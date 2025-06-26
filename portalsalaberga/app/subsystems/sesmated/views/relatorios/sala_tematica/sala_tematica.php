<?php
require_once('../../../config/connect.php');
require_once('../../../assets/fpdf/fpdf.php');

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

        // Adiciona uma página
        $fpdf->AddPage();

        // Adiciona o fundo, ajustando as dimensões
        $fpdf->Image('../../../assets/fundo.jpg', 0, 0, $fpdf->GetPageWidth(), $fpdf->GetPageHeight());

        // Consulta SQL
        $query = "
            SELECT c.nome_curso, a.nome, s.adequacao_tema, s.qualidade_conteudo, s.ambientacao_criatividade, 
                   s.didatica_clareza, s.trabalho_equipe, s.sustentabilidade_execucao
            FROM cursos c 
            INNER JOIN tarefa_13_sala_tematica s ON s.curso_id = c.curso_id 
            INNER JOIN avaliadores a ON a.id = s.id_avaliador;
        ";
        $stmt = $this->connect->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Configurações da tabela
        $fpdf->SetFont('Arial', 'B', 10); // Reduzi o tamanho da fonte para caber mais colunas
        $fpdf->SetFillColor(255, 255, 255); // Fundo branco para o cabeçalho
        $fpdf->SetTextColor(0, 0, 0); // Texto preto

        // Cabeçalho da tabela com larguras ajustadas
        $fpdf->SetY(150);
        $fpdf->SetX(5);
        $fpdf->Cell(80, 20, utf8_decode('Curso'), 1, 0, 'C', true);
        $fpdf->Cell(140, 20, utf8_decode('Avaliador'), 1, 0, 'C', true);
        $fpdf->Cell(60, 20, utf8_decode('Adequação'), 1, 0, 'C', true);
        $fpdf->Cell(60, 20, utf8_decode('Qualidade'), 1, 0, 'C', true);
        $fpdf->Cell(60, 20, utf8_decode('Criatividade'), 1, 0, 'C', true);
        $fpdf->Cell(50, 20, utf8_decode('Didática'), 1, 0, 'C', true);
        $fpdf->Cell(50, 20, utf8_decode(string: 'Equipe'), 1, 0, 'C', true);
        $fpdf->Cell(85, 20, utf8_decode('Sustentabilidade'), 1, 1, 'C', true);

        // Dados da tabela
        $fpdf->SetFont('Arial', '', 8); // Fonte menor para os dados
        $fpdf->SetFillColor(240, 240, 240); // Fundo cinza claro para linhas
        $fill = false;
        foreach ($results as $row) {
            $fpdf->SetX(5);
            $fpdf->Cell(80, 20, utf8_decode($row['nome_curso']), 1, 0, 'C', $fill);
            $fpdf->Cell(140, 20, utf8_decode($row['nome']), 1, 0, 'C', $fill);
            $fpdf->Cell(60, 20, utf8_decode($row['adequacao_tema']), 1, 0, 'C', $fill);
            $fpdf->Cell(60, 20, utf8_decode($row['qualidade_conteudo']), 1, 0, 'C', $fill);
            $fpdf->Cell(60, 20, utf8_decode($row['ambientacao_criatividade']), 1, 0, 'C', $fill);
            $fpdf->Cell(50, 20, utf8_decode($row['didatica_clareza']), 1, 0, 'C', $fill);
            $fpdf->Cell(50, 20, utf8_decode($row['trabalho_equipe']), 1, 0, 'C', $fill);
            $fpdf->Cell(85, 20, utf8_decode($row['sustentabilidade_execucao']), 1, 1, 'C', $fill);
            $fill = !$fill; // Alterna a cor de fundo
        }

        // Gera o PDF
        $fpdf->Output('relatorio_esquete.pdf', 'I');
    }
}

$relatorio = new PDF();
?>