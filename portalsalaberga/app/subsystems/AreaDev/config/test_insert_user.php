<?php
// Script para inserir um usuário de teste diretamente no banco u750204740_salaberga
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=u750204740_salaberga;charset=utf8mb4",
        "root", // Altere para seu usuário se necessário
        "",      // Altere para sua senha se necessário
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $nome = 'Teste Insercao Direta';
    $email = 'teste_insercao@exemplo.com';
    $senha = password_hash('senha123', PASSWORD_BCRYPT);
    $cpf = '999.999.999-99';

    // Verifica se já existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo "Usuário já existe!";
        exit;
    }

    // Insere o usuário
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, senha, email, cpf) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $senha, $email, $cpf]);
    $usuario_id = $pdo->lastInsertId();

    echo "Usuário inserido com sucesso! ID: $usuario_id\n";

    // Vincular permissão de área correta (usuario_area_dev(3) = ID 14)
    $sist_perm_id = 14; // 14 = usuario_area_dev(3), 15 = usuario_area_suporte(3), 16 = usuario_area_design(3)
    $stmt = $pdo->prepare("INSERT INTO usu_sist (usuario_id, sist_perm_id) VALUES (?, ?)");
    $stmt->execute([$usuario_id, $sist_perm_id]);
    echo "Permissão de área vinculada com sucesso!\n";

} catch (PDOException $e) {
    die("Erro ao inserir usuário: " . $e->getMessage());
} 