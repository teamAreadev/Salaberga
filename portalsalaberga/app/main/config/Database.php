<?php
class DatabaseManager {
    private static $instance = null;
    private static $conexaoSalaberga = null;
    private static $conexaoAreadev = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getSalabergaConnection() {
        if (self::$conexaoSalaberga === null) {
            try {
                // Detecta se está no ambiente local
                $is_local = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']);
                error_log("Ambiente detectado (Salaberga): " . ($is_local ? 'Local' : 'Produção'));

                    $dsn = 'mysql:host=localhost;dbname=u750204740_salaberga'; // Nome do banco local ajustado
                    $username = 'root';
                    $password = ''; // Ajuste se o root tiver senha
                

                self::$conexaoSalaberga = new PDO($dsn, $username, $password);
                self::$conexaoSalaberga->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                error_log("Conexão com Salaberga estabelecida com sucesso.");
            } catch (PDOException $exception) {
                error_log("Erro na conexão com o banco de dados Salaberga: " . $exception->getMessage());
                die("Erro na conexão com o banco de dados Salaberga: " . $exception->getMessage());
            }
        }
        return self::$conexaoSalaberga;
    }


}
?>