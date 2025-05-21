<?php

session_start();


class sessions
{
    function autenticar_session()
    {
        if (!$_SESSION['login']) {
            
            unset($_SESSION['login']);
            header('location:../autenticacao/login.php?login=erro');
            exit();
        }
        $logado = $_SESSION['login'];
    }
    function tempo_session($tempo)
    {
        if (isset($_SESSION['ultimo_acesso'])) {

            if (time() - $_SESSION['ultimo_acesso'] > $tempo) {

                session_unset();
                session_destroy();
                header('location:../autenticacao/login.php');
                exit();
            }
        }
        $_SESSION['ultimo_acesso'] = time();
    }
    function quebra_session()
    {
        session_unset();
        session_destroy();
        header('location:../autenticacao/login.php');
        exit();
    }
}