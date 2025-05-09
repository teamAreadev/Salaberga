<?php
define('FPDF_FONTPATH', __DIR__ . '/../assets/fpdf/font/');
require_once('../assets/fpdf/fpdf.php');
require_once('../assets/phpqrcode/qrlib.php');

if (isset($_POST['turma']) && !empty($_POST['turma'])) {
    $result = $_POST['turma'];
    switch ($result) {
        case 9:
            $diretorio = '../assets/img/imgAlunos/img3A';
            $turma = "3A";
            break;
        case 10:
            $diretorio = '../assets/img/imgAlunos/img3B';
            $turma = "3B";
            break;
        case 11:
            $diretorio = '../assets/img/imgAlunos/img3C';
            $turma = "3C";
            break;
        case 12:
            $diretorio = '../assets/img/imgAlunos/img3D';
            $turma = "3D";
            break;
        default:
            header('location:decisao.php');
            exit();
    }
} else {
    header('location:decisao.php');
    exit();
}

class qrCode1
{
    public function __construct($turma)
    {
        $this->pdf($turma);
    }

    public function pdf($turma)
    {
        $pdf = new FPDF("L", "cm", "A4");
        $pdf->AliasNbPages();
        $pdf->AddPage();

        global $diretorio;
        $arquivos = scandir($diretorio);
        $alunos = [];

        // Filtrar apenas arquivos de imagem e extrair nomes
        foreach ($arquivos as $arquivo) {
            if (in_array(strtolower(pathinfo($arquivo, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
                $nome_arquivo = pathinfo($arquivo, PATHINFO_FILENAME);
                // Assumindo que o nome do arquivo segue o padrão "id_nome" ou apenas "nome"
                $partes = explode('_', $nome_arquivo);
                $nome = end($partes); // Pega o último segmento como nome
                $alunos[] = ['id_aluno' => basename($nome_arquivo), 'nome' => $nome, 'arquivo' => $arquivo];
            }
        }

        // Configurações de layout
        $cracha_width = 5; // Largura do crachá (cm)
        $cracha_height = 8; // Altura do crachá (cm)
        $qr_size = 3.5; // Tamanho do QR code (cm)
        $space_between = 1; // Espaço entre crachás (cm)
        $max_per_line = 2; // Máximo de pares (frente e verso) por linha
        $start_x = 2; // Posição X inicial (cm)
        $start_y = 0.5; // Posição Y inicial (cm)
        $current_x = $start_x;
        $current_y = $start_y;

        foreach ($alunos as $aluno) {
            // Verificar se o par (frente e verso) cabe na página atual
            if ($current_y + $cracha_height + 1 > $pdf->GetPageHeight() - 1) {
                $pdf->AddPage();
                $current_x = $start_x;
                $current_y = $start_y;
            }

            // Caminho da frente do crachá (foto do aluno)
            $frente_cracha = $diretorio . '/' . $aluno['arquivo'];

            // Gerar o QR code para o verso
            $arquivo_qrcode = __DIR__ . "/qrcode_" . $aluno['id_aluno'] . ".png";
            QRcode::png("https://salaberga.com/../../../../teste/salaberga/portalsalaberga/app/subsystems/entradasaida/index.php?id_aluno=" . $aluno['id_aluno'], $arquivo_qrcode, QR_ECLEVEL_M, 4);

            if (!file_exists($arquivo_qrcode) || !getimagesize($arquivo_qrcode)) {
                die("Erro: QR Code não gerado para " . $aluno['nome']);
            }

            // Colocar a frente do crachá (foto do aluno)
            $pdf->Image($frente_cracha, $current_x, $current_y, $cracha_width, $cracha_height);

            // Colocar o verso do crachá (com QR code) ao lado
            $verso_x = $current_x + $cracha_width + $space_between; // Posição do verso ao lado da frente
            $pdf->Image('../assets/img/crach.jpg', $verso_x, $current_y, $cracha_width, $cracha_height);

            // Calcular a posição do QR code para centralizá-lo no verso
            $qr_x = $verso_x + ($cracha_width - $qr_size) / 2; // Centraliza o QR code
            $qr_y = $current_y + 3; // 0.5 cm de margem do topo da imagem
            $pdf->Image($arquivo_qrcode, $qr_x, $qr_y, $qr_size, $qr_size);

            // Exibir o nome do aluno abaixo do par (frente e verso)
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY($current_x, $current_y + $cracha_height + 0.2); // 0.2 cm abaixo do crachá
            $pdf->Cell($cracha_width * 2 + $space_between, 0.5,utf8_decode($aluno['nome']), 0, 1, 'C');

            // Remover o arquivo temporário do QR code
            if (file_exists($arquivo_qrcode)) {
                unlink($arquivo_qrcode);
            }

            // Atualizar a posição X para o próximo par
            $current_x += ($cracha_width * 2) + ($space_between * 2); // Espaço para frente + verso + espaço entre pares

            // Verificar se atingiu o limite da linha
            if ($current_x + ($cracha_width * 2) > $pdf->GetPageWidth() - 2) {
                $current_x = $start_x;
                $current_y += $cracha_height + 1; // Espaço vertical para a próxima linha
            }
        }

        // Finalizar o PDF
        $pdf->Output('I', 'crachas_turma.pdf');
    }
}

$qrcode = new qrCode1($turma);
