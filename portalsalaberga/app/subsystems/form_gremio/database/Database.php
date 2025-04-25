<?php

$dsn = 'mysql:host=localhost;dbname=u750204740_filme_salaberg';
$username = "u750204740_filme_salaberg";
$password = "paoComOvo123!@##";

try {
    $conexao = new PDO($dsn, $username, $password);
    
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}

?>