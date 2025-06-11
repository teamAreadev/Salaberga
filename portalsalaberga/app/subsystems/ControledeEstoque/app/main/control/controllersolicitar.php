<?php
session_start();
require("../model/model.functions.php");

if (isset($_POST['btn'])) {
    $produto = $_POST['produto'];
    $retirante = $_POST['retirante'];
    $valor_retirada = $_POST['quantidade'];

    $x = new gerenciamento();
    $x->solicitarproduto($valor_retirada, $produto, $retirante);
}
?>