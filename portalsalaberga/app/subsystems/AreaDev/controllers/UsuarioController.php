<?php
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioController {
    private $usuario;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->usuario = new Usuario($pdo);
    }

    public function login($email, $senha) {
        $usuario = $this->usuario->login($email, $senha);
        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo'];
            return true;
        }
        return false;
    }

    public function listarUsuarios() {
        return $this->usuario->listarUsuarios();
    }

    public function criarUsuario($nome, $email, $senha, $tipo) {
        return $this->usuario->criarUsuario($nome, $email, $senha, $tipo);
    }
} 