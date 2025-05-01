<?php
require_once('../models/select_model.php');
$select_model = new select_model();
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Gerenciamento de Alunos - Sistema de Estágio">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <title>Gerenciar Alunos - Sistema de Estágio</title>

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
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.36)',
                        'card': '0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -4px RGBA(0, 0, 0, 0.2)'
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

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
                radial-gradient(circle at 10% 20%, rgba(0, 122, 51, 0.03) 0%, rgba(0, 122, 51, 0) 20%),
                radial-gradient(circle at 90% 80%, rgba(255, 165, 0, 0.03) 0%, rgba(255, 165, 0, 0) 20%);
            transition: all 0.3s ease;
        }

        .sidebar {
            background-color: rgba(45, 45, 45, 0.95);
            background-image: linear-gradient(to bottom, #2d2d2d, #222222);
            border-right: 1px solid rgba(0, 122, 51, 0.2);
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
            color: #ffffff;
        }

        .sidebar-link:hover {
            background-color: rgba(0, 122, 51, 0.2);
            color: #00C250;
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background-color: rgba(0, 122, 51, 0.3);
            color: #00FF6B;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 122, 51, 0.15);
        }

        .dashboard-card,
        .table-container {
            background-color: #2d2d2d;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .dashboard-card:hover,
        .table-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 122, 51, 0.2);
        }

        thead {
            background: rgba(35, 35, 35, 0.95);
            backdrop-filter: blur(5px);
        }

        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background-color: rgba(0, 122, 51, 0.1);
        }

        .status-pill,
        .mobile-badge {
            padding: 0.35rem 1rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.3s ease;
        }

        .status-ativo {
            background: linear-gradient(135deg, rgba(0, 194, 80, 0.2) 0%, rgba(0, 122, 51, 0.2) 100%);
            color: #00FF6B;
            border: 1px solid rgba(0, 194, 80, 0.3);
        }

        .status-inativo {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(153, 27, 27, 0.2) 100%);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-estagiando {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%);
            color: #FBBF24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .area-desenvolvimento {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(29, 78, 216, 0.2) 100%);
            color: #93c5fd;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .area-design {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.2) 0%, rgba(126, 34, 206, 0.2) 100%);
            color: #c4b5fd;
            border: 1px solid rgba(168, 85, 247, 0.3);
        }

        .area-midia {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.2) 100%);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .area-redes {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        input,
        select,
        textarea {
            background-color: #232323 !important;
            border-color: #3d3d3d !important;
            color: #ffffff !important;
            padding: 0.75rem 1rem !important;
            width: 100% !important;
            font-size: 0.95rem !important;
            transition: all 0.3s ease !important;
            backdrop-filter: blur(5px) !important;
            -webkit-backdrop-filter: blur(5px) !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1) !important;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #007A33 !important;
            box-shadow: 0 0 0 2px rgba(0, 122, 51, 0.2), inset 0 2px 4px rgba(0, 0, 0, 0.1) !important;
            outline: none !important;
            background-color: rgba(40, 40, 40, 0.9) !important;
        }

        .custom-input::placeholder {
            color: rgba(255, 255, 255, 0.4) !important;
        }

        .search-input-container {
            position: relative;
            transition: all 0.3s ease;
        }

        .search-input-container:focus-within {
            transform: translateY(-2px);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }

        .search-input-container:focus-within .search-icon {
            color: #00C250;
        }

        .custom-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .custom-btn-primary {
            background: linear-gradient(135deg, #007A33 0%, #009940 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 122, 51, 0.3);
        }

        .custom-btn-primary:hover {
            background: linear-gradient(135deg, #00993F 0%, #00B64B 100%);
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(0, 122, 51, 0.4);
        }

        .custom-btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .custom-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .custom-btn:hover::before {
            transform: translateX(100%);
        }

        .btn-icon {
            transition: all 0.3s ease;
            opacity: 0.8;
        }

        .custom-btn:hover .btn-icon {
            transform: translateX(3px);
            opacity: 1;
        }

        .action-bar {
            background-color: rgba(45, 45, 45, 0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .candidatura-modal {
            background: linear-gradient(135deg, rgba(49, 49, 49, 0.95) 0%, rgba(37, 37, 37, 0.95) 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            max-height: 90vh;
            overflow-y: auto;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #3d3d3d;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #007A33;
        }

        .mobile-card {
            background: rgba(45, 45, 45, 0.9);
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 122, 51, 0.2);
            transition: transform 0.3s ease;
        }

        .mobile-card:hover {
            transform: translateY(-4px);
        }

        .mobile-card-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .mobile-card-label {
            font-weight: 500;
            color: #a0aec0;
            font-size: 0.85rem;
        }

        .mobile-card-value {
            font-weight: 400;
            color: #ffffff;
            font-size: 0.85rem;
            text-align: right;
            flex: 1;
        }

        .mobile-card-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .mobile-card-actions button {
            flex: 1;
            padding: 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .mobile-card-actions button.info-btn {
            color: #93c5fd;
        }

        .mobile-card-actions button.edit-btn {
            color: #00FF6B;
        }

        .mobile-card-actions button.delete-btn {
            color: #f87171;
        }

        .mobile-card-actions button:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .table-container.desktop-table th,
        .table-container.desktop-table td {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .table-container.desktop-table .action-icons i {
            font-size: 1.25rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        .slide-up {
            animation: slideUp 0.4s ease-out forwards;
        }

        @media (max-width: 768px) {
            .table-container.desktop-table {
                display: none;
            }

            .mobile-cards-container {
                display: block;
            }

            .mobile-cards-container {
                padding: 0 0.5rem;
            }

            .action-bar {
                padding: 1rem;
            }

            .search-input-container {
                width: 100%;
            }

            .custom-btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
        }

        @media (min-width: 769px) {
            .mobile-cards-container {
                display: none;
            }

            .table-container.desktop-table {
                display: block;
            }
        }
    </style>
</head>

<body class="select-none">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="sidebar w-64 hidden md:block">
            <div class="p-4 flex flex-col h-full">
                <div class="flex items-center gap-2 mb-6">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-10 w-auto">
                    <div>
                        <h1 class="text-lg font-bold text-primary-400">Sistema <span class="text-secondary">STGM</span></h1>
                        <div class="h-0.5 bg-primary-500/20 rounded-full mt-1"></div>
                    </div>
                </div>
                <nav class="flex-1">
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="gerenciar_alunos.php" class="sidebar-link active">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="gerenciar_empresas.php" class="sidebar-link">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="vagas.php" class="sidebar-link">
                        <i class="fas fa-briefcase w-5 mr-3"></i>
                        Vagas
                    </a>
                    <a href="relatorios.php" class="sidebar-link">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        Relatórios
                    </a>
                </nav>
                <div class="mt-auto pt-4 border-t border-gray-700">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Configurações
                    </a>
                    <a href="login.php" class="sidebar-link text-red-400 hover:text-red-300">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        Sair
                    </a>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Toggle -->
        <div class="md:hidden fixed top-4 left-4 z-50">
            <button id="sidebarToggle" class="bg-dark-50 p-2 rounded-lg shadow-md hover:bg-dark-100 transition-all">
                <i class="fas fa-bars text-primary-400"></i>
            </button>
        </div>

        <!-- Mobile Sidebar -->
        <div id="mobileSidebar" class="fixed inset-y-0 left-0 z-40 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden sidebar">
            <div class="p-4 flex flex-col h-full">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-10 w-auto">
                        <h1 class="text-lg font-bold text-primary-400">Sistema <span class="text-secondary">STGM</span></h1>
                    </div>
                    <button id="closeSidebar" class="p-2 text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="flex-1">
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="gerenciar_alunos.php" class="sidebar-link active">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="gerenciar_empresas.php" class="sidebar-link">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="vagas.php" class="sidebar-link">
                        <i class="fas fa-briefcase w-5 mr-3"></i>
                        Vagas
                    </a>
                    <a href="relatorios.php" class="sidebar-link">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        Relatórios
                    </a>
                </nav>
                <div class="mt-auto pt-4 border-t border-gray-700">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Configurações
                    </a>
                    <a href="login.php" class="sidebar-link text-red-400 hover:text-red-300">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        Sair
                    </a>
                </div>
            </div>
        </div>

        <!-- Conteúdo principal -->
        <div class="flex-1 flex flex-col overflow-y-auto bg-dark-400">
            <!-- Header -->
            <header class="bg-dark-50 shadow-md sticky top-0 z-30 border-b border-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <h1 class="text-xl font-bold text-white text-center sm:text-left w-full">Gerenciamento de Alunos</h1>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-400">
                            <i class="fas fa-user-circle mr-1"></i> Admin
                        </span>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6 sm:py-8 w-full">
                <!-- Breadcrumbs -->
                <div class="text-sm text-gray-400 mb-6 flex items-center">
                    <a href="dashboard.php" class="hover:text-primary-400 transition-colors">Dashboard</a>
                    <span class="mx-2 text-gray-600">/</span>
                    <span class="text-white">Gerenciar Alunos</span>
                </div>

                <!-- Actions Bar -->
                <div class="mb-8 action-bar p-4 sm:p-5 fade-in">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="search-input-container relative w-full sm:w-64">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchAluno" placeholder="Buscar aluno..." class="custom-input pl-10 pr-4 py-2.5 w-full">
                        </div>
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 w-full sm:w-auto">
                            <div class="relative">
                                <select id="filterArea" class="custom-input pl-4 pr-10 py-2.5 appearance-none w-full">
                                    <option value="">Todas as áreas</option>
                                    <option value="desenvolvimento">Desenvolvimento</option>
                                    <option value="design">Design</option>
                                    <option value="midia">Mídia</option>
                                    <option value="redes">Redes/Suporte</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                            </div>
                            <div class="relative">
                                <select id="filterStatus" class="custom-input pl-4 pr-10 py-2.5 appearance-none w-full">
                                    <option value="">Todos os status</option>
                                    <option value="ativo">Ativo</option>
                                    <option value="inativo">Inativo</option>
                                    <option value="estagiando">Estagiando</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Desktop -->
                <div class="table-container desktop-table overflow-x-auto slide-up">
                    <table class="min-w-full divide-y divide-gray-700 text-sm">
                        <thead>
                            <tr>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nome</th>
                                <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="alunosTableBody">
                            <?php
                            $dados = $select_model->alunos_aptos();
                            foreach ($dados as $index => $dado) {
                            ?>
                                <tr class="hover:bg-dark-50 transition-colors slide-up" style="animation-delay: <?= $index * 50 ?>ms;">
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-white"><?= htmlspecialchars($dado['nome']) ?></td>
                                    <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium action-icons">
                                        <button onclick="verDetalhes(<?= $dado['id'] ?>)" class="text-blue-400 hover:text-blue-300 mr-2 transition-colors">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <button onclick="editarAluno(<?= $dado['id'] ?>)" class="text-primary-400 hover:text-primary-300 mr-2 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="excluirAluno(<?= $dado['id'] ?>)" class="text-red-500 hover:text-red-400 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Cards Mobile -->
                <div id="alunosMobileCards" class="mobile-cards-container space-y-4">
                    <?php
                    foreach ($dados as $dado) {
                        $areaClassOpc1 = $dado['perfil_opc1'] === 'desenvolvimento' ? 'area-desenvolvimento' : ($dado['perfil_opc1'] === 'design' ? 'area-design' : ($dado['perfil_opc1'] === 'midia' ? 'area-midia' : 'area-redes'));
                        $areaClassOpc2 = $dado['perfil_opc2'] === 'desenvolvimento' ? 'area-desenvolvimento' : ($dado['perfil_opc2'] === 'design' ? 'area-design' : ($dado['perfil_opc2'] === 'midia' ? 'area-midia' : 'area-redes'));
                    ?>
                        <div class="mobile-card bg-dark-300 rounded-lg p-4 shadow-md">
                            <div class="mobile-card-item">
                                <span class="mobile-card-label">ID:</span>
                                <span class="mobile-card-value"><?= htmlspecialchars($dado['id']) ?></span>
                            </div>
                            <div class="mobile-card-item">
                                <span class="mobile-card-label">Nome:</span>
                                <span class="mobile-card-value font-medium"><?= htmlspecialchars($dado['nome']) ?></span>
                            </div>
                            <div class="mobile-card-item">
                                <span class="mobile-card-label">Contato:</span>
                                <span class="mobile-card-value"><?= htmlspecialchars($dado['contato'] ?: '-') ?></span>
                            </div>
                            <div class="mobile-card-item">
                                <span class="mobile-card-label">Médias:</span>
                                <span class="mobile-card-value"><?= htmlspecialchars($dado['medias'] ?: '-') ?></span>
                            </div>
                            <div class="mobile-card-item">
                                <span class="mobile-card-label">Email:</span>
                                <span class="mobile-card-value"><?= htmlspecialchars($dado['email'] ?: '-') ?></span>
                            </div>
                            <div class="mobile-card-item">
                                <span class="mobile-card-label">Projetos:</span>
                                <span class="mobile-card-value"><?= htmlspecialchars($dado['projetos'] ?: '-') ?></span>
                            </div>
                            <div class="mobile-card-item">
                                <span class="mobile-card-label">Opção 1:</span>
                                <span class="mobile-card-value">
                                    <span class="status-pill <?= $areaClassOpc1 ?>">
                                        <i class="fas fa-<?= $dado['perfil_opc1'] === 'desenvolvimento' ? 'code' : ($dado['perfil_opc1'] === 'design' ? 'paint-brush' : ($dado['perfil_opc1'] === 'midia' ? 'video' : 'network-wired')) ?> text-xs mr-1"></i>
                                        <?= htmlspecialchars($dado['perfil_opc1']) ?>
                                    </span>
                                </span>
                            </div>
                            <div class="mobile-card-item">
                                <span class="mobile-card-label">Opção 2:</span>
                                <span class="mobile-card-value">
                                    <span class="status-pill <?= $areaClassOpc2 ?>">
                                        <i class="fas fa-<?= $dado['perfil_opc2'] === 'desenvolvimento' ? 'code' : ($dado['perfil_opc2'] === 'design' ? 'paint-brush' : ($dado['perfil_opc2'] === 'midia' ? 'video' : 'network-wired')) ?> text-xs mr-1"></i>
                                        <?= htmlspecialchars($dado['perfil_opc2']) ?>
                                    </span>
                                </span>
                            </div>
                            <div class="mobile-card-item">
                                <span class="mobile-card-label">Ocorrência:</span>
                                <span class="mobile-card-value"><?= htmlspecialchars($dado['ocorrencia'] ?: '-') ?></span>
                            </div>
                            <div class="mobile-card-item">
                                <span class="mobile-card-label">Custeio:</span>
                                <span class="mobile-card-value"><?= $dado['custeio'] == "1" ? 'Sim' : 'Não' ?></span>
                            </div>
                            <div class="mobile-card-actions flex space-x-2 mt-4">
                                <button onclick="verDetalhes(<?= $dado['id'] ?>)" class="info-btn flex-1">
                                    <i class="fas fa-info-circle"></i> Detalhes
                                </button>
                                <button onclick="editarAluno(<?= $dado['id'] ?>)" class="edit-btn flex-1">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button onclick="excluirAluno(<?= $dado['id'] ?>)" class="delete-btn flex-1">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </main>
        </div>

        <!-- Modal de Edição -->
        <div id="alunoModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
            <div class="candidatura-modal rounded-lg p-8 max-w-md w-full mx-4">
                <h2 id="modalTitle" class="text-2xl font-bold mb-6 text-white slide-up">Editar Aluno</h2>
                <form id="alunoForm" class="space-y-4">
                    <input type="hidden" id="alunoId">
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Nome</label>
                        <input type="text" id="alunoNome" class="custom-input mt-1" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Contato</label>
                        <input type="text" id="alunoContato" class="custom-input mt-1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Médias</label>
                        <input type="number" id="alunoMedias" min="0" max="10" step="0.1" class="custom-input mt-1" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" id="alunoEmail" class="custom-input mt-1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Projetos Participados</label>
                        <input type="text" id="alunoProjetos" class="custom-input mt-1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Opção 1</label>
                        <select id="alunoOpc1" class="custom-select mt-1" disabled>
                            <option value="desenvolvimento">Desenvolvimento</option>
                            <option value="design">Design</option>
                            <option value="midia">Mídia</option>
                            <option value="redes">Redes/Suporte</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Opção 2</label>
                        <select id="alunoOpc2" class="custom-select mt-1" disabled>
                            <option value="desenvolvimento">Desenvolvimento</option>
                            <option value="design">Design</option>
                            <option value="midia">Mídia</option>
                            <option value="redes">Redes/Suporte</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Ocorrência</label>
                        <input type="text" id="alunoOcorrencia" class="custom-input mt-1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Custeio</label>
                        <select id="alunoCusteio" class="custom-select mt-1">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" id="cancelarBtn" class="custom-btn custom-btn-secondary">
                            <i class="fas fa-times btn-icon"></i>
                            <span>Cancelar</span>
                        </button>
                        <button type="submit" class="custom-btn custom-btn-primary">
                            <i class="fas fa-save btn-icon"></i>
                            <span>Salvar Alterações</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal de Detalhes -->
        <div id="detalhesModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
            <div class="candidatura-modal rounded-lg p-8 max-w-md w-full mx-4">
                <h2 class="text-2xl font-bold mb-6 text-white slide-up">Detalhes do Aluno</h2>
                <div id="detalhesContent" class="space-y-4 text-sm">
                    <!-- Conteúdo será preenchido via JavaScript -->
                </div>
                <div class="mt-6 flex justify-end">
                    <button id="fecharDetalhesBtn" class="custom-btn custom-btn-secondary">
                        <i class="fas fa-times btn-icon"></i>
                        <span>Fechar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dados dos alunos
        let alunos = [
            <?php foreach ($dados as $dado) { ?>

                id: <?= $dado['id'] ?>,
                nome: "<?= addslashes($dado['nome']) ?>",
                contato: "<?= addslashes($dado['contato'] ?: '-') ?>",
                medias: "<?= addslashes($dado['medias'] ?: '-') ?>",
                email: "<?= addslashes($dado['email'] ?: '-') ?>",
                projetos: "<?= addslashes($dado['projetos'] ?: '-') ?>",
                perfil_opc1: "<?= addslashes($dado['perfil_opc1']) ?>",
                perfil_opc2: "<?= addslashes($dado['perfil_opc2']) ?>",
                ocorrencia: "<?= addslashes($dado['ocorrencia'] ?: '-') ?>",
                custeio: <?= $dado['custeio'] ?>

            <?php } ?>
        ];

        // Função para renderizar a tabela de alunos (desktop)
        function renderizarTabelaDesktop(alunosFiltrados = alunos) {
            const tbody = document.getElementById('alunosTableBody');
            tbody.innerHTML = '';

            alunosFiltrados.forEach((aluno, index) => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-dark-50 transition-colors slide-up';
                tr.style.animationDelay = `${index * 50}ms`;
                tr.innerHTML = `
                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-white">${aluno.nome}</td>
                    <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium action-icons">
                        <button onclick="verDetalhes(${aluno.id})" class="text-blue-400 hover:text-blue-300 mr-2 transition-colors">
                            <i class="fas fa-info-circle"></i>
                        </button>
                        <button onclick="editarAluno(${aluno.id})" class="text-primary-400 hover:text-primary-300 mr-2 transition-colors">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="excluirAluno(${aluno.id})" class="text-red-500 hover:text-red-400 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Função para renderizar os cards de alunos (mobile)
        function renderizarCardsMobile(alunosFiltrados = alunos) {
            const container = document.getElementById('alunosMobileCards');
            container.innerHTML = '';

            alunosFiltrados.forEach(aluno => {
                const card = document.createElement('div');
                card.className = 'mobile-card bg-dark-300 rounded-lg p-4 shadow-md';

                const areaClassOpc1 = aluno.perfil_opc1 === 'desenvolvimento' ? 'area-desenvolvimento' :
                    aluno.perfil_opc1 === 'design' ? 'area-design' :
                    aluno.perfil_opc1 === 'midia' ? 'area-midia' :
                    'area-redes';
                const areaClassOpc2 = aluno.perfil_opc2 === 'desenvolvimento' ? 'area-desenvolvimento' :
                    aluno.perfil_opc2 === 'design' ? 'area-design' :
                    aluno.perfil_opc2 === 'midia' ? 'area-midia' :
                    'area-redes';

                card.innerHTML = `
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">ID:</span>
                        <span class="mobile-card-value">${aluno.id}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Nome:</span>
                        <span class="mobile-card-value font-medium">${aluno.nome}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Contato:</span>
                        <span class="mobile-card-value">${aluno.contato}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Médias:</span>
                        <span class="mobile-card-value">${aluno.medias}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Email:</span>
                        <span class="mobile-card-value">${aluno.email}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Projetos:</span>
                        <span class="mobile-card-value">${aluno.projetos}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Opção 1:</span>
                        <span class="mobile-card-value">
                            <span class="status-pill ${areaClassOpc1}">
                                <i class="fas fa-${
                                    aluno.perfil_opc1 === 'desenvolvimento' ? 'code' :
                                    aluno.perfil_opc1 === 'design' ? 'paint-brush' :
                                    aluno.perfil_opc1 === 'midia' ? 'video' :
                                    'network-wired'
                                } text-xs mr-1"></i>
                                ${aluno.perfil_opc1}
                            </span>
                        </span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Opção 2:</span>
                        <span class="mobile-card-value">
                            <span class="status-pill ${areaClassOpc2}">
                                <i class="fas fa-${
                                    aluno.perfil_opc2 === 'desenvolvimento' ? 'code' :
                                    aluno.perfil_opc2 === 'design' ? 'paint-brush' :
                                    aluno.perfil_opc2 === 'midia' ? 'video' :
                                    'network-wired'
                                } text-xs mr-1"></i>
                                ${aluno.perfil_opc2}
                            </span>
                        </span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Ocorrência:</span>
                        <span class="mobile-card-value">${aluno.ocorrencia}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Custeio:</span>
                        <span class="mobile-card-value">${aluno.custeio == 1 ? 'Sim' : 'Não'}</span>
                    </div>
                    <div class="mobile-card-actions flex space-x-2 mt-4">
                        <button onclick="verDetalhes(${aluno.id})" class="info-btn flex-1">
                            <i class="fas fa-info-circle"></i> Detalhes
                        </button>
                        <button onclick="editarAluno(${aluno.id})" class="edit-btn flex-1">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button onclick="excluirAluno(${aluno.id})" class="delete-btn flex-1">
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        // Função para mostrar detalhes do aluno
        function verDetalhes(id) {
            const aluno = alunos.find(a => a.id === id);
            if (aluno) {
                const detalhesContent = document.getElementById('detalhesContent');
                const areaClassOpc1 = aluno.perfil_opc1.toLowerCase();
                const areaClassOpc2 = aluno.perfil_opc2.toLowerCase();
                detalhesContent.innerHTML = `
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">ID:</span>
                        <span class="mobile-card-value">${aluno.id}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Nome:</span>
                        <span class="mobile-card-value font-medium">${aluno.nome}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Contato:</span>
                        <span class="mobile-card-value">${aluno.contato}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Médias:</span>
                        <span class="mobile-card-value">${aluno.medias}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Email:</span>
                        <span class="mobile-card-value">${aluno.email}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Projetos:</span>
                        <span class="mobile-card-value">${aluno.projetos}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Opção 1:</span>
                        <span class="mobile-card-value">
                            <span class="status-pill area-${areaClassOpc1}">
                                <i class="fas fa-${
                                    aluno.perfil_opc1 === 'desenvolvimento' ? 'code' :
                                    aluno.perfil_opc1 === 'design' ? 'paint-brush' :
                                    aluno.perfil_opc1 === 'midia' ? 'video' :
                                    'network-wired'
                                } text-xs mr-1"></i>
                                ${aluno.perfil_opc1}
                            </span>
                        </span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Opção 2:</span>
                        <span class="mobile-card-value">
                            <span class="status-pill area-${areaClassOpc2}">
                                <i class="fas fa-${
                                    aluno.perfil_opc2 === 'desenvolvimento' ? 'code' :
                                    aluno.perfil_opc2 === 'design' ? 'paint-brush' :
                                    aluno.perfil_opc2 === 'midia' ? 'video' :
                                    'network-wired'
                                } text-xs mr-1"></i>
                                ${aluno.perfil_opc2}
                            </span>
                        </span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Ocorrência:</span>
                        <span class="mobile-card-value">${aluno.ocorrencia}</span>
                    </div>
                    <div class="mobile-card-item">
                        <span class="mobile-card-label">Custeio:</span>
                        <span class="mobile-card-value">${aluno.custeio == 1 ? 'Sim' : 'Não'}</span>
                    </div>
                `;
                const modal = document.getElementById('detalhesModal');
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }
        }

        // Função para editar aluno
        function editarAluno(id) {
            const aluno = alunos.find(a => a.id === id);
            if (aluno) {
                document.getElementById('modalTitle').textContent = 'Editar Aluno';
                document.getElementById('alunoId').value = aluno.id;
                document.getElementById('alunoNome').value = aluno.nome;
                document.getElementById('alunoContato').value = aluno.contato;
                document.getElementById('alunoMedias').value = aluno.medias;
                document.getElementById('alunoEmail').value = aluno.email;
                document.getElementById('alunoProjetos').value = aluno.projetos;
                document.getElementById('alunoOpc1').value = aluno.perfil_opc1;
                document.getElementById('alunoOpc2').value = aluno.perfil_opc2;
                document.getElementById('alunoOcorrencia').value = aluno.ocorrencia;
                document.getElementById('alunoCusteio').value = aluno.custeio;

                document.getElementById('alunoNome').disabled = true;
                document.getElementById('alunoMedias').disabled = true;
                document.getElementById('alunoOpc1').disabled = true;
                document.getElementById('alunoOpc2').disabled = true;

                const modal = document.getElementById('alunoModal');
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }
        }

        // Função para excluir aluno
        function excluirAluno(id) {
            if (confirm('Tem certeza que deseja excluir este aluno?')) {
                const index = alunos.findIndex(a => a.id === id);
                if (index !== -1) {
                    alunos.splice(index, 1);
                    aplicarFiltros();
                    alert('Aluno excluído com sucesso!');
                }
            }
        }

        // Sidebar mobile toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const closeSidebar = document.getElementById('closeSidebar');
        const mobileSidebar = document.getElementById('mobileSidebar');

        sidebarToggle.addEventListener('click', () => {
            mobileSidebar.classList.remove('-translate-x-full');
            document.body.style.overflow = 'hidden';
        });

        closeSidebar.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
            document.body.style.overflow = 'auto';
        });

        mobileSidebar.addEventListener('click', (e) => {
            if (e.target === mobileSidebar) {
                mobileSidebar.classList.add('-translate-x-full');
                document.body.style.overflow = 'auto';
            }
        });

        // Modal de Edição
        const modal = document.getElementById('alunoModal');
        const cancelarBtn = document.getElementById('cancelarBtn');
        const alunoForm = document.getElementById('alunoForm');

        cancelarBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }
        });

        alunoForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const id = parseInt(document.getElementById('alunoId').value);
            const alunoIndex = alunos.findIndex(a => a.id === id);
            if (alunoIndex !== -1) {
                alunos[alunoIndex] = {
                    ...alunos[alunoIndex],
                    contato: document.getElementById('alunoContato').value,
                    email: document.getElementById('alunoEmail').value,
                    projetos: document.getElementById('alunoProjetos').value,
                    ocorrencia: document.getElementById('alunoOcorrencia').value,
                    custeio: parseInt(document.getElementById('alunoCusteio').value)
                };
                aplicarFiltros();
                alert('Alterações salvas com sucesso!');
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }
        });

        // Modal de Detalhes
        const detalhesModal = document.getElementById('detalhesModal');
        const fecharDetalhesBtn = document.getElementById('fecharDetalhesBtn');

        fecharDetalhesBtn.addEventListener('click', () => {
            detalhesModal.classList.add('hidden');
            detalhesModal.style.display = 'none';
        });

        detalhesModal.addEventListener('click', (e) => {
            if (e.target === detalhesModal) {
                detalhesModal.classList.add('hidden');
                detalhesModal.style.display = 'none';
            }
        });

        // Busca e Filtros
        function aplicarFiltros() {
            const searchTerm = document.getElementById('searchAluno').value.toLowerCase();
            const areaFiltro = document.getElementById('filterArea').value;
            const statusFiltro = document.getElementById('filterStatus').value;

            const alunosFiltrados = alunos.filter(aluno => {
                const matchSearch = aluno.nome.toLowerCase().includes(searchTerm);
                const matchArea = !areaFiltro || aluno.perfil_opc1 === areaFiltro || aluno.perfil_opc2 === areaFiltro;
                const matchStatus = !statusFiltro || (statusFiltro === 'ativo' && aluno.custeio == 1) || (statusFiltro === 'inativo' && aluno.custeio == 0) || (statusFiltro === 'estagiando' && aluno.ocorrencia.toLowerCase().includes('estagiando'));
                return matchSearch && matchArea && matchStatus;
            });

            renderizarTabelaDesktop(alunosFiltrados);
            renderizarCardsMobile(alunosFiltrados);

            const noResultsMessage = document.getElementById('noResultsMessage');
            if (alunosFiltrados.length === 0 && !noResultsMessage) {
                const message = document.createElement('div');
                message.id = 'noResultsMessage';
                message.className = 'col-span-3 text-center py-8 text-gray-400 fade-in';
                message.innerHTML = `
                    <i class="fas fa-search text-4xl mb-4 text-gray-600 opacity-30"></i>
                    <p class="text-lg">Nenhum aluno encontrado com os filtros atuais.</p>
                    <button id="clearFiltersBtn" class="mt-4 custom-btn custom-btn-secondary">
                        <i class="fas fa-times-circle btn-icon"></i>
                        <span>Limpar Filtros</span>
                    </button>
                `;
                document.getElementById('alunosMobileCards').insertAdjacentElement('afterend', message);
                document.getElementById('clearFiltersBtn').addEventListener('click', () => {
                    document.getElementById('searchAluno').value = '';
                    document.getElementById('filterArea').value = '';
                    document.getElementById('filterStatus').value = '';
                    aplicarFiltros();
                });
            } else if (alunosFiltrados.length > 0 && noResultsMessage) {
                noResultsMessage.remove();
            }
        }

        document.getElementById('searchAluno').addEventListener('input', aplicarFiltros);
        document.getElementById('filterArea').addEventListener('change', aplicarFiltros);
        document.getElementById('filterStatus').addEventListener('change', aplicarFiltros);

        // Inicializar tabela e cards
        renderizarTabelaDesktop();
        renderizarCardsMobile();

        // Verificar tamanho da tela e ajustar renderização
        function checkScreenSize() {
            if (window.innerWidth < 768) {
                document.querySelector('.desktop-table').style.display = 'none';
                document.querySelector('.mobile-cards-container').style.display = 'block';
            } else {
                document.querySelector('.desktop-table').style.display = 'block';
                document.querySelector('.mobile-cards-container').style.display = 'none';
            }
        }

        window.addEventListener('resize', checkScreenSize);
        checkScreenSize();
    </script>
</body>

</html>