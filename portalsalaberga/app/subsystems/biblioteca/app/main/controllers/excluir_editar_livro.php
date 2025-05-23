<?php
require_once '../models/main_model.php';

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
}else if (isset($_POST['editar_livro']) && !empty($_POST['editar_livro'])) {
    $id_livro = $_POST['editar_livro'];

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
}
?>