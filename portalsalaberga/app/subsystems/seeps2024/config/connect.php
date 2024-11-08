<?php 

define('HOST', 'localhost');
define('DATABASE', 'seeps');
define('USER', 'root');
define('PASSWORD', '');

class connect{

    protected $connect;

    function __construct(){

        $this->connect_database();
    }

    function connect_database(){

        try{
            $this->connect = new PDO('mysql:host='.HOST.',dbname='.DATABASE, USER, PASSWORD);

        }catch(PDOException $e){

            echo "Erro ao se conectar com o banco de dados". $e->getMessage();
            die();
        }
    }
}
?>