<?php

// Arquivo de configuração para a conexão com o banco de dados "areadev"

function getAreadevConnection() {
    // Configurações para o ambiente LOCAL (XAMPP, etc.)
    $host_local = 'localhost';
    // Certifique-se de que dbname_local, username_local e password_local estão corretos para o SEU XAMPP
    $dbname_local = 'areaDev'; // << VERIFIQUE ESTE NOME NO SEU PHPMyAdmin LOCAL
    $username_local = 'root'; // << GERALMENTE 'root' NO XAMPP
    $password_local = '';     // << GERALMENTE VAZIO NO XAMPP, VERIFIQUE SE VOCÊ DEFINIU UMA SENHA

    // Configurações para o ambiente de HOSPEDAGEM
    // Certifique-se de que estas configurações estão corretas para a SUA HOSPEDAGEM
    $host_hosting = 'localhost'; // Host da hospedagem (pode ser diferente, verifique com seu provedor)
    $dbname_hosting = 'u750204740_form_areaDev'; // Nome do banco na hospedagem
    $username_hosting = 'u750204740_form_areaDev'; // Usuário da hospedagem
    $password_hosting = 'paoComOvo123!@##'; // Senha da hospedagem

    // === Lógica para detectar o ambiente e escolher as credenciais ===
    $is_local = $_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1';

    if ($is_local) {
        // Ambiente local
        $host = $host_local;
        $dbname = $dbname_local;
        $username = $username_local;
        $password = $password_local;
    } else {
        // Ambiente de hospedagem
        $host = $host_hosting;
        $dbname = $dbname_hosting;
        $username = $username_hosting;
        $password = $password_hosting;
    }

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