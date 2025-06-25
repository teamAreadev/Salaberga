<?php
require_once('../../../assets/fpdf/fpdf.php');
require_once('../../../config/connect.php');
require_once('../../../../../main/models/sessions.php');
$session = new sessions();
$session->autenticar_session();

// Definindo constantes
define('TURMAS', [
    '1A' => 230,
    '2A' => 245,
    '3A' => 235,
    '1B' => 230,
    '2B' => 230,
    '3B' => 245,
    '1C' => 225,
    '2C' => 230,
    '3C' => 240,
    '1D' => 230,
    '2D' => 235,
    '3D' => 250
]);

define('DINHEIRO', [
    '1A' => 230*2,
    '2A' => 245*2,
    '3A' => 235*2,
    '1B' => 230*2,
    '2B' => 230*2,
    '3B' => 245*2,
    '1C' => 225*2,
    '2C' => 230*2,
    '3C' => 240*2,
    '1D' => 230*2,
    '2D' => 235*2,
    '3D' => 250*2
]);

class PDF extends connect
{
    public function __construct()
    {
        parent::__construct();
        $this->main();
    }

    private function getDadosRelatorio()
    {
        $query = "
            SELECT t.turma_id, t.nome_turma, c.nome_curso, c.curso_id,
                   rifa.valor_arrecadado, rifa.quantidades_rifas, a.nome AS nome_avaliador
            FROM turmas t
            INNER JOIN cursos c ON c.curso_id = t.curso_id
            INNER JOIN tarefa_01_rifas rifa ON rifa.turma_id = t.turma_id
            INNER JOIN avaliadores a ON a.id = rifa.id_usuario
            ORDER BY c.curso_id, t.nome_turma
        ";
        $stmt = $this->connect->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function gerarCabecalho($fpdf, $titulo)
    {
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->SetXY(0, 50); // Margem superior maior para evitar sobrepor os logotipos
        $fpdf->Cell(0, 20, utf8_decode($titulo), 0, 1, 'C');
        $fpdf->Ln(10);
    }

    private function gerarTabela($fpdf, $header, $data)
    {
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->SetFillColor(200, 200, 200);
        $totalWidth = 540; // Largura total das 6 colunas (90 * 6)
        $x = ($fpdf->GetPageWidth() - $totalWidth) / 2; // Centraliza a tabela
        $fpdf->SetXY($x, $fpdf->GetY());
        foreach ($header as $col) {
            $fpdf->Cell(90, 15, utf8_decode($col), 1, 0, 'C', true);
        }
        $fpdf->Ln();
        
        $fpdf->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            $fpdf->SetXY($x, $fpdf->GetY());
            foreach ($row as $col) {
                $fpdf->Cell(90, 15, utf8_decode($col), 1);
            }
            $fpdf->Ln();
        }
    }

    public function main()
    {
        $fpdf = new FPDF('P', 'pt', 'A4');
        $fpdf->AliasNbPages();
        $dados = $this->getDadosRelatorio();

        // Relatório 1: Por Turma
        $fpdf->AddPage('P');
        $this->gerarCabecalho($fpdf, 'Relatório por Turma');

        $header = ['Turma', 'Meta Rifas', 'Rifas Entregues', 'Meta Dinheiro', 'Valor Arrecadado', 'Avaliador'];
        foreach (TURMAS as $nome_turma => $meta) {
            $fpdf->SetFont('Arial', 'B', 12);
            $fpdf->SetXY(($fpdf->GetPageWidth() - 200) / 2, $fpdf->GetY()); // Centraliza o título da turma
            $fpdf->Cell(200, 15, utf8_decode("Turma: $nome_turma"), 0, 1);
            
            $turma_data = array_filter($dados, fn($d) => $d['nome_turma'] === $nome_turma);
            $tabela_data = [];
            foreach ($turma_data as $d) {
                $tabela_data[] = [
                    $d['nome_turma'],
                    $meta,
                    $d['quantidades_rifas'],
                    'R$ ' . number_format(DINHEIRO[$d['nome_turma']] ?? 0, 2, ',', '.'),
                    'R$ ' . number_format($d['valor_arrecadado'], 2, ',', '.'),
                    $d['nome_avaliador']
                ];
            }
            $this->gerarTabela($fpdf, $header, $tabela_data);
            $fpdf->Ln(20); // Espaçamento maior entre turmas
        }

        $fpdf->Output('relatorio_acervo.pdf', 'I');
    }
}

$relatorio = new PDF();