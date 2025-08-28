<?php
class connect
{
    protected $connect;
    protected $connect_users;

    function __construct()
    {
        $this->connect_database();
    }

    function connect_database()
    {
        try {
            $config = require(__DIR__ . "/../../../../.env/config.php");

            // Tentar primeiro o banco local
            try {
                $host = $config['local']['salaberga_estoque']['host'];
                $database = $config['local']['salaberga_estoque']['banco'];
                $user = $config['local']['salaberga_estoque']['user'];
                $password = $config['local']['salaberga_estoque']['senha'];

                $this->connect = new PDO('mysql:host=' . $host . ';dbname=' . $database . ';charset=utf8', $user, $password);
                $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                $host_users = $config['local']['salaberga_users']['host'];
                $database_users = $config['local']['salaberga_users']['banco'];
                $user_users = $config['local']['salaberga_users']['user'];
                $password_users = $config['local']['salaberga_users']['senha'];

                $this->connect_users = new PDO('mysql:host=' . $host_users . ';dbname=' . $database_users . ';charset=utf8', $user_users, $password_users);
                $this->connect_users->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connect_users->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Se falhar, tentar o banco da hospedagem
                $host = $config['hospedagem']['salaberga_estoque']['host'];
                $database = $config['hospedagem']['salaberga_estoque']['banco'];
                $user = $config['hospedagem']['salaberga_estoque']['user'];
                $password = $config['hospedagem']['salaberga_estoque']['senha'];

                $this->connect = new PDO('mysql:host=' . $host . ';dbname=' . $database . ';charset=utf8', $user, $password);
                $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
                $host_users = $config['hospedagem']['salaberga_users']['host'];
                $database_users = $config['hospedagem']['salaberga_users']['banco'];
                $user_users = $config['hospedagem']['salaberga_users']['user'];
                $password_users = $config['hospedagem']['salaberga_users']['senha'];

                $this->connect_users = new PDO('mysql:host=' . $host_users . ';dbname=' . $database_users . ';charset=utf8', $user_users, $password_users);
                $this->connect_users->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connect_users->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {

            error_log("Erro de conexão com banco: " . $e->getMessage());
            $this->connect = null;
            header('location:../views/windows/desconnect.php');
            exit();
        }
    }
}
