<?php
// Configurar codificação
header('Content-Type: application/pdf; charset=utf-8');
mb_internal_encoding('UTF-8');

require_once(__DIR__ . '/../../main/model/select_model.php');
require_once(__DIR__ . '/../assets/lib/fpdf/fpdf.php');

class PDF extends FPDF {
    // Cores da paleta Salaberga
    private $corPrimaria = [0, 140, 69]; // #008C45
    private $corSecundaria = [60, 179, 113]; // #3CB371
    private $corClara = [240, 249, 244]; // #F0F9F4
    private $corTexto = [55, 65, 81]; // #374151
    private $corBorda = [229, 231, 235]; // #E5E7EB
    private $headerShown = false;

    // Função para converter texto UTF-8 para ISO-8859-1
    private function convertText($text) {
        return iconv('UTF-8', 'ISO-8859-1//IGNORE', $text);
    }

    function Header() {
        // Só mostra o header na primeira página
        if (!$this->headerShown) {
            // Fundo do cabeçalho
            $this->SetFillColor($this->corClara[0], $this->corClara[1], $this->corClara[2]);
            $this->Rect(0, 0, $this->GetPageWidth(), 40, 'F');
            
            // Linha decorativa verde
            $this->SetDrawColor($this->corPrimaria[0], $this->corPrimaria[1], $this->corPrimaria[2]);
            $this->SetLineWidth(1);
            $this->Line(0, 40, $this->GetPageWidth(), 40);
            
            // Logo (comentado para evitar problemas de rede)
            // $this->Image('https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png', 10, 8, 25);
            
            // Título com estilo moderno
            $this->SetFont('Arial', 'B', 16);
            $this->SetTextColor($this->corPrimaria[0], $this->corPrimaria[1], $this->corPrimaria[2]);
            $this->SetX(40);
            $this->Cell(0, 15, $this->convertText('Relatório Diário de Saída para Estágio'), 0, 1, 'L');
            
            // Subtítulo com data
            $this->SetFont('Arial', '', 11);
            $this->SetTextColor($this->corTexto[0], $this->corTexto[1], $this->corTexto[2]);
            $this->SetX(40);
            $this->Cell(0, 5, 'Data: ' . date('d/m/Y') . ' - Sistema Escolar Salaberga', 0, 1, 'L');
            
            // Espaço após o cabeçalho
            $this->Ln(15);
            
            $this->headerShown = true;
        }
    }

    function Footer() {
        // Linha decorativa verde
        $this->SetDrawColor($this->corPrimaria[0], $this->corPrimaria[1], $this->corPrimaria[2]);
        $this->SetLineWidth(0.5);
        $this->Line(10, $this->GetPageHeight() - 15, $this->GetPageWidth() - 10, $this->GetPageHeight() - 15);
        
        // Informações do rodapé
        $this->SetY(-14);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor($this->corTexto[0], $this->corTexto[1], $this->corTexto[2]);
        $this->Cell(0, 10, $this->convertText('Página ' . $this->PageNo() . '/{nb}  •  Gerado em ' . date('d/m/Y H:i') . '  •  Sistema Escolar Salaberga'), 0, 0, 'C');
    }

    function ChapterTitle($title) {
        // Título de seção com estilo moderno
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor($this->corPrimaria[0], $this->corPrimaria[1], $this->corPrimaria[2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 10, '   ' . $this->convertText($title), 0, 1, 'L', true);
        $this->Ln(4);
    }

    function TableHeader() {
        // Cabeçalho da tabela com estilo moderno
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor($this->corSecundaria[0], $this->corSecundaria[1], $this->corSecundaria[2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(80, 8, '  Nome do Aluno', 1, 0, 'L', true);
        $this->Cell(40, 8, 'Data', 1, 0, 'C', true);
        $this->Cell(40, 8, 'Hora', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Turma', 1, 1, 'C', true);
        
        // Resetar cor do texto para o padrão
        $this->SetTextColor($this->corTexto[0], $this->corTexto[1], $this->corTexto[2]);
    }
    
    function InfoBox($title, $content) {
        // Caixa de informação com estilo moderno
        $this->SetFillColor($this->corClara[0], $this->corClara[1], $this->corClara[2]);
        $this->SetDrawColor($this->corPrimaria[0], $this->corPrimaria[1], $this->corPrimaria[2]);
        $this->SetLineWidth(0.3);
        $this->Rect(10, $this->GetY(), $this->GetPageWidth() - 20, 20, 'FD');
        
        // Título da caixa
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor($this->corPrimaria[0], $this->corPrimaria[1], $this->corPrimaria[2]);
        $this->SetXY(15, $this->GetY() + 3);
        $this->Cell(50, 6, $this->convertText($title), 0, 0, 'L');
        
        // Conteúdo da caixa
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor($this->corTexto[0], $this->corTexto[1], $this->corTexto[2]);
        $this->SetXY(65, $this->GetY());
        $this->Cell(0, 6, $this->convertText($content), 0, 1, 'L');
        
        $this->Ln(25);
    }
    
    function AlternateRowColors($i) {
        // Cores alternadas para as linhas da tabela
        if ($i % 2 == 0) {
            $this->SetFillColor(255, 255, 255);
        } else {
            $this->SetFillColor($this->corClara[0], $this->corClara[1], $this->corClara[2]);
        }
    }

    function DrawBarChart($data, $title) {
        // Configurações do gráfico
        $chartX = 20;
        $chartY = $this->GetY() + 5;
        $chartWidth = 160;
        $chartHeight = 40;
        $barWidth = 30;
        $maxValue = max(array_values($data));
        if ($maxValue == 0) $maxValue = 1; // Evitar divisão por zero
        $scale = $chartHeight / $maxValue;
        
        // Título do gráfico
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor($this->corTexto[0], $this->corTexto[1], $this->corTexto[2]);
        $this->SetXY($chartX, $chartY - 15);
        $this->Cell($chartWidth, 10, $this->convertText($title), 0, 1, 'L');
        
        // Fundo do gráfico
        $this->SetFillColor(248, 250, 252);
        $this->Rect($chartX, $chartY, $chartWidth, $chartHeight, 'F');
        
        // Linhas de grade
        $this->SetDrawColor(229, 231, 235);
        $this->SetLineWidth(0.2);
        for ($i = 0; $i <= 5; $i++) {
            $y = $chartY + $chartHeight - ($chartHeight / 5 * $i);
            $this->Line($chartX, $y, $chartX + $chartWidth, $y);
        }
        
        // Desenhar barras
        $barX = $chartX + 15;
        foreach ($data as $label => $value) {
            // Barra principal
            $barHeight = $value * $scale;
            $this->SetFillColor($this->corPrimaria[0], $this->corPrimaria[1], $this->corPrimaria[2]);
            $this->Rect($barX, $chartY + $chartHeight - $barHeight, $barWidth, $barHeight, 'F');
            
            // Valor acima da barra
            $this->SetFont('Arial', 'B', 9);
            $this->SetTextColor($this->corPrimaria[0], $this->corPrimaria[1], $this->corPrimaria[2]);
            $this->SetXY($barX, $chartY + $chartHeight - $barHeight - 10);
            $this->Cell($barWidth, 10, $value, 0, 0, 'C');
            
            // Rótulo abaixo da barra (apenas a letra da turma)
            $this->SetFont('Arial', '', 8);
            $this->SetTextColor($this->corTexto[0], $this->corTexto[1], $this->corTexto[2]);
            $this->SetXY($barX, $chartY + $chartHeight + 2);
            $labelShort = substr($label, -1); // Pega apenas a última letra (A, B, C, D)
            $this->Cell($barWidth, 5, $labelShort, 0, 0, 'C');
            
            $barX += $barWidth + 10;
        }
        
        // Atualizar posição Y
        $this->SetY($chartY + $chartHeight + 15);
    }
}

// Criar novo documento PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Obter a data de hoje
$hoje = date('Y-m-d');

// Inicializar conexão com o banco de dados
$select = new select_model();

// Obter todas as turmas (3º ano) - usando texto simples para evitar problemas de encoding
$turmas = [
    '9' => '3o Ano A',
    '10' => '3o Ano B', 
    '11' => '3o Ano C',
    '12' => '3o Ano D'
];

// Adicionar informações gerais
$pdf->InfoBox('Data do Relatorio:', date('d/m/Y') . ' (Hoje)');

// Para cada turma
$total_por_turma = [];
$temRegistros = false;

foreach ($turmas as $id_turma => $nome_turma) {
    // Obter alunos que saíram para estágio hoje
    $registros = $select->getSaidasEstagioPorTurma($id_turma, $hoje);
    $total_por_turma[$nome_turma] = count($registros);
    
    if (!empty($registros)) {
        $temRegistros = true;
        
        // Adicionar título da turma
        $pdf->ChapterTitle($nome_turma);
        
        // Adicionar cabeçalho da tabela
        $pdf->TableHeader();
        
        // Ordenar registros por nome do aluno
        usort($registros, function($a, $b) {
            return strcmp($a['nome'], $b['nome']);
        });
        
        // Adicionar registros dos alunos com cores alternadas
        $i = 0;
        foreach ($registros as $registro) {
            $pdf->AlternateRowColors($i);
            
            // Converter nome do aluno para ISO-8859-1
            $nomeAluno = iconv('UTF-8', 'ISO-8859-1//IGNORE', $registro['nome']);
            
            $pdf->Cell(80, 7, '  ' . $nomeAluno, 1, 0, 'L', true);
            $pdf->Cell(40, 7, date('d/m/Y', strtotime($registro['data_saida'])), 1, 0, 'C', true);
            $pdf->Cell(40, 7, date('H:i', strtotime($registro['hora_saida'])), 1, 0, 'C', true);
            $pdf->Cell(30, 7, $nome_turma, 1, 1, 'C', true);
            $i++;
        }
        
        $pdf->Ln(10);
    }
}

// Se não há registros, mostrar mensagem
if (!$temRegistros) {
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->SetTextColor(150, 150, 150);
    $pdf->Cell(0, 20, 'Nenhum aluno saiu para estagio hoje.', 0, 1, 'C');
    $pdf->Ln(10);
}

// Calcular total geral
$total_geral = array_sum($total_por_turma);

// Adicionar página de resumo
$pdf->AddPage();
$pdf->ChapterTitle('Resumo do Dia ' . date('d/m/Y'));

// Adicionar tabela de resumo
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(240, 249, 244);
$pdf->SetDrawColor(0, 140, 69);
$pdf->SetTextColor(55, 65, 81);

$pdf->Cell(100, 8, '  Turma', 1, 0, 'L', true);
$pdf->Cell(90, 8, 'Quantidade de Alunos', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
foreach ($total_por_turma as $turma => $total) {
    $pdf->Cell(100, 7, '  ' . $turma, 1, 0, 'L');
    $pdf->Cell(90, 7, $total . ' aluno(s)', 1, 1, 'C');
}

// Linha de total
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(0, 140, 69);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(100, 8, '  TOTAL GERAL', 1, 0, 'L', true);
$pdf->Cell(90, 8, $total_geral . ' aluno(s)', 1, 1, 'C', true);

// Adicionar observações
$pdf->Ln(15);
$pdf->SetTextColor(55, 65, 81);
$pdf->SetFont('Arial', 'I', 9);
$observacoes = "Observacoes:\n";
$observacoes .= "1. Este relatorio apresenta os alunos que sairam para estagio na data atual.\n";
$observacoes .= "2. Os dados sao organizados por turma e ordenados alfabeticamente por nome do aluno.\n";
$observacoes .= "3. Para mais informacoes, entre em contato com a coordenacao de estagios.";

$pdf->MultiCell(0, 5, $observacoes, 0, 'L');

// Gerar o PDF
$pdf->Output('I', 'Relatorio_Diario_Estagio_' . date('d-m-Y') . '.pdf');
?>