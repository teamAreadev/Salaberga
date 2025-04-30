<?php
require_once('../config/connect.php');


class main_model extends connect
{
    function __construct()
    {
        parent::__construct();
    }

    function cadastra($email, $senha)
    {
        session_start();
        $stmt_cadastro = $this->connect->prepare("SELECT * FROM usuario WHERE email = :email AND senha = :senha");
        $stmt_cadastro->bindValue(':email', $email);
        $stmt_cadastro->bindValue(':senha', $senha);
        $stmt_cadastro->execute();
        $result = $stmt_cadastro->fetch(PDO::FETCH_ASSOC);

        if (empty($result) && $result) {

            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            return 1;
        } else {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            return 2;
        }
    }
}
