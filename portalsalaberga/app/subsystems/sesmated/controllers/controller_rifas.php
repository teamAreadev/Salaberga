<?php
require_once('../models/main.model.php');

//adicionar turma
if (
    isset($_POST['id_turma']) && !empty($_POST['id_turma']) &&
    isset($_POST['rifas']) && !empty($_POST['rifas'])
) {
    $id_turma = $_POST['id_turma'];
    $rifas = $_POST['rifas'];

    $main_model = new main_model();
    $result = $main_model->adcionar_turma($id_turma, $rifas);

    switch ($result) {
        case 1:
            header('location:../views/rifa.php?turma_adicionada');
            exit();
        case 2:
            header('location:../views/rifa.php?erro');
            exit();
        case 3:
            header('location:../views/rifa.php?ja_adicionada');
            exit();
    }
} else {

    header('location:../views/rifa.php?empty');
    exit();
}
