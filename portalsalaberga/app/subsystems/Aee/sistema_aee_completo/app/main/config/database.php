<?php
function getDatabaseConnection() {
    try {
        // Configurações para ambiente local
        $localConfig = [
            'host' => 'localhost',
            'dbname' => 'sis_aee',
            'username' => 'root',
            'password' => ''
        ];

        // Configurações para ambiente de produção (hospedagem)
        $prodConfig = [
            'host' => 'localhost', // Substitua pelo host da hospedagem
            'dbname' => 'u750204740_aee', // Substitua pelo nome do banco na hospedagem
            'username' => 'u750204740_aee', // Substitua pelo usuário da hospedagem
            'password' => 'paoComOvo123!@##' 
        ];

        // Verifica se está em ambiente de produção
        $isProduction = getenv('ENVIRONMENT') === 'production';
        $config = $isProduction ? $prodConfig : $localConfig;
        
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ];

        $pdo = new PDO($dsn, $config['username'], $config['password'], $options);
        
        // Testar a conexão
        $pdo->query("SELECT 1");
        
        return $pdo;
    } catch (PDOException $e) {
        error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
        throw new Exception("Não foi possível conectar ao banco de dados. Verifique se o MySQL está rodando e se o banco existe.");
    }
}
?>