<?php

session_start();
function redirect_to_login(){
    header('Location: ../../main/views/autenticacao/login.php');
}
if(!isset($_SESSION['Email'])){
    redirect_to_login();
}
// Configura o time zone para o fuso horário desejado (exemplo: América/São Paulo)
date_default_timezone_set('America/Sao_Paulo');

// Obtém a data e hora atual no formato desejado
$date_time = date('Y-m-d H:i:s');

if (isset($_GET['id_aluno'])){
    $aluno = $_GET['id_aluno'];

    require_once('app/main/model/model_indexClass.php');
    $model = new MainModel();
    if($model->registrarSaidaEstagio($aluno, $date_time)){
        header('Location: success.php?id_aluno=' . $aluno);
        exit();
    }
}

?>