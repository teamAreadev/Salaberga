<?php
require_once '../config/database.php';

class AdminModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function verificarCredenciais($usuario, $senha) {
        try {
            $query = "SELECT * FROM admin_usuarios WHERE usuario = :usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($admin && $admin['senha'] === md5($senha)) {
                return [
                    'success' => true,
                    'message' => 'Login realizado com sucesso',
                    'admin_id' => $admin['id'],
                    'admin_nome' => $admin['nome']
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Usuário ou senha incorretos'
                ];
            }
        } catch(PDOException $e) {
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