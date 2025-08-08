<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../model/model.functions.php');
if (isset($_POST['btn'])) {
    $retirante = $_POST['retirante'];
    $valor_retirada = $_POST['quantidade'];

    error_log("=== INICIANDO PROCESSAMENTO DE SOLICITAÇÃO ===");
    error_log("POST data: " . json_encode($_POST));

    $x = new gerenciamento();

    // 1️⃣ Prioriza o uso do barcode se estiver presente
    if (!empty($_POST['barcode'])) {
        $barcode = $_POST['barcode'];

        error_log("=== SOLICITAÇÃO POR BARCODE ===");
        error_log("Barcode recebido: " . $barcode);
        error_log("Quantidade: " . $valor_retirada);
        error_log("Responsável: " . $retirante);

        $produtoEncontrado = $x->buscarProdutoPorBarcode($barcode);
        if ($produtoEncontrado) {
            error_log("Produto encontrado via barcode: " . json_encode($produtoEncontrado));

            // 👉 Usa o barcode como argumento
            $x->solicitarproduto($valor_retirada, $produtoEncontrado['barcode'], $retirante);

        } else {
            error_log("Produto não encontrado para barcode: " . $barcode);
            header("Location: ../view/solicitar.php?error=1&message=" . urlencode("Produto não encontrado com o código de barras informado!"));
            exit;
        }
    }

    // 2️⃣ Se barcode não for fornecido, usa o ID do produto selecionado
    elseif (!empty($_POST['produto'])) {
        $produto_id = $_POST['produto']; // aqui é o ID
        $produtoEncontrado = $x->buscarProdutoPorID($produto_id); // supondo que você tenha essa função

        if ($produtoEncontrado) {
            $x->solicitarproduto($valor_retirada, $produtoEncontrado['barcode'], $retirante); // também usa o barcode aqui
        } else {
            header("Location: ../view/solicitar.php?error=1&message=" . urlencode("Produto não encontrado pelo ID informado."));
            exit;
        }
    }

    // 3️⃣ Nenhuma opção fornecida
    else {
        header("Location: ../view/solicitar.php?error=1&message=" . urlencode("Por favor, selecione um produto ou insira o código de barras!"));
        exit;
    }
}
?>