<?php
class Database {
    private $dsn = "mysql:host=localhost;dbname=registro_pcd;charset=utf8mb4";
    private $username = "root";
    private $password = "";
    protected $db;

    public function __construct() {
        $this->connect_database();
    }
    function connect_database(){
        try {
            $this->db = new PDO($this->dsn, $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}
?>