<?php
require_once('StartCookies.php');
class Sessions extends StartCookies
{
    private int $tempo = 3600;
    private string $url_login = '/Paroquia_digital/app/main/views/login.php';

    function __construct()
    {
        parent::StartCookies();
        $this->AutenticarSessao();
        $this->TempoSessao();
    }
    public function AutenticarSessao()
    {
        if (
            !isset($_SESSION['email']) ||
            !isset($_SESSION['nome']) ||
            !isset($_SESSION['id']) ||
            !isset($_SESSION['paroquias_id']) ||
            !isset($_SESSION['perfis_id']) ||
            !isset($_SESSION['cpf'])
        ) {

            $_SESSION['auth_error'] = 'true';
            header("location: {$this->url_login}");
            exit();
        }
        
    }
    public function TempoSessao()
    {
        if (isset($_SESSION['ultimo_acesso'])) {

            if (time() - $_SESSION['ultimo_acesso'] > $this->tempo) {

                $_SESSION['auth_error'] = 'true';
                header("location: {$this->url_login}");
                exit();
            }
        }
        $_SESSION['ultimo_acesso'] = time();
    }
    public function logout()
    {
        $_SESSION['auth_error'] = 'true';
        header("location: {$this->url_login}");
        exit();
    }
}
