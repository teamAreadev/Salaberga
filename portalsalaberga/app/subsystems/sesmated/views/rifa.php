<?php
require_once('../models/select.model.php');
$select_model = new select_model();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 1 - Venda de Rifas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --background-color: #0a0a0a;
            --text-color: #ffffff;
            --header-color: #00b348;
            --icon-bg: #2d2d2d;
            --icon-shadow: rgba(0, 0, 0, 0.3);
            --accent-color: #ffb733;
            --grid-color: #333333;
            --card-bg: rgba(30, 30, 30, 0.95);
            --header-bg: rgba(15, 15, 15, 0.98);
            --search-bar-bg: #1a1a1a;
            --card-border-hover: var(--accent-color);
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }

        body {
            background: radial-gradient(ellipse at top, #1a1a1a 0%, #0a0a0a 100%);
            color: var(--text-color);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
        }

        .header-bg {
            background: linear-gradient(135deg, var(--header-bg) 0%, rgba(0, 0, 0, 0.95) 100%);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .card-bg {
            background: linear-gradient(145deg, var(--card-bg) 0%, rgba(25, 25, 25, 0.95) 100%);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .stats-card {
            background: linear-gradient(145deg, rgba(30, 30, 30, 0.98) 0%, rgba(20, 20, 20, 0.98) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .input-field {
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%) !important;
            color: var(--text-color) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 3rem;
            cursor: pointer;
        }

        .input-field:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(255, 183, 51, 0.1);
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%);
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--header-color) 0%, var(--accent-color) 100%);
            box-shadow: 0 2px 10px rgba(0, 179, 72, 0.4);
        }

        .card-hover:hover {
            border-color: rgba(255, 183, 51, 0.3);
            box-shadow: 0 12px 40px rgba(255, 183, 51, 0.15);
            transform: translateY(-4px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--header-color) 0%, #00a040 100%);
            box-shadow: 0 4px 20px rgba(0, 179, 72, 0.3);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            box-shadow: 0 8px 30px rgba(0, 179, 72, 0.4);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(145deg, #2a2a2a 0%, #1a1a1a 100%);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(145deg, #353535 0%, #252525 100%);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        .status-complete {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .status-pending {
            background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .icon-button {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .icon-button:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        .modal-bg {
            background: linear-gradient(145deg, rgba(25, 25, 25, 0.98) 0%, rgba(15, 15, 15, 0.98) 100%);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .section-divider {
            background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.1) 50%, transparent 100%);
            height: 1px;
            margin: 2rem 0;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-up {
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from {
                box-shadow: 0 4px 20px rgba(0, 179, 72, 0.3);
            }

            to {
                box-shadow: 0 8px 40px rgba(0, 179, 72, 0.5);
            }
        }

        /* Estilo customizado para o select */
        .select-wrapper {
            position: relative;
        }
        
        .select-wrapper::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-color);
            pointer-events: none;
            font-size: 0.875rem;
        }
        
        select.input-field {
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%) !important;
            color: var(--text-color) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 3rem;
            cursor: pointer;
        }
        select.input-field option {
            background-color: #181818 !important;
            color: #fff !important;
        }
        select.input-field:focus,
        select.input-field:active {
            background-color: #181818 !important;
            color: #fff !important;
        }
        select.input-field option:checked {
            background-color: #222 !important;
            color: #ffb733 !important;
        }

        /* Melhorias de Responsividade */
        @media (max-width: 640px) {
            .header-bg {
                padding: 1rem 0;
            }

            .stats-card {
                padding: 1rem;
            }

            .card-bg {
                padding: 1rem;
            }

            .icon-button {
                width: 36px;
                height: 36px;
            }

            .modal-bg {
                margin: 0.5rem;
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {

            .status-complete,
            .status-pending {
                font-size: 0.65rem;
                padding: 6px 12px;
            }
        }

        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--header-color), var(--accent-color));
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #00a040, #ff9500);
        }

        /* Estilo customizado para o select */
        select.input-field {
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%) !important;
            color: var(--text-color) !important;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: none;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 2.5rem;
        }

        select.input-field:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(255, 183, 51, 0.1);
        }

        select.input-field option {
            color: #222 !important;
        }

        .user-chip {
            background: linear-gradient(145deg, #232d25 0%, #181f1a 100%);
            border: 1px solid #1f3a26;
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #e5e7eb;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.08);
        }
    </style>
</head>

<body class="min-h-screen">
 
    <header class="header-bg sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 py-2 sm:py-3 relative">
            <div class="flex flex-col items-start sm:items-center justify-start sm:justify-center gap-2">
                <div class="flex items-start sm:items-center justify-start sm:justify-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-green-500 via-emerald-600 to-green-700 flex items-center justify-center pulse-glow">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent text-left sm:text-center">
                        TAREFA 1
                    </h1>
                </div>
                <p class="text-gray-400 text-xs font-medium tracking-wider uppercase text-left sm:text-center">VENDA DE RIFAS</p>
            </div>
            <div class="user-chip absolute top-4 right-4">
                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                    <i class="fas fa-user text-green-300 text-xs"></i>
                </div>
                <span class="text-gray-100">João Silva</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 py-8">
        <!-- Controls Section -->
        <section class="mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                <!-- Search and Add Controls -->
                <div class="lg:col-span-8 space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-1 max-w-md">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input
                                type="text"
                                id="searchInput"
                                placeholder="Buscar turma..."
                                class="input-field rounded-2xl pl-12 pr-4 py-3 text-white placeholder-gray-400 focus:outline-none w-full">
                        </div>
                        <button
                            onclick="openAddModal()"
                            class="btn-primary px-6 py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class="fas fa-plus-circle"></i>
                            <span class="hidden sm:inline">Novo Registro</span>
                            <span class="sm:hidden">Adicionar</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Turmas Grid -->
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <i class="fas fa-users text-2xl" style="color: var(--header-color);"></i>
                <h2 class="text-2xl font-bold">Controle por Turma</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6" id="representativesGrid">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <div class="section-divider"></div>

        <!-- Resumos Section -->
        <section class="text-center space-y-6">
            <div class="flex items-center justify-center gap-3 mb-8">
                <i class="fas fa-chart-line text-2xl" style="color: var(--accent-color);"></i>
                <h2 class="text-2xl font-bold">Relatórios Detalhados</h2>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="openModalResumo('turma')" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-chart-bar"></i>
                    Resumo por Turma
                </button>
                <button onclick="openModalResumo('curso')" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-graduation-cap"></i>
                    Resumo por Curso
                </button>
                <button onclick="openModalTotalArrecadado()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-coins"></i>
                    Total Arrecadado
                </button>
            </div>
        </section>
    </main>

    <!-- Add/Edit Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="modal-bg rounded-3xl p-8 w-full max-w-md mx-4 slide-up max-h-[90vh] overflow-y-auto">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                    <i class="fas fa-user-plus text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold" id="modalTitle">Adicionar Turma</h2>
            </div>

            <form id="representativeForm" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                        <i class="fas fa-users mr-2"></i>Turma
                    </label>
                    <select id="turmaInput" required class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none">
                        <option value="" selected disabled>Selecione a turma</option>
                        <?php
                        $dados = $select_model->select_turma();

                        foreach ($dados as $dado) {
                        ?>
                            <option value="<?=$dado['turma_id']?>"><?=$dado['nome_turma']?> <?=$dado['nome_curso']?></option>

                        <?php } ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                        <i class="fas fa-ticket-alt mr-2"></i>Rifas Vendidas
                    </label>
                    <input
                        type="number"
                        id="rifasInput"
                        min="0"
                        required
                        class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none"
                        placeholder="Quantidade de rifas">
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button
                        type="submit"
                        class="btn-primary flex-1 py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Salvar
                    </button>
                    <button
                        type="button"
                        onclick="closeModal()"
                        class="btn-secondary flex-1 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Detalhes -->
    <div id="modalResumo" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="modal-bg rounded-3xl p-8 w-full max-w-4xl mx-4 slide-up max-h-[90vh] overflow-y-auto">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold" id="modalResumoTitle">Detalhes</h2>
            </div>
            <div id="modalResumoContent" class="text-gray-200"></div>
            <div class="flex justify-end pt-8">
                <button type="button" onclick="closeModalResumo()" class="btn-secondary px-4 py-2 rounded-2xl font-semibold text-gray-300 flex items-center gap-2">
                    <i class="fas fa-times"></i> Fechar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Total Arrecadado -->
    <div id="modalTotalArrecadado" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="modal-bg rounded-3xl p-8 w-full max-w-md mx-4 slide-up max-h-[90vh] overflow-y-auto">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                    <i class="fas fa-coins text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold">Total Arrecadado</h2>
            </div>
            <div class="text-center mb-6">
                <p class="text-lg text-gray-300 mb-2">Total de Rifas Vendidas</p>
                <p class="text-4xl font-black mb-4" style="color: var(--accent-color);" id="modalTotalRifas">0</p>
                <p class="text-lg text-gray-300 mb-2">Valor Total Arrecadado</p>
                <p class="text-4xl font-black" style="color: var(--accent-color);" id="modalTotalValor">R$ 0,00</p>
            </div>
            <div class="flex justify-end pt-4">
                <button type="button" onclick="closeModalTotalArrecadado()" class="btn-secondary px-4 py-2 rounded-2xl font-semibold text-gray-300 flex items-center gap-2">
                    <i class="fas fa-times"></i> Fechar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Data storage
        let turmaRifas = JSON.parse(localStorage.getItem('turmaRifas')) || {};
        let editingIndex = -1;

        // Configurações das turmas e cursos
        const turmaMetas = {
            '1A': 230,
            '2A': 245,
            '3A': 235,
            '1B': 230,
            '2B': 230,
            '3B': 245,
            '1C': 225,
            '3C': 240,
            '2C': 230,
            '1D': 230,
            '2D': 235,
            '3D': 250
        };

        const cursos = {
            'Enfermagem': ['1A', '2A', '3A'],
            'Informática': ['1B', '2B', '3B'],
            'Administração': ['1C', '3C'],
            'Meio Ambiente': ['2C'],
            'Edificações': ['1D', '2D', '3D']
        };

        const cursoColors = {
            'Enfermagem': 'from-red-500 to-pink-600',
            'Informática': 'from-blue-500 to-cyan-600',
            'Administração': 'from-purple-500 to-indigo-600',
            'Meio Ambiente': 'from-green-500 to-emerald-600',
            'Edificações': 'from-orange-500 to-yellow-600'
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderRepresentatives();
            updateTotal();

            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const filtered = Object.keys(turmaRifas).filter(turma => turma.toLowerCase().includes(searchTerm));
                renderRepresentatives(filtered);
            });

            // Form submission
            document.getElementById('representativeForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveRepresentative();
            });
        });

        function renderRepresentatives(data = Object.keys(turmaRifas)) {
            const grid = document.getElementById('representativesGrid');
            grid.innerHTML = '';

            data.forEach((turma, index) => {
                const rifasSold = turmaRifas[turma] || 0;
                const valueEarned = rifasSold * 2;
                const meta = turmaMetas[turma];
                const progress = Math.min((rifasSold / meta) * 100, 100);
                const isComplete = rifasSold >= meta;

                // Determinar curso da turma
                let curso = '';
                Object.keys(cursos).forEach(c => {
                    if (cursos[c].includes(turma)) curso = c;
                });

                const card = document.createElement('div');
                card.className = 'card-bg rounded-3xl p-6 card-hover transition-all duration-300 fade-in';

                card.innerHTML = `
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br ${cursoColors[curso] || 'from-gray-600 to-gray-700'} flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-black text-lg">${turma}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xl font-bold text-white mb-1">Turma ${turma}</h3>
                                <p class="text-sm text-gray-400 font-medium">${curso}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 flex-shrink-0">
                            <button onclick="editRepresentative('${turma}')" 
                                    class="icon-button bg-blue-600 hover:bg-blue-500 text-white">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteRepresentative('${turma}')" 
                                    class="icon-button bg-red-600 hover:bg-red-500 text-white">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="space-y-5">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300 font-semibold">Rifas Vendidas</span>
                            <div class="flex items-center gap-2">
                                <span class="text-3xl font-black ${isComplete ? 'text-green-400' : 'text-yellow-400'}">${rifasSold}</span>
                                <span class="text-gray-400 text-lg">/ ${meta}</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300 font-semibold">Valor Arrecadado</span>
                            <span class="text-2xl font-bold" style="color: var(--accent-color);">R$ ${valueEarned.toFixed(2)}</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400 font-medium">Progresso da Meta</span>
                                <span class="text-gray-400 font-bold">${progress.toFixed(0)}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-4">
                                <div class="progress-bar h-4 rounded-full transition-all duration-700" style="width: ${progress}%"></div>
                            </div>
                        </div>
                        
                        <div class="text-center pt-3">
                            ${isComplete ? 
                                '<span class="status-complete"><i class="fas fa-trophy"></i>Meta Concluída</span>' : 
                                `<span class="status-pending"><i class="fas fa-clock"></i>Faltam ${meta - rifasSold} rifas</span>`
                            }
                        </div>
                    </div>
                `;

                grid.appendChild(card);
            });

            if (data.length === 0) {
                grid.innerHTML = `
                    <div class="col-span-full text-center py-20">
                        <div class="w-32 h-32 mx-auto mb-8 rounded-3xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center">
                            <i class="fas fa-users text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-300 mb-4">Nenhuma turma encontrada</h3>
                        <p class="text-gray-400 mb-8 text-lg">Adicione a primeira turma para começar</p>
                        <button onclick="openAddModal()" class="btn-primary px-6 py-3 rounded-2xl font-semibold text-white">
                            <i class="fas fa-plus mr-2"></i>Adicionar Turma
                        </button>
                    </div>
                `;
            }
        }

        function updateTotal() {
            const totalRifas = Object.values(turmaRifas).reduce((sum, val) => sum + (val || 0), 0);
            const total = totalRifas * 2;
        }

        function openAddModal(turmaEdit = null) {
            editingIndex = turmaEdit;
            document.getElementById('modalTitle').textContent = turmaEdit ? 'Editar Turma' : 'Adicionar Turma';
            document.getElementById('turmaInput').value = turmaEdit || '';
            document.getElementById('rifasInput').value = turmaEdit ? (turmaRifas[turmaEdit] || '') : '';
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');

            setTimeout(() => {
                document.getElementById('turmaInput').focus();
            }, 100);
        }

        function editRepresentative(turma) {
            openAddModal(turma);
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('modal').classList.remove('flex');
        }

        function saveRepresentative() {
            const turma = document.getElementById('turmaInput').value;
            const rifasSold = parseInt(document.getElementById('rifasInput').value) || 0;

            if (!turma) {
                alert('Por favor, selecione a turma.');
                document.getElementById('turmaInput').focus();
                return;
            }

            turmaRifas[turma] = rifasSold;
            localStorage.setItem('turmaRifas', JSON.stringify(turmaRifas));
            renderRepresentatives();
            updateTotal();
            closeModal();
        }

        function deleteRepresentative(turma) {
            if (confirm(`Tem certeza que deseja excluir os dados da turma "${turma}"?`)) {
                delete turmaRifas[turma];
                localStorage.setItem('turmaRifas', JSON.stringify(turmaRifas));
                renderRepresentatives();
                updateTotal();
            }
        }

        function openModalResumo(tipo) {
            let html = '';
            if (tipo === 'turma') {
                html += `
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-600">
                                    <th class="pb-4 text-lg font-bold text-white">Turma</th>
                                    <th class="pb-4 text-lg font-bold text-white">Curso</th>
                                    <th class="pb-4 text-lg font-bold text-white">Meta</th>
                                    <th class="pb-4 text-lg font-bold text-white">Vendidas</th>
                                    <th class="pb-4 text-lg font-bold text-white">Progresso</th>
                                    <th class="pb-4 text-lg font-bold text-white">Pontos</th>
                                </tr>
                            </thead>
                            <tbody class="space-y-2">
                `;
                Object.keys(turmaMetas).forEach(turma => {
                    const vendidas = turmaRifas[turma] || 0;
                    const meta = turmaMetas[turma];
                    const progress = Math.min((vendidas / meta) * 100, 100);
                    const pontos = (vendidas >= meta) ? 500 : 0;
                    let curso = '';
                    Object.keys(cursos).forEach(c => {
                        if (cursos[c].includes(turma)) curso = c;
                    });

                    html += `
                        <tr class="border-b border-gray-700/50 hover:bg-gray-800/30">
                            <td class="py-4 font-bold text-white">${turma}</td>
                            <td class="py-4 text-gray-300">${curso}</td>
                            <td class="py-4 text-gray-300">${meta}</td>
                            <td class="py-4 font-bold ${vendidas >= meta ? 'text-green-400' : 'text-yellow-400'}">${vendidas}</td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 bg-gray-700 rounded-full h-2">
                                        <div class="progress-bar h-2 rounded-full" style="width: ${progress}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-400">${progress.toFixed(0)}%</span>
                                </div>
                            </td>
                            <td class="py-4 font-bold ${pontos > 0 ? 'text-green-400' : 'text-gray-400'}">${pontos}</td>
                        </tr>
                    `;
                });
                html += '</tbody></table></div>';
                document.getElementById('modalResumoTitle').textContent = 'Detalhes por Turma';
            } else if (tipo === 'curso') {
                html += `
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-600">
                                    <th class="pb-4 text-lg font-bold text-white">Curso</th>
                                    <th class="pb-4 text-lg font-bold text-white">Turmas</th>
                                    <th class="pb-4 text-lg font-bold text-white">Meta Total</th>
                                    <th class="pb-4 text-lg font-bold text-white">Vendidas</th>
                                    <th class="pb-4 text-lg font-bold text-white">Valor</th>
                                    <th class="pb-4 text-lg font-bold text-white">Progresso</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                Object.keys(cursos).forEach(curso => {
                    let metaTotal = 0,
                        vendidas = 0;
                    cursos[curso].forEach(turma => {
                        metaTotal += turmaMetas[turma];
                        vendidas += turmaRifas[turma] || 0;
                    });
                    const progress = Math.min((vendidas / metaTotal) * 100, 100);
                    const valor = vendidas * 2;

                    html += `
                        <tr class="border-b border-gray-700/50 hover:bg-gray-800/30">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br ${cursoColors[curso]} flex items-center justify-center">
                                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                                    </div>
                                    <span class="font-bold text-white">${curso}</span>
                                </div>
                            </td>
                            <td class="py-4 text-gray-300">${cursos[curso].join(', ')}</td>
                            <td class="py-4 text-gray-300">${metaTotal}</td>
                            <td class="py-4 font-bold ${vendidas >= metaTotal ? 'text-green-400' : 'text-yellow-400'}">${vendidas}</td>
                            <td class="py-4 font-bold" style="color: var(--accent-color);">R$ ${valor.toFixed(2)}</td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 bg-gray-700 rounded-full h-2">
                                        <div class="progress-bar h-2 rounded-full" style="width: ${progress}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-400">${progress.toFixed(0)}%</span>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                html += '</tbody></table></div>';
                document.getElementById('modalResumoTitle').textContent = 'Detalhes por Curso';
            }
            document.getElementById('modalResumoContent').innerHTML = html;
            document.getElementById('modalResumo').classList.remove('hidden');
            document.getElementById('modalResumo').classList.add('flex');
        }

        function closeModalResumo() {
            document.getElementById('modalResumo').classList.add('hidden');
            document.getElementById('modalResumo').classList.remove('flex');
        }

        // Event listeners
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('modalResumo').addEventListener('click', function(e) {
            if (e.target === this) closeModalResumo();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!document.getElementById('modal').classList.contains('hidden')) closeModal();
                if (!document.getElementById('modalResumo').classList.contains('hidden')) closeModalResumo();
            }
        });

        // Modal Total Arrecadado
        function openModalTotalArrecadado() {
            const totalRifas = Object.values(turmaRifas).reduce((sum, val) => sum + (val || 0), 0);
            const total = totalRifas * 2;
            document.getElementById('modalTotalRifas').textContent = totalRifas;
            document.getElementById('modalTotalValor').textContent = `R$ ${total.toFixed(2)}`;
            document.getElementById('modalTotalArrecadado').classList.remove('hidden');
            document.getElementById('modalTotalArrecadado').classList.add('flex');
        }

        function closeModalTotalArrecadado() {
            document.getElementById('modalTotalArrecadado').classList.add('hidden');
            document.getElementById('modalTotalArrecadado').classList.remove('flex');
        }
        // Fechar modal com ESC e clique fora
        document.getElementById('modalTotalArrecadado').addEventListener('click', function(e) {
            if (e.target === this) closeModalTotalArrecadado();
        });
    </script>
</body>

</html>