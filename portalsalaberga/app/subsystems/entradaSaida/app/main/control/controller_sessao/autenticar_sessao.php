<?php
session_start();

// Controle de recarregamento da página
if (isset($_SESSION['refresh']) && $_SESSION['refresh'] == 0) {
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    header("refresh:0");
    $_SESSION['refresh'] = 1;
}

// Pega o nome do arquivo atual
$current_page = basename($_SERVER['PHP_SELF']);

// Definir listas de páginas permitidas para cada tipo de usuário
$pages_status_0 = ['paginaDoVigilante.php', 'index.php']; // Páginas permitidas para status 0 (vigilante)
$pages_status_1 = [
    'inicio.php',
    'index.php',
    'identificação.php',
    'identificacao.php', // Corrigir possíveis adições de páginas no futuro
    'esqueceu_a_senha.php',
    'entrada_saida.php',
    'codigo_de_verificacao.php',
    'cadastrar.php'
]; // Páginas permitidas para status 1 (gestão)
$pages_not_logged = ['index.php']; // Páginas permitidas para quem não está logado

// Lógica de redirecionamento
if (isset($_SESSION['login']) && $_SESSION['login'] && $_SESSION['status'] == 0) {
    // Usuário logado com status 0 (vigilante)
    if (!in_array($current_page, $pages_status_0)) {
        header('Location: ../views/paginaDoVigilante.php');
        exit();
    }
} elseif (isset($_SESSION['login']) && $_SESSION['login'] && $_SESSION['status'] == 1) {
    // Usuário logado com status 1 (gestão)
    if (!in_array($current_page, $pages_status_1)) {
        header('Location: ../views/inicio.php');
        exit();
    }
} else {
    // Usuário não logado
    if (!in_array($current_page, $pages_not_logged)) {
        header('Location: ../index.php');
        exit();
    }
}
