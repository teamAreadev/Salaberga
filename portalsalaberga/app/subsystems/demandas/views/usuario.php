<?php
require_once('../models/usuario.model.php');
$model_usuario = new usuario_model();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Demandas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
        }

        .demanda-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .demanda-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .demanda-card:hover {
            transform: translateY(-5px);
        }

        .demanda-card h2 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 1.2em;
        }

        .demanda-card p {
            margin: 8px 0;
            color: #666;
        }

        .prioridade {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .prioridade-alta {
            background-color: #ffebee;
            color: #c62828;
        }

        .prioridade-media {
            background-color: #fff3e0;
            color: #ef6c00;
        }

        .prioridade-baixa {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .status-pendente {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .status-andamento {
            background-color: #fff3e0;
            color: #ef6c00;
        }

        .status-concluido {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
    </style>
</head>

<body>
    <h1>Em andamento</h1>
    <div class="demanda-container">
        <?php
        $dados = $model_usuario->select_demandas_andamentos();

        foreach ($dados as $dado) {
            $prioridadeClass = strtolower($dado['prioridade']) . '-prioridade';
        ?>
            <div class="demanda-card">
                <h2><?= htmlspecialchars($dado['titulo']) ?></h2>
                <p><?= htmlspecialchars($dado['descricao']) ?></p>
                <p>Prioridade: <span class="prioridade prioridade-<?= strtolower($dado['prioridade']) ?>"><?= htmlspecialchars($dado['prioridade']) ?></span></p>
                <p>Status: <span class="status status-andamento"><?= htmlspecialchars($dado['status']) ?></span></p>
                <p>Prazo: <?= htmlspecialchars($dado['prazo']) ?></p>
            </div>
        <?php } ?>
    </div>

    <h1>Pendente</h1>
    <div class="demanda-container">
        <?php
        $dados = $model_usuario->select_demandas_pendentes();

        foreach ($dados as $dado) {
        ?>
            <div class="demanda-card">
                <h2><?= htmlspecialchars($dado['titulo']) ?></h2>
                <p><?= htmlspecialchars($dado['descricao']) ?></p>
                <p>Prioridade: <span class="prioridade prioridade-<?= strtolower($dado['prioridade']) ?>"><?= htmlspecialchars($dado['prioridade']) ?></span></p>
                <p>Status: <span class="status status-pendente"><?= htmlspecialchars($dado['status']) ?></span></p>
                <p>Prazo: <?= htmlspecialchars($dado['prazo']) ?></p>
            </div>
        <?php } ?>
    </div>

    <h1>Concluída</h1>
    <div class="demanda-container">
        <?php
        $dados = $model_usuario->select_demandas_concluidos();

        foreach ($dados as $dado) {
        ?>
            <div class="demanda-card">
                <h2><?= htmlspecialchars($dado['titulo']) ?></h2>
                <p><?= htmlspecialchars($dado['descricao']) ?></p>
                <p>Prioridade: <span class="prioridade prioridade-<?= strtolower($dado['prioridade']) ?>"><?= htmlspecialchars($dado['prioridade']) ?></span></p>
                <p>Status: <span class="status status-concluido"><?= htmlspecialchars($dado['status']) ?></span></p>
                <p>Prazo: <?= htmlspecialchars($dado['prazo']) ?></p>
            </div>
        <?php } ?>
    </div>
</body>

</html>