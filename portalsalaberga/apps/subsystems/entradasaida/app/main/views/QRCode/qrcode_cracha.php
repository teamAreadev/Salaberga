<?php
/**
 * Geração de crachás em PDF (A4 paisagem) com mPDF e chillerlan/php-qrcode.
 *
 * Layout: 2 pares por linha (frente + QR) = 4 crachás por linha.
 * Entrada: POST turma (id_turma: 9, 10, 11 ou 12).
 */

require_once __DIR__ . '/../../assets/lib/mpdf/vendor/autoload.php';
require_once __DIR__ . '/../../assets/lib/qrcode/vendor/autoload.php';
require_once __DIR__ . '/../../config/Database.php';

use chillerlan\QRCode\{QRCode, QROptions};

class GeradorCrachas extends connect
{
    /** Largura e altura de cada crachá (proporção vertical do modelo). */
    private const CRACHA_LARGURA = '4.2cm';
    private const CRACHA_ALTURA = '6.72cm';

    /** Tamanhos do conteúdo (referência visual do crachá). */
    private const FOTO_LARGURA = '1.5cm';
    private const FOTO_ALTURA = '1.85cm';
    private const QR_TAMANHO = '2.05cm';
    private const NOME_MAX_UMA_LINHA = 20;

    /** Espaço superior reservado ao logo Salaberga (foto/QR começam abaixo). */
    private const ALTURA_AREA_LOGO = '2.25cm';
    private const ALTURA_AREA_FOTO = '2.05cm';
    private const ALTURA_AREA_QR = '4.47cm';

    /** Quantidade de pares (frente + QR) por linha no PDF. */
    private const PARES_POR_LINHA = 2;

    /** URL base codificada no QR Code de cada aluno. */
    private const QR_URL_BASE = 'https://salaberga.com/salaberga/portalsalaberga/app/subsystems/entradasaida/index.php?';

    /** Cores dos cursos (badge do curso). */
    private const CORES_CURSO = [
        'Enfermagem'     => '#E22B2B',
        'Informática'    => '#004AAC',
        'Meio Ambiente'  => '#26A726',
        'Edificações'    => '#8C8C8C',
    ];

    private string $turmaDir = '';
    private string $cursoNome = '';
    private string $corCurso = '#333333';
    private string $pastaTurma = '';
    /** Pastas onde buscar fotos (ex.: 3b e img3B). */
    private array $pastasFoto = [];
    private string|false $fundoCracha = false;

    /** Pasta temporária para PNGs dos QR (evita base64 gigante no HTML). */
    private ?string $dirTemporario = null;

    public function __construct()
    {
        parent::__construct();
        $this->executar();
    }

    /**
     * Fluxo principal: valida entrada, carrega alunos e gera o PDF.
     */
    private function executar(): void
    {
        try {
            $idTurma = $this->validarEntrada();
            $this->resolverConfiguracaoTurma($idTurma);
            $alunos = $this->buscarAlunos($idTurma);

            if ($alunos === []) {
                throw new RuntimeException('Nenhum aluno encontrado para esta turma.');
            }

            $this->montarPDF($alunos);
        } catch (Throwable $e) {
            echo 'Erro: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }

    /**
     * Garante que o id da turma foi enviado via POST.
     */
    private function validarEntrada(): string
    {
        if (!isset($_POST['turma']) || $_POST['turma'] === '') {
            header('Location: decisao.php?erro=turma_invalida');
            exit;
        }

        return (string) $_POST['turma'];
    }

    /**
     * Mapeia id_turma → pasta de fotos, nome do curso e cor do badge.
     */
    private function resolverConfiguracaoTurma(string $idTurma): void
    {
        $mapa = [
            '9'  => ['dir' => '3a', 'nome' => 'Enfermagem'],
            '10' => ['dir' => '3b', 'nome' => 'Informática'],
            '11' => ['dir' => '3c', 'nome' => 'Meio Ambiente'],
            '12' => ['dir' => '3d', 'nome' => 'Edificações'],
        ];

        if (!isset($mapa[$idTurma])) {
            throw new InvalidArgumentException('Turma inválida.');
        }

        $this->turmaDir   = $mapa[$idTurma]['dir'];
        $this->cursoNome  = $mapa[$idTurma]['nome'];
        $this->corCurso   = self::CORES_CURSO[$this->cursoNome] ?? '#333333';

        $baseAlunos = __DIR__ . '/../../assets/img/imgAlunos/';
        $this->pastaTurma = $baseAlunos . $this->turmaDir . '/';
        $this->pastasFoto = [$this->pastaTurma];

        $pastaLegada = $baseAlunos . 'img' . strtoupper($this->turmaDir) . '/';
        if ($pastaLegada !== $this->pastaTurma && is_dir($pastaLegada)) {
            $this->pastasFoto[] = $pastaLegada;
        }

        $this->fundoCracha = realpath(__DIR__ . '/../../assets/img/crach.jpg') ?: false;

        if ($this->fundoCracha === false) {
            throw new RuntimeException('Imagem de fundo crach.jpg não encontrada.');
        }
    }

    /**
     * Lista alunos da turma selecionada.
     *
     * @return array<int, array{id_aluno: mixed, nome: string, matricula: mixed}>
     */
    private function buscarAlunos(string $idTurma): array
    {
        $sql = 'SELECT id_aluno, nome, matricula FROM aluno WHERE id_turma = :turma ORDER BY nome ASC';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':turma', $idTurma, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Instancia mPDF, monta HTML em blocos e envia o PDF ao navegador.
     *
     * O HTML é enviado em partes para não ultrapassar pcre.backtrack_limit do PHP.
     * Os QR Codes são gravados em disco (não em data URI) para manter cada bloco pequeno.
     */
    private function montarPDF(array $alunos): void
    {
        $this->criarDiretorioTemporario();

        try {
            $mpdf = new \Mpdf\Mpdf([
                'mode'          => 'utf-8',
                'format'        => 'A4-L',
                'margin_left'   => 8,
                'margin_right'  => 8,
                'margin_top'    => 8,
                'margin_bottom' => 8,
            ]);

            $mpdf->SetTitle('Crachás — ' . $this->cursoNome);

            // Estilos e abertura da grade em blocos separados
            $mpdf->WriteHTML($this->montarEstilos());
            $mpdf->WriteHTML('<table class="crachas-grid" cellpadding="4" cellspacing="0"><tbody>');

            $this->escreverLinhasCrachas($mpdf, $alunos);

            $mpdf->WriteHTML('</tbody></table>');
            $mpdf->Output('crachas_' . $this->turmaDir . '.pdf', 'I');
        } finally {
            $this->limparDiretorioTemporario();
        }
    }

    /**
     * Escreve cada linha da grade (2 pares) com WriteHTML separado.
     */
    private function escreverLinhasCrachas(\Mpdf\Mpdf $mpdf, array $alunos): void
    {
        $coluna   = 0;
        $linhaHtml = '';

        foreach ($alunos as $aluno) {
            if ($coluna === 0) {
                $linhaHtml = '<tr>';
            }

            $linhaHtml .= '<td class="celula-par">' . $this->montarPar($aluno) . '</td>';
            $coluna++;

            if ($coluna >= self::PARES_POR_LINHA) {
                $mpdf->WriteHTML($linhaHtml . '</tr>');
                $linhaHtml = '';
                $coluna = 0;
            }
        }

        if ($coluna === 1) {
            $mpdf->WriteHTML($linhaHtml . '<td class="celula-par"></td></tr>');
        }
    }

    /**
     * Cria pasta temporária para arquivos PNG dos QR Codes.
     */
    private function criarDiretorioTemporario(): void
    {
        $dir = sys_get_temp_dir() . '/crachas_qr_' . getmypid() . '_' . uniqid('', true);

        if (!mkdir($dir, 0700, true) && !is_dir($dir)) {
            throw new RuntimeException('Não foi possível criar a pasta temporária para os QR Codes.');
        }

        $this->dirTemporario = $dir;
    }

    /**
     * Remove PNGs temporários gerados para o PDF.
     */
    private function limparDiretorioTemporario(): void
    {
        if ($this->dirTemporario === null || !is_dir($this->dirTemporario)) {
            return;
        }

        foreach (glob($this->dirTemporario . '/*.png') ?: [] as $arquivo) {
            @unlink($arquivo);
        }

        @rmdir($this->dirTemporario);
        $this->dirTemporario = null;
    }

    /**
     * CSS global — layout dos crachás usa tabelas (melhor compatibilidade com mPDF).
     */
    private function montarEstilos(): string
    {
        $cor = htmlspecialchars($this->corCurso, ENT_QUOTES, 'UTF-8');

        return '
        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
                margin: 0;
                padding: 0;
            }
            .crachas-grid {
                width: 100%;
                border-collapse: collapse;
            }
            .crachas-grid td.celula-par {
                width: 50%;
                vertical-align: top;
                text-align: center;
                padding: 2px;
            }
            .par-inner {
                margin: 0 auto;
                border-collapse: collapse;
            }
            .par-inner td {
                vertical-align: top;
                padding: 0 2px;
            }
            .cracha-tabela {
                border-collapse: collapse;
                margin: 0 auto;
            }
            .cracha-nome {
                font-weight: bold;
                font-size: 6.2pt;
                line-height: 1.1;
                text-transform: uppercase;
                color: #000000;
                margin: 0.06cm 0 0.04cm;
                padding: 0 0.15cm;
            }
            .cracha-matricula {
                font-size: 5.8pt;
                font-family: DejaVu Serif, serif;
                color: #1a1a1a;
                margin: 0.04cm 0 0.06cm;
            }
            .cracha-curso {
                display: inline-block;
                font-size: 6pt;
                font-weight: bold;
                color: #ffffff;
                background: ' . $cor . ';
                padding: 0.08cm 0.28cm;
                margin: 0.05cm 0;
                border-radius: 0.2cm;
            }
            .cracha-cargo {
                font-size: 5.2pt;
                font-family: DejaVu Serif, serif;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                color: #1a1a1a;
                margin: 0;
            }
        </style>';
    }

    /**
     * Imagem de fundo do crachá (mPDF renderiza <img>; CSS background-image falha no PDF).
     */
    private function gerarImgFundoCracha(): string
    {
        $src = htmlspecialchars($this->fundoCracha, ENT_QUOTES, 'UTF-8');

        return '<img src="' . $src . '" width="' . self::CRACHA_LARGURA . '" height="' . self::CRACHA_ALTURA . '" '
            . 'style="display:block;margin:0;padding:0;border:0;" alt="">';
    }

    /**
     * Abre a sobreposição do conteúdo sobre a imagem de fundo (margem negativa).
     */
    private function abrirConteudoSobreFundo(): string
    {
        return '<table width="' . self::CRACHA_LARGURA . '" cellspacing="0" cellpadding="0" '
            . 'style="margin-top:-' . self::CRACHA_ALTURA . '; border-collapse:collapse;">';
    }

    /**
     * Linha vazia que reserva o topo do crachá para o logo Salaberga.
     */
    private function gerarLinhaReservaLogo(string $largura): string
    {
        return '<tr><td height="' . self::ALTURA_AREA_LOGO . '" width="' . $largura . '"></td></tr>';
    }

    /**
     * Um par: crachá da esquerda (dados) + crachá da direita (QR).
     */
    private function montarPar(array $aluno): string
    {
        return '
        <table class="par-inner" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td align="center">' . $this->gerarHTMLCrachaFrente($aluno) . '</td>
                <td align="center">' . $this->gerarHTMLCrachaQR($aluno) . '</td>
            </tr>
        </table>';
    }

    /**
     * Crachá esquerdo: foto centralizada na área superior + textos abaixo.
     */
    private function gerarHTMLCrachaFrente(array $aluno): string
    {
        $nomeHtml  = $this->formatarNomeHtml($aluno['nome']);
        $matricula = htmlspecialchars((string) $aluno['matricula'], ENT_QUOTES, 'UTF-8');
        $curso     = htmlspecialchars($this->cursoNome, ENT_QUOTES, 'UTF-8');
        $blocoFoto = $this->gerarHTMLFoto($aluno);
        $w         = self::CRACHA_LARGURA;

        return '
        <table class="cracha-tabela" cellspacing="0" cellpadding="0">
            <tr>
                <td width="' . $w . '" style="padding:0; text-align:center; vertical-align:top;">
                    ' . $this->gerarImgFundoCracha() . '
                    ' . $this->abrirConteudoSobreFundo() . '
                        ' . $this->gerarLinhaReservaLogo($w) . '
                        <tr>
                            <td height="' . self::ALTURA_AREA_FOTO . '" width="' . $w . '" align="center" valign="middle" style="text-align:center;">
                                ' . $blocoFoto . '
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="text-align:center; padding:0 0.1cm;">
                                <p class="cracha-nome">' . $nomeHtml . '</p>
                                <p class="cracha-matricula">Matrícula: ' . $matricula . '</p>
                                <span class="cracha-curso">' . $curso . '</span>
                            </td>
                        </tr>
                        <tr>
                            <td height="0.85cm" align="center" valign="bottom" style="text-align:center;">
                                <p class="cracha-cargo">Estagiário(a)</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';
    }

    /**
     * Nome em maiúsculas; quebra em duas linhas quando for longo (estilo do modelo).
     */
    private function formatarNomeHtml(string $nome): string
    {
        $nome = mb_strtoupper(trim($nome), 'UTF-8');
        $palavras = preg_split('/\s+/u', $nome, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        if ($palavras === []) {
            return '';
        }

        $umaLinha = count($palavras) <= 2 && mb_strlen($nome) <= self::NOME_MAX_UMA_LINHA;

        if ($umaLinha) {
            return htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
        }

        $meio = (int) ceil(count($palavras) / 2);
        $linha1 = implode(' ', array_slice($palavras, 0, $meio));
        $linha2 = implode(' ', array_slice($palavras, $meio));

        return htmlspecialchars($linha1, ENT_QUOTES, 'UTF-8')
            . '<br>'
            . htmlspecialchars($linha2, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Crachá direito: fundo + QR Code centralizado (horizontal e vertical).
     */
    private function gerarHTMLCrachaQR(array $aluno): string
    {
        $qrSrc = htmlspecialchars($this->gerarQRCode((string) $aluno['matricula']), ENT_QUOTES, 'UTF-8');
        $w     = self::CRACHA_LARGURA;

        return '
        <table class="cracha-tabela" cellspacing="0" cellpadding="0">
            <tr>
                <td width="' . $w . '" style="padding:0; text-align:center;">
                    ' . $this->gerarImgFundoCracha() . '
                    ' . $this->abrirConteudoSobreFundo() . '
                        ' . $this->gerarLinhaReservaLogo($w) . '
                        <tr>
                            <td width="' . $w . '" height="' . self::ALTURA_AREA_QR . '" align="center" valign="middle" style="text-align:center;">
                                <img src="' . $qrSrc . '" width="' . self::QR_TAMANHO . '" height="' . self::QR_TAMANHO . '"
                                     style="display:block; margin:0 auto; padding:0; border:0;"
                                     alt="QR Code">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';
    }

    /**
     * Retorna <img> da foto centralizada ou placeholder quando o arquivo não existe.
     */
    private function gerarHTMLFoto(array $aluno): string
    {
        $caminhoFoto = $this->resolverCaminhoFoto($aluno);

        if ($caminhoFoto === null) {
            return '<span style="display:inline-block;width:' . self::FOTO_LARGURA . ';height:' . self::FOTO_ALTURA
                . ';line-height:' . self::FOTO_ALTURA . ';font-size:5pt;color:#666;background:#f5f5f5;'
                . 'border:1px solid #ccc;">Sem foto</span>';
        }

        $src = htmlspecialchars(realpath($caminhoFoto) ?: $caminhoFoto, ENT_QUOTES, 'UTF-8');

        return '<img src="' . $src . '" width="' . self::FOTO_LARGURA . '" height="' . self::FOTO_ALTURA . '" '
            . 'style="display:block;margin:0 auto;border:1px solid #d8d8d8;" alt="">';
    }

    /**
     * Localiza a foto em imgAlunos/{turma} ou img3A/img3B… (matrícula ou nome do arquivo).
     */
    private function resolverCaminhoFoto(array $aluno): ?string
    {
        $matricula = (string) $aluno['matricula'];
        $nomeArquivo = $aluno['nome'] . '.png';

        foreach ($this->pastasFoto as $pasta) {
            $porMatricula = $pasta . $matricula . '.png';
            if (is_file($porMatricula)) {
                return $porMatricula;
            }

            $porNome = $pasta . $nomeArquivo;
            if (is_file($porNome)) {
                return $porNome;
            }
        }

        return null;
    }

    /**
     * Gera QR Code como arquivo PNG temporário (caminho absoluto para o mPDF).
     */
    private function gerarQRCode(string $matricula): string
    {
        if ($this->dirTemporario === null) {
            throw new RuntimeException('Diretório temporário de QR Codes não inicializado.');
        }

        $url = self::QR_URL_BASE .'id_aluno='. rawurlencode($matricula);
        $nomeArquivo = 'qr_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $matricula) . '.png';
        $arquivo = $this->dirTemporario . '/' . $nomeArquivo;

        $options = new QROptions([
            'outputBase64'    => false,
            'scale'           => 5,
            'quietzoneSize'   => 1,
            'foregroundColor' => [0, 0, 0],
            'backgroundColor' => [255, 255, 255],
        ]);

        (new QRCode($options))->render($url, $arquivo);

        if (!is_file($arquivo)) {
            throw new RuntimeException('Falha ao gerar QR Code para a matrícula ' . $matricula);
        }

        return realpath($arquivo) ?: $arquivo;
    }
}

new GeradorCrachas();
