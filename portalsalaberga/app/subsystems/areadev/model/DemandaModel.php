<?php

class DemandaModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function criar($dados) {
        try {
            $sql = "INSERT INTO demandas (titulo, descricao, prioridade, admin_id, prazo) 
                    VALUES (:titulo, :descricao, :prioridade, :admin_id, :prazo)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':titulo', $dados['titulo']);
            $stmt->bindParam(':descricao', $dados['descricao']);
            $stmt->bindParam(':prioridade', $dados['prioridade']);
            $stmt->bindParam(':admin_id', $dados['admin_id']);
            $stmt->bindParam(':prazo', $dados['prazo']);
            
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erro ao criar demanda: " . $e->getMessage());
            return false;
        }
    }

    public function listarTodas() {
        try {
            $sql = "SELECT d.*, u.nome as admin_nome 
                    FROM demandas d 
                    JOIN usuarios u ON d.admin_id = u.id 
                    ORDER BY d.data_criacao DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar demandas: " . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT d.*, u.nome as admin_nome 
                    FROM demandas d 
                    JOIN usuarios u ON d.admin_id = u.id 
                    WHERE d.id = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar demanda: " . $e->getMessage());
            return false;
        }
    }

    public function atualizarStatus($id, $status) {
        try {
            $sql = "UPDATE demandas SET status = :status WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atualizar status da demanda: " . $e->getMessage());
            return false;
        }
    }

    public function atribuirUsuario($demanda_id, $usuario_id) {
        try {
            $sql = "INSERT INTO demanda_usuarios (demanda_id, usuario_id) 
                    VALUES (:demanda_id, :usuario_id)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':demanda_id', $demanda_id);
            $stmt->bindParam(':usuario_id', $usuario_id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atribuir usuário à demanda: " . $e->getMessage());
            return false;
        }
    }

    public function atualizarStatusUsuario($demanda_id, $usuario_id, $status) {
        try {
            $sql = "UPDATE demanda_usuarios 
                    SET status = :status, 
                        data_aceitacao = CASE 
                            WHEN :status = 'aceito' THEN NOW() 
                            ELSE data_aceitacao 
                        END,
                        data_conclusao = CASE 
                            WHEN :status = 'concluido' THEN NOW() 
                            ELSE data_conclusao 
                        END
                    WHERE demanda_id = :demanda_id AND usuario_id = :usuario_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':demanda_id', $demanda_id);
            $stmt->bindParam(':usuario_id', $usuario_id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atualizar status do usuário na demanda: " . $e->getMessage());
            return false;
        }
    }

    public function listarDemandasUsuario($usuario_id) {
        try {
            $sql = "SELECT d.*, du.status as status_usuario, du.data_aceitacao, du.data_conclusao
                    FROM demandas d 
                    JOIN demanda_usuarios du ON d.id = du.demanda_id
                    WHERE du.usuario_id = :usuario_id
                    ORDER BY d.data_criacao DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar demandas do usuário: " . $e->getMessage());
            return [];
        }
    }

    public function verificarPermissao($usuario_id, $demanda_id) {
        try {
            $sql = "SELECT COUNT(*) as tem_permissao 
                    FROM demanda_usuarios 
                    WHERE usuario_id = :usuario_id AND demanda_id = :demanda_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':demanda_id', $demanda_id);
            $stmt->execute();
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['tem_permissao'] > 0;
        } catch (PDOException $e) {
            error_log("Erro ao verificar permissão: " . $e->getMessage());
            return false;
        }
    }

    public function getEstatisticas() {
        try {
            $sql = "SELECT 
                    COUNT(*) as total_demandas,
                    SUM(CASE WHEN status = 'pendente' THEN 1 ELSE 0 END) as demandas_pendentes,
                    SUM(CASE WHEN status = 'em_andamento' THEN 1 ELSE 0 END) as demandas_em_andamento,
                    SUM(CASE WHEN status = 'concluida' THEN 1 ELSE 0 END) as demandas_concluidas,
                    COUNT(DISTINCT admin_id) as total_admins,
                    COUNT(DISTINCT usuario_id) as total_usuarios
                    FROM demandas d
                    LEFT JOIN demanda_usuarios du ON d.id = du.demanda_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar estatísticas: " . $e->getMessage());
            return false;
        }
    }
} 