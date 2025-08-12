<?php

require_once('../model/model.functions.php');
print_r($_POST);

if (isset($_POST['btn'])) {
    $retirante = $_POST['retirante'];
    $valor_retirada = $_POST['quantidade'];

    $x = new gerenciamento();

    if (!empty($_POST['barcode'])) {
        $barcode = $_POST['barcode'];

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