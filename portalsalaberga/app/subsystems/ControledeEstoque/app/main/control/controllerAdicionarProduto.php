<?php
require("../model/model.functions.php");

// Debug: verificar dados recebidos
error_log("controllerAdicionarProduto.php - POST data: " . print_r($_POST, true));

if (isset($_POST['btn'])) {
    $barcode = isset($_POST['barcode']) ? $_POST['barcode'] : '';
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $quantidade = isset($_POST['quantidade']) ? $_POST['quantidade'] : '';
    $natureza = isset($_POST['natureza']) ? $_POST['natureza'] : '';

    error_log("Dados recebidos - barcode: " . $barcode . ", nome: " . $nome . ", quantidade: " . $quantidade . ", natureza: " . $natureza);

    // Verificar se todos os campos obrigatórios estão preenchidos
    if (empty($nome) || empty($quantidade) || empty($natureza)) {
        error_log("Erro: Campos obrigatórios não preenchidos");
        header("location: ../view/adcnovoproduto.php?error=campos_vazios");
        exit();
    }

    $x = new gerenciamento();
    
    // Se não houver barcode, usar o nome com prefixo SC_ como identificador
    if (empty($barcode) || !is_numeric($barcode)) {
        // Para produtos sem código, usar SC_ + nome como identificador
        $barcode = 'SC_' . $nome;
        error_log("Produto sem código - barcode final: " . $barcode);
    }
    
    $x->adcproduto($barcode, $nome, $quantidade, $natureza);
} else {
    error_log("controllerAdicionarProduto.php - btn não encontrado no POST");
}
?>