<?php
require_once(__DIR__ . '/../../model/select_model.php');
$select = new select_model();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ultimas Saídas</h1> 

    <p>3A</p>

    <?php
    $dados = $select->saida_estagio_3A();
    foreach ($dados as $dado) {
    ?>
        <p><?= $dado['nome'] ?></p>
    <?php
    }
    ?>
    <P>3B </P>

    <?php
    $dados = $select->saida_estagio_3B();
    foreach ($dados as $dado) {
    ?>
        <p><?= $dado['nome'] ?></p>
    <?php
    }
    ?>
    <P>3C</P>

    <?php
    $dados = $select->saida_estagio_3C();
    foreach ($dados as $dado) {
    ?>
        <p><?= $dado['nome'] ?></p>
    <?php
    }?>
    <P>3D</P>

    <?php
    $dados = $select->saida_estagio_3D();
    foreach ($dados as $dado) {
    ?>
        <p><?= $dado['nome'] ?></p>
    <?php
    }?>
</body>
</html>