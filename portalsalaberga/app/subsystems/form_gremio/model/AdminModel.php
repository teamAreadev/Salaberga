<?php
require_once __DIR__ . '/../config/database.php';

class AdminModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Verifica as credenciais do admin
     */
    public function verificarAdmin($usuario, $senha) {
        try {
            // Verificação especial para admin padrão
            if ($usuario === 'admin' && $senha === 'admin123') {
                error_log("Login admin padrão: SUCESSO");
                
                // Busca o admin pelo usuário para obter os dados
                $query = "SELECT id, nome, usuario FROM admins WHERE usuario = :usuario LIMIT 1";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':usuario', $usuario);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                    return [
                        'success' => true,
                        'message' => 'Login realizado com sucesso',
                        'admin' => $admin
                    ];
                }
            }
            
            // Busca o admin pelo usuário
            $query = "SELECT id, nome, usuario, senha FROM admins WHERE usuario = :usuario LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Debug: Verificar a senha armazenada e a fornecida
                error_log("Senha no banco: " . $admin['senha']);
                error_log("Senha fornecida: " . $senha);
                error_log("Senha em MD5: " . md5($senha));
                
                // Verificar se a senha está em formato bcrypt ou md5
                $senhaCorreta = false;
                
                // Verificar com password_verify (para bcrypt)
                if (password_verify($senha, $admin['senha'])) {
                    error_log("Senha verificada com password_verify: SUCESSO");
                    $senhaCorreta = true;
                } 
                // Verificar com md5 (formato antigo)
                else if (md5($senha) === $admin['senha']) {
                    error_log("Senha verificada com md5: SUCESSO");
                    $senhaCorreta = true;
                    
                    // Atualizar para bcrypt automaticamente
                    try {
                        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
                        $queryUpdate = "UPDATE admins SET senha = :senha WHERE id = :id";
                        $stmtUpdate = $this->db->prepare($queryUpdate);
                        $stmtUpdate->bindParam(':senha', $senhaHash);
                        $stmtUpdate->bindParam(':id', $admin['id']);
                        $stmtUpdate->execute();
                        error_log("Senha atualizada para bcrypt");
                    } catch (PDOException $e) {
                        error_log("Erro ao atualizar senha: " . $e->getMessage());
                    }
                }
                
                if ($senhaCorreta) {
                    unset($admin['senha']); // Remove a senha do array
                    error_log("Login bem-sucedido para: " . $usuario);
                    return [
                        'success' => true,
                        'message' => 'Login realizado com sucesso',
                        'admin' => $admin
                    ];
                }
            }
            
            error_log("Login falhou para: " . $usuario);
            return [
                'success' => false,
                'message' => 'Usuário ou senha inválidos'
            ];
            
        } catch (PDOException $e) {
            error_log("Erro no login admin: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro ao verificar credenciais: ' . $e->getMessage()
            ];
        }
    }

    public function alterarSenha($adminId, $senhaAtual, $novaSenha) {
        try {
            // Verificar senha atual
            $queryVerificar = "SELECT senha FROM admin_usuarios WHERE id = :id";
            $stmtVerificar = $this->db->prepare($queryVerificar);
            $stmtVerificar->bindParam(':id', $adminId);
            $stmtVerificar->execute();
            
            $admin = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
            
            if (!$admin || md5($senhaAtual) !== $admin['senha']) {
                return [
                    'success' => false,
                    'message' => 'Senha atual incorreta'
                ];
            }
            
            // Atualizar senha
            $novaSenhaHash = md5($novaSenha);
            
            $queryAtualizar = "UPDATE admin_usuarios SET senha = :senha WHERE id = :id";
            $stmtAtualizar = $this->db->prepare($queryAtualizar);
            $stmtAtualizar->bindParam(':senha', $novaSenhaHash);
            $stmtAtualizar->bindParam(':id', $adminId);
            
            if ($stmtAtualizar->execute()) {
                return [
                    'success' => true,
                    'message' => 'Senha alterada com sucesso'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao alterar senha'
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