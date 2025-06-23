<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 11 - Inovação</title>
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
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="header-bg sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 py-2 sm:py-3">
            <div class="text-center">
                <div class="flex items-center justify-center gap-2 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-green-500 via-emerald-600 to-green-700 flex items-center justify-center pulse-glow">
                        <i class="fas fa-lightbulb text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                            TAREFA 11
                        </h1>
                        <p class="text-gray-400 text-xs font-medium tracking-wider uppercase">Inovação</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm">Produtos Úteis à Comunidade Maranguapense</p>
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
                    <h2 class="text-2xl font-bold">Cadastrar Projeto de Inovação</h2>
                </div>
                
                <form id="projetoForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-project-diagram mr-2"></i>Nome do Projeto
                            </label>
                            <input type="text" id="nomeProjeto" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-graduation-cap mr-2"></i>Curso
                            </label>
                            <select id="cursoProjeto" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                                <option value="">Selecione o curso</option>
                                <option value="Informática">Informática</option>
                                <option value="Enfermagem">Enfermagem</option>
                                <option value="Administração">Administração</option>
                                <option value="Agropecuária">Agropecuária</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-users mr-2"></i>Equipe (separar nomes por vírgula)
                        </label>
                        <textarea id="equipeProjeto" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="2" placeholder="João Silva, Maria Santos, Pedro Oliveira"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-align-left mr-2"></i>Descrição do Projeto
                        </label>
                        <textarea id="descricaoProjeto" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="4" required></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Problema que Resolve
                        </label>
                        <textarea id="problemaProjeto" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3" required></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-heart mr-2"></i>Benefícios para a Comunidade
                        </label>
                        <textarea id="beneficiosProjeto" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3" required></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-tools mr-2"></i>Recursos Necessários
                            </label>
                            <textarea id="recursosProjeto" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-microchip mr-2"></i>Tecnologias Utilizadas
                            </label>
                            <textarea id="tecnologiasProjeto" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary px-8 py-3 rounded-2xl font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Cadastrar Projeto
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Projetos Grid -->
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <i class="fas fa-list text-2xl" style="color: var(--header-color);"></i>
                <h2 class="text-2xl font-bold">Projetos Cadastrados</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="projetosList">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <!-- Avaliação Modal -->
        <div id="avaliacaoModal" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
            <div class="modal-bg rounded-3xl p-8 w-full max-w-4xl mx-4 slide-up max-h-[90vh] overflow-y-auto">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold">Avaliar Projeto</h2>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2" id="projetoAvaliando"></h3>
                    <p class="text-sm text-gray-400" id="descricaoAvaliando"></p>
                </div>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-3">💡 Originalidade e Inovação (0-20 pontos)</label>
                        <input type="range" id="originalidade" min="0" max="20" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="originalidadeValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>20</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Grau de inovação, inventividade e criatividade na abordagem</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-3">🧩 Relevância e Aplicabilidade para a Comunidade (0-20 pontos)</label>
                        <input type="range" id="relevancia" min="0" max="20" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="relevanciaValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>20</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Conexão com necessidades reais, impacto direto ou indireto</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-3">⚙️ Viabilidade Técnica (0-15 pontos)</label>
                        <input type="range" id="viabilidade" min="0" max="15" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="viabilidadeValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>15</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Exequibilidade e nível de prototipagem</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-3">🌱 Sustentabilidade e Responsabilidade Socioambiental (0-15 pontos)</label>
                        <input type="range" id="sustentabilidade" min="0" max="15" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="sustentabilidadeValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>15</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Compromisso com o meio ambiente e ética social</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-3">📊 Clareza e Organização da Apresentação (0-10 pontos)</label>
                        <input type="range" id="apresentacao" min="0" max="10" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="apresentacaoValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>10</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Comunicação e domínio do conteúdo</p>
                    </div>
                </div>
                
                <div class="mt-8 p-6 bg-gray-800/50 rounded-2xl">
                    <h4 class="text-lg font-semibold mb-2">Pontuação Total: <span id="totalPontos" class="text-yellow-400 text-2xl font-bold">0</span>/80</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium mb-3">Nome do Jurado</label>
                        <input type="text" id="nomeJurado" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-3">Observações</label>
                        <textarea id="observacoes" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                    </div>
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
                <button onclick="calcularPontuacao()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-medal"></i>
                    Pontuação por Posição
                </button>
            </div>
        </section>
    </main>

    <script>
        let projetos = JSON.parse(localStorage.getItem('projetos_inovacao') || '[]');
        let avaliacoes = JSON.parse(localStorage.getItem('avaliacoes_inovacao') || '[]');
        let projetoAtual = null;

        const cursoColors = {
            'Informática': 'from-blue-500 to-cyan-600',
            'Enfermagem': 'from-red-500 to-pink-600',
            'Administração': 'from-purple-500 to-indigo-600',
            'Agropecuária': 'from-green-500 to-emerald-600'
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderProjetos();
            
            // Form submission
            document.getElementById('projetoForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const projeto = {
                    id: Date.now(),
                    nome: document.getElementById('nomeProjeto').value,
                    curso: document.getElementById('cursoProjeto').value,
                    equipe: document.getElementById('equipeProjeto').value,
                    descricao: document.getElementById('descricaoProjeto').value,
                    problema: document.getElementById('problemaProjeto').value,
                    beneficios: document.getElementById('beneficiosProjeto').value,
                    recursos: document.getElementById('recursosProjeto').value,
                    tecnologias: document.getElementById('tecnologiasProjeto').value,
                    timestamp: new Date().toISOString()
                };
                
                projetos.push(projeto);
                localStorage.setItem('projetos_inovacao', JSON.stringify(projetos));
                
                this.reset();
                renderProjetos();
                
                showNotification('Projeto cadastrado com sucesso!', 'success');
            });

            // Atualizar valores dos sliders
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.addEventListener('input', function() {
                    document.getElementById(this.id + 'Value').textContent = this.value + ' pontos';
                    calcularTotal();
                });
            });
        });

        function renderProjetos() {
            const container = document.getElementById('projetosList');
            container.innerHTML = '';
            
            if (projetos.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-20">
                        <div class="w-32 h-32 mx-auto mb-8 rounded-3xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center">
                            <i class="fas fa-lightbulb text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-300 mb-4">Nenhum projeto cadastrado</h3>
                        <p class="text-gray-400 mb-8 text-lg">Adicione o primeiro projeto para começar</p>
                    </div>
                `;
                return;
            }
            
            projetos.forEach(projeto => {
                const avaliacoesProjeto = avaliacoes.filter(a => a.projetoId === projeto.id);
                const mediaNotas = avaliacoesProjeto.length > 0 
                    ? (avaliacoesProjeto.reduce((sum, a) => sum + a.total, 0) / avaliacoesProjeto.length).toFixed(1)
                    : 'Não avaliado';
                
                const card = document.createElement('div');
                card.className = 'card-bg rounded-3xl p-6 card-hover transition-all duration-300 fade-in';
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br ${cursoColors[projeto.curso] || 'from-gray-600 to-gray-700'} flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-lightbulb text-white text-xl"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xl font-bold text-white mb-1">${projeto.nome}</h3>
                                <p class="text-sm text-gray-400 font-medium">${projeto.curso}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-gray-400 text-sm">Equipe:</span>
                            <p class="text-gray-300 text-sm mt-1">${projeto.equipe || 'Não informado'}</p>
                        </div>
                        
                        <div>
                            <span class="text-gray-400 text-sm">Descrição:</span>
                            <p class="text-gray-300 text-sm mt-1">${projeto.descricao.substring(0, 100)}${projeto.descricao.length > 100 ? '...' : ''}</p>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300 font-semibold">Média de Avaliação</span>
                            <span class="text-2xl font-bold" style="color: var(--accent-color);">${mediaNotas}</span>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-xs text-gray-400 mb-3">Avaliações: ${avaliacoesProjeto.length}</p>
                            <button onclick="avaliarProjeto(${projeto.id})" 
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

        function avaliarProjeto(id) {
            projetoAtual = projetos.find(p => p.id === id);
            document.getElementById('projetoAvaliando').textContent = 
                `${projetoAtual.nome} (${projetoAtual.curso})`;
            document.getElementById('descricaoAvaliando').textContent = projetoAtual.descricao;
            
            // Reset form
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.value = 0;
                document.getElementById(slider.id + 'Value').textContent = '0 pontos';
            });
            document.getElementById('nomeJurado').value = '';
            document.getElementById('observacoes').value = '';
            calcularTotal();
            
            document.getElementById('avaliacaoModal').classList.remove('hidden');
            document.getElementById('avaliacaoModal').classList.add('flex');
        }

        function calcularTotal() {
            const originalidade = parseInt(document.getElementById('originalidade').value);
            const relevancia = parseInt(document.getElementById('relevancia').value);
            const viabilidade = parseInt(document.getElementById('viabilidade').value);
            const sustentabilidade = parseInt(document.getElementById('sustentabilidade').value);
            const apresentacao = parseInt(document.getElementById('apresentacao').value);
            
            const total = originalidade + relevancia + viabilidade + sustentabilidade + apresentacao;
            document.getElementById('totalPontos').textContent = total;
        }

        function salvarAvaliacao() {
            if (!projetoAtual || !document.getElementById('nomeJurado').value) {
                showNotification('Preencha o nome do jurado!', 'error');
                return;
            }
            
            const avaliacao = {
                id: Date.now(),
                projetoId: projetoAtual.id,
                jurado: document.getElementById('nomeJurado').value,
                originalidade: parseInt(document.getElementById('originalidade').value),
                relevancia: parseInt(document.getElementById('relevancia').value),
                viabilidade: parseInt(document.getElementById('viabilidade').value),
                sustentabilidade: parseInt(document.getElementById('sustentabilidade').value),
                apresentacao: parseInt(document.getElementById('apresentacao').value),
                total: parseInt(document.getElementById('totalPontos').textContent),
                observacoes: document.getElementById('observacoes').value,
                timestamp: new Date().toISOString()
            };
            
            avaliacoes.push(avaliacao);
            localStorage.setItem('avaliacoes_inovacao', JSON.stringify(avaliacoes));
            
            showNotification('Avaliação salva com sucesso!', 'success');
            fecharAvaliacao();
            renderProjetos();
        }

        function fecharAvaliacao() {
            document.getElementById('avaliacaoModal').classList.add('hidden');
            document.getElementById('avaliacaoModal').classList.remove('flex');
            projetoAtual = null;
        }

        function gerarRelatorioGeral() {
            let relatorio = 'RELATÓRIO GERAL - PROJETOS DE INOVAÇÃO\n';
            relatorio += '='.repeat(60) + '\n\n';
            // Identificar sugestões para Mostracitec
            const projetosMostracitec = projetos.map(projeto => {
                const avaliacoesProjeto = avaliacoes.filter(a => a.projetoId === projeto.id);
                let mediaViabilidade = 0;
                let mediaSustentabilidade = 0;
                if (avaliacoesProjeto.length > 0) {
                    mediaViabilidade = avaliacoesProjeto.reduce((sum, a) => sum + a.viabilidade, 0) / avaliacoesProjeto.length;
                    mediaSustentabilidade = avaliacoesProjeto.reduce((sum, a) => sum + a.sustentabilidade, 0) / avaliacoesProjeto.length;
                }
                return {
                    id: projeto.id,
                    mediaViabilidade,
                    mediaSustentabilidade
                };
            });
            // Ordenar por soma das médias e pegar os 3 primeiros
            const sugestoesMostracitec = projetosMostracitec
                .sort((a, b) => (b.mediaViabilidade + b.mediaSustentabilidade) - (a.mediaViabilidade + a.mediaSustentabilidade))
                .slice(0, 3)
                .map(p => p.id);
            projetos.forEach(projeto => {
                const avaliacoesProjeto = avaliacoes.filter(a => a.projetoId === projeto.id);
                const destaqueMostracitec = sugestoesMostracitec.includes(projeto.id) ? ' *** SUGESTÃO MOSTRACITEC ***' : '';
                relatorio += `PROJETO: ${projeto.nome}${destaqueMostracitec}\n`;
                relatorio += `Curso: ${projeto.curso}\n`;
                relatorio += `Equipe: ${projeto.equipe}\n`;
                relatorio += `Descrição: ${projeto.descricao}\n`;
                relatorio += `Problema: ${projeto.problema}\n`;
                relatorio += `Benefícios: ${projeto.beneficios}\n`;
                relatorio += `Recursos: ${projeto.recursos}\n`;
                relatorio += `Tecnologias: ${projeto.tecnologias}\n\n`;
                if (avaliacoesProjeto.length > 0) {
                    relatorio += 'AVALIAÇÕES:\n';
                    avaliacoesProjeto.forEach(av => {
                        relatorio += `  Jurado: ${av.jurado}\n`;
                        relatorio += `  Originalidade: ${av.originalidade}/20\n`;
                        relatorio += `  Relevância: ${av.relevancia}/20\n`;
                        relatorio += `  Viabilidade: ${av.viabilidade}/15\n`;
                        relatorio += `  Sustentabilidade: ${av.sustentabilidade}/15\n`;
                        relatorio += `  Apresentação: ${av.apresentacao}/10\n`;
                        relatorio += `  TOTAL: ${av.total}/80\n`;
                        if (av.observacoes) {
                            relatorio += `  Observações: ${av.observacoes}\n`;
                        }
                        relatorio += '\n';
                    });
                    const media = (avaliacoesProjeto.reduce((sum, a) => sum + a.total, 0) / avaliacoesProjeto.length).toFixed(2);
                    relatorio += `MÉDIA FINAL: ${media}/80\n`;
                } else {
                    relatorio += 'Não avaliado\n';
                }
                relatorio += '-'.repeat(40) + '\n\n';
            });
            downloadFile(relatorio, 'relatorio_projetos_inovacao.txt');
        }

        function gerarRanking() {
            // Identificar sugestões para Mostracitec
            const projetosMostracitec = projetos.map(projeto => {
                const avaliacoesProjeto = avaliacoes.filter(a => a.projetoId === projeto.id);
                let mediaViabilidade = 0;
                let mediaSustentabilidade = 0;
                if (avaliacoesProjeto.length > 0) {
                    mediaViabilidade = avaliacoesProjeto.reduce((sum, a) => sum + a.viabilidade, 0) / avaliacoesProjeto.length;
                    mediaSustentabilidade = avaliacoesProjeto.reduce((sum, a) => sum + a.sustentabilidade, 0) / avaliacoesProjeto.length;
                }
                return {
                    id: projeto.id,
                    mediaViabilidade,
                    mediaSustentabilidade
                };
            });
            const sugestoesMostracitec = projetosMostracitec
                .sort((a, b) => (b.mediaViabilidade + b.mediaSustentabilidade) - (a.mediaViabilidade + a.mediaSustentabilidade))
                .slice(0, 3)
                .map(p => p.id);
            const ranking = projetos.map(projeto => {
                const avaliacoesProjeto = avaliacoes.filter(a => a.projetoId === projeto.id);
                const media = avaliacoesProjeto.length > 0 
                    ? avaliacoesProjeto.reduce((sum, a) => sum + a.total, 0) / avaliacoesProjeto.length
                    : 0;
                return {
                    ...projeto,
                    media: media,
                    totalAvaliacoes: avaliacoesProjeto.length
                };
            }).sort((a, b) => b.media - a.media);
            let relatorio = 'RANKING FINAL - PROJETOS DE INOVAÇÃO\n';
            relatorio += '='.repeat(50) + '\n\n';
            ranking.forEach((projeto, index) => {
                const destaqueMostracitec = sugestoesMostracitec.includes(projeto.id) ? ' *** SUGESTÃO MOSTRACITEC ***' : '';
                relatorio += `${index + 1}º LUGAR${destaqueMostracitec}\n`;
                relatorio += `Projeto: ${projeto.nome}\n`;
                relatorio += `Curso: ${projeto.curso}\n`;
                relatorio += `Equipe: ${projeto.equipe}\n`;
                relatorio += `Média: ${projeto.media.toFixed(2)}/80\n`;
                relatorio += `Avaliações: ${projeto.totalAvaliacoes}\n\n`;
            });
            downloadFile(relatorio, 'ranking_projetos_inovacao.txt');
        }

        function calcularPontuacao() {
            const ranking = projetos.map(projeto => {
                const avaliacoesProjeto = avaliacoes.filter(a => a.projetoId === projeto.id);
                const media = avaliacoesProjeto.length > 0 
                    ? avaliacoesProjeto.reduce((sum, a) => sum + a.total, 0) / avaliacoesProjeto.length
                    : 0;
                
                return {
                    ...projeto,
                    media: media
                };
            }).sort((a, b) => b.media - a.media);
            
            let relatorio = 'PONTUAÇÃO POR POSIÇÃO - PROJETOS DE INOVAÇÃO\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            const pontuacoes = [1000, 850, 700, 600, 500];
            
            ranking.forEach((projeto, index) => {
                const posicao = index + 1;
                const pontos = index < pontuacoes.length ? pontuacoes[index] : 0;
                
                relatorio += `${posicao}º LUGAR - ${pontos} PONTOS\n`;
                relatorio += `Projeto: ${projeto.nome}\n`;
                relatorio += `Curso: ${projeto.curso}\n`;
                relatorio += `Equipe: ${projeto.equipe}\n`;
                relatorio += `Média de avaliação: ${projeto.media.toFixed(2)}/80\n\n`;
            });
            
            downloadFile(relatorio, 'pontuacao_posicao_inovacao.txt');
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
