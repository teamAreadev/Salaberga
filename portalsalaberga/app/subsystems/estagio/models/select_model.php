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
        $stmt_empresa = $this->connect->query("SELECT sum(quantidade) from vagas where id_perfil = 3; ");
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
   function alunos($nome_perfil = 0, $search = '', $filtro = '')
{
    $sql = "SELECT 
                id,
                nome,
                medias,
                projetos,
                ocorrencia,
                entregas_individuais,
                entregas_grupo,
                perfil_opc1,
                perfil_opc2,
                custeio,
                (
                    medias + 
                    (CASE WHEN projetos != '' THEN 5 ELSE 0 END) -
                    (ocorrencia * 0.5) +
                    (entregas_individuais * 5) +
                    (entregas_grupo * 5)
                ) AS score,
                CASE 
                    WHEN perfil_opc1 = '$nome_perfil' THEN 1
                    WHEN perfil_opc2 = '$nome_perfil' THEN 2
                    ELSE 3
                END AS priority_group
            FROM aluno
            WHERE perfil_opc1 = '$nome_perfil' OR perfil_opc2 = '$nome_perfil'
            ORDER BY 
                priority_group ASC,  -- First sort by priority group (1 for first option, 2 for second option)
                score DESC,          -- Then by score descending within each group
                medias DESC,         -- Then by medias descending
                COALESCE(ocorrencia, 0) ASC;";
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
   function alunos_aptos_curso($nome_perfil = 0, $search = '', $filtro = '')
    {
        $sql = "SELECT * FROM aluno";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function alunos_aptos($nome_perfil = 0, $search = '', $filtro = '')
    {
        $sql = "SELECT 
                    a.id, 
                    a.nome, 
                    a.perfil_opc1, 
                    c.nome AS empresa,
                    p.nome_perfil AS perfil_empresa,
                    'approved' as status
                FROM selecionado s
                INNER JOIN aluno a ON s.id_aluno = a.id
                INNER JOIN vagas v ON s.id_vaga = v.id
                INNER JOIN concedentes c ON v.id_concedente = c.id
                INNER JOIN perfis p ON v.id_perfil = p.id
                
                UNION
                
                SELECT 
                    a.id, 
                    a.nome, 
                    a.perfil_opc1, 
                    c.nome AS empresa,
                    p.nome_perfil AS perfil_empresa,
                    'waiting' as status
                FROM selecao se
                INNER JOIN aluno a ON se.id_aluno = a.id
                INNER JOIN vagas v ON se.id_vaga = v.id
                INNER JOIN concedentes c ON v.id_concedente = c.id
                INNER JOIN perfis p ON v.id_perfil = p.id
                LEFT JOIN selecionado s ON se.id_aluno = s.id_aluno AND se.id_vaga = s.id_vaga
                WHERE s.id_aluno IS NULL
                
                UNION
                
                SELECT 
                    a.id, 
                    a.nome, 
                    a.perfil_opc1, 
                    NULL AS empresa,
                    NULL AS perfil_empresa,
                    'no_interview' as status
                FROM aluno a
                LEFT JOIN selecao se ON a.id = se.id_aluno
                LEFT JOIN selecionado s ON a.id = s.id_aluno
                WHERE se.id_aluno IS NULL AND s.id_aluno IS NULL
                
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
                v.tipo_vaga as tipo_vaga,
                v.id_concedente as id_empresa,
                v.id_perfil as id_perfil
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
            $sql .= " AND v.id_perfil = ?";
            $params[] = $area;
        }

        if (!empty($empresa)) {
            $sql .= " AND v.id_concedente = ?";
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
        $stmt = $this->connect->query("
            SELECT a.nome, a.id 
            FROM aluno a
            INNER JOIN selecionado s ON a.id = s.id_aluno
            WHERE s.id_vaga = '$id_vaga'");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function alunos_espera($id_vaga)
    {
        $stmt = $this->connect->query("
            SELECT DISTINCT a.nome, a.id 
            FROM aluno a
            INNER JOIN selecao s ON a.id = s.id_aluno
            LEFT JOIN selecionado sel ON a.id = sel.id_aluno AND sel.id_vaga = '$id_vaga'
            WHERE s.id_vaga = '$id_vaga' 
            AND sel.id_aluno IS NULL");
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
            // Verifica se já existe
            $check = $this->connect->prepare("SELECT 1 FROM selecionado WHERE id_aluno = ? AND id_vaga = ?");
            $check->execute([$item['id_aluno'], $item['id_vaga']]);
            if ($check->fetch()) {
                continue; // Já existe, não insere
            }
            $stmt = $this->connect->prepare("INSERT INTO selecionado (id_aluno, id_vaga, nome) VALUES (?, ?, ?)");
            if ($stmt->execute([$item['id_aluno'], $item['id_vaga'], $item['nome'] ?? ''])) {
                $count++;
            }
        }
        return $count;
    }
    public function getConnection()
    {
        return $this->connect;
    }

    public function total_alunos(){

        $stmt_alunos = $this->connect->query('SELECT count(*) FROM aluno');
        $result = $stmt_alunos->fetch(PDO::FETCH_ASSOC);
        foreach($result as $dado){
            return $dado;
        }
    }

    function vaga_por_id($id_vaga) {
        $stmt = $this->connect->prepare("SELECT * FROM vagas WHERE id = ? LIMIT 1");
        $stmt->execute([$id_vaga]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function concedente_por_id($empresa_id) {
        $sql = "SELECT id, nome, nome_contato, contato, endereco FROM concedentes WHERE id = :empresa_id LIMIT 1";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(':empresa_id', $empresa_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

