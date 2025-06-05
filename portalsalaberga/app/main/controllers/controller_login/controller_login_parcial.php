<?php
session_start();

// Verifica se os dados de login foram enviados via POST
if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    error_log("Debug Controller Parcial: Tentativa de login parcial para o email: " . $email);

    // Inclui o arquivo de modelo que contém a função login_parcial()
    require_once(__DIR__ . '/../../models/model_dados.php');

    // Chama a função de login parcial
    $login_successful = login_parcial($email, $senha);

    if ($login_successful) {
        error_log("Debug Controller Parcial: Login parcial bem sucedido para o email: " . $email);
        // Redireciona para a página de sucesso após o login parcial
        // TODO: Substitua '../../views/subsytem/subsistema_parcial.php' pela página correta após login parcial
        header('Location: ../../views/form/form_parcial.php'); // Redirecionando para form_parcial.php
        exit();
    } else {
        error_log("Debug Controller Parcial: Falha no login parcial para o email: " . $email);
        // Redireciona de volta para a página de login parcial com mensagem de erro
        header('Location: ../../views/autenticacao/login_parcial.php?login=erro');
        exit();
    }
} else {
    error_log("Debug Controller Parcial: Acesso inválido ao controller de login parcial.");
    // Redireciona para a página de login parcial se não houver dados POST
    header('Location: ../../views/autenticacao/login_parcial.php');
    exit();
}
