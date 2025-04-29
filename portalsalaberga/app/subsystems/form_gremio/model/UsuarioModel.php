<?php
require_once '../config/database.php';

class UsuarioModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Verifica as credenciais do usuário (email e nome)
     * @param string $email Email do usuário
     * @param string $nome Nome completo do usuário
     * @return array Resultado da verificação
     */
    public function verificarUsuario($email, $nome) {
        try {
            // Busca o aluno pelo email e nome
            $query = "SELECT * FROM alunos WHERE email = :email AND nome = :nome";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();
            
            $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$aluno) {
                return [
                    'success' => false,
                    'message' => 'Email ou nome não encontrados. Verifique as informações e tente novamente.'
                ];
            }
            
            // Se encontrou o aluno, busca suas inscrições
            $queryInscricoes = "SELECT * FROM inscricoes WHERE aluno_id = :aluno_id";
            $stmtInscricoes = $this->db->prepare($queryInscricoes);
            $stmtInscricoes->bindParam(':aluno_id', $aluno['id']);
            $stmtInscricoes->execute();
            
            $inscricoes = $stmtInscricoes->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'success' => true,
                'message' => 'Login realizado com sucesso',
                'aluno' => $aluno,
                'inscricoes' => $inscricoes
            ];
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro ao verificar usuário: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtém todos os dados de um aluno e suas inscrições
     * @param int $alunoId ID do aluno
     * @return array Dados do aluno e suas inscrições
     */
    public function obterDadosUsuario($alunoId) {
        try {
            // Busca o aluno pelo ID
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
            
            // Busca as inscrições do aluno
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
                'message' => 'Erro ao obter dados do usuário: ' . $e->getMessage()
            ];
        }
    }
}
?> 