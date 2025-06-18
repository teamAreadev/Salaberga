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
    public function editar_demanda($titulo, $descricao, $prioridade, $id_admin, $prazo)
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
}
