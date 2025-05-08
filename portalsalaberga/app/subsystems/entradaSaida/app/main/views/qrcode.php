<?php
define('FPDF_FONTPATH', __DIR__ . '/../assets/fpdf/font/');
require_once('../assets/fpdf/fpdf.php');
require_once('../config/Database.php');
require_once('../assets/phpqrcode/qrlib.php');

class qrCode1 extends Database
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdf();
    }

    public function pdf()
    {
 


         
        $pdf = new FPDF("L", "cm", "A4");
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $curso = $_POST["turma"];
        $pdo = $this->db->connect();

        $queryStr = "SELECT id_aluno, nome from aluno WHERE id_turma = :turma";
        $query = $pdo->prepare($queryStr);
        $query->bindValue(":turma", $curso);
        $query->execute();

        $id_aluno = $query->fetchAll(PDO::FETCH_ASSOC);


        // Configurações de layout
        $cracha_width = 5; // Largura do crachá (cm)
        $cracha_height = 8; // Altura do crachá (cm)
        $qr_size = 3.5; // Tamanho do QR code (cm)
        $space_between = 1; // Espaço entre crachás (cm)
        $max_per_line = 3; // Máximo de crachás por linha
        $start_x = 2; // Posição X inicial (cm)
        $start_y = 0.5; // Posição Y inicial (cm)
        $current_x = $start_x;
        $current_y = $start_y;

        foreach ($id_aluno as $id) {
            // Verificar se o crachá cabe na página atual
            if ($current_y + $cracha_height + 1 > $pdf->GetPageHeight() - 1) {
                $pdf->AddPage();
                $current_x = $start_x;
                $current_y = $start_y;
            }

            // Gerar o QR code
            $arquivo_qrcode = __DIR__ . "/qrcode_" . $id['id_aluno'] . ".png";
            QRcode::png("https://salaberga.com/salaberga/portalsalaberga/app/main/views/subsytem/subsistema.php?id_aluno=" . $id['id_aluno'], $arquivo_qrcode, QR_ECLEVEL_M, 4);

            // Verificar se o arquivo foi criado
            if (!file_exists($arquivo_qrcode) || !getimagesize($arquivo_qrcode)) {
                die("Erro: QR Code não gerado para " . $id['nome']);
            }

            // Colocar a imagem de fundo (crachá)
            $pdf->Image('../assets/img/crach.jpg', $current_x, $current_y, $cracha_width, $cracha_height);

            // Calcular a posição do QR code para centralizá-lo em cima da imagem
            $qr_x = $current_x + ($cracha_width - $qr_size) / 2; // Centraliza o QR code
            $qr_y = $current_y + 3; // 0.5 cm de margem do topo da imagem
            $pdf->Image($arquivo_qrcode, $qr_x, $qr_y, $qr_size, $qr_size);

            // Exibir o ID do aluno abaixo do crachá
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY($current_x, $current_y + $cracha_height + 0.2); // 0.2 cm abaixo do crachá
            $pdf->Cell($cracha_width, 0.5, $id['nome'], 0, 1, 'C');

            // Remover o arquivo temporário
            if (file_exists($arquivo_qrcode)) {
                unlink($arquivo_qrcode);
            }

            // Atualizar a posição X para o próximo crachá
            $current_x += $cracha_width + $space_between;

            // Verificar se atingiu o limite da linha
            if ($current_x + $cracha_width > $pdf->GetPageWidth() - 2) {
                $current_x = $start_x;
                $current_y += $cracha_height + 1; // Espaço vertical para a próxima linha
            }
        }

        // Finalizar o PDF após processar todos os crachás
        $pdf->Output('I', 'relatorio_acervo.pdf');
    }
}

$qrcode = new qrCode1();