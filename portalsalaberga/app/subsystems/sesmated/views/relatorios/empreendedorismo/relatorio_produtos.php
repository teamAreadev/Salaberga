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

        // Consulta SQL (corrigido o alias da tabela)
        $query = "
            SELECT c.nome_curso, p.nome_produto, p.valor_unitario, p.quantidade
            FROM cursos c 
            INNER JOIN produtos p ON p.curso_id = c.curso_id 
        ";
        $stmt = $this->connect->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Configurações da tabela
        $fpdf->SetFont('Arial', 'B', 10); // Tamanho da fonte reduzido para caber mais colunas
        $fpdf->SetFillColor(255, 255, 255); // Fundo branco para o cabeçalho
        $fpdf->SetTextColor(0, 0, 0); // Texto preto

        // Cabeçalho da tabela com larguras ajustadas
        $fpdf->SetY(150);
        $fpdf->SetX(60);
        $fpdf->Cell(100, 20, utf8_decode('Curso'), 1, 0, 'C', true);
        $fpdf->Cell(180, 20, utf8_decode('Nome do Produto'), 1, 0, 'C', true);
        $fpdf->Cell(100, 20, utf8_decode('Valor Unitário'), 1, 0, 'C', true);
        $fpdf->Cell(100, 20, utf8_decode('Quantidade'), 1, 1, 'C', true);

        // Dados da tabela
        $fpdf->SetFont('Arial', '', 8); // Fonte menor para os dados
        $fpdf->SetFillColor(240, 240, 240); // Fundo cinza claro para linhas
        $fill = false;
        foreach ($results as $row) {
            $fpdf->SetX(60);
            $fpdf->Cell(100, 20, utf8_decode($row['nome_curso']), 1, 0, 'C', $fill);
            $fpdf->Cell(180, 20, utf8_decode($row['nome_produto']), 1, 0, 'C', $fill);
            $fpdf->Cell(100, 20, utf8_decode($row['valor_unitario']), 1, 0, 'C', $fill);
            $fpdf->Cell(100, 20, utf8_decode($row['quantidade']), 1, 1, 'C', $fill);
            $fill = !$fill; // Alterna a cor de fundo
        }

        // Gera o PDF
        $fpdf->Output('relatorio_produtos.pdf', 'I');
    }
}

$relatorio = new PDF();
?>