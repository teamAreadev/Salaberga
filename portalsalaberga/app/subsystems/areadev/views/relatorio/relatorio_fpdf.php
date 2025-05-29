<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../model/Demanda.php';
require_once __DIR__ . '/../../model/Usuario.php';
require_once __DIR__ . '/../../assets/fpdf/fpdf.php';

session_start();

// Verificar se está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Classe FPDF customizada com estilo
class RelatorioPDF extends FPDF {
    private $cores = [
        'primaria' => [0, 122, 51],    // Verde institucional
        'secundaria' => [240, 240, 240], // Cinza claro para fundo
        'destaque' => [0, 90, 40],     // Verde escuro
        'texto' => [40, 40, 40],       // Cinza escuro para texto
        'subtitulo' => [100, 100, 100] // Cinza médio para subtítulos
    ];

    // Configurações iniciais
    function __construct() {
        parent::__construct('P', 'mm', 'A4');
        $this->SetAutoPageBreak(true, 25);
        $this->SetMargins(10, 15, 10);
        $this->SetFont('Arial', '', 10); // Define a fonte padrão
    }

    // Cabeçalho
    function Header() {
        // Fundo do cabeçalho
        $this->SetFillColor(...$this->cores['secundaria']);
        $this->Rect(0, 0, $this->GetPageWidth(), 40, 'F');

        // Logo (verifique o caminho da imagem)
        // $this->Image('caminho/para/logo.png', 15, 10, 25);

        // Título
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(...$this->cores['primaria']);
        $this->SetXY(15, 15);
        $this->Cell(120, 10, utf8_decode('Relatório Geral de Demandas'), 0, 1, 'L');

        // Subtítulo
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(...$this->cores['subtitulo']);
        $this->SetX(15);
        $this->Cell(120, 5, utf8_decode('Visão Geral do Sistema'), 0, 1, 'L');

        // Data de geração
        $this->SetFont('Arial', 'I', 9);
        $this->SetX(15);
        date_default_timezone_set('America/Sao_Paulo');
        $this->Cell(120, 5, utf8_decode('Gerado em: ' . date('d/m/Y H:i')), 0, 1, 'L');

        // Linha separadora
        $this->SetDrawColor(...$this->cores['primaria']);
        $this->SetLineWidth(0.5);
        $this->Line(10, 40, $this->GetPageWidth() - 10, 40);

        $this->SetY(45);
    }

    // Rodapé
    function Footer() {
        $this->SetY(-18);
        $this->SetDrawColor(...$this->cores['primaria']);
        $this->SetLineWidth(0.3);
        $this->Line(10, $this->GetPageHeight() - 20, $this->GetPageWidth() - 10, $this->GetPageHeight() - 20);

        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(...$this->cores['subtitulo']);
        $this->Cell(0, 5, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('Sistema de Gestão de Demandas - Todos os direitos reservados'), 0, 0, 'C');
    }

    // Função auxiliar para ajustar texto
    function ajustarTexto($texto, $largura_celula) {
        $texto = utf8_decode($texto);
        while ($this->GetStringWidth($texto) > $largura_celula - 2 && strlen($texto) > 0) {
            $texto = substr($texto, 0, -1);
        }
        return $texto;
    }

    // Título de seção
    function TituloSecao($titulo) {
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(...$this->cores['primaria']);
        $this->Cell(0, 10, utf8_decode($titulo), 0, 1, 'L');
        $this->SetDrawColor(...$this->cores['primaria']);
        $this->SetLineWidth(0.3);
        $this->Line(10, $this->GetY(), 287, $this->GetY());
        $this->Ln(5);
    }

    // Célula de estatística
    function CelulaEstatistica($label, $valor, $cor_valor = 'destaque') {
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(...$this->cores['texto']);
        $this->Cell(60, 7, utf8_decode($label), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(...$this->cores[$cor_valor]);
        $this->Cell(0, 7, $valor, 0, 1, 'L');
    }

    // Tabela de usuários
    function TabelaUsuarios($dadosUsuarios) {
        $this->TituloSecao('Estatísticas por Usuário');

        // Cabeçalho da tabela
        $this->SetFillColor(220, 240, 230); // Cor de fundo clara
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(...$this->cores['texto']);
        $this->Cell(80, 7, utf8_decode('Usuário'), 1, 0, 'L', true);
        $this->Cell(50, 7, utf8_decode('Demandas Concluídas'), 1, 0, 'C', true);
        $this->Cell(50, 7, utf8_decode('Demandas Pendentes'), 1, 1, 'C', true);

        // Dados da tabela
        $this->SetFont('Arial', '', 10);
        $row_bg1 = [255, 255, 255]; // Branco
        $row_bg2 = [245, 250, 245]; // Cinza claro
        $fill = false;

        foreach ($dadosUsuarios as $estat) {
            $bg = $fill ? $row_bg2 : $row_bg1;
            $this->SetFillColor(...$bg);
            $this->SetTextColor(...$this->cores['texto']);
            $this->Cell(80, 7, $this->ajustarTexto($estat['nome'], 80), 1, 0, 'L', true);
            $this->SetTextColor(...$this->cores['primaria']);
            $this->Cell(50, 7, $estat['concluidas'], 1, 0, 'C', true);
            $this->SetTextColor(...$this->cores['subtitulo']);
            $this->Cell(50, 7, $estat['pendentes'], 1, 1, 'C', true);
            $fill = !$fill;
        }
    }

    // Tabela de demandas existentes (melhorada)
    function TabelaDemandasExistentes($demandas) {
        $this->TituloSecao('Demandas Existentes');
        
        // Cabeçalho da tabela
        $this->SetFillColor(220, 240, 230); // Cor de fundo clara
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(...$this->cores['texto']);
        $cellWidths = [58, 120, 40, 59]; // Larguras das colunas: Título, Descrição, Prazo, Quem Realiza
        $header = [utf8_decode('Título'), utf8_decode('Descrição'), 'Prazo', utf8_decode('Quem Realiza')];
  
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($cellWidths[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();

        // Dados da tabela
        $this->SetFont('Arial', '', 10);
        $row_bg1 = [255, 255, 255]; // Branco
        $row_bg2 = [245, 250, 245]; // Cinza claro
        $fill = false;

        foreach ($demandas as $demanda) {
            $bg = $fill ? $row_bg2 : $row_bg1;
            $this->SetFillColor(...$bg);
            $this->SetTextColor(...$this->cores['texto']);

            // Formatar dados
            $titulo = $this->ajustarTexto($demanda['titulo'], $cellWidths[0]);
            $descricao = $this->ajustarTexto($demanda['descricao'], $cellWidths[1]);
            $prazo_inicio = !empty($demanda['data_criacao']) ? date('d/m/Y', strtotime($demanda['data_criacao'])) : '-';
            $prazo_fim = !empty($demanda['data_conclusao']) ? date('d/m/Y', strtotime($demanda['data_conclusao'])) :
                         (!empty($demanda['prazo']) ? date('d/m/Y', strtotime($demanda['prazo'])) : '-');
            $prazo = $prazo_inicio . ' | ' . $prazo_fim;

            $realizadores = '';
            if (!empty($demanda['usuarios_atribuidos'])) {
                $nomes = [];
                foreach ($demanda['usuarios_atribuidos'] as $usuario) {
                    if (isset($usuario['status']) && in_array($usuario['status'], ['aceito', 'em_andamento'])) {
                        $nomes[] = utf8_decode($usuario['nome']);
                    }
                }
                $realizadores = !empty($nomes) ? $this->ajustarTexto(implode(', ', $nomes), $cellWidths[3]) : 'Nenhum aceito';
            } else {
                $realizadores = 'Nenhum atribuído';
            }

            // Verificar altura necessária para a linha
            $maxHeight = 7;
            $lineHeight = 5;
            $cellContents = [$titulo, $descricao, $prazo, $realizadores];
            foreach ($cellContents as $i => $content) {
                $lines = ceil($this->GetStringWidth($content) / ($cellWidths[$i] - 2));
                $requiredHeight = $lines * $lineHeight;
                $maxHeight = max($maxHeight, $requiredHeight);
            }

            // Renderizar linha
            $startY = $this->GetY();
            $startX = $this->GetX();

            $this->MultiCell($cellWidths[0], $maxHeight, $titulo, 1, 'L', true);
            $this->SetXY($startX + $cellWidths[0], $startY);
            $this->MultiCell($cellWidths[1], $maxHeight, $descricao, 1, 'L', true);
            $this->SetXY($startX + $cellWidths[0] + $cellWidths[1], $startY);
            $this->Cell($cellWidths[2], $maxHeight, $prazo, 1, 0, 'C', $fill);
            $this->SetXY($startX + $cellWidths[0] + $cellWidths[1] + $cellWidths[2], $startY);
            $this->MultiCell($cellWidths[3], $maxHeight, $realizadores, 1, 'L', true, 1);

            // After drawing the last cell of the row, manually set the Y position for the next row
            $this->SetY($startY + $maxHeight);

            $fill = !$fill;
        }
    }
}

// Inicializa a conexão com o banco de dados
$database = new Database();
$pdo = $database->getConnection();

$demanda = new Demanda($pdo);
$usuario = new Usuario($pdo);

// Buscar estatísticas gerais
$totalDemandas = $demanda->listarDemandas();
$demandasEmEspera = 0;
$demandasEmAndamento = 0;
$demandasConcluidas = 0;
$demandasCanceladas = 0;

foreach ($totalDemandas as $d) {
    switch ($d['status']) {
        case 'pendente':
            $demandasEmEspera++;
            break;
        case 'em_andamento':
            $demandasEmAndamento++;
            break;
        case 'concluida':
            $demandasConcluidas++;
            break;
        case 'cancelada':
            $demandasCanceladas++;
            break;
    }
}

$totalDeDemandas = count($totalDemandas);
$totalDeUsuarios = count($usuario->listarUsuarios());

// Buscar estatísticas por usuário
$usuarios = $usuario->listarUsuarios();
$estatisticasUsuarios = [];

foreach ($usuarios as $user) {
    $demandasUsuario = $demanda->listarDemandasPorUsuario($user['id']);
    $concluidas = 0;
    $pendentes = 0;

    foreach ($demandasUsuario as $d) {
        if (isset($d['status_usuario']) && $d['status_usuario'] === 'concluido') {
            $concluidas++;
        } elseif (isset($d['status_usuario']) && $d['status_usuario'] === 'pendente') {
            $pendentes++;
        }
    }

    $estatisticasUsuarios[] = [
        'nome' => $user['nome'],
        'concluidas' => $concluidas,
        'pendentes' => $pendentes
    ];
}

// Gerar PDF
$pdf = new RelatorioPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L'); // 'L' para Paisagem

// Tabela de Demandas Existentes
$pdf->TabelaDemandasExistentes($totalDemandas);

// Saída do PDF
$pdf->Output('I', 'relatorio_geral.pdf');
?>