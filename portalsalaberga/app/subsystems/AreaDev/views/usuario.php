<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Demanda.php';

session_start();

// Inicializa a conexão com o banco de dados
$database = new Database();
$pdo = $database->getConnection();

// Verificar se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$demanda = new Demanda($pdo);

// Processar atualização de status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'atualizar_status' && isset($_POST['id'])) {
    if (isset($_POST['novo_status'])) {
        $novo_status = $_POST['novo_status'];
        if ($novo_status === 'em_andamento') {
            $demanda->marcarEmAndamento($_POST['id']);
        } elseif ($novo_status === 'concluida') {
            $demanda->marcarConcluida($_POST['id']);
        }
    }
    header("Location: usuario.php");
    exit();
}

$demandas = $demanda->listarDemandasPorUsuario($_SESSION['usuario_id']);

// Calcular estatísticas
$totalDemandas = count($demandas);
$demandasPendentes = 0;
$demandasEmAndamento = 0;
$demandasConcluidas = 0;

foreach ($demandas as $d) {
    switch ($d['status']) {
        case 'Pendente':
            $demandasPendentes++;
            break;
        case 'Em Andamento':
            $demandasEmAndamento++;
            break;
        case 'Concluída':
            $demandasConcluidas++;
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Painel do Usuário - Sistema de Gestão de Demandas">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Painel do Usuário - Sistema de Gestão de Demandas</title>
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
                    'float': 'float 3s ease-in-out infinite',
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
        padding: 1.75rem;
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
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 122, 51, 0.15);
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

    /* Search and Filter Styles */
    .search-container {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
    }

    .custom-input {
        background: rgba(35, 35, 35, 0.95);
        border: 2px solid rgba(0, 122, 51, 0.2);
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        color: #ffffff;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .custom-input:focus {
        border-color: #00FF6B;
        box-shadow: 0 0 0 4px rgba(0, 255, 107, 0.1);
        outline: none;
        background: rgba(35, 35, 35, 1);
    }

    .custom-input::placeholder {
        color: #888888;
        font-weight: 400;
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
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.2rem 0.5rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .status-badge i {
         font-size: 0.875rem;
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

    .status-concluida i {
        color: #4ade80;
    }

    .status-concluido { /* Para status de participante */
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-concluido i { /* Para status de participante */
        color: #4ade80;
    }

    .status-cancelada {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    /* Priority Badges */
    .priority-badge {
        padding: 0.2rem 0.5rem;
        border-radius: 15px;
        font-size: 0.7rem;
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
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(12px);
        transition: all 0.3s ease;
    }

    .modal-content {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border: 1px solid rgba(0, 122, 51, 0.2);
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
        border-radius: 24px;
        backdrop-filter: blur(20px);
        max-height: 90vh;
        overflow-y: auto;
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

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
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

    .float {
        animation: float 3s ease-in-out infinite;
    }

    /* Progress Bar */
    .progress-bar {
        width: 100%;
        height: 6px;
        background: rgba(0, 122, 51, 0.1);
        border-radius: 3px;
        overflow: hidden;
        margin: 1rem 0;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #007A33, #00FF6B);
        border-radius: 3px;
        transition: width 0.3s ease;
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

    /* Responsive */
    @media (max-width: 768px) {
        .demand-card {
            padding: 1.25rem;
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

    /* Select Styles */
    .custom-select {
        background: rgba(35, 35, 35, 0.95);
        border: 2px solid rgba(0, 122, 51, 0.2);
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        color: #ffffff;
        transition: all 0.3s ease;
        font-weight: 500;
        min-width: 200px;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .custom-select:focus {
        border-color: #00FF6B;
        box-shadow: 0 0 0 4px rgba(0, 255, 107, 0.1);
        outline: none;
        background: rgba(35, 35, 35, 1);
    }

    .custom-select option {
        background: #232323;
        color: #ffffff;
        padding: 1rem;
    }

    .custom-select:hover {
        border-color: rgba(0, 122, 51, 0.4);
    }

    .select-wrapper {
        position: relative;
        display: inline-block;
    }

    .select-wrapper::after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #888888;
        pointer-events: none;
    }
</style>

<body class="select-none">
    <!-- Header -->
    <header class="bg-dark-200 shadow-lg border-b border-primary/20 sticky top-0 z-40 backdrop-blur-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-50 rounded-xl flex items-center justify-center float">
                    <i class="fas fa-user text-white text-lg"></i>
                </div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-primary-50 to-primary-200 bg-clip-text text-transparent">
                    Painel do Usuário
                </h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-2 text-gray-300">
                    <i class="fas fa-user-circle text-primary-50"></i>
                    <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                </div>
                <a href="logout.php" class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2">
                    <i class="fas fa-sign-out-alt btn-icon"></i> 
                    <span class="hidden md:inline">Sair</span>
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <!-- Stats Cards -->


        <!-- Search and Filters -->
        <div class="search-container slide-up" style="animation-delay: 0.6s">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="flex-1 w-full lg:max-w-md">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Buscar suas demandas..." 
                            class="custom-input w-full pl-12"
                            onkeyup="filterDemands()"
                        >
                    </div>
                </div>

                <div class="flex flex-wrap gap-4">
                    <div class="select-wrapper">
                        <select class="custom-select" onchange="filterByStatus(this.value)">
                            <option value="all">Todas as Demandas</option>
                            <option value="pendente">Pendentes</option>
                            <option value="em_andamento">Em Andamento</option>
                            <option value="concluida">Concluídas</option>
                        </select>
                    </div>

                    <div class="select-wrapper">
                        <select class="custom-select" onchange="filterByPriority(this.value)">
                            <option value="all">Todas Prioridades</option>
                            <option value="alta">Alta</option>
                            <option value="media">Média</option>
                            <option value="baixa">Baixa</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demands Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <i class="fas fa-clipboard-list text-primary-50"></i>
                Minhas Demandas
            </h2>
            
            <div id="demandsContainer" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($demandas as $index => $d): ?>
                <div class="demand-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300"
                    data-title="<?php echo htmlspecialchars($d['titulo']); ?>"
                    data-description="<?php echo htmlspecialchars($d['descricao']); ?>"
                    data-status="<?php echo $d['status']; ?>"
                    data-priority="<?php echo $d['prioridade']; ?>">
                    
                    <!-- Card Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white mb-2 line-clamp-2 cursor-pointer hover:text-primary-50 transition-colors duration-300"
                                onclick="mostrarDescricao('<?php echo htmlspecialchars($d['titulo']); ?>', '<?php echo htmlspecialchars($d['descricao']); ?>', '<?php echo $d['status']; ?>', '<?php echo date('d/m/Y H:i', strtotime($d['data_criacao'])); ?>', '<?php echo !empty($d['data_conclusao']) ? date('d/m/Y H:i', strtotime($d['data_conclusao'])) : ''; ?>')">
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
                                <p class="text-gray-400">
                                    <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-400">
                                    <?php echo !empty($d['data_conclusao']) ? 'Concluído em:' : 'Status:'; ?>
                                </span>
                                <p class="text-white font-medium">
                                    <?php 
                                    if (!empty($d['data_conclusao'])) {
                                        echo date('d/m/Y', strtotime($d['data_conclusao']));
                                    } else {
                                        echo 'Em progresso';
                                    }
                                    ?>
                                </p>
                                <?php if (!empty($d['data_conclusao'])): ?>
                                <p class="text-gray-400">
                                    <?php echo date('H:i', strtotime($d['data_conclusao'])); ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                        <button 
                            onclick="mostrarDescricao('<?php echo htmlspecialchars($d['titulo']); ?>', '<?php echo htmlspecialchars($d['descricao']); ?>', '<?php echo $d['status']; ?>', '<?php echo date('d/m/Y H:i', strtotime($d['data_criacao'])); ?>', '<?php echo !empty($d['data_conclusao']) ? date('d/m/Y H:i', strtotime($d['data_conclusao'])) : ''; ?>')"
                            class="custom-btn bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg"
                            title="Ver detalhes">
                            <i class="fas fa-eye"></i>
                        </button>

                        <?php 
                        $usuario_logado_atribuido = false;
                        $status_usuario = null;
                        if (!empty($d['usuarios_atribuidos'])) {
                            foreach ($d['usuarios_atribuidos'] as $u_atrib) {
                                if ($u_atrib['id'] == $_SESSION['usuario_id']) {
                                    $usuario_logado_atribuido = true;
                                    $status_usuario = $u_atrib['status'];
                                    break;
                                }
                            }
                        }
                        ?>

                        <?php if ($usuario_logado_atribuido): ?>
                            <?php if ($status_usuario === 'pendente'): ?>
                                <form method="POST" action="../controllers/DemandaController.php" class="inline" onsubmit="return confirmarEmAndamento()">
                                    <input type="hidden" name="acao" value="atualizar_status">
                                    <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                    <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                                    <input type="hidden" name="novo_status" value="em_andamento">
                                    <button type="submit" class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white p-2 rounded-lg" title="Marcar como Em Andamento">
                                        <i class="fas fa-spinner"></i>
                                        Realizar Tarefa
                                    </button>
                                </form>
                            <?php elseif ($status_usuario === 'em_andamento'): ?>
                                <form method="POST" action="../controllers/DemandaController.php" class="inline" onsubmit="return confirmarConclusao()">
                                    <input type="hidden" name="acao" value="atualizar_status">
                                    <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                    <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                                    <input type="hidden" name="novo_status" value="concluida">
                                    <button type="submit" class="custom-btn bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg" title="Marcar como Concluída">
                                        <i class="fas fa-check"></i>
                                        Concluir Minha Parte
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Status dos Usuários -->
                    <?php if (!empty($d['usuarios_atribuidos'])): ?>
                    <div class="mt-4 pt-4 border-t border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-400 mb-2">Status dos Participantes:</h4>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($d['usuarios_atribuidos'] as $u_atrib): ?>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-300"><?php echo htmlspecialchars($u_atrib['nome']); ?>:</span>
                                    <span class="status-badge status-<?php echo $u_atrib['status']; ?>">
                                        <?php
                                        $statusIcons = [
                                            'pendente' => 'fas fa-clock',
                                            'em_andamento' => 'fas fa-spinner fa-spin',
                                            'concluido' => 'fas fa-check-circle'
                                        ];
                                        ?>
                                        <i class="<?php echo $statusIcons[$u_atrib['status']] ?? 'fas fa-question'; ?>"></i>
                                        <?php echo ucfirst($u_atrib['status']); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                        <?php endforeach; ?>
            </div>
            
            <!-- Empty State -->
            <div id="emptyState" class="empty-state hidden">
                <i class="fas fa-search"></i>
                <h3 class="text-xl font-semibold mb-2">Nenhuma demanda encontrada</h3>
                <p>Tente ajustar os filtros ou aguarde novas demandas serem atribuídas.</p>
            </div>
        </div>
    </main>

    <!-- Modal de Descrição -->
    <div id="modalDescricao" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-2xl p-8 scale-in">
            <div class="flex justify-between items-start mb-6">
                <h3 id="modalTitulo" class="text-2xl font-bold text-white pr-4"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white transition-colors p-2">
                    <i class="fas fa-times text-xl"></i>
                    </button>
            </div>
            
            <div class="mb-6">
                <div class="flex items-center gap-4 mb-4">
                    <span id="modalStatus" class="status-badge"></span>
                    <span class="text-gray-400 text-sm" id="modalDates"></span>
                </div>
            </div>
            
            <div class="bg-gray-800/50 rounded-lg p-4 mb-6">
                <h4 class="text-sm font-semibold text-gray-400 mb-2">Descrição:</h4>
                <p id="modalDescricaoTexto" class="text-gray-300 text-base leading-relaxed"></p>
            </div>
            
            <div class="flex justify-end">
                <button onclick="closeModal()" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg">
                    Fechar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function mostrarDescricao(titulo, descricao, status, dataCriacao, dataConclusao) {
            document.getElementById('modalTitulo').textContent = titulo;
            document.getElementById('modalDescricaoTexto').textContent = descricao;
            
            // Update status badge
            const statusBadge = document.getElementById('modalStatus');
            statusBadge.textContent = status;
            statusBadge.className = `status-badge status-${status.toLowerCase().replace(' ', '-')}`;
            
            // Update dates
            let datesText = `Criado em: ${dataCriacao}`;
            if (dataConclusao) {
                datesText += ` • Concluído em: ${dataConclusao}`;
            }
            document.getElementById('modalDates').textContent = datesText;
            
            document.getElementById('modalDescricao').classList.remove('hidden');
            document.getElementById('modalDescricao').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modalDescricao').classList.add('hidden');
            document.getElementById('modalDescricao').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Filter Functions
        function filterByStatus(status) {
            const cards = document.querySelectorAll('.demand-card');
            const emptyState = document.getElementById('emptyState');
            let visibleCount = 0;

            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        function filterByPriority(priority) {
            const cards = document.querySelectorAll('.demand-card');
            const emptyState = document.getElementById('emptyState');
            let visibleCount = 0;

            cards.forEach(card => {
                if (priority === 'all' || card.dataset.priority === priority) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        function filterDemands() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusSelect = document.querySelector('select[onchange="filterByStatus(this.value)"]');
            const prioritySelect = document.querySelector('select[onchange="filterByPriority(this.value)"]');
            const cards = document.querySelectorAll('.demand-card');
            const emptyState = document.getElementById('emptyState');
            let visibleCount = 0;

            cards.forEach(card => {
                const title = card.dataset.title.toLowerCase();
                const description = card.dataset.description.toLowerCase();
                const status = card.dataset.status;
                const priority = card.dataset.priority;
                const activeStatus = statusSelect.value;
                const activePriority = prioritySelect.value;

                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                const matchesStatus = activeStatus === 'all' || status === activeStatus;
                const matchesPriority = activePriority === 'all' || priority === activePriority;

                if (matchesSearch && matchesStatus && matchesPriority) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        function confirmarConclusao() {
            return confirm('Tem certeza que deseja marcar esta demanda como concluída?');
        }

        function confirmarEmAndamento() {
            return confirm('Tem certeza que deseja marcar esta demanda como Em Andamento?');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.id === 'modalDescricao') {
                closeModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Add loading states to forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<div class="loading"></div> Processando...';
                    submitBtn.disabled = true;
                }
            });
        });

        // Initialize animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to cards
            document.querySelectorAll('.demand-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
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

            // Auto-hide empty state if there are cards
            const cards = document.querySelectorAll('.demand-card');
            const emptyState = document.getElementById('emptyState');
            if (cards.length === 0) {
                emptyState.classList.remove('hidden');
            }
        });
    </script>
</body>
</html> 