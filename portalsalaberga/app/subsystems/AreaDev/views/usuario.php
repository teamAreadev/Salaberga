<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../model/Demanda.php';

session_start();

// Verificar se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$demanda = new Demanda($pdo);

// Processar atualização de status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'atualizar_status' && isset($_POST['id'])) {
    $demanda->marcarConcluida($_POST['id']);
    header("Location: usuario.php");
    exit();
}

$demandas = $demanda->listarDemandas();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A90E2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Painel do Usuário - Sistema de Gestão de Demandas</title>
</head>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#007A33',
                    secondary: '#FFA500',
                }
            }
        }
    }
</script>
<body class="bg-gray-100">
    <nav class="bg-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-white text-xl font-bold">Sistema de Gestão de Demandas</span>
                </div>
                <div class="flex items-center">
                    <span class="text-white mr-4">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                    <a href="logout.php" class="text-white hover:text-gray-200">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Minhas Demandas</h1>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($demandas as $d): ?>
                        <?php if ($d['usuario_id'] == $_SESSION['usuario_id']): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 cursor-pointer hover:text-primary" 
                                     onclick="mostrarDescricao('<?php echo htmlspecialchars($d['titulo']); ?>', '<?php echo htmlspecialchars($d['descricao']); ?>')">
                                    <?php echo htmlspecialchars($d['titulo']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                    <?php echo htmlspecialchars($d['descricao']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php echo $d['prioridade'] === 'alta' ? 'bg-red-100 text-red-800' : 
                                        ($d['prioridade'] === 'media' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'); ?>">
                                    <?php echo ucfirst($d['prioridade']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php echo $d['status'] === 'concluida' ? 'bg-green-100 text-green-800' : 
                                        ($d['status'] === 'em_andamento' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo ucfirst($d['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <?php if ($d['status'] !== 'concluida'): ?>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="acao" value="atualizar_status">
                                    <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                    <button type="submit" class="text-primary hover:text-primary/90">
                                        <i class="fas fa-check"></i> Marcar como Concluída
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Descrição -->
    <div id="modalDescricao" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="modalTitulo" class="text-lg font-medium leading-6 text-gray-900 mb-4"></h3>
                <p id="modalDescricao" class="text-sm text-gray-500"></p>
                <div class="mt-4 flex justify-end">
                    <button onclick="document.getElementById('modalDescricao').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrarDescricao(titulo, descricao) {
            document.getElementById('modalTitulo').textContent = titulo;
            document.getElementById('modalDescricao').textContent = descricao;
            document.getElementById('modalDescricao').classList.remove('hidden');
        }
    </script>
</body>
</html> 