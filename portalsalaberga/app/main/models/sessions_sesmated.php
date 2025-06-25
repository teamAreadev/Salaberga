<?php
class sessions
{
    function autenticar_session()
    {
        if (!$_SESSION['login']) {

            session_unset();
            session_destroy();
            header('location:../autenticacao/login_sesmated.php?login=erro');
            exit();
        }
    }
    function tempo_session($tempo)
    {
        if (isset($_SESSION['ultimo_acesso'])) {

            if (time() - $_SESSION['ultimo_acesso'] > $tempo) {

                session_unset();
                session_destroy();
                header('location:../autenticacao/loginlogin_sesmated.php');
                exit();
            }
        }
        $_SESSION['ultimo_acesso'] = time();
    }
    function quebra_session()
    {
        session_unset();
        session_destroy();
        header('location:../autenticacao/loginlogin_sesmated.php');
        exit();
    }
}
