<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 13 - Sala Temática</title>
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
        
        .modal-bg {
            background: linear-gradient(145deg, rgba(25, 25, 25, 0.98) 0%, rgba(15, 15, 15, 0.98) 100%);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
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

        .range-slider {
            -webkit-appearance: none;
            appearance: none;
            height: 8px;
            border-radius: 5px;
            background: linear-gradient(90deg, #333 0%, #666 100%);
            outline: none;
        }

        .range-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--header-color) 0%, var(--accent-color) 100%);
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 179, 72, 0.4);
        }

        .range-slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--header-color) 0%, var(--accent-color) 100%);
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 179, 72, 0.4);
        }

        select.input-field {
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%) !important;
            color: var(--text-color) !important;
            border: 1px solid rgba(255,255,255,0.12);
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 2.5rem;
        }
        
        select.input-field option {
            color: #222 !important;
        }

        /* ===== HEADER NOVO - INÍCIO ===== */
        .container-responsive {
            width: 100%;
            max-width: none;
            padding: 0 clamp(1rem, 4vw, 2rem);
        }
        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            width: 100%;
        }
        .header-title-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .header-title-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
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
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            font-weight: 600;
            color: #e5e7eb;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.08);
        }
        .user-chip-desktop {
            position: absolute;
            top: 0;
            right: 0;
        }
        @media (max-width: 640px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            .user-chip-desktop {
                position: relative;
                top: auto;
                right: auto;
            }
            .header-title-section {
                align-items: center;
            }
        }
        /* Títulos responsivos */
        .main-title {
            font-size: clamp(1.5rem, 6vw, 2.5rem);
            line-height: 1.2;
        }
        /* ===== HEADER NOVO - FIM ===== */
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="header-bg">
        <div class="container-responsive py-4">
            <div class="header-content">
                <!-- Título e Logo Centralizados -->
                <div class="header-title-section">
                    <div class="header-title-row">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 via-emerald-600 to-green-700 flex items-center justify-center pulse-glow">
                            <i class="fas fa-door-open text-white text-lg"></i>
                        </div>
                        <h1 class="main-title font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                            TAREFA 13
                        </h1>
                    </div>
                    <p class="text-gray-400 text-xs font-medium tracking-wider uppercase">Sala Temática</p>
                </div>
                
                <!-- Chip do Usuário - Posicionado à direita no desktop -->
                <div class="user-chip user-chip-desktop">
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                        <i class="fas fa-user text-green-300 text-xs"></i>
                    </div>
                    <span class="text-gray-100">João Silva</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 py-8">
        <!-- Cadastro Section -->
        <section class="mb-12">
            <div class="card-bg rounded-3xl p-8 fade-in">
                <div class="flex items-center gap-3 mb-8">
                    <i class="fas fa-plus-circle text-2xl" style="color: var(--header-color);"></i>
                    <h2 class="text-2xl font-bold">Cadastrar Sala Temática</h2>
                </div>
                
                <form id="salaForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-heading mr-2"></i>Nome da Sala
                            </label>
                            <input type="text" id="nomeSala" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-graduation-cap mr-2"></i>Curso Responsável
                            </label>
                            <select id="cursoSala" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                                <option value="">Selecione o curso</option>
                                <option value="Enfermagem">Enfermagem</option>
                                <option value="Informática">Informática</option>
                                <option value="Meio ambiente">Meio ambiente</option>
                                <option value="Administração">Administração</option>
                                <option value="Edificações">Edificações</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-users mr-2"></i>Equipe Responsável (separar nomes por vírgula)
                        </label>
                        <textarea id="equipeSala" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="2"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-tags mr-2"></i>Tema da Sala
                        </label>
                        <input type="text" id="temaSala" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-align-left mr-2"></i>Descrição da Sala
                        </label>
                        <textarea id="descricaoSala" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="4" required></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-tools mr-2"></i>Recursos Utilizados
                            </label>
                            <textarea id="recursosSala" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-bullseye mr-2"></i>Objetivos
                            </label>
                            <textarea id="objetivosSala" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary px-8 py-3 rounded-2xl font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Cadastrar Sala
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Salas Grid -->
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <i class="fas fa-list text-2xl" style="color: var(--header-color);"></i>
                <h2 class="text-2xl font-bold">Salas Cadastradas</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="salasList">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <!-- Votação Modal -->
        <div id="votacaoModal" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
            <div class="modal-bg rounded-3xl p-8 w-full max-w-4xl mx-4 slide-up max-h-[90vh] overflow-y-auto">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                        <i class="fas fa-vote-yea text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold">Votar na Sala</h2>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2" id="salaVotando"></h3>
                    <p class="text-sm text-gray-400" id="descricaoVotando"></p>
                </div>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-3">🎯 Adequação ao Tema Proposto (0-20 pontos)</label>
                        <input type="range" id="adequacao" min="0" max="20" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="adequacaoValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>20</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Foco temático, pertinência e coerência com a proposta geral do evento</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-3">🧠 Qualidade do Conteúdo Apresentado (0-20 pontos)</label>
                        <input type="range" id="conteudo" min="0" max="20" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="conteudoValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>20</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Rigor informativo, valor educativo e conexão crítica</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-3">🖼 Ambientação e Criatividade (0-15 pontos)</label>
                        <input type="range" id="ambientacao" min="0" max="15" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="ambientacaoValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>15</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Estética, criatividade e esforço na construção do ambiente</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-3">󰠅 Didática e Clareza na Apresentação Oral (0-15 pontos)</label>
                        <input type="range" id="didatica" min="0" max="15" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="didaticaValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>15</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Comunicação, domínio do tema e interação com os visitantes</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-3">🤝 Trabalho em Equipe e Organização (0-15 pontos)</label>
                        <input type="range" id="equipe" min="0" max="15" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="equipeValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>15</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Organização e cooperação entre os alunos</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-3">♻️ Sustentabilidade na Execução (0-15 pontos)</label>
                        <input type="range" id="sustentabilidade" min="0" max="15" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="sustentabilidadeValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>15</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Coerência entre discurso e prática sustentável</p>
                    </div>
                </div>
                
                <div class="mt-8 p-6 bg-gray-800/50 rounded-2xl">
                    <h4 class="text-lg font-semibold mb-2">Pontuação Total: <span id="totalPontos" class="text-yellow-400 text-2xl font-bold">0</span>/100</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium mb-3">Nome do Avaliador</label>
                        <input type="text" id="nomeAvaliador" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-3">Observações</label>
                        <textarea id="observacoes" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 pt-8">
                    <button onclick="salvarVoto()" class="btn-primary flex-1 py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                        <i class="fas fa-vote-yea"></i>
                        Registrar Voto
                    </button>
                    <button onclick="fecharVotacao()" class="btn-secondary flex-1 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                </div>
            </div>
        </div>

        <!-- Relatórios Section -->
        <section class="text-center space-y-6">
            <div class="flex items-center justify-center gap-3 mb-8">
                <i class="fas fa-chart-line text-2xl" style="color: var(--accent-color);"></i>
                <h2 class="text-2xl font-bold">Relatórios Detalhados</h2>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="gerarRelatorioGeral()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-file-alt"></i>
                    Relatório Geral
                </button>
                <button onclick="gerarRanking()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-trophy"></i>
                    Ranking Final
                </button>
                <button onclick="calcularPontuacao()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-medal"></i>
                    Pontuação por Posição
                </button>
            </div>
        </section>
    </main>

    <script>
        let salas = JSON.parse(localStorage.getItem('salas_tematicas') || '[]');
        let votos = JSON.parse(localStorage.getItem('votos_salas') || '[]');
        let salaAtual = null;

        const cursoColors = {
            'Informática': 'from-blue-500 to-cyan-600',
            'Enfermagem': 'from-red-500 to-pink-600',
            'Administração': 'from-purple-500 to-indigo-600',
            'Agropecuária': 'from-green-500 to-emerald-600'
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderSalas();
            
            // Form submission
            document.getElementById('salaForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const sala = {
                    id: Date.now(),
                    nome: document.getElementById('nomeSala').value,
                    curso: document.getElementById('cursoSala').value,
                    equipe: document.getElementById('equipeSala').value,
                    tema: document.getElementById('temaSala').value,
                    descricao: document.getElementById('descricaoSala').value,
                    recursos: document.getElementById('recursosSala').value,
                    objetivos: document.getElementById('objetivosSala').value,
                    timestamp: new Date().toISOString()
                };
                
                salas.push(sala);
                localStorage.setItem('salas_tematicas', JSON.stringify(salas));
                
                this.reset();
                renderSalas();
                
                showNotification('Sala cadastrada com sucesso!', 'success');
            });

            // Atualizar valores dos sliders
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.addEventListener('input', function() {
                    document.getElementById(this.id + 'Value').textContent = this.value + ' pontos';
                    calcularTotal();
                });
            });
        });

        function renderSalas() {
            const container = document.getElementById('salasList');
            container.innerHTML = '';
            
            if (salas.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-20">
                        <div class="w-32 h-32 mx-auto mb-8 rounded-3xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center">
                            <i class="fas fa-door-open text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-300 mb-4">Nenhuma sala cadastrada</h3>
                        <p class="text-gray-400 mb-8 text-lg">Adicione a primeira sala para começar</p>
                    </div>
                `;
                return;
            }
            
            salas.forEach(sala => {
                const votosSala = votos.filter(v => v.salaId === sala.id);
                const mediaNotas = votosSala.length > 0 
                    ? (votosSala.reduce((sum, v) => sum + v.total, 0) / votosSala.length).toFixed(1)
                    : 'Não avaliado';
                
                const card = document.createElement('div');
                card.className = 'card-bg rounded-3xl p-6 card-hover transition-all duration-300 fade-in';
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br ${cursoColors[sala.curso] || 'from-gray-600 to-gray-700'} flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-door-open text-white text-xl"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xl font-bold text-white mb-1">${sala.nome}</h3>
                                <p class="text-sm text-gray-400 font-medium">${sala.curso}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-gray-400 text-sm">Tema:</span>
                            <p class="text-gray-300 text-sm mt-1 font-semibold">${sala.tema}</p>
                        </div>
                        
                        <div>
                            <span class="text-gray-400 text-sm">Equipe:</span>
                            <p class="text-gray-300 text-sm mt-1">${sala.equipe || 'Não informado'}</p>
                        </div>
                        
                        <div>
                            <span class="text-gray-400 text-sm">Descrição:</span>
                            <p class="text-gray-300 text-sm mt-1">${sala.descricao.substring(0, 100)}${sala.descricao.length > 100 ? '...' : ''}</p>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300 font-semibold">Média de Votos</span>
                            <span class="text-2xl font-bold" style="color: var(--accent-color);">${mediaNotas}</span>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-xs text-gray-400 mb-3">Votos: ${votosSala.length}</p>
                            <button onclick="votarSala(${sala.id})" 
                                    class="btn-primary w-full py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                                <i class="fas fa-vote-yea"></i>
                                Votar
                            </button>
                        </div>
                    </div>
                `;
                
                container.appendChild(card);
            });
        }

        function votarSala(id) {
            salaAtual = salas.find(s => s.id === id);
            document.getElementById('salaVotando').textContent = 
                `${salaAtual.nome} (${salaAtual.curso})`;
            document.getElementById('descricaoVotando').textContent = salaAtual.descricao;
            
            // Reset form
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.value = 0;
                document.getElementById(slider.id + 'Value').textContent = '0 pontos';
            });
            document.getElementById('nomeAvaliador').value = '';
            document.getElementById('observacoes').value = '';
            calcularTotal();
            
            document.getElementById('votacaoModal').classList.remove('hidden');
            document.getElementById('votacaoModal').classList.add('flex');
        }

        function calcularTotal() {
            const criatividade = parseInt(document.getElementById('adequacao').value);
            const conteudo = parseInt(document.getElementById('conteudo').value);
            const organizacao = parseInt(document.getElementById('ambientacao').value);
            const interatividade = parseInt(document.getElementById('didatica').value);
            const impactoVisual = parseInt(document.getElementById('equipe').value);
            const sustentabilidade = parseInt(document.getElementById('sustentabilidade').value);
            
            const total = criatividade + conteudo + organizacao + interatividade + impactoVisual + sustentabilidade;
            document.getElementById('totalPontos').textContent = total;
        }

        function salvarVoto() {
            if (!salaAtual || !document.getElementById('nomeAvaliador').value) {
                showNotification('Preencha o nome do avaliador!', 'error');
                return;
            }
            
            const voto = {
                id: Date.now(),
                salaId: salaAtual.id,
                avaliador: document.getElementById('nomeAvaliador').value,
                criatividade: parseInt(document.getElementById('adequacao').value),
                conteudo: parseInt(document.getElementById('conteudo').value),
                organizacao: parseInt(document.getElementById('ambientacao').value),
                interatividade: parseInt(document.getElementById('didatica').value),
                impactoVisual: parseInt(document.getElementById('equipe').value),
                sustentabilidade: parseInt(document.getElementById('sustentabilidade').value),
                total: parseInt(document.getElementById('totalPontos').textContent),
                observacoes: document.getElementById('observacoes').value,
                timestamp: new Date().toISOString()
            };
            
            votos.push(voto);
            localStorage.setItem('votos_salas', JSON.stringify(votos));
            
            showNotification('Voto registrado com sucesso!', 'success');
            fecharVotacao();
            renderSalas();
        }

        function fecharVotacao() {
            document.getElementById('votacaoModal').classList.add('hidden');
            document.getElementById('votacaoModal').classList.remove('flex');
            salaAtual = null;
        }

        function gerarRelatorioGeral() {
            let relatorio = 'RELATÓRIO GERAL - SALAS TEMÁTICAS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            salas.forEach(sala => {
                const votosSala = votos.filter(v => v.salaId === sala.id);
                relatorio += `SALA: ${sala.nome}\n`;
                relatorio += `Curso: ${sala.curso}\n`;
                relatorio += `Tema: ${sala.tema}\n`;
                relatorio += `Equipe: ${sala.equipe}\n`;
                relatorio += `Descrição: ${sala.descricao}\n`;
                relatorio += `Recursos: ${sala.recursos}\n`;
                relatorio += `Objetivos: ${sala.objetivos}\n\n`;
                
                if (votosSala.length > 0) {
                    relatorio += 'VOTOS RECEBIDOS:\n';
                    votosSala.forEach(voto => {
                        relatorio += `  Avaliador: ${voto.avaliador}\n`;
                        relatorio += `  Criatividade: ${voto.criatividade}/20\n`;
                        relatorio += `  Conteúdo: ${voto.conteudo}/20\n`;
                        relatorio += `  Organização: ${voto.organizacao}/15\n`;
                        relatorio += `  Interatividade: ${voto.interatividade}/15\n`;
                        relatorio += `  Impacto Visual: ${voto.impactoVisual}/15\n`;
                        relatorio += `  Sustentabilidade: ${voto.sustentabilidade}/15\n`;
                        relatorio += `  TOTAL: ${voto.total}/100\n`;
                        if (voto.observacoes) {
                            relatorio += `  Observações: ${voto.observacoes}\n`;
                        }
                        relatorio += '\n';
                    });
                    
                    const media = (votosSala.reduce((sum, v) => sum + v.total, 0) / votosSala.length).toFixed(2);
                    relatorio += `MÉDIA FINAL: ${media}/100\n`;
                } else {
                    relatorio += 'Não avaliado\n';
                }
                
                relatorio += '-'.repeat(40) + '\n\n';
            });
            
            downloadFile(relatorio, 'relatorio_salas_tematicas.txt');
        }

        function gerarRanking() {
            const ranking = salas.map(sala => {
                const votosSala = votos.filter(v => v.salaId === sala.id);
                const media = votosSala.length > 0 
                    ? votosSala.reduce((sum, v) => sum + v.total, 0) / votosSala.length
                    : 0;
                
                return {
                    ...sala,
                    media: media,
                    totalVotos: votosSala.length
                };
            }).sort((a, b) => b.media - a.media);
            
            let relatorio = 'RANKING FINAL - SALAS TEMÁTICAS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            ranking.forEach((sala, index) => {
                relatorio += `${index + 1}º LUGAR\n`;
                relatorio += `Sala: ${sala.nome}\n`;
                relatorio += `Curso: ${sala.curso}\n`;
                relatorio += `Tema: ${sala.tema}\n`;
                relatorio += `Equipe: ${sala.equipe}\n`;
                relatorio += `Média: ${sala.media.toFixed(2)}/100\n`;
                relatorio += `Votos: ${sala.totalVotos}\n\n`;
            });
            
            downloadFile(relatorio, 'ranking_salas_tematicas.txt');
        }

        function calcularPontuacao() {
            const ranking = salas.map(sala => {
                const votosSala = votos.filter(v => v.salaId === sala.id);
                const media = votosSala.length > 0 
                    ? votosSala.reduce((sum, v) => sum + v.total, 0) / votosSala.length
                    : 0;
                
                return {
                    ...sala,
                    media: media
                };
            }).sort((a, b) => b.media - a.media);
            
            let relatorio = 'PONTUAÇÃO POR POSIÇÃO - SALAS TEMÁTICAS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            const pontuacoes = [1000, 850, 700, 600, 500];
            
            ranking.forEach((sala, index) => {
                const posicao = index + 1;
                const pontos = index < pontuacoes.length ? pontuacoes[index] : 0;
                
                relatorio += `${posicao}º LUGAR - ${pontos} PONTOS\n`;
                relatorio += `Sala: ${sala.nome}\n`;
                relatorio += `Curso: ${sala.curso}\n`;
                relatorio += `Tema: ${sala.tema}\n`;
                relatorio += `Equipe: ${sala.equipe}\n`;
                relatorio += `Média de avaliação: ${sala.media.toFixed(2)}/100\n\n`;
            });
            
            downloadFile(relatorio, 'pontuacao_posicao_salas.txt');
        }

        function downloadFile(content, filename) {
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            a.click();
            URL.revokeObjectURL(url);
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-2xl text-white font-semibold ${
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            } slide-up`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Event listeners
        document.getElementById('votacaoModal').addEventListener('click', function(e) {
            if (e.target === this) fecharVotacao();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!document.getElementById('votacaoModal').classList.contains('hidden')) fecharVotacao();
            }
        });
    </script>
</body>
</html>
