<?php

            $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
            $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
            $filme = isset($_POST['filme']) ? $_POST['filme'] : null;
            $turma = isset($_POST['turma']) ? $_POST['turma'] : null;
            $curso = isset($_POST['curso']) ? $_POST['curso'] : null;

        
            require_once('../model/model.php');
            cadastrar($nome,$cpf,$filme,$turma,$curso);
        



?>