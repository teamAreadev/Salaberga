<?php
class Area {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listarAreas() {
        $stmt = $this->pdo->query("SELECT * FROM areas ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 