<?php
class Database {
    private $salaberga;
    private $area_dev;
    private static $instance = null;

    private function __construct() {
        try {
            // Conexão com o banco salaberga
            $dsn_salaberga = 'mysql:host=localhost;dbname=salaberga';
            $username_salaberga = "root";
            $password_salaberga = "";
            $this->salaberga = new PDO($dsn_salaberga, $username_salaberga, $password_salaberga);
            $this->salaberga->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Conexão com o banco area_dev
            $dsn_area_dev = 'mysql:host=localhost;dbname=area_dev';
            $username_area_dev = "root";
            $password_area_dev = "";
            $this->area_dev = new PDO($dsn_area_dev, $username_area_dev, $password_area_dev);
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