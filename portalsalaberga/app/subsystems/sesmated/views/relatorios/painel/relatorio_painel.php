<?php
require_once('../../../config/connect.php');
require_once('../../../assets/fpdf/fpdf.php');
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

    public function main()
    {
        $fpdf = new FPDF('P', 'pt', 'A4');
        $fpdf->AliasNbPages();

        // Primeira página: Tabelas com somatório e bônus
        $fpdf->AddPage();
        $fpdf->Image('../../../assets/fundo.jpg', 0, 0, $fpdf->GetPageWidth(), $fpdf->GetPageHeight());

        // Consulta SQL para a primeira página
        $query = "
            SELECT 
                c.nome_curso,
                SUM(p.adequacao_tema) as total_adequacao,
                SUM(p.qualidade_conteudo) as total_qualidade,
                SUM(p.organizacao_layout) as total_layout,
                SUM(p.estetica_criatividade) as total_criatividade,
                SUM(p.sustentabilidade_construcao) as total_sustentabilidade
            FROM cursos c 
            INNER JOIN tarefa_14_painel p ON p.curso_id = c.curso_id 
            GROUP BY c.nome_curso
            ORDER BY (SUM(p.adequacao_tema) + SUM(p.qualidade_conteudo) + SUM(p.organizacao_layout) + SUM(p.estetica_criatividade) + SUM(p.sustentabilidade_construcao)) DESC;
        ";
        $stmt = $this->connect->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Título principal
        $fpdf->SetFont('Arial', 'B', 24);
        $fpdf->SetY(140);
        $fpdf->SetX(0);
        $fpdf->Cell(595, 20, utf8_decode('Tarefa 14: Painel'), 0, 1, 'C');

        // Título da primeira tabela
        $fpdf->SetFont('Arial', 'B', 14);
        $fpdf->SetY(180);
        $fpdf->SetX(0);
        $fpdf->Cell(595, 20, utf8_decode('Detalhamento por Critério'), 0, 1, 'C');

        // Configurações da primeira tabela
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->SetFillColor(255, 255, 255);
        $fpdf->SetTextColor(0, 0, 0);

        // Cabeçalho da primeira tabela
        $fpdf->SetY(220);
        $fpdf->SetX(30);
        $fpdf->Cell(80, 20, utf8_decode('Curso'), 1, 0, 'C', true);
        $fpdf->Cell(90, 20, utf8_decode('Adequação'), 1, 0, 'C', true);
        $fpdf->Cell(90, 20, utf8_decode('Qualidade'), 1, 0, 'C', true);
        $fpdf->Cell(90, 20, utf8_decode('Layout'), 1, 0, 'C', true);
        $fpdf->Cell(90, 20, utf8_decode('Criatividade'), 1, 0, 'C', true);
        $fpdf->Cell(90, 20, utf8_decode('Sustentabilidade'), 1, 1, 'C', true);

        // Dados da primeira tabela
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->SetFillColor(240, 240, 240);
        $fill = false;
        foreach ($results as $row) {
            $fpdf->SetX(30);
            $fpdf->Cell(80, 20, utf8_decode($row['nome_curso']), 1, 0, 'C', $fill);
            $fpdf->Cell(90, 20, utf8_decode($row['total_adequacao']), 1, 0, 'C', $fill);
            $fpdf->Cell(90, 20, utf8_decode($row['total_qualidade']), 1, 0, 'C', $fill);
            $fpdf->Cell(90, 20, utf8_decode($row['total_layout']), 1, 0, 'C', $fill);
            $fpdf->Cell(90, 20, utf8_decode($row['total_criatividade']), 1, 0, 'C', $fill);
            $fpdf->Cell(90, 20, utf8_decode($row['total_sustentabilidade']), 1, 1, 'C', $fill);
            $fill = !$fill;
        }

        // Título da segunda tabela
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Ln(20);
        $fpdf->SetX(0);
        $fpdf->Cell(595, 20, utf8_decode('Soma Total dos Critérios por Curso'), 0, 1, 'C');
        $fpdf->Ln(20);
        // Configurações da segunda tabela
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->SetFillColor(255, 255, 255);
        $fpdf->SetTextColor(0, 0, 0);

        // Cabeçalho da segunda tabela
        $fpdf->SetX(130);
        $fpdf->Cell(120, 20, utf8_decode('Curso'), 1, 0, 'C', true);
        $fpdf->Cell(100, 20, utf8_decode('Soma Total'), 1, 0, 'C', true);
        $fpdf->Cell(100, 20, utf8_decode('Pontuação'), 1, 1, 'C', true);

        // Dados da segunda tabela
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->SetFillColor(240, 240, 240);
        $fill = false;
        $rank = 1;
        foreach ($results as $row) {
            $total = $row['total_adequacao'] + $row['total_qualidade'] + $row['total_layout'] + $row['total_criatividade'] + $row['total_sustentabilidade'];
            $bonus = 0;
            switch ($rank) {
                case 1:
                    $bonus = 500;
                    break;
                case 2:
                    $bonus = 450;
                    break;
                case 3:
                    $bonus = 400;
                    break;
                case 4:
                    $bonus = 350;
                    break;
                case 5:
                    $bonus = 300;
                    break;
                default:
                    $bonus = 0;
                    break;
            }
            $fpdf->SetX(130);
            $fpdf->Cell(120, 20, utf8_decode($row['nome_curso']), 1, 0, 'C', $fill);
            $fpdf->Cell(100, 20, utf8_decode($total), 1, 0, 'C', $fill);
            $fpdf->Cell(100, 20, utf8_decode($bonus), 1, 1, 'C', $fill);
            $fill = !$fill;
            $rank++;
        }

        // Segunda página: Relatório detalhado por avaliador
        $fpdf->AddPage();
        $fpdf->Image('../../../assets/fundo.jpg', 0, 0, $fpdf->GetPageWidth(), $fpdf->GetPageHeight());

        // Consulta SQL para a segunda página
        $query_original = "
            SELECT 
                c.nome_curso, 
                a.nome, 
                p.adequacao_tema, 
                p.qualidade_conteudo, 
                p.organizacao_layout, 
                p.estetica_criatividade, 
                p.sustentabilidade_construcao
            FROM cursos c 
            INNER JOIN tarefa_14_painel p ON p.curso_id = c.curso_id 
            INNER JOIN avaliadores a ON a.id = p.id_avaliador
            ORDER BY c.curso_id, a.nome;
        ";
        $stmt_original = $this->connect->query($query_original);
        $results_original = $stmt_original->fetchAll(PDO::FETCH_ASSOC);

        // Título da tabela na segunda página
        $fpdf->SetFont('Arial', 'B', 14);
        $fpdf->SetY(140);
        $fpdf->SetX(0);
        $fpdf->Cell(595, 20, utf8_decode('Relatório Detalhado por Avaliador'), 0, 1, 'C');

        // Configurações da tabela
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->SetFillColor(255, 255, 255);
        $fpdf->SetTextColor(0, 0, 0);

        // Cabeçalho da tabela
        $fpdf->SetY(170);
        $fpdf->SetX(10);
        $fpdf->Cell(80, 20, utf8_decode('Curso'), 1, 0, 'C', true);
        $fpdf->Cell(140, 20, utf8_decode('Avaliador'), 1, 0, 'C', true);
        $fpdf->Cell(80, 20, utf8_decode('Adequação'), 1, 0, 'C', true);
        $fpdf->Cell(60, 20, utf8_decode('Qualidade'), 1, 0, 'C', true);
        $fpdf->Cell(40, 20, utf8_decode('Layout'), 1, 0, 'C', true);
        $fpdf->Cell(80, 20, utf8_decode('Criatividade'), 1, 0, 'C', true);
        $fpdf->Cell(90, 20, utf8_decode('Sustentabilidade'), 1, 1, 'C', true);

        // Dados da tabela
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->SetFillColor(240, 240, 240);
        $fill = false;
        foreach ($results_original as $row) {

            $fpdf->SetX(10);
            $fpdf->Cell(80, 20, utf8_decode($row['nome_curso']), 1, 0, 'C', $fill);
            $fpdf->Cell(140, 20, utf8_decode($row['nome']), 1, 0, 'C', $fill);
            $fpdf->Cell(80, 20, utf8_decode($row['adequacao_tema']), 1, 0, 'C', $fill);
            $fpdf->Cell(60, 20, utf8_decode($row['qualidade_conteudo']), 1, 0, 'C', $fill);
            $fpdf->Cell(40, 20, utf8_decode($row['organizacao_layout']), 1, 0, 'C', $fill);
            $fpdf->Cell(80, 20, utf8_decode($row['estetica_criatividade']), 1, 0, 'C', $fill);
            $fpdf->Cell(90, 20, utf8_decode($row['sustentabilidade_construcao']), 1, 1, 'C', $fill);
            $fill = !$fill;
        }

        // Terceira página: Tabela com bônus por colocação
        $fpdf->AddPage();
        $fpdf->Image('../../../assets/fundo.jpg', 0, 0, $fpdf->GetPageWidth(), $fpdf->GetPageHeight());

        // Título da terceira tabela
        $fpdf->SetFont('Arial', 'B', 14);
        $fpdf->SetY(140);
        $fpdf->SetX(0);
        $fpdf->Cell(595, 20, utf8_decode('Classificação com Pontos de Bônus'), 0, 1, 'C');

        // Configurações da terceira tabela
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->SetFillColor(255, 255, 255);
        $fpdf->SetTextColor(0, 0, 0);

        // Cabeçalho da terceira tabela
        $fpdf->SetY(170);
        $fpdf->SetX(100);
        $fpdf->Cell(150, 20, utf8_decode('Curso'), 1, 0, 'C', true);
        $fpdf->Cell(100, 20, utf8_decode('Soma Total'), 1, 0, 'C', true);
        $fpdf->Cell(100, 20, utf8_decode('Colocação'), 1, 0, 'C', true);
        $fpdf->Cell(100, 20, utf8_decode('Pontos de Bônus'), 1, 1, 'C', true);

        // Dados da terceira tabela
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->SetFillColor(240, 240, 240);
        $fill = false;
        $rank = 1;
        foreach ($results as $row) {
            $total = $row['total_adequacao'] + $row['total_qualidade'] + $row['total_layout'] + $row['total_criatividade'] + $row['total_sustentabilidade'];
            $bonus = 0;
            switch ($rank) {
                case 1:
                    $bonus = 500;
                    break;
                case 2:
                    $bonus = 450;
                    break;
                case 3:
                    $bonus = 400;
                    break;
                case 4:
                    $bonus = 350;
                    break;
                case 5:
                    $bonus = 300;
                    break;
                default:
                    $bonus = 0;
                    break;
            }
            $fpdf->SetX(100);
            $fpdf->Cell(150, 20, utf8_decode($row['nome_curso']), 1, 0, 'C', $fill);
            $fpdf->Cell(100, 20, utf8_decode($total), 1, 0, 'C', $fill);
            $fpdf->Cell(100, 20, utf8_decode($rank . 'º'), 1, 0, 'C', $fill);
            $fpdf->Cell(100, 20, utf8_decode($bonus), 1, 1, 'C', $fill);
            $fill = !$fill;
            $rank++;
        }

        // Gera o PDF
        $fpdf->Output('relatorio_painel.pdf', 'I');
    }
}

$relatorio = new PDF();
?>