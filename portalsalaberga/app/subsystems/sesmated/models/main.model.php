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
}
