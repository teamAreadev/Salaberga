<?php

if (isset($_GET['alt'])) {
   header('Location: ../../views/autenticacao/login.php');
   exit();  
}


if (isset($_POST['Senha']) && !empty($_POST['Senha'])) {
    // Verifica se os campos novaSenha e confSenha existem e não estão vazios
    if (isset($_POST['novaSenha']) && !empty($_POST['novaSenha']) && isset($_POST['confSenha']) && !empty($_POST['confSenha'])) {
        $novaSenha = $_POST['novaSenha'];
        $confSenha = $_POST['confSenha'];

        // Verifica se as senhas coincidem
        if ($novaSenha === $confSenha) {
            require_once('../../models/model_dados.php');
            // Chama a função para alterar a senha
            alterarSenha($novaSenha);
        } else {
            // Senhas não coincidem
            header('Location: ../../views/autenticacao/perfil.php?erro=1');
        }
    } 
}

?>