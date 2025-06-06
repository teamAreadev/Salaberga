<?php

require_once(__DIR__ . '/../../assets/fpdf/fpdf.php');
require_once(__DIR__ . '/../../config/connect.php'); // Assumindo que getConnection() está aqui e o caminho está correto

// Classe FPDF personalizada para adicionar o background (reutilizando a classe anterior)
class PDF extends FPDF
{
    public $colwidths;

    // Constructor to initialize column widths
    function __construct($orientation='P', $unit='mm', $size='A4')
    {
        parent::__construct($orientation, $unit, $size);
        // Define larguras das colunas para o modo paisagem (ajustar para este relatório)
        $this->colwidths = [
            'Nome' => 80,  
            'Equipe' => 20,  
            'Entregas Individuais' => 40,   
            'Entregas Grupo' => 40,   
            'Nota Final' => 20      
        ];
         $this->SetAutoPageBreak(true, 15); // Set auto page break
         $this->SetFont('Arial','',12); // Set default font
         $this->AddPage($orientation); // Add initial page with specified orientation
    }

    function Header()
    {
        // Caminho para a imagem de background. Ajuste se necessário.
        $backgroundPath1 = __DIR__ . '/../../../subsystems/estagio/views/relatorio/img/fundo.jpg';
        $backgroundPath2 = __DIR__ . '/../../assets/img/pdf/Fundo1.png';

        if (file_exists($backgroundPath2)) {
             $this->Image($backgroundPath2, 0, 0, $this->w, $this->h);
        } elseif (file_exists($backgroundPath1)) {
             $this->Image($backgroundPath1, 0, 0, $this->w, $this->h);
        } else {
             error_log("Erro: Nenhuma imagem de background encontrada. Caminhos verificados: " . $backgroundPath2 . " e " . $backgroundPath1);
             $this->SetFillColor(230, 230, 230); 
             $this->Rect(0, 0, $this->w, $this->h, 'F');
        }

         $this->SetFont('Arial','B',16);
         $this->SetTextColor(0, 0, 0); // Cor do texto preta
         $this->Cell(0, 15, utf8_decode('Relatório de Alunos e Notas'), 0, 1, 'C');
         $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(0, 0, 0); // Cor do texto preta
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }

    // Table Row method for this report
    function TableRow($data, $fill = false)
    {
        $this->SetFillColor(240, 240, 240); // Cor de fundo para as linhas da tabela (opcional)
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 8);

        // Data: Nome, Equipe, Entregas Individuais, Entregas Grupo, Nota Final
        $this->Cell($this->colwidths['Nome'], 6, utf8_decode($data['nome']), 1, 0, 'L', $fill);
        $this->Cell($this->colwidths['Equipe'], 6, utf8_decode($data['equipe']), 1, 0, 'C', $fill);
        $this->Cell($this->colwidths['Entregas Individuais'], 6, utf8_decode($data['entregas_individuais']), 1, 0, 'C', $fill);
        $this->Cell($this->colwidths['Entregas Grupo'], 6, utf8_decode($data['entregas_grupo']), 1, 0, 'C', $fill);
        $this->Cell($this->colwidths['Nota Final'], 6, utf8_decode($data['nota']), 1, 1, 'C', $fill);
    }
}

// Obter conexão com o banco de dados login_parcial
$conexao = getConnection(); 

if ($conexao === null) {
    die('Erro: Falha ao conectar ao banco de dados login_parcial. Verifique a configuração de connect.php.');
}

// Consultar dados da tabela aluno, ordenando por equipe e nome
try {
    $stmt = $conexao->query("SELECT id, nome, equipe, entregas_individuais, entregas_grupo, nota FROM aluno ORDER BY equipe, nome");
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erro ao consultar banco de dados: ' . $e->getMessage());
}

// Verificar se há dados para gerar o relatório
if (empty($alunos)) {
    die('Nenhum aluno encontrado para gerar o relatório.');
}

// Crie uma instância do PDF em formato retrato ('P'), pode mudar para 'L' se preferir
$pdf = new PDF('P');
$pdf->AliasNbPages();

// Cabeçalho da Tabela
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(131, 181, 105); // Cor de fundo verde
$pdf->SetTextColor(0, 0, 0);

// Adicionar cabeçalho da tabela usando as larguras definidas na classe PDF
$pdf->Cell($pdf->colwidths['Nome'], 7, utf8_decode('Nome'), 1, 0, 'C', true);
$pdf->Cell($pdf->colwidths['Equipe'], 7, utf8_decode('Equipe'), 1, 0, 'C', true);
$pdf->Cell($pdf->colwidths['Entregas Individuais'], 7, utf8_decode('Entregas Individuais'), 1, 0, 'C', true);
$pdf->Cell($pdf->colwidths['Entregas Grupo'], 7, utf8_decode('Entregas Grupo'), 1, 0, 'C', true);
$pdf->Cell($pdf->colwidths['Nota Final'], 7, utf8_decode('Nota'), 1, 1, 'C', true); // 1 para quebrar linha após o cabeçalho

$fill = false; // Alternar cor de fundo das linhas da tabela

foreach ($alunos as $aluno) {
    $pdf->TableRow($aluno, $fill);
    $fill = !$fill; // Alternar cor
}

$pdf->Output('relatorio_alunos_notas.pdf', 'I'); // 'I' para exibir no navegador, 'D' para download

?> 