<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_error_handler(function(
    $errno, $errstr, $errfile, $errline
) {
    $msg = addslashes("[$errno] $errstr em $errfile na linha $errline");
    echo "<script>console.log('PHP: $msg');</script>";
    return false;
});

set_exception_handler(function($exception) {
    $msg = addslashes($exception->getMessage() . ' em ' . $exception->getFile() . ' na linha ' . $exception->getLine());
    echo "<script>console.log('Exceção: $msg');</script>";
});

// Removido controle de sessão e permissões para acesso livre
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/Demanda.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../model/Area.php';

// Função para mapear a área a partir da permissão
function areaFromPermissao($permissao) {
    if (strpos($permissao, 'adm_area_design') === 0) return 'Design';
    if (strpos($permissao, 'adm_area_dev') === 0) return 'Desenvolvimento';
    if (strpos($permissao, 'adm_area_suporte') === 0) return 'Suporte';
    if (strpos($permissao, 'adm_geral') === 0) return 'Geral';
    if (strpos($permissao, 'usuario') === 0) return 'Usuário Comum';
    return 'Desconhecida';
}

// Inicializa a conexão com o banco de dados
$database = Database::getInstance();
$pdo_salaberga = $database->getSalabergaConnection();
$pdo_area_dev = $database->getAreaDevConnection();

// Inicializa os modelos
$demanda = new Demanda($pdo_area_dev);
$usuario = new Usuario($pdo_salaberga);
$area = new Area($pdo_area_dev);
$areas = $area->listarAreas();

// Remover áreas duplicadas pelo nome
$nomesVistos = [];
$areas_unicas = [];
foreach ($areas as $a) {
    if (!in_array($a['nome'], $nomesVistos)) {
        $areas_unicas[] = $a;
        $nomesVistos[] = $a['nome'];
    }
}
$areas = $areas_unicas;

$permissoes = $usuario->listarPermissoes();

// Buscar usuários conforme permissões do sistema de demandas
$id_sistema_demandas = 3;
$usuarios_permissoes = $usuario->listarUsuariosComPermissoes($id_sistema_demandas);
$admins_gerais = Usuario::filtrarAdminsGerais($usuarios_permissoes);
$admins_area = Usuario::filtrarAdminsArea($usuarios_permissoes);
$usuarios = Usuario::filtrarUsuariosComuns($usuarios_permissoes);

// Processar ações POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                if (isset($_POST['titulo'], $_POST['descricao'], $_POST['area_id'], $_POST['prioridade'])) {
                    $demanda->criarDemanda(
                        $_POST['titulo'],
                        $_POST['descricao'],
                        $_POST['prioridade'],
                        1,
                        [],
                        null,
                        $_POST['area_id'],
                        $usuario
                    );
                }
                break;
            case 'delete':
                if (isset($_POST['demanda_id'])) {
                    $demanda->excluirDemanda($_POST['demanda_id']);
                }
                break;
            case 'update_status':
                if (isset($_POST['demanda_id'], $_POST['novo_status'])) {
                    if ($_POST['novo_status'] === 'concluida') {
                        $demanda->marcarConcluida($_POST['demanda_id'], 1);
                    } else if ($_POST['novo_status'] === 'em_andamento') {
                        $demanda->marcarEmAndamento($_POST['demanda_id'], 1);
                    }
                }
                break;
        }
    }
}

// Listar todas as demandas
$demandas = $demanda->listarDemandas();

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

    .status-aceito {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-aceito i {
        color: #4ade80;
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

    .status-concluido {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-concluido i {
        color: #4ade80;
    }

    .status-cancelada {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .status-cancelada i {
        color: #f87171;
    }

    .status-recusado {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .status-recusado i {
        color: #f87171;
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

    .demand-card h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 0.375rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
        margin-bottom: 0.375rem;
    }

    /* User Cards */
    .user-card {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 122, 51, 0.1);
        border-color: rgba(0, 255, 107, 0.3);
    }
</style>

<body class="select-none">
    <!-- Header -->
    <header class="bg-dark-400 shadow-lg border-b border-primary-500/20 sticky top-0 z-50 backdrop-blur-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Logo e Título -->
                <div class="flex items-center gap-3 w-full sm:w-auto justify-center sm:justify-start">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="w-10 h-10">
                    <div class="text-center sm:text-left">
                        <h1 class="text-xl md:text-2xl font-bold bg-gradient-to-r from-primary-50 to-primary-200 bg-clip-text text-transparent">
                            Painel Administrativo
                        </h1>
                        <p class="text-sm text-gray-400">Sistema de Gestão de Demandas</p>
                    </div>
                </div>

                <!-- Botões e Informações do Usuário -->
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                    <!-- Informações do Usuário -->
                    <div class="flex items-center gap-2 text-gray-300 bg-dark-300/50 px-4 py-2 rounded-lg">
                        <i class="fas fa-user-shield text-primary-50"></i>
                        <span class="text-sm truncate max-w-[200px]"><?php echo htmlspecialchars($_SESSION['Nome'] ?? 'Admin'); ?></span>
                        <span class="bg-red-600 text-white text-xs font-semibold px-2.5 py-0.5 rounded-full">
                            Admin
                        </span>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center gap-2 w-full sm:w-auto justify-center sm:justify-end">
                        <a href="../../../main/views/autenticacao/login.php?sair=true" class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm w-full sm:w-auto justify-center">
                            <i class="fas fa-sign-out-alt btn-icon"></i>
                            <span>Sair</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in">
            <div class="stats-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Total de Demandas</p>
                        <p class="text-3xl font-bold text-white"><?php echo $totalDemandas; ?></p>
            </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-tasks text-white text-xl"></i>
        </div>
                </div>
            </div>

            <div class="stats-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Em Andamento</p>
                        <p class="text-3xl font-bold text-white"><?php echo $demandasEmAndamento; ?></p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-400 rounded-full flex items-center justify-center">
                        <i class="fas fa-spinner text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Concluídas</p>
                        <p class="text-3xl font-bold text-white"><?php echo $demandasConcluidas; ?></p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-400 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="search-container slide-up" style="animation-delay: 0.6s">
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
                
                <button onclick="openModal('criarDemandaModal')" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2">
                    <i class="fas fa-plus btn-icon"></i> Nova Demanda
                </button>
            </div>
        </div>

        <!-- Demands Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <i class="fas fa-clipboard-list text-primary-50"></i>
                Gerenciar Demandas
            </h2>
            
            <!-- Seção Em Espera -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-white mb-4">Em Espera</h3>
                <div id="demandasEsperaContainer" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 items-start">
                    <?php 
                    $count_espera = 0;
                    foreach ($demandas as $index => $d): 
                        if ($d['status'] === 'pendente'):
                            $count_espera++;
                    ?>
                
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
                                        'cancelada' => 'fas fa-ban',
                                        'aceito' => 'fas fa-check-circle'
                                    ];
                                    
                                    $display_status = $d['status'];
                                    $display_icon = $statusIcons[$display_status] ?? 'fas fa-question';

                                    if (!empty($d['usuarios_atribuidos']) && count($d['usuarios_atribuidos']) === 1) {
                                                        $single_participant_status = $d['usuarios_atribuidos'][0]['status'] ?? null;
                                                        if ($single_participant_status === 'concluido') {
                                                $display_status = 'concluida';
                                                            $display_icon = $statusIcons[$display_status] ?? 'fas fa-question';
                                                        }
                                                    }
                                    
                                        $status_display = ucfirst(str_replace('_', ' ', $display_status));
                                    ?>
                                    <i class="<?php echo $display_icon; ?>"></i>
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
                                <p class="text-gray-400">
                                    <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
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
                                        $dias_prazo = 0;
                                        switch ($d['prioridade']) {
                                            case 'baixa': $dias_prazo = 5; break;
                                            case 'media': $dias_prazo = 3; break;
                                            case 'alta': $dias_prazo = 1; break;
                                        }
                                        echo date('d/m/Y', strtotime($d['data_criacao'] . " +{$dias_prazo} days"));
                                    }
                                    ?>
                                </p>
                                <?php if (!empty($d['data_conclusao'])): ?>
                                <p class="text-gray-400">
                                    <?php echo date('H:i', strtotime($d['data_conclusao'])); ?>
                                </p>
                                <?php else: ?>
                                <p class="text-gray-400">
                                    <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
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

                        <div class="flex items-center gap-2 ml-auto">
                                <?php if ($d['status'] !== 'concluida'): ?>
                                    <?php if ($d['status'] === 'pendente'): ?>
                                        <button onclick="realizarTarefa(<?php echo $d['id']; ?>, '<?php echo $d['status']; ?>')" 
                                                class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg transition-all duration-300 flex items-center gap-2">
                                            <i class="fas fa-tasks"></i>
                                            Realizar Tarefa
                        </button>
                                    <?php elseif ($d['status'] === 'em_andamento'): ?>
                                        <button onclick="concluirDemanda(<?php echo $d['id']; ?>)" 
                                                class="custom-btn bg-green-600 hover:bg-green-700 text-white py-1 px-2 rounded-lg transition-all duration-300 flex items-center gap-2">
                                            <i class="fas fa-check"></i>
                                            Concluir
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <button onclick="editarDemanda(<?php echo $d['id']; ?>)" class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="excluirDemanda(<?php echo $d['id']; ?>)" class="custom-btn bg-red-600 hover:bg-red-700 text-white py-1 px-2 rounded-lg" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Status dos Usuários -->
                        <?php if (!empty($d['usuarios_atribuidos'])): ?>
                        <div class="mt-4 pt-4 border-t border-gray-700">
                            <h4 class="text-sm font-semibold text-gray-400 mb-2">Status dos Participantes:</h4>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($d['usuarios_atribuidos'] as $u_atrib): ?>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-300"><?php echo isset($u_atrib['nome']) && $u_atrib['nome'] ? htmlspecialchars($u_atrib['nome']) : '<span class="text-gray-500">Sem nome</span>'; ?>:</span>
                                        <span class="status-badge status-<?php echo $u_atrib['status']; ?>">
                                            <?php
                                            $statusIconsParticipante = [
                                                'pendente' => 'fas fa-clock',
                                                'aceito' => 'fas fa-check-circle',
                                                'em_andamento' => 'fas fa-spinner fa-spin',
                                                'concluido' => 'fas fa-check-circle',
                                                'recusado' => 'fas fa-times-circle'
                                            ];
                                            ?>
                                            <i class="<?php echo $statusIconsParticipante[$u_atrib['status']] ?? 'fas fa-question'; ?>"></i>
                                            <?php echo ucfirst($u_atrib['status']); ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
                 <?php if ($count_espera === 0): ?>
                    <div class="empty-state">
                        <i class="fas fa-clipboard"></i>
                        <h3 class="text-xl font-semibold mb-2">Nenhuma demanda em espera</h3>
                        <p>Todas as demandas pendentes estão sendo feitas ou foram concluídas/canceladas.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Seção Outras Demandas -->
            <div class="mb-8">
                 <h3 class="text-xl font-bold text-white mb-4">Outras Demandas</h3>
                 <div id="demandasOutrasContainer" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 items-start">
                     <?php 
                     $count_outras = 0;
                     foreach ($demandas as $index => $d): 
                         if ($d['status'] !== 'pendente'):
                             $count_outras++;
                     ?>
                     
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
                                             'cancelada' => 'fas fa-ban',
                                             'aceito' => 'fas fa-check-circle'
                                         ];
                                         
                                         $display_status = $d['status'];
                                         $display_icon = $statusIcons[$display_status] ?? 'fas fa-question';

                                         if (!empty($d['usuarios_atribuidos']) && count($d['usuarios_atribuidos']) === 1) {
                                             $single_participant_status = $d['usuarios_atribuidos'][0]['status'] ?? null;
                                             if ($single_participant_status === 'concluido') {
                                                 $display_status = 'concluida';
                                                 $display_icon = $statusIcons[$display_status] ?? 'fas fa-question';
                                             }
                                         }

                                         $status_display = ucfirst(str_replace('_', ' ', $display_status));
                                         ?>
                                         <i class="<?php echo $display_icon; ?>"></i>
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
                                     <p class="text-gray-400">
                                         <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
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
                                         $dias_prazo = 0;
                                         switch ($d['prioridade']) {
                                                 case 'baixa': $dias_prazo = 5; break;
                                                 case 'media': $dias_prazo = 3; break;
                                                 case 'alta': $dias_prazo = 1; break;
                                             }
                                             echo date('d/m/Y', strtotime($d['data_criacao'] . " +{$dias_prazo} days"));
                                         }
                                         ?>
                                     </p>
                                     <?php if (!empty($d['data_conclusao'])): ?>
                                         <p class="text-gray-400">
                                         <?php echo date('H:i', strtotime($d['data_conclusao'])); ?>
                                     </p>
                                     <?php else: ?>
                                     <p class="text-gray-400">
                                         <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
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

                             <div class="flex items-center gap-2 ml-auto">
                            <?php if ($d['status'] !== 'concluida'): ?>
                                <?php if ($d['status'] === 'pendente'): ?>
                                         <button onclick="realizarTarefa(<?php echo $d['id']; ?>, '<?php echo $d['status']; ?>')" 
                                                 class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg transition-all duration-300 flex items-center gap-2">
                                        <i class="fas fa-tasks"></i>
                                        Realizar Tarefa
                                    </button>
                                <?php elseif ($d['status'] === 'em_andamento'): ?>
                                    <button onclick="concluirDemanda(<?php echo $d['id']; ?>)" 
                                                 class="custom-btn bg-green-600 hover:bg-green-700 text-white py-1 px-2 rounded-lg transition-all duration-300 flex items-center gap-2">
                                        <i class="fas fa-check"></i>
                                        Concluir
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                                 <button onclick="editarDemanda(<?php echo $d['id']; ?>)" class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                                 <button onclick="excluirDemanda(<?php echo $d['id']; ?>)" class="custom-btn bg-red-600 hover:bg-red-700 text-white py-1 px-2 rounded-lg" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Status dos Usuários -->
                    <?php if (!empty($d['usuarios_atribuidos'])): ?>
                    <div class="mt-4 pt-4 border-t border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-400 mb-2">Status dos Participantes:</h4>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($d['usuarios_atribuidos'] as $u_atrib): ?>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-300"><?php echo isset($u_atrib['nome']) && $u_atrib['nome'] ? htmlspecialchars($u_atrib['nome']) : '<span class="text-gray-500">Sem nome</span>'; ?>:</span>
                                    <span class="status-badge status-<?php echo $u_atrib['status']; ?>">
                                        <?php
                                        $statusIconsParticipante = [
                                            'pendente' => 'fas fa-clock',
                                            'aceito' => 'fas fa-check-circle',
                                            'em_andamento' => 'fas fa-spinner fa-spin',
                                            'concluido' => 'fas fa-check-circle',
                                            'recusado' => 'fas fa-times-circle'
                                        ];
                                        ?>
                                        <i class="<?php echo $statusIconsParticipante[$u_atrib['status']] ?? 'fas fa-question'; ?>"></i>
                                        <?php echo ucfirst($u_atrib['status']); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                     <?php 
                         endif;
                     endforeach; 
                     ?>
            </div>
                  <?php if ($count_outras === 0): ?>
                     <div class="empty-state">
                         <i class="fas fa-list"></i>
                         <h3 class="text-xl font-semibold mb-2">Nenhuma outra demanda</h3>
                         <p>Todas as demandas estão em espera ou sendo feitas.</p>
            </div>
                 <?php endif; ?>
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

            <!-- Admins Gerais -->
            <?php if (!empty($admins_gerais)): ?>
            <h3 class="text-lg font-semibold text-primary-100 mb-2">Administradores Gerais</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <?php foreach ($admins_gerais as $index => $user): ?>
                <div class="user-card fade-in" style="animation-delay: <?php echo ($index * 0.1); ?>s">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-shield text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white">
                                <?php echo isset($user['nome']) && $user['nome'] ? htmlspecialchars($user['nome']) : '<span class="text-gray-500">Sem nome</span>'; ?>
                            </h3>
                            <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user['email']); ?></p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-red-500/20 text-red-400">
                                Admin Geral - <?php echo areaFromPermissao($user['permissao']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Admins de Área -->
            <?php if (!empty($admins_area)): ?>
            <h3 class="text-lg font-semibold text-primary-100 mb-2">Administradores de Área</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <?php foreach ($admins_area as $index => $user): ?>
                <div class="user-card fade-in" style="animation-delay: <?php echo ($index * 0.1); ?>s">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-cog text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white">
                                <?php echo isset($user['nome']) && $user['nome'] ? htmlspecialchars($user['nome']) : '<span class="text-gray-500">Sem nome</span>'; ?>
                            </h3>
                            <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user['email']); ?></p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400">
                                Admin de Área - <?php echo areaFromPermissao($user['permissao']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Usuários de Área -->
            <?php
            $usuarios_area = array_filter($usuarios, function($user) {
                return strpos($user['permissao'], 'usuario_area_') === 0;
            });
            ?>
            <?php if (!empty($usuarios_area)): ?>
            <h3 class="text-lg font-semibold text-primary-100 mb-2">Usuários de Área</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <?php foreach ($usuarios_area as $index => $user): ?>
                <div class="user-card fade-in" style="animation-delay: <?php echo ($index * 0.1); ?>s">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white">
                                <?php echo isset($user['nome']) && $user['nome'] ? htmlspecialchars($user['nome']) : '<span class="text-gray-500">Sem nome</span>'; ?>
                            </h3>
                            <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user['email']); ?></p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-blue-500/20 text-blue-400">
                                Usuário de Área - <?php echo areaFromPermissao($user['permissao']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Usuários Comuns -->
            <h3 class="text-lg font-semibold text-primary-100 mb-2">Usuários</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($usuarios as $index => $user): ?>
                <div class="user-card fade-in" style="animation-delay: <?php echo ($index * 0.1); ?>s">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white">
                                <?php echo isset($user['nome']) && $user['nome'] ? htmlspecialchars($user['nome']) : '<span class="text-gray-500">Sem nome</span>'; ?>
                            </h3>
                            <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user['email']); ?></p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-blue-500/20 text-blue-400">
                                Usuário - <?php echo areaFromPermissao($user['permissao']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Modal de Descrição -->
    <div id="modalDescricao" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-2xl p-8 scale-in">
            <div class="flex justify-between items-start mb-6">
                <h3 id="modalTitulo" class="text-2xl font-bold text-white pr-4"></h3>
                <button onclick="closeModal('modalDescricao')" class="text-gray-400 hover:text-white transition-colors p-2">
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
                <button onclick="closeModal('modalDescricao')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg">
                    Fechar
                </button>
            </div>
        </div>
    </div>

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
                    <label for="area_id" class="block text-sm font-medium text-gray-300 mb-2">Área</label>
                    <select id="area_id" name="area_id" required class="custom-select w-full">
                        <option value="">Selecione a área</option>
                        <?php foreach ($areas as $area): ?>
                            <option value="<?= $area['id'] ?>"><?= htmlspecialchars($area['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
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
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                <div id="prazoCalculadoInfo" class="mt-2"></div>
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
                    <select id="tipo" name="tipo" required class="custom-select w-full" onchange="toggleAreaField()">
                        <option value="">Selecione o tipo/permissão</option>
                        <optgroup label="Usuários">
                            <option value="usuario_area_dev">Usuário - Área de Desenvolvimento</option>
                            <option value="usuario_area_design">Usuário - Área de Design</option>
                            <option value="usuario_area_suporte">Usuário - Área de Suporte</option>
                        </optgroup>
                        <optgroup label="Administradores">
                            <option value="adm_area_dev">Administrador - Área de Desenvolvimento</option>
                            <option value="adm_area_design">Administrador - Área de Design</option>
                            <option value="adm_area_suporte">Administrador - Área de Suporte</option>
                            <option value="adm_geral">Administrador Geral</option>
                        </optgroup>
                    </select>
                </div>
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeModal('criarUsuarioModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" name="criar_usuario" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-2 px-4 rounded-lg">
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
                <input type="hidden" id="editId" name="id">
                
                <div>
                    <label for="editTitulo" class="block text-sm font-medium text-gray-300 mb-2">Título</label>
                    <input type="text" id="editTitulo" name="titulo" required class="custom-input w-full">
                </div>
                
                <div>
                    <label for="editDescricao" class="block text-sm font-medium text-gray-300 mb-2">Descrição</label>
                    <textarea id="editDescricao" name="descricao" rows="4" required class="custom-input w-full"></textarea>
                </div>
                
                <div>
                    <label for="editPrioridade" class="block text-sm font-medium text-gray-300 mb-2">Prioridade</label>
                    <select id="editPrioridade" name="prioridade" required class="custom-select w-full">
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                <div id="editPrazoCalculadoInfo" class="mt-2"></div>
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeModal('editarDemandaModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-2 px-4 rounded-lg">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Demand Modal -->
    <div id="excluirDemandaModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-md p-8 scale-in">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-500"></i>
            </div>

                <h3 class="text-2xl font-bold text-white mb-4">Confirmar Exclusão</h3>
                
                <p class="text-gray-300 mb-8 text-lg">
                    Tem certeza que deseja excluir esta demanda? Esta ação não pode ser desfeita.
                </p>

                <form action="../controllers/DemandaController.php" method="POST" id="formExcluirDemanda" class="w-full">
                <input type="hidden" name="acao" value="excluir">
                <input type="hidden" name="id" id="demanda_a_excluir_id">
                    
            <div class="flex justify-center gap-4">
                        <button type="button" onclick="closeModal('excluirDemandaModal')" 
                                class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2 transition-all duration-300">
                            <i class="fas fa-times"></i>
                    Cancelar
                </button>
                        
                        <button type="submit" 
                                class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2 transition-all duration-300">
                            <i class="fas fa-trash"></i>
                    Excluir
                </button>
            </div>
            </form>
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
            
            openModal('modalDescricao');
        }

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

        // Função para editar demanda
        async function editarDemanda(id) {
            try {
                const response = await fetch(`../controllers/DemandaController.php?action=get_demanda&id=${id}`);
                    if (!response.ok) {
                    throw new Error('Erro ao buscar dados da demanda');
                }
                const data = await response.json();
                
                if (data) {
                    document.getElementById('editId').value = data.id;
                    document.getElementById('editTitulo').value = data.titulo;
                    document.getElementById('editDescricao').value = data.descricao;
                    document.getElementById('editPrioridade').value = data.prioridade;
                    
                    updateEditPrazoCalculadoInfo();
                    openModal('editarDemandaModal');
                } else {
                    alert('Erro ao carregar dados da demanda');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao carregar dados da demanda: ' + error.message);
            }
        }

        // Função para excluir demanda
        function excluirDemanda(id) {
            document.getElementById('demanda_a_excluir_id').value = id;
            openModal('excluirDemandaModal');
        }

        // Atualizar informação de prazo calculado ao selecionar prioridade
        const prioridadeSelect = document.getElementById('prioridade');
        const prazoCalculadoInfo = document.getElementById('prazoCalculadoInfo');

        function updatePrazoCalculadoInfo() {
            const prioridade = prioridadeSelect.value;
            let dias = 0;
            switch (prioridade) {
                case 'baixa': dias = 5; break;
                case 'media': dias = 3; break;
                case 'alta': dias = 1; break;
            }
            prazoCalculadoInfo.innerHTML = `
                <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-primary-500/20 text-primary-50 text-sm font-medium">
                    <i class="fas fa-clock"></i>
                    Prazo: até ${dias} dia${dias > 1 ? 's' : ''}
                </span>
            `;
        }

        updatePrazoCalculadoInfo();
        prioridadeSelect.addEventListener('change', updatePrazoCalculadoInfo);

        // Atualizar informação de prazo calculado no modal de edição
        const editPrioridadeSelect = document.getElementById('editPrioridade');
        const editPrazoCalculadoInfo = document.getElementById('editPrazoCalculadoInfo');

        function updateEditPrazoCalculadoInfo() {
            const prioridade = editPrioridadeSelect.value;
            let dias = 0;
            switch (prioridade) {
                case 'baixa': dias = 5; break;
                case 'media': dias = 3; break;
                case 'alta': dias = 1; break;
            }
            editPrazoCalculadoInfo.innerHTML = `
                <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-primary-500/20 text-primary-50 text-sm font-medium">
                    <i class="fas fa-clock"></i>
                    Prazo: até ${dias} dia${dias > 1 ? 's' : ''}
                </span>
            `;
        }

        editPrioridadeSelect.addEventListener('change', updateEditPrazoCalculadoInfo);

        // Função para realizar tarefa
        function realizarTarefa(demandaId, statusAtual) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '../controllers/DemandaController.php';

                const acaoInput = document.createElement('input');
                acaoInput.type = 'hidden';
                acaoInput.name = 'acao';
                acaoInput.value = 'atualizar_status';

                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'id';
                idInput.value = demandaId;

                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'novo_status';
                statusInput.value = statusAtual === 'em_andamento' ? 'concluida' : 'em_andamento';

                form.appendChild(acaoInput);
                form.appendChild(idInput);
                form.appendChild(statusInput);

                document.body.appendChild(form);
                form.submit();
        }

        function concluirDemanda(demandaId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '../controllers/DemandaController.php';
                
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'acao';
                actionInput.value = 'atualizar_status';
                
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'id';
                idInput.value = demandaId;
                
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'novo_status';
                statusInput.value = 'concluida';
                
                form.appendChild(actionInput);
                form.appendChild(idInput);
                form.appendChild(statusInput);
                
                document.body.appendChild(form);
                form.submit();
            }

        // Filter Functions
        function filterByStatus(status) {
            const cards = document.querySelectorAll('.demand-card');

            cards.forEach(card => {
                const cardStatus = card.dataset.status;
                
                if (status === 'all' || cardStatus === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            updateEmptyState('demandasEsperaContainer');
            updateEmptyState('demandasOutrasContainer');
            filterDemands();
        }

        function filterByPriority(priority) {
            const cards = document.querySelectorAll('.demand-card');

            cards.forEach(card => {
                const cardPriority = card.dataset.priority;

                let isVisibleByPriority = (priority === 'all' || cardPriority === priority);
                card.style.display = isVisibleByPriority ? 'block' : 'none';
            });

            filterDemands();
        }

        function filterDemands() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusSelect = document.querySelector('select[onchange="filterByStatus(this.value)"]');
            const prioritySelect = document.querySelector('select[onchange="filterByPriority(this.value)"]');
            const cards = document.querySelectorAll('.demand-card');
            
            const activeStatus = statusSelect ? statusSelect.value : 'all';
            const activePriority = prioritySelect ? prioritySelect.value : 'all';

            cards.forEach(card => {
                const title = card.dataset.title.toLowerCase();
                const description = card.dataset.description.toLowerCase();
                const status = card.dataset.status;
                const priority = card.dataset.priority;

                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                const matchesStatus = activeStatus === 'all' || status === activeStatus;
                const matchesPriority = activePriority === 'all' || priority === activePriority;

                if (matchesSearch && matchesStatus && matchesPriority) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            updateEmptyState('demandasEsperaContainer');
            updateEmptyState('demandasOutrasContainer');
        }

        function updateEmptyState(containerId) {
            const container = document.getElementById(containerId);
            if (!container) return;

            const cards = container.querySelectorAll('.demand-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const cardStatus = card.dataset.status;
                let belongsToContainer = false;
                if (containerId === 'demandasEsperaContainer' && cardStatus === 'pendente') {
                    belongsToContainer = true;
                } else if (containerId === 'demandasOutrasContainer' && cardStatus !== 'pendente') {
                    belongsToContainer = true;
                }

                if (card.style.display !== 'none' && belongsToContainer) {
                    visibleCount++;
                }
            });

            const emptyState = container.querySelector('.empty-state');
            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                const modalId = event.target.id;
                closeModal(modalId);
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const openModal = document.querySelector('.modal.flex');
                if (openModal) {
                    closeModal(openModal.id);
                }
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
        });

        function toggleAreaField() {
            const tipoSelect = document.getElementById('tipo');
            const areaField = document.getElementById('areaField');
            
            if (tipoSelect.value.startsWith('adm_area_')) {
                if (areaField) areaField.style.display = 'block';
            } else {
                if (areaField) areaField.style.display = 'none';
            }
        }
    </script>
</body>
</html> 