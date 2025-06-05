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
                $is_local = $_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1';

                if ($is_local) {
                    $dsn = 'mysql:host=localhost;dbname=salaberga'; // Local DB Name
                    $username = "root";
                    $password = "";
                } else {
                    $dsn = 'mysql:host=localhost;dbname=u750204740_portalsaberga'; // Production DB Name
                    $username = "u750204740_salaberga";
                    $password = "paoComOvo123!@##"; // Production Password
                }

                self::$conexaoSalaberga = new PDO($dsn, $username, $password);
                self::$conexaoSalaberga->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                die("Erro na conexão com o banco de dados Salaberga: " . $exception->getMessage());
            }
        }
        return self::$conexaoSalaberga;
    }

    public static function getAreadevConnection() {
        if (self::$conexaoAreadev === null) {
            try {
                 // Detecta se está no ambiente local
                 $is_local = $_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1';

                 if ($is_local) {
                    $dsn = 'mysql:host=localhost;dbname=u750204740_areadev'; // Local DB Name
                    $username = "root";
                    $password = "";
                 } else {
                    $dsn = 'mysql:host=localhost;dbname=u750204740_areadev'; // Production DB Name
                    $username = "u750204740_salaberga"; // Usuário de produção, pode ser o mesmo
                    $password = "paoComOvo123!@##"; // Senha de produção
                 }

                self::$conexaoAreadev = new PDO($dsn, $username, $password);
                self::$conexaoAreadev->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                die("Erro na conexão com o banco de dados Areadev: " . $exception->getMessage());
            }
        }
        return self::$conexaoAreadev;
    }
}
