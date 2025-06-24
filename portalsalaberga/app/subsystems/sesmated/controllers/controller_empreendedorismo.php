<?php
require_once('../models/main.model.php');

if (
    isset($_POST['criterio']) && !empty($_POST['criterio']) &&
    isset($_POST['pontuacao']) && !empty($_POST['pontuacao']) &&
    isset($_POST['curso']) && !empty($_POST['curso'])
) {
    $criterio = $_POST['criterio'];
    $pontuacao = $_POST['pontuacao'];
    $curso = $_POST['curso'];

    $main_model = new main_model();
    $result = $main_model->confirmar_empreendedorismo($criterio, $pontuacao, $curso);

    switch ($result) {
        case 1:
            header('location:../views/Empreendedorismo.php?confirmado');
            exit();
        case 2:
            header('location:../views/Empreendedorismo.php?erro');
            exit();
        case 3:
            header('location:../views/Empreendedorismo.php?ja_confirmado');
            exit();
    }
} else {
    header('location:../views/Empreendedorismo.php?empty');
    exit();
} 