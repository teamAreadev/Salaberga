<?php
// Página de Tarefa 05: Esquete Teatral - Construindo comunidades sustentáveis
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 05 - Esquete Teatral</title>
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
            transition: all 0.3s ease;
        }

        .stats-card {
            background: linear-gradient(145deg, rgba(30, 30, 30, 0.98) 0%, rgba(20, 20, 20, 0.98) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .input-field {
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%);
            color: var(--text-color);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(255, 183, 51, 0.1);
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%);
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

        .status-rehearsal {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
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
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .modal-bg {
            background: linear-gradient(145deg, rgba(25, 25, 25, 0.98) 0%, rgba(15, 15, 15, 0.98) 100%);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
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
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%);
            color: var(--text-color);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 3rem;
            cursor: pointer;
        }

        select.input-field:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(255, 183, 51, 0.1);
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%);
        }

        select.input-field option {
            background-color: #232323 !important;
            color: #fff !important;
        }
        select.input-field option:hover,
        select.input-field option:focus {
            background-color: #ffb733 !important;
            color: #181818 !important;
        }
        select.input-field option:checked {
            background-color: #ffb733 !important;
            color: #181818 !important;
        }

        /* Correção extra para garantir hover visível em todos navegadores */
        select.input-field option:hover, select.input-field:focus option:hover, 
        select.input-field option:active {
            background-color: #ffb733 !important;
            color: #181818 !important;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-up {
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { box-shadow: 0 4px 20px rgba(0, 179, 72, 0.3); }
            to { box-shadow: 0 8px 40px rgba(0, 179, 72, 0.5); }
        }

        .criteria-badge {
            background: linear-gradient(145deg, rgba(40, 40, 40, 0.8) 0%, rgba(30, 30, 30, 0.8) 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--accent-color);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .duration-indicator {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Melhorias de Responsividade */
        @media (max-width: 640px) {
            .header-bg { padding: 1rem 0; }
            .stats-card { padding: 1rem; }
            .card-bg { padding: 1rem; }
            .modal-bg { margin: 0.5rem; padding: 1.5rem; }
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

        /* Custom select */
        .custom-select-wrapper {
            font-family: inherit;
            user-select: none;
        }
        .custom-select-selected {
            background: #232323;
            color: #fff;
            padding: 12px 16px;
            border-radius: 12px;
            border: 2px solid #ffb733;
            cursor: pointer;
        }
        .custom-select-items {
            position: absolute;
            background: #232323;
            border: 2px solid #ffb733;
            border-top: none;
            width: 100%;
            z-index: 99;
            border-radius: 0 0 12px 12px;
            max-height: 250px;
            overflow-y: auto;
        }
        .custom-select-items div {
            padding: 12px 16px;
            color: #fff;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .custom-select-items div:hover, .custom-select-items .same-as-selected {
            background: #ffb733;
            color: #181818;
        }
        .custom-select-hide {
            display: none;
        }
    </style>
</head>

<body class="min-h-screen">
    <!-- Header -->
    <header class="header-bg sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 py-2 sm:py-3 relative">
            <div class="flex flex-col items-start sm:items-center justify-start sm:justify-center gap-2">
                <div class="flex items-start sm:items-center justify-start sm:justify-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-green-500 via-emerald-600 to-green-700 flex items-center justify-center pulse-glow">
                        <i class="fas fa-theater-masks text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent text-left sm:text-center">
                        TAREFA 5
                    </h1>
                </div>
                <p class="text-gray-400 text-xs font-medium tracking-wider uppercase text-left sm:text-center">ESQUETE TEATRAL</p>
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
        <!-- Tema e Informações -->
        <section class="mb-12">
            <!-- Seção removida conforme solicitado -->
        </section>

        <!-- Controls Section -->
        <section class="mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                <div class="lg:col-span-8 space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-1 max-w-md">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input
                                type="text"
                                id="searchInput"
                                placeholder="Buscar curso ou esquete..."
                                class="input-field rounded-2xl pl-12 pr-4 py-3 text-white placeholder-gray-400 focus:outline-none w-full">
                        </div>
                        <button
                            onclick="openAddModal()"
                            class="btn-primary px-6 py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class="fas fa-plus-circle"></i>
                            <span class="hidden sm:inline">Registrar Esquete</span>
                            <span class="sm:hidden">Adicionar</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Esquetes Grid -->
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <i class="fas fa-theater-masks text-2xl" style="color: var(--header-color);"></i>
                <h2 class="text-2xl font-bold">Esquetes por Curso</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="esquetesGrid">
                <!-- Cards serão gerados dinamicamente -->
            </div>
        </section>

        <!-- Relatórios Section -->
        <section class="text-center space-y-6">
            <div class="flex items-center justify-center gap-3 mb-8">
                <i class="fas fa-chart-line text-2xl" style="color: var(--accent-color);"></i>
                <h2 class="text-2xl font-bold">Relatórios e Cronograma</h2>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="openModalResumo('resultados')" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-trophy"></i>
                    Resultados Finais
                </button>
            </div>
        </section>
    </main>

    <!-- Modal Adicionar/Editar Esquete -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="modal-bg rounded-3xl p-8 w-full max-w-2xl mx-4 slide-up max-h-[90vh] overflow-y-auto">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                    <i class="fas fa-theater-masks text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold" id="modalTitle">Registrar Esquete</h2>
            </div>

            <form class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-graduation-cap mr-2"></i>Curso
                        </label>
                        <div class="select-wrapper">
                            <div class="custom-select-wrapper" style="position:relative;max-width:400px;">
                                <div class="custom-select-selected">Selecione o curso</div>
                                <div class="custom-select-items custom-select-hide">
                                    <div>Enfermagem</div>
                                    <div>Informática</div>
                                    <div>Meio Ambiente</div>
                                    <div>Administração</div>
                                    <div>Edificações</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-trophy mr-2"></i>Colocação
                        </label>
                        <div class="select-wrapper">
                            <div class="custom-select-wrapper" style="position:relative;max-width:400px;">
                                <div class="custom-select-selected">Selecione a colocação</div>
                                <div class="custom-select-items custom-select-hide">
                                    <div>1º Lugar - 500 pontos</div>
                                    <div>2º Lugar - 450 pontos</div>
                                    <div>3º Lugar - 400 pontos</div>
                                    <div>4º Lugar - 350 pontos</div>
                                    <div>5º Lugar - 300 pontos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                        <i class="fas fa-heading mr-2"></i>Título da Esquete
                    </label>
                    <input
                        type="text"
                        id="tituloInput"
                        required
                        class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none"
                        placeholder="Digite o título da esquete">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-users mr-2"></i>Nº de Participantes
                        </label>
                        <input
                            type="number"
                            id="participantesInput"
                            min="5"
                            max="10"
                            required
                            class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none"
                            placeholder="5 a 10 estudantes">
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-clock mr-2"></i>Duração (minutos)
                        </label>
                        <input
                            type="number"
                            id="duracaoInput"
                            min="7"
                            max="15"
                            required
                            class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none"
                            placeholder="7 a 15 minutos">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                        <i class="fas fa-align-left mr-2"></i>Sinopse
                    </label>
                    <textarea
                        id="sinopseInput"
                        rows="4"
                        class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none resize-none"
                        placeholder="Descreva brevemente o enredo da esquete e como aborda a temática sustentável..."></textarea>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button
                        type="submit"
                        class="btn-primary flex-1 py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Salvar Esquete
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

    <!-- Modal de Relatórios -->
    <div id="modalResumo" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="modal-bg rounded-3xl p-8 w-full max-w-4xl mx-4 slide-up max-h-[90vh] overflow-y-auto">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold" id="modalResumoTitle">Relatório</h2>
            </div>
            <div id="modalResumoContent" class="text-gray-200">
                <?php if (isset($resultadosFinais) && is_array($resultadosFinais)): ?>
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold mb-4">Classificação Final</h3>
                        <div class="space-y-3">
                            <?php foreach ($resultadosFinais as $resultado): ?>
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-600 to-yellow-500 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl"><?= $resultado['icone'] ?></span>
                                        <span class="font-bold"><?= htmlspecialchars($resultado['curso']) ?></span>
                                    </div>
                                    <span class="font-bold text-xl"><?= htmlspecialchars($resultado['pontos']) ?> pontos</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p>Nenhum resultado disponível.</p>
                <?php endif; ?>
            </div>
            <div class="flex justify-end pt-8">
                <button type="button" onclick="closeModalResumo()" class="btn-secondary px-4 py-2 rounded-2xl font-semibold text-gray-300 flex items-center gap-2">
                    <i class="fas fa-times"></i> Fechar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Funções do Modal
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Registrar Esquete';
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }

        function openEditModal(curso) {
            document.getElementById('modalTitle').textContent = 'Editar Esquete - ' + curso.charAt(0).toUpperCase() + curso.slice(1);
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('modal').classList.remove('flex');
        }

        function openDetailsModal(curso) {
            // Implementar modal de detalhes da esquete
            alert('Detalhes da esquete do curso: ' + curso);
        }

        function openModalResumo(tipo) {
            const modal = document.getElementById('modalResumo');
            const title = document.getElementById('modalResumoTitle');
            const content = document.getElementById('modalResumoContent');
            
            switch(tipo) {
                case 'cronograma':
                    title.textContent = 'Cronograma de Ensaios';
                    content.innerHTML = `
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold mb-4">Horários Disponíveis para Ensaios</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="stats-card rounded-xl p-4">
                                    <h4 class="font-bold text-green-400 mb-2">Segunda a Quinta</h4>
                                    <p class="text-sm text-gray-300">14:00 - 17:00</p>
                                    <p class="text-sm text-gray-300">Salas temáticas disponíveis</p>
                                </div>
                                <div class="stats-card rounded-xl p-4">
                                    <h4 class="font-bold text-blue-400 mb-2">Sexta</h4>
                                    <p class="text-sm text-gray-300">13:00 - 16:00</p>
                                    <p class="text-sm text-gray-300">Auditório principal</p>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                case 'sorteio':
                    title.textContent = 'Ordem de Apresentação';
                    content.innerHTML = `
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold mb-4">Ordem Definida por Sorteio</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg">
                                    <span class="font-bold text-yellow-400">1º</span>
                                    <span>Meio Ambiente - "O Futuro que Queremos"</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg">
                                    <span class="font-bold text-gray-300">2º</span>
                                    <span>Informática - "Tecnologia Verde"</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg">
                                    <span class="font-bold text-orange-400">3º</span>
                                    <span>Enfermagem - "Cuidar do Planeta, Cuidar da Vida"</span>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                case 'resultados':
                    title.textContent = 'Resultados Finais';
                    content.innerHTML = `
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold mb-4">Classificação Final</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-600 to-yellow-500 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl">🥇</span>
                                        <span class="font-bold">Enfermagem</span>
                                    </div>
                                    <span class="font-bold text-xl">500 pontos</span>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-400 to-gray-300 rounded-lg text-black">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl">🥈</span>
                                        <span class="font-bold">Informática</span>
                                    </div>
                                    <span class="font-bold text-xl">450 pontos</span>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-orange-600 to-yellow-600 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl">🥉</span>
                                        <span class="font-bold">Meio Ambiente</span>
                                    </div>
                                    <span class="font-bold text-xl">400 pontos</span>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
            }
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModalResumo() {
            document.getElementById('modalResumo').classList.add('hidden');
            document.getElementById('modalResumo').classList.remove('flex');
        }

        // Event Listeners
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('modalResumo').addEventListener('click', function(e) {
            if (e.target === this) closeModalResumo();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeModalResumo();
            }
        });

        // Função de busca
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            // Implementar lógica de filtro aqui
        });

        // Custom select JS
        document.querySelectorAll('.custom-select-wrapper').forEach(function(wrapper) {
            var selected = wrapper.querySelector('.custom-select-selected');
            var items = wrapper.querySelector('.custom-select-items');
            selected.addEventListener('click', function(e) {
                e.stopPropagation();
                closeAllSelect(this);
                items.classList.toggle('custom-select-hide');
                selected.classList.toggle('custom-select-arrow-active');
            });
            items.querySelectorAll('div').forEach(function(optionDiv) {
                optionDiv.addEventListener('click', function(e) {
                    selected.textContent = this.textContent;
                    items.querySelectorAll('div').forEach(function(d) {
                        d.classList.remove('same-as-selected');
                    });
                    this.classList.add('same-as-selected');
                    items.classList.add('custom-select-hide');
                });
            });
        });
        function closeAllSelect(elmnt) {
            document.querySelectorAll('.custom-select-items').forEach(function(items) {
                if (items.previousElementSibling !== elmnt) {
                    items.classList.add('custom-select-hide');
                }
            });
        }
        document.addEventListener('click', closeAllSelect);
    </script>
</body>
</html>