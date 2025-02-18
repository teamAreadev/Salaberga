<?php

if (isset($_GET['certo'])) {
    header('location: ../../views/autenticação/cadastro.php');
    exit();
}
if (isset($_GET['erro'])) {
    header('location: ../../views/autenticação/precadastro.php?erro');
    exit();
}

if (isset($_POST['pre_cadastro']) && isset($_POST['preemail']) && isset($_POST['precpf']) && !empty($_POST['preemail']) && !empty($_POST['precpf'])) {

    $email = $_POST['preemail'];
    $cpf = $_POST['precpf'];

    require('../../models/model_dados.php');
    pre_cadastro($email, $cpf);

} else {
    header('location:../../views/autenticação/precadastro.php');
    exit();
}

