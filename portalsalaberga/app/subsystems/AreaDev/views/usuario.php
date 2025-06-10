<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/DemandaController.php';

$demandaController = new DemandaController($db);

// Processar ações do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'atualizar_status') {
        $demandaController->atualizarStatusUsuarioDemanda(
            $_POST['demanda_id'],
            2, // ID do usuário fixo por enquanto
            $_POST['status']
        );
    }
}

$demandas = $demandaController->getDemandasUsuario(2); // ID do usuário fixo por enquanto
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Demandas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Minhas Demandas</h2>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Prioridade</th>
                                <th>Status</th>
                                <th>Prazo</th>
                                <th>Meu Status</th>
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
                                    <span class="badge bg-<?php 
                                        echo $demanda['status_usuario'] === 'concluido' ? 'success' : 
                                            ($demanda['status_usuario'] === 'em_andamento' ? 'primary' : 
                                            ($demanda['status_usuario'] === 'aceito' ? 'info' : 
                                            ($demanda['status_usuario'] === 'recusado' ? 'danger' : 'secondary'))); 
                                    ?>">
                                        <?php echo ucfirst($demanda['status_usuario']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($demanda['status_usuario'] === 'pendente'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="atualizar_status">
                                        <input type="hidden" name="demanda_id" value="<?php echo $demanda['id']; ?>">
                                        <input type="hidden" name="status" value="aceito">
                                        <button type="submit" class="btn btn-sm btn-success">Aceitar</button>
                                    </form>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="atualizar_status">
                                        <input type="hidden" name="demanda_id" value="<?php echo $demanda['id']; ?>">
                                        <input type="hidden" name="status" value="recusado">
                                        <button type="submit" class="btn btn-sm btn-danger">Recusar</button>
                                    </form>
                                    <?php elseif ($demanda['status_usuario'] === 'aceito'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="atualizar_status">
                                        <input type="hidden" name="demanda_id" value="<?php echo $demanda['id']; ?>">
                                        <input type="hidden" name="status" value="em_andamento">
                                        <button type="submit" class="btn btn-sm btn-primary">Iniciar</button>
                                    </form>
                                    <?php elseif ($demanda['status_usuario'] === 'em_andamento'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="atualizar_status">
                                        <input type="hidden" name="demanda_id" value="<?php echo $demanda['id']; ?>">
                                        <input type="hidden" name="status" value="concluido">
                                        <button type="submit" class="btn btn-sm btn-success">Concluir</button>
                                    </form>
                                    <?php endif; ?>
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
