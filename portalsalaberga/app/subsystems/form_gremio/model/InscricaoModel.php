<?php
require_once __DIR__ . '/../config/database.php';

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

    /**
     * Cadastra uma inscrição individual para um aluno já cadastrado
     * @param array $dados Dados da inscrição
     * @return array Resultado da operação
     */
    public function cadastrarInscricaoIndividual($dados) {
        try {
            // Verificar se o aluno já tem inscrição para esta modalidade
            $queryVerificar = "SELECT * FROM inscricoes 
                             WHERE aluno_id = :aluno_id AND modalidade = :modalidade";
            $stmtVerificar = $this->db->prepare($queryVerificar);
            
            $stmtVerificar->bindParam(':aluno_id', $dados['aluno_id']);
            $stmtVerificar->bindParam(':modalidade', $dados['modalidade']);
            $stmtVerificar->execute();
            
            if ($stmtVerificar->rowCount() > 0) {
                return [
                    'success' => false,
                    'message' => 'Você já possui uma inscrição para esta modalidade'
                ];
            }
            
            // Inserir nova inscrição
            $queryInscricao = "INSERT INTO inscricoes (aluno_id, modalidade, categoria, status) 
                             VALUES (:aluno_id, :modalidade, :categoria, 'pendente')";
            $stmtInscricao = $this->db->prepare($queryInscricao);
            
            $stmtInscricao->bindParam(':aluno_id', $dados['aluno_id']);
            $stmtInscricao->bindParam(':modalidade', $dados['modalidade']);
            $stmtInscricao->bindParam(':categoria', $dados['categoria']);
            
            $stmtInscricao->execute();
            $inscricaoId = $this->db->lastInsertId();
            
            return [
                'success' => true,
                'message' => 'Inscrição individual realizada com sucesso!',
                'inscricao_id' => $inscricaoId
            ];
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro ao realizar inscrição individual: ' . $e->getMessage()
            ];
        }
    }

    public function obterTodasInscricoes() {
        try {
            $query = "SELECT 
                     a.id, a.nome, a.ano, a.turma, a.email, a.telefone, a.data_inscricao,
                     i.id as inscricao_id,
                     i.modalidade,
                     i.categoria,
                     i.nome_equipe,
                     i.status,
                     CASE 
                         WHEN i.nome_equipe IS NOT NULL THEN 'coletiva'
                         ELSE 'individual'
                     END as tipo_inscricao,
                     CASE 
                         WHEN e.lider_id = a.id THEN 1
                         ELSE 0
                     END as is_lider
                     FROM alunos a
                     JOIN inscricoes i ON a.id = i.aluno_id
                     LEFT JOIN equipes e ON i.nome_equipe = e.nome AND i.modalidade = e.modalidade
                     ORDER BY a.data_inscricao DESC, i.modalidade ASC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            return [
                'success' => true,
                'inscricoes' => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ];
        } catch(PDOException $e) {
            error_log("Erro ao obter inscrições: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro ao obter inscrições',
                'inscricoes' => []
            ];
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
            // Primeiro, verificar se a inscrição é de um líder de equipe
            $queryVerificar = "SELECT i.*, e.lider_id 
                             FROM inscricoes i 
                             LEFT JOIN equipes e ON i.equipe_id = e.id 
                             WHERE i.id = :id";
            $stmtVerificar = $this->db->prepare($queryVerificar);
            $stmtVerificar->bindParam(':id', $inscricaoId);
            $stmtVerificar->execute();
            
            $inscricao = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
            
            if (!$inscricao) {
                return [
                    'success' => false,
                    'message' => 'Inscrição não encontrada'
                ];
            }
            
            // Se for uma inscrição de equipe e o aluno for o líder
            if ($inscricao['equipe_id'] && $inscricao['aluno_id'] == $inscricao['lider_id']) {
                // Atualizar status de todos os membros da equipe
                $query = "UPDATE inscricoes SET status = :status, data_aprovacao = NOW() 
                         WHERE equipe_id = :equipe_id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':equipe_id', $inscricao['equipe_id']);
                
                if ($stmt->execute()) {
                    return [
                        'success' => true,
                        'message' => 'Status da equipe atualizado com sucesso',
                        'affected_rows' => $stmt->rowCount()
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Erro ao atualizar status da equipe'
                    ];
                }
            } else {
                // Atualizar apenas a inscrição individual
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
    
    /**
     * Cancela uma inscrição
     * @param int $inscricaoId ID da inscrição
     * @return array Resultado da operação
     */
    public function cancelarInscricao($inscricaoId) {
        try {
            // Verificar se a inscrição existe
            $queryVerificar = "SELECT * FROM inscricoes WHERE id = :id";
            $stmtVerificar = $this->db->prepare($queryVerificar);
            $stmtVerificar->bindParam(':id', $inscricaoId);
            $stmtVerificar->execute();
            
            if ($stmtVerificar->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'Inscrição não encontrada'
                ];
            }
            
            $inscricao = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
            
            // Não é possível cancelar inscrições já aprovadas
            if ($inscricao['status'] === 'aprovado') {
                return [
                    'success' => false,
                    'message' => 'Não é possível cancelar uma inscrição já aprovada'
                ];
            }
            
            // Se for uma inscrição de equipe, verificar se o aluno é membro
            if ($inscricao['equipe_id']) {
                $queryRemoverMembro = "DELETE FROM equipe_membros 
                                     WHERE equipe_id = :equipe_id AND aluno_id = :aluno_id";
                $stmtRemoverMembro = $this->db->prepare($queryRemoverMembro);
                $stmtRemoverMembro->bindParam(':equipe_id', $inscricao['equipe_id']);
                $stmtRemoverMembro->bindParam(':aluno_id', $inscricao['aluno_id']);
                $stmtRemoverMembro->execute();
            }
            
            // Excluir inscrição
            $queryExcluir = "DELETE FROM inscricoes WHERE id = :id";
            $stmtExcluir = $this->db->prepare($queryExcluir);
            $stmtExcluir->bindParam(':id', $inscricaoId);
            
            if ($stmtExcluir->execute()) {
                return [
                    'success' => true,
                    'message' => 'Inscrição cancelada com sucesso'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao cancelar inscrição'
                ];
            }
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualiza o status de todas as inscrições de uma equipe
     * @param int $equipeId ID da equipe
     * @param string $status Novo status
     * @return array Resultado da operação
     */
    public function atualizarStatusEquipeCompleta($equipeId, $status) {
        try {
            $query = "UPDATE inscricoes SET status = :status WHERE equipe_id = :equipe_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':equipe_id', $equipeId);
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Status da equipe atualizado com sucesso',
                    'affected_rows' => $stmt->rowCount()
                ];
            } else {
                $error = $stmt->errorInfo();
                return [
                    'success' => false,
                    'message' => 'Erro ao atualizar status da equipe',
                    'error' => $error[2]
                ];
            }
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro ao atualizar status: ' . $e->getMessage()
            ];
        }
    }
}
?>