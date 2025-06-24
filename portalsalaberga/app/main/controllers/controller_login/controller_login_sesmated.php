<?php

require_once('../../models/model_dados.php');

if (isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];



    $login_successful = login_sesmated($email, $senha);

    if ($login_successful) {

        header('location: ../../views/subsytem/subsistema_sesmated.php');
        exit();
    } else {
        header('Location: ../../views/autenticacao/login_sesmated.php?login=erro');
        exit();
    }
} else {

    header('Location: ../../views/autenticacao/login_sesmated.php');
    exit();
}
