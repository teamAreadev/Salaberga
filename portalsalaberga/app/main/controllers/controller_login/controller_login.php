<?php


if (isset($_POST['email']) && $_POST['email'] == 'concedente@concedente.com' && isset($_POST['senha']) && $_POST['senha'] == 'paocomovo') {
    header('Location: ../../views/subsytem/subsistema_concedente.php');
    exit();
}

if (isset($_GET['sair'])) {
    // Guarda o valor da sessão 'recsenha'
    $recsenha = $_SESSION['recsenha'] ?? null;

    // Destroi todas as sessões
    session_unset();

    // Restaura apenas a sessão 'recsenha' se ela existias
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

    if ($_SESSION['status'] == 0 || $_SESSION['status'] == 1 || $_SESSION['status'] == 3 ) {

        header('location: ../../views/subsytem/subsistema.php');
        exit();
    } else if ($_SESSION['status'] == 2){
        header('Location: ../../views/subsytem/subsistema_estagio.php');
        exit();
    } else if ($_SESSION['status'] == 4){
        header('Location: ../../views/autenticacao/login.php?login=erro');
        exit();
    } 
} else {
   
} 


?>