<?php
session_start();

class sessions
{

    function autenticar_session()
    {
        if (!isset($_SESSION['email']) == true && !isset($_SESSION['senha']) == true) {

            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('location:../views/login.php');
            exit();
        }
        $logado = $_SESSION['email'];
    }
    function tempo_session($tempo)
    {
        if (isset($_SESSION['ultimo_acesso'])) {

            if (time() - $_SESSION['ultimo_acesso'] > $tempo) {

                session_unset();
                session_destroy();
                header('location:../views/login.php');
                exit();
            }
        }
        $_SESSION['ultimo_acesso'] = time();
    }
    function quebra_session()
    {
        session_unset();
        session_destroy();
        header('location:../views/login.php');
        exit();
    }
}
