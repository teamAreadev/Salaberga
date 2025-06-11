<?php
require("../model/model.functions.php");

if (isset($_POST['btn'])) {
    $barcode = $_POST['barcode'];
    $quantidade = $_POST['quantidade'];

    $x = new gerenciamento();
    $x->adcaoestoque($barcode, $quantidade);
}
?>