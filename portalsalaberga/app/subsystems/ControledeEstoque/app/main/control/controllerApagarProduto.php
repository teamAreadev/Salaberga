<?php
require("../model/model.functions.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $gerenciamento = new gerenciamento();
    $resultado = $gerenciamento->apagarProduto($id);

    if ($resultado) {
        header('location:../view/estoque.php?mensagem=Produto excluído com sucesso!');
    } else {
        header('location:../view/estoque.php?erro=Erro ao excluir produto.');
    }
} else {
    header('location:../view/estoque.php');
}
?>