<?php
require_once '../config/database.php';

class InscricaoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function cadastrarInscricao($dados) {
        try {
            // Inicia transação
            $this->db->beginTransaction();

            // Insere dados do aluno
            $queryAluno = "INSERT INTO alunos (nome, ano, turma, email, telefone) 
                          VALUES (:nome, :ano, :turma, :email, :telefone)";
            $stmtAluno = $this->db->prepare($queryAluno);
            
            $stmtAluno->bindParam(':nome', $dados['nome']);
            $stmtAluno->bindParam(':ano', $dados['ano']);
            $stmtAluno->bindParam(':turma', $dados['turma']);
            $stmtAluno->bindParam(':email', $dados['email']);
            $stmtAluno->bindParam(':telefone', $dados['telefone']);
            
            $stmtAluno->execute();
            $alunoId = $this->db->lastInsertId();

            // Insere modalidades selecionadas
            $modalidades = json_decode($dados['modalidades'], true);
            
            foreach ($modalidades as $modalidade) {
                $queryInscricao = "INSERT INTO inscricoes (aluno_id, modalidade, categoria, nome_equipe) 
                                  VALUES (:aluno_id, :modalidade, :categoria, :nome_equipe)";
                $stmtInscricao = $this->db->prepare($queryInscricao);
                
                $categoria = isset($dados['genero-'.$modalidade]) ? $dados['genero-'.$modalidade] : 'misto';
                $nomeEquipe = isset($dados['equipe-nome-'.$modalidade]) ? $dados['equipe-nome-'.$modalidade] : null;
                
                $stmtInscricao->bindParam(':aluno_id', $alunoId);
                $stmtInscricao->bindParam(':modalidade', $modalidade);
                $stmtInscricao->bindParam(':categoria', $categoria);
                $stmtInscricao->bindParam(':nome_equipe', $nomeEquipe);
                
                $stmtInscricao->execute();
            }

            // Commit da transação
            $this->db->commit();
            
            return [
                'success' => true,
                'message' => 'Inscrição realizada com sucesso!',
                'aluno_id' => $alunoId
            ];
            
        } catch(PDOException $e) {
            // Rollback em caso de erro
            $this->db->rollBack();
            return [
                'success' => false,
                'message' => 'Erro ao realizar inscrição: ' . $e->getMessage()
            ];
        }
    }

    public function obterTodasInscricoes() {
        try {
            $query = "SELECT a.id, a.nome, a.ano, a.turma, a.email, a.telefone, a.data_inscricao,
                     COUNT(i.id) as total_modalidades,
                     SUM(CASE WHEN i.status = 'aprovado' THEN 1 ELSE 0 END) as aprovadas,
                     SUM(CASE WHEN i.status = 'pendente' THEN 1 ELSE 0 END) as pendentes,
                     SUM(CASE WHEN i.status = 'reprovado' THEN 1 ELSE 0 END) as reprovadas
                     FROM alunos a
                     JOIN inscricoes i ON a.id = i.aluno_id
                     GROUP BY a.id
                     ORDER BY a.data_inscricao DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }

    public function obterInscricaoPorId($alunoId) {
        try {
            // Obter dados do aluno
            $queryAluno = "SELECT * FROM alunos WHERE id = :id";
            $stmtAluno = $this->db->prepare($queryAluno);
            $stmtAluno->bindParam(':id', $alunoId);
            $stmtAluno->execute();
            $aluno = $stmtAluno->fetch(PDO::FETCH_ASSOC);
            
            if (!$aluno) {
                return [
                    'success' => false,
                    'message' => 'Aluno não encontrado'
                ];
            }
            
            // Obter modalidades inscritas
            $queryInscricoes = "SELECT * FROM inscricoes WHERE aluno_id = :aluno_id";
            $stmtInscricoes = $this->db->prepare($queryInscricoes);
            $stmtInscricoes->bindParam(':aluno_id', $alunoId);
            $stmtInscricoes->execute();
            $inscricoes = $stmtInscricoes->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'success' => true,
                'aluno' => $aluno,
                'inscricoes' => $inscricoes
            ];
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro ao obter inscrição: ' . $e->getMessage()
            ];
        }
    }

    public function atualizarStatusInscricao($inscricaoId, $status) {
        try {
            $query = "UPDATE inscricoes SET status = :status, data_aprovacao = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $inscricaoId);
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Status atualizado com sucesso'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao atualizar status'
                ];
            }
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro: ' . $e->getMessage()
            ];
        }
    }

    public function verificarStatusInscricao($alunoId) {
        try {
            $query = "SELECT a.id, a.nome, a.ano, a.turma, 
                     i.modalidade, i.categoria, i.nome_equipe, i.status
                     FROM alunos a
                     JOIN inscricoes i ON a.id = i.aluno_id
                     WHERE a.id = :aluno_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':aluno_id', $alunoId);
            $stmt->execute();
            
            $inscricoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($inscricoes) > 0) {
                return [
                    'success' => true,
                    'inscricoes' => $inscricoes
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Nenhuma inscrição encontrada'
                ];
            }
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro: ' . $e->getMessage()
            ];
        }
    }
}
?>