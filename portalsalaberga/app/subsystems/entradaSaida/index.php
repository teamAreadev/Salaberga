<?php

session_start();
function redirect_to_login()
{
    header('Location: ../../main/views/autenticacao/login.php');
}
if (!isset($_SESSION['Email'])) {
    session_destroy();
    redirect_to_login();
} else {
    // Configura o time zone para o fuso horário desejado (exemplo: América/São Paulo)
    date_default_timezone_set('America/Sao_Paulo');

    // Obtém a data e hora atual no formato desejado
    $date_time = date('Y-m-d H:i:s');

    if (isset($_GET['id_aluno'])) {
        $aluno = $_GET['id_aluno'];

        require_once('app/main/model/model_indexClass.php');
        $model = new MainModel();

        $result = $model->registrarSaidaEstagio($aluno, $date_time);

        switch ($result) {
            case 0:
                header('Location: success.php?id_aluno=' . $aluno);
                exit();
            case 1:
                header('Location: erro.php?id_aluno=' . $aluno . '&erro=1');
                exit();
            case 2:
                header('Location: erro.php?id_aluno=' . $aluno . '&erro=2');
                exit();
            case 3:
                header('Location: erro.php?id_aluno=' . $aluno . '&erro=3');
                exit();
            default:
                header('Location: erro.php');
                exit();
        }
    }
}
