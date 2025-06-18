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
        $stmt_select = $this->connect_demandas->query("SELECT * FROM demandas WHERE status = 'pendente';
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
    public function selecionar_demanda($id_demanda, $id_usuario)
    {
        $stmt_selecionar = $this->connect_demandas->prepare("SELECT * FROM $this->tabela3 WHERE id_usuario = :id_usuario AND id_demanda = :id_demanda");
        $stmt_selecionar->bindValue(':id_usuario', $id_usuario);
        $stmt_selecionar->bindValue(':id_demanda', $id_demanda);
        $stmt_selecionar->execute();
        $result = $stmt_selecionar->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_selecionar = $this->connect_demandas->prepare("UPDATE `demandas` SET `status`='em_andamento' WHERE id = :id_demanda");
            $stmt_selecionar->bindValue(':id_demanda', $id_demanda);
            $stmt_selecionar->execute();

            $stmt_selecionar = $this->connect_demandas->prepare("INSERT INTO $this->tabela3 VALUES (null, :id_demanda, :id_usuario)");
            $stmt_selecionar->bindValue(':id_demanda', $id_demanda);
            $stmt_selecionar->bindValue(':id_usuario', $id_usuario);

            if ($stmt_selecionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }
    public function concluir_demanda($id_demanda)
    {
        $date = date('Y-m-d H:i:s');
        $stmt_concluir = $this->connect_demandas->prepare("UPDATE `demandas` SET `status`='concluida' AND `data_conclusao` = $date WHERE id = :id_demanda");
        $stmt_concluir->bindValue(':id_demanda', $id_demanda);
        $stmt_concluir->execute();

        if ($stmt_concluir->execute()) {
            return 1;
        } else {
            return 2;
        }
    }
}
