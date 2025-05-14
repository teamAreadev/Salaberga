<?php

define('HOST', 'localhost');
define('DATABASE', 'estagio');
define('USER', 'root');
define('PASSWORD', '');
/*

define('HOST', 'localhost');
define('DATABASE', 'u750204740_estagio2k25');
define('USER', 'u750204740_estagio2k25');
define('PASSWORD', 'paoComOvo123!@##');
*/

class connect
{
    protected $connect;

    function __construct()
    {
        $this->connect_database();
    }

    function connect_database()
    {

        try {

            $this->connect = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD);
        } catch (PDOException $e) {

            die('Erro! O sistema não possui conexão com o banco de dados.');
        }
    }
}
