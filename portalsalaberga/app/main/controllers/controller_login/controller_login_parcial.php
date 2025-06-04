<?php
error_log("Debug: controller_login_parcial.php loaded.");
session_start();


if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    error_log("Debug: Tentativa de login para o email: " . $email);
    
    error_log("Debug: Attempting to include model_dados.php");
    require_once('../../models/model_dados.php');
    error_log("Debug: model_dados.php included successfully.");
    
    $login = login_parcial($email, $senha);
    
    if ($login) {
        error_log("Debug: Login bem sucedido para o email: " . $email);
        header('Location: ../../views/form/success_form_parcial.php');
        exit();
    } else {
        error_log("Debug: Falha no login para o email: " . $email);
        header('Location: ../../views/autenticacao/login_parcial.php?login=erro');
        exit();
    }
} else {
    error_log("Debug: Dados de login incompletos ou inválidos");
    header('Location: ../../views/autenticacao/login_parcial.php?login=erro');
    exit();
}
