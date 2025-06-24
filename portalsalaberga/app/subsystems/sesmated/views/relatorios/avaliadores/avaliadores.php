<?php
require_once('../../../assets/fpdf/fpdf.php');
require_once('../../../config/connect.php');

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
        $fpdf->AddPage('P'); // Orientação vertical

        // Imagem de fundo
        $fpdf->Image('../../../assets/fundo.jpg', 0, 0, $fpdf->GetPageWidth(), $fpdf->GetPageHeight());

        // Cabeçalho da tabela
        $fpdf->SetY($fpdf->GetY() + 125); // Pequeno espaço após o texto
        $fpdf->SetX(200);
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->SetFillColor(240, 240, 240); // Cinza claro para o cabeçalho
        $fpdf->SetTextColor(0, 0, 0); // Preto para o texto do cabeçalho
        $fpdf->Cell(80, 20, utf8_decode('Nome'), 1, 0, 'C', true);
        $fpdf->Cell(60, 20, utf8_decode('Data'), 1, 0, 'C', true);
        $fpdf->Cell(50, 20, utf8_decode('Turno'), 1, 0, 'C', true);
        $fpdf->Cell(50, 20, utf8_decode('Senha'), 1, 1, 'C', true);

        // Espaço entre cabeçalho e dados
        $fpdf->Ln(2);

        // Dados
        $fpdf->SetFont('Arial', '', 11);
        $fpdf->SetDrawColor(0, 179, 72); // Verde para bordas
        $fill = false;

        $result = $this->connect->prepare("SELECT * FROM avaliadores");
        $result->execute();
        $dados = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dados as $dado) {
            $fpdf->SetX(200);
            if ($fill) {
                $fpdf->SetFillColor(0, 0, 0); // Preto para fundo
                $fpdf->SetTextColor(255, 255, 255); // Branco para texto em fundo preto
            } else {
                $fpdf->SetFillColor(255, 255, 255); // Branco para fundo
                $fpdf->SetTextColor(0, 0, 0); // Preto para texto em fundo branco
            }
            $fpdf->Cell(80, 18, utf8_decode($dado['nome']), 1, 0, 'C', true);
            $fpdf->Cell(60, 18, utf8_decode($dado['data']), 1, 0, 'C', true);
            $fpdf->Cell(50, 18, utf8_decode($dado['turno']), 1, 0, 'C', true);
            $fpdf->Cell(50, 18, utf8_decode($dado['senha']), 1, 1, 'C', true);
            $fill = !$fill;
        }

        // Adicionar rodapé
        $fpdf->SetY(-15);
        $fpdf->SetFont('Arial', 'I', 8);
        $fpdf->SetTextColor(0, 122, 51); // Verde escuro
        $fpdf->Cell(0, 10, utf8_decode('Página ') . $fpdf->PageNo() . '/{nb}', 0, 0, 'C');

        $fpdf->Output('relatorio_acervo.pdf', 'I');
    }
}

$relatorio = new PDF();