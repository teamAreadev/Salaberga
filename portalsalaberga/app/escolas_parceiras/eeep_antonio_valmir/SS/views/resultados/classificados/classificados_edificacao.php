<?php

function classificados_edificacao()
{

    require_once('../../../config/connect.php');
    require_once('../../../assets/fpdf/fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage();

    // Cabeçalho com larguras ajustadas
    $pdf->Image('../../../assets/images/logo.png', 8, 8, 15, 0, 'PNG');
    $pdf->SetFont('Arial', 'B', 25);
    $pdf->Cell(185, 10, ('CLASSIFICADOS EDIFICACAO'), 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 10, ('PCD = PESSOA COM DEFICIENCIA | COTISTA = INCLUSO NA COTA DO BAIRRO | AC = AMPLA CONCORRENCIA'), 0, 1, 'C');
    $pdf->SetFont('Arial', 'b', 12);
    $pdf->Cell(185, 10, '', 0, 1, 'C');

    //Edificação

    //ac_publica
    $stmtSelect_edificacao_ac_publica = $conexao->prepare("
SELECT candidato.nome, candidato.id_curso1_fk, candidato.publica, candidato.bairro, candidato.pcd, nota.media
FROM candidato 
INNER JOIN nota ON nota.candidato_id_candidato = candidato.id_candidato AND candidato.publica = 1 AND candidato.id_curso1_fk = 4 AND  candidato.bairro = 0 AND candidato.pcd = 0 
ORDER BY nota.media DESC LIMIT 24
");
    $stmtSelect_edificacao_ac_publica->execute();
    $result = $stmtSelect_edificacao_ac_publica->fetchAll(PDO::FETCH_ASSOC);

    // Fonte do cabeçalho
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(93, 164, 67); //fundo verde
    $pdf->SetTextColor(255, 255, 255);  //texto branco
    $pdf->Cell(191, -8, "Rede Publica - AC", 1, 0, 'C', true);
    $pdf->Ln(0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(93, 164, 67); //fundo verde
    $pdf->SetTextColor(255, 255, 255);  //texto branco
    $pdf->Cell(10, 7, 'CH', 1, 0, 'C', true);
    $pdf->Cell(90, 7, 'Nome', 1, 0, 'C', true);
    $pdf->Cell(32, 7, 'Curso', 1, 0, 'C', true);
    $pdf->Cell(18, 7, 'Origem', 1, 0, 'C', true);
    $pdf->Cell(26, 7, 'Segmento', 1, 0, 'C', true);
    $pdf->Cell(15, 7, 'Media', 1, 1, 'C', true);

    // Resetar cor do texto para preto
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);

    // Dados com cores alternadas
    $classificacao = 001;

    foreach ($result as $row) {
        // Definir curso
        switch ($row['id_curso1_fk']) {
            case 1:
                $curso = ('ENFERMAGEM');
                break;
            case 2:
                $curso = ('INFORMATICA');
                break;
            case 3:
                $curso = ('ADMINISTRACAO');
                break;
            case 4:
                $curso = ('EDIFICACOES');
                break;
            default:
                $curso = ('Não definido');
                break;
        }

        // Definir escola
        $escola = ($row['publica'] == 1) ? ('PUBLICA') : ('PRIVADA');

        // Definir cota
        if ($row['pcd'] == 1) {
            $cota = 'PCD';
        } else if ($row['publica'] == 1 && $row['bairro'] == 1) {
            $cota = 'COSTISTA';
        } else {
            $cota = 'AC';
        }

        // Definir cor da linha
        $cor = $classificacao % 2 ? 255 : 192;
        $pdf->SetFillColor($cor, $cor, $cor);

        // Imprimir linha no PDF
        $pdf->Cell(10, 7, sprintf("%03d", $classificacao), 1, 0, 'C', true);
        $pdf->Cell(90, 7, strToUpper(($row['nome'])), 1, 0, 'L', true);
        $pdf->Cell(32, 7, $curso, 1, 0, 'L', true);
        $pdf->Cell(18, 7, $escola, 1, 0, 'L', true);
        $pdf->Cell(26, 7, $cota, 1, 0, 'L', true);
        $pdf->Cell(15, 7, number_format($row['media'], 2), 1, 1, 'C', true);

        $classificacao++;
    }
    $pdf->Ln(20);

    //bairro_publica
    $stmtSelect_edificacao_bairro_publica = $conexao->prepare("
SELECT candidato.nome, candidato.id_curso1_fk, candidato.publica, candidato.bairro, candidato.pcd, nota.media
FROM candidato 
INNER JOIN nota ON nota.candidato_id_candidato = candidato.id_candidato AND candidato.publica = 1 AND candidato.id_curso1_fk = 4 AND  candidato.bairro = 1 AND candidato.pcd = 0 
ORDER BY nota.media DESC LIMIT 10;
");
    $stmtSelect_edificacao_bairro_publica->execute();
    $result = $stmtSelect_edificacao_bairro_publica->fetchAll(PDO::FETCH_ASSOC);

    // Fonte do cabeçalho
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(93, 164, 67); //fundo verde
    $pdf->SetTextColor(255, 255, 255);  //texto branco
    $pdf->Cell(191, -8, "Rede Publica - Cota", 1, 0, 'C', true);
    $pdf->Ln(0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(93, 164, 67); //fundo verde
    $pdf->SetTextColor(255, 255, 255);  //texto branco
    $pdf->Cell(10, 7, 'CH', 1, 0, 'C', true);
    $pdf->Cell(90, 7, 'Nome', 1, 0, 'C', true);
    $pdf->Cell(32, 7, 'Curso', 1, 0, 'C', true);
    $pdf->Cell(18, 7, 'Origem', 1, 0, 'C', true);
    $pdf->Cell(26, 7, 'Segmento', 1, 0, 'C', true);
    $pdf->Cell(15, 7, 'Media', 1, 1, 'C', true);

    // Resetar cor do texto para preto
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);

    // Dados com cores alternadas
    $classificacao = 001;

    foreach ($result as $row) {
        // Definir curso
        switch ($row['id_curso1_fk']) {
            case 1:
                $curso = ('ENFERMAGEM');
                break;
            case 2:
                $curso = ('INFORMATICA');
                break;
            case 3:
                $curso = ('ADMINISTRACAO');
                break;
            case 4:
                $curso = ('EDIFICACOES');
                break;
            default:
                $curso = ('Não definido');
                break;
        }

        // Definir escola
        $escola = ($row['publica'] == 1) ? ('PUBLICA') : ('PRIVADA');

        // Definir cota
        if ($row['pcd'] == 1) {
            $cota = 'PCD';
        } else if ($row['publica'] == 1 && $row['bairro'] == 1) {
            $cota = 'COSTISTA';
        } else {
            $cota = 'AC';
        }

        // Definir cor da linha
        $cor = $classificacao % 2 ? 255 : 192;
        $pdf->SetFillColor($cor, $cor, $cor);

        // Imprimir linha no PDF
        $pdf->Cell(10, 7, sprintf("%03d", $classificacao), 1, 0, 'C', true);
        $pdf->Cell(90, 7, strToUpper(($row['nome'])), 1, 0, 'L', true);
        $pdf->Cell(32, 7, $curso, 1, 0, 'L', true);
        $pdf->Cell(18, 7, $escola, 1, 0, 'L', true);
        $pdf->Cell(26, 7, $cota, 1, 0, 'L', true);
        $pdf->Cell(15, 7, number_format($row['media'], 2), 1, 1, 'C', true);

        $classificacao++;
    }
    $pdf->Ln(20);

    //ac_privada
    $stmtSelect_edificacao_ac_privada = $conexao->prepare("
SELECT candidato.nome, candidato.id_curso1_fk, candidato.publica, candidato.bairro, candidato.pcd, nota.media
FROM candidato 
INNER JOIN nota ON nota.candidato_id_candidato = candidato.id_candidato AND candidato.publica = 0 AND candidato.id_curso1_fk = 4 AND  candidato.bairro = 0 AND candidato.pcd = 0 
ORDER BY nota.media DESC LIMIT 6;
");
    $stmtSelect_edificacao_ac_privada->execute();
    $result = $stmtSelect_edificacao_ac_privada->fetchAll(PDO::FETCH_ASSOC);

    // Fonte do cabeçalho
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(93, 164, 67); //fundo verde
    $pdf->SetTextColor(255, 255, 255);  //texto branco
    $pdf->Cell(191, -8, "Rede Privada - AC", 1, 0, 'C', true);
    $pdf->Ln(0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(93, 164, 67); //fundo verde
    $pdf->SetTextColor(255, 255, 255);  //texto branco
    $pdf->Cell(10, 7, 'CH', 1, 0, 'C', true);
    $pdf->Cell(90, 7, 'Nome', 1, 0, 'C', true);
    $pdf->Cell(32, 7, 'Curso', 1, 0, 'C', true);
    $pdf->Cell(18, 7, 'Origem', 1, 0, 'C', true);
    $pdf->Cell(26, 7, 'Segmento', 1, 0, 'C', true);
    $pdf->Cell(15, 7, 'Media', 1, 1, 'C', true);

    // Resetar cor do texto para preto
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);

    // Dados com cores alternadas
    $classificacao = 001;

    foreach ($result as $row) {
        // Definir curso
        switch ($row['id_curso1_fk']) {
            case 1:
                $curso = ('ENFERMAGEM');
                break;
            case 2:
                $curso = ('INFORMATICA');
                break;
            case 3:
                $curso = ('ADMINISTRACAO');
                break;
            case 4:
                $curso = ('EDIFICACOES');
                break;
            default:
                $curso = ('Não definido');
                break;
        }

        // Definir escola
        $escola = ($row['publica'] == 1) ? ('PUBLICA') : ('PRIVADA');

        // Definir cota
        if ($row['pcd'] == 1) {
            $cota = 'PCD';
        } else if ($row['publica'] == 1 && $row['bairro'] == 1) {
            $cota = 'COSTISTA';
        } else {
            $cota = 'AC';
        }

        // Definir cor da linha
        $cor = $classificacao % 2 ? 255 : 192;
        $pdf->SetFillColor($cor, $cor, $cor);

        // Imprimir linha no PDF
        $pdf->Cell(10, 7, sprintf("%03d", $classificacao), 1, 0, 'C', true);
        $pdf->Cell(90, 7, strToUpper(($row['nome'])), 1, 0, 'L', true);
        $pdf->Cell(32, 7, $curso, 1, 0, 'L', true);
        $pdf->Cell(18, 7, $escola, 1, 0, 'L', true);
        $pdf->Cell(26, 7, $cota, 1, 0, 'L', true);
        $pdf->Cell(15, 7, number_format($row['media'], 2), 1, 1, 'C', true);

        $classificacao++;
    }
    $pdf->Ln(20);

    //bairro_privada
    $stmtSelect_edificacao_bairro_privada = $conexao->prepare("
SELECT candidato.nome, candidato.id_curso1_fk, candidato.publica, candidato.bairro, candidato.pcd, nota.media
FROM candidato 
INNER JOIN nota ON nota.candidato_id_candidato = candidato.id_candidato AND candidato.publica = 0 AND candidato.id_curso1_fk = 4 AND  candidato.bairro = 1 AND candidato.pcd = 0 
ORDER BY nota.media DESC LIMIT 3;
");
    $stmtSelect_edificacao_bairro_privada->execute();
    $result = $stmtSelect_edificacao_bairro_privada->fetchAll(PDO::FETCH_ASSOC);

    // Fonte do cabeçalho
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(93, 164, 67); //fundo verde
    $pdf->SetTextColor(255, 255, 255);  //texto branco
    $pdf->Cell(191, -8, "Rede Privada - Cota", 1, 0, 'C', true);
    $pdf->Ln(0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(93, 164, 67); //fundo verde
    $pdf->SetTextColor(255, 255, 255);  //texto branco
    $pdf->Cell(10, 7, 'CH', 1, 0, 'C', true);
    $pdf->Cell(90, 7, 'Nome', 1, 0, 'C', true);
    $pdf->Cell(32, 7, 'Curso', 1, 0, 'C', true);
    $pdf->Cell(18, 7, 'Origem', 1, 0, 'C', true);
    $pdf->Cell(26, 7, 'Segmento', 1, 0, 'C', true);
    $pdf->Cell(15, 7, 'Media', 1, 1, 'C', true);

    // Resetar cor do texto para preto
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);

    // Dados com cores alternadas
    $classificacao = 001;

    foreach ($result as $row) {
        // Definir curso
        switch ($row['id_curso1_fk']) {
            case 1:
                $curso = ('ENFERMAGEM');
                break;
            case 2:
                $curso = ('INFORMATICA');
                break;
            case 3:
                $curso = ('ADMINISTRACAO');
                break;
            case 4:
                $curso = ('EDIFICACOES');
                break;
            default:
                $curso = ('Não definido');
                break;
        }

        // Definir escola
        $escola = ($row['publica'] == 1) ? ('PUBLICA') : ('PRIVADA');

        // Definir cota
        if ($row['pcd'] == 1) {
            $cota = 'PCD';
        } else if ($row['bairro'] == 1) {
            $cota = 'COSTISTA';
        } else {
            $cota = 'AC';
        }

        // Definir cor da linha
        $cor = $classificacao % 2 ? 255 : 192;
        $pdf->SetFillColor($cor, $cor, $cor);

        // Imprimir linha no PDF
        $pdf->Cell(10, 7, sprintf("%03d", $classificacao), 1, 0, 'C', true);
        $pdf->Cell(90, 7, strToUpper(($row['nome'])), 1, 0, 'L', true);
        $pdf->Cell(32, 7, $curso, 1, 0, 'L', true);
        $pdf->Cell(18, 7, $escola, 1, 0, 'L', true);
        $pdf->Cell(26, 7, $cota, 1, 0, 'L', true);
        $pdf->Cell(15, 7, number_format($row['media'], 2), 1, 1, 'C', true);

        $classificacao++;
    }
    $pdf->Ln(20);

    //pcd
    $stmtSelect_edificacao_pcd = $conexao->prepare("
SELECT candidato.nome, candidato.id_curso1_fk, candidato.publica, candidato.bairro, candidato.pcd, nota.media
FROM candidato 
INNER JOIN nota ON nota.candidato_id_candidato = candidato.id_candidato AND candidato.id_curso1_fk = 4 AND candidato.pcd = 1 
ORDER BY nota.media DESC LIMIT 2;
");
    $stmtSelect_edificacao_pcd->execute();
    $result = $stmtSelect_edificacao_pcd->fetchAll(PDO::FETCH_ASSOC);

    // Fonte do cabeçalho
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(93, 164, 67); //fundo verde
    $pdf->SetTextColor(255, 255, 255);  //texto branco
    $pdf->Cell(191, -8, "PCD", 1, 0, 'C', true);
    $pdf->Ln(0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(93, 164, 67); //fundo verde
    $pdf->SetTextColor(255, 255, 255);  //texto branco
    $pdf->Cell(10, 7, 'CH', 1, 0, 'C', true);
    $pdf->Cell(90, 7, 'Nome', 1, 0, 'C', true);
    $pdf->Cell(32, 7, 'Curso', 1, 0, 'C', true);
    $pdf->Cell(18, 7, 'Origem', 1, 0, 'C', true);
    $pdf->Cell(26, 7, 'Segmento', 1, 0, 'C', true);
    $pdf->Cell(15, 7, 'Media', 1, 1, 'C', true);

    // Resetar cor do texto para preto
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);

    // Dados com cores alternadas
    $classificacao = 001;

    foreach ($result as $row) {
        // Definir curso
        switch ($row['id_curso1_fk']) {
            case 1:
                $curso = ('ENFERMAGEM');
                break;
            case 2:
                $curso = ('INFORMATICA');
                break;
            case 3:
                $curso = ('ADMINISTRACAO');
                break;
            case 4:
                $curso = ('EDIFICACOES');
                break;
            default:
                $curso = ('Não definido');
                break;
        }

        // Definir escola
        $escola = ($row['publica'] == 1) ? ('PUBLICA') : ('PRIVADA');

        // Definir cota
        if ($row['pcd'] == 1) {
            $cota = 'PCD';
        } else if ($row['publica'] == 1 && $row['bairro'] == 1) {
            $cota = 'COSTISTA';
        } else {
            $cota = 'AC';
        }

        // Definir cor da linha
        $cor = $classificacao % 2 ? 255 : 192;
        $pdf->SetFillColor($cor, $cor, $cor);

        // Imprimir linha no PDF
        $pdf->Cell(10, 7, sprintf("%03d", $classificacao), 1, 0, 'C', true);
        $pdf->Cell(90, 7, strToUpper(($row['nome'])), 1, 0, 'L', true);
        $pdf->Cell(32, 7, $curso, 1, 0, 'L', true);
        $pdf->Cell(18, 7, $escola, 1, 0, 'L', true);
        $pdf->Cell(26, 7, $cota, 1, 0, 'L', true);
        $pdf->Cell(15, 7, number_format($row['media'], 2), 1, 1, 'C', true);

        $classificacao++;
    }
    $pdf->Ln(20);

    $pdf->Output('classificacao.pdf', 'I');
}
classificados_edificacao();