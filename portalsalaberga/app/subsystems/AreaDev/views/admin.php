<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Demanda.php';
require_once __DIR__ . '/../model/Usuario.php';

session_start();

// Inicializa a conexão com o banco de dados
$database = new Database();
$pdo = $database->getConnection();

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
            $sucesso = $demanda->criarDemanda($titulo, $descricao, $prioridade, $_SESSION['usuario_id'], $usuario_id);
            if ($sucesso) {
            header("Location: admin.php");
            exit();
            } else {
                $erro = "Erro ao criar demanda. Por favor, tente novamente.";
            }
        }
    } elseif ($_POST['acao'] === 'excluir' && isset($_POST['id'])) {
        $demanda->excluirDemanda($_POST['id']);
        header("Location: admin.php");
        exit();
    } elseif ($_POST['acao'] === 'atualizar_status' && isset($_POST['id'])) {
        // Verifica se um novo status foi enviado e atualiza
        if (isset($_POST['novo_status'])) {
            $novo_status = $_POST['novo_status'];
            $id_demanda = $_POST['id'];
            // Adicione lógica para validar o novo status, se necessário
            
            if ($novo_status === 'concluida') {
                 $demanda->marcarConcluida($id_demanda);
            } elseif ($novo_status === 'em_andamento') {
                 $demanda->marcarEmAndamento($id_demanda);
            }
            // Adicione outras transições de status aqui, se houver
        }
        header("Location: admin.php");
        exit();
    }
}

$demandas = $demanda->listarDemandas();
$usuarios = $usuario->listarUsuarios();

// Calcular totais de demandas por status
$totalDemandas = count($demandas);
$demandasEmAndamento = 0;
$demandasConcluidas = 0;
$demandasPendentes = 0;

foreach ($demandas as $d) {
    if ($d['status'] === 'em_andamento') {
        $demandasEmAndamento++;
    } elseif ($d['status'] === 'concluida') {
        $demandasConcluidas++;
    } elseif ($d['status'] === 'pendente') {
        $demandasPendentes++;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Painel Administrativo - Sistema de Gestão de Demandas">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Painel Administrativo - Sistema de Gestão de Demandas</title>
</head>

<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: {
                        DEFAULT: '#007A33',
                        '50': '#00FF6B',
                        '100': '#00EB61',
                        '200': '#00C250',
                        '300': '#00993F',
                        '400': '#00802F',
                        '500': '#007A33',
                        '600': '#00661F',
                        '700': '#00521A',
                        '800': '#003D15',
                        '900': '#002910'
                    },
                    secondary: {
                        DEFAULT: '#FFA500',
                        '50': '#FFE9C0',
                        '100': '#FFE1AB',
                        '200': '#FFD183',
                        '300': '#FFC15A',
                        '400': '#FFB232',
                        '500': '#FFA500',
                        '600': '#C78000',
                        '700': '#8F5C00',
                        '800': '#573800',
                        '900': '#1F1400'
                    },
                    dark: {
                        DEFAULT: '#1a1a1a',
                        '50': '#2d2d2d',
                        '100': '#272727',
                        '200': '#232323',
                        '300': '#1f1f1f',
                        '400': '#1a1a1a',
                        '500': '#171717',
                        '600': '#141414',
                        '700': '#111111',
                        '800': '#0e0e0e',
                        '900': '#0a0a0a'
                    }
                },
                animation: {
                    'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    'bounce-gentle': 'bounce 2s infinite',
                    'fade-in': 'fadeIn 0.5s ease-out',
                    'slide-up': 'slideUp 0.6s ease-out',
                    'scale-in': 'scaleIn 0.3s ease-out',
                },
                boxShadow: {
                    'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.36)',
                    'card': '0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -4px rgba(0, 0, 0, 0.2)',
                    'card-hover': '0 20px 25px -5px rgba(0, 122, 51, 0.1), 0 10px 10px -5px rgba(0, 122, 51, 0.04)',
                }
            }
        }
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: #1a1a1a;
        color: #ffffff;
        min-height: 100vh;
        background-image:
            radial-gradient(circle at 10% 20%, rgba(0, 122, 51, 0.05) 0%, rgba(0, 122, 51, 0) 20%),
            radial-gradient(circle at 90% 80%, rgba(255, 165, 0, 0.05) 0%, rgba(255, 165, 0, 0) 20%),
            linear-gradient(135deg, rgba(0, 122, 51, 0.02) 0%, rgba(255, 165, 0, 0.02) 100%);
        transition: all 0.3s ease;
    }

    /* Cards Styles */
    .demand-card {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .demand-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #007A33, #00FF6B);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .demand-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 122, 51, 0.15);
        border-color: rgba(0, 255, 107, 0.3);
    }

    .demand-card:hover::before {
        transform: scaleX(1);
    }

    .stats-card {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 122, 51, 0.1);
    }

    .user-card {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 6px 24px rgba(0,0,0,0.15);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.3s ease;
    }

    .user-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 122, 51, 0.1);
        border-color: rgba(0, 255, 107, 0.2);
    }

    /* Button Styles */
    .custom-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.025em;
    }

    .custom-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .custom-btn:hover::before {
        transform: translateX(100%);
    }

    .custom-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .btn-icon {
        transition: all 0.3s ease;
    }

    .custom-btn:hover .btn-icon {
        transform: translateX(3px) scale(1.1);
    }

    /* Input Styles */
    .custom-input, .custom-select {
        background: rgba(35, 35, 35, 0.95);
        border: 2px solid rgba(0, 122, 51, 0.2);
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        color: #ffffff;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .custom-input:focus, .custom-select:focus {
        border-color: #00FF6B;
        box-shadow: 0 0 0 4px rgba(0, 255, 107, 0.1);
        outline: none;
        background: rgba(35, 35, 35, 1);
    }

    .custom-input::placeholder {
        color: #888888;
        font-weight: 400;
    }

    /* Search and Filter Styles */
    .search-container {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
    }

    .filter-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        border: 2px solid rgba(0, 122, 51, 0.3);
        background: rgba(35, 35, 35, 0.8);
        color: #ffffff;
        transition: all 0.3s ease;
        font-weight: 500;
        cursor: pointer;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #007A33, #00FF6B);
        border-color: #00FF6B;
        color: #000000;
        font-weight: 600;
    }

    .filter-btn:hover {
        border-color: #00FF6B;
        background: rgba(0, 122, 51, 0.1);
        transform: translateY(-2px);
    }

    /* Status Badges */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: capitalize;
    }

    .status-badge:hover {
        transform: scale(1.05);
    }

    .status-pendente {
        background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(234, 179, 8, 0.1));
        color: #fbbf24;
        border: 1px solid rgba(234, 179, 8, 0.3);
    }

    .status-em_andamento {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.1));
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .status-concluida {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-cancelada {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    /* Priority Badges */
    .priority-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        
        letter-spacing: 0.05em;
    }

    .priority-alta {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .priority-media {
        background: rgba(234, 179, 8, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(234, 179, 8, 0.3);
    }

    .priority-baixa {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    /* Modal Styles */
    .modal {
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        transition: all 0.3s ease;
    }

    .modal-content {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border: 1px solid rgba(0, 122, 51, 0.2);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        border-radius: 24px;
        backdrop-filter: blur(20px);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .slide-up {
        animation: slideUp 0.6s ease-out forwards;
    }

    .scale-in {
        animation: scaleIn 0.3s ease-out forwards;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #1a1a1a;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #007A33, #00FF6B);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #00FF6B, #007A33);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .demand-card {
            padding: 1rem;
            margin-bottom: 0.75rem;
        }
        
        .stats-card {
            padding: 1.5rem;
        }
        
        .search-container {
            padding: 1.5rem;
        }
    }

    /* Loading Animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(0, 122, 51, 0.3);
        border-radius: 50%;
        border-top-color: #00FF6B;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Completion Button */
    .complete-btn {
        background: linear-gradient(135deg, #007A33, #00FF6B);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .complete-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 122, 51, 0.3);
    }

    .complete-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #888888;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
</style>

<body class="select-none">
    <!-- Header -->
    <header class="bg-dark-200 shadow-lg border-b border-primary/20 sticky top-0 z-50 backdrop-blur-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-tasks text-white text-lg"></i>
                </div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-primary-50 to-primary-200 bg-clip-text text-transparent">
                    Painel Administrativo
                </h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-2 text-gray-300">
                    <i class="fas fa-user-shield text-primary-50"></i>
                    <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                </div>
                <a href="logout.php" class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2">
                    <i class="fas fa-sign-out-alt btn-icon"></i> 
                    <span class="hidden md:inline">Sair</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Stats Cards -->
        

        <?php if (!empty($erro)): ?>
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg mb-6 fade-in">
            <div class="flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($erro); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Search and Filters -->
        <div class="search-container slide-up" style="animation-delay: 0.5s">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="flex-1 w-full lg:max-w-md">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Buscar demandas..." 
                            class="custom-input w-full pl-12"
                            onkeyup="filterDemands()"
                        >
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <button class="filter-btn active" onclick="filterByStatus('all')" data-status="all">
                        <i class="fas fa-list mr-2"></i>Todas
                    </button>
                    <button class="filter-btn" onclick="filterByStatus('pendente')" data-status="pendente">
                        <i class="fas fa-clock mr-2"></i>Pendentes
                    </button>
                    <button class="filter-btn" onclick="filterByStatus('em_andamento')" data-status="em_andamento">
                        <i class="fas fa-spinner mr-2"></i>Em Andamento
                    </button>
                    <button class="filter-btn" onclick="filterByStatus('concluida')" data-status="concluida">
                        <i class="fas fa-check mr-2"></i>Concluídas
                    </button>
                </div>
                
                <button onclick="openModal('criarDemandaModal')" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2">
                    <i class="fas fa-plus btn-icon"></i> Nova Demanda
                </button>
            </div>
        </div>

        <!-- Demands Cards -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <i class="fas fa-tasks text-primary-50"></i>
                Gerenciar Demandas
            </h2>
            
            <div id="demandsContainer" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($demandas as $index => $d): ?>
                <div class="demand-card fade-in" 
                     style="animation-delay: <?php echo ($index * 0.1); ?>s"
                     data-status="<?php echo $d['status']; ?>"
                     data-title="<?php echo strtolower($d['titulo']); ?>"
                     data-description="<?php echo strtolower($d['descricao']); ?>">
                    
                    <!-- Card Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white mb-2 line-clamp-2">
                                <?php echo htmlspecialchars($d['titulo']); ?>
                            </h3>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="status-badge status-<?php echo $d['status']; ?>">
                                    <?php
                                    $statusIcons = [
                                        'pendente' => 'fas fa-clock',
                                        'em_andamento' => 'fas fa-spinner fa-spin',
                                        'concluida' => 'fas fa-check-circle',
                                        'cancelada' => 'fas fa-ban'
                                    ];
                                    $status_display = ucfirst(str_replace('_', ' ', $d['status'])); // Formatar para exibição
                                    ?>
                                    <i class="<?php echo $statusIcons[$d['status']] ?? 'fas fa-question'; ?>"></i>
                                    <?php echo $status_display; ?>
                                </span>
                                <span class="priority-badge priority-<?php echo $d['prioridade']; ?>">
                                    <?php echo ucfirst($d['prioridade']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-gray-400">ID: #<?php echo $d['id']; ?></span>
                        </div>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="mb-4">
                        <p class="text-gray-300 text-sm line-clamp-3 mb-3">
                            <?php echo htmlspecialchars($d['descricao']); ?>
                        </p>
                        
                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-gray-400">Criado em:</span>
                                <p class="text-white font-medium">
                                    <?php echo date('d/m/Y', strtotime($d['data_criacao'])); ?>
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-400">
                                    <?php echo !empty($d['data_conclusao']) ? 'Concluído em:' : 'Prazo:'; ?>
                                </span>
                                <p class="text-white font-medium">
                                    <?php 
                                    if (!empty($d['data_conclusao'])) {
                                        echo date('d/m/Y', strtotime($d['data_conclusao']));
                                    } else {
                                        echo 'Não definido';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                            </div>
                    
                    <!-- Card Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                        <div class="flex items-center gap-2">
                            <?php if ($d['admin_id'] == $_SESSION['usuario_id']): ?>
                            
                            <button 
                                onclick="editarDemanda(<?php echo $d['id']; ?>)" 
                                class="custom-btn bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg"
                                title="Editar demanda">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button 
                                onclick="excluirDemanda(<?php echo $d['id']; ?>)" 
                                class="custom-btn bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg"
                                title="Excluir demanda">
                                <i class="fas fa-trash"></i>
                            </button>

                            <?php if ($d['status'] === 'pendente' && (is_null($d['usuario_id']) || $d['usuario_id'] == 0 || $d['usuario_id'] == '' || $d['usuario_id'] == $_SESSION['usuario_id']) && $d['admin_id'] == $_SESSION['usuario_id']): ?>
                            <form method="POST" action="../controllers/DemandaController.php" class="inline" onsubmit="return confirmarEmAndamento()">
                                <input type="hidden" name="acao" value="atualizar_status">
                                <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                <input type="hidden" name="novo_status" value="em_andamento">
                                <button type="submit" class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white p-2 rounded-lg" title="Marcar como Em Andamento">
                                    <i class="fas fa-spinner"></i>
                                    Realizar Tarefa
                                </button>
                            </form>
                            <?php endif; ?>

                            <?php if ($d['status'] === 'em_andamento' && (is_null($d['usuario_id']) || $d['usuario_id'] == 0 || $d['usuario_id'] == '' || $d['usuario_id'] == $_SESSION['usuario_id']) && $d['admin_id'] == $_SESSION['usuario_id']): ?>
                            <form method="POST" action="../controllers/DemandaController.php" class="inline" onsubmit="return confirmarConclusao()">
                                <input type="hidden" name="acao" value="atualizar_status">
                                <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                <input type="hidden" name="novo_status" value="concluida">
                                <button type="submit" class="custom-btn bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg" title="Marcar como Concluída">
                                    <i class="fas fa-check"></i>
                                    Concluir
                                </button>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="text-xs text-gray-400">
                            <i class="fas fa-user mr-1"></i>
                            <?php echo !empty($d['usuario_nome']) ? htmlspecialchars($d['usuario_nome']) : 'Não atribuído'; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="empty-state hidden">
                <i class="fas fa-search"></i>
                <h3 class="text-xl font-semibold mb-2">Nenhuma demanda encontrada</h3>
                <p>Tente ajustar os filtros ou criar uma nova demanda.</p>
            </div>
        </div>

        <!-- User Management Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-users text-primary-50"></i>
                    Gerenciar Usuários
                </h2>
                <button onclick="openModal('criarUsuarioModal')" class="custom-btn bg-gradient-to-r from-secondary-500 to-secondary-400 hover:from-secondary-400 hover:to-secondary-300 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2">
                    <i class="fas fa-user-plus btn-icon"></i> Novo Usuário
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($usuarios as $index => $user): ?>
                <div class="user-card fade-in" style="animation-delay: <?php echo ($index * 0.1); ?>s">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white">
                                <?php echo htmlspecialchars($user['nome']); ?>
                            </h3>
                            <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user['email']); ?></p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full <?php echo $user['tipo'] === 'admin' ? 'bg-red-500/20 text-red-400' : 'bg-blue-500/20 text-blue-400'; ?>">
                                <?php echo ucfirst($user['tipo']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Create Demand Modal -->
    <div id="criarDemandaModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-md p-6 scale-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Nova Demanda</h3>
                <button onclick="closeModal('criarDemandaModal')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="../controllers/DemandaController.php" method="POST" class="space-y-4">
                            <input type="hidden" name="acao" value="criar">
                            <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-300 mb-2">Título</label>
                    <input type="text" id="titulo" name="titulo" required class="custom-input w-full">
                            </div>
                            <div>
                    <label for="descricao" class="block text-sm font-medium text-gray-300 mb-2">Descrição</label>
                    <textarea id="descricao" name="descricao" required class="custom-input w-full" rows="4"></textarea>
                            </div>
                            <div>
                    <label for="prioridade" class="block text-sm font-medium text-gray-300 mb-2">Prioridade</label>
                    <select id="prioridade" name="prioridade" required class="custom-select w-full">
                        <option value="alta">Alta</option>
                        <option value="media" selected>Média</option>
                                    <option value="baixa">Baixa</option>
                                </select>
                            </div>
                            <div>
                    <label for="usuario_id" class="block text-sm font-medium text-gray-300 mb-2">Atribuir a</label>
                    <select id="usuario_id" name="usuario_id" class="custom-select w-full">
                        <option value="">Não atribuído</option>
                                    <?php foreach ($usuarios as $u): ?>
                                    <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['nome']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeModal('criarDemandaModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                                    Cancelar
                                </button>
                    <button type="submit" name="criar" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-2 px-4 rounded-lg">
                        Criar Demanda
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

    <!-- Create User Modal -->
    <div id="criarUsuarioModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-md p-6 scale-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Novo Usuário</h3>
                <button onclick="closeModal('criarUsuarioModal')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="../controllers/UsuarioController.php" method="POST" class="space-y-4">
                <input type="hidden" name="acao" value="criar_usuario">
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-300 mb-2">Nome</label>
                    <input type="text" id="nome" name="nome" required class="custom-input w-full">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" id="email" name="email" required class="custom-input w-full">
                </div>
                <div>
                    <label for="senha" class="block text-sm font-medium text-gray-300 mb-2">Senha</label>
                    <input type="password" id="senha" name="senha" required class="custom-input w-full">
                                </div>
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-300 mb-2">Tipo de Usuário</label>
                    <select id="tipo" name="tipo" required class="custom-select w-full">
                        <option value="usuario">Usuário Comum</option>
                        <option value="admin">Administrador</option>
                    </select>
                                </div>
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeModal('criarUsuarioModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Cancelar
                                    </button>
                    <button type="submit" name="criar_usuario" class="custom-btn bg-gradient-to-r from-secondary-500 to-secondary-400 hover:from-secondary-400 hover:to-secondary-300 text-white font-bold py-2 px-4 rounded-lg">
                        Criar Usuário
                                    </button>
                </div>
                                </form>
        </div>
    </div>

    <!-- Edit Demand Modal -->
    <div id="editarDemandaModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-md p-6 scale-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Editar Demanda</h3>
                <button onclick="closeModal('editarDemandaModal')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="../controllers/DemandaController.php" method="POST" class="space-y-4">
                <input type="hidden" name="acao" value="atualizar_demanda">
                <input type="hidden" name="id" id="editar_demanda_id">
                <div>
                    <label for="editar_titulo" class="block text-sm font-medium text-gray-300 mb-2">Título</label>
                    <input type="text" id="editar_titulo" name="titulo" required class="custom-input w-full">
                </div>
                <div>
                    <label for="editar_descricao" class="block text-sm font-medium text-gray-300 mb-2">Descrição</label>
                    <textarea id="editar_descricao" name="descricao" required class="custom-input w-full" rows="4"></textarea>
                </div>
                <div>
                    <label for="editar_prioridade" class="block text-sm font-medium text-gray-300 mb-2">Prioridade</label>
                    <select id="editar_prioridade" name="prioridade" required class="custom-select w-full">
                        <option value="alta">Alta</option>
                        <option value="media">Média</option>
                        <option value="baixa">Baixa</option>
                    </select>
                </div>
                <div>
                    <label for="editar_status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select id="editar_status" name="status" required class="custom-select w-full">
                        <option value="pendente">Pendente</option>
                        <option value="em_andamento">Em Andamento</option>
                        <option value="concluida">Concluída</option>
                        
                    </select>
                </div>
                <div>
                    <label for="editar_usuario_id" class="block text-sm font-medium text-gray-300 mb-2">Atribuir a</label>
                    <select id="editar_usuario_id" name="usuario_id" class="custom-select w-full">
                        <option value="">Não atribuído</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['nome']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeModal('editarDemandaModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" name="atualizar_demanda" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-2 px-4 rounded-lg">
                        Atualizar Demanda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Demand Modal -->
    <div id="excluirDemandaModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-sm p-6 scale-in text-center">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Confirmar Exclusão</h3>
                <button onclick="closeModal('excluirDemandaModal')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <p class="text-gray-300 mb-6">Tem certeza que deseja excluir esta demanda? Esta ação não pode ser desfeita.</p>
            <input type="hidden" id="demanda_a_excluir_id">
            <div class="flex justify-center gap-4">
                <button type="button" onclick="closeModal('excluirDemandaModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                    Cancelar
                </button>
                <button type="button" onclick="confirmarExclusao()" class="custom-btn bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                    Excluir
                </button>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Filter Functions
        function filterByStatus(status) {
            const cards = document.querySelectorAll('.demand-card');
            const buttons = document.querySelectorAll('.filter-btn');
            const emptyState = document.getElementById('emptyState');
            let visibleCards = 0;

            // Update active button
            buttons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.status === status) {
                    btn.classList.add('active');
                }
            });

            // Filter cards
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                    visibleCards++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide empty state
            if (visibleCards === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        function filterDemands() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.demand-card');
            const emptyState = document.getElementById('emptyState');
            let visibleCards = 0;

            cards.forEach(card => {
                const title = card.dataset.title;
                const description = card.dataset.description;
                const isVisible = title.includes(searchTerm) || description.includes(searchTerm);
                
                if (isVisible) {
                    card.style.display = 'block';
                    visibleCards++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide empty state
            if (visibleCards === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        // Edit Demand Function
        function editarDemanda(id) {
            
            
            // Limpar dados anteriores
            document.getElementById('editar_demanda_id').value = '';
            document.getElementById('editar_titulo').value = '';
            document.getElementById('editar_descricao').value = '';
            document.getElementById('editar_prioridade').value = 'media';
            document.getElementById('editar_status').value = 'pendente';
            document.getElementById('editar_usuario_id').value = '';

            fetch(`../controllers/DemandaController.php?action=get_demanda&id=${id}`)
                .then(response => {
                    
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new TypeError("Resposta não é JSON! Content-Type: " + contentType);
                    }
                    
                    return response.text().then(text => {
                        
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('Erro ao fazer parse do JSON:', e);
                            throw new Error('Resposta inválida do servidor');
                        }
                    });
                })
                .then(data => {
                    
                    if (data.error) {
                        console.error('Erro ao buscar dados da demanda:', data.error);
                        alert('Erro ao carregar dados da demanda: ' + data.error);
                        return;
                    }
                    
                    if (!data.id || !data.titulo || !data.descricao) {
                        console.error('Dados incompletos recebidos:', data);
                        alert('Dados incompletos recebidos do servidor');
                        return;
                    }
                    
                    document.getElementById('editar_demanda_id').value = data.id;
                    document.getElementById('editar_titulo').value = data.titulo;
                    document.getElementById('editar_descricao').value = data.descricao;
                    document.getElementById('editar_prioridade').value = data.prioridade || 'media';
                    document.getElementById('editar_status').value = data.status || 'pendente';
                    document.getElementById('editar_usuario_id').value = data.usuario_id || '';
                    
                    openModal('editarDemandaModal');
                })
                .catch(error => {
                    console.error('Erro na requisição AJAX:', error);
                    alert('Erro ao carregar dados da demanda: ' + error.message);
                });
        }

        // Delete Demand Function
        function excluirDemanda(id) {
            document.getElementById('demanda_a_excluir_id').value = id;
            openModal('excluirDemandaModal');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.add('hidden');
                event.target.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const openModals = document.querySelectorAll('.modal:not(.hidden)');
                openModals.forEach(modal => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });
                document.body.style.overflow = 'auto';
            }
        });

        // Add loading states to buttons
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<div class="loading"></div> Processando...';
                    submitBtn.disabled = true;
                }
            });
        });

        // Initialize tooltips and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to cards
            document.querySelectorAll('.demand-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add click animation to buttons
            document.querySelectorAll('.custom-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });

        function confirmarEmAndamento() {
            return confirm('Tem certeza que deseja marcar esta demanda como Em Andamento?');
        }

        function confirmarConclusao() {
            return confirm('Tem certeza que deseja marcar esta demanda como Concluída?');
        }

        function confirmarExclusao() {
            const id = document.getElementById('demanda_a_excluir_id').value;
            window.location.href = `../controllers/DemandaController.php?action=excluir&id=${id}`;
        }
    </script>
</body>
</html> 