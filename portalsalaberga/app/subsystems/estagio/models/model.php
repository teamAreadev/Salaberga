<?php
require_once('../config/connect.php');


class main_model extends connect
{
    function __construct()
    {
        parent::__construct();
    }

    function login($email, $senha)
    {
        session_start();
        $stmt_cadastro = $this->connect->prepare("SELECT * FROM usuario WHERE email = :email AND senha = :senha");
        $stmt_cadastro->bindValue(':email', $email);
        $stmt_cadastro->bindValue(':senha', $senha);
        $stmt_cadastro->execute();

        if ($stmt_cadastro->rowCount() > 0) {

            $_SESSION['email'] = $email;
            return 1;
        } else {

            unset($_SESSION['email']);
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
                // Cadastrar nova empresa
                $stmt_cadastrar_empresa = $this->connect->prepare("INSERT INTO concedentes (nome, contato, endereco) VALUES (:nome, :contato, :endereco)");
                $stmt_cadastrar_empresa->bindValue(':nome', $nome);
                $stmt_cadastrar_empresa->bindValue(':contato', $telefone);
                $stmt_cadastrar_empresa->bindValue(':endereco', $endereco);
                $stmt_cadastrar_empresa->execute();

                // Obter o ID da empresa recém-cadastrada
                $concedente_id = $this->connect->lastInsertId();

                // Selecionar todos os perfis do banco (opcional, se quiser ter os nomes à mão)
                $stmt_selecionar_perfil = $this->connect->prepare("SELECT id, nome_perfil FROM perfis");
                $stmt_selecionar_perfil->execute();
                $perfis_banco = $stmt_selecionar_perfil->fetchAll(PDO::FETCH_ASSOC);

                // Preparar o statement para cadastrar associação empresa-perfil
                $stmt_cadastrar_perfil = $this->connect->prepare("INSERT INTO concedentes_perfis (concedente_id, perfil_id) VALUES (:concedente_id, :perfil_id)");

                // Verificar se há perfis enviados
                if (!empty($perfis)) {
                    foreach ($perfis as $nome_perfil) {
                        // Buscar o ID do perfil com base no nome
                        $stmt_buscar_id = $this->connect->prepare("SELECT id FROM perfis WHERE nome_perfil = :nome_perfil");
                        $stmt_buscar_id->bindValue(':nome_perfil', $nome_perfil);
                        $stmt_buscar_id->execute();
                        $resultado = $stmt_buscar_id->fetch(PDO::FETCH_ASSOC);

                        if ($resultado) {
                            $perfil_id = $resultado['id'];

                            $stmt_cadastrar_perfil->bindValue(':concedente_id', $concedente_id, PDO::PARAM_INT);
                            $stmt_cadastrar_perfil->bindValue(':perfil_id', $perfil_id, PDO::PARAM_INT);

                            if ($stmt_cadastrar_perfil->execute()) {
                                echo "Perfil '{$nome_perfil}' (ID {$perfil_id}) associado à empresa ID {$concedente_id} com sucesso!<br>";
                            } else {
                                echo "Erro ao associar perfil '{$nome_perfil}' à empresa ID {$concedente_id}.<br>";
                            }
                        } else {
                            echo "Perfil '{$nome_perfil}' não encontrado na tabela perfis.<br>";
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
    function cadastrar_vaga($nome, $id_empresa, $id_area, $quantidade)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM vagas WHERE nome_vaga = :nome");
        $stmt_check->bindValue(':nome', $nome);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {

            echo $id_empresa;
            $stmt_cadastrar_vagas = $this->connect->prepare("INSERT INTO vagas VALUES (null,:nome_vaga, :id_concedente, :id_perfil, :quantidade)");
            $stmt_cadastrar_vagas->bindValue(':nome_vaga', $nome);
            $stmt_cadastrar_vagas->bindValue(':id_perfil', $id_area);
            $stmt_cadastrar_vagas->bindValue(':id_concedente', $id_empresa);
            $stmt_cadastrar_vagas->bindValue(':quantidade', $quantidade);
            $stmt_cadastrar_vagas->execute();

            if($stmt_cadastrar_vagas){

                return 1;
            }else{

                return 2;
            }
        } else {

            return 3;
        }
    }

    function selecao($alunos, id_vaga){

        foreach($alunos as $aluno){

            $stmt = $this->connect->query("INSERT INTO selecao VALUES(null, '$aluno', '$id_vaga', DEFAULT)");

            
        }
        if($stmt){

            return 1;
        }{

            return 2;
        }
    }
}
