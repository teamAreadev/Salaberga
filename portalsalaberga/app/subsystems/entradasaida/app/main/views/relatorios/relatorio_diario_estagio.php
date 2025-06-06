<?php
require_once('../../config/Database.php');
require_once('../../assets/lib/fpdf/fpdf.php');
require_once('../../model/select_model.php');

class PDF extends FPDF {
    private $select;
    private $colors = [
        'primary' => [0, 140, 69],    // #008C45
        'secondary' => [60, 179, 113], // #3CB371
        'light' => [240, 249, 244],   // #F0F9F4
        'dark' => [55, 65, 81],       // #374151
        'gray' => [229, 231, 235]     // #E5E7EB
    ];

    public function __construct()
    {
        parent::__construct('P', 'pt', 'A4');
        $this->select = new select_model();
        $this->AliasNbPages();
        $this->AddPage();
        $this->header();
        $this->main();
        $this->footer();
    }

    public function header()
    {
        // Logo e título
        $this->SetFillColor($this->colors['primary'][0], $this->colors['primary'][1], $this->colors['primary'][2]);
        $this->Rect(0, 0, $this->GetPageWidth(), 50, 'F');
        
        // Título principal
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 25, utf8_decode('Relatório de Saídas para Estágio'), 0, 1, 'C');
        
        // Data e hora
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, utf8_decode('Data: ' . date('d/m/Y') . ' - Hora: ' . date('H:i')), 0, 1, 'C');
        
        // Linha decorativa
        $this->SetDrawColor($this->colors['secondary'][0], $this->colors['secondary'][1], $this->colors['secondary'][2]);
        $this->SetLineWidth(1);
        $this->Line(40, 50, $this->GetPageWidth() - 40, 50);
        
        $this->Ln(15);
    }

    public function main()
    {
        $this->SetFont('Arial', 'B', 12);
        
        // 3º Ano A
        $this->SetFillColor($this->colors['primary'][0], $this->colors['primary'][1], $this->colors['primary'][2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, utf8_decode('3º Ano A'), 0, 1, 'L', true);
        $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);
        $dados_3a = $this->select->saida_estagio_3A();
        $this->imprimirAlunos($dados_3a);
        $this->Ln(15);

        // 3º Ano B
        $this->SetFillColor($this->colors['secondary'][0], $this->colors['secondary'][1], $this->colors['secondary'][2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, utf8_decode('3º Ano B'), 0, 1, 'L', true);
        $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);
        $dados_3b = $this->select->saida_estagio_3B();
        $this->imprimirAlunos($dados_3b);
        $this->Ln(15);

        // 3º Ano C
        $this->SetFillColor($this->colors['primary'][0], $this->colors['primary'][1], $this->colors['primary'][2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, utf8_decode('3º Ano C'), 0, 1, 'L', true);
        $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);
        $dados_3c = $this->select->saida_estagio_3C();
        $this->imprimirAlunos($dados_3c);
        $this->Ln(15);

        // 3º Ano D
        $this->SetFillColor($this->colors['secondary'][0], $this->colors['secondary'][1], $this->colors['secondary'][2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, utf8_decode('3º Ano D'), 0, 1, 'L', true);
        $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);
        $dados_3d = $this->select->saida_estagio_3D();
        $this->imprimirAlunos($dados_3d);
    }

    public function imprimirAlunos($dados) {
        if (empty($dados)) {
            $this->SetFont('Arial', 'I', 10);
            $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);
            $this->Cell(0, 10, utf8_decode('Nenhum aluno registrado hoje'), 0, 1, 'L');
            return;
        }

        // Cabeçalho da tabela
        $this->SetFillColor($this->colors['light'][0], $this->colors['light'][1], $this->colors['light'][2]);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);
        
        // Bordas mais suaves
        $this->SetDrawColor($this->colors['gray'][0], $this->colors['gray'][1], $this->colors['gray'][2]);
        $this->SetLineWidth(0.2);
        
        $this->Cell(300, 10, utf8_decode('Nome do Aluno'), 1, 0, 'C', true);
        $this->Cell(100, 10, utf8_decode('Horário'), 1, 1, 'C', true);

        // Dados dos alunos
        $this->SetFont('Arial', '', 10);
        $fill = false;
        foreach ($dados as $dado) {
            $this->SetFillColor($fill ? $this->colors['light'][0] : 255, 
                              $fill ? $this->colors['light'][1] : 255, 
                              $fill ? $this->colors['light'][2] : 255);
            $this->Cell(300, 10, utf8_decode($dado['nome']), 1, 0, 'L', true);
            $this->Cell(100, 10, isset($dado['dae']) ? date('H:i', strtotime($dado['dae'])) : '--:--', 1, 1, 'C', true);
            $fill = !$fill;
        }
    }

    public function footer()
    {
        $this->SetY(-20);
        
        // Linha decorativa
        $this->SetDrawColor($this->colors['secondary'][0], $this->colors['secondary'][1], $this->colors['secondary'][2]);
        $this->SetLineWidth(0.5);
        $this->Line(40, $this->GetY(), $this->GetPageWidth() - 40, $this->GetY());
        
        $this->Ln(5);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor($this->colors['primary'][0], $this->colors['primary'][1], $this->colors['primary'][2]);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        
        // Data e hora no rodapé
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, utf8_decode('Gerado em: ' . date('d/m/Y H:i:s')), 0, 0, 'R');
    }
}

$pdf = new PDF();
$pdf->Output('relatorio_saidas_estagio.pdf', 'I');
?>

