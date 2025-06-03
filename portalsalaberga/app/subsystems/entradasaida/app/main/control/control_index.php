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


$controller = new LoginController();
echo $controller->handleLogin();

if (isset($_POST['cadastrar'])) {
    $id_turma = $_POST['id_turma'] ?? '';
    $matricula = $_POST['matricula'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $id_curso = $_POST['id_curso'] ?? '';
    $id_usuario = $_SESSION['id_usuario'] ?? null; // Obtém o id_usuario da sessão

    echo "Dados recebidos: id_turma=$id_turma, matricula=$matricula, nome=$nome, id_curso=$id_curso, id_usuario=$id_usuario<br>";
    $obj = new MainModel();
    echo "Chamando cadastrar...<br>";
    if ($obj->cadastrar($id_turma, $matricula, $nome, $id_curso, $id_usuario)) {
        echo "Cadastro bem-sucedido, redirecionando...<br>";
        header('Location: ../views/cadastrar.php?error=cadastro_concluido');
    } else {
        echo "Cadastro falhou, redirecionando...<br>";
        header('Location: ../views/cadastrar.php?error=cadastro_falhou');
    }
    exit();
}





//registro saida-estagio//

if (isset($_POST["Registrar"])) {
    $id_aluno = $_POST['id_aluno'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    $date_time = $data . ' ' . $hora . ':00';

    $obj = new MainModel();
    if ($obj->RegistroEstagio($id_aluno, $date_time)) {
        header('Location: ../views/saida_estagio_view.php?status=success');
    } else {
        header('Location: ../views/saida_estagio.php?status=error');
    }
    exit();
}



if (isset($_POST['action'])) {
    $opc = $_POST['action'];

    switch ($opc) {
        case "cadastrar":
            header('location:../views/cadastrar.php');
            break;

        case "entrada":
            header('location:../views/registro_entrada.php');
            break;

        case "saida":
            header('location:../views/registro_saida.php');
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



if (isset($_POST['saida'])) {
    $nome_responsavel = $_POST['nome_responsavel'];
    $nome_conducente = $_POST['nome_conducente'] ?? '';
    $id_tipo_conducente = !empty($_POST['id_tipo_conducente']) && is_numeric($_POST['id_tipo_conducente']) ? (int)$_POST['id_tipo_conducente'] : null;
    $id_tipo_responsavel = $_POST['id_tipo_responsavel'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $id_motivo = $_POST['id_motivo'];
    $id_usuario = $_POST['id_usuario'];
    $id_aluno = $_POST['id_aluno'];

    $date_time = $data . ' ' . $hora . ':00';

    if (!DateTime::createFromFormat(format: 'Y-m-d H:i:s', datetime: $date_time)) {
        echo "Formato de data e hora inválido!";
        exit;
    }

    $obj = new MainModel();
    if ($obj->registrarSaida(nome_responsavel: $nome_responsavel, nome_conducente: $nome_conducente, id_tipo_conducente: $id_tipo_conducente, id_tipo_responsavel: $id_tipo_responsavel, date_time: $date_time, id_motivo: $id_motivo, id_usuario: $id_usuario, id_aluno: $id_aluno)) {
        echo "Registro salvo com sucesso!";
    } else {
        echo "Falha ao salvar o registro.";
    }
    exit();
}

//print_r($_POST);



if (isset($_POST['entrada'])) {
    $nome_responsavel = $_POST['nome_responsavel'];
    $nome_conducente = $_POST['nome_conducente'] ?? '';
    $id_tipo_conducente = !empty($_POST['id_tipo_conducente']) && is_numeric($_POST['id_tipo_conducente']) ? (int)$_POST['id_tipo_conducente'] : null;
    $id_tipo_responsavel = $_POST['id_tipo_responsavel'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $id_motivo = $_POST['id_motivo'];
    $id_usuario = $_POST['id_usuario'];
    $id_aluno = $_POST['id_aluno'];

    $date_time = $data . ' ' . $hora . ':00';

    if (!DateTime::createFromFormat(format: 'Y-m-d H:i:s', datetime: $date_time)) {
        echo "Formato de data e hora inválido!";
        exit;
    }

    $obj = new MainModel();
    if ($obj->registrarEntrada(nome_responsavel: $nome_responsavel, nome_conducente: $nome_conducente, id_tipo_conducente: $id_tipo_conducente, id_tipo_responsavel: $id_tipo_responsavel, date_time: $date_time, id_motivo: $id_motivo, id_usuario: $id_usuario, id_aluno: $id_aluno)) {
        echo "Registro salvo com sucesso!";
    } else {
        echo "Falha ao salvar o registro.";
    }
    exit();
};



if (isset($_POST['GerarRelatorio']) && isset($_POST['tipo_relatorio'])) {
    $gerar_relatorio = $_POST['GerarRelatorio'];
    $tipoRelatorio = $_POST['tipo_relatorio'];
    $id_aluno = $_POST['id_aluno'] ?? 0;
    $id_turma = $_POST['Turma'] ?? 0;
    $ano = $_POST['Ano'] ?? 0;

    echo "<pre>";
    echo "Dados recebidos via POST:\n";
    var_dump($_POST);
    echo "</pre>";

    switch ($gerar_relatorio) {
        case 'por_aluno':
            header('location:../views/relatorios/aluno_individual.php?id_aluno=' . $id_aluno . '&tipo_relatorio=' . $tipoRelatorio);
            exit();
            break;

        case 'por_alunoEntrada':
            header('location:../views/relatorios/aluno_individualEntrada.php?id_aluno=' . $id_aluno . '&tipo_relatorio=' . $tipoRelatorio);
            exit();
            break;

        case 'por_alunoSaida':
            header('location:../views/relatorios/aluno_individualSaida.php?id_aluno=' . $id_aluno . '&tipo_relatorio=' . $tipoRelatorio);
            exit();
            break;

        case '3_ano_geral':
            header('location:../views/relatorios/ano_geral.php?id_aluno=' . $id_aluno . '&tipoRelatorio=' . $tipoRelatorio);
            exit();
            break;

        case 'ano_geralEntrada':
            if ($ano == 0) {
                echo "Erro: Selecione um ano válido!";
                exit();
            }
            header('location:../views/relatorios/ano_geralEntrada.php?ano=' . urlencode($ano) . '&tipo_relatorio=' . urlencode($tipoRelatorio));
            exit();
            break;

        case 'ano_geralSaida':
            if ($ano == 0) {
                echo "Erro: Selecione um ano válido!";
                exit();
            }
            header('location:../views/relatorios/ano_geralSaida.php?ano=' . urlencode($ano) . '&tipo_relatorio=' . urlencode($tipoRelatorio));
            exit();
            break;

        case 'por_turma':
            if ($id_turma == 0) {
                echo "Erro: Selecione uma turma válida!";
                exit();
            }
            header('location:../views/relatorios/por_turma.php?id_turma=' . urlencode($id_turma) . '&tipoRelatorio=' . urlencode($tipoRelatorio));
            exit();
            break;

        case 'por_turmaEntrada':
            if ($id_turma == 0) {
                echo "Erro: Selecione uma turma válida!";
                exit();
            }
            header('location:../views/relatorios/por_turmaEntrada.php?id_turma=' . urlencode($id_turma) . '&tipoRelatorio=' . urlencode($tipoRelatorio));
            exit();
            break;

        case 'por_turmaSaida':
            if ($id_turma == 0) {
                echo "Erro: Selecione uma turma válida!";
                exit();
            }
            header('location:../views/relatorios/por_turmaSaida.php?id_turma=' . urlencode($id_turma) . '&tipoRelatorio=' . urlencode($tipoRelatorio));
            exit();
            break;

        default:
            echo "Tipo de relatório inválido!";
            return;
    }
} else {
    echo "Selecione um tipo de relatório e clique em Gerar!";
}
exit();