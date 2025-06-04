<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function pre_cadastro($email, $cpf)
{
    require_once('../../config/Database.php');

    try {
        // NOTE: This function uses 'cpf' which is in the 'usuarios' table according to salaberga(1).sql.
        // Changed table name to 'usuarios'.
        $stmtSelect = "SELECT email, cpf FROM usuarios WHERE email = :email AND cpf = :cpf";
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
        // NOTE: This function uses 'cpf' and 'nome', which are in the 'usuarios' table according to salaberga(1).sql.
        // Changed table name to 'usuarios'.
        $querySelect = "SELECT id FROM usuarios WHERE email = :email AND cpf = :cpf";
        $stmtSelect = $conexao->prepare($querySelect);
        $stmtSelect->bindParam(':email', $email);
        $stmtSelect->bindParam(':cpf', $cpf);
        $stmtSelect->execute();
        $result = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($result)) {
            // Usuário já existe, realizar update da senha e nome
            // Changed table name to 'usuarios' and included 'nome' update.
            $queryUpdate = "
                UPDATE usuarios SET senha = MD5(:senha), nome = :nome WHERE email = :email AND (senha IS NULL OR senha = '')
            ";

            $stmtUpdate = $conexao->prepare($queryUpdate);
            $stmtUpdate->bindParam(':email', $email);
            $stmtUpdate->bindParam(':senha', $senha);
            $stmtUpdate->bindParam(':nome', $nome); // 'nome' is now in 'usuarios'
            $stmtUpdate->execute();

            // Verifica se a senha foi alterada
            if ($stmtUpdate->rowCount() > 0) {
                // Removed insertion into cliente table as nome is now in usuarios

                header('Location: ../../views/autenticacao/login.php');
                exit();
            } else {
                // usuário já existe ou senha já definida
                header('Location: ../../controllers/controller_cadastro/controller_cadastro.php?erro2');
                exit();
            }
        } else {
            // usuário não existe, insert new user
            // NOTE: Assuming you want to allow insertion if not found by email/cpf,
            // but the original logic seemed to only update existing entries.
            // This part might need clarification based on desired user creation flow.
            // For now, keeping the 'user not found' behavior as per original logic.
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
        $conexao = Database::getSalabergaConnection();

        // Prepara e executa a consulta para verificar o usuário na tabela 'usuarios'
        $querySelectUser = "SELECT id, email, nome, senha FROM usuarios WHERE email = :email";
        $stmtSelectUser = $conexao->prepare($querySelectUser);
        $stmtSelectUser->bindParam(':email', $email);
        $stmtSelectUser->execute();
        $user = $stmtSelectUser->fetch(PDO::FETCH_ASSOC);

        $login_successful = false;

        if (!empty($user)) {
            // Verifica se a senha corresponde usando bcrypt (para senhas já migradas)
            if (password_verify($senha, $user['senha'])) {
                $login_successful = true;
            } else {
                // Se não corresponder com bcrypt, verifica se é uma senha MD5 antiga
                // MD5 hashes são tipicamente 32 caracteres hexadecimais
                if (strlen($user['senha']) === 32 && ctype_xdigit($user['senha'])) {
                    if (md5($senha) === $user['senha']) {
                        $login_successful = true;
                        // Senha MD5 correta, agora faça a migração para bcrypt
                        $new_senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                        $update_query = "UPDATE usuarios SET senha = :new_senha WHERE id = :userId";
                        $update_stmt = $conexao->prepare($update_query);
                        $update_stmt->bindParam(':new_senha', $new_senha_hash);
                        $update_stmt->bindParam(':userId', $user['id']);
                        $update_stmt->execute();
                        error_log("Senha MD5 migrada para bcrypt para o usuário: " . $email);
                    }
                }
            }
        }

        if ($login_successful) {
            // Login bem sucedido, busca sistemas e permissões para este usuário
            $queryUserSystemsPermissions = "
                SELECT
                    s.id AS sistema_id,
                    s.sistema AS sistema_nome,
                    p.id AS permissao_id,
                    p.descricao AS permissao_descricao
                FROM
                    usuarios u
                LEFT JOIN
                    usu_sist us ON u.id = us.usuario_id
                LEFT JOIN
                    sist_perm sp ON us.sist_perm_id = sp.id
                LEFT JOIN
                    sistemas s ON sp.sistema_id = s.id
                LEFT JOIN
                    permissoes p ON sp.permissao_id = p.id
                WHERE
                    u.id = :userId
            ";

            $stmtUserSystemsPermissions = $conexao->prepare($queryUserSystemsPermissions);
            $stmtUserSystemsPermissions->bindParam(':userId', $user['id']);
            $stmtUserSystemsPermissions->execute();
            $userSystemsPermissions = $stmtUserSystemsPermissions->fetchAll(PDO::FETCH_ASSOC);

            // Armazena dados relevantes do usuário e sistemas/permissões na sessão
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id']; // Armazena o ID do usuário na sessão
            $_SESSION['Email'] = $user['email'];
            $_SESSION['Senha'] = str_repeat('•', strlen($senha)); // Evitar armazenar senha real
            $_SESSION['Nome'] = $user['nome'];
            $_SESSION['user_systems_permissions'] = $userSystemsPermissions;

            return true;
        } else {
            error_log("Tentativa de login falhou para o email: " . $email);
            return false;
        }

    } catch (PDOException $e) {
        error_log("Erro no banco de dados durante login: " . $e->getMessage());
        return false;
    }
}

function login_parcial($email, $senha)
{
    error_log("Debug: login_parcial function called.");
    try {
        // Conexão direta com o banco de dados login_parcial
        $conexao = new PDO("mysql:host=localhost;dbname=login_parcial", "root", "");
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        error_log("Debug: Database connection successful in login_parcial.");

        // Prepara e executa a consulta para verificar o usuário na tabela 'usuarios'
        $querySelectUser = "SELECT id, email, senha, equipe FROM usuarios WHERE email = :email AND senha = :senha";
        $stmtSelectUser = $conexao->prepare($querySelectUser);
        $stmtSelectUser->bindParam(':email', $email);
        $stmtSelectUser->bindParam(':senha', $senha);
        $stmtSelectUser->execute();
        $user = $stmtSelectUser->fetch(PDO::FETCH_ASSOC);

        error_log("Debug: User query executed in login_parcial.");

        if (!empty($user)) {
            error_log("Debug: User found in login_parcial. User ID: " . $user['id'] . ", Equipe: " . $user['equipe']);
            // Armazena dados relevantes do usuário e sistemas/permissões na sessão
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id']; // Armazena o ID do usuário na sessão
            $_SESSION['Email'] = $user['email'];
            $_SESSION['Senha'] = str_repeat('•', strlen($senha)); // Evitar armazenar senha real
            $_SESSION['equipe'] = $user['equipe'];
            error_log("Debug: Session variables set in login_parcial.");
            return true;
        } else {
            error_log("Debug: User not found or password incorrect in login_parcial.");
            return false;
        }

    } catch (PDOException $e) {
        error_log("Erro no banco de dados durante login_parcial: " . $e->getMessage());
        return false;
    }
}

function recSenha($email)
{
    require_once('../../config/Database.php');
    try {
        // Uses 'email', which is in the 'usuarios' table in salaberga(1).sql.
        $querySelect = "SELECT email FROM usuarios WHERE email = :email";
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

                //corpo email - UPDATE THIS URL TO YOUR ACTUAL RECSENHA PAGE
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
                // NOTE: mail() function requires proper server configuration.
                if (mail($destino, $assunto, $arquivo, $headers)) {
                    header('location:../controller_recsenha/controller_recSenha.php?certo');
                    exit(); // Added exit after header
                } else {
                     // Handle mail sending failure
                     error_log("Erro ao enviar email de recuperação para: " . $email);
                     header('location:../controller_recsenha/controller_recSenha.php?erro_envio');
                     exit(); // Added exit after header
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
        // NOTE: This function uses 'telefone', which is NOT in the 'usuarios' table according to salaberga(1).sql.
        // This function will likely fail unless 'telefone' is added to 'usuarios' or handled elsewhere.
        // Original logic kept for now, assuming 'telefone' might be added to 'usuarios'.
        $querySelect = "SELECT id FROM usuarios WHERE email = :email";
        $stmtSelect = $conexao->prepare($querySelect);
        $stmtSelect->bindParam(':email', $_SESSION['Email']);
        $stmtSelect->execute();
        $resultSelect = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if (!empty($resultSelect)) {
            $queryUpdate = "UPDATE usuarios SET telefone = :telefone WHERE id = :id"; // Assumes 'telefone' is in 'usuarios'
            $stmtUpdate = $conexao->prepare($queryUpdate);
            $stmtUpdate->bindParam(':id', $resultSelect['id']);
            $stmtUpdate->bindParam(':telefone', $telefone);
            $stmtUpdate->execute();
            header('Location: ../controller_perfil/controller_telefone.php?alt');
            exit(); // Added exit after header
        } else {
             // User not found or not logged in properly
             header('Location: ../controller_perfil/controller_telefone.php?erro_user');
             exit();
        }
    } catch (PDOException $e) {
        error_log("Erro no banco de dados: " . $e->getMessage());
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}

function alterarSenha($novaSenha, $confSenha, $senhaAntiga) {
    try {
        require_once('../../config/Database.php');

        // Busca a senha criptografada na tabela 'usuarios'
        $querySelect = "SELECT id, senha FROM usuarios WHERE email = :email";
        $stmtSelect = $conexao->prepare($querySelect);
        $stmtSelect->bindParam(':email', $_SESSION['Email']); // Assuming email is in session
        $stmtSelect->execute();
        $resultSelect = $stmtSelect->fetch(PDO::FETCH_ASSOC);

         if (empty($resultSelect)) {
            return 'erro=user_not_found'; // User not found
         }

        // Verifica se as novas senhas coincidem
        if ($confSenha != $novaSenha) {
            return 'erro=1'; // Nova senha e confirmação não coincidem
        }

        // Verifica se a senha antiga está correta (comparando MD5)
        if (MD5($senhaAntiga) != $resultSelect['senha']) {
            return 'erro=2'; // Senha antiga incorreta
        }

        // Se chegou aqui, atualiza a senha na tabela 'usuarios'
        $queryUpdate = "UPDATE usuarios SET senha = md5(:novaSenha) WHERE id = :id";
        $stmtUpdate = $conexao->prepare($queryUpdate);
        $stmtUpdate->bindParam(':novaSenha', $novaSenha);
        $stmtUpdate->bindParam(':id', $resultSelect['id']);
        $stmtUpdate->execute();

        return 'sucesso=1';

    } catch (PDOException $e) {
        error_log("Erro no banco de dados: " . $e->getMessage());
        // Changed redirect location to profile page with error
        header('Location: ../../views/autenticacao/perfil.php?erro=3&msg=' . urlencode($e->getMessage()));
        exit();
    }
}

function alterarEmail($email,$senha)
{
    try {
        require_once('../../config/Database.php');

        // Busca o usuário pela senha e email da sessão para verificação na tabela 'usuarios'
        $querySelect = "SELECT id, email FROM usuarios where senha = MD5(:senha) AND email = :emailAtual";
        $stmtSelect = $conexao->prepare($querySelect);
        $stmtSelect->bindParam(':senha', $senha);
        $stmtSelect->bindParam(':emailAtual', $_SESSION['Email']);
        $stmtSelect->execute();
        $resultSelect = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        // Verify if the user is found and password matches
        if (empty($resultSelect)) {
             return 'erro=2'; // Incorrect password or user not found with current email and password
        }

        // Password is correct and matches the session user, update with the new email.
        $queryUpdate = "UPDATE usuarios SET email = :emailNovo WHERE id = :id";
        $stmtUpdate = $conexao->prepare($queryUpdate);
        $stmtUpdate->bindParam(':emailNovo', $email);
        $stmtUpdate->bindParam(':id', $resultSelect['id']); // Use id from the select result
        $stmtUpdate->execute();

        // Update the email in the session as well
        $_SESSION['Email'] = $email;

        return $resultado = 'sucesso=1';
    } catch (PDOException $e) {
        error_log("Erro no banco de dados: " . $e->getMessage());
        // Changed redirect location to profile page with error
        header('Location: ../../views/autenticacao/perfil.php?erro=3&msg=' . urlencode($e->getMessage()));
        exit();
    }
}

function getAlunosByEquipe($id_equipe)
{
    error_log("Debug: getAlunosByEquipe called with equipe ID: " . $id_equipe);
    try {
        // Conexão direta com o banco de dados login_parcial
        $conexao = new PDO("mysql:host=localhost;dbname=login_parcial", "root", "");
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        error_log("Debug: Database connection successful in getAlunosByEquipe.");

        // Prepara e executa a consulta para verificar os alunos na tabela 'aluno' pela equipe
        $querySelectAlunos = "SELECT id, nome FROM aluno WHERE equipe = :id_equipe";
        $stmtSelectAlunos = $conexao->prepare($querySelectAlunos);
        $stmtSelectAlunos->bindParam(':id_equipe', $id_equipe);
        $stmtSelectAlunos->execute();
        $alunos = $stmtSelectAlunos->fetchAll(PDO::FETCH_ASSOC);

        error_log("Debug: getAlunosByEquipe query executed. Found " . count($alunos) . " alunos.");
        error_log("Debug: getAlunosByEquipe results: " . print_r($alunos, true));

        return $alunos;

    } catch (PDOException $e) {
        error_log("Erro no banco de dados ao buscar alunos por equipe (getAlunosByEquipe): " . $e->getMessage());
        return []; // Retorna um array vazio em caso de erro
    }
}

// Nova função para obter o nome da equipe
function getEquipeNome($id_equipe)
{
    try {
        // Conexão direta com o banco de dados login_parcial
        $conexao = new PDO("mysql:host=localhost;dbname=login_parcial", "root", "");
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara e executa a consulta para buscar o nome da equipe
        $querySelectEquipe = "SELECT nome FROM equipes WHERE id = :id_equipe LIMIT 1";
        $stmtSelectEquipe = $conexao->prepare($querySelectEquipe);
        $stmtSelectEquipe->bindParam(':id_equipe', $id_equipe);
        $stmtSelectEquipe->execute();
        $equipe = $stmtSelectEquipe->fetch(PDO::FETCH_ASSOC);

        return $equipe ? $equipe['nome'] : 'Nome da Equipe não encontrado';

    } catch (PDOException $e) {
        error_log("Erro no banco de dados ao buscar nome da equipe (getEquipeNome): " . $e->getMessage());
        return 'Erro ao carregar nome da Equipe'; // Retorna mensagem de erro em caso de falha
    }
}
