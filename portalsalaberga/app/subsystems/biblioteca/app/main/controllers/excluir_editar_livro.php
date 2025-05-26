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

    echo $titulo = $_POST['titulo'];
    echo $id_livro = $_POST['id_livro'];
    echo $editora = $_POST['editora'];
    echo $edicao = $_POST['edicao'];
    echo $quantidade = $_POST['quantidade'];
    echo $corredor = $_POST['corredor'];
    echo $estante = $_POST['estante'];
    echo $prateleira = $_POST['prateleira'];
    echo $subgenero = $_POST['subgenero'];
    echo $literatura = $_POST['literatura'];
    echo $ficcao = $_POST['ficcao'];
    echo $cativo = $_POST['cativo'];
    echo $genero = $_POST['genero'];
    echo $ano_publicacao = $_POST['ano_publicacao'];
    echo $subgenero = $_POST['subgenero'];

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
