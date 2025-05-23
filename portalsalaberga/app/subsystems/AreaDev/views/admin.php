<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../model/Demanda.php';
require_once __DIR__ . '/../model/Usuario.php';

session_start();

// Verificar se está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$demanda = new Demanda($pdo);
$usuario = new Usuario($pdo);

// Processar criação de demanda
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] === 'criar') {
        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $prioridade = $_POST['prioridade'] ?? 'media';
        $usuario_id = $_POST['usuario_id'] ?? null;

        if (!empty($titulo) && !empty($descricao)) {
            $demanda->criarDemanda($titulo, $descricao, $prioridade, $_SESSION['usuario_id'], $usuario_id);
            header("Location: admin.php");
            exit();
        }
    } elseif ($_POST['acao'] === 'excluir' && isset($_POST['id'])) {
        $demanda->excluirDemanda($_POST['id']);
        header("Location: admin.php");
        exit();
    } elseif ($_POST['acao'] === 'atualizar_status' && isset($_POST['id'])) {
        $demanda->marcarConcluida($_POST['id']);
        header("Location: admin.php");
        exit();
    } elseif ($_POST['acao'] === 'criar_usuario') {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $tipo = $_POST['tipo'] ?? 'usuario';

        if (!empty($nome) && !empty($email) && !empty($senha)) {
            $usuario->criarUsuario($nome, $email, $senha, $tipo);
            header("Location: admin.php");
            exit();
        }
    }
}

$demandas = $demanda->listarDemandas();
$usuarios = $usuario->listarUsuarios();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A90E2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Painel Administrativo - Sistema de Gestão de Demandas</title>
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
                <h1 class="text-2xl font-bold text-gray-900">Painel Administrativo</h1>
                <div class="space-x-4">
                    <button onclick="document.getElementById('modalCriarUsuario').classList.remove('hidden')" 
                            class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-secondary/90">
                        <i class="fas fa-user-plus mr-2"></i> Novo Usuário
                    </button>
                    <button onclick="document.getElementById('modalCriarDemanda').classList.remove('hidden')" 
                            class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90">
                        <i class="fas fa-plus mr-2"></i> Nova Demanda
                    </button>
                </div>
            </div>

            <!-- Modal Criar Usuário -->
            <div id="modalCriarUsuario" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Novo Usuário</h3>
                        <form method="POST" class="space-y-4">
                            <input type="hidden" name="acao" value="criar_usuario">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nome</label>
                                <input type="text" name="nome" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Senha</label>
                                <input type="password" name="senha" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                                <select name="tipo" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                    <option value="usuario">Usuário</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="document.getElementById('modalCriarUsuario').classList.add('hidden')"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/90">
                                    Criar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Criar Demanda -->
            <div id="modalCriarDemanda" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Nova Demanda</h3>
                        <form method="POST" class="space-y-4">
                            <input type="hidden" name="acao" value="criar">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Título</label>
                                <input type="text" name="titulo" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Descrição</label>
                                <textarea name="descricao" required rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prioridade</label>
                                <select name="prioridade" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                    <option value="baixa">Baixa</option>
                                    <option value="media">Média</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Atribuir para</label>
                                <select name="usuario_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                    <option value="">Selecione um usuário</option>
                                    <?php foreach ($usuarios as $u): ?>
                                    <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['nome']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="document.getElementById('modalCriarDemanda').classList.add('hidden')"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/90">
                                    Criar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($demandas as $d): ?>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($d['usuario_nome'] ?? 'Não atribuído'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <?php if ($d['status'] !== 'concluida'): ?>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="acao" value="atualizar_status">
                                    <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                    <button type="submit" class="text-primary hover:text-primary/90 mr-3">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                                <form method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta demanda?')">
                                    <input type="hidden" name="acao" value="excluir">
                                    <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
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