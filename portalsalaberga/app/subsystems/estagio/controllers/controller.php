<?php
require_once('../models/model.php');

if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['senha']) && !empty($_POST['senha'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $model = new main_model;
    $result = $model->cadastra($email, $senha);

    echo $result;
    switch ($result) {

        case 1:
            header('location:../views/dashboard.php');
            exit();
        case 2:
            header('location:../views/login.php?erro');
            exit();
    }
} else {
    header('location:../views/login.php');
    exit();
}
