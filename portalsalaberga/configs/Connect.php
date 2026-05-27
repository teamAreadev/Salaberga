<?php
class Connect
{
    protected static $connection = null;

    protected static function getConnection()
    {
        try {
            $config = require(__DIR__ . "/../.env/config.php");

            // Tentar primeiro o banco local
            try {

                $host = $config['local']['paroquias']['host'];
                $database = $config['local']['paroquias']['database'];
                $user = $config['local']['paroquias']['user'];
                $password = $config['local']['paroquias']['password'];

                self::$connection = new PDO('mysql:host=' . $host . ';dbname=' . $database . ';charset=utf8', $user, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Se falhar, tentar o banco da hospedagem

                $host = $config['hospedagem']['paroquias']['host'];
                $database = $config['hospedagem']['paroquias']['database'];
                $user = $config['hospedagem']['paroquias']['user'];
                $password = $config['hospedagem']['paroquias']['password'];

                self::$connection = new PDO('mysql:host=' . $host . ';dbname=' . $database . ';charset=utf8', $user, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {

            error_log("Erro de conexão com banco: " . $e->getMessage());
            self::$connection = null;
            header('location: ../app/main/views/windows/desconectado.php');
            exit();
        }
    }
}
