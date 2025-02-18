<?php

$dsn = 'mysql:host=localhost;dbname=u750204740_Luiza_Teodoro';
$username = "u750204740_Luiza_Teodoro";
$password = "LuizadeTeodoro!@##qwe123";

try {
    $conexao = new PDO($dsn, $username, $password);
    
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}

?>
