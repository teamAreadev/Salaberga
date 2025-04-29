<?php
class Database {
  /*
    private $host = 'localhost';
    private $db_name = 'u750204740_formcpgremio';
    private $username = 'u750204740_formcpgremio';
    private $password = 'Gremio@25!';
  */
        private $host = 'localhost';
    private $db_name = 'copa_gremio';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}", 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>