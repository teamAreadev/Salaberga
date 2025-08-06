<?php
require("../model/model.functions.php");

if (isset($_POST['btn'])) {
    $barcode = $_POST['barcode'];

    $x = new gerenciamento();
    $x->consultarestoque($barcode);
}
?>