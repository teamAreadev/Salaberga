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


        $fpdf->Output('relatorio_acervo.pdf', 'I');
    }
}

$relatorio = new PDF();