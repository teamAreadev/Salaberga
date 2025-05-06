<?php
require_once('../models/model.php');

if (isset($_POST['alunos']) && !empty($_POST['alunos']) && isset($_POST['id_vaga']) && !empty($_POST['id_vaga'])) {

    $id_aluno = $_POST['id_alunos'];
    $alunos = $_POST['alunos'];

    $model = new main_model;
    $result = $model->selecao($alunos, $id_vaga);

    switch ($result) {

        case 1:
            header('location:../views/dashboard.php');
            exit();
        case 2:
            header('location:../views/login.php?erro');
            exit();
        default:
            header('location:../index.php');
            exit();
    }
} else if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['senha']) && !empty($_POST['senha'])) {

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
        default:
            header('location:../index.php');
            exit();
    }
} else if (isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['endereco']) && !empty($_POST['endereco']) && isset($_POST['telefone']) && !empty($_POST['telefone'])) {

    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    if (isset($_POST)) {
        $perfis = array();

        // Lista de possíveis posts
        $possiveis = ['sup', 'des', 'dev', 'tut'];

        // Conta quantos posts válidos existem
        $count = 0;
        foreach ($possiveis as $post) {
            if (isset($_POST[$post]) && !empty($_POST[$post])) {
                $count++;
            }
        }

        // Adiciona apenas o número de posts correspondente à contagem
        $adicionados = 0;
        foreach ($possiveis as $post) {
            if (isset($_POST[$post]) && !empty($_POST[$post]) && $adicionados < $count) {
                $perfis[] = $_POST[$post];
                $adicionados++;
            }
        }
    }


    $model = new main_model;
    $result = $model->cadastrar_empresa($nome, $endereco, $telefone, $perfis);
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
} else if (isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['empresa']) && !empty($_POST['empresa']) && isset($_POST['areas']) && !empty($_POST['areas']) && isset($_POST['quantidades']) && !empty($_POST['quantidades'])) {

    $nome = $_POST['nome'];
    $id_empresa = $_POST['empresa'];
    $id_area = $_POST['areas'];
    $quantidades = $_POST['quantidades'];

    $model = new main_model;
    $result = $model->cadastrar_vaga($nome, $id_empresa, $id_area, $quantidades);

    switch ($result) {

        case 1:
            header('location:../views/vagas.php?certo');
            exit();
        case 2:
            header('location:../views/vagas.php?erro');
            exit();
        case 3:
            header('location:../views/vagas.php?existe');
            exit();
    }
} /*else {
    header('location:../views/login.php?erro');
    exit();
}*/
