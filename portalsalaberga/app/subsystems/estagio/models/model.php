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
    function cadastrar_empresa($nome, $area, $endereco, $telefone)
    {

        $stmt_check = $this->connect->prepare("SELECT * FROM concedentes WHERE nome = :nome");
        $stmt_check->bindValue(':nome', $nome);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            $stmt_cadastrar_empresa = $this->connect->prepare("INSERT INTO concedentes VALUES(null,:nome, :contato,:endereco ,:perfil)");
            $stmt_cadastrar_empresa->bindValue(':nome', $nome);
            $stmt_cadastrar_empresa->bindValue(':contato', $telefone);
            $stmt_cadastrar_empresa->bindValue(':endereco', $endereco);
            $stmt_cadastrar_empresa->bindValue(':perfil', $area);
            $stmt_cadastrar_empresa->execute();

            if ($stmt_cadastrar_empresa) {
                return 1;
            } else {
                return 2;
            }
        } else {

            return 3;
        }
    }
}
