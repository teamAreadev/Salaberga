<?php
try {
    $dsn = 'mysql:host=localhost;dbname=u750204740_portalsaberga';
    $username = "u750204740_salaberga";
    $password = "paoComOvo123!@##";

    $conexao = new PDO($dsn, $username, $password);
} catch (PDOException $exception) {

    $dsn = 'mysql:host=localhost;dbname=salaberga';
    $username = "root";
    $password = "";
    $conexao = new PDO($dsn, $username, $password);
    
} finally {
    
}
