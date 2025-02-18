<?php

$dsn = 'mysql:host=localhost;dbname=u750204740_Antonio_valmir';
$username = "u750204740_Antonio_valmir";
$password = "Antonio_Valmir!@##qwe123";


try {
    $conexao = new PDO($dsn, $username, $password);
    
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}

?>
