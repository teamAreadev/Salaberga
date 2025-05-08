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
    function estagios_ativas()
    {

        $stmt_ativas = $this->connect->query("SELECT count(*) FROM selecionado");
        $result =  $stmt_ativas->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    function concedentes($search = '', $area = '')
    {
        $sql = "SELECT DISTINCT c.*, 
                GROUP_CONCAT(DISTINCT p.nome_perfil) as areas
                FROM concedentes c
                LEFT JOIN vagas v ON c.id = v.id_concedente
                LEFT JOIN perfis p ON v.id_perfil = p.id
                WHERE 1=1";

        $params = [];

        if (!empty($search)) {
            $sql .= " AND (c.nome LIKE ? OR c.endereco LIKE ? OR c.contato LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($area)) {
            $sql .= " AND p.nome_perfil = ?";
            $params[] = $area;
        }

        $sql .= " GROUP BY c.id ORDER BY c.nome ASC";

        $stmt = $this->connect->prepare($sql);
        
        if (!empty($params)) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function alunos_aptos($nome_perfil = 0, $search = '', $filtro = '')
    {
        $sql = "SELECT 
                    id, 
                    nome, 
                    contato, 
                    medias, 
                    email, 
                    projetos, 
                    perfil_opc1, 
                    perfil_opc2, 
                    ocorrencia, 
                    custeio, 
                    entregas_individuais, 
                    entregas_grupo
                FROM alunos
                ORDER BY nome ASC";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function vagas($search = '', $area = '', $empresa = '')
    {
        $sql = "SELECT 
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
            INNER JOIN perfis p ON v.id_perfil = p.id
            WHERE 1=1";

        $params = [];

        if (!empty($search)) {
            $sql .= " AND (c.nome LIKE ? OR p.nome_perfil LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($area)) {
            $sql .= " AND p.nome_perfil = ?";
            $params[] = $area;
        }

        if (!empty($empresa)) {
            $sql .= " AND c.id = ?";
            $params[] = $empresa;
        }

        $sql .= " ORDER BY v.data DESC, v.hora DESC";

        $stmt = $this->connect->prepare($sql);
        
        if (!empty($params)) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function alunos_selecionados($id_vaga)
    {

        $stmt = $this->connect->query("SELECT aluno.nome, aluno.id FROM aluno inner join selecao on aluno.id = selecao.id_aluno WHERE id_vaga = '$id_vaga'");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    function alunos_selecionados_estagio($id_vaga)
    {
        $stmt = $this->connect->query("
            SELECT 
                a.nome, 
                a.id,
                CASE 
                    WHEN sel.id_aluno IS NOT NULL THEN 'approved'
                    ELSE 'waiting'
                END as status
            FROM aluno a
            INNER JOIN selecao s ON a.id = s.id_aluno 
            LEFT JOIN selecionado sel ON a.id = sel.id_aluno AND sel.id_vaga = '$id_vaga'
            WHERE s.id_vaga = '$id_vaga'");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function vagas_com_alunos()
    {
        $stmt = $this->connect->query("SELECT DISTINCT id_vaga FROM selecao");
        $vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $vagas;
    }

    function nome_empresa_por_vaga($id_vaga)
    {
        $stmt = $this->connect->prepare("SELECT c.nome FROM vagas v INNER JOIN concedentes c ON v.id_concedente = c.id WHERE v.id = :id_vaga LIMIT 1");
        $stmt->bindValue(':id_vaga', $id_vaga, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nome'] : null;
    }

    function aprovar_selecionados($selecionados)
    {
        $count = 0;
        foreach ($selecionados as $item) {
            $stmt = $this->connect->prepare("INSERT INTO selecionado (id_aluno, id_vaga, nome) VALUES (?, ?, ?)");
            if ($stmt->execute([$item['id_aluno'], $item['id_vaga'], $item['nome']])) {
                $count++;
            }
        }
        return $count;
    }
    public function getConnection()
    {
        return $this->connect;
    }
}
