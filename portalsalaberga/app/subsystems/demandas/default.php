<?php 
session_start();
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
$dados = explode('(',$_SESSION['user_systems_permissions'][0]['permissao_descricao']);
$dado = $dados[0];

if($dado == 'adm'){

    header('location:views/adm.php');
    exit();
}else if($dado == 'usuario'){

    header('location:views/usuario.php');
    exit();
}

?>