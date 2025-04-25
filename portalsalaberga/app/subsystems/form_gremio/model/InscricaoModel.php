<?php
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
}
?>