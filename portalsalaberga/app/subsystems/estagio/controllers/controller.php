<?php
require_once('../models/model.php');

if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['senha']) && !empty($_POST['senha'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $model = new main_model;
    $result = $model->login($email, $senha);

    switch ($result) {

        case 1:
            header('location:../views/dashboard.php');
            exit();
        case 2:
            header('location:../views/login.php?erro');
            exit();
    }
} else if (isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['areas']) && !empty($_POST['areas']) && isset($_POST['endereco']) && !empty($_POST['endereco']) && isset($_POST['telefone']) && !empty($_POST['telefone'])) {

    $nome = $_POST['nome'];
    $area = $_POST['areas'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];

    $model = new main_model;
    $result = $model->cadastrar_empresa($nome, $area, $endereco, $telefone);
    switch ($result) {

        case 1:
            header('location:../views/gerenciar_empresas.php?certo');
            exit();
        case 2:
            header('location:../views/gerenciar_empresas.php?erro');
            exit();
        case 3:
            header('location:../views/gerenciar_empresas.php?existe');
            exit();
    }
} /*else {
    header('location:../views/login.php?session');
    exit();
}*/
