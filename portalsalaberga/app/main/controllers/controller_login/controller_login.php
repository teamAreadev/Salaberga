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
    header('Location: ../../views/autenticação/login.php');
    exit();
}
if (isset($_POST['login']) && isset($_POST['Email']) && isset($_POST['Password']) && !empty($_POST['Email']) && !empty($_POST['Password'])) {

    $email = $_POST['Email'];
    $senha = $_POST['Password'];
    require_once('../../models/model_dados.php');
    $login = login($email, $senha);

    if ($login == 0) {

        header('location:../../../subsystems/SS/index.php?');
        exit();
    } else if ($login == 1) {

        header('location:../../../subsystems/SS/index.php?');
        exit();
    } else if ($login == 2) {

        header('Location: ../../views/autenticação/login.php?login=erro');
        exit();
    } else {

        header('Location: ../../views/autenticação/login.php');
        exit();
    }
} else {
    header('Location: ../../views/autenticação/login.php?login=erro');
    exit();
}
