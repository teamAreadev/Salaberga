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

    public function listarUsuarios($tipo = null) {
        if ($tipo) {
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE tipo = ? ORDER BY nome");
            $stmt->execute([$tipo]);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM usuarios ORDER BY nome");
        }
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

    public function listarAdminsGerais() {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE tipo = 'adm_geral' ORDER BY nome");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarAdminsArea() {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE tipo LIKE 'adm_area_%' ORDER BY nome");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarUsuariosComuns() {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE tipo = 'usuario' ORDER BY nome");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarUsuariosPorArea($area_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE area_id = ? ORDER BY nome");
        $stmt->execute([$area_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca todos os usuários e suas permissões para um sistema específico
    public function listarUsuariosComPermissoes($sistema_id) {
        $sql = "
            SELECT u.*, p.descricao as permissao
            FROM usuarios u
            INNER JOIN usu_sist us ON u.id = us.usuario_id
            INNER JOIN sist_perm sp ON us.sist_perm_id = sp.id
            INNER JOIN permissoes p ON sp.permissao_id = p.id
            WHERE sp.sistema_id = ?
            ORDER BY u.nome
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$sistema_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Utilitários para filtrar tipos de usuário a partir do resultado de listarUsuariosComPermissoes
    public static function filtrarAdminsGerais($usuarios) {
        return array_filter($usuarios, function($u) {
            return strpos($u['permissao'], 'adm_geral') === 0;
        });
    }
    public static function filtrarAdminsArea($usuarios) {
        return array_filter($usuarios, function($u) {
            return strpos($u['permissao'], 'adm_area_') === 0;
        });
    }
    public static function filtrarUsuariosComuns($usuarios) {
        return array_filter($usuarios, function($u) {
            return strpos($u['permissao'], 'usuario') === 0;
        });
    }
} 