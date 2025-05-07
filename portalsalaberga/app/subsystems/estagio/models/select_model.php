<?php
require_once(__DIR__ . '/../config/connect.php');

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
                "SELECT 
                    a.*,
                    CASE 
                        WHEN s.id IS NOT NULL THEN 'approved'
                        ELSE 'waiting'
                    END as status,
                    p.nome_perfil as area,
                    c.nome as empresa
                FROM aluno a
                LEFT JOIN selecao s ON a.id = s.id_aluno
                LEFT JOIN vagas v ON s.id_vaga = v.id
                LEFT JOIN perfis p ON v.id_perfil = p.id
                LEFT JOIN concedentes c ON v.id_concedente = c.id
                WHERE a.perfil_opc1 IS NOT NULL OR a.perfil_opc2 IS NOT NULL 
                ORDER BY a.medias DESC,
                COALESCE(a.ocorrencia, 0) ASC;"
            );
            $result = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } else {
            $stmt_alunos = $this->connect->query(
                "SELECT 
                    a.*,
                    CASE 
                        WHEN s.id IS NOT NULL THEN 'approved'
                        ELSE 'waiting'
                    END as status,
                    p.nome_perfil as area,
                    c.nome as empresa,
                    (
                        a.medias + 
                        (CASE WHEN a.projetos != '' THEN 5 ELSE 0 END) -
                        (a.ocorrencia * 0.5) +
                        (a.entregas * 5)
                    ) AS score
                FROM aluno a
                LEFT JOIN selecao s ON a.id = s.id_aluno
                LEFT JOIN vagas v ON s.id_vaga = v.id
                LEFT JOIN perfis p ON v.id_perfil = p.id
                LEFT JOIN concedentes c ON v.id_concedente = c.id
                WHERE a.perfil_opc1 = '$nome_perfil' OR a.perfil_opc2 = '$nome_perfil'
                ORDER BY score DESC, a.medias DESC, COALESCE(a.ocorrencia, 0) ASC;"
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
