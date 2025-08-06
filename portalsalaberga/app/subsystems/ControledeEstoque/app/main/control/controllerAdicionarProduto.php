<?php
require("../model/model.functions.php");

if (isset($_POST['btn'])) {
    $barcode = $_POST['barcode'];
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $natureza = $_POST['natureza'];


    $x = new gerenciamento();
    $x->adcproduto($barcode, $nome, $quantidade,  $natureza);
}
?>