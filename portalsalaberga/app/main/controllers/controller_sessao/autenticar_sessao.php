<?php

session_start();

if (isset($_GET['sair'])) {
    $_SESSION = array();
    session_destroy();
    header('Location: ../../views/autenticacao/login.php');
    exit();
}


// Verifica a página atual
$current_page = basename($_SERVER['PHP_SELF']);


// Função para verificar a página atual
function isCurrentPage($page)
{
    global $current_page;
    return $current_page === $page;
}

// Verifica se o usuário está logado e tem status válido
if (isset($_SESSION['login']) && $_SESSION['login'] && isset($_SESSION['status']) && !empty($_SESSION['status'])) {
    // Se o usuário não está na página 'subsistema.php', redireciona
    if (!isCurrentPage('subsistema.php')) {
        header('Location: ../../views/subsystem/subsistema.php'); // Use caminho absoluto
        exit();
    }
}
// Verifica se o usuário está em pré-cadastro
elseif (isset($_SESSION['precadastro']) && $_SESSION['precadastro']) {
    // Se o usuário não está na página 'cadastro.php', redireciona
    if (!isCurrentPage('cadastro.php')) {
        header('Location: ../../views/autenticacao/cadastro.php'); // Use caminho absoluto
        exit();
    }
}
// Caso contrário, redireciona para pré-cadastro
else {
    // Se o usuário não está na página 'precadastro.php', redireciona
    if (!isCurrentPage('precadastro.php')) {
        header('Location: ../../views/subsytem/subsistema.php'); // Use caminho absoluto
        exit();
    }
}