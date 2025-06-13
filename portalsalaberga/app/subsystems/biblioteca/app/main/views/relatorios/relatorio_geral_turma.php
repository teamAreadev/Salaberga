<?php
require_once('../../models/select_model.php');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=sis_biblioteca;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id_turma = isset($_GET['turma']) ? $_GET['turma'] : null;
    $mes = isset($_GET['mes']) ? $_GET['mes'] : date('n');

    if (!$id_turma) {
        throw new Exception("ID da turma não fornecido");
    }

    $select_model = new select_model();
    $nome_turma = $select_model->get_turma_nome($id_turma);

    if (!$nome_turma) {
        throw new Exception("Turma não encontrada");
    }

    $aluno_destaque = $select_model->get_aluno_destaque($id_turma, $mes);
    if (empty($aluno_destaque)) {
        $aluno_destaque = 'Nenhum aluno encontrado para este mês';
    }

    $stmt_livros_por_aluno = $pdo->prepare("
        SELECT a.nome AS student_name, COUNT(e.id) AS book_count
        FROM emprestimo e
        JOIN aluno a ON e.id_aluno = a.id_aluno
        WHERE a.id_turma = :id_turma
          AND MONTH(e.data_emprestimo) = :mes
          AND YEAR(e.data_emprestimo) = YEAR(CURDATE())
        GROUP BY a.id_aluno, a.nome
        ORDER BY book_count DESC
    ");
    $stmt_livros_por_aluno->execute(['id_turma' => $id_turma, 'mes' => $mes]);
    $livros_por_aluno = $stmt_livros_por_aluno->fetchAll(PDO::FETCH_ASSOC);

    $chart_labels = [];
    $chart_data_values = [];
    foreach ($livros_por_aluno as $aluno_data) {
        $chart_labels[] = htmlspecialchars($aluno_data['student_name']);
        $chart_data_values[] = $aluno_data['book_count'];
    }

    // Preparar dados para JavaScript
    $json_chart_labels = json_encode($chart_labels);
    $json_chart_data_values = json_encode($chart_data_values);

    $meses = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    ];
    $nome_mes = $meses[$mes];

    ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Geral de Turma</title>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
   body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    min-height: 100vh;
    box-sizing: border-box;

    background-image: url('../../assets/img/layout.png');
    background-size: cover;           /* Garante que cubra toda a tela */
    background-repeat: no-repeat;     /* Não repete */
    background-position: center;      /* Centraliza */
    background-attachment: fixed;     /* Mantém fixo ao rolar */
}


h1, h2 {
    text-align: center;
    margin: 0;
}
h1 {
    color: #007a33;
    font-size: 2rem;
}
h2 {
    color: #FFA500;
    font-size: 1.5rem;
    margin-bottom: 20px;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 15px;
}

.content-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 20px;
}

.info-box {
    flex: 1 1 300px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.info-box h3 {
    color: #007a33;
    margin-top: 0;
}

.chart-container {
    flex: 1 1 300px;
    width: 100%;
}

.back-button {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    margin: 20px;
    background-color: #ffffff;
    color: #007a33;
    text-decoration: none;
    border-radius: 9999px;
    font-weight: bold;
    font-size: 16px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease, color 0.3s ease;
    border: 1px solid #ddd;
}
.back-button:hover {
    background-color: #007a33;
    color: white;
}
.back-button svg {
    transition: stroke 0.3s ease;
    margin-right: 8px;
}
.back-button:hover svg {
    stroke: white;
}

.btn-download-pdf {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007a33;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}
.btn-download-pdf:hover {
    background-color: #005f26;
}

@media (max-width: 768px) {
    h1 {
        font-size: 1.6rem;
    }

    h2 {
        font-size: 1.2rem;
    }

    .back-button, .btn-download-pdf {
        width: 100%;
        text-align: center;
        justify-content: center;
    }

    .info-box, .chart-container {
        flex: 1 1 100%;
    }
}


    </style>
</head>
<body>
<a href="../relatorios/geral_turma.php" class="back-button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="20" viewBox="0 0 24 24" width="20" stroke="#007a33" stroke-width="2" style="margin-right: 8px;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Voltar
</a>

    <div class="container">
        <h1>RELATÓRIO GERAL DE TURMA</h1>
        <h2>BIBLIOTECA STGM</h2>

        <div class="content-wrapper">
            <div class="info-box">
                <h3>Aluno(a) destaque:</h3>
                <p><?php echo htmlspecialchars($aluno_destaque); ?></p>
                <p><strong>Mês:</strong> <?php echo htmlspecialchars($nome_mes); ?></p>
                <p><strong>Turma:</strong> <?php echo htmlspecialchars($nome_turma); ?></p>
            </div>

            <div class="chart-container">
                <canvas id="booksChart"></canvas>
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="relatorio_geral_turma_pdf.php?turma=<?php echo $id_turma; ?>&mes=<?php echo $mes; ?>" class="btn-download-pdf" style="
                display: inline-block;
                padding: 10px 20px;
                background-color: #007a33;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
            ">
                Baixar Relatório em PDF
            </a>
        </div>
    </div>

    <script>
        const labels = <?php echo $json_chart_labels; ?>;
        const dataValues = <?php echo $json_chart_data_values; ?>;

        const ctx = document.getElementById('booksChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Livros Emprestados',
                    data: dataValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Livros emprestados por aluno no mês'
                    }
                }
            },
        });
    </script>
</body>
</html>
<?php
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
