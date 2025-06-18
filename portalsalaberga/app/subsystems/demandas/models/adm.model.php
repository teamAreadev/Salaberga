<?php
require_once('usuario.model.php');
class adm_model extends usuario_model
{
    private $tabela1;
    private $tabela2;
    private $tabela3;
    function __construct()
    {
        parent::__construct();
        $this->tabela1 = 'areas';
        $this->tabela2 = 'demandas';
        $this->tabela3 = 'demanda_usuarios';
    }

    public function cadastrar_demanda($titulo, $descricao, $prioridade, $id_admin, $prazo)
    {
        $stmt_cadastrar = $this->connect_demandas->prepare("SELECT * FROM $this->tabela2 WHERE titulo = :titulo");
        $stmt_cadastrar->bindValue(':titulo', $titulo);
        $stmt_cadastrar->execute();
        $result = $stmt_cadastrar->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_cadastrar = $this->connect_demandas->prepare("INSERT INTO $this->tabela2(`titulo`, `descricao`, `prioridade`, `admin_id`, `prazo`) VALUES (:titulo, :descricao, :prioridade, :id_admin, :prazo)");
            $stmt_cadastrar->bindValue(':titulo', $titulo);
            $stmt_cadastrar->bindValue(':descricao', $descricao);
            $stmt_cadastrar->bindValue(':prioridade', $prioridade);
            $stmt_cadastrar->bindValue(':id_admin', $id_admin);
            $stmt_cadastrar->bindValue(':prazo', $prazo);

            if ($stmt_cadastrar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
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
            $stmt_concluir = $this->connect_demandas->prepare("UPDATE `demandas` SET `status`='concluida' WHERE id = :id_demanda");
            $stmt_concluir->bindValue(':id_demanda', $id_demanda);
            $stmt_concluir->execute();

            if ($stmt_concluir->execute()) {
                return 1;
            } else {
                return 2;
            }
    }
}
