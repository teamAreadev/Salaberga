<?php
require_once('../../config/Database.php');
require_once('../../assets/lib/fpdf/fpdf.php');
require_once('../../model/select_model.php');

class PDF extends FPDF {
    private $select;
    private $colors = [
        'primary' => [0, 122, 51],    // Cor principal verde (para header/footer)
        'secondary' => [255, 165, 0], // Cor secundária laranja (para linhas decorativas)
        'light_green' => [240, 249, 244], // Verde claro para fundo de cabeçalho de tabela
        'dark' => [55, 65, 81],       // Cinza escuro para texto geral
        'gray_border' => [229, 231, 235], // Cinza claro para bordas da tabela
        'light_gray_row' => [245, 245, 245], // Cinza claro para linhas ímpares da tabela
        
        // Cores específicas das turmas (baseadas em ultimo_registro.php)
        'turma_3a' => [220, 53, 69],  // Vermelho (danger)
        'turma_3b' => [65, 105, 225], // Azul (info)
        'turma_3c' => [13, 202, 240], // Ciano (admin)
        'turma_3d' => [108, 117, 125] // Cinza (grey)
    ];

    public function __construct()
    {
        parent::__construct('P', 'pt', 'A4'); // 'P' para Portrait, 'pt' para points, 'A4' size
        $this->select = new select_model();
    }

    // Header method (FPDF calls this automatically on new page)
    public function Header()
    {
        // Define o fuso horário para Brasília
        date_default_timezone_set('America/Sao_Paulo');

        // Fundo do cabeçalho com a cor primária
        $this->SetFillColor($this->colors['primary'][0], $this->colors['primary'][1], $this->colors['primary'][2]);
        $this->Rect(0, 0, $this->GetPageWidth(), 60, 'F');

        // Título principal
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(255, 255, 255); // Texto branco
        $this->Cell(0, 8, utf8_decode('Relatório de Saídas para Estágio'), 0, 1, 'C');

        // Data e hora
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 23, utf8_decode('Data: ' . date('d/m/Y') . ' | Hora: ' . date('H:i')) , 0, 1, 'C');

        // Linha decorativa
        $this->SetDrawColor($this->colors['secondary'][0], $this->colors['secondary'][1], $this->colors['secondary'][2]);;

        $this->Ln(15); // Espaço após o cabeçalho
    }

    // Footer method (FPDF calls this automatically on new page)
    public function Footer()
    {
        $this->SetY(-20); // Posição a 20pt da parte inferior

        // Linha decorativa
        $this->SetDrawColor($this->colors['secondary'][0], $this->colors['secondary'][1], $this->colors['secondary'][2]);
        $this->SetLineWidth(0.5);
        $this->Line(40, $this->GetY(), $this->GetPageWidth() - 40, $this->GetY());

        $this->Ln(5); // Espaço entre a linha e o texto

        // Número da página
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor($this->colors['primary'][0], $this->colors['primary'][1], $this->colors['primary'][2]);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');

        // Data e hora de geração no rodapé
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, utf8_decode('Gerado em: ' . date('d/m/Y H:i:s')), 0, 0, 'R');
    }

    // Main content generation
    public function generateReport()
    {
        $this->AliasNbPages(); // Necessário para o {nb} no footer
        $this->AddPage();

        $this->SetFont('Arial', 'B', 12);

        // 3º Ano A
        $this->SetFillColor($this->colors['turma_3a'][0], $this->colors['turma_3a'][1], $this->colors['turma_3a'][2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, utf8_decode('3º Ano A'), 0, 1, 'L', true);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);
        $dados_3a = $this->select->saida_estagio_3A();
        $this->imprimirAlunos($dados_3a);
        $this->Ln(15);

        // 3º Ano B
        $this->SetFillColor($this->colors['turma_3b'][0], $this->colors['turma_3b'][1], $this->colors['turma_3b'][2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, utf8_decode('3º Ano B'), 0, 1, 'L', true);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);
        $dados_3b = $this->select->saida_estagio_3B();
        $this->imprimirAlunos($dados_3b);
        $this->Ln(15);

        // 3º Ano C
        $this->SetFillColor($this->colors['turma_3c'][0], $this->colors['turma_3c'][1], $this->colors['turma_3c'][2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, utf8_decode('3º Ano C'), 0, 1, 'L', true);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);
        $dados_3c = $this->select->saida_estagio_3C();
        $this->imprimirAlunos($dados_3c);
        $this->Ln(15);

        // 3º Ano D
        $this->SetFillColor($this->colors['turma_3d'][0], $this->colors['turma_3d'][1], $this->colors['turma_3d'][2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, utf8_decode('3º Ano D'), 0, 1, 'L', true);
        $this->SetFillColor(255, 255, 255);
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
        $this->SetFillColor($this->colors['light_green'][0], $this->colors['light_green'][1], $this->colors['light_green'][2]);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);

        // Bordas da tabela
        $this->SetDrawColor($this->colors['gray_border'][0], $this->colors['gray_border'][1], $this->colors['gray_border'][2]);
        $this->SetLineWidth(0.2);

        // Larguras das colunas
        $pageWidth = $this->GetPageWidth() - 57; // Considerando as margens padrão de 20pt de cada lado
        $colWidthNome = $pageWidth * 0.7; // 70% para o nome
        $colWidthHorario = $pageWidth * 0.3; // 30% para o horário

        $this->Cell($colWidthNome, 10, utf8_decode('Nome do Aluno'), 1, 0, 'C', true);
        $this->Cell($colWidthHorario, 10, utf8_decode('Horário'), 1, 1, 'C', true);

        // Dados dos alunos
        $this->SetFont('Arial', '', 10);
        $rowCounter = 0;
        foreach ($dados as $dado) {
            $this->SetFillColor($rowCounter % 2 == 0 ? 255 : $this->colors['light_gray_row'][0],
                              $rowCounter % 2 == 0 ? 255 : $this->colors['light_gray_row'][1],
                              $rowCounter % 2 == 0 ? 255 : $this->colors['light_gray_row'][2]);
            $this->SetTextColor($this->colors['dark'][0], $this->colors['dark'][1], $this->colors['dark'][2]);

            // Ajuste de alinhamento explícito
            $this->Cell($colWidthNome, 10, utf8_decode($dado['nome']), 1, 0, 'L', true); // Nome: Left
            $this->Cell($colWidthHorario, 10, isset($dado['dae']) ? date('H:i', strtotime($dado['dae'])) : '--:--',
                        1, 1, 'C', true); // Horário: Center

            $rowCounter++;
        }
    }
}

// Instantiate and generate the report
$pdf = new PDF();
$pdf->generateReport(); // Call the method to generate content
$pdf->Output('relatorio_saidas_estagio.pdf', 'I');
?>

