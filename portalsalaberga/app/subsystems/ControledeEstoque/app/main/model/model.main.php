<?php
require_once(__DIR__ . '/../config/connection.php');

class MainModel extends connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registrar_perda(
        $id_produto,
        $quantidade,
        $tipo_perda,
        $data_perda
    ) {

        $stmt_check = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt_check->bindParam(':id', $id_produto);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {

            $stmt_registrar = $this->pdo->prepare("INSERT INTO perdas_produtos VALUES(null, :id_produto, :quantidade, :tipo, :data_perda)");
            $stmt_registrar->bindParam(':id_produto', $id_produto);
            $stmt_registrar->bindParam(':quantidade', $quantidade);
            $stmt_registrar->bindParam(':tipo', $tipo_perda);
            $stmt_registrar->bindParam(':data_perda', $data_perda);
            $stmt_registrar->execute();

            if($stmt_registrar){

                return 1;
            }else{

                return 2;
            }
            
        }else{

            return 3;
        }
    }
};
