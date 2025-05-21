<?php

session_start();


class sessions
{
    function autenticar_session()
    {
        if (!isset($_SESSION['Email']) == true && !isset($_SESSION['Senha']) == true) {
            
            unset($_SESSION['Email']);
            unset($_SESSION['Senha']);
            header('location:../autenticacao/login.php');
            exit();
        }
        $logado = $_SESSION['Email'];
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