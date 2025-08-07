<?php
    class Connection {
        protected $pdo;
        
        public function __construct() {
            $this->connect_database();
        }
        
        public function connect_database() {
            try {
                $this->pdo = new PDO("mysql:host=localhost;dbname=u750204740_estoque;charset=utf8mb4", "u750204740_estoque", "paoComOvo123!@##");
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
        
        public function getPdo() {
            return $this->pdo;
        }
    }
?>