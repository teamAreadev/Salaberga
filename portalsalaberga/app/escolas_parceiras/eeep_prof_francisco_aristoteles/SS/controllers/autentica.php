<?php

// Verifica se existe um POST email e password e se não está vazio
if (isset($_GET['email']) && isset($_GET['senha']) && !empty($_GET['email']) && !empty($_GET['senha'])) {
    require_once('../models/model.php');
    
    // Cria as variáveis
    $email = $_GET['email'];
    $senha = $_GET['senha'];
    
    // Inicia a sessão
    session_start();
    
    // Chama a função logar
    $login = logar($email, $senha);
    
    switch ($_SESSION['status']) {
        case 0:
            header('Location: ../views/inicio.php');
            exit();
        case 1:
            header('Location: ../views/inicio_ADM.php');
            exit();
        default:
            header('Location: ../../../index.php');
            exit();
    }
}

// Verifica se o usuário deseja sair
 
if (isset($_GET['sair'])) {
    session_start();
    session_unset();
    session_destroy();
    header('Location: ../../../index.php'); // Redireciona para a página de escolas parceiras
    echo '<script src="../assets/js/clearCache.js"></script>';
    echo '<script>window.location.href = "../../../escolas_parceiras.php";</script>';
    exit();

}


