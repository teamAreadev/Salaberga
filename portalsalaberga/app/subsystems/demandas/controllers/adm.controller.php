<?php
require_once('../models/adm.model.php');

if (
    isset($_POST['titulo']) && !empty($_POST['titulo']) &&
    isset($_POST['descricao']) && !empty($_POST['descricao']) &&
    isset($_POST['prioridade']) && !empty($_POST['prioridade']) &&
    isset($_POST['id_adm']) && !empty($_POST['id_adm']) &&
    isset($_POST['prazo']) && !empty($_POST['prazo'])
) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $prioridade = $_POST['prioridade'];
    $id_adm = $_POST['id_adm'];
    $prazo = $_POST['prazo'];

    $adm_model = new adm_model();
    $result = $adm_model->cadastrar_demanda($titulo, $descricao, $prioridade, $id_adm, $prazo);

    if ($result) {

        header('location: ../views/adm.php?status=success');
        exit();
    } else {

        header('location: ../views/adm.php?status=error');
        exit();
    }
} else {

    header('location: ../views/adm.php?status=empty');
    exit();
}
