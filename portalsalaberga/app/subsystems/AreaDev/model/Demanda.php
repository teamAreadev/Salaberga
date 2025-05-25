<?php
class Demanda {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listarDemandas() {
        $stmt = $this->pdo->prepare("
            SELECT d.*, u.nome as admin_nome, u2.nome as usuario_nome 
            FROM demandas d 
            LEFT JOIN usuarios u ON d.admin_id = u.id 
            LEFT JOIN usuarios u2 ON d.usuario_id = u2.id 
            ORDER BY d.data_criacao DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarDemandasPorUsuario($usuario_id) {
        $stmt = $this->pdo->prepare("
            SELECT d.*, u.nome as admin_nome 
            FROM demandas d 
            LEFT JOIN usuarios u ON d.admin_id = u.id 
            WHERE d.usuario_id = ? OR d.admin_id = ?
            ORDER BY d.data_criacao DESC
        ");
        $stmt->execute([$usuario_id, $usuario_id]);
        return $stmt->fetchAll();
    }

    public function buscarDemanda($id) {
        $stmt = $this->pdo->prepare("
            SELECT d.*, u.nome as admin_nome, u2.nome as usuario_nome 
            FROM demandas d 
            LEFT JOIN usuarios u ON d.admin_id = u.id 
            LEFT JOIN usuarios u2 ON d.usuario_id = u2.id 
            WHERE d.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criarDemanda($titulo, $descricao, $prioridade, $admin_id, $usuario_id = null) {
        $stmt = $this->pdo->prepare("
            INSERT INTO demandas (titulo, descricao, prioridade, admin_id, usuario_id, status)
            VALUES (?, ?, ?, ?, ?, 'pendente')
        ");
        // Converter string vazia para NULL para consistência
        $usuario_id_salvar = ($usuario_id === '' || $usuario_id === 0) ? null : $usuario_id;
        
        return $stmt->execute([$titulo, $descricao, $prioridade, $admin_id, $usuario_id_salvar]);
    }

    public function atualizarDemanda($id, $titulo, $descricao, $prioridade, $status, $usuario_id = null) {
        $stmt = $this->pdo->prepare("
            UPDATE demandas 
            SET titulo = ?, descricao = ?, prioridade = ?, status = ?, usuario_id = ?
            WHERE id = ?
        ");
        // Converter string vazia ou 0 para NULL para consistência
        $usuario_id_salvar = ($usuario_id === '' || $usuario_id === 0) ? null : $usuario_id;
        return $stmt->execute([$titulo, $descricao, $prioridade, $status, $usuario_id_salvar, $id]);
    }

    public function excluirDemanda($id) {
        $stmt = $this->pdo->prepare("DELETE FROM demandas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function marcarConcluida($id) {
        $stmt = $this->pdo->prepare("
            UPDATE demandas 
            SET status = 'concluida', data_conclusao = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    public function marcarEmAndamento($id) {
        $stmt = $this->pdo->prepare("UPDATE demandas SET status = 'em_andamento' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function verificarPermissao($id, $usuario_id, $tipo) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM demandas 
            WHERE id = ? AND (usuario_id = ? OR admin_id = ? OR ? = 'admin')
        ");
        $stmt->execute([$id, $usuario_id, $usuario_id, $tipo]);
        return $stmt->fetch() !== false;
    }

    public function verificarPermissaoUsuario($id, $usuario_id) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM demandas 
            WHERE id = ? AND usuario_id = ?
        ");
        $stmt->execute([$id, $usuario_id]);
        return $stmt->fetch() !== false;
    }
} 