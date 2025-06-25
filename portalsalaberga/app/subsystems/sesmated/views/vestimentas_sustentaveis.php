<?php 
require_once('../../../main/models/sessions.php');
$session = new sessions;
$session->autenticar_session();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 08 - Vestimentas Sustentáveis</title>
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
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            min-height: 2.5rem;
            display: flex;
            align-items: center;
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
        select.input-field option {
            background-color: #232323 !important;
            color: #fff !important;
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
        /* ===== HEADER NOVO - FIM ===== */

        /* Títulos responsivos */
        .main-title {
            font-size: clamp(1.5rem, 6vw, 2.5rem);
            line-height: 1.2;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="header-bg">
        <div class="container-responsive py-4">
            <div class="header-content">
                <div class="header-title-section">
                    <div class="header-title-row">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 via-emerald-600 to-green-700 flex items-center justify-center pulse-glow">
                            <i class="fas fa-tshirt text-white text-lg"></i>
                        </div>
                        <h1 class="main-title font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                            TAREFA 8
                        </h1>
                    </div>
                    <p class="text-gray-400 text-xs font-medium tracking-wider uppercase">Vestimentas Sustentáveis</p>
                </div>
                <div class="flex items-center gap-2 user-chip-desktop">
                    <a href="abertura.php" class="btn-secondary px-4 py-2 rounded-2xl font-semibold text-gray-300 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Voltar
                    </a>
                    <div class="user-chip">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                            <i class="fas fa-user text-green-300 text-xs"></i>
                        </div>
                        <span class="text-gray-100">João Silva</span>
                    </div>
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
                    <i class="fas fa-user-plus text-2xl" style="color: var(--header-color);"></i>
                    <h2 class="text-2xl font-bold">Cadastrar Participante</h2>
                </div>
                
                <form id="participantForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-user mr-2"></i>Nome do Modelo
                            </label>
                            <input type="text" id="nomeModelo" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-graduation-cap mr-2"></i>Curso
                            </label>
                            <select id="curso" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                                <option value="">Selecione o curso</option>
                                <option value="Informática">Informática</option>
                                <option value="Enfermagem">Enfermagem</option>
                                <option value="Administração">Administração</option>
                                <option value="Agropecuária">Agropecuária</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-venus-mars mr-2"></i>Gênero
                            </label>
                            <select id="genero" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                                <option value="">Selecione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-palette mr-2"></i>Descrição da Vestimenta
                            </label>
                            <textarea id="descricao" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary px-8 py-3 rounded-2xl font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Cadastrar Participante
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Participantes Grid -->
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <i class="fas fa-users text-2xl" style="color: var(--header-color);"></i>
                <h2 class="text-2xl font-bold">Participantes Cadastrados</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="participantsList">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <!-- Avaliação Modal -->
        <div id="avaliacaoModal" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
            <div class="modal-bg rounded-3xl p-8 w-full max-w-4xl mx-4 slide-up max-h-[90vh] overflow-y-auto">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold" id="avaliacaoTitle">Avaliar Participante</h2>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2" id="participanteAvaliando"></h3>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium mb-3">♻️ Uso de Materiais Sustentáveis (0-20 pontos)</label>
                            <input type="range" id="materiais" min="0" max="20" value="0" class="range-slider w-full">
                            <div class="flex justify-between text-sm mt-2">
                                <span>0</span>
                                <span id="materiaisValue" class="text-yellow-400 font-bold">0 pontos</span>
                                <span>20</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-3">🎨 Criatividade e Design (0-20 pontos)</label>
                            <input type="range" id="criatividade" min="0" max="20" value="0" class="range-slider w-full">
                            <div class="flex justify-between text-sm mt-2">
                                <span>0</span>
                                <span id="criatividadeValue" class="text-yellow-400 font-bold">0 pontos</span>
                                <span>20</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-3">👗 Estética e Harmonia Visual (0-20 pontos)</label>
                            <input type="range" id="estetica" min="0" max="20" value="0" class="range-slider w-full">
                            <div class="flex justify-between text-sm mt-2">
                                <span>0</span>
                                <span id="esteticaValue" class="text-yellow-400 font-bold">0 pontos</span>
                                <span>20</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium mb-3">🎓 Identidade com o Curso (0-15 pontos)</label>
                            <input type="range" id="identidade" min="0" max="15" value="0" class="range-slider w-full">
                            <div class="flex justify-between text-sm mt-2">
                                <span>0</span>
                                <span id="identidadeValue" class="text-yellow-400 font-bold">0 pontos</span>
                                <span>15</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-3">🧍 Desfile e Apresentação (0-15 pontos)</label>
                            <input type="range" id="desfile" min="0" max="15" value="0" class="range-slider w-full">
                            <div class="flex justify-between text-sm mt-2">
                                <span>0</span>
                                <span id="desfileValue" class="text-yellow-400 font-bold">0 pontos</span>
                                <span>15</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-3">🧵 Acabamento e Estrutura (0-10 pontos)</label>
                            <input type="range" id="acabamento" min="0" max="10" value="0" class="range-slider w-full">
                            <div class="flex justify-between text-sm mt-2">
                                <span>0</span>
                                <span id="acabamentoValue" class="text-yellow-400 font-bold">0 pontos</span>
                                <span>10</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 p-6 bg-gray-800/50 rounded-2xl">
                    <h4 class="text-lg font-semibold mb-2">Pontuação Total: <span id="totalPontos" class="text-yellow-400 text-2xl font-bold">0</span>/100</h4>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium mb-3">Nome do Jurado</label>
                    <input type="text" id="nomeJurado" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 pt-8">
                    <button onclick="salvarAvaliacao()" class="btn-primary flex-1 py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Salvar Avaliação
                    </button>
                    <button onclick="fecharAvaliacao()" class="btn-secondary flex-1 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
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
            </div>
        </section>
    </main>

    <script>
        let participantes = JSON.parse(localStorage.getItem('vestimentas_participantes') || '[]');
        let avaliacoes = JSON.parse(localStorage.getItem('vestimentas_avaliacoes') || '[]');
        let participanteAtual = null;

        const cursoColors = {
            'Informática': 'from-blue-500 to-cyan-600',
            'Enfermagem': 'from-red-500 to-pink-600',
            'Administração': 'from-purple-500 to-indigo-600',
            'Agropecuária': 'from-green-500 to-emerald-600'
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderParticipantes();
            
            // Form submission
            document.getElementById('participantForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const participante = {
                    id: Date.now(),
                    nome: document.getElementById('nomeModelo').value,
                    curso: document.getElementById('curso').value,
                    genero: document.getElementById('genero').value,
                    descricao: document.getElementById('descricao').value,
                    timestamp: new Date().toISOString()
                };
                
                participantes.push(participante);
                localStorage.setItem('vestimentas_participantes', JSON.stringify(participantes));
                
                this.reset();
                renderParticipantes();
                
                // Show success message
                showNotification('Participante cadastrado com sucesso!', 'success');
            });

     
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.addEventListener('input', function() {
                    document.getElementById(this.id + 'Value').textContent = this.value + ' pontos';
                    calcularTotal();
                });
            });
        });

        function renderParticipantes() {
            const container = document.getElementById('participantsList');
            container.innerHTML = '';
            
            if (participantes.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-20">
                        <div class="w-32 h-32 mx-auto mb-8 rounded-3xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center">
                            <i class="fas fa-tshirt text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-300 mb-4">Nenhum participante cadastrado</h3>
                        <p class="text-gray-400 mb-8 text-lg">Adicione o primeiro participante para começar</p>
                    </div>
                `;
                return;
            }
            
            participantes.forEach(participante => {
                const avaliacoesParticipante = avaliacoes.filter(a => a.participanteId === participante.id);
                const mediaNotas = avaliacoesParticipante.length > 0 
                    ? (avaliacoesParticipante.reduce((sum, a) => sum + a.total, 0) / avaliacoesParticipante.length).toFixed(1)
                    : 'Não avaliado';
                
                const card = document.createElement('div');
                card.className = 'card-bg rounded-3xl p-6 card-hover transition-all duration-300 fade-in';
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br ${cursoColors[participante.curso] || 'from-gray-600 to-gray-700'} flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user text-white text-xl"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xl font-bold text-white mb-1">${participante.nome}</h3>
                                <p class="text-sm text-gray-400 font-medium">${participante.curso} - ${participante.genero}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-gray-300 font-semibold">Descrição:</span>
                            <p class="text-gray-400 text-sm mt-1">${participante.descricao || 'Não informado'}</p>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300 font-semibold">Média de Avaliação</span>
                            <span class="text-2xl font-bold" style="color: var(--accent-color);">${mediaNotas}</span>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-xs text-gray-400 mb-3">Avaliações: ${avaliacoesParticipante.length}</p>
                            <button onclick="avaliarParticipante(${participante.id})" 
                                    class="btn-primary w-full py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                                <i class="fas fa-star"></i>
                                Avaliar
                            </button>
                        </div>
                    </div>
                `;
                
                container.appendChild(card);
            });
        }

        function avaliarParticipante(id) {
            participanteAtual = participantes.find(p => p.id === id);
            document.getElementById('participanteAvaliando').textContent = 
                `${participanteAtual.nome} (${participanteAtual.curso})`;
            
            // Reset form
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.value = 0;
                document.getElementById(slider.id + 'Value').textContent = '0 pontos';
            });
            document.getElementById('nomeJurado').value = '';
            calcularTotal();
            
            document.getElementById('avaliacaoModal').classList.remove('hidden');
            document.getElementById('avaliacaoModal').classList.add('flex');
        }

        function calcularTotal() {
            const materiais = parseInt(document.getElementById('materiais').value);
            const criatividade = parseInt(document.getElementById('criatividade').value);
            const estetica = parseInt(document.getElementById('estetica').value);
            const identidade = parseInt(document.getElementById('identidade').value);
            const desfile = parseInt(document.getElementById('desfile').value);
            const acabamento = parseInt(document.getElementById('acabamento').value);
            
            const total = materiais + criatividade + estetica + identidade + desfile + acabamento;
            document.getElementById('totalPontos').textContent = total;
        }

        function salvarAvaliacao() {
            if (!participanteAtual || !document.getElementById('nomeJurado').value) {
                showNotification('Preencha o nome do jurado!', 'error');
                return;
            }
            
            const avaliacao = {
                id: Date.now(),
                participanteId: participanteAtual.id,
                jurado: document.getElementById('nomeJurado').value,
                materiais: parseInt(document.getElementById('materiais').value),
                criatividade: parseInt(document.getElementById('criatividade').value),
                estetica: parseInt(document.getElementById('estetica').value),
                identidade: parseInt(document.getElementById('identidade').value),
                desfile: parseInt(document.getElementById('desfile').value),
                acabamento: parseInt(document.getElementById('acabamento').value),
                total: parseInt(document.getElementById('totalPontos').textContent),
                timestamp: new Date().toISOString()
            };
            
            avaliacoes.push(avaliacao);
            localStorage.setItem('vestimentas_avaliacoes', JSON.stringify(avaliacoes));
            
            showNotification('Avaliação salva com sucesso!', 'success');
            fecharAvaliacao();
            renderParticipantes();
        }

        function fecharAvaliacao() {
            document.getElementById('avaliacaoModal').classList.add('hidden');
            document.getElementById('avaliacaoModal').classList.remove('flex');
            participanteAtual = null;
        }

        function gerarRelatorioGeral() {
            let relatorio = 'RELATÓRIO GERAL - VESTIMENTAS SUSTENTÁVEIS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            participantes.forEach(participante => {
                const avaliacoesParticipante = avaliacoes.filter(a => a.participanteId === participante.id);
                relatorio += `PARTICIPANTE: ${participante.nome}\n`;
                relatorio += `Curso: ${participante.curso} | Gênero: ${participante.genero}\n`;
                relatorio += `Descrição: ${participante.descricao}\n\n`;
                
                if (avaliacoesParticipante.length > 0) {
                    relatorio += 'AVALIAÇÕES:\n';
                    avaliacoesParticipante.forEach(av => {
                        relatorio += `  Jurado: ${av.jurado}\n`;
                        relatorio += `  Materiais Sustentáveis: ${av.materiais}/20\n`;
                        relatorio += `  Criatividade: ${av.criatividade}/20\n`;
                        relatorio += `  Estética: ${av.estetica}/20\n`;
                        relatorio += `  Identidade: ${av.identidade}/15\n`;
                        relatorio += `  Desfile: ${av.desfile}/15\n`;
                        relatorio += `  Acabamento: ${av.acabamento}/10\n`;
                        relatorio += `  TOTAL: ${av.total}/100\n\n`;
                    });
                    
                    const media = (avaliacoesParticipante.reduce((sum, a) => sum + a.total, 0) / avaliacoesParticipante.length).toFixed(2);
                    relatorio += `MÉDIA FINAL: ${media}/100\n`;
                } else {
                    relatorio += 'Não avaliado\n';
                }
                
                relatorio += '-'.repeat(30) + '\n\n';
            });
            
            downloadFile(relatorio, 'relatorio_vestimentas_sustentaveis.txt');
        }

        function gerarRanking() {
            const ranking = participantes.map(participante => {
                const avaliacoesParticipante = avaliacoes.filter(a => a.participanteId === participante.id);
                const media = avaliacoesParticipante.length > 0 
                    ? avaliacoesParticipante.reduce((sum, a) => sum + a.total, 0) / avaliacoesParticipante.length
                    : 0;
                
                return {
                    ...participante,
                    media: media,
                    totalAvaliacoes: avaliacoesParticipante.length
                };
            }).sort((a, b) => b.media - a.media);
            
            let relatorio = 'RANKING FINAL - VESTIMENTAS SUSTENTÁVEIS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            ranking.forEach((participante, index) => {
                relatorio += `${index + 1}º LUGAR\n`;
                relatorio += `Nome: ${participante.nome}\n`;
                relatorio += `Curso: ${participante.curso}\n`;
                relatorio += `Média: ${participante.media.toFixed(2)}/100\n`;
                relatorio += `Avaliações: ${participante.totalAvaliacoes}\n\n`;
            });
            
            downloadFile(relatorio, 'ranking_vestimentas_sustentaveis.txt');
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
            // Simple notification system
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
        document.getElementById('avaliacaoModal').addEventListener('click', function(e) {
            if (e.target === this) fecharAvaliacao();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!document.getElementById('avaliacaoModal').classList.contains('hidden')) fecharAvaliacao();
            }
        });
    </script>
</body>
</html>
