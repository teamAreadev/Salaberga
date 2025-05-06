<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'copa_gremio';
    private $username = 'root';
    private $password = '';
    private $conn;
    /*
    private $host = 'localhost';
    private $db_name = 'u750204740_formcpgremio';
    private $username = 'u750204740_formcpgremio';
    private $password = 'Gremio@25!';
    private $conn;
    */
    public function getConnection() {
        $this->conn = null;

        try {
            error_log("Tentando conectar ao banco de dados: {$this->host}/{$this->db_name}");
            
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8", 
                $this->username, 
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                )
            );
            
            error_log("Conexão com o banco de dados estabelecida com sucesso");
        } catch(PDOException $exception) {
            error_log("Erro de conexão com o banco: " . $exception->getMessage());
            error_log("Detalhes: host={$this->host}, db={$this->db_name}, user={$this->username}");
            throw $exception;
        }

        return $this->conn;
    }
}
?>