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
    function cadastrar_empresa($nome, $endereco, $telefone, $perfis) {
        // Verificar se a empresa já existe
        $stmt_check = $this->connect->prepare("SELECT * FROM concedentes WHERE nome = :nome");
        $stmt_check->bindValue(':nome', $nome);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);
    
        if (empty($result)) {
            // Iniciar uma transação para garantir consistência
            $this->connect->beginTransaction();
    
            try {
                // Inserir a empresa na tabela concedentes
                $stmt_cadastrar_empresa = $this->connect->prepare("INSERT INTO concedentes (nome, contato, endereco) VALUES (:nome, :contato, :endereco)");
                $stmt_cadastrar_empresa->bindValue(':nome', $nome);
                $stmt_cadastrar_empresa->bindValue(':contato', $telefone);
                $stmt_cadastrar_empresa->bindValue(':endereco', $endereco);
                $stmt_cadastrar_empresa->execute();
    
                // Obter o ID da empresa recém-cadastrada
                $concedente_id = $this->connect->lastInsertId();
    
                // Inserir os perfis associados na tabela concedentes_perfis
                $stmt_cadastrar_perfil = $this->connect->prepare("INSERT INTO concedentes_perfis (concedente_id, perfil_id) VALUES (:concedente_id, :perfil_id)");
                foreach ($perfis as $perfil_id) {
                    $stmt_cadastrar_perfil->bindValue(':concedente_id', $concedente_id);
                    $stmt_cadastrar_perfil->bindValue(':perfil_id', $perfil_id);
                    $stmt_cadastrar_perfil->execute();
                }
    
                // Confirmar a transação
                $this->connect->commit();
                return 1; // Sucesso
            } catch (Exception $e) {
                // Reverter a transação em caso de erro
                $this->connect->rollBack();
                return 2; // Erro ao cadastrar
            }
        } else {
            return 3; // Empresa já existe
        }
    }
}
