<?php
session_start();
require("../model/model.functions.php");

if (isset($_POST['btn'])) {
    $retirante = $_POST['retirante'];
    $valor_retirada = $_POST['quantidade'];
    
    // Verificar se foi enviado produto (ID) ou barcode
    if (isset($_POST['produto']) && !empty($_POST['produto'])) {
        $produto = $_POST['produto'];
        $x = new gerenciamento();
        $x->solicitarproduto($valor_retirada, $produto, $retirante);
    } elseif (isset($_POST['barcode']) && !empty($_POST['barcode'])) {
        $barcode = $_POST['barcode'];
        $x = new gerenciamento();
        
        // Log para debug
        error_log("Tentando solicitar produto com barcode: " . $barcode);
        
        // Buscar o produto pelo código de barras primeiro
        $produtoEncontrado = $x->buscarProdutoPorBarcode($barcode);
        if ($produtoEncontrado) {
            error_log("Produto encontrado: " . json_encode($produtoEncontrado));
            $x->solicitarproduto($valor_retirada, $barcode, $retirante);
        } else {
            error_log("Produto não encontrado para barcode: " . $barcode);
            // Redirecionar com erro se produto não encontrado
            header("Location: ../view/solicitar.php?error=1&message=Produto não encontrado com o código de barras informado!");
            exit;
        }
    } else {
        // Redirecionar com erro se nenhum produto foi selecionado
        header("Location: ../view/solicitar.php?error=1&message=Por favor, selecione um produto!");
        exit;
    }
}
?>