<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../model/Demanda.php';
require_once __DIR__ . '/../../model/Usuario.php';
require_once __DIR__ . '/../../assets/fpdf/fpdf.php';

session_start();

// Inicializa a conexão com o banco de dados
$database = new Database();
$pdo = $database->getConnection();

// Verificar se está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Classe FPDF customizada com estilo
class RelatorioEstatisticasPDF extends FPDF {
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
        $this->Cell(120, 10, utf8_decode('Relatório de Estatísticas'), 0, 1, 'L');

        // Subtítulo
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(...$this->cores['subtitulo']);
        $this->SetX(15);
        $this->Cell(120, 5, utf8_decode('Resumo Geral e por Usuário'), 0, 1, 'L');

        // Data de geração
        $this->SetFont('Arial', 'I', 9);
        $this->SetX(15);
        date_default_timezone_set('America/Sao_Paulo');
        $this->Cell(120, 5, utf8_decode('Gerado em: ' . date('d/m/Y H:i')), 0, 1, 'L');

        // Linha separadora
        $this->SetDrawColor(...$this->cores['primaria']);
        $this->SetLineWidth(0.5);
        $this->Line(10, 40, 200, 40);

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

    // Título de seção
    function TituloSecao($titulo) {
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(...$this->cores['primaria']);
        $this->Cell(0, 10, utf8_decode($titulo), 0, 1, 'L');
        $this->SetDrawColor(...$this->cores['primaria']);
        $this->SetLineWidth(0.3);
        $this->Line(10, $this->GetY(), 150, $this->GetY());
        $this->Ln(5);
    }

    // Célula de estatística
    function CelulaEstatistica($label, $valor, $cor_valor = 'destaque') {
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(...$this->cores['texto']);
        $this->Cell(50, 7, utf8_decode($label), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(...$this->cores[$cor_valor]);
        $this->Cell(20, 7, $valor, 0, 1, 'L');
    }

     // Tabela de usuários
    function TabelaUsuarios($dadosUsuarios) {
        $this->TituloSecao('Estatísticas por Usuário');

        // Cabeçalho da tabela
        $this->SetFillColor(220, 240, 230); // Cor de fundo clara
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(...$this->cores['texto']);
        $this->Cell(60, 7, utf8_decode('Usuário'), 1, 0, 'L', true);
        $this->Cell(40, 7, utf8_decode('Concluídas'), 1, 0, 'C', true);
        $this->Cell(40, 7, utf8_decode('Pendentes'), 1, 1, 'C', true);

        // Dados da tabela
        $this->SetFont('Arial', '', 10);
        $row_bg1 = [255, 255, 255]; // Branco
        $row_bg2 = [245, 250, 245]; // Cinza claro
        $fill = false;

        foreach ($dadosUsuarios as $estat) {
            $bg = $fill ? $row_bg2 : $row_bg1;
            $this->SetFillColor(...$bg);
            $this->SetTextColor(...$this->cores['texto']);
            $this->Cell(60, 7, utf8_decode($estat['nome']), 1, 0, 'L', true);
            $this->SetTextColor(...$this->cores['primaria']);
            $this->Cell(40, 7, $estat['concluidas'], 1, 0, 'C', true);
            $this->SetTextColor(...$this->cores['subtitulo']);
            $this->Cell(40, 7, $estat['pendentes'], 1, 1, 'C', true);
            $fill = !$fill;
        }
    }

    // Tabela de estatísticas gerais
    function TabelaEstatisticasGerais($dados) {
        $this->TituloSecao('Estatísticas Gerais');

        // Cabeçalho da tabela
        $this->SetFillColor(220, 240, 230); // Cor de fundo clara
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(...$this->cores['texto']);
        $this->Cell(100, 7, utf8_decode('Indicador'), 1, 0, 'L', true);
        $this->Cell(40, 7, utf8_decode('Valor'), 1, 1, 'C', true);

        // Dados da tabela
        $this->SetFont('Arial', '', 10);
        $row_bg1 = [255, 255, 255]; // Branco
        $row_bg2 = [245, 250, 245]; // Cinza claro
        $fill = false;

        $estatisticas = [
            ['Total de Demandas', $dados['total_demandas'], 'primaria'],
            ['Demandas em Espera', $dados['em_espera'], 'subtitulo'],
            ['Demandas em Andamento', $dados['em_andamento'], 'destaque'],
            ['Demandas Concluídas', $dados['concluidas'], 'primaria'],
            ['Demandas Canceladas', $dados['canceladas'], 'subtitulo'],
            ['Total de Usuários', $dados['total_usuarios'], 'primaria']
        ];

        foreach ($estatisticas as $estat) {
            $bg = $fill ? $row_bg2 : $row_bg1;
            $this->SetFillColor(...$bg);
            $this->SetTextColor(...$this->cores['texto']);
            $this->Cell(100, 7, utf8_decode($estat[0]), 1, 0, 'L', true);
            $this->SetTextColor(...$this->cores[$estat[2]]);
            $this->Cell(40, 7, $estat[1], 1, 1, 'C', true);
            $fill = !$fill;
        }
    }
}

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
$pdf = new RelatorioEstatisticasPDF();
$pdf->AliasNbPages();
$pdf->AddPage(); // Pode ser 'L' para paisagem se necessário, mas A4 retrato deve caber

// Estatísticas por Usuário
$pdf->TabelaUsuarios($estatisticasUsuarios);

$pdf->Ln(10);

// Estatísticas gerais
$dadosEstatisticas = [
    'total_demandas' => $totalDeDemandas,
    'em_espera' => $demandasEmEspera,
    'em_andamento' => $demandasEmAndamento,
    'concluidas' => $demandasConcluidas,
    'canceladas' => $demandasCanceladas,
    'total_usuarios' => $totalDeUsuarios
];
$pdf->TabelaEstatisticasGerais($dadosEstatisticas);

// Saída do PDF
$pdf->Output('I', 'relatorio_estatisticas.pdf');

?> 