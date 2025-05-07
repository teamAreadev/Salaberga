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
        $stmt_vagas = $this->connect->query("SELECT sum(quantidade) as quantidade FROM vagas");
        $result = $stmt_vagas->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function total_vagas_des()
    {
        $stmt_empresa = $this->connect->query("SELECT sum(quantidade) as quantidade FROM vagas WHERE id_perfil = 2");
        $result = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function total_vagas_dev()
    {
        $stmt_empresa = $this->connect->query("SELECT sum(quantidade) as quantidade FROM vagas WHERE id_perfil = 1");
        $result = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function total_vagas_tut()
    {
        $stmt_empresa = $this->connect->query("SELECT sum(quantidade) as quantidade FROM vagas WHERE id_perfil = 4");
        $result = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function total_vagas_sup()
    {
        $stmt_empresa = $this->connect->query("SELECT sum(quantidade) as quantidade FROM vagas WHERE id_perfil = 3");
        $result = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    function estagios_ativas(){

        $stmt_ativas = $this->connect->query("SELECT count(*) FROM selecao");
        $result =  $stmt_ativas->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    function concedentes()
    {
        $stmt_empresa = $this->connect->query(
            "SELECT 
                c.id AS id,
                c.nome AS nome,
                COALESCE(GROUP_CONCAT(p.nome_perfil), '') AS perfis,
                c.endereco,
                c.contato
            FROM 
                concedentes c
            LEFT JOIN concedentes_perfis cp ON c.id = cp.concedente_id
            LEFT JOIN perfis p ON cp.perfil_id = p.id
            GROUP BY 
                c.id, c.nome, c.endereco, c.contato;"
        );
        $result = $stmt_empresa->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    function alunos_aptos($nome_perfil = 0)
    {
        if ($nome_perfil == 0) {

            $stmt_alunos = $this->connect->query(
                "SELECT * FROM aluno WHERE perfil_opc1 IS NOT NULL OR perfil_opc2 IS NOT NULL 
            ORDER BY medias DESC,
            COALESCE(ocorrencia, 0) ASC;"
            );
            $result = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } else {

            $stmt_alunos = $this->connect->query(
                "SELECT 
                            id,
                            nome,
                            medias,
                            projetos,
                            ocorrencia,
                            entregas,
                            perfil_opc1,
                            perfil_opc2,
                            custeio,
                            (
                                medias + 
                                (CASE WHEN projetos != '' THEN 5 ELSE 0 END) -
                                (ocorrencia * 0.5) +
                                (entregas * 5)
                            ) AS score
                        FROM aluno
                        WHERE perfil_opc1 = '$nome_perfil' OR perfil_opc2 = '$nome_perfil'
                        ORDER BY score DESC, medias DESC, COALESCE(ocorrencia, 0) ASC;"
            );
            $result = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }
    }
    function vagas()
    {
        $stmt_vagas = $this->connect->query(
            "SELECT 
                v.id as id,
                c.nome AS nome_empresa,
                p.nome_perfil AS nome_perfil,
                v.quantidade AS quantidade,
                v.data as data,
                v.hora as hora,
                v.tipo_vaga as tipo_vaga
            FROM 
                vagas v
            INNER JOIN concedentes c ON v.id_concedente = c.id
            INNER JOIN perfis p ON v.id_perfil = p.id;"
        );
        $result = $stmt_vagas->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    function alunos_selecionados($id_vaga)
    {

        $stmt = $this->connect->query("SELECT aluno.nome, aluno.id FROM aluno inner join selecao on aluno.id = selecao.id_aluno WHERE id_vaga = '$id_vaga'");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
