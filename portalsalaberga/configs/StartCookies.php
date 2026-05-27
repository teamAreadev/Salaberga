<?php

class StartCookies
{
    public static function StartCookies()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'domain' => '',
                'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),     // só HTTPS
                'httponly' => true,   // JS não acessa
                'samesite' => 'Strict'
            ]);
            session_start();
            session_regenerate_id(true);

            if (
                isset($_SESSION['id']) &&
                ($_SESSION['ip'] !== $_SERVER['REMOTE_ADDR'] ||
                    $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT'])
            ) {

                session_unset();
                session_destroy();
                header("Location: ../index.php");
                exit;
            }
        }
    }
}
