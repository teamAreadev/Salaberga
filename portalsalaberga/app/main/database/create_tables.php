<?php
require_once(__DIR__ . '/../config/connect.php');

try {
    $conn = getConnection();
    
    // Lê o arquivo SQL
    $sql = file_get_contents(__DIR__ . '/create_usuarios_table.sql');
    
    // Executa o SQL
    $conn->exec($sql);
    
    echo "Tabela 'usuarios' criada com sucesso!";
} catch(PDOException $e) {
    echo "Erro ao criar tabela: " . $e->getMessage();
} 