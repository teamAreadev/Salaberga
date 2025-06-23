<?php
require_once('../config/connect.php');

class main_model extends connect
{

    function __construct()
    {
        parent::__construct();
    }

    //rifas 
    public function adcionar_turma($id_turma, $rifas)
    {
        $valor = $rifas * 2;
        // Verifica se já existe registro para a turma
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_01_rifas WHERE turma_id = :turma_id");
        $stmt_check->bindValue(':turma_id', $id_turma);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {

            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_01_rifas`(`turma_id`, `valor_arrecadado`, `quantidades_rifas`) VALUES ( :turma_id, :valor, :quantidades)");
            $stmt_adcionar->bindValue(':turma_id', $id_turma);
            $stmt_adcionar->bindValue(':valor', $valor);
            $stmt_adcionar->bindValue(':quantidades', $rifas);

            if ($stmt_adcionar->execute()) {

                return 1;
            } else {

                return 2;
            }
        } else {

            return 3;
        }
    }

    //grito
    public function confirmar_grito($id_curso, $grito)
    {
        $pontuacao = $grito == "sim" ? 500 : 0;
        $grito = $grito == "sim" ? 1 : 0;
        // Verifica se já existe registro para a turma
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_02_grito_guerra WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {

            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_02_grito_guerra`(`curso_id`, `cumprida`, `pontuacao`) VALUES (:curso_id, :cumprida, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':cumprida', $grito);
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {

                return 1;
            } else {

                return 2;
            }
        } else {

            return 3;
        }
    }
}
