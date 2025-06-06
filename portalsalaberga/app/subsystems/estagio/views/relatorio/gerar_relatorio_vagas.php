<?php
require_once('../../models/select_model.php');
require_once('../../assets/fpdf/fpdf.php');
require_once('../../models/sessions.php');
// Configura o fuso horário para São Paulo
date_default_timezone_set('America/Sao_Paulo');

// Verifica se o usuário está autenticado
$sessions = new sessions();
$sessions->autenticar_session();

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
            $this->SetMargins(10, 15, 10);
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
                $alunos_selecionados = $this->select_model->alunos_selecionados_relatorio($vaga['id']);
                
                // Busca alunos em espera para esta vaga
                $alunos_espera = $this->select_model->alunos_espera($vaga['id']);
                
                // Adiciona alunos selecionados
                foreach ($alunos_selecionados as $aluno) {
                    $this->alunos_destaque[] = [
                        'nome' => $aluno['nome'],
                        'empresa' => $vaga['nome_empresa'],
                        'perfil' => $vaga['nome_perfil'],
                        'status' => 'Selecionado',
                        'contato' => $aluno['contato'] ?? ''
                    ];
                    $total_alunos_selecionados++;
                }
                
                // Adiciona alunos em espera
                foreach ($alunos_espera as $aluno) {
                    $this->alunos_destaque[] = [
                        'nome' => $aluno['nome'],
                        'empresa' => $vaga['nome_empresa'],
                        'perfil' => $vaga['nome_perfil'],
                        'status' => 'Em Espera',
                        'contato' => $aluno['contato'] ?? ''
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
        function ajustarTexto($texto, $largura_celula) {
            // Remove caracteres do final até que o texto caiba na largura da célula
            while ($this->GetStringWidth($texto) > $largura_celula) {
                $texto = mb_substr($texto, 0, -1, 'UTF-8');
            }
            return $texto;
        }

        function formatarNome($nome) {
            // Converte todo o nome para minúsculo
            $nome = mb_strtolower($nome, 'UTF-8');
            // Divide o nome em palavras
            $palavras = explode(' ', $nome);
            // Capitaliza a primeira letra de cada palavra
            $palavras = array_map(function($palavra) {
                return ucfirst($palavra);
            }, $palavras);
            // Junta as palavras novamente
            return implode(' ', $palavras);
        }

        function formatarEmpresa($empresa) {
            return mb_strtoupper($empresa, 'UTF-8');
        }

        function formatarData($data) {
            if (empty($data)) return '-';
            $data_obj = new DateTime($data);
            return $data_obj->format('d/m/Y');
        }

        function formatarNumeroWhatsApp($numero) {
            // Remove todos os caracteres não numéricos
            $numero = preg_replace('/[^0-9]/', '', $numero);
            
            // Se o número começar com 55, remove
            if (substr($numero, 0, 2) === '55') {
                $numero = substr($numero, 2);
            }
            
            // Se o número começar com 0, remove
            if (substr($numero, 0, 1) === '0') {
                $numero = substr($numero, 1);
            }
            
            // Adiciona o código do país (55) se não existir
            if (strlen($numero) === 11) {
                $numero = '55' . $numero;
            }
            
            return $numero;
        }

        // Cabeçalho
    function Header() {
        if ($this->PageNo() == 1) {
            $this->SetFillColor(248, 248, 248);
            $this->Rect(0, 0, $this->GetPageWidth(), 40, 'F');
            
            $this->Image('https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png', 15, 10, 25);
            
            $this->SetFont('Arial', 'B', 18);
            $this->SetTextColor($this->cores['primaria'][0], $this->cores['primaria'][1], $this->cores['primaria'][2]);
            $this->SetXY(45, 15);
            $this->Cell(100, 10, ' Seleções / Entrevistas realizadas', 0, 0, 'L');
        
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

            // Cabeçalho da tabela
            $this->SetFillColor(220, 240, 230);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(45, 7, 'Empresa', 1, 0, 'L', true);
            $this->Cell(30, 7, 'Perfil', 1, 0, 'L', true);
            $this->Cell(35, 7, 'Data | Hora', 1, 0, 'C', true);
            $this->Cell(65, 7, 'Alunos', 1, 0, 'C', true);
            $this->Cell(15, 7, 'Contato', 1, 1, 'C', true);
            
            // Dados da tabela
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(40, 40, 40);
            
            $row_bg1 = [255, 255, 255];
            $row_bg2 = [245, 250, 245];
            $contador_linhas = 0;
            
            if (empty($this->vagas)) {
                $bg = $row_bg1;
                $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                $this->Cell(45, 7, '-', 1, 0, 'C', true);
                $this->Cell(30, 7, '-', 1, 0, 'C', true);
                $this->Cell(35, 7, '-', 1, 0, 'C', true);
                $this->Cell(65, 7, '-', 1, 0, 'C', true);
                $this->Cell(15, 7, '-', 1, 1, 'C', true);
            } else {
                foreach ($this->vagas as $vaga) {
                    // Busca alunos selecionados e em espera para esta vaga
                    $alunos_selecionados = $this->select_model->alunos_selecionados_relatorio($vaga['id']);
                    $alunos_espera = $this->select_model->alunos_espera($vaga['id']);
                    
                    $data_hora = ($this->formatarData($vaga['data'])) . ' | ' . ($vaga['hora'] ?? '-');
                    if ($data_hora === '- | -') $data_hora = '-';

                    // Se não houver alunos, mostra uma linha com traço
                    if (empty($alunos_selecionados) && empty($alunos_espera)) {
                        $bg = ($contador_linhas % 2 == 0) ? $row_bg1 : $row_bg2;
                        $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                        $this->Cell(45, 7, $this->ajustarTexto($this->formatarEmpresa($vaga['nome_empresa'] ?? '-'), 45), 1, 0, 'L', true);
                        $this->Cell(30, 7, $this->ajustarTexto($vaga['nome_perfil'] ?? '-', 30), 1, 0, 'L', true);
                        $this->Cell(35, 7, $data_hora, 1, 0, 'C', true);
                        $this->Cell(65, 7, '-', 1, 0, 'C', true);
                        $this->Cell(15, 7, '-', 1, 1, 'C', true);
                        $contador_linhas++;
                    } else {
                        // Lista alunos selecionados
                        foreach ($alunos_selecionados as $aluno) {
                            $bg = ($contador_linhas % 2 == 0) ? $row_bg1 : $row_bg2;
                            $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                            $this->Cell(45, 7, $this->ajustarTexto($this->formatarEmpresa($vaga['nome_empresa'] ?? '-'), 45), 1, 0, 'L', true);
                            $this->Cell(30, 7, $this->ajustarTexto($vaga['nome_perfil'] ?? '-', 30), 1, 0, 'L', true);
                            $this->Cell(35, 7, $data_hora, 1, 0, 'C', true);
                            
                            // Apenas o texto do aluno selecionado fica verde e negrito, fundo segue a alternância
                            $this->SetTextColor(0, 122, 51); // Verde para selecionados
                            $this->SetFont('Arial', 'B', 10); // Negrito para selecionados
                            
                            // Adiciona o nome do aluno
                            $nome_aluno = $this->ajustarTexto($this->formatarNome($aluno['nome']), 65);
                            $this->Cell(65, 7, $nome_aluno, 1, 0, 'L', true);
                            
                            // Adiciona o contato
                            if (!empty($aluno['contato'])) {
                                $x = $this->GetX();
                                $y = $this->GetY();
                                $this->Rect($x, $y, 15, 7);
                                $this->Image('../../assets/whatsapp.png', $x + 5, $y + 1, 5, 5);
                                $this->SetX($x + 15);
                                $numero_whatsapp = $this->formatarNumeroWhatsApp($aluno['contato']);
                                $this->Link($this->GetX() - 15, $this->GetY(), 15, 7, "https://wa.me/{$numero_whatsapp}");

                                
                            } else {
                                $this->SetTextColor(0, 122, 51); // Verde para selecionados
                                $this->SetFont('Arial', 'B', 10); // Negrito para selecionados
                                $this->Cell(15, 7, 'X', 1, 0, 'C', true);
                            }
                            
                            $this->SetTextColor(40, 40, 40);
                            $this->SetFont('Arial', '', 10);
                            $this->Ln(); // Adiciona uma quebra de linha após cada aluno
                            $contador_linhas++;
                        }
                        
                        // Lista alunos em espera
                        foreach ($alunos_espera as $aluno) {
                            $bg = ($contador_linhas % 2 == 0) ? $row_bg1 : $row_bg2;
                            $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                            $this->Cell(45, 7, $this->ajustarTexto($this->formatarEmpresa($vaga['nome_empresa'] ?? '-'), 45), 1, 0, 'L', true);
                            $this->Cell(30, 7, $this->ajustarTexto($vaga['nome_perfil'] ?? '-', 30), 1, 0, 'L', true);
                            $this->Cell(35, 7, $data_hora, 1, 0, 'C', true);
                            $this->SetTextColor(100, 100, 100); // Cinza para em espera
                            
                            // Adiciona o nome do aluno
                            $nome_aluno = $this->ajustarTexto($this->formatarNome($aluno['nome']), 65);
                            $this->Cell(65, 7, $nome_aluno, 1, 0, 'L', true);
                            
                            // Adiciona o contato
                            if (!empty($aluno['contato'])) {
                                $x = $this->GetX();
                                $y = $this->GetY();
                                $this->Rect($x, $y, 15, 7);
                                $this->Image('../../assets/whatsapp.png', $x + 5, $y + 1, 5, 5);
                                $this->SetX($x + 15);
                                $numero_whatsapp = $this->formatarNumeroWhatsApp($aluno['contato']);
                                $this->Link($this->GetX() - 15, $this->GetY(), 15, 7, "https://wa.me/{$numero_whatsapp}");
                            } else {
                                $this->SetTextColor(0, 122, 51); // Verde para selecionados
                                $this->SetFont('Arial', 'B', 10); // Negrito para selecionados
                                $this->Cell(15, 7, 'X', 1, 0, 'C', true);
                            }
                            
                            $this->SetTextColor(40, 40, 40);
                            $this->SetFont('Arial', '', 10);
                            $this->Ln(); // Adiciona uma quebra de linha após cada aluno
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
            $this->Cell(80, 7, 'Empresa', 1, 0, 'C', true);
            $this->Cell(30, 7, 'Perfil', 1, 0, 'C', true);
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
                $this->Cell(80, 7, '-', 1, 0, 'C', true);
                $this->Cell(30, 7, '-', 1, 0, 'C', true);
                $this->Cell(70, 7, '-', 1, 1, 'C', true);
            } else {
                foreach ($alunos_selecionados as $aluno) {
                    $bg = $fill ? $row_bg2 : $row_bg1;
                    $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                    
                    $this->Cell(80, 7, $this->ajustarTexto($aluno['empresa'] ?? '-', 80), 1, 0, 'L', true);
                    $this->Cell(30, 7, $this->ajustarTexto($aluno['perfil'] ?? '-', 30), 1, 0, 'L', true);
                    $this->Cell(70, 7, $this->ajustarTexto($aluno['nome'] ?? '-', 70), 1, 1, 'L', true);
                    
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
            $this->Cell(80, 7, utf8_decode('Empresa'), 1, 0, 'C', true);
            $this->Cell(30, 7, utf8_decode('Perfil'), 1, 0, 'C', true);
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
                $this->Cell(80, 7, '-', 1, 0, 'C', true);
                $this->Cell(30, 7, '-', 1, 0, 'C', true);
                $this->Cell(70, 7, '-', 1, 1, 'C', true);
            } else {
                foreach ($alunos_nao_selecionados as $aluno) {
                    $bg = $fill ? $row_bg2 : $row_bg1;
                    $this->SetFillColor($bg[0], $bg[1], $bg[2]);
                    
                    $this->Cell(80, 7, utf8_decode($this->ajustarTexto($aluno['empresa'] ?? '-', 80)), 1, 0, 'L', true);
                    $this->Cell(30, 7, utf8_decode($this->ajustarTexto($aluno['perfil'] ?? '-', 30)), 1, 0, 'L', true);
                    $this->Cell(70, 7, utf8_decode($this->ajustarTexto($aluno['nome'] ?? '-', 70)), 1, 1, 'L', true);
                    
                    $fill = !$fill;
                }
            }
        }

        function gerarRelatorio() {
            $this->addTabelaVagas();
        }
    }

    // Obtém os parâmetros
    $empresa_id = isset($_GET['empresa']) && !empty($_GET['empresa']) ? intval($_GET['empresa']) : '';
    $perfil_id = isset($_GET['perfil']) && !empty($_GET['perfil']) ? intval($_GET['perfil']) : '';
    
    // Inicializa o modelo
    $select_model = new select_model();
    
    // Obtém as vagas com os filtros
    $vagas = $select_model->vagas('', $perfil_id, $empresa_id);
    
    // Verifica se existem vagas
    if (empty($vagas)) {
        $pdf = new ModernPDF($select_model, []);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(0, 122, 51);
        $pdf->Cell(0, 20, 'Nenhuma vaga encontrada com os filtros selecionados.', 0, 1, 'C');
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
    error_log('Erro no relatório de vagas: ' . $e->getMessage());
    header('Content-Type: text/html; charset=utf-8');
    echo '<div style="color: red; padding: 20px; font-family: Arial, sans-serif;">';
    echo '<h2>Erro ao gerar relatório</h2>';
    echo '<p>Ocorreu um erro ao tentar gerar o relatório. Por favor, tente novamente mais tarde.</p>';
    echo '<p>Detalhes do erro: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p><a href="javascript:history.back()">Voltar</a></p>';
    echo '</div>';
}
?>