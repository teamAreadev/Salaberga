<?php
require_once('../models/main.model.php');
print_r($_POST);
if (
    isset($_POST['cursoProduto']) && !empty($_POST['cursoProduto']) &&
    isset($_POST['nomeProduto']) && !empty($_POST['nomeProduto']) &&
    isset($_POST['precoProduto']) && !empty($_POST['precoProduto']) &&
    isset($_POST['quantidadeProduto']) && !empty($_POST['quantidadeProduto'])
) {
    $arrecadacao_id = null; // Defina corretamente conforme sua lógica de negócio
    $nome_produto = $_POST['nomeProduto'];
    $preco_unitario = $_POST['precoProduto'];
    $quantidade_vendida = $_POST['quantidadeProduto'];

    $main_model = new main_model();
    $result = $main_model->cadastrar_produto($arrecadacao_id, $nome_produto, $preco_unitario, $quantidade_vendida);

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
    isset($_POST['criterio']) && !empty($_POST['criterio']) &&
    isset($_POST['pontuacao']) && !empty($_POST['pontuacao']) &&
    isset($_POST['curso']) && !empty($_POST['curso'])
) {
    $criterio = $_POST['criterio'];
    $pontuacao = $_POST['pontuacao'];
    $curso = $_POST['curso'];

    $main_model = new main_model();
    $result = $main_model->confirmar_empreendedorismo($criterio, $pontuacao, $curso);

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