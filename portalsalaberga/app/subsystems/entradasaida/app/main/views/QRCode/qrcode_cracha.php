<?php
require_once(__DIR__ . '/../../config/Database.php');
require_once(__DIR__ . '/../../assets/lib/fpdf/fpdf.php');
require_once(__DIR__ . '/../../assets/lib/phpqrcode/qrlib.php');

class qrCode1 extends connect
{
    public function __construct()
    {
        parent::__construct();
        $this->pdf();
    }

    public function pdf()
    {
        // Verificar se a extensão GD está ativada
        if (!function_exists('imagecreate')) {
            die('Erro: A extensão GD do PHP não está ativada. Habilite-a no php.ini.');
        }

        $pdf = new FPDF('L', 'cm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $curso = $_POST['turma'];

        // Consultar alunos da turma
        $queryStr = 'SELECT id_aluno, nome, matricula FROM aluno WHERE id_turma = :turma';
        $query = $this->connect->prepare($queryStr);
        $query->bindValue(':turma', $curso, PDO::PARAM_STR);
        $query->execute();
        $turma = $query->fetchAll(PDO::FETCH_ASSOC);

        // Verificar se há alunos
        if (empty($turma)) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 1, utf8_decode('Nenhum aluno encontrado para a turma especificada.'), 0, 1, 'C');
            $pdf->Output('I', 'crachas_turma_' . $curso . '.pdf');
            return;
        }

        // Configurações de layout
        $cracha_width = 5.5;  // Largura do crachá (cm)
        $cracha_height = 8.5;  // Altura do crachá (cm)
        $foto_aluno_width = 2.3;  // Largura do crachá (cm)
        $foto_aluno_height = 2.3;  // Altura do crachá (cm)
        $qr_size = 4;  // Tamanho do QR code (cm)
        $espaco_cracha = 6;  // Espaço entre crachás (cm)
        $max_per_line = 2;  // Máximo de crachás por linha
        $start_x = 1;  // Posição X inicial (cm)
        $start_y = 0.5;  // Posição Y inicial (cm)
        $start_aluno_x = 2.7;  // Posição X inicial (cm)
        $start_aluno_y = 3.3;  // Posição Y inicial (cm)
        $current_x = $start_x;
        $current_y = $start_y;
        $cor_curso_enfermagem = '#E22B2B';
        $cor_curso_informatica = '#004AAC';
        $cor_curso_meio_ambiente = '#26A726';
        $cor_curso_edificações = '#8c8c8c';
        $turma_dir = '';
        switch ($curso) {
            case '9':
                $turma_dir = '3a';
                $curso_nome = 'Enfermagem';
                $cor_curso = $cor_curso_enfermagem;
                break;
            case '10':
                $turma_dir = '3b';
                $curso_nome = 'Informatica';
                $cor_curso = $cor_curso_informatica;
                break;
            case '11':
                $turma_dir = '3c';
                $curso_nome = 'Meio Ambiente';
                $cor_curso = $cor_curso_meio_ambiente;
                break;
            case '12':
                $turma_dir = '3d';
                $curso_nome = 'Edificações';
                $cor_curso = $cor_curso_edificações;
                break;
        }

        $cracha_fundo = __DIR__ . '/../../assets/img/crach.jpg';
        $pasta_turma = __DIR__ . '/../../assets/img/imgAlunos/' . $turma_dir . '/';
        foreach ($turma as $aluno) {
            //imagem aluno frente do cracha
            $stmt_matricula = $this->connect->prepare("SELECT matricula FROM aluno WHERE matricula = :matricula");
            $stmt_matricula->execute([
                ":matricula" => $aluno['matricula']
            ]);
            $matricula = $stmt_matricula->fetch(PDO::FETCH_ASSOC);
            $foto_aluno = $pasta_turma . $aluno['matricula'] . '.png';
            $pdf->SetFont('Arial', null, 13);
            //$pdf->Cell(3,1,$foto_aluno, 1, 1, 'c', false);
            //$pdf->Cell(1,1,$matricula['matricula'], 1, 1, 'c', false);
            //file_exists($foto_aluno)  
            //!empty($matricula);

            if (file_exists($foto_aluno) && !empty($matricula['matricula'])) {
                
                // imagem qrcode atras do cracha
                $pdf->Image($cracha_fundo, $start_x , $start_y, $cracha_width, $cracha_height);
                $pdf->Image($foto_aluno, $start_aluno_x , $start_aluno_y, $foto_aluno_width, $foto_aluno_height);
                $pdf->SetXY(3, 5);
                $pdf->Cell(4, 2, $aluno['nome'], 1, 1, 'c', false);
                $pdf->SetXY(3, 6);
                $pdf->Cell(4, 2, $aluno['matricula'], 1, 1, 'c', false);

                // Gerar o QR code
                $url = "https://salaberga.com/salaberga/portalsalaberga/app/subsystems/entradasaida/index.php?id_aluno=" . urlencode($aluno['matricula']);
                //QRcode::png($url, $foto_aluno, QR_ECLEVEL_M, 3, 1, false);
                $pdf->Image($cracha_fundo, $start_x + $espaco_cracha, $start_y, $cracha_width, $cracha_height);
                
                $pdf->SetXY(5, 8.5);
                $pdf->Cell(4, 2, $aluno['nome'], 0, 1, 'c', false);
            }
        }
        $pdf->Output('I', 'crachas_turma_' . $curso . '.pdf');
    }
}

// Validar entrada
if (!isset($_POST['turma']) || empty($_POST['turma'])) {
    header('location: decisao.php?error=turma_nao_especificada');
}
$qrcode = new qrCode1();
