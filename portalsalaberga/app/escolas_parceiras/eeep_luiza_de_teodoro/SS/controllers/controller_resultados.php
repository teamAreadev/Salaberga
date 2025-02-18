<?php

if (isset($_POST['curso']) && isset($_POST['tipo'])) {

    $curso = $_POST['curso'];
    $tipo = $_POST['tipo'];

    if ($tipo == '1') {

        require_once('../views/resultados/classificados.php');
        classificados($curso);
    } else if ($tipo == '2') {

        require_once('../views/resultados/lista_de_espera.php');
        lista_de_espera($curso);
    } else {

        header('location:../views/inicio.php');
    }
} else {
    header('location:../views/inicio.php');
}
