<?php

require_once('../model/model.functions.php');
print_r($_POST);

if (isset($_POST['btn'])) {
    $retirante = $_POST['retirante'];
    $valor_retirada = $_POST['quantidade'];

    error_log("=== INICIANDO PROCESSAMENTO DE SOLICITAÇÃO ===");
    error_log("POST data: " . json_encode($_POST));
    error_log("Barcode presente: " . (!empty($_POST['barcode']) ? 'SIM' : 'NÃO'));
    error_log("Produto ID presente: " . (!empty($_POST['produto']) ? 'SIM' : 'NÃO'));
    error_log("Opção atual: " . ($_POST['opcao_atual'] ?? 'NÃO DEFINIDA'));
    error_log("Responsável recebido: " . $retirante);
    error_log("Tipo do responsável: " . gettype($retirante));

    $x = new gerenciamento();

    // 1️⃣ Prioriza o uso do barcode se estiver presente E não estiver vazio
    if (!empty($_POST['barcode']) && trim($_POST['barcode']) !== '') {
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

    // 2️⃣ Se barcode não for fornecido ou estiver vazio, usa o ID do produto selecionado
    elseif (!empty($_POST['produto']) && $_POST['produto'] !== '') {
        $produto_id = $_POST['produto']; // aqui é o ID
        
        error_log("=== SOLICITAÇÃO POR ID ===");
        error_log("ID do produto recebido: " . $produto_id);
        error_log("Quantidade: " . $valor_retirada);
        error_log("Responsável: " . $retirante);
        
        $produtoEncontrado = $x->buscarProdutoPorId($produto_id); // função correta
        
        error_log("Resultado da busca por ID: " . json_encode($produtoEncontrado));



        if ($produtoEncontrado) {
            error_log("Produto encontrado via ID: " . json_encode($produtoEncontrado));
            $x->solicitarproduto($valor_retirada, $produtoEncontrado['barcode'], $retirante); // também usa o barcode aqui
        } else {
            error_log("Produto não encontrado para ID: " . $produto_id);
            header("Location: ../view/solicitar.php?error=1&message=" . urlencode("Produto não encontrado pelo ID informado."));
            exit;
        }
    }

    // 3️⃣ Nenhuma opção fornecida
    else {
        error_log("Nenhum produto ou barcode fornecido");
        error_log("POST data completo: " . json_encode($_POST));
        header("Location: ../view/solicitar.php?error=1&message=" . urlencode("Por favor, selecione um produto ou insira o código de barras!"));
        exit;
    }
}
?>