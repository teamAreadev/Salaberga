<?php

/*if (isset($_GET['login']) && $_GET['login'] == 'a') {
    header('Location: ../../views/aluno/subsistema_aluno.php');
    exit();
} else if (isset($_GET['login']) && $_GET['login'] == 'p') {
    header('Location: ../../views/professor/subsistema_professor.php');
    exit();
}*/

if (isset($_GET['sair'])) {
    // Guarda o valor da sessão 'recsenha'
    $recsenha = $_SESSION['recsenha'] ?? null;

    // Destroi todas as sessões
    session_unset();

    // Restaura apenas a sessão 'recsenha' se ela existia
    if ($recsenha !== null) {
        $_SESSION['recsenha'] = $recsenha;
    }
    header('Location: ../../views/autenticacao/login.php');
    exit();
}


if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    require_once('../../models/model_dados.php');
    $login = login($email, $senha);

    if ($login != 4) {

        header('location:../../views/subsytem/subsistema.php?');
        exit();
    } else {
        header('Location: ../../views/autenticacao/login.php?login=erro');
        exit();
    } 
} else {
    header('Location: ../../views/autenticacao/login.php?login=erro');
    exit();
} 
