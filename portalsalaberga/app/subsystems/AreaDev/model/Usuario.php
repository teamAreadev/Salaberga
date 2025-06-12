<?php
class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function verificarLogin($email, $senha) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    public function listarUsuarios() {
        $stmt = $this->pdo->query("SELECT * FROM usuarios ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criarUsuario($nome, $email, $senha, $tipo) {
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("
            INSERT INTO usuarios (nome, email, senha, tipo)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$nome, $email, $senhaHash, $tipo]);
    }
} 