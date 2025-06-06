<?php
class Area {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listarAreas() {
        $stmt = $this->pdo->query("SELECT * FROM areas WHERE status = 'ativo' ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarArea($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM areas WHERE id = ? AND status = 'ativo'");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criarArea($nome, $descricao) {
        $stmt = $this->pdo->prepare("INSERT INTO areas (nome, descricao) VALUES (?, ?)");
        return $stmt->execute([$nome, $descricao]);
    }

    public function atualizarArea($id, $nome, $descricao) {
        $stmt = $this->pdo->prepare("UPDATE areas SET nome = ?, descricao = ? WHERE id = ?");
        return $stmt->execute([$nome, $descricao, $id]);
    }

    public function desativarArea($id) {
        $stmt = $this->pdo->prepare("UPDATE areas SET status = 'inativo' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function listarDemandasPorArea($areaId) {
        $stmt = $this->pdo->prepare("
            SELECT d.*, u.nome as admin_nome 
            FROM demandas d 
            JOIN salaberga.usuarios u ON d.admin_id = u.id 
            WHERE d.area_id = ? 
            ORDER BY d.data_criacao DESC
        ");
        $stmt->execute([$areaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 