<?php
require_once '../models/main_model.php';
print_r($_POST);
if (isset($_POST['excluir_livro']) && !empty($_POST['excluir_livro'])) {
    $id_livro = $_POST['excluir_livro'];

    $titulo = $_POST['titulo'];
    $dados = [
        'titulo_livro' => $titulo
    ];

    $model = new main_model();
    $result = $model->excluir_livro($id_livro);


    switch ($result) {
        case 1:
            header('location:../views/excluir_livro.php?true');
            break;
        case 2:
            header('location:../views/excluir_livro.php?error');
            break;
    }
} else if (
    isset($_POST['editar_livro']) && !empty($_POST['editar_livro']) &&
    isset($_POST['titulo']) && !empty($_POST['titulo']) &&
    isset($_POST['data']) && !empty($_POST['data']) &&
    isset($_POST['editora']) && !empty($_POST['editora']) &&
    isset($_POST['edicao']) && !empty($_POST['edicao']) &&
    isset($_POST['quantidade']) && !empty($_POST['quantidade']) &&
    isset($_POST['corredor']) && !empty($_POST['corredor']) &&
    isset($_POST['estante']) && !empty($_POST['estante']) &&
    isset($_POST['prateleira']) && !empty($_POST['prateleira']) &&
    isset($_POST['subgenero']) && !empty($_POST['subgenero']) &&
    isset($_POST['literatura']) && !empty($_POST['literatura']) &&
    isset($_POST['ficcao']) && !empty($_POST['ficcao']) &&
    isset($_POST['cativo']) && !empty($_POST['cativo'])
) {
    $id_livro = $_POST['editar_livro'];
    $titulo = $_POST['titulo'];
    $data = $_POST['data'];
    $editora = $_POST['editora'];
    $edicao = $_POST['edicao'];
    $quantidade = $_POST['quantidade'];
    $corredor = $_POST['corredor'];
    $estante = $_POST['estante'];
    $prateleira = $_POST['prateleira'];
    $subgenero = $_POST['subgenero'];
    $literatura = $_POST['literatura'];
    $ficcao = $_POST['ficcao'];
    $cativo = $_POST['cativo'];

    $model = new main_model();
    $result = $model->editar_livro($id_livro, $titulo, $data, $editora, $edicao, $quantidade, $corredor, $estante, $prateleira, $subgenero, $literatura, $ficcao, $cativo);

    switch ($result) {
        case 1:
            header('location:../views/excluir_livro.php?true');
            break;
        case 2:
            header('location:../views/excluir_livro.php?error');
            break;
    }
}
