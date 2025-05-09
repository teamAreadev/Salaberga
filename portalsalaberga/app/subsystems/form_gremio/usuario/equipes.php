<?php
session_start();
if (!isset($_SESSION['aluno_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../config/config.php';
require_once '../model/EquipeModel.php';
require_once '../model/UsuarioModel.php';

$alunoId = $_SESSION['aluno_id'];
$equipeModel = new EquipeModel();
$usuarioModel = new UsuarioModel();

// Buscar dados do usuário
$dadosUsuario = $usuarioModel->obterDadosUsuario($alunoId);

// Buscar equipes do usuário
$resultadoEquipes = $equipeModel->listarEquipesUsuario($alunoId);

// Processar ações de formulário
$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Criar nova equipe
    if (isset($_POST['acao']) && $_POST['acao'] === 'criar_equipe') {
        $dadosEquipe = [
            'nome' => $_POST['nome'],
            'modalidade' => $_POST['modalidade'],
            'categoria' => $_POST['categoria'],
            'aluno_id' => $alunoId
        ];
        
        $resultado = $equipeModel->criarEquipe($dadosEquipe);
        $mensagem = $resultado['message'];
        $tipoMensagem = $resultado['success'] ? 'success' : 'error';
        
        if ($resultado['success']) {
            $resultadoEquipes = $equipeModel->listarEquipesUsuario($alunoId);
        }
    }
    
    // Entrar em equipe existente
    else if (isset($_POST['acao']) && $_POST['acao'] === 'entrar_equipe') {
        $codigo = $_POST['codigo'];
        $resultado = $equipeModel->entrarEquipe($alunoId, $codigo);
        $mensagem = $resultado['message'];
        $tipoMensagem = $resultado['success'] ? 'success' : 'error';
        
        if ($resultado['success']) {
            $resultadoEquipes = $equipeModel->listarEquipesUsuario($alunoId);
        }
    }
    
    // Sair da equipe
    else if (isset($_POST['acao']) && $_POST['acao'] === 'sair_equipe') {
        $equipeId = $_POST['equipe_id'];
        $resultado = $equipeModel->sairEquipe($alunoId, $equipeId);
        $mensagem = $resultado['message'];
        $tipoMensagem = $resultado['success'] ? 'success' : 'error';
        
        if ($resultado['success']) {
            $resultadoEquipes = $equipeModel->listarEquipesUsuario($alunoId);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Equipes - Copa Grêmio 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e6f2ec', 100: '#cce5d9', 200: '#99cbb3', 300: '#66b18d',
                            400: '#339766', 500: '#007d40', 600: '#006a36', 700: '#005A24',
                            800: '#004d1f', 900: '#00401a',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .modal { transition: opacity 0.3s ease, transform 0.3s ease; }
        .modal-hidden { opacity: 0; transform: scale(0.95); pointer-events: none; }
        .btn-primary { background-image: linear-gradient(to right, #007d40 0%, #339766 50%, #007d40 100%); }
        .btn-primary:hover { background-position: right center; transform: translateY(-2px); }
        .toast { transition: transform 0.3s ease-out, opacity 0.3s ease-out; }
        .table-responsive { 
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
            border-radius: 0.375rem;
            position: relative;
            max-height: none !important;
        }
        
        @media (max-width: 640px) {
            .table-responsive {
                position: relative;
            }
            
            .table-responsive::after {
                content: '';
                position: absolute;
                right: 0;
                top: 0;
                bottom: 0;
                width: 20px;
                background: linear-gradient(to right, transparent, rgba(255,255,255,0.9));
                pointer-events: none;
            }
            
            .table-responsive table {
                min-width: 100%;
            }
            
            .table-responsive th,
            .table-responsive td {
                white-space: nowrap;
                padding: 0.75rem 1rem;
            }
            
            .table-responsive thead th {
                position: sticky;
                top: 0;
                background: #f9fafb;
                z-index: 10;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Unified Navigation -->
        <nav class="bg-primary-700 text-white shadow-lg">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Design%20sem%20nome-MOpK2hbpuoqfoF8sir0Ue6SvciAArc.svg" 
                         alt="Logo Copa Grêmio" class="h-10 w-10" loading="lazy">
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold">Copa Grêmio 2025</h1>
                        <p class="text-primary-200 text-xs">Grêmio Estudantil José Ivan Pontes Júnior</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="mobile-menu-btn" class="md:hidden focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <ul id="nav-menu" class="hidden md:flex space-x-4">
                        <li><a href="dashboard.php" class="text-white hover:text-primary-200 px-3 py-2">Início</a></li>
                        <li><a href="equipes.php" class="text-primary-200 border-b-2 border-primary-400 px-3 py-2">Equipes</a></li>
                    
                        <li><a href="logout.php" class="text-white hover:text-primary-200 px-3 py-2">Sair</a></li>
                    </ul>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-primary-600">
                <ul class="flex flex-col space-y-2 px-4 py-3">
                    <li><a href="dashboard.php" class="text-white hover:text-primary-200 px-3 py-2 block">Início</a></li>
                    <li><a href="equipes.php" class="text-primary-200 border-l-4 border-primary-400 px-3 py-2 block">Equipes</a></li>
                    <li><a href="inscricoes.php" class="text-white hover:text-primary-200 px-3 py-2 block">Inscrições</a></li>
                    <li><a href="logout.php" class="text-white hover:text-primary-200 px-3 py-2 block">Sair</a></li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-6 flex-col sm:flex-row gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Gerenciamento de Equipes</h1>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <button onclick="openModal('criarEquipeModal')" class="btn-primary text-white px-6 py-3 rounded-lg text-base flex items-center justify-center flex-1 sm:flex-none transition-all duration-300 hover:scale-105">
                        <i class="fas fa-plus-circle mr-2"></i>Criar Equipe
                    </button>
                    <button onclick="openModal('entrarEquipeModal')" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg text-base flex items-center justify-center flex-1 sm:flex-none transition-all duration-300 hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i>Entrar em Equipe
                    </button>
                </div>
            </div>

            <?php if ($mensagem): ?>
                <div id="toast" class="toast fixed bottom-4 right-4 bg-<?php echo $tipoMensagem === 'success' ? 'green' : 'red'; ?>-600 text-white p-4 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <i class="fas fa-<?php echo $tipoMensagem === 'success' ? 'check-circle' : 'exclamation-circle'; ?> mr-2"></i>
                        <span><?php echo htmlspecialchars($mensagem); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- My Teams -->
           
            <?php if ($resultadoEquipes['success'] && !empty($resultadoEquipes['equipes'])): ?>
                <div class="space-y-4">
                    <?php foreach ($resultadoEquipes['equipes'] as $equipe): ?>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-primary-700"><?php echo htmlspecialchars($equipe['nome']); ?></h3>
                                <?php if ($equipe['is_lider']): ?>
                                    <span class="bg-primary-500 text-white text-xs px-2 py-1 rounded-full">Líder</span>
                                <?php endif; ?>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-gray-600"><strong>Modalidade:</strong> <?php echo htmlspecialchars($equipe['modalidade']); ?></p>
                                    <p class="text-gray-600"><strong>Categoria:</strong> <?php echo htmlspecialchars($equipe['categoria']); ?></p>
                                    <p class="text-gray-600"><strong>Código:</strong> <span class="font-mono"><?php echo htmlspecialchars($equipe['codigo_acesso']); ?></span></p>
                                </div>
                                <div>
                                    <p class="text-gray-600"><strong>Membros:</strong> <?php echo $equipe['total_membros']; ?> / <?php echo $equipe['limite_membros']; ?></p>
                                    <?php if (!$equipe['is_lider']): ?>
                                        <form method="POST" onsubmit="return confirm('Tem certeza que deseja sair desta equipe?');">
                                            <input type="hidden" name="acao" value="sair_equipe">
                                            <input type="hidden" name="equipe_id" value="<?php echo $equipe['id']; ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm flex items-center">
                                                <i class="fas fa-sign-out-alt mr-1"></i>Sair
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                            $resultadoMembros = $equipeModel->listarMembrosEquipe($equipe['id']);
                            $resultadoValor = $equipeModel->calcularValorInscricao($equipe['id']);
                            ?>
                            <div class="border-t pt-4">
                                <div class="flex mb-4">
                                    <button onclick="showTab('membros-<?php echo $equipe['id']; ?>', this)" class="px-4 py-2 text-sm font-medium text-primary-700 border-b-2 border-primary-500">Membros</button>
                                    <button onclick="showTab('valores-<?php echo $equipe['id']; ?>', this)" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-primary-700 border-b-2 border-transparent hover:border-primary-200">Valores</button>
                                </div>
                                <div id="membros-<?php echo $equipe['id']; ?>" class="tab-content table-responsive">
                                    <?php if ($resultadoMembros['success']): ?>
                                        <div class="hidden md:block"> <!-- Tabela apenas para desktop -->
                                            <table class="min-w-full bg-white border rounded-md">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Nome</th>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Turma</th>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Modalidades</th>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Função</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($resultadoMembros['membros'] as $membro): ?>
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-4 py-2 text-sm"><?php echo htmlspecialchars($membro['nome']); ?></td>
                                                            <td class="px-4 py-2 text-sm"><?php echo htmlspecialchars($membro['ano'] . 'º ' . $membro['turma']); ?></td>
                                                            <td class="px-4 py-2 text-sm"><?php echo $membro['total_modalidades']; ?></td>
                                                            <td class="px-4 py-2 text-sm">
                                                                <span class="px-2 py-1 text-xs rounded-full <?php echo $membro['is_lider'] ? 'bg-primary-100 text-primary-800' : 'bg-gray-100 text-gray-800'; ?>">
                                                                    <?php echo $membro['is_lider'] ? 'Líder' : 'Membro'; ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Cards para mobile -->
                                        <div class="md:hidden space-y-3">
                                            <?php foreach ($resultadoMembros['membros'] as $membro): ?>
                                                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div>
                                                            <h4 class="font-medium text-gray-800"><?php echo htmlspecialchars($membro['nome']); ?></h4>
                                                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($membro['ano'] . 'º ' . $membro['turma']); ?></p>
                                                        </div>
                                                        <span class="px-2 py-1 text-xs rounded-full <?php echo $membro['is_lider'] ? 'bg-primary-100 text-primary-800' : 'bg-gray-100 text-gray-800'; ?>">
                                                            <?php echo $membro['is_lider'] ? 'Líder' : 'Membro'; ?>
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                                        <i class="fas fa-trophy"></i>
                                                        <span>Modalidades: <?php echo $membro['total_modalidades']; ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-yellow-600"><?php echo htmlspecialchars($resultadoMembros['message']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div id="valores-<?php echo $equipe['id']; ?>" class="tab-content hidden">
                                    <?php if ($resultadoValor['success']): ?>
                                        <div class="mt-4">
                                            <!-- Tabela de valores para desktop -->
                                            <div class="hidden md:block">
                                                <table class="min-w-full bg-white border rounded-md">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Nome</th>
                                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Modalidades</th>
                                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Valor por Modalidade</th>
                                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Valor Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($resultadoValor['detalhes'] as $detalhe): ?>
                                                            <tr class="hover:bg-gray-50">
                                                                <td class="px-4 py-2 text-sm"><?php echo htmlspecialchars($detalhe['nome']); ?></td>
                                                                <td class="px-4 py-2 text-sm"><?php echo $detalhe['total_modalidades']; ?></td>
                                                                <td class="px-4 py-2 text-sm">R$ <?php echo number_format($detalhe['valor_modalidade'], 2, ',', '.'); ?></td>
                                                                <td class="px-4 py-2 text-sm">R$ <?php echo number_format($detalhe['valor_total'], 2, ',', '.'); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="bg-primary-50">
                                                            <td colspan="3" class="px-4 py-2 text-right font-medium text-primary-800">Total:</td>
                                                            <td class="px-4 py-2 font-bold text-primary-800">R$ <?php echo number_format($resultadoValor['valor_total'], 2, ',', '.'); ?></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                            <!-- Cards de valores para mobile -->
                                            <div class="md:hidden space-y-3">
                                                <?php foreach ($resultadoValor['detalhes'] as $detalhe): ?>
                                                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                                                        <div class="flex justify-between items-start mb-3">
                                                            <h4 class="font-medium text-gray-800"><?php echo htmlspecialchars($detalhe['nome']); ?></h4>
                                                            <span class="font-bold text-primary-700">
                                                                R$ <?php echo number_format($detalhe['valor_total'], 2, ',', '.'); ?>
                                                            </span>
                                                        </div>
                                                        <div class="space-y-2 text-sm">
                                                            <div class="flex justify-between text-gray-600">
                                                                <span>Modalidades:</span>
                                                                <span><?php echo $detalhe['total_modalidades']; ?></span>
                                                            </div>
                                                            <div class="flex justify-between text-gray-600">
                                                                <span>Valor por modalidade:</span>
                                                                <span>R$ <?php echo number_format($detalhe['valor_modalidade'], 2, ',', '.'); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>

                                                <!-- Total geral para mobile -->
                                                <div class="bg-primary-50 rounded-lg p-4 flex justify-between items-center">
                                                    <span class="font-medium text-primary-800">Total Geral:</span>
                                                    <span class="font-bold text-lg text-primary-800">
                                                        R$ <?php echo number_format($resultadoValor['valor_total'], 2, ',', '.'); ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <?php if (!$resultadoValor['atingiu_minimo']): ?>
                                                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                                                    <div class="flex items-center text-yellow-700">
                                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                                        <p>
                                                            <?php if ($equipe['modalidade'] === 'x2'): ?>
                                                                Sua equipe precisa ter exatamente 3 membros para gerar o pagamento.
                                                            <?php else: ?>
                                                                Sua equipe precisa de pelo menos <?php echo $resultadoValor['minimo_necessario']; ?> membros para gerar o pagamento.
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                    <p class="mt-2 text-sm text-yellow-600">
                                                        Atualmente: <?php echo $resultadoValor['total_membros']; ?>/<?php echo $resultadoValor['minimo_necessario']; ?> membros
                                                    </p>
                                                </div>
                                            <?php else: ?>
                                                <div class="mt-4">
                                                    <button onclick="abrirModalPagamento(<?php echo htmlspecialchars(json_encode($resultadoValor['pix_info'])); ?>, '<?php echo $equipe['nome']; ?>', <?php echo $resultadoValor['valor_total']; ?>)" 
                                                            class="w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-3 rounded-md flex items-center justify-center">
                                                        <i class="fas fa-money-bill-wave mr-2"></i>
                                                        Realizar Pagamento
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <p class="text-yellow-600"><?php echo htmlspecialchars($resultadoValor['message']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($resultadoEquipes['success'] && empty($resultadoEquipes['equipes'])): ?>
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="py-8">
                        <i class="fas fa-users text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Você ainda não está em nenhuma equipe</h3>
                        <p class="text-gray-500 mb-6">Crie uma nova equipe ou entre em uma equipe existente usando um código de acesso.</p>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <button onclick="openModal('criarEquipeModal')" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg flex items-center justify-center">
                                <i class="fas fa-plus-circle mr-2"></i>Criar Equipe
                            </button>
                            <button onclick="openModal('entrarEquipeModal')" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg flex items-center justify-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>Entrar em Equipe
                            </button>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-red-100 text-red-700 p-6 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle text-xl mr-3"></i>
                        <h3 class="font-semibold text-lg">Não foi possível carregar suas equipes</h3>
                    </div>
                    <div class="mb-4">
                        <p class="mb-2">Erro: <?php echo htmlspecialchars($resultadoEquipes['message'] ?? 'Erro desconhecido'); ?></p>
                        <p>Este problema pode ser temporário. Você pode tentar as seguintes ações:</p>
                        <ul class="list-disc list-inside ml-2 mt-2 space-y-1">
                            <li>Recarregar a página</li>
                            <li>Verificar sua conexão com a internet</li>
                            <li>Tentar criar uma nova equipe abaixo</li>
                            <li>Contatar o suporte se o problema persistir</li>
                        </ul>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="location.reload()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md flex items-center justify-center">
                            <i class="fas fa-sync-alt mr-2"></i>Recarregar Página
                        </button>
                        <button onclick="openModal('criarEquipeModal')" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md flex items-center justify-center">
                            <i class="fas fa-plus-circle mr-2"></i>Criar Equipe
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </main>

        <!-- Footer -->
       

        <!-- Create Team Modal -->
        <div id="criarEquipeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden modal modal-hidden">
            <div class="bg-white rounded-lg w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-primary-700">Criar Nova Equipe</h3>
                    <button onclick="closeModal('criarEquipeModal')" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="criarEquipeForm" method="POST">
                    <input type="hidden" name="acao" value="criar_equipe">
                    <div class="mb-4">
                        <label for="nome" class="block text-sm font-medium text-gray-700">Nome da Equipe</label>
                        <input type="text" id="nome" name="nome" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Digite o nome">
                    </div>
                    <div class="mb-4">
                        <label for="modalidade" class="block text-sm font-medium text-gray-700">Modalidade</label>
                        <select id="modalidade" name="modalidade" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Selecione...</option>
                            <option value="futsal">Futsal (Até 9 membros)</option>
                            <option value="volei">Vôlei (Até 6 membros)</option>
                            <option value="basquete">Basquete (Até 5 membros)</option>
                            <option value="handebol">Handebol (Até 7 membros)</option>
                            <option value="queimada">Queimada (Até 8 membros)</option>
                            <option value="futmesa">Futmesa (Até 2 membros)</option>
                            <option value="teqball">Teqball (Até 2 membros)</option>
                            <option value="teqvolei">Teqvôlei (Até 2 membros)</option>
                            <option value="beach_tenis">Beach Tennis (Até 2 membros)</option>
                            <option value="volei_de_praia">Vôlei de Praia (Até 2 membros)</option>
                            <option value="tenis_de_mesa">Tênis de Mesa (Até 1 membro)</option>
                            <option value="dama">Dama (Até 1 membro)</option>
                            <option value="xadrez">Xadrez (Até 1 membro)</option>
                            <option value="x2">X2 (Até 3 membros)</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="categoria" class="block text-sm font-medium text-gray-700">Categoria</label>
                        <select id="categoria" name="categoria" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Selecione...</option>
                            <option value="masculino">Masculino</option>
                            <option value="feminino">Feminino</option>
                            <option value="misto">Misto</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('criarEquipeModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">Cancelar</button>
                        <button type="submit" class="btn-primary px-4 py-2 text-white rounded-md">Criar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Join Team Modal -->
        <div id="entrarEquipeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden modal modal-hidden">
            <div class="bg-white rounded-lg w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-primary-700">Entrar em Equipe</h3>
                    <button onclick="closeModal('entrarEquipeModal')" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="entrarEquipeForm" method="POST">
                    <input type="hidden" name="acao" value="entrar_equipe">
                    <div class="mb-4">
                        <label for="codigo" class="block text-sm font-medium text-gray-700">Código de Acesso</label>
                        <input type="text" id="codigo" name="codigo" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Digite o código de 6 caracteres">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('entrarEquipeModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">Cancelar</button>
                        <button type="submit" class="btn-primary px-4 py-2 text-white rounded-md">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Pagamento -->
    <div id="modalPagamento" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden modal modal-hidden">
        <div class="bg-white rounded-lg w-full max-w-sm mx-4 p-4">
            <div class="flex justify-between items-center mb-3 sticky top-0 bg-white">
                <h3 class="text-lg font-bold text-primary-700">Pagamento</h3>
                <button onclick="fecharModalPagamento()" class="text-gray-600 hover:text-gray-800 p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="space-y-4">
                <!-- Resumo da Equipe -->
                <div class="bg-gray-50 p-3 rounded-lg">
                    <div class="space-y-1">
                        <p class="text-center font-medium"><span id="modalNomeEquipe" class="text-primary-700"></span></p>
                        <p class="text-center text-xl font-bold text-primary-800">R$ <span id="modalValorTotal"></span></p>
                    </div>
                </div>

                <!-- Chave PIX -->
                <div class="bg-white border rounded-lg p-3">
                    <div class="space-y-2">
                        <span class="text-sm text-gray-700">Chave PIX:</span>
                        <div class="flex items-center gap-2">
                            <span id="modalChavePix" class="font-mono bg-gray-50 px-3 py-2 rounded border text-sm flex-1 overflow-x-auto whitespace-nowrap"><?php echo PIX_CHAVE; ?></span>
                            <button onclick="copiarPix(document.getElementById('modalChavePix').textContent)" 
                                    class="bg-primary-600 hover:bg-primary-700 text-white p-2 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-105">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">
                            <i class="fas fa-user mr-1"></i> <?php echo PIX_NOME; ?>
                        </p>
                    </div>
                </div>

                <!-- Instruções -->
                <div class="bg-primary-50 p-3 rounded-lg">
                    <h4 class="font-medium text-primary-800 mb-2 text-sm">Como pagar:</h4>
                    <ol class="list-decimal list-inside space-y-1 text-primary-700 text-sm">
                        <li>Copie a chave PIX</li>
                        <li>Abra seu app do banco</li>
                        <li>Faça a transferência</li>
                        <li>Salve o comprovante</li>
                        <li>Envie pelo WhatsApp</li>
                    </ol>
                </div>

                <!-- Botão do WhatsApp -->
                <button id="btnWhatsApp" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg flex items-center justify-center font-medium transition-all duration-300 hover:scale-105">
                    <i class="fab fa-whatsapp mr-2"></i>
                    Enviar Comprovante
                </button>
            </div>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Modal Functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden', 'modal-hidden');
            setTimeout(() => modal.classList.remove('modal-hidden'), 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('modal-hidden');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        // Tab Functions
        function showTab(tabId, buttonEl) {
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(tab => tab.classList.add('hidden'));
            document.getElementById(tabId).classList.remove('hidden');

            const tabButtons = buttonEl.parentElement.querySelectorAll('button');
            tabButtons.forEach(button => {
                button.classList.remove('text-primary-700', 'border-primary-500');
                button.classList.add('text-gray-500', 'border-transparent');
            });
            buttonEl.classList.add('text-primary-700', 'border-primary-500');
        }

        // Auto-dismiss Toast
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        function copiarPix(chave) {
            navigator.clipboard.writeText(chave)
                .then(() => {
                    // Criar elemento de confirmação de cópia
                    const confirmacao = document.createElement('div');
                    confirmacao.className = 'fixed bottom-4 right-4 bg-green-600 text-white py-2 px-4 rounded-lg shadow-lg flex items-center z-50';
                    confirmacao.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Chave PIX copiada com sucesso!';
                    confirmacao.style.transition = 'opacity 0.5s ease';
                    document.body.appendChild(confirmacao);
                    
                    // Remover após 2 segundos
                    setTimeout(() => {
                        confirmacao.classList.add('opacity-0');
                        setTimeout(() => confirmacao.remove(), 500);
                    }, 2000);
                })
                .catch(() => {
                    alert('Erro ao copiar chave PIX. Por favor, copie manualmente.');
                });
        }

        function enviarComprovante(identificador, valor, nomeEquipe) {
            const mensagem = `Olá! Segue o comprovante de pagamento:\n\n` +
                            `*Equipe:* ${nomeEquipe}\n` +
                            `*Valor:* R$ ${valor}`;
            
            const numeroWhatsapp = '<?php echo WHATSAPP_NUMERO; ?>';
            const url = `https://wa.me/${numeroWhatsapp}?text=${encodeURIComponent(mensagem)}`;
            window.open(url, '_blank');
        }

        function abrirModalPagamento(pixInfo, nomeEquipe, valorTotal) {
            const modal = document.getElementById('modalPagamento');
            
            // Preencher informações no modal
            document.getElementById('modalNomeEquipe').textContent = nomeEquipe;
            document.getElementById('modalValorTotal').textContent = valorTotal.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
            document.getElementById('modalChavePix').textContent = pixInfo.chave;

            // Configurar botão do WhatsApp
            document.getElementById('btnWhatsApp').onclick = () => enviarComprovante(
                pixInfo.identificador,
                valorTotal.toLocaleString('pt-BR', { minimumFractionDigits: 2 }),
                nomeEquipe
            );

            // Exibir modal
            modal.classList.remove('hidden', 'modal-hidden');
            setTimeout(() => modal.classList.remove('modal-hidden'), 10);
        }

        function fecharModalPagamento() {
            const modal = document.getElementById('modalPagamento');
            modal.classList.add('modal-hidden');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        // Fechar modal ao clicar fora
        document.getElementById('modalPagamento').addEventListener('click', function(e) {
            if (e.target === this) {
                fecharModalPagamento();
            }
        });

        // Ajustar tabelas em dispositivos móveis
        document.addEventListener('DOMContentLoaded', function() {
            const tabelasResponsivas = document.querySelectorAll('.table-responsive');
            
            tabelasResponsivas.forEach(tabela => {
                // Remover altura máxima fixa
                tabela.style.maxHeight = 'none';
                
                // Adicionar indicador de scroll apenas se necessário
                if (tabela.scrollWidth > tabela.clientWidth) {
                    const scrollHint = document.createElement('div');
                    scrollHint.className = 'text-xs text-gray-500 text-center mt-2 mb-1 animate-pulse';
                    scrollHint.innerHTML = '<i class="fas fa-arrows-left-right mr-1"></i> Deslize para ver mais informações';
                    tabela.parentNode.insertBefore(scrollHint, tabela.nextSibling);
                }
                
                // Adicionar eventos de scroll para mostrar/ocultar gradiente
                tabela.addEventListener('scroll', function() {
                    const isAtEnd = this.scrollLeft + this.clientWidth >= this.scrollWidth;
                    this.style.setProperty('--gradient-opacity', isAtEnd ? '0' : '1');
                });
            });
        });
    </script>
</body>
</html>