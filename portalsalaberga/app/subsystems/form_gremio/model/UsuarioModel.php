<?php
require_once __DIR__ . '/../config/database.php';

class UsuarioModel {
    private $db;

    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->getConnection();
            
            if (!$this->db) {
                throw new Exception("Não foi possível estabelecer conexão com o banco de dados");
            }
        } catch (Exception $e) {
            error_log("Erro na inicialização do UsuarioModel: " . $e->getMessage());
            throw $e;
        }
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

    /**
     * Cadastra um novo usuário
     * @param array $dados Dados do usuário
     * @return array Resultado do cadastro
     */
    public function cadastrarUsuario($dados) {
        try {
            // Verificar se o email já está cadastrado
            $queryVerificar = "SELECT COUNT(*) as total FROM alunos WHERE email = :email";
            $stmtVerificar = $this->db->prepare($queryVerificar);
            $stmtVerificar->bindParam(':email', $dados['email']);
            $stmtVerificar->execute();
            
            $resultado = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
            
            if ($resultado['total'] > 0) {
                return [
                    'success' => false,
                    'message' => 'Este email já está cadastrado'
                ];
            }
            
            error_log("Preparando para inserir novo aluno: " . print_r($dados, true));
            
            // Inserir novo aluno - nota que a tabela não tem o campo data_cadastro,
            // mas tem data_inscricao que é auto-preenchido pelo banco
            $query = "INSERT INTO alunos (nome, email, telefone, ano, turma) 
                     VALUES (:nome, :email, :telefone, :ano, :turma)";
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(':email', $dados['email']);
            $stmt->bindParam(':telefone', $dados['telefone']);
            $stmt->bindParam(':ano', $dados['ano']);
            $stmt->bindParam(':turma', $dados['turma']);
            
            if ($stmt->execute()) {
                error_log("Inserção realizada com sucesso. ID: " . $this->db->lastInsertId());
                return [
                    'success' => true,
                    'message' => 'Usuário cadastrado com sucesso',
                    'aluno_id' => $this->db->lastInsertId()
                ];
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("Falha na execução do SQL: " . print_r($errorInfo, true));
                return [
                    'success' => false,
                    'message' => 'Erro ao cadastrar usuário: ' . $errorInfo[2]
                ];
            }
            
        } catch(PDOException $e) {
            $errorCode = $e->getCode();
            error_log("PDOException no cadastro: [Código: {$errorCode}] " . $e->getMessage());
            
            // Tratamento específico para erros comuns
            if ($errorCode == '23000' || $errorCode == 1062) {
                // Violação de chave única 
                return [
                    'success' => false,
                    'message' => 'Este email já está cadastrado no sistema'
                ];
            } else if ($errorCode == '42S02' || $errorCode == 1146) {
                // Tabela não existe
                return [
                    'success' => false,
                    'message' => 'Erro no banco de dados: Tabela alunos não encontrada'
                ];
            } else if ($errorCode == '42S22' || $errorCode == 1054) {
                // Coluna desconhecida
                return [
                    'success' => false,
                    'message' => 'Erro no banco de dados: Campo não encontrado na tabela'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao cadastrar usuário: ' . $e->getMessage()
                ];
            }
        } catch(Exception $e) {
            error_log("Exception genérica no cadastro: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro ao processar cadastro: ' . $e->getMessage()
            ];
        }
    }
}
?> 