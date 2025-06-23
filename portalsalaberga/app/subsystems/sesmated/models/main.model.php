<?php 
require_once('../config/connect.php');

class main_model extends connect{

    function __construct(){
        parent::__construct();
    }

    //rifas 
    public function adcionar_turma($turma, $rifas){

        $stmt_adcionar = $this->connect->prepare("SELECT ")
    }
    
}
?>