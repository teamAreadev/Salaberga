<?php
require_once __DIR__ . '/database.php';

try {
    // Lê o arquivo SQL
    $sql = file_get_contents(__DIR__ . '/database.sql');
    
    // Divide o SQL em comandos individuais
    $commands = array_filter(array_map('trim', explode(';', $sql)));
    
    // Executa cada comando
    foreach ($commands as $command) {
        if (!empty($command)) {
            $pdo->exec($command);
        }
    }
    
    echo "Banco de dados configurado com sucesso!\n";
} catch (PDOException $e) {
    die("Erro ao configurar o banco de dados: " . $e->getMessage() . "\n");
} 