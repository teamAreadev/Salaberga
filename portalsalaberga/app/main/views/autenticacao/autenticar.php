<?php


// Configurações de cache para evitar problemas de sessão
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Lista de páginas públicas que não precisam de autenticação
$public_pages = ['login.php', 'cadastro.php', 'recuperacaodesenha.php', 'login_parcial.php'];
$current_page = basename($_SERVER['PHP_SELF']);

// Se não estiver logado e tentar acessar páginas protegidas, redireciona para o login
if (!isset($_SESSION['login']) || !$_SESSION['login']) {
    if (!in_array($current_page, $public_pages)) {
        header('Location: login.php');
        exit();
    }
}
?> 