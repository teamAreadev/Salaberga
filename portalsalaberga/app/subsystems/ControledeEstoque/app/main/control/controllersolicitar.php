<?php
session_start();
require("../model/model.functions.php");

if (isset($_POST['btn'])) {
    $retirante = $_POST['retirante'];
    $valor_retirada = $_POST['quantidade'];
    
    // Log para debug
    error_log("=== INICIANDO PROCESSAMENTO DE SOLICITAÇÃO ===");
    error_log("POST data: " . json_encode($_POST));
    
    // Verificar se foi enviado produto (ID) ou barcode
    if (isset($_POST['produto']) && !empty($_POST['produto'])) {
        $produto = $_POST['produto'];
        $x = new gerenciamento();
        $x->solicitarproduto($valor_retirada, $produto, $retirante);
    } elseif (isset($_POST['barcode']) && !empty($_POST['barcode'])) {
        $barcode = $_POST['barcode'];
        $x = new gerenciamento();
        
        // Log para debug
        error_log("=== SOLICITAÇÃO POR BARCODE ===");
        error_log("Barcode recebido: " . $barcode);
        error_log("Quantidade: " . $valor_retirada);
        error_log("Responsável: " . $retirante);
        
        // Buscar o produto pelo código de barras primeiro
        $produtoEncontrado = $x->buscarProdutoPorBarcode($barcode);
        if ($produtoEncontrado) {
            error_log("Produto encontrado: " . json_encode($produtoEncontrado));
            error_log("Chamando solicitarproduto com barcode: " . $produtoEncontrado['barcode']);
            // Usar o código de barras real do produto, não o ID
            $x->solicitarproduto($valor_retirada, $produtoEncontrado['barcode'], $retirante);
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