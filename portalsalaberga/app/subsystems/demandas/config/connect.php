<?php
class connect
{
    protected $connect_demandas;
    protected $connect_salaberga;

    function __construct()
    {
        $this->connect_database();
    }
    function connect_database()
    {
        try {
            $host = 'localhost';
            $database = 'demandas';
            $user = 'root';
            $password = '';
            $this->connect_demandas = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $password);
            
            $host = 'localhost';
            $database = 'salaberga';
            $user = 'root';
            $password = '';
            $this->connect_salaberga = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $password);

        } catch (PDOException $e) {
            $host = 'localhost';
            $database = 'u750204740_demandas';
            $user = 'u750204740_demandas';
            $password = 'paoComOvo123!@##';
            $this->connect = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $password);

            $host = 'localhost';
            $database = 'u750204740_salaberga';
            $user = 'u750204740_salaberga';
            $password = 'paoComOvo123!@##';
            $this->connect = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $password);
        } catch (PDOException $e) {

            die('Erro! O sistema não possui conexão com o banco de dados.');
        }
    }
}
