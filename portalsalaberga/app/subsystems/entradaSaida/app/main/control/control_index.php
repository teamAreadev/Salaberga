<?php


require_once '../model/model_indexClass.php';

class LoginController
{
    private $auth;

    public function __construct()
    {
        $this->auth = new UserAuth();
    }

    public function handleLogin()
    {
        // Verifica se o formulário foi enviado
        if (isset($_POST["btn"]) && $_POST["btn"] == "on") {



            if (empty($_POST['email']) || empty($_POST['password'])) {
                return "Erro: Email e senha são obrigatórios.";
            }
            $email = $_POST['email'];
            $password = $_POST['password'];

            try {
                // Chama o método login
                if ($this->auth->login($email, $password)) {
                    header('Location: ../views/inicio.php');
                } else {
                    header('Location: ../index.php?login=1');
                }
            } catch (Exception $e) {
                return "Erro ao realizar login: " . $e->getMessage();
            }
        }
    }
}

// Uso do controlador
$controller = new LoginController();
echo $controller->handleLogin();





//  ######            ######
//   ##  ##           ##  ##
//   ##  ##               ##
//   #####               ##
//   ## ##              ##
//   ##  ##             ##
//  #### ##             ##
//meu codigo é daqui pra cima :))


// <----------------------- retirem o comentario e finalizem a função ----------------------->


// Verifica se é POST

/*
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Erro: Use o método POST.");
}
if (!isset($_POST['Nome']) || trim($_POST['Nome']) === '' && !isset($_POST['Turma']) || trim($_POST['Turma']) === '' && !isset($_POST['Curso']) || trim($_POST['Curso']) === '' && !isset($_POST['Matrícula']) || trim($_POST['Matrícula']) === '') {

    // Atribui os valores a variáveis
    $nome = $_POST['Nome'];
    $turma = $_POST['Turma'];
    $curso = $_POST['Curso'];
    $matricula = $_POST['Matrícula'];
    
    require_once('model/model.indexClass.php');
    cadastrar($nome, $turma,$curso,$matricula);

} else {
    ("Erro: Todos os campos são obrigatórios e não pode estar vazios.");
}
*/
if (isset($_POST["btn"]) && $_POST["btn"] == "on") {

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_aluno = $_POST['id_aluno']; // ID do aluno vindo do formulário
    $data = $_POST['data']; // Ex.: 2025-04-30
    $hora = $_POST['hora']; // Ex.: 14:30

    // Combina data e hora no formato DATETIME
    $date_time = $data . ' ' . $hora . ':00'; // Ex.: 2025-04-30 14:30:00

    // Instancia a classe e chama a função
    $obj = new RegistroAluno(); // Substitua por sua classe
    if ($obj->registrarSaida($id_aluno, $date_time)) {
        echo "Registro salvo com sucesso!";
    } else {
        echo "Falha ao salvar o registro.";
    }
}
}



if (isset($_POST['action'])) {
    $opc = $_POST['action'];

    switch ($opc) {
        case "cadastrar":
            header('location:../views/cadastrar.php');
            break;

        case "entrada":
            header('location:../views/entrada_saida.php');
            break;

        case "saida":
            header('location:../views/entrada_saida.php');
            break;
            
        case "saida_estagio":
            header('location:../views/saida_Estagio.php');
            break;
            
        case "relatorios":
            header('location:../views/relatorio.php');
            break;
    }

};

    if (isset($_POST['btn'])) {
        $opc = $_POST['btn'];
    
        switch ($opc) {
            case "Entrada":
                header('location:../views/relatorioEntrada.php');
                break;
    
            case "Saída":
                header('location:../views/relatorioSaida.php');
                break;
    
            case "Saída-Estágio":
                header('location:../views/relatorioSaida_Estagio.php');
                break;


            }

    }
    



