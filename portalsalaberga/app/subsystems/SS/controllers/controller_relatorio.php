<?php


if (isset($_POST['curso']) && (isset($_POST['tipo']))) {
    $curso = $_POST['curso'];
    $tipo = $_POST['tipo'];

    if ($tipo == '1') {
        require_once('../views/relatorios/publicaGeral.php');
        publicaGeral($curso);
    }
    if ($tipo == '2') {
        require_once('../views/relatorios/publicaAC.php');
        publicaAC($curso);
    }
    if ($tipo == '3') {
        require_once('../views/relatorios/publicaCotas.php');
        publicaCotas($curso);
    }
    if ($tipo == '4') {
        require_once('../views/relatorios/privadaGeral.php');
        privadaGeral($curso);
    }
    if ($tipo == '5') {
        require_once('../views/relatorios/privadaAC.php');
        privadaAC($curso);
    }
    if ($tipo == '6') {
        require_once('../views/relatorios/privadaCotas.php');
        privadaCotas($curso);
    }
    if ($tipo == '7') {
        require_once('../views/relatorios/usuarios.php');
        usuarios();
    }
} else {
    header('location:../views/inicio.php');
}
