<?php
require_once('../models/model.php');
if (
    isset($_POST['nome']) &&
    isset($_POST['contato']) &&
    isset($_POST['media']) &&
    isset($_POST['email']) &&
    isset($_POST['projetos']) &&
    isset($_POST['opc1']) &&
    isset($_POST['opc2']) &&
    isset($_POST['ocorrencia']) &&
    isset($_POST['custeio']) &&
    isset($_POST['entregas_individuais']) &&
    isset($_POST['entregas_grupo']) &&
    isset($_POST['id'])
) {

    $nome = $_POST['nome'];
    $contato = $_POST['contato'];
    $medias = $_POST['media'];
    $email = $_POST['email'];
    $projetos = $_POST['projetos'];
    $perfil_opc1 = $_POST['opc1'];
    $perfil_opc2 = $_POST['opc2'];
    $ocorrencia = $_POST['ocorrencia'];
    $custeio = $_POST['custeio'];
    $entregas_individuais = $_POST['entregas_individuais'];
    $entregas_grupo = $_POST['entregas_grupo'];
    $id = $_POST['id'];


    $model = new main_model;
    $result = $model->criar_aluno($id, $nome, $contato, $medias, $email, $projetos, $perfil_opc1, $perfil_opc2, $ocorrencia, $custeio, $entregas_individuais, $entregas_grupo);
    switch ($result) {
        case 1:
            header('location:../views/gerenciar_alunos.php?cadastrado');
            exit();
        case 2:
            header('location:../views/gerenciar_alunos.php?erro');
            exit();
        case 3:
            header('location:../views/gerenciar_alunos.php?ja_cadastrado');
            exit();
        default:
            header('location:../views/gerenciar_alunos.php?erro2');
            exit();
    }
}
