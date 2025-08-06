<?php
require("../model/model.functions.php");

if (isset($_POST['btn'])) {
    $barcode = isset($_POST['barcode']) ? $_POST['barcode'] : '';
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $natureza = $_POST['natureza'];

    error_log("Dados recebidos - barcode: " . $barcode . ", nome: " . $nome . ", quantidade: " . $quantidade . ", natureza: " . $natureza);

    $x = new gerenciamento();
    
    // Se não houver barcode, usar o nome com prefixo SCB_ como identificador
    if (empty($barcode) || !is_numeric($barcode)) {
        // Para produtos sem código, usar SCB_ + nome como identificador
        $barcode = 'SCB_' . $nome;
        error_log("Produto sem código - barcode final: " . $barcode);
    }
    
    $x->adcproduto($barcode, $nome, $quantidade, $natureza);
}
?>