<?php

define('HOST', 'localhost');
define('DATABASE', 'u750204740_sistBiblioteca');
define('USER', 'u750204740_sistBiblioteca');
define('PASSWORD', 'paoComOvo123!@##');
/*
define('HOST', 'localhost');
define('DATABASE', 'sist_biblioteca');
define('USER', 'root');
define('PASSWORD', '');
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
