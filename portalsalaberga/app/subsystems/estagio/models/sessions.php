<?php
session_start();

class sessions
{

    function autenticar_session()
    {
        if (!isset($_SESSION['email'])) {

            session_unset();
            session_destroy();
            header('location:../views/login.php');
            exit();
        }
        return $_SESSION['email'];
    }
    function tempo_session()
    {
        $tempo = 600;
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
