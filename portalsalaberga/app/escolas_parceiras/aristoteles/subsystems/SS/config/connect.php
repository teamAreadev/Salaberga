<?php

$dsn = 'mysql:host=localhost;dbname=u750204740_Prof_Francisco';
$username = "u750204740_Prof_Francisco";
$password = "Prof_Francisco!@##qwe123";

try {
    $conexao = new PDO($dsn, $username, $password);
    
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}

?>
