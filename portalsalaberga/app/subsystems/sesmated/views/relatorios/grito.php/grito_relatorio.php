<?php
require_once('../../../assets/fpdf/fpdf.php');
require_once('../../../config/connect.php');
require_once('../../../../../main/models/sessions.php');
$session = new sessions();
$session->autenticar_session();

class PDF extends connect
{
    public function __construct()
    {
        parent::__construct();
        $this->main();
    }

    private function getDadosRelatorio()
    {
        // Busca todas as turmas e cursos
        $query = "
            SELECT t.turma_id, t.nome_turma, c.nome_curso, c.curso_id
            FROM turmas t
            INNER JOIN cursos c ON c.curso_id = t.curso_id
            ORDER BY c.curso_id, t.nome_turma
        ";
        $stmt = $this->connect->query($query);
        $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Busca todos os gritos registrados por curso
        $queryGrito = "SELECT curso_id, cumprida FROM tarefa_02_grito_guerra";
        $stmtGrito = $this->connect->query($queryGrito);
        $gritos = $stmtGrito->fetchAll(PDO::FETCH_KEY_PAIR); // [curso_id => cumprida]

        // Monta resultado por turma
        foreach ($turmas as &$turma) {
            $curso_id = $turma['curso_id'];
            if (isset($gritos[$curso_id]) && $gritos[$curso_id]) {
                $turma['grito'] = 'Sim';
                $turma['pontos'] = 500;
            } else {
                $turma['grito'] = 'Não';
                $turma['pontos'] = 0;
            }
        }
        return $turmas;
    }

    private function gerarCabecalho($fpdf, $titulo)
    {
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(0, 20, utf8_decode($titulo), 0, 1, 'C');
        $fpdf->Ln(10);
    }

    private function gerarTabela($fpdf, $header, $data)
    {
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->SetFillColor(200, 200, 200);
        foreach ($header as $col) {
            $fpdf->Cell(90, 15, utf8_decode($col), 1, 0, 'C', true);
        }
        $fpdf->Ln();
        $fpdf->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            $fpdf->Cell(90, 15, utf8_decode($row['nome_curso']), 1);
            $fpdf->Cell(90, 15, utf8_decode($row['nome_turma']), 1);
            $fpdf->Cell(90, 15, utf8_decode($row['grito']), 1);
            $fpdf->Cell(90, 15, utf8_decode($row['pontos']), 1);
            $fpdf->Ln();
        }
    }

    public function main()
    {
        $fpdf = new FPDF('P', 'pt', 'A4');
        $fpdf->AliasNbPages();
        $fpdf->AddPage('P');
        $this->gerarCabecalho($fpdf, 'Relatório de Grito de Guerra por Turma');
        $header = ['Curso', 'Turma', 'Grito de Guerra', 'Pontos'];
        $dados = $this->getDadosRelatorio();
        $this->gerarTabela($fpdf, $header, $dados);
        $fpdf->Output('relatorio_grito_guerra.pdf', 'I');
    }
}

$relatorio = new PDF();
