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

        // Adiciona uma página
        $fpdf->AddPage();

        // Adiciona o fundo, ajustando as dimensões
        $fpdf->Image('../../../assets/fundo.jpg', 0, 0, $fpdf->GetPageWidth(), $fpdf->GetPageHeight());

        // Consulta SQL
        $query = "
            SELECT c.nome_curso, a.nome, e.tempo, e.tema, e.figurino, e.criatividade
            FROM cursos c 
            INNER JOIN tarefa_05_esquete e ON e.curso_id = c.curso_id 
            INNER JOIN avaliadores a ON a.id = e.id_avaliador;
        ";
        $stmt = $this->connect->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Configurações da tabela
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->SetFillColor(255, 255, 255); // Fundo branco para o cabeçalho
        $fpdf->SetTextColor(0, 0, 0); // Texto preto

        // Cabeçalho da tabela com larguras fixas
        $fpdf->SetY(150);
        $fpdf->SetX(20);
        $fpdf->Cell(100, 20, utf8_decode('Curso'), 1, 0, 'C', true);
        $fpdf->Cell(160, 20, utf8_decode('Avaliador'), 1, 0, 'C', true);
        $fpdf->Cell(70, 20, utf8_decode('Tempo'), 1, 0, 'C', true);
        $fpdf->Cell(70, 20, utf8_decode('Tema'), 1, 0, 'C', true);
        $fpdf->Cell(70, 20, utf8_decode('Figurino'), 1, 0, 'C', true);
        $fpdf->Cell(80, 20, utf8_decode('Criatividade'), 1, 1, 'C', true);

        // Dados da tabela
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->SetFillColor(240, 240, 240); // Fundo cinza claro para linhas
        $fill = false;
        foreach ($results as $row) {
            $fpdf->SetX(10);
            $fpdf->Cell(100, 20, utf8_decode($row['nome_curso']), 1, 0, 'C', $fill);
            $fpdf->Cell(160, 20, utf8_decode($row['nome']), 1, 0, 'C', $fill);
            $fpdf->Cell(70, 20, utf8_decode($row['tempo']), 1, 0, 'C', $fill);
            $fpdf->Cell(70, 20, utf8_decode($row['tema']), 1, 0, 'C', $fill);
            $fpdf->Cell(70, 20, utf8_decode($row['figurino']), 1, 0, 'C', $fill);
            $fpdf->Cell(80, 20, utf8_decode($row['criatividade']), 1, 1, 'C', $fill);
            $fill = !$fill; // Alterna a cor de fundo
        }

        // Gera o PDF
        $fpdf->Output('relatorio_esquete.pdf', 'I');
    }
}

$relatorio = new PDF();
?>