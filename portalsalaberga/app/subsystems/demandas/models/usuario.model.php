<?php
require_once('../config/connect.php');

class usuario_model extends connect
{
    private $tabela1;
    private $tabela2;
    private $tabela3;
    function __construct()
    {
        parent::__construct();
        $this->tabela1 = 'areas';
        $this->tabela2 = 'demandas';
        $this->tabela3 = 'demanda_usuario';
    }

    public function select_demandas_andamentos()
    {
        $stmt_select = $this->connect->query("SELECT * FROM $this->tabela2 WHERE status = 'em_andamento'");
        $result = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function select_demandas_pendentes()
    {
        $stmt_select = $this->connect->query("SELECT *  FROM $this->tabela2 WHERE status = 'pendente'");
        $result = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function select_demandas_concluidos()
    {
        $stmt_select = $this->connect->query("SELECT * FROM $this->tabela2 WHERE status = 'concluida'");
        $result = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

