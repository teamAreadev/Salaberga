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
        // Verifica se o e-mail já existe
        $stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return "email_ja_cadastrado";
        }

        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
        $this->pdo->beginTransaction();
        try {
            // Inserir na tabela usuarios
            $stmt = $this->pdo->prepare("
                INSERT INTO usuarios (nome, email, senha)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$nome, $email, $senhaHash]);
            $usuario_id = $this->pdo->lastInsertId();

            // Inserir na tabela usu_sist
            $stmt = $this->pdo->prepare("
                INSERT INTO usu_sist (usuario_id, sist_perm_id)
                VALUES (?, ?)
            ");
            $stmt->execute([$usuario_id, $tipo]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return $e->getMessage();
        }
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
        try {
            $sql = "SELECT DISTINCT u.id, u.nome, u.email, p.descricao as permissao
                    FROM usuarios u
                    INNER JOIN usu_sist us ON u.id = us.usuario_id
                    INNER JOIN sist_perm sp ON us.sist_perm_id = sp.id
                    INNER JOIN permissoes p ON sp.permissao_id = p.id
                    WHERE sp.sistema_id = ?
                    AND (p.descricao LIKE 'usuario_area_%' 
                         OR p.descricao LIKE 'adm_area_%' 
                         OR p.descricao = 'adm_geral')";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$sistema_id]);
            
            error_log("SQL Query: " . $sql);
            $sql = "SELECT DISTINCT u.*, p.descricao as permissao 
                    FROM usuarios u 
                    INNER JOIN usu_sist us ON u.id = us.usuario_id 
                    INNER JOIN sist_perm sp ON us.sist_perm_id = sp.id 
                    INNER JOIN permissoes p ON sp.permissao_id = p.id 
                    WHERE sp.sistema_id = ? 
                    AND (p.descricao LIKE 'usuario_area_%' OR p.descricao LIKE 'adm_area_%' OR p.descricao = 'adm_geral')
                    ORDER BY u.nome";
            
            error_log("SQL Query: " . $sql);
            error_log("ID Sistema: " . $sistema_id);
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$sistema_id]);
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            error_log("Total de usuários encontrados: " . count($usuarios));
            return $usuarios;
        } catch (Exception $e) {
            error_log("Erro ao listar usuários com permissões: " . $e->getMessage());
            return [];
        }
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

    // Buscar todas as permissões disponíveis na tabela sist_perm
    public function listarPermissoes() {
        $stmt = $this->pdo->query("
            SELECT sp.id, p.descricao
            FROM sist_perm sp
            INNER JOIN permissoes p ON sp.permissao_id = p.id
            ORDER BY p.descricao
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 