<?php
if (isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['escola'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $escola = $_POST['escola'];

    switch ($escola) {

        case 1:
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            header('location:../escolas_parceiras/eeep_maria_carmem/SS/controllers/autentica.php?email='.$email.'&senha='.$senha);
            break;

        case 2:
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            header('location:../escolas_parceiras/eeep_luiza_de_teodoro/SS/controllers/autentica.php?email='.$email.'&senha='.$senha);
            break;
            
        case 3:
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            header('location:../escolas_parceiras/eeep_antonio_valmir/SS/controllers/autentica.php?email='.$email.'&senha='.$senha);
            break;

        case 4:
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            header('location:../escolas_parceiras/eeep_prof_francisco_aristoteles/SS/controllers/autentica.php?email='.$email.'&senha='.$senha);
            break;
        }
    }

