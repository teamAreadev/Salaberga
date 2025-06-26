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
          SELECT c.nome_curso, a.nome, p.adequacao_tema, p.letra_adaptada, p.diccao_clareza_entonacao, p.desempenho_artistico, p.trilha_sonora_sincronia, p.criatividade_originalidade FROM cursos c INNER JOIN tarefa_07_parodia p ON p.curso_id = c.curso_id INNER JOIN avaliadores a ON a.id = p.id_avaliador;

        ";
        $stmt = $this->connect->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Configurações da tabela
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->SetFillColor(255, 255, 255); // Fundo branco para o cabeçalho
        $fpdf->SetTextColor(0, 0, 0); // Texto preto

        // Cabeçalho da tabela com larguras fixas
        $fpdf->SetY(150);
        $fpdf->SetX(0);
        $fpdf->Cell(80, 20, utf8_decode('Curso'), 1, 0, 'C', true);
        $fpdf->Cell(100, 20, utf8_decode('Avaliador'), 1, 0, 'C', true);
        $fpdf->Cell(70, 20, utf8_decode('Adequação Tema'), 1, 0, 'C', true);
        $fpdf->Cell(70, 20, utf8_decode('Letra Adaptada'), 1, 0, 'C', true);
        $fpdf->Cell(70, 20, utf8_decode('Dicção/Entonação'), 1, 0, 'C', true);
        $fpdf->Cell(70, 20, utf8_decode('Desempenho'), 1, 0, 'C', true);
        $fpdf->Cell(70, 20, utf8_decode('Trilha Sonora'), 1, 0, 'C', true);
        $fpdf->Cell(70, 20, utf8_decode('Criatividade'), 1, 1, 'C', true);

        // Dados da tabela
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->SetFillColor(240, 240, 240); // Fundo cinza claro para linhas
        $fill = false;
        foreach ($results as $row) {
            $fpdf->SetX(0);
            $fpdf->Cell(80, 20, utf8_decode($row['nome_curso']), 1, 0, 'C', $fill);
            $fpdf->Cell(100, 20, utf8_decode($row['nome']), 1, 0, 'C', $fill);
            $fpdf->Cell(70, 20, utf8_decode($row['adequacao_tema']), 1, 0, 'C', $fill);
            $fpdf->Cell(70, 20, utf8_decode($row['letra_adaptada']), 1, 0, 'C', $fill);
            $fpdf->Cell(70, 20, utf8_decode($row['diccao_clareza_entonacao']), 1, 0, 'C', $fill);
            $fpdf->Cell(70, 20, utf8_decode($row['desempenho_artistico']), 1, 0, 'C', $fill);
            $fpdf->Cell(70, 20, utf8_decode($row['trilha_sonora_sincronia']), 1, 0, 'C', $fill);
            $fpdf->Cell(70, 20, utf8_decode($row['criatividade_originalidade']), 1, 1, 'C', $fill);
            $fill = !$fill; // Alterna a cor de fundo
        }

        // Gera o PDF
        $fpdf->Output('relatorio_esquete.pdf', 'I');
    }
}

$relatorio = new PDF();
?>