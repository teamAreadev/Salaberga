<?php
require_once __DIR__ . '/database.php';

try {
    // Conexão com o banco principal (salaberga)
    $pdo_principal = new PDO(
        "mysql:host=localhost;dbname=u750204740_salaberga;charset=utf8mb4",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Busca usuários do banco principal
    $stmt = $pdo_principal->query("SELECT id, nome, email FROM usuarios");
    $usuarios_principal = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Para cada usuário do banco principal
    foreach ($usuarios_principal as $usuario) {
        // Verifica se o usuário já existe no banco local
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$usuario['email']]);
        $usuario_local = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario_local) {
            // Se não existe, insere no banco local
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
            $stmt->execute([$usuario['nome'], $usuario['email']]);
            $usuario_local_id = $pdo->lastInsertId();

            // Registra a sincronização
            $stmt = $pdo->prepare("INSERT INTO sincronizacao_usuarios (usuario_id_local, usuario_id_principal) VALUES (?, ?)");
            $stmt->execute([$usuario_local_id, $usuario['id']]);
        } else {
            // Se existe, atualiza a última sincronização
            $stmt = $pdo->prepare("UPDATE sincronizacao_usuarios SET ultima_sincronizacao = CURRENT_TIMESTAMP WHERE usuario_id_local = ?");
            $stmt->execute([$usuario_local['id']]);
        }
    }

    echo "Sincronização de usuários concluída com sucesso!\n";
} catch (PDOException $e) {
    die("Erro ao sincronizar usuários: " . $e->getMessage() . "\n");
} 