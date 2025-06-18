<?php
require_once('../models/adm.model.php');
$model_adm = new adm_model();
session_start();
print_r($_SESSION);
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .status-message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
        }

        .status-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .status-error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .status-empty {
            background-color: #fff3e0;
            color: #ef6c00;
            border: 1px solid #ffcc80;
        }

        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .radio-group {
            display: flex;
            gap: 15px;
            margin-top: 5px;
        }

        .radio-group label {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        button[type="submit"] {
            background-color: #2196f3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        button[type="submit"]:hover {
            background-color: #1976d2;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_GET['status'])) {
        switch ($_GET['status']) {
            case 'success':
                echo '<div class="status-message status-success">Demanda cadastrada com sucesso!</div>';
                break;
            case 'error':
                echo '<div class="status-message status-error">Erro ao cadastrar demanda. Verifique se o título já existe.</div>';
                break;
            case 'empty':
                echo '<div class="status-message status-empty">Por favor, preencha todos os campos.</div>';
                break;
        }
    }
    ?>

    <div class="form-container">
        <form action="../controllers/adm.controller.php" method="post">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao" id="descricao" required>
            </div>

            <div class="form-group">
                <label>Prioridade</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="prioridade" value="baixa" required>
                        Baixa
                    </label>
                    <label>
                        <input type="radio" name="prioridade" value="media" required>
                        Média
                    </label>
                    <label>
                        <input type="radio" name="prioridade" value="alta" required>
                        Alta
                    </label>
                </div>
            </div>
            <input type="hidden" name="id_admin" value="<?=$_SESSION['user_id']?>">
            <input type="date" name="prazo" required>

            <button type="submit">Cadastrar Demanda</button>
        </form>
    </div>

    <h1>Em andamento</h1>
    <div class="demanda-container">
        <?php
        $dados = $model_adm->select_demandas_andamentos();

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
        $dados = $model_adm->select_demandas_pendentes();

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
        $dados = $model_adm->select_demandas_concluidos();

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