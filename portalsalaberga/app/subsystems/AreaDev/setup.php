<?php
require_once __DIR__ . '/config/config.php';

try {
    // Criar banco de dados
    $pdo->exec("CREATE DATABASE IF NOT EXISTS area_dev");
    $pdo->exec("USE area_dev");

    // Criar tabela de usuários
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            senha VARCHAR(32) NOT NULL,
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
            usuario_id INT NULL,
            data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            data_conclusao TIMESTAMP NULL,
            FOREIGN KEY (admin_id) REFERENCES usuarios(id),
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
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
        $stmt->execute([
            'Administrador',
            'admin@sistema.com',
            '0192023a7bbd73250516f069df18b500', // senha: admin123
            'admin'
        ]);
        echo "Usuário admin criado com sucesso!<br>";
    }

    echo "Banco de dados configurado com sucesso!";
} catch (PDOException $e) {
    die("Erro ao configurar banco de dados: " . $e->getMessage());
}
?> 