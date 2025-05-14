<?php

// Configura o time zone para o fuso horário desejado (exemplo: América/São Paulo)
date_default_timezone_set('America/Sao_Paulo');

// Obtém a data e hora atual no formato desejado
$date_time = date('Y-m-d H:i:s');

if (isset($_GET['id_aluno'])){
    $aluno = $_GET['id_aluno'];

    require_once('app/main/model/model_indexClass.php');
    $model = new RegistroAluno();
    if($model->registrarSaidaEstagio($aluno, $date_time)){
        header('Location: success.php');
    }
    
    
}

?>