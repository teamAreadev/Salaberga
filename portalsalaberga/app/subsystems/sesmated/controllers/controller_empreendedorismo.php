<?php
require_once('../models/main.model.php');
print_r($_POST);
if (
    isset($_POST['cursoProduto']) && !empty($_POST['cursoProduto']) &&
    isset($_POST['nomeProduto']) && !empty($_POST['nomeProduto']) &&
    isset($_POST['precoProduto']) && !empty($_POST['precoProduto']) &&
    isset($_POST['quantidadeProduto']) && !empty($_POST['quantidadeProduto'])
) {

    $curso_id = $_POST['cursoProduto'];
    $nome_produto = $_POST['nomeProduto'];
    $preco_unitario = $_POST['precoProduto'];
    $quantidade_vendida = $_POST['quantidadeProduto'];

    $main_model = new main_model();
    $result = $main_model->cadastrar_produto($curso_id, $nome_produto, $preco_unitario, $quantidade_vendida);

    switch ($result) {
        case 1:
            header('location:../views/Empreendedorismo.php?confirmado');
            exit();
        case 2:
            header('location:../views/Empreendedorismo.php?erro');
            exit();
        case 3:
            header('location:../views/Empreendedorismo.php?ja_confirmado');
            exit();
    }
} else if (
    isset($_POST['curso']) && !empty($_POST['curso']) &&
    isset($_POST['id_avaliador']) && !empty($_POST['id_avaliador']) &&
    isset($_POST['valor_lucro']) && !empty($_POST['valor_lucro'])
) {
    $id_curso = $_POST['curso'];
    $id_avaliador = $_POST['id_avaliador'];
    $lucro = $_POST['valor_lucro'];

    $main_model = new main_model();
    $result = $main_model->confirmar_empreendedorismo($id_curso, $id_avaliador, $lucro);

    switch ($result) {
        case 1:
            header('location:../views/Empreendedorismo.php?confirmado');
            exit();
        case 2:
            header('location:../views/Empreendedorismo.php?erro');
            exit();
        case 3:
            header('location:../views/Empreendedorismo.php?ja_confirmado');
            exit();
    }
}/*else {
    header('location:../views/Empreendedorismo.php?empty');
    exit();
} */