<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/model/EquipeModel.php';

// Verificar se foi fornecido um ID de equipe
if (!isset($_GET['id'])) {
    die('Por favor, forneça um ID de equipe na URL usando ?id=X');
}

$equipeId = $_GET['id'];
$equipeModel = new EquipeModel();

// Buscar membros da equipe
$resultadoMembros = $equipeModel->listarMembrosEquipe($equipeId);

// Buscar valor da inscrição
$resultadoValor = $equipeModel->calcularValorInscricao($equipeId);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Equipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        .valor-total {
            font-size: 1.2em;
            font-weight: bold;
            color: #2c5282;
            margin-top: 20px;
        }
        .lider {
            color: #2c5282;
            font-weight: bold;
        }
        .error {
            color: #e53e3e;
            padding: 20px;
            border: 1px solid #e53e3e;
            border-radius: 8px;
            background-color: #fff5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!$resultadoMembros['success']): ?>
            <div class="error">
                <h2>Erro</h2>
                <p><?php echo htmlspecialchars($resultadoMembros['message']); ?></p>
            </div>
        <?php else: ?>
            <div class="card">
                <h2>Detalhes da Equipe</h2>
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($resultadoMembros['equipe']['nome']); ?></p>
                <p><strong>Modalidade:</strong> <?php echo htmlspecialchars($resultadoMembros['equipe']['modalidade']); ?></p>
                <p><strong>Categoria:</strong> <?php echo htmlspecialchars($resultadoMembros['equipe']['categoria']); ?></p>
                <p><strong>Total de Membros:</strong> <?php echo $resultadoMembros['total_membros']; ?></p>
            </div>

            <div class="card">
                <h2>Membros da Equipe</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Turma</th>
                            <th>Modalidades</th>
                            <th>Função</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultadoMembros['membros'] as $membro): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($membro['nome']); ?></td>
                                <td><?php echo htmlspecialchars($membro['ano'] . 'º ' . $membro['turma']); ?></td>
                                <td><?php echo $membro['total_modalidades']; ?></td>
                                <td><?php echo $membro['is_lider'] ? '<span class="lider">Líder</span>' : 'Membro'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($resultadoValor['success']): ?>
                <div class="card">
                    <h2>Valores das Inscrições</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Modalidades</th>
                                <th>Valor por Modalidade</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultadoValor['detalhes'] as $detalhe): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($detalhe['nome']); ?></td>
                                    <td><?php echo $detalhe['total_modalidades']; ?></td>
                                    <td>R$ <?php echo number_format($detalhe['valor_modalidade'], 2, ',', '.'); ?></td>
                                    <td>R$ <?php echo number_format($detalhe['valor_total'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p class="valor-total">Valor Total da Equipe: R$ <?php echo number_format($resultadoValor['valor_total'], 2, ',', '.'); ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html> 