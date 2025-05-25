<?php
require_once __DIR__ . '/config/config.php';

try {
    // Criar banco de dados
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $pdo->exec("USE " . DB_NAME);

    // Criar tabela de usuários
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            tipo ENUM('admin', 'usuario') NOT NULL,
            data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Criar tabela de demandas
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS demandas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(200) NOT NULL,
            descricao TEXT NOT NULL,
            prioridade ENUM('baixa', 'media', 'alta') NOT NULL,
            status ENUM('pendente', 'em_andamento', 'concluida') NOT NULL DEFAULT 'pendente',
            admin_id INT NOT NULL,
            data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            data_conclusao TIMESTAMP NULL,
            FOREIGN KEY (admin_id) REFERENCES usuarios(id)
        )
    ");

    // Tabela de atribuição de usuários às demandas
    $pdo->exec("DROP TABLE IF EXISTS demanda_usuarios");
    $pdo->exec("
        CREATE TABLE demanda_usuarios (
            demanda_id INT,
            usuario_id INT,
            status ENUM('pendente', 'em_andamento', 'concluido') DEFAULT 'pendente',
            data_conclusao DATETIME DEFAULT NULL,
            PRIMARY KEY (demanda_id, usuario_id),
            FOREIGN KEY (demanda_id) REFERENCES demandas(id) ON DELETE CASCADE,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
        )
    ");

    // Verificar se já existe um usuário admin
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE tipo = 'admin'");
    $adminCount = $stmt->fetchColumn();

    if ($adminCount == 0) {
        // Inserir usuário admin padrão
        $stmt = $pdo->prepare("
            INSERT INTO usuarios (nome, email, senha, tipo) 
            VALUES (?, ?, ?, ?)
        ");
        $senha_hash = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt->execute([
            'Administrador',
            'admin@sistema.com',
            $senha_hash,
            'admin'
        ]);
        echo "Usuário admin criado com sucesso!<br>";
    }

    echo "Banco de dados configurado com sucesso!";
} catch (PDOException $e) {
    die("Erro ao configurar banco de dados: " . $e->getMessage());
}
?> 