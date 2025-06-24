<?php
session_start();

// Verifica se os dados de login foram enviados via POST
if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    error_log("Debug Controller Parcial: Tentativa de login parcial para o email: " . $email);

    require_once(__DIR__ . '/../../models/model_dados.php');

    $login_successful = login_sesmated($email, $senha);

    switch ($login_successful) {

        case 1:
            header('../../views/subsytem/subsistema_sesmated.php');
            exit();
        case 2:
            header('Location: ../../views/autenticacao/login_sesmated.php?login=erro');
            exit();
    }
} else {

    header('Location: ../../views/autenticacao/login_sesmated.php');
    exit();
}
