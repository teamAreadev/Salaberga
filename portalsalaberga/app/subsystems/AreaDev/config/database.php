<?php
class Database {
    private $host = "localhost";
    private $db_name = "area_dev";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        // Primeiro tenta conectar ao banco de produção
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=u750204740_areadev";
            $this->conn = new PDO($dsn, "u750204740_areadev", "paoComOvo123!@##");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->exec("set names utf8");
            return $this->conn;
        } catch(PDOException $e) {
            // Se falhar, tenta conectar ao banco local
            try {
                $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->conn->exec("set names utf8");
                return $this->conn;
            } catch(PDOException $e) {
                echo "Erro de conexão: " . $e->getMessage();
                return null;
            }
        }
    }
}