<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/DemandaController.php';

$demandaController = new DemandaController($db);

// Processar formulário de criação de demanda
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'criar') {
        $demandaController->criarDemanda(
            $_POST['titulo'],
            $_POST['descricao'],
            $_POST['prioridade'],
            1, // ID do admin fixo por enquanto
            $_POST['prazo']
        );
    }
}

$demandas = $demandaController->listarDemandas();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Demandas - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Gerenciamento de Demandas</h2>
        
        <!-- Formulário de Criação de Demanda -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Nova Demanda</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="criar">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="prioridade" class="form-label">Prioridade</label>
                        <select class="form-select" id="prioridade" name="prioridade" required>
                            <option value="baixa">Baixa</option>
                            <option value="media">Média</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="prazo" class="form-label">Prazo</label>
                        <input type="date" class="form-control" id="prazo" name="prazo" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Criar Demanda</button>
                </form>
            </div>
        </div>

        <!-- Lista de Demandas -->
        <div class="card">
            <div class="card-header">
                <h4>Demandas Existentes</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Prioridade</th>
                                <th>Status</th>
                                <th>Prazo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($demandas as $demanda): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($demanda['titulo']); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $demanda['prioridade'] === 'alta' ? 'danger' : 
                                            ($demanda['prioridade'] === 'media' ? 'warning' : 'info'); 
                                    ?>">
                                        <?php echo ucfirst($demanda['prioridade']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $demanda['status'] === 'concluida' ? 'success' : 
                                            ($demanda['status'] === 'em_andamento' ? 'primary' : 'secondary'); 
                                    ?>">
                                        <?php echo ucfirst($demanda['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($demanda['prazo'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="verDetalhes(<?php echo $demanda['id']; ?>)">
                                        Detalhes
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function verDetalhes(id) {
            window.location.href = `detalhes_demanda.php?id=${id}`;
        }
    </script>
</body>
</html>
