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
        $stmt_select = $this->connect_demandas->query("
            SELECT d.*, u1.nome as nome_usuario FROM demandas d INNER JOIN demanda_usuarios du ON d.id = du.id_demanda INNER JOIN salaberga.usuarios u1 ON du.id_usuario = u1.id WHERE d.status = 'em_andamento';
        ");
        $result = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function select_demandas_pendentes()
    {
        $stmt_select = $this->connect_demandas->query("
            SELECT d.*, u1.nome as nome_usuario FROM demandas d INNER JOIN demanda_usuarios du ON d.id = du.id_demanda INNER JOIN salaberga.usuarios u1 ON du.id_usuario = u1.id WHERE d.status = 'pendente';
        ");
        $result = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function select_demandas_concluidos()
    {
        $stmt_select = $this->connect_demandas->query("
            SELECT d.*, u1.nome as nome_usuario FROM demandas d INNER JOIN demanda_usuarios du ON d.id = du.id_demanda INNER JOIN salaberga.usuarios u1 ON du.id_usuario = u1.id WHERE d.status = 'concluida';
        ");
        $result = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
