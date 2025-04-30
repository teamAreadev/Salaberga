<?php
require_once('../config/connect.php');

class select_model extends connect
{

    //atrivbutos
    function __construct()
    {
        parent::__construct();
    }

    function total_empresa()
    {
        $stmt_empresa = $this->connect->query("SELECT count(*) FROM concedentes");
        $result = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function total_vagas()
    {
        $stmt_vagas = $this->connect->query("SELECT sum(numero_vagas) FROM concedentes");
        $result = $stmt_vagas->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function total_vagas_dev()
    {
        $stmt_vagas_dev = $this->connect->query("SELECT numero_vagas FROM concedentes WHERE perfil = 'desenvolvedor'");
        $result = $stmt_vagas_dev->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function total_vagas_suporte()
    {
        $stmt_empresa = $this->connect->query("SELECT numero_vagas FROM concedentes WHERE perfil = 'suporte'");
        $result = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function total_vagas_design()
    {
        $stmt_empresa = $this->connect->query("SELECT numero_vagas FROM concedentes WHERE perfil = 'design'");
        $result = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function total_vagas_tutoria()
    {
        $stmt_empresa = $this->connect->query("SELECT numero_vagas FROM concedentes WHERE perfil = 'tutoria'");
        $result = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function concedentes()
    {
        $stmt_empresa = $this->connect->query("SELECT * FROM concedentes");
        $result = $stmt_empresa->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
