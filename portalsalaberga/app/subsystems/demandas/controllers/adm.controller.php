<?php
require_once('../models/adm.model.php');

if (
    isset($_POST['titulo']) && !empty($_POST['titulo']) &&
    isset($_POST['descricao']) && !empty($_POST['descricao']) &&
    isset($_POST['prioridade']) && !empty($_POST['prioridade']) &&
    isset($_POST['id_admin']) && !empty($_POST['id_admin']) &&
    isset($_POST['prazo']) && !empty($_POST['prazo'])
) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $prioridade = $_POST['prioridade'];
    $id_adm = $_POST['id_admin'];
    $prazo = $_POST['prazo'];

    $adm_model = new adm_model();
    $result = $adm_model->cadastrar_demanda($titulo, $descricao, $prioridade, $id_adm, $prazo);

    switch ($result) {
        case 1:
            header('location: ../views/adm.php?status=cadastrado');
            exit();

        case 2:
            header('location: ../views/adm.php?status=error');
            exit();

        case 3:
            header('location: ../views/adm.php?status=ja_cadastrado');
            exit();
    }
} else if (isset($_POST['id_usuario']) && !empty($_POST['id_usuario']) && isset($_POST['id_demanda']) && !empty($_POST['id_demanda'])) {

    $id_usuario = $_POST['id_usuario'];
    $id_demanda = $_POST['id_demanda'];

    $adm_model = new adm_model();
    $result = $adm_model->selecionar_demanda($id_demanda, $id_usuario);

    switch ($result) {
        case 1:
            header('location: ../views/adm.php?status=selecionado');
            exit();

        case 2:
            header('location: ../views/adm.php?status=error');
            exit();

        case 3:
            header('location: ../views/adm.php?status=ja_selecionado');
            exit();
    }
} else if(isset($_POST['id_demanda_concluir']) && !empty($_POST['id_demanda_concluir'])){

    $id_demanda = $_POST['id_demanda_concluir'];

    $adm_model = new adm_model();
    $result = $adm_model->concluir_demanda($id_demanda);

    switch ($result) {
        case 1:
            header('location: ../views/adm.php?status=concluido');
            exit();

        case 2:
            header('location: ../views/adm.php?status=error');
            exit();
    }
}else{

    header('location: ../views/adm.php?status=empty');
    exit();
}
