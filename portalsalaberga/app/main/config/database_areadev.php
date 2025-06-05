<?php

// Arquivo de configuração para a conexão com o banco de dados "areadev"

// Configurações para o ambiente LOCAL (XAMPP, etc.)
$host_local = 'localhost';
$dbname_local = 'areadev';
$username_local = 'root';
$password_local = '';

// Configurações para o ambiente de HOSPEDAGEM
// *** SUBSTITUA os PLACEHOLDERS ABAIXO com os dados REAIS da sua hospedagem ***
$host_hosting = 'your_hosting_db_hostname'; // Ex: Um IP, um nome de servidor (mysql.seuhost.com)
$dbname_hosting = 'your_hosting_db_name'; // Nome do banco de dados na hospedagem
$username_hosting = 'your_hosting_db_username'; // Usuário do banco na hospedagem
$password_hosting = 'your_hosting_db_password'; // Senha do usuário do banco na hospedagem

function getAreadevConnection() {
    // Por padrão, usa as configurações locais
    $host = $host_local;
    $dbname = $dbname_local;
    $username = $username_local;
    $password = $password_local;
    $charset = 'utf8mb4';

    // Exemplo: Se quiser usar as configurações da hospedagem temporariamente, descomente e use estas linhas:
    /*
    $host = $host_hosting;
    $dbname = $dbname_hosting;
    $username = $username_hosting;
    $password = $password_hosting;
    */

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lançar exceções em erros
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retornar linhas como arrays associativos por padrão
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Usar prepared statements nativos
    ];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);
        // Note qual conexão está sendo usada (útil para depurar)
        $current_db = (strpos($host, 'localhost') !== false) ? 'local' : 'hospedagem';
        error_log("Debug: Conexão com o banco 'areadev' ({$current_db}) estabelecida com sucesso.");
        return $pdo;
    } catch (\PDOException $e) {
        // Logar o erro de conexão
        error_log("Erro de conexão com o banco 'areadev': " . $e->getMessage());
        // Em um ambiente de produção, você pode querer lançar uma exceção ou exibir uma mensagem genérica
        // throw new \PDOException("Não foi possível conectar ao banco de dados 'areadev'.");
        return null; // Retorna null em caso de falha na conexão
    }
}

?> 