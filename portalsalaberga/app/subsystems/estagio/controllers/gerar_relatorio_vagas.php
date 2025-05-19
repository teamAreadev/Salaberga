<?php
require_once('../models/select_model.php');
require_once('../assets/fpdf/fpdf.php');

// Configura o fuso horário para São Paulo
date_default_timezone_set('America/Sao_Paulo');

// Classe FPDF com suporte a UTF-8
class PDF extends FPDF {
    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='') {
        $txt = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $txt);
        parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
    }
}

try {
    class ModernPDF extends PDF {
        // Configurações de cores
        private $cores = [
            'primaria' => [0, 122, 51],    // Verde institucional
            'secundaria' => [240, 240, 240], // Cinza claro
            'destaque' => [0, 90, 40],     // Verde escuro
            'texto' => [70, 70, 70],       // Cinza escuro
            'subtitulo' => [100, 100, 100]  // Cinza médio
        ];

        private $select_model;
        private $vagas;
        private $dados_resumo;
        private $alunos_destaque;

        // Configurações de página
        function __construct($select_model, $vagas) {
            parent::__construct('P', 'mm', 'A4');
            $this->SetAutoPageBreak(true, 25);
            $this->SetMargins(15, 15, 15);
            $this->select_model = $select_model;
            $this->vagas = $vagas;
            $this->processarDados();
            // Configura fonte padrão
            $this->SetFont('Arial', '', 10);
        }

        private function processarDados() {
            $total_alunos_selecionados = 0;
            $total_alunos_espera = 0;
            $this->alunos_destaque = [];
            
            foreach ($this->vagas as $vaga) {
                // Busca alunos selecionados para esta vaga
                $alunos_selecionados = $this->select_model->alunos_selecionados($vaga['id']);
                
                // Busca alunos em espera para esta vaga
                $alunos_espera = $this->select_model->alunos_espera($vaga['id']);
                
                // Adiciona alunos selecionados
                foreach ($alunos_selecionados as $aluno) {
                    $this->alunos_destaque[] = [
                        'nome' => $aluno['nome'],
                        'empresa' => $vaga['nome_empresa'],
                        'perfil' => $vaga['nome_perfil'],
                        'status' => 'Selecionado'
                    ];
                    $total_alunos_selecionados++;
                }
                
                // Adiciona alunos em espera
                foreach ($alunos_espera as $aluno) {
                    $this->alunos_destaque[] = [
                        'nome' => $aluno['nome'],
                        'empresa' => $vaga['nome_empresa'],
                        'perfil' => $vaga['nome_perfil'],
                        'status' => 'Em Espera'
                    ];
                    $total_alunos_espera++;
                }
            }
            
            $this->dados_resumo = [
                'total_vagas' => array_sum(array_column($this->vagas, 'quantidade')),
                'total_empresas' => count(array_unique(array_column($this->vagas, 'nome_empresa'))),
                'total_alunos_selecionados' => $total_alunos_selecionados,
                'total_alunos_espera' => $total_alunos_espera
            ];
        }

        // Funções auxiliares
        function ajustarTexto($texto, $largura_max) {
            if ($this->GetStringWidth($texto) > $largura_max) {
                $texto_cortado = mb_substr($texto, 0, 30, 'UTF-8');
                if (mb_strlen($texto, 'UTF-8') > 30) {
                    return $texto_cortado . '...';
                }
                return $texto_cortado;
            }
            return $texto;
        }

        // Cabeçalho
        function Header() {
            if ($this->PageNo() == 1) {
                $this->SetFillColor(248, 248, 248);
                $this->Rect(0, 0, $this->GetPageWidth(), 40, 'F');
                
                $this->Image('https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png', 15, 10, 25);
                
                $this->SetFont('Arial', 'B', 18);
                $this->SetTextColor(...$this->cores['primaria']);
                $this->SetXY(45, 15);
                $this->Cell(100, 10, 'Relatório de Vagas', 0, 0, 'L');
                
                $this->SetFont('Arial', 'I', 9);
                $this->SetTextColor(...$this->cores['subtitulo']);
                $this->SetXY(45, 25);
                $this->Cell(100, 5, 'Gerado em: ' . date('d/m/Y H:i'), 0, 0, 'L');
                
                $this->SetDrawColor(...$this->cores['primaria']);
                $this->SetLineWidth(0.5);
                $this->Line(15, 40, $this->GetPageWidth() - 15, 40);
                
                $this->SetY(45);
            } else {
                $this->SetY(15);
            }
        }

        // Rodapé
        function Footer() {
            $this->SetDrawColor(...$this->cores['primaria']);
            $this->SetLineWidth(0.3);
            $this->Line(15, $this->GetPageHeight() - 20, $this->GetPageWidth() - 15, $this->GetPageHeight() - 20);
            
            $this->SetY(-18);
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(...$this->cores['subtitulo']);
            $this->Cell(0, 5, 'Página ' . $this->PageNo() . '/{nb}', 0, 1, 'C');
            $this->Cell(0, 5, 'Sistema de Gestão de Vagas - Todos os direitos reservados', 0, 0, 'C');
        }

        // Tabela de Vagas
        function addTabelaVagas() {
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 12);
            $this->SetTextColor(...$this->cores['primaria']);
            $this->Cell(0, 10, 'Vagas Disponíveis', 0, 1, 'L');
            
            // Cabeçalho da tabela
            $this->SetFillColor(220, 240, 230);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(70, 7, 'Empresa', 1, 0, 'C', true);
            $this->Cell(50, 7, 'Perfil', 1, 0, 'C', true);
            $this->Cell(70, 7, 'Alunos', 1, 1, 'C', true);
            
            // Dados da tabela
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(40, 40, 40);
            
            $row_bg1 = [255, 255, 255];
            $row_bg2 = [245, 250, 245];
            $contador_linhas = 0;
            
            if (empty($this->vagas)) {
                $bg = $row_bg1;
                $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                $this->Cell(70, 7, '-', 1, 0, 'C', true);
                $this->Cell(50, 7, '-', 1, 0, 'C', true);
                $this->Cell(70, 7, '-', 1, 1, 'C', true);
            } else {
                foreach ($this->vagas as $vaga) {
                    // Busca alunos selecionados e em espera para esta vaga
                    $alunos_selecionados = $this->select_model->alunos_selecionados($vaga['id']);
                    $alunos_espera = $this->select_model->alunos_espera($vaga['id']);
                    
                    // Se não houver alunos, mostra uma linha com traço
                    if (empty($alunos_selecionados) && empty($alunos_espera)) {
                        $bg = ($contador_linhas % 2 == 0) ? $row_bg1 : $row_bg2;
                        $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                        $this->Cell(70, 7, $this->ajustarTexto($vaga['nome_empresa'] ?? '-', 35), 1, 0, 'L', true);
                        $this->Cell(50, 7, $this->ajustarTexto($vaga['nome_perfil'] ?? '-', 25), 1, 0, 'L', true);
                        $this->Cell(70, 7, '-', 1, 1, 'C', true);
                        $contador_linhas++;
                    } else {
                        // Lista alunos selecionados
                        foreach ($alunos_selecionados as $aluno) {
                            $bg = ($contador_linhas % 2 == 0) ? $row_bg1 : $row_bg2;
                            $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                            $this->Cell(70, 7, $this->ajustarTexto($vaga['nome_empresa'] ?? '-', 35), 1, 0, 'L', true);
                            $this->Cell(50, 7, $this->ajustarTexto($vaga['nome_perfil'] ?? '-', 25), 1, 0, 'L', true);
                            
                            // Apenas o texto do aluno selecionado fica verde e negrito, fundo segue a alternância
                            $this->SetTextColor(0, 122, 51); // Verde para selecionados
                            $this->SetFont('Arial', 'B', 10); // Negrito para selecionados
                            $this->Cell(70, 7, $this->ajustarTexto($aluno['nome'], 35), 1, 1, 'L', true);
                            $this->SetTextColor(40, 40, 40);
                            $this->SetFont('Arial', '', 10);
                            $contador_linhas++;
                        }
                        
                        // Lista alunos em espera
                        foreach ($alunos_espera as $aluno) {
                            $bg = ($contador_linhas % 2 == 0) ? $row_bg1 : $row_bg2;
                            $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                            $this->Cell(70, 7, $this->ajustarTexto($vaga['nome_empresa'] ?? '-', 35), 1, 0, 'L', true);
                            $this->Cell(50, 7, $this->ajustarTexto($vaga['nome_perfil'] ?? '-', 25), 1, 0, 'L', true);
                            $this->SetTextColor(100, 100, 100); // Cinza para em espera
                            $this->Cell(70, 7, $this->ajustarTexto($aluno['nome'], 35), 1, 1, 'L', true);
                            $this->SetTextColor(40, 40, 40); // Volta para cor padrão
                            $contador_linhas++;
                        }
                    }
                }
            }
        }

        // Tabela de Alunos
        function addTabelaAlunos() {
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 12);
            $this->SetTextColor(...$this->cores['primaria']);
            $this->Cell(0, 10, 'Alunos Selecionados', 0, 1, 'L');
            
            // Cabeçalho da tabela
            $this->SetFillColor(220, 240, 230);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(60, 7, 'Empresa', 1, 0, 'C', true);
            $this->Cell(60, 7, 'Perfil', 1, 0, 'C', true);
            $this->Cell(70, 7, 'Aluno Selecionado', 1, 1, 'C', true);
            
            // Dados da tabela
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(40, 40, 40);
            
            $row_bg1 = [255, 255, 255];
            $row_bg2 = [245, 250, 245];
            $fill = false;
            
            // Filtra apenas alunos selecionados
            $alunos_selecionados = array_filter($this->alunos_destaque, function($aluno) {
                return $aluno['status'] === 'Selecionado';
            });
            
            if (empty($alunos_selecionados)) {
                $bg = $row_bg1;
                $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                $this->Cell(60, 7, '-', 1, 0, 'C', true);
                $this->Cell(60, 7, '-', 1, 0, 'C', true);
                $this->Cell(70, 7, '-', 1, 1, 'C', true);
            } else {
                foreach ($alunos_selecionados as $aluno) {
                    $bg = $fill ? $row_bg2 : $row_bg1;
                    $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                    
                    $this->Cell(60, 7, $this->ajustarTexto($aluno['empresa'] ?? '-', 30), 1, 0, 'L', true);
                    $this->Cell(60, 7, $this->ajustarTexto($aluno['perfil'] ?? '-', 30), 1, 0, 'L', true);
                    $this->Cell(70, 7, $this->ajustarTexto($aluno['nome'] ?? '-', 35), 1, 1, 'L', true);
                    
                    $fill = !$fill;
                }
            }
        }

        // Tabela de Alunos Não Selecionados
        function addTabelaAlunosNaoSelecionados() {
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 12);
            $this->SetTextColor(...$this->cores['primaria']);
            $this->Cell(0, 10, utf8_decode('Alunos em Espera'), 0, 1, 'L');
            
            // Cabeçalho da tabela
            $this->SetFillColor(220, 240, 230);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(60, 7, utf8_decode('Empresa'), 1, 0, 'C', true);
            $this->Cell(60, 7, utf8_decode('Perfil'), 1, 0, 'C', true);
            $this->Cell(70, 7, utf8_decode('Aluno em Espera'), 1, 1, 'C', true);
            
            // Dados da tabela
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(40, 40, 40);
            
            $row_bg1 = [255, 255, 255];
            $row_bg2 = [245, 250, 245];
            $fill = false;
            
            // Filtra apenas alunos em espera
            $alunos_nao_selecionados = array_filter($this->alunos_destaque, function($aluno) {
                return $aluno['status'] === 'Em Espera';
            });
            
            if (empty($alunos_nao_selecionados)) {
                $bg = $row_bg1;
                $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                $this->Cell(60, 7, '-', 1, 0, 'C', true);
                $this->Cell(60, 7, '-', 1, 0, 'C', true);
                $this->Cell(70, 7, '-', 1, 1, 'C', true);
            } else {
                foreach ($alunos_nao_selecionados as $aluno) {
                    $bg = $fill ? $row_bg2 : $row_bg1;
                    $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                    
                    $this->Cell(60, 7, utf8_decode($this->ajustarTexto($aluno['empresa'] ?? '-', 30)), 1, 0, 'L', true);
                    $this->Cell(60, 7, utf8_decode($this->ajustarTexto($aluno['perfil'] ?? '-', 30)), 1, 0, 'L', true);
                    $this->Cell(70, 7, utf8_decode($this->ajustarTexto($aluno['nome'] ?? '-', 35)), 1, 1, 'L', true);
                    
                    $fill = !$fill;
                }
            }
        }

        // Tabela de Resumo
        function addTabelaResumo() {
            $this->SetFont('Arial', 'B', 12);
            $this->SetTextColor(...$this->cores['primaria']);
            $this->Cell(0, 10, 'Resumo', 0, 1, 'L');
            
            // Cabeçalho da tabela
            $this->SetFillColor(220, 240, 230);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(90, 7, 'Item', 1, 0, 'C', true);
            $this->Cell(90, 7, 'Quantidade', 1, 1, 'C', true);
            
            // Dados da tabela
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(40, 40, 40);
            
            $row_bg1 = [255, 255, 255];
            $row_bg2 = [245, 250, 245];
            $fill = false;
            
            $items = [
                'Total de Vagas' => $this->dados_resumo['total_vagas'] ?? 0,
                'Total de Empresas' => $this->dados_resumo['total_empresas'] ?? 0,
                'Total de Alunos Selecionados' => $this->dados_resumo['total_alunos_selecionados'] ?? 0
            ];
            
            foreach ($items as $item => $valor) {
                $bg = $fill ? $row_bg2 : $row_bg1;
                $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                
                $this->Cell(90, 7, $item, 1, 0, 'L', true);
                $this->Cell(90, 7, $valor ?: '-', 1, 1, 'C', true);
                
                $fill = !$fill;
            }
        }

        // Tabela de Resumo por Empresa
        function addTabelaResumoEmpresas() {
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 12);
            $this->SetTextColor(...$this->cores['primaria']);
            $this->Cell(0, 10, 'Resumo por Empresa', 0, 1, 'L');
            
            // Cabeçalho da tabela
            $this->SetFillColor(220, 240, 230);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(70, 7, 'Empresa', 1, 0, 'C', true);
            $this->Cell(50, 7, 'Perfil', 1, 0, 'C', true);
            $this->Cell(70, 7, 'Total de Vagas', 1, 1, 'C', true);
            
            // Dados da tabela
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(40, 40, 40);
            
            $row_bg1 = [255, 255, 255];
            $row_bg2 = [245, 250, 245];
            $contador_linhas = 0;
            
            // Agrupa vagas por empresa e perfil
            $vagas_por_empresa = [];
            foreach ($this->vagas as $vaga) {
                $chave = $vaga['nome_empresa'] . '|' . $vaga['nome_perfil'];
                if (!isset($vagas_por_empresa[$chave])) {
                    $vagas_por_empresa[$chave] = [
                        'empresa' => $vaga['nome_empresa'],
                        'perfil' => $vaga['nome_perfil'],
                        'total' => 0
                    ];
                }
                $vagas_por_empresa[$chave]['total'] += $vaga['quantidade'];
            }
            
            // Ordena por empresa e perfil
            uasort($vagas_por_empresa, function($a, $b) {
                $cmp = strcmp($a['empresa'], $b['empresa']);
                if ($cmp === 0) {
                    return strcmp($a['perfil'], $b['perfil']);
                }
                return $cmp;
            });
            
            if (empty($vagas_por_empresa)) {
                $bg = $row_bg1;
                $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                $this->Cell(70, 7, '-', 1, 0, 'C', true);
                $this->Cell(50, 7, '-', 1, 0, 'C', true);
                $this->Cell(70, 7, '-', 1, 1, 'C', true);
            } else {
                foreach ($vagas_por_empresa as $vaga) {
                    $bg = ($contador_linhas % 2 == 0) ? $row_bg1 : $row_bg2;
                    $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                    
                    $this->Cell(70, 7, $this->ajustarTexto($vaga['empresa'], 35), 1, 0, 'L', true);
                    $this->Cell(50, 7, $this->ajustarTexto($vaga['perfil'], 25), 1, 0, 'L', true);
                    $this->Cell(70, 7, $vaga['total'], 1, 1, 'C', true);
                    
                    $contador_linhas++;
                }
            }
        }

        function gerarRelatorio() {
            $this->addTabelaResumo();
            $this->Ln(10);
            $this->addTabelaResumoEmpresas();
            $this->Ln(10);
            $this->addTabelaVagas();
        }
    }

    // Obtém os parâmetros
    $empresa_id = isset($_GET['empresa']) && !empty($_GET['empresa']) ? $_GET['empresa'] : '';
    $perfil_id = isset($_GET['perfil']) && !empty($_GET['perfil']) ? $_GET['perfil'] : '';
    
    // Inicializa o modelo
    $select_model = new select_model();
    
    // Obtém as vagas
    $vagas = $select_model->vagas('', $perfil_id, $empresa_id);
    
    // Verifica se existem vagas
    if (empty($vagas)) {
        $pdf = new ModernPDF($select_model, []);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(0, 122, 51);
        $pdf->Cell(0, 20, utf8_decode('Nenhuma vaga encontrada com os filtros selecionados.'), 0, 1, 'C');
        $pdf->Output('relatorio_vagas.pdf', 'I');
        exit;
    }
    
    // Inicializa o PDF e gera o relatório
    $pdf = new ModernPDF($select_model, $vagas);
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->gerarRelatorio();
    $pdf->Output('relatorio_vagas.pdf', 'I');
    exit;

} catch (Exception $e) {
    header('Content-Type: text/html; charset=utf-8');
    echo '<div style="color: red; padding: 20px; font-family: Arial, sans-serif;">';
    echo '<h2>Erro ao gerar relatório</h2>';
    echo '<p>Ocorreu um erro ao tentar gerar o relatório. Por favor, tente novamente mais tarde.</p>';
    echo '<p><a href="javascript:history.back()">Voltar</a></p>';
    echo '</div>';
    
    error_log('Erro no relatório de vagas: ' . $e->getMessage());
}
?>