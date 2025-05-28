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
    isset($_POST['id_livro']) && !empty($_POST['id_livro']) &&
    isset($_POST['titulo']) && !empty($_POST['titulo']) &&
    isset($_POST['editora']) && !empty($_POST['editora']) &&
    isset($_POST['edicao']) && !empty($_POST['edicao']) &&
    isset($_POST['quantidade']) && !empty($_POST['quantidade']) &&
    isset($_POST['corredor']) && !empty($_POST['corredor']) &&
    isset($_POST['estante']) && !empty($_POST['estante']) &&
    isset($_POST['prateleira']) && !empty($_POST['prateleira']) &&
    isset($_POST['subgenero']) && !empty($_POST['subgenero']) &&
    isset($_POST['genero']) && !empty($_POST['genero']) &&
    isset($_POST['ano_publicacao']) && !empty($_POST['ano_publicacao']) &&
    isset($_POST['quantidade']) && !empty($_POST['quantidade'])
) {
    $titulo = $_POST['titulo'];
    $id_livro = $_POST['id_livro'];
    $editora = $_POST['editora'];
    $edicao = $_POST['edicao'];
    $quantidade = $_POST['quantidade'];
    $corredor = $_POST['corredor'];
    $estante = $_POST['estante'];
    $prateleira = $_POST['prateleira'];
    $subgenero = $_POST['subgenero'];
    $literatura = $_POST['literatura'] ?? 0;
    $ficcao = $_POST['ficcao'] ?? 0;
    $cativo = $_POST['cativo'] ?? 0;
    $genero = $_POST['genero'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $subgenero = $_POST['subgenero'];
    $genero = $_POST['genero'];

    $model = new main_model();
    $result = $model->editar_livro($id_livro, $titulo, $data, $editora, $edicao, $quantidade, $corredor, $estante, $prateleira, $subgenero, $literatura, $ficcao, $cativo, $genero, $ano_publicacao);

    switch ($result) {
        case 1:
            header('location:../views/excluir_livro.php?true');
            break;
        case 2:
            header('location:../views/excluir_livro.php?error');
            break;
    }
}
