<?php
require_once('../models/usuario.model.php');
$model_usuario = new usuario_model();
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0a0a0a">
    <meta name="description" content="Painel Usuário - Sistema de Gestão de Demandas">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <title>Painel Usuário - Sistema de Gestão de Demandas</title>

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
                        }
                    },
                    animation: {
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'float': 'float 3s ease-in-out infinite',
                        'shimmer': 'shimmer 2s linear infinite',
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: #ffffff;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(0, 122, 51, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 255, 107, 0.02) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        /* Enhanced Card Styling */
        .demanda-card {
            background: rgba(26, 26, 26, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            width: 100%;
            opacity: 1;
        }

        .demanda-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 107, 0.6), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .demanda-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.02), transparent);
            transform: rotate(45deg);
            transition: transform 0.6s ease;
            pointer-events: none;
        }

        .demanda-card:hover {
            transform: translateY(-4px);
            border-color: rgba(0, 122, 51, 0.3);
            box-shadow: 
                0 10px 25px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(0, 122, 51, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .demanda-card:hover::before {
            opacity: 1;
        }

        .demanda-card:hover::after {
            transform: rotate(45deg) translate(50%, 50%);
        }

        /* Badge Styling */
        .priority-badge, .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            gap: 0.3rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .priority-badge::before, .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .priority-badge:hover::before, .status-badge:hover::before {
            left: 100%;
        }

        .priority-baixa { 
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(5, 150, 105, 0.15));
            color: #6ee7b7; 
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .priority-media { 
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(217, 119, 6, 0.15));
            color: #fcd34d; 
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .priority-alta { 
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(220, 38, 38, 0.15));
            color: #fca5a5; 
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-pendente { 
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(217, 119, 6, 0.15));
            color: #fcd34d; 
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .status-andamento { 
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(29, 78, 216, 0.15));
            color: #93c5fd; 
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .status-concluido { 
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(5, 150, 105, 0.15));
            color: #6ee7b7; 
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        /* Button Styling */
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007A33, #00993F);
            color: white;
            border: 1px solid rgba(0, 122, 51, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #00993F, #00C250);
            box-shadow: 0 4px 15px rgba(0, 122, 51, 0.3);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            border: 1px solid rgba(220, 38, 38, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #ef4444, #f87171);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
            transform: translateY(-1px);
        }

        .btn-yellow {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .btn-yellow:hover {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            transform: translateY(-1px);
        }

        .btn-green {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn-green:hover {
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            transform: translateY(-1px);
        }

        /* Column Headers */
        .column-header {
            background: rgba(26, 26, 26, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 1.2rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .column-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 107, 0.6), transparent);
        }

        /* Status Messages */
        .status-message {
            padding: 1rem 1.2rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .status-success { 
            background: rgba(16, 185, 129, 0.1); 
            color: #6ee7b7; 
            border-color: rgba(16, 185, 129, 0.3);
        }

        .status-error { 
            background: rgba(239, 68, 68, 0.1); 
            color: #fca5a5; 
            border-color: rgba(239, 68, 68, 0.3);
        }

        .status-empty { 
            background: rgba(245, 158, 11, 0.1); 
            color: #fcd34d; 
            border-color: rgba(245, 158, 11, 0.3);
        }

        /* User Badge */
        .user-badge {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(29, 78, 216, 0.15));
            color: #93c5fd;
            border: 1px solid rgba(59, 130, 246, 0.3);
            padding: 0.6rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Animations */
        @keyframes glow {
            from { box-shadow: 0 0 5px rgba(0, 255, 107, 0.2); }
            to { box-shadow: 0 0 20px rgba(0, 255, 107, 0.4); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Card content styling */
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .card-title:hover {
            color: #00FF6B;
        }

        .card-description {
            color: #a1a1aa;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .card-date {
            color: #71717a;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .demanda-card {
                padding: 1.25rem;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(26, 26, 26, 0.5);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 122, 51, 0.5);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 122, 51, 0.7);
        }

        /* Blur no fundo do modal de informações */
        #infoModal.modal.flex {
            background-color: rgba(0,0,0,0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: background 0.3s;
        }
        #infoModal .modal-content {
            opacity: 0;
            transform: scale(0.95) translateY(30px);
            transition: opacity 0.3s, transform 0.3s;
        }
        #infoModal.flex .modal-content.show {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    </style>
</head>

<body>
    <!-- Enhanced Header -->
    <header class="bg-black/50 backdrop-blur-lg border-b border-white/10 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="w-10 h-10 animate-float">
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-white to-primary-50 bg-clip-text text-transparent">
                            Painel do Usuário
                        </h1>
                        <p class="text-sm text-gray-400">Sistema de Gestão de Demandas</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 text-gray-300 bg-dark-300/50 px-4 py-2 rounded-lg backdrop-filter backdrop-blur-sm">
                        <i class="fas fa-user-shield text-primary-50"></i>
                        <span class="text-sm truncate max-w-[200px]">
                            <?php echo isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : 'Usuário'; ?>
                        </span>
                    </div>
                    <a href="../../main/views/autenticacao/login.php" class="btn btn-secondary text-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        Sair
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Status Messages -->
        <?php
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 'success':
                    echo '<div class="status-message status-success"><i class="fas fa-check-circle"></i>Demanda cadastrada com sucesso!</div>';
                    break;
                case 'error':
                    echo '<div class="status-message status-error"><i class="fas fa-exclamation-triangle"></i>Erro ao cadastrar demanda.</div>';
                    break;
                case 'empty':
                    echo '<div class="status-message status-empty"><i class="fas fa-info-circle"></i>Preencha todos os campos.</div>';
                    break;
            }
        }
        ?>

        <!-- Enhanced Kanban Board -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Coluna Pendente -->
            <div class="column-container">
                <div class="column-header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-400 text-sm"></i>
        </div>
                            <h2 class="text-lg font-semibold text-white">Pendente</h2>
                        </div>
                        <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-sm font-medium">
                            <?php 
                            $pendentes = $model_usuario->select_demandas_pendentes();
                            echo count($pendentes); 
                            ?>
                        </span>
                    </div>
                    </div>
                <div class="space-y-6">
                    <?php
                    if (!empty($pendentes)) {
                        foreach ($pendentes as $dado) {
                    ?>
                        <div class="demanda-card">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="card-title">
                                    <?= htmlspecialchars($dado['titulo']) ?>
                                </h3>
                                <button type="button" class="text-gray-400 hover:text-primary-50 p-2 rounded-full transition-colors focus:outline-none" title="Mais informações"
                                    onclick="openInfoModal('<?= htmlspecialchars(addslashes($dado['titulo'])) ?>', '<?= htmlspecialchars(addslashes($dado['prazo'])) ?>', '<?= isset($dado['nome_usuario']) ? htmlspecialchars(addslashes($dado['nome_usuario'])) : 'Não atribuído' ?>')">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                            <p class="card-description">
                                <?= htmlspecialchars($dado['descricao']) ?>
                            </p>
                            <div class="flex items-end justify-between gap-2 mt-auto pt-4">
                                <div class="flex flex-wrap gap-2">
                                    <span class="priority-badge priority-<?= strtolower($dado['prioridade']) ?>">
                                        <i class="fas fa-flag"></i>
                                        <?= htmlspecialchars($dado['prioridade']) ?>
                                    </span>
                                    <span class="status-badge status-pendente">
                                        <i class="fas fa-clock"></i>
                                        <?= htmlspecialchars($dado['status']) ?>
                                    </span>
                                </div>
                                <form action="../controllers/usuario.controller.php" method="post">
                                    <input type="hidden" name="id_demanda" value="<?= $dado['id'] ?>">
                                    <button type="submit" class="btn btn-yellow flex items-center gap-2 px-4 py-2 text-sm font-semibold shadow hover:shadow-lg transition-all">
                                        <i class="fas fa-play"></i>
                                        Iniciar
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php 
                        }
                    } else {
                        echo '<div class="text-center text-gray-400 py-8">
                                <i class="fas fa-inbox text-4xl mb-4 opacity-50"></i>
                                <p>Nenhuma demanda pendente</p>
                              </div>';
                    }
                    ?>
                </div>
            </div>

            <!-- Coluna Em Andamento -->
            <div class="column-container">
                <div class="column-header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-spinner text-blue-400 text-sm animate-spin"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">Em Andamento</h2>
                        </div>
                        <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm font-medium">
                            <?php 
                            $andamentos = $model_usuario->select_demandas_andamentos();
                            echo count($andamentos); 
                            ?>
                        </span>
                    </div>
                </div>
                <div class="space-y-6">
                    <?php
                    if (!empty($andamentos)) {
                        foreach ($andamentos as $dado) {
                    ?>
                        <div class="demanda-card">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="card-title">
                                    <?= htmlspecialchars($dado['titulo']) ?>
                                </h3>
                                <button type="button" class="text-gray-400 hover:text-primary-50 p-2 rounded-full transition-colors focus:outline-none" title="Mais informações"
                                    onclick="openInfoModal('<?= htmlspecialchars(addslashes($dado['titulo'])) ?>', '<?= htmlspecialchars(addslashes($dado['prazo'])) ?>', '<?= isset($dado['nome_usuario']) ? htmlspecialchars(addslashes($dado['nome_usuario'])) : 'Não atribuído' ?>')">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                            <p class="card-description">
                                <?= htmlspecialchars($dado['descricao']) ?>
                            </p>
                            <div class="flex items-end justify-between gap-2 mt-auto pt-4">
                                <div class="flex flex-wrap gap-2">
                                    <span class="priority-badge priority-<?= strtolower($dado['prioridade']) ?>">
                                        <i class="fas fa-flag"></i>
                                        <?= htmlspecialchars($dado['prioridade']) ?>
                                    </span>
                                    <span class="status-badge status-andamento">
                                        <i class="fas fa-spinner"></i>
                                        <?= htmlspecialchars($dado['status']) ?>
                                    </span>
                                </div>
                                <form action="../controllers/usuario.controller.php" method="post">
                                    <input type="hidden" name="id_demanda_concluir" value="<?= $dado['id'] ?>">
                                    <button type="submit" class="btn btn-primary flex items-center gap-2 px-4 py-2 text-sm font-semibold shadow hover:shadow-lg transition-all">
                                        <i class="fas fa-check"></i>
                                        Concluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php 
                        }
                    } else {
                        echo '<div class="text-center text-gray-400 py-8">
                                <i class="fas fa-cogs text-4xl mb-4 opacity-50"></i>
                                <p>Nenhuma demanda em andamento</p>
                              </div>';
                    }
                    ?>
                </div>
            </div>

            <!-- Coluna Concluída -->
            <div class="column-container">
                <div class="column-header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-400 text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">Concluída</h2>
                        </div>
                        <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-medium">
                            <?php 
                            $concluidos = $model_usuario->select_demandas_concluidos();
                            echo count($concluidos); 
                            ?>
                        </span>
                    </div>
                </div>
                <div class="space-y-6">
                    <?php
                    if (!empty($concluidos)) {
                        foreach ($concluidos as $dado) {
                    ?>
                        <div class="demanda-card">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="card-title">
                                    <?= htmlspecialchars($dado['titulo']) ?>
                                </h3>
                                <button type="button" class="text-gray-400 hover:text-primary-50 p-2 rounded-full transition-colors focus:outline-none" title="Mais informações"
                                    onclick="openInfoModal('<?= htmlspecialchars(addslashes($dado['titulo'])) ?>', '<?= htmlspecialchars(addslashes($dado['prazo'])) ?>', '<?= isset($dado['nome_usuario']) ? htmlspecialchars(addslashes($dado['nome_usuario'])) : 'Não atribuído' ?>')">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                            <p class="card-description">
                                <?= htmlspecialchars($dado['descricao']) ?>
                            </p>
                            <div class="flex flex-wrap gap-2 mt-auto">
                                <span class="priority-badge priority-<?= strtolower($dado['prioridade']) ?>">
                                    <i class="fas fa-flag"></i>
                                    <?= htmlspecialchars($dado['prioridade']) ?>
                                </span>
                                <span class="status-badge status-concluido">
                                    <i class="fas fa-check-circle"></i>
                                    <?= htmlspecialchars($dado['status']) ?>
                                </span>
                            </div>
                            <div class="flex justify-end mt-6"></div>
                        </div>
                    <?php 
                        }
                    } else {
                        echo '<div class="text-center text-gray-400 py-8">
                                <i class="fas fa-trophy text-4xl mb-4 opacity-50"></i>
                                <p>Nenhuma demanda concluída</p>
                              </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Informações do Card -->
    <div id="infoModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-sm p-6 rounded-xl shadow-2xl border border-gray-800 bg-[#181818] text-white relative">
            <button onclick="closeInfoModal()" class="absolute top-3 right-3 text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-800 rounded-lg">
                <i class="fas fa-times"></i>
            </button>
            <h3 class="text-xl font-bold mb-4" id="infoModalTitulo"></h3>
            <div class="mb-3">
                <span class="block text-gray-400 text-sm mb-1">Prazo:</span>
                <span class="block text-lg font-semibold" id="infoModalPrazo"></span>
            </div>
            <div>
                <span class="block text-gray-400 text-sm mb-1">Responsável:</span>
                <span class="block text-lg font-semibold" id="infoModalResponsavel"></span>
            </div>
        </div>
    </div>

    <script>
        // Apenas hover e glow, sem animação de entrada para evitar cards invisíveis
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.demanda-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'scale(1.02)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'scale(1)';
                });
            });
            // Auto-hide status messages
            const statusMessages = document.querySelectorAll('.status-message');
            statusMessages.forEach(message => {
                setTimeout(() => {
                    message.style.opacity = 0;
                    message.style.transform = 'translateX(50px)';
                    setTimeout(() => message.remove(), 500);
                }, 4000);
            });
        });

        // Modal de informações do card
        function openInfoModal(titulo, prazo, responsavel) {
            document.getElementById('infoModalTitulo').textContent = titulo;
            document.getElementById('infoModalPrazo').textContent = prazo;
            document.getElementById('infoModalResponsavel').textContent = responsavel;
            const modal = document.getElementById('infoModal');
            const modalContent = modal.querySelector('.modal-content');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                modalContent.classList.add('show');
            }, 10);
        }
        function closeInfoModal() {
            const modal = document.getElementById('infoModal');
            const modalContent = modal.querySelector('.modal-content');
            modalContent.classList.remove('show');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }, 250);
        }
        // Fechar modal ao clicar fora
        document.addEventListener('click', (e) => {
            const modal = document.getElementById('infoModal');
            if (modal && !modal.classList.contains('hidden') && e.target === modal) {
                closeInfoModal();
            }
        });
    </script>
</body>

</html>
