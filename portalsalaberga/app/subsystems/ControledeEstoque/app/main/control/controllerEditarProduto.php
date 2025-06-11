<?php
require("../model/model.functions.php");

// Verificar se a requisição é para carregar o produto para edição
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $gerenciamento = new gerenciamento();
    $produto = $gerenciamento->buscarProdutoPorId($id);

    if ($produto) {
        // Retorna os dados do produto em formato JSON
        header('Content-Type: application/json');
        echo json_encode($produto);
        exit;
    } else {
        // Produto não encontrado
        header('Content-Type: application/json');
        echo json_encode(['erro' => 'Produto não encontrado']);
        exit;
    }
}

// Verificar se a requisição é para salvar as alterações
if (isset($_POST['editar_id'])) {
    $id = $_POST['editar_id'];
    $nome = $_POST['editar_nome'];
    $barcode = $_POST['editar_barcode'];
    $quantidade = $_POST['editar_quantidade'];
    $natureza = $_POST['editar_natureza'];

    $gerenciamento = new gerenciamento();
    $resultado = $gerenciamento->editarProduto($id, $nome, $barcode, $quantidade, $natureza);

    if ($resultado) {
        header('location:../view/estoque.php?mensagem=Produto atualizado com sucesso!');
    } else {
        header('location:../view/estoque.php?erro=Erro ao atualizar produto.');
    }
}
?>