<?php
try {
    $dsn = 'mysql:host=localhost;dbname=u750204740_areadev';
    $username = "u750204740_areadev";
    $password = "paoComOvo123!@##";

    $conexao = new PDO($dsn, $username, $password);
} catch (PDOException $exception) {

    $dsn = 'mysql:host=localhost;dbname=area_dev';
    $username = "root";
    $password = "";
    $conexao = new PDO($dsn, $username, $password);
    
} finally {
    
}
