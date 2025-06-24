<?php

require_once('../../../../entradaSaida/app/main/config/Database.php');
require_once('../../../assets/fpdf/fpdf.php');

try {
    $db = new connect();
    $conn = $db->getConnection();
} catch (PDOException $e) {
    die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
}

$query = "
    SELECT
        a.nome AS nome_aluno,
        a.matricula,
        a.id_turma,
        c.curso AS nome_curso,
        (CASE
            WHEN c.curso LIKE '%Enfermagem%' THEN 'A'
            WHEN c.curso LIKE '%Informática%' THEN 'B'
            WHEN c.curso LIKE '%Meio Ambiente%' THEN 'C'
            WHEN c.curso LIKE '%Administração%' THEN 'C'
            WHEN c.curso LIKE '%Edificações%' THEN 'D'
            ELSE ''
        END) AS letra_turma,
        e.nome AS nome_evento,
        e.data_evento,
        f.presente,
        f.data_registro
    FROM
        frequencia_sesmated AS f
    JOIN
        aluno AS a ON f.id_aluno = a.id_aluno
    JOIN
        evento AS e ON f.id_evento = e.id_evento
    JOIN
        curso AS c ON a.id_curso = c.id_curso
    ORDER BY
        e.nome,
        a.id_turma,
        CASE
            WHEN c.curso LIKE '%Enfermagem%' THEN 1
            WHEN c.curso LIKE '%Informática%' THEN 2
            WHEN c.curso LIKE '%Meio Ambiente%' THEN 3
            WHEN c.curso LIKE '%Administração%' THEN 4
            WHEN c.curso LIKE '%Edificações%' THEN 5
            ELSE 6
        END,
        a.nome;
";

$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$turmasMapping = [
    9 => '3º Ano',
    10 => '3º Ano',
    11 => '3º Ano',
    12 => '3º Ano',
    // Adicione outros mapeamentos de id_turma para ano se necessário
];

$frequenciaPorEvento = [];
foreach ($results as $row) {
    $frequenciaPorEvento[$row['nome_evento']]['data'] = $row['data_evento'];
    $frequenciaPorEvento[$row['nome_evento']]['alunos'][] = $row;
}

class PDF extends FPDF
{
    function Header()
    {
        // Adiciona a imagem de fundo
        $this->Image('../../../assets/img/fundo.jpg', 0, 0, $this->GetPageWidth(), $this->GetPageHeight());

        // Pula um espaço no topo para não sobrepor os logos da imagem de fundo.
        $this->Ln(50);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function ChapterTitle($label)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(114, 203, 72);
        $this->Cell(0, 6, utf8_decode($label), 0, 1, 'L', true);
        $this->Ln(4);
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetMargins(5, 10, 5); // Diminui as margens para alargar a tabela

if (empty($frequenciaPorEvento)) {
    $pdf->AddPage('P', 'A4');
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Nenhum dado de frequencia encontrado.', 0, 1, 'C');
} else {
    $pdf->AddPage('P', 'A4');
    foreach ($frequenciaPorEvento as $nomeEvento => $dadosEvento) {
        $dataEvento = date('d/m/Y', strtotime($dadosEvento['data']));
        $pdf->ChapterTitle($nomeEvento . " - " . $dataEvento);

        // Cabeçalho da tabela
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(25, 7, utf8_decode('Matrícula'), 1, 0, 'C', true);
        $pdf->Cell(65, 7, utf8_decode('Aluno'), 1, 0, 'C', true);
        $pdf->Cell(15, 7, utf8_decode('Ano'), 1, 0, 'C', true);
        $pdf->Cell(15, 7, utf8_decode('Turma'), 1, 0, 'C', true);
        $pdf->Cell(40, 7, utf8_decode('Curso'), 1, 0, 'C', true);
        $pdf->Cell(20, 7, utf8_decode('Presença'), 1, 0, 'C', true);
        $pdf->Cell(20, 7, utf8_decode('Registro'), 1, 1, 'C', true);
        $pdf->SetFont('Arial', '', 9);

        foreach ($dadosEvento['alunos'] as $aluno) {
            $anoTurma = $turmasMapping[$aluno['id_turma']] ?? '';

            $curso = $aluno['nome_curso'];
            if (stripos($curso, 'Enfermagem') !== false) {
                $pdf->SetFillColor(255, 192, 203); // Vermelho claro (Rosa)
            } elseif (stripos($curso, 'Informática') !== false) {
                $pdf->SetFillColor(176, 196, 222); // Azul aço claro
            } elseif (stripos($curso, 'Meio Ambiente') !== false) {
                $pdf->SetFillColor(144, 238, 144); // Verde claro
            } elseif (stripos($curso, 'Administração') !== false) {
                $pdf->SetFillColor(173, 216, 230); // Azul claro
            } elseif (stripos($curso, 'Edificações') !== false) {
                $pdf->SetFillColor(211, 211, 211); // Cinza claro
            } else {
                $pdf->SetFillColor(255, 255, 255); // Branco
            }

            $pdf->Cell(25, 6, mb_strtoupper($aluno['matricula'], 'UTF-8'), 1, 0, 'C', true);
            $pdf->Cell(65, 6, utf8_decode(mb_strtoupper($aluno['nome_aluno'], 'UTF-8')), 1, 0, 'L', true);
            $pdf->Cell(15, 6, utf8_decode(mb_strtoupper($anoTurma, 'UTF-8')), 1, 0, 'C', true);
            $pdf->Cell(15, 6, utf8_decode(mb_strtoupper($aluno['letra_turma'], 'UTF-8')), 1, 0, 'C', true);
            $pdf->Cell(40, 6, utf8_decode(mb_strtoupper($aluno['nome_curso'], 'UTF-8')), 1, 0, 'C', true);

            $presenca = $aluno['presente'] ? 'Presente' : 'Ausente';
            $pdf->SetTextColor(0, 0, 0); // Garante que o texto de presença seja legível
            $pdf->Cell(20, 6, utf8_decode(mb_strtoupper($presenca, 'UTF-8')), 1, 0, 'C', true);
            
            $horaRegistro = date('H:i', strtotime($aluno['data_registro']));
            $pdf->Cell(20, 6, $horaRegistro, 1, 1, 'C', true);
        }
        $pdf->Ln(10); // Espaçamento entre os eventos
    }
}

$pdf->Output('I', 'Relatorio_Frequencia.pdf');
?>