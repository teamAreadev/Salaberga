<?php
class Connection {
    protected $pdo;
    
    public function __construct($env = 'local') {
        $this->connect_database($env);
    }
    
    public function connect_database($env) {
        // Configurações de conexão local
        $local_dsn = "mysql:host=localhost;dbname=u750204740_estoque;charset=utf8mb4";
        $local_user = "root";
        $local_pass = "";
        
        // Configurações de conexão da hospedagem
        $host_dsn = "mysql:host=mysql.hostinger.com;dbname=u750204740_estoque;charset=utf8mb4"; // Substitua por host correto
        $host_user = "u750204740_estoque";
        $host_pass = "paoComOvo123!@##";
        
        try {
            if ($env === 'local') {
                $this->pdo = new PDO($local_dsn, $local_user, $local_pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                error_log("Conexão local estabelecida com sucesso!");
                return true;
            } else {
                $this->pdo = new PDO($host_dsn, $host_user, $host_pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                error_log("Conexão com hospedagem estabelecida com sucesso!");
                return true;
            }
        } catch (PDOException $e) {
            error_log("Erro na conexão ($env): " . $e->getMessage());
            return false;
        }
    }
    
    public function getPdo() {
        return $this->pdo;
    }
}
?>