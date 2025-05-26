<?php
class Demanda {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listarDemandas() {
        $stmt = $this->pdo->prepare("
            SELECT d.*, u.nome as admin_nome
            FROM demandas d 
            LEFT JOIN usuarios u ON d.admin_id = u.id 
            ORDER BY d.data_criacao DESC
        ");
        $stmt->execute();
        $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Para cada demanda, buscar os usuários atribuídos
        foreach ($demandas as &$demanda) {
            $stmtUsuarios = $this->pdo->prepare("
                SELECT u.id, u.nome, du.status, du.data_conclusao 
                FROM usuarios u
                INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                WHERE du.demanda_id = ?
            ");
            $stmtUsuarios->execute([$demanda['id']]);
            $demanda['usuarios_atribuidos'] = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
        }

        return $demandas;
    }

    public function listarDemandasPorUsuario($usuario_id) {
        $stmt = $this->pdo->prepare("
            SELECT d.*, u.nome as admin_nome,
                   du.status as status_usuario,
                   du.data_conclusao as data_conclusao_usuario
            FROM demandas d 
            LEFT JOIN usuarios u ON d.admin_id = u.id 
            INNER JOIN demanda_usuarios du ON d.id = du.demanda_id
            WHERE du.usuario_id = ? OR d.admin_id = ?
            ORDER BY d.data_criacao DESC
        ");
        $stmt->execute([$usuario_id, $usuario_id]);
        $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Para cada demanda, buscar os usuários atribuídos
        foreach ($demandas as &$demanda) {
            $stmtUsuarios = $this->pdo->prepare("
                SELECT u.id, u.nome, du.status, du.data_conclusao 
                FROM usuarios u
                INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                WHERE du.demanda_id = ?
            ");
            $stmtUsuarios->execute([$demanda['id']]);
            $demanda['usuarios_atribuidos'] = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
        }

        return $demandas;
    }

    public function buscarDemanda($id) {
        $stmt = $this->pdo->prepare("
            SELECT d.*, u.nome as admin_nome 
            FROM demandas d 
            LEFT JOIN usuarios u ON d.admin_id = u.id 
            WHERE d.id = ?
        ");
        $stmt->execute([$id]);
        $demanda = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($demanda) {
            // Buscar usuários atribuídos
            $stmtUsuarios = $this->pdo->prepare("
                SELECT u.id, u.nome 
                FROM usuarios u
                INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                WHERE du.demanda_id = ?
            ");
            $stmtUsuarios->execute([$id]);
            $demanda['usuarios_atribuidos'] = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
        }

        return $demanda;
    }

    public function criarDemanda($titulo, $descricao, $prioridade, $admin_id, $usuarios_ids = [], $prazo = null) {
        try {
            $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare("
                INSERT INTO demandas (titulo, descricao, prioridade, admin_id, status, prazo)
                VALUES (?, ?, ?, ?, 'pendente', ?)
            ");
            $stmt->execute([$titulo, $descricao, $prioridade, $admin_id, $prazo]);

            $demanda_id = $this->pdo->lastInsertId();

            if (!empty($usuarios_ids)) {
                $stmtAtribuir = $this->pdo->prepare("
                    INSERT INTO demanda_usuarios (demanda_id, usuario_id)
                    VALUES (?, ?)
                ");
                foreach ($usuarios_ids as $usuario_id) {
                    $stmtAtribuir->execute([$demanda_id, $usuario_id]);
                }
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            // Log do erro ou tratamento
            return false;
        }
    }

    public function atualizarDemanda($id, $titulo, $descricao, $prioridade, $status, $usuarios_ids = [], $prazo = null) {
        try {
            $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare("
            UPDATE demandas 
                SET titulo = ?, descricao = ?, prioridade = ?, status = ?, prazo = ?
            WHERE id = ?
        ");
            $stmt->execute([$titulo, $descricao, $prioridade, $status, $prazo, $id]);

            // Remover atribuições existentes e adicionar as novas
            $stmtRemoverAtribuicao = $this->pdo->prepare("DELETE FROM demanda_usuarios WHERE demanda_id = ?");
            $stmtRemoverAtribuicao->execute([$id]);

            if (!empty($usuarios_ids)) {
                $stmtAtribuir = $this->pdo->prepare("
                    INSERT INTO demanda_usuarios (demanda_id, usuario_id)
                    VALUES (?, ?)
                ");
                foreach ($usuarios_ids as $usuario_id) {
                    $stmtAtribuir->execute([$id, $usuario_id]);
                }
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            // Log do erro ou tratamento
            return false;
        }
    }

    public function excluirDemanda($id) {
        // A exclusão na tabela demanda_usuarios será em cascata devido à FOREIGN KEY
        $stmt = $this->pdo->prepare("DELETE FROM demandas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function marcarConcluida($id, $usuario_id) {
        try {
            $this->pdo->beginTransaction();
            
            // Atualiza o status do usuário específico
            $stmt = $this->pdo->prepare("
                UPDATE demanda_usuarios 
                SET status = 'concluido', data_conclusao = CURRENT_TIMESTAMP 
                WHERE demanda_id = ? AND usuario_id = ?
            ");
            $stmt->execute([$id, $usuario_id]);

            // Verifica se todos os usuários concluíram
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as total,
                       SUM(CASE WHEN status = 'concluido' THEN 1 ELSE 0 END) as concluidos
                FROM demanda_usuarios 
                WHERE demanda_id = ?
            ");
            $stmt->execute([$id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Se todos os usuários concluíram, marca a demanda como concluída
            if ($resultado['total'] > 0 && $resultado['total'] == $resultado['concluidos']) {
                $stmt = $this->pdo->prepare("
                    UPDATE demandas 
                    SET status = 'concluida', data_conclusao = CURRENT_TIMESTAMP 
                    WHERE id = ?
                ");
                $stmt->execute([$id]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function marcarEmAndamento($id, $usuario_id) {
        try {
            $this->pdo->beginTransaction();
            
            // Atualiza o status do usuário específico
            $stmt = $this->pdo->prepare("
                UPDATE demanda_usuarios 
                SET status = 'em_andamento' 
                WHERE demanda_id = ? AND usuario_id = ?
            ");
            $stmt->execute([$id, $usuario_id]);

            // Atualiza o status geral da demanda
            $stmt = $this->pdo->prepare("
                UPDATE demandas 
                SET status = 'em_andamento' 
                WHERE id = ?
            ");
            $stmt->execute([$id]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    // Verificar permissão para usuário (agora verifica se o usuário está atribuído ou é admin)
    public function verificarPermissaoUsuario($id, $usuario_id) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM demanda_usuarios du
            INNER JOIN demandas d ON du.demanda_id = d.id
            WHERE du.demanda_id = ? AND (du.usuario_id = ? OR d.admin_id = ?)
        ");
        $stmt->execute([$id, $usuario_id, $usuario_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function verificarStatusUsuario($demanda_id, $usuario_id) {
        $stmt = $this->pdo->prepare("
            SELECT status 
            FROM demanda_usuarios 
            WHERE demanda_id = ? AND usuario_id = ?
        ");
        $stmt->execute([$demanda_id, $usuario_id]);
        return $stmt->fetchColumn();
    }

    // Este método pode não ser mais necessário ou precisará ser adaptado dependendo do uso
    // public function verificarPermissao($id, $usuario_id, $tipo) {
    //     $stmt = $this->pdo->prepare("
    //         SELECT * FROM demandas 
    //         WHERE id = ? AND (usuario_id = ? OR admin_id = ? OR ? = 'admin')
    //     ");
    //     $stmt->execute([$id, $usuario_id, $usuario_id, $tipo]);
    //     return $stmt->fetch() !== false;
    // }
} 