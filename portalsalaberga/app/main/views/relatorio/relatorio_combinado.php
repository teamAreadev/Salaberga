<?php

require_once(__DIR__ . '/../../assets/fpdf/fpdf.php');
require_once(__DIR__ . '/../../config/connect.php'); // Assumindo que getConnection() está aqui

// Classe FPDF personalizada para adicionar o background
class PDF extends FPDF
{
    public $colwidthsSprint;
    public $colwidthsAluno;
    protected $headerY;

    // Constructor
    function __construct($orientation='P', $unit='mm', $size='A4')
    {
        parent::__construct($orientation, $unit, $size);
        // Define larguras das colunas para a tabela de Sprints (Paisagem)
        $this->colwidthsSprint = [
            'Entrega' => 140, 
            'Entregue' => 25,  
            'NoPrazo' => 25,   
            'Notas' => 80      
        ];
         // Define larguras das colunas para a lista de Alunos (Paisagem)
        $this->colwidthsAluno = [
            'Nome' => 100,  
            'Entregas Individuais' => 40,   
            'Entregas Grupo' => 40,   
            'Nota Final' => 30      
        ];
         $this->SetAutoPageBreak(true, 15); // Set auto page break
         $this->AliasNbPages(); // For page numbering
    }

    function Header()
    {
        // Caminho para a imagem de background.
        $backgroundPath1 = __DIR__ . '/../../../subsystems/estagio/views/relatorio/img/fundo.jpg';
        $backgroundPath2 = __DIR__ . '/../../assets/img/pdf/Fundo1.png';

        if (file_exists($backgroundPath2)) {
             $this->Image($backgroundPath2, 0, 0, $this->w, $this->h);
        } elseif (file_exists($backgroundPath1)) {
             $this->Image($backgroundPath1, 0, 0, $this->w, $this->h);
        } else {
             error_log("Erro: Nenhuma imagem de background encontrada.");
             $this->SetFillColor(230, 230, 230); 
             $this->Rect(0, 0, $this->w, $this->h, 'F');
        }

         $this->SetFont('Arial','B',16);
         $this->SetTextColor(0, 0, 0); // Cor do texto preta
         $this->Cell(0, 15, utf8_decode('Relatório Combinado de Equipes e Alunos'), 0, 1, 'C');
         $this->Ln(10);
         
         // Store the Y position after the main header
         $this->headerY = $this->GetY();
         
         // Table headers will be drawn within the main loop based on context
    }
    
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(0, 0, 0); // Cor do texto preta
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }

    // Method to draw the Sprint Evaluation Table Header
    function DrawSprintTableHeader()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(131, 181, 105); // Cor de fundo verde
        $this->SetTextColor(0, 0, 0);
        $this->Cell($this->colwidthsSprint['Entrega'], 7, utf8_decode('Entrega'), 1, 0, 'C', true); 
        $this->Cell($this->colwidthsSprint['Entregue'], 7, utf8_decode('Entregue'), 1, 0, 'C', true); 
        $this->Cell($this->colwidthsSprint['NoPrazo'], 7, utf8_decode('No Prazo'), 1, 0, 'C', true); 
        $this->Cell($this->colwidthsSprint['Notas'], 7, utf8_decode('Notas'), 1, 1, 'C', true); // 1 for newline
        $this->SetFont('Arial', '', 8); // Reset font for table data
    }

    // Method to draw a row in the Sprint Evaluation Table
    function DrawSprintTableRow($data, $fill = false)
    {
         // Store current position
        $x = $this->GetX();
        $y = $this->GetY();
        
        // Calculate the height of the row based on content in MultiCells
        $nb=0;
        $nb = max($nb, $this->NbLines($this->colwidthsSprint['Entrega'], utf8_decode($data['Entrega'])));
        if (!empty($data['Notas'])) {
             $nb = max($nb, $this->NbLines($this->colwidthsSprint['Notas'], utf8_decode($data['Notas'])));
        }
        $rowHeight = 5 * $nb; // 5 is the line height, calculate total row height
        $rowHeight = max($rowHeight, 6); // Minimum row height

        // Draw cells with full height and borders
        $this->Cell($this->colwidthsSprint['Entrega'], $rowHeight, '', 1, 0, 'L', $fill);
        $this->Cell($this->colwidthsSprint['Entregue'], $rowHeight, '', 1, 0, 'C', $fill);
        $this->Cell($this->colwidthsSprint['NoPrazo'], $rowHeight, '', 1, 0, 'C', $fill);
        $this->Cell($this->colwidthsSprint['Notas'], $rowHeight, '', 1, 1, 'L', $fill); // 1 for newline

        // Place content
        $this->SetXY($x, $y);
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(0, 0, 0);

        $this->MultiCell($this->colwidthsSprint['Entrega'], 5, utf8_decode($data['Entrega']), 0, 'L', false);

        $this->SetXY($x + $this->colwidthsSprint['Entrega'], $y + ($rowHeight - 5) / 2); 
        $this->Cell($this->colwidthsSprint['Entregue'], 5, utf8_decode($data['Entregue']), 0, 0, 'C', false);

        $this->SetXY($x + $this->colwidthsSprint['Entrega'] + $this->colwidthsSprint['Entregue'], $y + ($rowHeight - 5) / 2); 
        $this->Cell($this->colwidthsSprint['NoPrazo'], 5, utf8_decode($data['No Prazo']), 0, 0, 'C', false);

        $this->SetXY($x + $this->colwidthsSprint['Entrega'] + $this->colwidthsSprint['Entregue'] + $this->colwidthsSprint['NoPrazo'], $y);
        $this->MultiCell($this->colwidthsSprint['Notas'], 5, utf8_decode($data['Notas']), 0, 'L', false);

        $this->SetY($y + $rowHeight);
    }

    // Method to draw the Student List Header
     function DrawStudentListHeader()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(190, 190, 190); // Cor de fundo cinza
        $this->SetTextColor(0, 0, 0);
        $this->Cell($this->colwidthsAluno['Nome'], 7, utf8_decode('Nome'), 1, 0, 'C', true);
        $this->Cell($this->colwidthsAluno['Entregas Individuais'], 7, utf8_decode('Entregas Individuais'), 1, 0, 'C', true);
        $this->Cell($this->colwidthsAluno['Entregas Grupo'], 7, utf8_decode('Entregas Grupo'), 1, 0, 'C', true);
        $this->Cell($this->colwidthsAluno['Nota Final'], 7, utf8_decode('Nota Final'), 1, 1, 'C', true);
         $this->SetFont('Arial', '', 8); // Reset font
    }

    // Method to draw a row in the Student List
     function DrawStudentListRow($data, $fill = false)
    {
        $this->SetFillColor(240, 240, 240); // Cor de fundo para as linhas (opcional)
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 8);

        $this->Cell($this->colwidthsAluno['Nome'], 6, utf8_decode($data['nome']), 1, 0, 'L', $fill);
        $this->Cell($this->colwidthsAluno['Entregas Individuais'], 6, utf8_decode($data['entregas_individuais']), 1, 0, 'C', $fill);
        $this->Cell($this->colwidthsAluno['Entregas Grupo'], 6, utf8_decode($data['entregas_grupo']), 1, 0, 'C', $fill);
        $this->Cell($this->colwidthsAluno['Nota Final'], 6, utf8_decode($data['nota']), 1, 1, 'C', $fill);
    }

    // Computes the number of lines a MultiCell of width w will take
    function NbLines($w, $txt)
    {
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace('\r','',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=='\n')
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=='\n')
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

     // Override AcceptPageBreak to handle redrawing headers
     function AcceptPageBreak()
     {
         $this->AddPage($this->CurOrientation);
         $this->SetY($this->headerY); // Reset Y below the main header

         // Redraw headers depending on context - this part is tricky without knowing the exact context
         // For simplicity, let's just redraw the main report title header
         // A more complex implementation would check what table/list was being drawn before the break

         return true; // Allow the page break
     }
}

// Obter conexão com o banco de dados login_parcial
$conexao = getConnection(); 

if ($conexao === null) {
    die('Erro: Falha ao conectar ao banco de dados login_parcial. Verifique a configuração de connect.php.');
}

// Consultar dados da tabela avaliacoes_entregas, ordenando por equipe
try {
    $stmtAvaliacoes = $conexao->query("SELECT * FROM avaliacoes_entregas ORDER BY equipe");
    $avaliacoes = $stmtAvaliacoes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erro ao consultar banco de dados (avaliacoes_entregas): ' . $e->getMessage());
}

// Consultar dados da tabela aluno, ordenando por equipe e nome
try {
    $stmtAlunos = $conexao->query("SELECT id, nome, equipe, entregas_individuais, entregas_grupo, nota FROM aluno ORDER BY equipe, nome");
    $alunos = $stmtAlunos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erro ao consultar banco de dados (aluno): ' . $e->getMessage());
}

// Verificar se há dados para gerar o relatório
if (empty($avaliacoes) && empty($alunos)) {
    die('Nenhuma avaliação ou aluno encontrado para gerar o relatório.');
}

// Crie uma instância do PDF em formato paisagem ('L')
$pdf = new PDF('L');

$currentTeam = '';

// Lista de entregas para iterar e exibir (reutilizando do relatório anterior)
$entregas = [
    'sprint1_doc' => 'Sprint 1 - Documento Descritivo',
    'sprint1_reqs' => 'Sprint 1 - Requisitos Funcionais e Nao Funcionais',
    'sprint2_caso_uso' => 'Sprint 2 - Diagrama de Caso de Uso',
    'sprint2_atividades' => 'Sprint 2 - Diagrama de Atividades',
    'sprint3_conceitual' => 'Sprint 3 - Modelagem Conceitual',
    'sprint3_logica' => 'Sprint 3 - Modelagem Lógica',
    'sprint3_fisica' => 'Sprint 3 - Modelagem Física',
    'sprint4_prototipo' => 'Sprint 4 - Protótipo de Telas + Validação',
    'sprint4_storyboard' => 'Sprint 4 - Storyboard',
    'sprint5_doc_final' => 'Sprint 5 - Documentação Completa',
    'sprint5_interface' => 'Sprint 5 - Interface + 1 Funcionalidade',
    'sprint5_relatorio' => 'Sprint 5 - Relatório FPDF',
    'sprint5_personalizada1' => 'Sprint 5 - Entrega Personalizada 1',
    'sprint5_personalizada2' => 'Sprint 5 - Entrega Personalizada 2',
    'sprint5_final' => 'Sprint 5 - Entrega Final do Projeto',
    'ajustes_areadev' => 'Ajustes Finais - Validação ou ajustes extras solicitados pela AREADEV',
];

$fill = false; // Alternar cor de fundo das linhas da tabela

foreach ($avaliacoes as $avaliacao) {
     // Verificar se a equipe mudou
     if ($avaliacao['equipe'] !== $currentTeam) {
         $currentTeam = $avaliacao['equipe'];

         // Adicionar um cabeçalho para a nova equipe
         $pdf->AddPage('L'); // Start a new page for each team, ensure landscape
         $pdf->SetFont('Arial', 'B', 14);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->Cell(0, 10, utf8_decode('Equipe: ' . $currentTeam), 0, 1, 'L', false);
         $pdf->Ln(5);

         // Listar alunos desta equipe
         $pdf->SetFont('Arial', 'B', 10);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->Cell(0, 7, utf8_decode('Alunos:'), 0, 1, 'L');
         $pdf->Ln(2);

         // Draw Student List Header
         $pdf->DrawStudentListHeader();
         $fillAluno = false;
         foreach ($alunos as $aluno) {
             if ($aluno['equipe'] === $currentTeam) {
                 $pdf->DrawStudentListRow($aluno, $fillAluno);
                 $fillAluno = !$fillAluno;
             }
         }
         $pdf->Ln(5); // Espaço após a lista de alunos

         // Adicionar cabeçalho da tabela de Sprints para a equipe
         $pdf->SetFont('Arial', 'B', 10);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->Cell(0, 7, utf8_decode('Avaliações de Entregas:'), 0, 1, 'L');
         $pdf->Ln(2);
         $pdf->DrawSprintTableHeader();
         $fill = false; // Reset fill for sprint table
     }

    // Adicionar linha da tabela de Sprints para a avaliação atual
    $entregue = (isset($avaliacao[$prefix . '_entregue']) && $avaliacao[$prefix . '_entregue'] === 1) ? utf8_decode('Sim') : utf8_decode('Nao');
    $prazo = (isset($avaliacao[$prefix . '_prazo']) && $avaliacao[$prefix . '_prazo'] === 1) ? utf8_decode('Sim') : utf8_decode('Nao');
    $notas = isset($avaliacao[$prefix . '_notas']) && !empty($avaliacao[$prefix . '_notas']) ? utf8_decode($avaliacao[$prefix . '_notas']) : '';

    // Data for the sprint row
    $sprintRowData = [
        'Entrega' => $entregas[$prefix],
        'Entregue' => $entregue,
        'No Prazo' => $prazo,
        'Notas' => $notas
    ];

     // Find the correct delivery description using the prefix from $avaliacao
     $sprintPrefix = null;
     foreach($entregas as $key => $description) {
         // Assuming the keys in $avaliacao match the $entregas prefixes (e.g., sprint1_doc_entregue -> sprint1_doc)
         if (strpos(key($avaliacao), $key) === 0) {
             $sprintPrefix = $key;
             break;
         }
     }

     if ($sprintPrefix) {
          $sprintRowData['Entrega'] = $entregas[$sprintPrefix];
          $entregue = (isset($avaliacao[$sprintPrefix . '_entregue']) && $avaliacao[$sprintPrefix . '_entregue'] === 1) ? utf8_decode('Sim') : utf8_decode('Nao');
          $prazo = (isset($avaliacao[$sprintPrefix . '_prazo']) && $avaliacao[$sprintPrefix . '_prazo'] === 1) ? utf8_decode('Sim') : utf8_decode('Nao');
          $notas = isset($avaliacao[$sprintPrefix . '_notas']) && !empty($avaliacao[$sprintPrefix . '_notas']) ? utf8_decode($avaliacao[$sprintPrefix . '_notas']) : '';

          $sprintRowData = [
             'Entrega' => $entregas[$sprintPrefix],
             'Entregue' => $entregue,
             'No Prazo' => $prazo,
             'Notas' => $notas
         ];

         $pdf->DrawSprintTableRow($sprintRowData, $fill);
         $fill = !$fill; // Alternar cor de fundo
     }
     // Note: The original loop iterates through $avaliacoes, which are rows from the avaliacoes_entregas table.
     // Each row in avaliacoes_entregas contains all sprint evaluations for a *single team*.
     // The inner loop structure based on $entregas was for the previous report where we iterated through deliveries for one team's evaluation.
     // We need to adapt this to process the single row of $avaliacao.

     // Let's re-think the inner loop based on the structure of $avaliacao
     // $avaliacao is one row from avaliacoes_entregas, containing columns like sprint1_doc_entregue, sprint1_doc_notas, etc.
     // We need to iterate through the *columns* of $avaliacao that correspond to sprint deliveries.

     // Let's map column prefixes to delivery descriptions once
     $deliveryColumns = [
         'sprint1_doc' => 'Sprint 1 - Documento Descritivo',
         'sprint1_reqs' => 'Sprint 1 - Requisitos Funcionais e Nao Funcionais',
         'sprint2_caso_uso' => 'Sprint 2 - Diagrama de Caso de Uso',
         'sprint2_atividades' => 'Sprint 2 - Diagrama de Atividades',
         'sprint3_conceitual' => 'Sprint 3 - Modelagem Conceitual',
         'sprint3_logica' => 'Sprint 3 - Modelagem Lógica',
         'sprint3_fisica' => 'Sprint 3 - Modelagem Física',
         'sprint4_prototipo' => 'Sprint 4 - Protótipo de Telas + Validação',
         'sprint4_storyboard' => 'Sprint 4 - Storyboard',
         'sprint5_doc_final' => 'Sprint 5 - Documentação Completa',
         'sprint5_interface' => 'Sprint 5 - Interface + 1 Funcionalidade',
         'sprint5_relatorio' => 'Sprint 5 - Relatório FPDF',
         'sprint5_personalizada1' => 'Sprint 5 - Entrega Personalizada 1',
         'sprint5_personalizada2' => 'Sprint 5 - Entrega Personalizada 2',
         'sprint5_final' => 'Sprint 5 - Entrega Final do Projeto',
         'ajustes_areadev' => 'Ajustes Finais - Validação ou ajustes extras solicitados pela AREADEV',
     ];

     // Iterate through the delivery columns for the current team's evaluation ($avaliacao)
     $fillSprint = false; // Alternar cor de fundo para a tabela de sprints
     foreach ($deliveryColumns as $prefix => $description) {
         $entregue = (isset($avaliacao[$prefix . '_entregue']) && $avaliacao[$prefix . '_entregue'] === 1) ? utf8_decode('Sim') : utf8_decode('Nao');
         $prazo = (isset($avaliacao[$prefix . '_prazo']) && $avaliacao[$prefix . '_prazo'] === 1) ? utf8_decode('Sim') : utf8_decode('Nao');
         $notas = isset($avaliacao[$prefix . '_notas']) && !empty($avaliacao[$prefix . '_notas']) ? utf8_decode($avaliacao[$prefix . '_notas']) : '';

         $sprintRowData = [
             'Entrega' => $description,
             'Entregue' => $entregue,
             'No Prazo' => $prazo,
             'Notas' => $notas
         ];

         $pdf->DrawSprintTableRow($sprintRowData, $fillSprint);
         $fillSprint = !$fillSprint; // Alternar cor de fundo
     }

     $pdf->Ln(10); // Espaço após a tabela de sprints para a equipe

}

$pdf->Output('relatorio_combinado.pdf', 'I'); // 'I' para exibir no navegador, 'D' para download

?> 