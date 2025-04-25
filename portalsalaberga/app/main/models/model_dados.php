<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

function pre_cadastro($email, $cpf)
{

    require_once('../../config/Database.php');

    try {
        // Usando prepared statements para prevenir SQL injection
        $stmtSelect = "SELECT email, cpf FROM usuario WHERE email = :email AND cpf = :cpf";
        $stmt = $conexao->prepare($stmtSelect);

        // Bind dos valores
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cpf', $cpf);

        // Executa a consulta
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($dados)) {
            //se os dados tiverem corretos 
            $_SESSION['precadastro'] = true;
            header('location:../controller_cadastro/controller_pre_cadastro.php?certo');
            exit();
        } else {
            //se os dados n estiverem corretos
            header('location:../controller_cadastro/controller_pre_cadastro.php?erro');
            exit();
        }
    } catch (PDOException $e) {
        error_log("Erro no banco de dados: " . $e->getMessage());
        echo "Ocorreu um erro ao processar sua solicitação.";
    }
}


function cadastrar($nome, $cpf, $email, $senha)
{
    require_once('../../config/Database.php');


    try {
        // Primeiro, fazer o SELECT para verificar
        $querySelect = "SELECT id FROM usuario WHERE email = :email AND cpf = :cpf";
        $stmtSelect = $conexao->prepare($querySelect);
        $stmtSelect->bindParam(':email', $email);
        $stmtSelect->bindParam(':cpf', $cpf);
        $stmtSelect->execute();
        $result = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($result)) {
            // Usuário já existe, realizar update da senha
            $queryUpdate = "
                UPDATE usuario SET senha = MD5(:senha) WHERE email = :email AND (senha IS NULL)
            ";

            $stmtUpdate = $conexao->prepare($queryUpdate);
            $stmtUpdate->bindParam(':email', $email);
            $stmtUpdate->bindParam(':senha', $senha);
            $stmtUpdate->execute();
            $resul1t = $stmtUpdate->fetchAll(PDO::FETCH_ASSOC);


            // Verifica se a senha foi alterada
            if ($stmtUpdate->rowCount() > 0) {
                // Inserir o cliente associado ao usuário
                $queryInsert = "
                    INSERT INTO cliente (nome, id_usuario)
                    VALUES (:nome, :id_usuario)
                ";

                $stmtInsert = $conexao->prepare($queryInsert);
                $stmtInsert->bindParam(':nome', $nome);
                $stmtInsert->bindParam(':id_usuario', $result[0]['id']);
                $stmtInsert->execute();

                header('Location: ../../views/autenticacao/login.php');
                exit();
            } else {
                // usuário já existe
                header('Location: ../../controllers/controller_cadastro/controller_cadastro.php?erro2');
                exit();
            }
        } else {
            // usuário não existe
            header('Location: ../../controllers/controller_cadastro/controller_cadastro.php?erro1');
            exit();
        }
    } catch (PDOException $e) {
        error_log("Erro no banco de dados: " . $e->getMessage());
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}



function login($email, $senha)
{
    require_once('../../config/Database.php');
    try {
        // Prepara e executa a consulta para verificar o usuário
        $querySelect = "SELECT id, email, senha, tipo FROM usuario WHERE email = :email AND senha = MD5(:senha)";
        $stmtSelect = $conexao->prepare($querySelect);
        $stmtSelect->bindParam(':email', $email);
        $stmtSelect->bindParam(':senha', $senha);
        $stmtSelect->execute();
        $result = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            // Consulta para obter informações adicionais do cliente
            $querySelectC = "SELECT telefone, nome FROM cliente WHERE id_usuario = :id_usuario";
            $stmtSelectC = $conexao->prepare($querySelectC);
            $stmtSelectC->bindParam(':id_usuario', $result['id']);
            $stmtSelectC->execute();
            $resultC = $stmtSelectC->fetch(PDO::FETCH_ASSOC);

            function mascararSenha($senha)
            {
                return str_repeat('•', strlen($senha));
            }

            // Configura as variáveis de sessão
            $_SESSION['login'] = true;
            $_SESSION['Email'] = $email;
            $_SESSION['Senha'] = mascararSenha($senha);
            $_SESSION['Telefone'] = $resultC['telefone'];
            $_SESSION['Nome'] = $resultC['nome'];


            // Redireciona com base no tipo de usuário
            switch ($result['tipo']) {
                case 'aluno':
                    $_SESSION['status'] = 0;
                    return 0;
                    break;
                case 'professor':
                    $_SESSION['status'] = 1;
                    return 1;
                    break;
                case 'adm':
                    $_SESSION['status'] = 2;
                    return 2;
                    break;
                case 'egresso':
                    $_SESSION['status'] = 3;
                    return 3;
                    break;
                default:
                    # code...
                    break;
            }
            exit();
        } else {
            return 4;
        }
    } catch (PDOException $e) {
        error_log("Erro no banco de dados: " . $e->getMessage());
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}

function recSenha($email)
{
    require_once('../../config/Database.php');
    try {

        // Primeiro, fazer o SELECT para verificar
        $querySelect = "SELECT email FROM usuario WHERE email = :email";
        $stmtSelect = $conexao->prepare($querySelect);
        $stmtSelect->bindParam(':email', $email);
        $stmtSelect->execute();
        $result = $stmtSelect->fetch(PDO::FETCH_ASSOC);



        if (!empty($result)) {
            if (!isset($_SESSION['recsenha']) || $_SESSION['recsenha'] === false) {

                //variaveis
                $nome = 'Salaberga.com';
                $data_envio = date('d/m/Y');
                $hora_envio = date('H:i:s');

                //corpo email
                $arquivo = "
                Acesse o link abaixo para fazer a alteração da senha:
                http://localhost/escola%20projetos/Salaberga/portalsalaberga/app/main/views/autentica%C3%A7%C3%A3o/alteraSenha.php
                Email enviado por $nome, no dia $data_envio às $hora_envio horas.
                ";

                //emails para quem será enviado o formulário
                $destino = $email;
                $assunto = "Recuperação de senha.";

                //este sempre devera existir para garantir a exibição correta dos caracteres

                $headers = "MIME-Version: 1.0\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\n";
                $headers .= "From: $nome <$email>";

                //enviar

                if (mail($destino, $assunto, $arquivo, $headers)) {

                    header('location:../controller_recsenha/controller_recSenha.php?certo');
                }
            } else {
                //usuario recuperou a senha recentemente
                header('Location: ../../controllers/controller_recsenha/controller_recSenha.php?login=erro');
                exit();
            }
        } else {
            //usuário não cadastrado
            header('Location: ../../controllers/controller_recsenha/controller_recSenha.php?login=erro1');
            exit();
        }
    } catch (PDOException $e) {
        error_log("Erro no banco de dados: " . $e->getMessage());
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}

function alterarTelefone($telefone)
{

    require_once('../../config/Database.php');
    try {

        $querySelect = "SELECT id FROM usuario WHERE email = :email";
        $stmtSelect = $conexao->prepare($querySelect);
        $stmtSelect->bindParam(':email', $_SESSION['Email']);
        $stmtSelect->execute();
        $resultSelect = $stmtSelect->fetch(PDO::FETCH_ASSOC);


        if (!empty($resultSelect)) {

            $queryUpdate = "
        UPDATE cliente SET telefone = :telefone WHERE id_usuario = :id 
";

            $stmtUpdate = $conexao->prepare($queryUpdate);
            $stmtUpdate->bindParam(':id', $resultSelect['id']);
            $stmtUpdate->bindParam(':telefone', $telefone);
            $stmtUpdate->execute();
            $resultUpdate = $stmtUpdate->fetchAll(PDO::FETCH_ASSOC);
            header('Location: ../controller_perfil/controller_telefone.php?alt');
        }
    } catch (PDOException $e) {
        error_log("Erro no banco de dados: " . $e->getMessage());
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}

function alterarSenha($novaSenha, $confSenha, $senhaAntiga) {
    try {
        require_once('../../config/Database.php');

        // Busca a senha criptografada
        $querySelect = "SELECT id, senha FROM usuario";
        $stmtSelect = $conexao->prepare($querySelect);
        $stmtSelect->execute();
        $resultSelect = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        // Verifica se as novas senhas coincidem
        if ($confSenha != $novaSenha) {
            return 'erro=1'; // Nova senha e confirmação não coincidem
        }

        // Verifica se a senha antiga está correta
        if ($senhaAntiga != $resultSelect['senha']) {
            return 'erro=2'; // Senha antiga incorreta
        }

        // Se chegou aqui, atualiza a senha
        $queryUpdate = "UPDATE usuario SET senha = md5(:novaSenha) WHERE id = :id";
        $stmtUpdate = $conexao->prepare($queryUpdate);
        $stmtUpdate->bindParam(':novaSenha', $novaSenha);
        $stmtUpdate->bindParam(':id', $resultSelect['id']);
        $stmtUpdate->execute();

        return 'sucesso=1';

    } catch (PDOException $e) {
        header('Location: ../../views/autenticacao/perfil.php?erro=3&msg=' . urlencode($e->getMessage()));
        exit();
    }
}

function alterarEmail($email,$senha)
{
    try {

        require_once('../../config/Database.php');

        // Busca a senha criptografada
        $querySelect = "SELECT id, email FROM usuario where senha = :senha";
        $stmtSelect = $conexao->prepare($querySelect);
        $stmtSelect->bindParam(':senha', $senha);
        $stmtSelect->execute();
        $resultSelect = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        // Senha antiga correta, atualiza com a nova senha criptografada
        $queryUpdate = "UPDATE usuario SET email = :emailNovo WHERE email = :emailAntigo";
        $stmtUpdate = $conexao->prepare($queryUpdate);
        $stmtUpdate->bindParam(':emailNovo', $email);
        $stmtUpdate->bindParam(':emailAntigo', $_SESSION['Email']);
        $stmtUpdate->execute();

        return $resultado = 'sucesso=1';
    } catch (PDOException $e) {
        header('Location: ../../views/autenticacao/perfil.php?erro=3&msg=' . urlencode($e->getMessage()));
        exit();
    }
}
