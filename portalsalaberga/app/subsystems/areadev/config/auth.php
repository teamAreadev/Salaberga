<?php
session_start();

function verificarAutenticacao() {
    if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_tipo'])) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    // Verificar tempo de inatividade (30 minutos)
    if (isset($_SESSION['ultimo_acesso']) && (time() - $_SESSION['ultimo_acesso'] > 1800)) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    // Verificar se o IP e User Agent são os mesmos do login
    if (!isset($_SESSION['ip']) || !isset($_SESSION['user_agent']) ||
        $_SESSION['ip'] !== $_SERVER['REMOTE_ADDR'] ||
        $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    // Atualizar último acesso
    $_SESSION['ultimo_acesso'] = time();
}

function verificarAdmin() {
    verificarAutenticacao();
    if ($_SESSION['usuario_tipo'] !== 'admin') {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

function verificarUsuario() {
    verificarAutenticacao();
    if ($_SESSION['usuario_tipo'] === 'admin') {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
} 