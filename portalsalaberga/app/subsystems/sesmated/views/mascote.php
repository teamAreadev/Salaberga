<?php
// Página de Tarefa 03: Mascote do curso
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 03 - Mascote do Curso</title>
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
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(255, 183, 51, 0.1);
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%);
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
        
        select.input-field:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 3px rgba(255, 183, 51, 0.1) !important;
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%) !important;
        }
        
        select.input-field:hover {
            border-color: rgba(255, 183, 51, 0.3) !important;
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%) !important;
        }
        
        select.input-field option {
            background-color: #1a1a1a !important;
            background: #1a1a1a !important;
            color: var(--text-color) !important;
            padding: 0.75rem !important;
            border: none !important;
        }
        
        select.input-field option:hover,
        select.input-field option:focus {
            background-color: #2a2a2a !important;
            background: #2a2a2a !important;
            color: var(--accent-color) !important;
        }
        
        select.input-field option:checked {
            background-color: var(--accent-color) !important;
            background: var(--accent-color) !important;
            color: #000 !important;
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
        
        .points-glow {
            animation: pointsGlow 3s ease-in-out infinite;
        }
        
        @keyframes pointsGlow {
            0%, 100% { 
                box-shadow: 0 4px 20px rgba(255, 183, 51, 0.4);
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 8px 40px rgba(255, 183, 51, 0.6);
                transform: scale(1.05);
            }
        }
        
        /* Estilos para as medalhas de colocação */
        .medal-1st {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #000;
            box-shadow: 0 4px 20px rgba(255, 215, 0, 0.4);
        }
        
        .medal-2nd {
            background: linear-gradient(135deg, #c0c0c0 0%, #e5e5e5 100%);
            color: #000;
            box-shadow: 0 4px 20px rgba(192, 192, 192, 0.4);
        }
        
        .medal-3rd {
            background: linear-gradient(135deg, #cd7f32 0%, #daa520 100%);
            color: #fff;
            box-shadow: 0 4px 20px rgba(205, 127, 50, 0.4);
        }
        
        .medal-4th, .medal-5th {
            background: linear-gradient(135deg, var(--header-color) 0%, #00a040 100%);
            color: #fff;
            box-shadow: 0 4px 20px rgba(0, 179, 72, 0.3);
        }
        
        .criteria-item {
            background: linear-gradient(145deg, rgba(40, 40, 40, 0.6) 0%, rgba(30, 30, 30, 0.6) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 1rem;
            transition: all 0.3s ease;
        }
        
        .criteria-item:hover {
            border-color: rgba(255, 183, 51, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 183, 51, 0.1);
        }
        
        /* Melhorias de Responsividade */
        @media (max-width: 640px) {
            .header-bg { padding: 1rem 0; }
            .card-bg { padding: 1.5rem; }
            .user-chip { font-size: 0.75rem; padding: 0.375rem 0.75rem; }
            .criteria-item { padding: 0.5rem; min-width: 0; }
            .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .hidden-mobile { display: none !important; }
            .btn-primary { min-width: 140px !important; width: auto !important; font-size: 1rem; }
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
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="header-bg sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 py-2 sm:py-3">
            <div class="flex flex-col items-start sm:items-center justify-start sm:justify-center gap-2">
                <div class="flex items-start sm:items-center justify-start sm:justify-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-green-500 via-emerald-600 to-green-700 flex items-center justify-center pulse-glow">
                        <i class="fas fa-paw text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent text-left sm:text-center">
                        TAREFA 3
                    </h1>
                </div>
                <p class="text-gray-400 text-xs font-medium tracking-wider uppercase text-left sm:text-center">Mascote do Curso</p>
            </div>
            <!-- Chip do Usuário -->
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
        <div class="flex flex-col items-center justify-center min-h-[70vh]">
            <div class="card-bg rounded-3xl p-8 sm:p-12 max-w-3xl w-full text-center fade-in">
                
                <!-- Formulário Principal -->
                <form id="mascoteForm" class="space-y-8">
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-yellow-600 flex items-center justify-center">
                            <i class="fas fa-paw text-white text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-3xl sm:text-4xl font-black mb-4 bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                                Mascote do Curso
                            </h2>
                            <p class="text-lg text-gray-300 font-medium">
                                Selecione o curso, a colocação do mascote e veja a pontuação!
                            </p>
                        </div>
                    </div>

                    <!-- Critérios de Avaliação -->
                    <div class="mb-8 hidden-mobile">
                        <div class="flex items-center gap-3 justify-center mb-6">
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                            <span class="text-lg font-bold text-gray-200">Critérios de Avaliação</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="criteria-item">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center">
                                        <i class="fas fa-bolt text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-white mb-1 text-base">Animação</h4>
                                        <p class="text-xs text-gray-400">Energia e carisma</p>
                                    </div>
                                </div>
                            </div>
                            <div class="criteria-item">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                                        <i class="fas fa-tshirt text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-white mb-1 text-base">Vestimenta</h4>
                                        <p class="text-xs text-gray-400">Criatividade visual</p>
                                    </div>
                                </div>
                            </div>
                            <div class="criteria-item">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <i class="fas fa-id-badge text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-white mb-1 text-base">Identidade</h4>
                                        <p class="text-xs text-gray-400">Conexão com curso</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Seletor de Curso -->
                    <div class="mb-8">
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-graduation-cap mr-2"></i>Curso
                        </label>
                        <div class="select-wrapper">
                            <select id="cursoInput" required class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none">
                                <option value="" selected disabled>Selecione o curso</option>
                                <option value="enfermagem">Enfermagem</option>
                                <option value="informatica">Informática</option>
                                <option value="meio-ambiente">Meio Ambiente</option>
                                <option value="administracao">Administração</option>
                                <option value="edificacoes">Edificações</option>
                            </select>
                        </div>
                    </div>

                    <!-- Seletor de Colocação -->
                    <div class="mb-8">
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-trophy mr-2"></i>Colocação
                        </label>
                        <div class="select-wrapper">
                            <select id="colocacaoInput" required class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none">
                                <option value="" selected disabled>Selecione a colocação</option>
                                <option value="1">🥇 1º lugar - 500 pontos</option>
                                <option value="2">🥈 2º lugar - 450 pontos</option>
                                <option value="3">🥉 3º lugar - 400 pontos</option>
                                <option value="4">🏅 4º lugar - 350 pontos</option>
                                <option value="5">🏅 5º lugar - 300 pontos</option>
                            </select>
                        </div>
                    </div>

                    <!-- Painel de Pontuação -->
                    <div id="pontosPainel" class="mt-8 hidden slide-up">
                        <div class="stats-card rounded-2xl p-3 text-center max-w-xs mx-auto">
                            <h3 class="text-xl sm:text-2xl font-black mb-2 text-white">
                                <span id="colocacaoTexto">Colocação</span>
                            </h3>
                            <p class="text-base text-gray-300 mb-2">
                                Curso: <span id="cursoSelecionado" class="font-bold" style="color: var(--accent-color);"></span>
                            </p>
                            <p class="text-xl font-bold text-yellow-400"><span id="pontosMascote">0</span> Pontos</p>
                        </div>
                    </div>

                    <!-- Botão de Envio -->
                    <div class="pt-8 flex justify-center">
                        <button type="submit" class="btn-primary px-6 py-3 rounded-2xl font-bold text-white flex items-center justify-center gap-3 text-lg w-auto min-w-[120px] sm:min-w-[150px]">
                            <i class="fas fa-paper-plane"></i>
                            Confirmar Resultado
                        </button>
                    </div>
                </form>

                <!-- Botão para Voltar -->
                <div id="voltarButton" class="mt-8 hidden">
                    <button onclick="resetForm()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2 mx-auto">
                        <i class="fas fa-arrow-left"></i>
                        Nova Avaliação
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Tela de Sucesso -->
    <div id="sucessoMascote" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
        <div class="card-bg rounded-3xl p-8 max-w-md w-full text-center fade-in">
            <div class="flex flex-col items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-4xl"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-green-400 mb-2">Resultado Registrado!</h2>
                <p class="text-lg text-gray-200">A pontuação do mascote foi computada com sucesso.</p>
            </div>
            <button onclick="fecharSucesso()" class="btn-primary px-6 py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2 mx-auto mt-4">
                <i class="fas fa-arrow-left"></i> Nova Avaliação
            </button>
        </div>
    </div>

    <script>
        const form = document.getElementById('mascoteForm');
        const pontosPainel = document.getElementById('pontosPainel');
        const voltarButton = document.getElementById('voltarButton');
        
        // Mapeamento de pontos por colocação
        const pontosPorColocacao = {
            '1': 500,
            '2': 450,
            '3': 400,
            '4': 350,
            '5': 300
        };

        // Mapeamento de cursos para exibição
        const cursosNomes = {
            'enfermagem': 'Enfermagem',
            'informatica': 'Informática',
            'meio-ambiente': 'Meio Ambiente',
            'administracao': 'Administração',
            'edificacoes': 'Edificações'
        };

        // Mapeamento de colocações
        const colocacaoTextos = {
            '1': '🥇 1º Lugar',
            '2': '🥈 2º Lugar', 
            '3': '🥉 3º Lugar',
            '4': '🏅 4º Lugar',
            '5': '🏅 5º Lugar'
        };

        const colocacaoInput = document.getElementById('colocacaoInput');
        const cursoInput = document.getElementById('cursoInput');
        const pontosMascote = document.getElementById('pontosMascote');
        const pontosDisplay = document.getElementById('pontosDisplay');
        const medalIcon = document.getElementById('medalIcon');
        const colocacaoTexto = document.getElementById('colocacaoTexto');
        const cursoSelecionado = document.getElementById('cursoSelecionado');

        // Atualizar pontuação quando colocação mudar
        colocacaoInput.addEventListener('change', function() {
            const valor = colocacaoInput.value;
            if (pontosPorColocacao[valor]) {
                pontosMascote.textContent = pontosPorColocacao[valor];
                pontosPainel.classList.remove('hidden');
                colocacaoTexto.textContent = colocacaoTextos[valor];
                if (cursoInput.value) {
                    cursoSelecionado.textContent = cursosNomes[cursoInput.value];
                }
            } else {
                pontosPainel.classList.add('hidden');
            }
        });

        // Atualizar curso quando selecionado
        cursoInput.addEventListener('change', function() {
            if (cursoInput.value && colocacaoInput.value) {
                cursoSelecionado.textContent = cursosNomes[cursoInput.value];
            }
        });

        // Submissão do formulário
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const cursoValue = cursoInput.value;
            const colocacaoValue = colocacaoInput.value;
            if (!cursoValue) {
                alert('Por favor, selecione o curso.');
                cursoInput.focus();
                return;
            }
            if (!colocacaoValue) {
                alert('Por favor, selecione a colocação.');
                colocacaoInput.focus();
                return;
            }
            cursoSelecionado.textContent = cursosNomes[cursoValue];
            colocacaoTexto.textContent = colocacaoTextos[colocacaoValue];
            form.style.display = 'none';
            voltarButton.classList.add('hidden');
            document.getElementById('sucessoMascote').classList.remove('hidden');
        });

        function resetForm() {
            // Mostrar formulário novamente
            form.style.display = 'block';
            voltarButton.classList.add('hidden');
            
            // Reset do formulário
            form.reset();
            pontosPainel.classList.add('hidden');
        }

        function fecharSucesso() {
            document.getElementById('sucessoMascote').classList.add('hidden');
            resetForm();
        }
    </script>
</body>
</html>