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
    function cadastrar_empresa($nome, $endereco, $telefone, $perfis)
    {
        // Verificar se a empresa já existe
        $stmt_check = $this->connect->prepare("SELECT * FROM concedentes WHERE nome = :nome");
        $stmt_check->bindValue(':nome', $nome);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            // Iniciar uma transação para garantir consistência


            try {
                // Inserir a empresa na tabela concedentes
                $stmt_cadastrar_empresa = $this->connect->prepare("INSERT INTO concedentes (nome, contato, endereco) VALUES (:nome, :contato, :endereco)");
                $stmt_cadastrar_empresa->bindValue(':nome', $nome);
                $stmt_cadastrar_empresa->bindValue(':contato', $telefone);
                $stmt_cadastrar_empresa->bindValue(':endereco', $endereco);
                $test = $stmt_cadastrar_empresa->execute();
                $stmt_result = $stmt_cadastrar_empresa->fetch(PDO::FETCH_ASSOC);

                $stmt_selecionar_perfil = $this->connect->prepare("SELECT * FROM PERFIS");
                $test = $stmt_selecionar_perfil->execute();
                $perfil_id = $stmt_selecionar_perfil->fetchAll(PDO::FETCH_ASSOC);

                // Obter o ID da empresa recém-cadastrada
                $concedente_id = $this->connect->lastInsertId();
                $perfis_banco = $perfil_id;
                echo 'oi';

                // Inserir os perfis associados na tabela concedentes_perfis
                // Inserção dos perfis válidos
                if (!empty($perfis)) {
                    $stmt_cadastrar_perfil = $this->connect->prepare("INSERT INTO concedentes_perfis (concedente_id, perfil_id) VALUES (:concedente_id, :perfil_id)");
                    $tamanho_perfis = count($perfis);

                    for ($i = 0; $i < $tamanho_perfis; $i++) {
                        $stmt_cadastrar_perfil->bindValue(':concedente_id', $concedente_id);
                        $stmt_cadastrar_perfil->bindValue(':perfil_id', $perfis[$i]);
                        if ($stmt_cadastrar_perfil->execute()) {
                            // Opcional: Buscar o nome do perfil para exibir na mensagem
                            $nome_perfil = array_column($perfis_banco, 'nome_perfil', 'id')[$perfis[$i]];
                            echo "Perfil ID {$perfis[$i]} ($nome_perfil) associado à empresa ID $concedente_id com sucesso!<br>";
                        } else {
                            echo "Erro ao associar perfil ID {$perfis[$i]} à empresa ID $concedente_id.<br>";
                        }
                    }
                } else {
                    echo "Nenhum perfil válido para cadastrar.<br>";
                }

                // Confirmar a transação

                return 1; // Sucesso

            } catch (Exception $e) {
                // Reverter a transação em caso de erro
                return 2; // Erro ao cadastrar
            }
        } else {
            return 3; // Empresa já existe
        }
    }
}
