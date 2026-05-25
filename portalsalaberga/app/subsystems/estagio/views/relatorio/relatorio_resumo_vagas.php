<?php
require_once('../../models/select_model.php');
require_once('../../models/sessions.php');
require_once('../../assets/fpdf/fpdf.php');

// Classe FPDF com suporte a UTF-8
class PDF extends FPDF {
    function __construct($orientation='P', $unit='mm', $size='A4') {
        parent::__construct($orientation, $unit, $size);
    }

    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='') {
        if (is_string($txt)) {
            $txt = mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8');
        }
        parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
    }
}

class RelatorioResumoVagas extends PDF {
    private $select_model;
    private $vagas;
    private $cores;

    public function __construct() {
        parent::__construct('P', 'mm', 'A4');
        $this->SetAutoPageBreak(true, 25);
        $this->SetMargins(15, 15, 15);
        $this->select_model = new select_model();
        $this->vagas = $this->select_model->vagas();
        
        $this->cores = array();
        $this->cores['primaria'] = array(0, 122, 51);
        $this->cores['secundaria'] = array(240, 240, 240);
        $this->cores['destaque'] = array(0, 90, 40);
        $this->cores['texto'] = array(70, 70, 70);
        $this->cores['subtitulo'] = array(100, 100, 100);
    }

    function Header() {
        if ($this->PageNo() == 1) {
            $this->SetFillColor(248, 248, 248);
            $this->Rect(0, 0, $this->GetPageWidth(), 40, 'F');
            
            $this->Image('https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png', 15, 10, 25);
            
            $this->SetFont('Arial', 'B', 18);
            $this->SetTextColor($this->cores['primaria'][0], $this->cores['primaria'][1], $this->cores['primaria'][2]);
            $this->SetXY(45, 15);
            $this->Cell(100, 10, ' Resumo de Vagas', 0, 0, 'L');
        
            $this->SetFont('Arial', 'B', 9);
            $this->SetTextColor($this->cores['subtitulo'][0], $this->cores['subtitulo'][1], $this->cores['subtitulo'][2]);
            $this->SetXY(45, 25);
            $this->Cell(100, 5, '  Ensino Médio Técnico em Informática', 0, 0, 'L');

            date_default_timezone_set('America/Fortaleza');

            $this->SetFont('Arial', 'I', 9);
            $this->SetTextColor($this->cores['subtitulo'][0], $this->cores['subtitulo'][1], $this->cores['subtitulo'][2]);
            $this->SetXY(45, 30);
            $this->Cell(100, 5, '  Gerado em: ' . date('d/m/Y H:i'), 0, 0, 'L');
            
            $this->SetDrawColor($this->cores['primaria'][0], $this->cores['primaria'][1], $this->cores['primaria'][2]);
            $this->SetLineWidth(0.5);
            $this->Line(15, 40, 195, 40);
            
            $this->SetY(45);
        } else {
            $this->SetY(15);
        }
    }

    function Footer() {
        $this->SetDrawColor($this->cores['primaria'][0], $this->cores['primaria'][1], $this->cores['primaria'][2]);
        $this->SetLineWidth(0.3);
        $this->Line(15, $this->GetPageHeight() - 20, $this->GetPageWidth() - 15, $this->GetPageHeight() - 20);
        
        $this->SetY(-18);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor($this->cores['subtitulo'][0], $this->cores['subtitulo'][1], $this->cores['subtitulo'][2]);
        $this->Cell(0, 5, 'Página ' . $this->PageNo() . '/{nb}', 0, 1, 'C');
        $this->Cell(0, 5, 'Sistema de Gestão de Vagas - Todos os direitos reservados', 0, 0, 'C');
    }

    public function gerarRelatorio() {
        $this->AliasNbPages();
        $this->AddPage();
        
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor($this->cores['primaria'][0], $this->cores['primaria'][1], $this->cores['primaria'][2]);
        
        $this->SetFillColor(220, 240, 230);
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(15 + (180 - 170) / 2);
        
        $this->Cell(100, 7, 'Empresa', 1, 0, 'L', true);
        $this->Cell(40, 7, 'Perfil', 1, 0, 'L', true);
        $this->Cell(30, 7, 'Quantidade', 1, 1, 'C', true);
        
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(40, 40, 40);
        
        $row_bg1 = array(255, 255, 255);
        $row_bg2 = array(245, 250, 245);
        $contador_linhas = 0;

        $vagas_agrupadas = array();
        $total_alunos_selecionados = 0;
        $total_alunos_espera = 0;

        $parciais_perfil = array();
        $parciais_perfil[1] = 0;
        $parciais_perfil[2] = 0;
        $parciais_perfil[3] = 0;
        $parciais_perfil[4] = 0;

        foreach ($this->vagas as $vaga) {
            $chave = $vaga['nome_empresa'] . '|' . $vaga['nome_perfil'];
            if (!isset($vagas_agrupadas[$chave])) {
                $vagas_agrupadas[$chave] = array(
                    'empresa' => $vaga['nome_empresa'],
                    'perfil' => $vaga['nome_perfil'],
                    'quant_vaga' => 0,
                    'alunos_selecionados' => 0,
                    'alunos_espera' => 0
                );
            }
            $vagas_agrupadas[$chave]['quant_vaga'] += $vaga['quant_vaga'];

            $id_perfil = null;
            switch (strtolower(trim($vaga['nome_perfil']))) {
                case 'desenvolvimento': $id_perfil = 1; break;
                case 'design/mídias': $id_perfil = 2; break;
                case 'suporte/redes': $id_perfil = 3; break;
                case 'tutoria': $id_perfil = 4; break;
            }
            if ($id_perfil && isset($parciais_perfil[$id_perfil])) {
                $parciais_perfil[$id_perfil] += $vaga['quant_vaga'];
            }

            $alunos_selecionados = $this->select_model->alunos_selecionados_estagio($vaga['id']);
            $alunos_espera = $this->select_model->alunos_espera($vaga['id']);
            
            $vagas_agrupadas[$chave]['alunos_selecionados'] += count($alunos_selecionados);
            $vagas_agrupadas[$chave]['alunos_espera'] += count($alunos_espera);
            
            $total_alunos_selecionados += count($alunos_selecionados);
            $total_alunos_espera += count($alunos_espera);
        }

        uasort($vagas_agrupadas, function($a, $b) {
            $cmp = strcmp($a['empresa'], $b['empresa']);
            if ($cmp === 0) {
                return strcmp($a['perfil'], $b['perfil']);
            }
            return $cmp;
        });

        foreach ($vagas_agrupadas as $vaga) {
            $bg = ($contador_linhas % 2 == 0) ? $row_bg1 : $row_bg2;
            $this->SetFillColor($bg[0], $bg[1], $bg[2]);
            $this->SetX(15 + (180 - 170) / 2);
            
            $this->Cell(100, 7, $this->ajustarTexto($this->formatarEmpresa($vaga['empresa']), 55), 1, 0, 'L', true);
            $this->Cell(40, 7, $this->ajustarTexto($vaga['perfil'], 20), 1, 0, 'L', true);
            $this->Cell(30, 7, $vaga['quant_vaga'], 1, 1, 'C', true);
            
            $contador_linhas++;
        }


        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(220, 240, 230);
        $this->SetX(15 + (180 - (140 + 30)) / 2);
        $this->Cell(170, 7, 'Detalhamento das Vagas:', 0, 1, 'L');

        $nomes_perfil = array();
        $nomes_perfil[1] = 'Perfil Desenvolvimento';
        $nomes_perfil[2] = 'Perfil Design/Mídias';
        $nomes_perfil[3] = 'Perfil Suporte/Redes';
        $nomes_perfil[4] = 'Perfil Tutoria';


        foreach ($parciais_perfil as $id_perfil => $quantidade) {
            $this->SetX(15 + (180 - (140 + 30)) / 2);
            $this->Cell(140, 7, $nomes_perfil[$id_perfil] . ':', 1, 0, 'L', true);
            $this->Cell(30, 7, $quantidade, 1, 1, 'C', true);
        }
        
        $this->ln(5);
        $this->SetX(15 + (180 - (140 + 30)) / 2);
        $this->Cell(140, 7, 'Total de Vagas:', 1, 0, 'L', true);
        $this->Cell(30, 7, array_sum(array_column($vagas_agrupadas, 'quant_vaga')), 1, 1, 'C', true);

        $this->SetX(15 + (180 - (140 + 30)) / 2);
        $this->Cell(140, 7, 'Déficit de Vagas:', 1, 0, 'L', true);
        $this->Cell(30, 7, 49-array_sum(array_column($vagas_agrupadas, 'quant_vaga')), 1, 1, 'C', true);

        $this->SetX(15 + (180 - (140 + 30)) / 2);
        $this->Cell(140, 7, 'Concedentes:', 1, 0, 'L', true);
        $this->Cell(30, 7, count(array_unique(array_column($vagas_agrupadas, 'empresa'))), 1, 1, 'C', true);

    }

    private function ajustarTexto($texto, $tamanho) {
        if (strlen($texto) > $tamanho) {
            return substr($texto, 0, $tamanho - 3) . '...';
        }
        return $texto;
    }

    private function formatarEmpresa($empresa) {
        return mb_strtoupper($empresa, 'UTF-8');
    }
}

session_start();
$session = new sessions();
$session->autenticar_session();

ini_set('display_errors', 0);
error_reporting(0);

try {
    $relatorio = new RelatorioResumoVagas();
    $relatorio->gerarRelatorio();
    ob_clean();
    $relatorio->Output('Relatorio_Resumo_Vagas.pdf', 'I');
    exit;
} catch (Exception $e) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    header('Content-Type: text/html; charset=utf-8');
    echo '<div style="color: red; padding: 20px; font-family: Arial, sans-serif;">';
    echo '<h2>Erro ao gerar relatório</h2>';
    echo '<p>Ocorreu um erro ao tentar gerar o relatório. Por favor, tente novamente mais tarde.</p>';
    echo '<p>Detalhes do erro: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p><a href="javascript:history.back()">Voltar</a></p>';
    echo '</div>';
}
