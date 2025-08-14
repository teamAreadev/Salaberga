<?php
require_once('../model/model.main.php');
print_r($_POST);
if (isset($_POST['categoria']) && !empty($_POST['categoria'])) {

    $categoria = $_POST['categoria'];

    $model = new MainModel();

    $result = $model->criar_categoria($categoria);
    switch ($result) {
        case 1:
            header('Location: ../view/estoque.php?categoria_registrado');
            exit();
        case 2:
            header('Location: ../view/estoque.php?categoria_erro');
            exit();
        case 3:
            header('Location: ../view/estoque.php?ja_existe');
            exit();
        default:
            header('Location: ../view/estoque.php?falha');
            exit();
    }
}
?> 