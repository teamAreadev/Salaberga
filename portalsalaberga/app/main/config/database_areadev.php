<?php

// Arquivo de configuração para a conexão com o banco de dados "areadev"

function getAreadevConnection() {
    $host = 'localhost'; // Ex: 'localhost' ou o IP do servidor do banco
    $dbname = 'areadev';      // Nome do banco de dados que você criou
    $username = 'root'; // Seu nome de usuário do banco de dados
    $password = ''; // Sua senha do banco de dados
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lançar exceções em erros
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retornar linhas como arrays associativos por padrão
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Usar prepared statements nativos
    ];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);
        error_log("Debug: Conexão com o banco 'areadev' estabelecida com sucesso.");
        return $pdo;
    } catch (\PDOException $e) {
        // Logar o erro de conexão
        error_log("Erro de conexão com o banco 'areadev': " . $e->getMessage());
        // Em um ambiente de produção, você pode querer lançar uma exceção ou exibir uma mensagem genérica
        throw new \PDOException("Não foi possível conectar ao banco de dados 'areadev'.");
    }
}

?> 