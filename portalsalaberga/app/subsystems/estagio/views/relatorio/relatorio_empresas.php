<?php
require_once('../../models/select_model.php');
require_once('../../assets/fpdf/fpdf.php');

date_default_timezone_set('America/Sao_Paulo');

function formatar_telefone($telefone) {
    $telefone = preg_replace('/[^0-9]/', '', $telefone);
    if (strlen($telefone) == 11) {
        return sprintf('(%s) %s %s-%s',
            substr($telefone, 0, 2),
            substr($telefone, 2, 1),
            substr($telefone, 3, 4),
            substr($telefone, 7, 4)
        );
    } elseif (strlen($telefone) == 10) {
        return sprintf('(%s) %s-%s',
            substr($telefone, 0, 2),
            substr($telefone, 2, 4),
            substr($telefone, 6, 4)
        );
    }
    return $telefone;
}

class ModernEmpresasPDF extends FPDF {
    private $cores = [
        'primaria' => [0, 122, 51],
        'secundaria' => [240, 240, 240],
        'destaque' => [0, 90, 40],
        'texto' => [70, 70, 70],
        'subtitulo' => [100, 100, 100]
    ];
    private $inicioX = 10;
    private $fimX = 288;

    function Header() {
        if ($this->PageNo() == 1) {
            $this->SetFillColor(248, 248, 248);
            $this->Rect(0, 0, $this->GetPageWidth(), 40, 'F');
            $this->Image('https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png', 15, 10, 25);
            $this->SetFont('Arial', 'B', 18);
            $this->SetTextColor(...$this->cores['primaria']);
            $this->SetXY(45, 15);
            $this->Cell(100, 10, utf8_decode('Relatório de Empresas'), 0, 0, 'L');
            $this->SetFont('Arial', 'I', 9);
            $this->SetTextColor(...$this->cores['subtitulo']);
            $this->SetXY(45, 25);
            $this->Cell(100, 5, utf8_decode('Gerado em: ' . date('d/m/Y H:i')), 0, 0, 'L');
            $this->SetDrawColor(...$this->cores['primaria']);
            $this->SetLineWidth(0.7);
            $this->Line($this->inicioX, 40, $this->fimX, 40);
            $this->SetY(45);
        } else {
            $this->SetY(15);
        }
    }

    function Footer() {
        $this->SetDrawColor(...$this->cores['primaria']);
        $this->SetLineWidth(0.7);
        $this->Line($this->inicioX, $this->GetPageHeight() - 20, $this->fimX, $this->GetPageHeight() - 20);
        $this->SetY(-18);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(...$this->cores['subtitulo']);
        $this->Cell(0, 5, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('Sistema de Gestão de Empresas - Todos os direitos reservados'), 0, 0, 'C');
    }

    // Função para calcular linhas para MultiCell
    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    function tabelaEmpresas($empresas) {
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(220, 240, 230);
        $this->SetTextColor(...$this->cores['primaria']);
        $this->Cell(60, 10, 'Nome', 1, 0, 'C', true);
        $this->Cell(50, 10, utf8_decode('Resposável'), 1, 0, 'C', true);
        $this->Cell(35, 10, 'Telefone', 1, 0, 'C', true);
        $this->Cell(133, 10, utf8_decode('Endereço'), 1, 1, 'C', true);

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(40, 40, 40);

        $row_bg1 = [255, 255, 255];
        $row_bg2 = [245, 250, 245];
        $fill = false;

        foreach ($empresas as $empresa) {
            $bg = $fill ? $row_bg2 : $row_bg1;
            $this->SetFillColor($bg[0], $bg[1], $bg[2]);

            $x = $this->GetX();
            $y = $this->GetY();

            $w_nome = 60;
            $w_contato = 50;
            $w_telefone = 35;
            $w_endereco = 133;

            $nome_texto = utf8_decode(mb_strtoupper($empresa['nome'], 'UTF-8'));
            $endereco_texto = utf8_decode($empresa['endereco']);
            
            // Altura fixa de 2 linhas
            $h = 10;

            // Nome (MultiCell) - alinhamento vertical centralizado
            $this->SetXY($x, $y);
            $this->MultiCell($w_nome, 10, $nome_texto, 0, 'L', true);
            $this->Rect($x, $y, $w_nome, $h);

            // Contato
            $this->SetXY($x + $w_nome, $y);
            $this->Cell($w_contato, $h, utf8_decode(mb_strtoupper($empresa['nome_contato'], 'UTF-8')), 1, 0, 'L', true);

            // Telefone
            $this->SetXY($x + $w_nome + $w_contato, $y);
            $this->Cell($w_telefone, $h, formatar_telefone($empresa['contato']), 1, 0, 'L', true);

            // Endereço (MultiCell)
            $this->SetXY($x + $w_nome + $w_contato + $w_telefone, $y);
            $this->MultiCell($w_endereco, 10, $endereco_texto, 0, 'L', true);
            $this->Rect($x + $w_nome + $w_contato + $w_telefone, $y, $w_endereco, $h);

            $this->SetXY($x, $y + $h);
            $fill = !$fill;
        }
    }
}

// --- BUSCA DADOS ---
$empresa_id = isset($_GET['empresa_id']) ? $_GET['empresa_id'] : '';
$perfil = isset($_GET['perfil']) ? $_GET['perfil'] : '';

$select_model = new select_model;
if ($empresa_id) {
    $empresas = [];
    $empresa = $select_model->concedente_por_id($empresa_id);
    if ($empresa) $empresas[] = $empresa;
} else {
    $empresas = $select_model->concedentes();
}

// --- GERA PDF ---
$pdf = new ModernEmpresasPDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->tabelaEmpresas($empresas);
$pdf->Output('I', 'relatorio_empresas.pdf');
exit;