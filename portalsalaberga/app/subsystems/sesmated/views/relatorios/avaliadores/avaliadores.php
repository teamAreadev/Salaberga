<?php
require_once('../../../assets/fpdf/fpdf.php');
require_once('../../../config/connect.php');

class PDF extends connect
{
    public function __construct()
    {
        parent::__construct();
        $this->header();
        $this->main();
        $this->footer();
    }

    public function header()
    {
        $fpdf = new FPDF('L', 'pt', 'A4');
        return $fpdf;
    }

    public function main()
    {
        $fpdf = $this->header();
        $fpdf->AliasNbPages();
        $fpdf->AddPage();

        $dados = $this->connect->prepare("SELECT * FROM tarefa_01_rifas");
        $this->footer($fpdf);
        $fpdf->Output('relatorio_acervo.pdf', 'I');
    }

    function footer($fpdf)
    {
        $fpdf->SetY(-15);
        $fpdf->SetFont('Arial', 'I', 8);
        $fpdf->SetTextColor(0, 122, 51);
        $fpdf->Cell(0, 10, utf8_decode('Página ') . $fpdf->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
$relatorio = new PDF();
