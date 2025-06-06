<?php

// Arquivo de configuração para a conexão com o banco de dados "areadev"

function getAreadevConnection() {
    // Configurações para o ambiente LOCAL (XAMPP, etc.)
    $host_local = 'localhost';
    $dbname_local = 'u750204740_form_areaDev';
    $username_local = 'u750204740_form_areaDev';
    $password_local = 'paoComOvo123!@##';

    // Configurações para o ambiente de HOSPEDAGEM
    $host_hosting = 'localhost'; // Host da hospedagem
    $dbname_hosting = 'u750204740_form_areaDev'; // Nome do banco na hospedagem
    $username_hosting = 'u750204740_form_areaDev'; // Usuário da hospedagem
    $password_hosting = 'paoComOvo123!@##'; // Senha da hospedagem

    // Por padrão, usa as configurações da hospedagem
    $host = $host_hosting;
    $dbname = $dbname_hosting;
    $username = $username_hosting;
    $password = $password_hosting;
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);
        error_log("Debug: Conexão com o banco 'areadev' estabelecida com sucesso.");
        return $pdo;
    } catch (\PDOException $e) {
        error_log("Erro de conexão com o banco 'areadev': " . $e->getMessage());
        return null;
    }
}

?> 