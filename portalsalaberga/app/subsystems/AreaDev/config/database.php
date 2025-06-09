<?php
// Detecta se está no ambiente local ou na hospedagem
$is_local = $_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1';

// Configurações do banco de dados
if ($is_local) {
    // Configurações para ambiente local
    define('DB_SALABERGA_NAME', 'salaberga');
    define('DB_AREA_DEV_NAME', 'areadev');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    // Configurações para ambiente de produção (hospedagem)
    define('DB_SALABERGA_NAME', 'u750204740_salaberga');
    define('DB_AREA_DEV_NAME', 'u750204740_areadev');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'u750204740_salaberga');
    define('DB_PASS', 'paoComOvo123!@##');
}

class Database {
<<<<<<< HEAD
    private $salaberga;
    private $area_dev;
    private static $instance = null;
=======
    private $host = "localhost";
    private $db_name = "area_dev";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection() {
        $this->conn = null;
>>>>>>> parent of 3f481e1 (finalizando sistema de demandas)

    private function __construct() {
        try {
            // Conexão com o banco salaberga
            $dsn_salaberga = 'mysql:host=' . DB_HOST . ';dbname=' . DB_SALABERGA_NAME;
            $this->salaberga = new PDO($dsn_salaberga, DB_USER, DB_PASS);
            $this->salaberga->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Conexão com o banco area_dev
            $dsn_area_dev = 'mysql:host=' . DB_HOST . ';dbname=' . DB_AREA_DEV_NAME;
            $this->area_dev = new PDO($dsn_area_dev, DB_USER, DB_PASS);
            $this->area_dev->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getSalabergaConnection() {
        return $this->salaberga;
    }

    public function getAreaDevConnection() {
        return $this->area_dev;
    }

    // Método para compatibilidade com código existente
    public function getConnection() {
        return $this->area_dev;
    }
}

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=areadev;charset=utf8mb4",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}