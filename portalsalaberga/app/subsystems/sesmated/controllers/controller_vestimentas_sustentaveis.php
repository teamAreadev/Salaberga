<?php
require_once('../models/main.model.php');
print_r($_POST);
if (
    isset($_POST['curso']) && !empty($_POST['curso']) &&
    isset($_POST['nota_materiais']) &&
    isset($_POST['nota_criatividade']) &&
    isset($_POST['nota_estetica']) &&
    isset($_POST['nota_identidade']) &&
    isset($_POST['nota_desfile']) &&
    isset($_POST['nota_acabamento']) &&
    isset($_POST['id_avaliador']) && !empty($_POST['id_avaliador'])
) {
    $curso = $_POST['curso'];
    $id_avaliador = $_POST['id_avaliador'];
    $nota_materiais = $_POST['nota_materiais'];
    $nota_criatividade = $_POST['nota_criatividade'];
    $nota_estetica = $_POST['nota_estetica'];
    $nota_identidade = $_POST['nota_identidade'];
    $nota_desfile = $_POST['nota_desfile'];
    $nota_acabamento = $_POST['nota_acabamento'];

    $modeloPrincipal = new main_model();
    $resultado = $modeloPrincipal->confirmar_vestimentas($curso, $nota_materiais, $nota_criatividade, $nota_estetica, $nota_identidade, $nota_desfile, $nota_acabamento, $id_avaliador);

    switch ($resultado) {
        case 1:
            header('location:../views/esquete.php?confirmado');
            exit();
        case 2:
            header('location:../views/esquete.php?erro');
            exit();
        case 3:
            header('location:../views/esquete.php?ja_confirmado');
            exit();
    }
} else {
    header('location:../views/esquete.php?empty');
    exit();
}
