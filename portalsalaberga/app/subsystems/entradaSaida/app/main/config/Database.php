<?php
//CONEXÃO COM O BANCO
class Database {
    private $dsn = 'mysql:host=localhost;dbname=entradasaida';
    private $username = 'root';
    private $password = '';
    private $connection = null;

    public function connect() {
        try {
            $this->connection = new PDO($this->dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (PDOException $exception) {
            throw new Exception("Connection error: " . $exception->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        $this->connection = null;
    }
    
}

?>