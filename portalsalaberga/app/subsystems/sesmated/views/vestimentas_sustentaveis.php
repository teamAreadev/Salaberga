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
            --background-color: #1a1a1a;
            --text-color: #ffffff;
            --header-color: #00b348;
            --icon-bg: #2d2d2d;
            --icon-shadow: rgba(0, 0, 0, 0.3);
            --accent-color: #ffb733;
            --grid-color: #333333;
            --card-bg: rgba(45, 45, 45, 0.9);
            --header-bg: rgba(28, 28, 28, 0.95);
            --mobile-nav-bg: rgba(28, 28, 28, 0.95);
            --search-bar-bg: #2d2d2d;
            --card-border-hover: var(--accent-color);
        }
        
        body {
            background: var(--background-color);
            color: var(--text-color);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
        }
        
        .header-bg {
            background: var(--header-bg);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .card-bg {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .input-field {
            background: var(--search-bar-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
        }
        
        .input-field:focus {
            border-color: var(--header-color);
            box-shadow: 0 0 0 2px rgba(0, 179, 72, 0.1);
            outline: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--header-color) 0%, #00a040 100%);
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 179, 72, 0.3);
        }
        
        .btn-secondary {
            background: #404040;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.2s ease;
        }
        
        .btn-secondary:hover {
            background: #4a4a4a;
            transform: translateY(-1px);
        }

        /* Header Styles */
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
        .main-title {
            font-size: clamp(1.5rem, 6vw, 2.5rem);
            line-height: 1.2;
        }

        select.input-field {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        
        select.input-field option {
            background-color: #2d2d2d;
            color: white;
        }

        /* Modal Styles */
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
        }

        .modal-container {
            background: #1f2937;
            border: 1px solid #374151;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        }

        .modal-header {
            background: #111827;
            border-bottom: 1px solid #374151;
        }

        .participant-card {
            background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .evaluation-section {
            background: #111827;
            border: 1px solid #374151;
        }

        .year-card {
            background: #1f2937;
            border: 1px solid #374151;
            transition: all 0.2s ease;
        }

        .year-card:hover {
            background: #252f3f;
            border-color: #4b5563;
        }

        .score-input {
            background: #374151 !important;
            border: 1px solid #4b5563 !important;
            color: #f9fafb !important;
            transition: all 0.2s ease !important;
        }

        .score-input:focus {
            background: #4b5563 !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        .total-card {
            background: linear-gradient(135deg, #065f46 0%, #047857 100%);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .warning-alert {
            background: rgba(217, 119, 6, 0.1);
            border: 1px solid rgba(217, 119, 6, 0.3);
            color: #f59e0b;
        }

        .jurado-input {
            background: #374151;
            border: 1px solid #4b5563;
            color: #f9fafb;
        }

        .jurado-input:focus {
            background: #4b5563;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        @media (max-width: 768px) {
            .modal-container {
                margin: 1rem;
                max-height: calc(100vh - 2rem);
                width: calc(100vw - 2rem);
            }
        }
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
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 via-emerald-600 to-green-700 flex items-center justify-center">
                            <i class="fas fa-tshirt text-white text-lg"></i>
                        </div>
                        <h1 class="main-title font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                            TAREFA 08
                        </h1>
                    </div>
                    <p class="text-gray-400 text-xs font-medium tracking-wider uppercase">Vestimentas Sustentáveis</p>
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
    <main class="container mx-auto px-4 sm:px-6 py-8 max-w-7xl">
        <!-- Cadastro Section -->
        <section class="mb-12">
            <div class="card-bg rounded-2xl p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                        <i class="fas fa-user-plus text-white text-sm"></i>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold">Cadastrar Participante</h2>
                </div>
                
                <form id="participantForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-3 text-gray-300">
                                Nome do Modelo
                            </label>
                            <input type="text" id="nomeModelo" class="input-field w-full rounded-lg px-4 py-3 text-white" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-3 text-gray-300">
                                Curso
                            </label>
                            <select id="curso" class="input-field w-full rounded-lg px-4 py-3 text-white" required>
                                <option value="">Selecione o curso</option>
                                <option value="Enfermagem">Enfermagem</option>
                                <option value="Informática">Informática</option>
                                <option value="Meio Ambiente">Meio Ambiente</option>
                                <option value="Administração">Administração</option>
                                <option value="Edificações">Edificações</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-3 text-gray-300">
                                Descrição da Vestimenta
                            </label>
                            <textarea id="descricao" class="input-field w-full rounded-lg px-4 py-3 text-white" rows="3" placeholder="Descreva a vestimenta..."></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary px-6 py-3 rounded-lg font-medium text-white flex items-center gap-2">
                            <i class="fas fa-save text-sm"></i>
                            Cadastrar Participante
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Participantes Grid -->
        <section class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold">Participantes Cadastrados</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="participantsList">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <!-- Relatórios Section -->
        <section class="text-center">
            <div class="flex items-center justify-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-sm"></i>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold">Relatórios</h2>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="gerarRelatorioGeral()" class="btn-secondary px-6 py-3 rounded-lg font-medium text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-file-alt text-sm"></i>
                    Relatório Geral
                </button>
                <button onclick="gerarRanking()" class="btn-secondary px-6 py-3 rounded-lg font-medium text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-trophy text-sm"></i>
                    Ranking Final
                </button>
            </div>
        </section>
    </main>

    <!-- Modal de Avaliação -->
    <div id="avaliacaoModal" class="fixed inset-0 modal-backdrop hidden items-center justify-center z-50 p-4">
        <div class="modal-container rounded-2xl w-full max-w-4xl max-h-[95vh] overflow-y-auto">
            <!-- Header do Modal -->
            <div class="modal-header p-6 rounded-t-2xl">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Avaliar Participante</h2>
                        <p class="text-sm text-gray-400 mt-1">Sistema de pontuação por turmas</p>
                    </div>
                </div>
            </div>

            <!-- Conteúdo do Modal -->
            <div class="p-6 space-y-6">
                <!-- Card do Participante -->
                <div class="participant-card p-5 rounded-xl">
                    <h3 class="text-xl font-bold text-white mb-2" id="participanteAvaliando"></h3>
                    <p class="text-blue-100">Distribua a pontuação total de <span class="text-yellow-300 font-bold">500 pontos</span> entre os modelos das turmas</p>
                </div>

                <!-- Seção de Avaliação -->
                <div class="evaluation-section rounded-xl p-6">
                    <div class="text-center mb-6">
                        <h4 class="text-xl font-bold text-white mb-2" id="tabelaTitulo">Tabela de Pontuação</h4>
                        <p class="text-gray-400" id="tabelaSubtitulo">Pontuação máxima: 500 pontos</p>
                    </div>

                    <!-- Container das Turmas -->
                    <div class="space-y-4" id="turmasContainer">
                        <!-- Cards das turmas serão gerados aqui -->
                    </div>

                    <!-- Card do Total -->
                    <div class="total-card p-5 rounded-xl mt-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="text-lg font-bold text-green-100">TOTAL</h4>
                                <p class="text-green-200 text-sm" id="totalModelos">5 MODELOS</p>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-white" id="totalPontuacao">0</div>
                                <div class="text-green-200 text-sm">/ 500</div>
                            </div>
                        </div>
                    </div>

                    <!-- Alerta -->
                    <div class="warning-alert p-4 rounded-xl mt-4">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                            <p class="font-medium">A pontuação total deve somar exatamente 500 pontos</p>
                        </div>
                    </div>
                </div>

                <!-- Seção Inferior -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Input do Jurado -->
                    <div>
                        <label class="block text-sm font-medium mb-3 text-gray-300">
                            <i class="fas fa-user-tie mr-2 text-blue-400"></i>Nome do Jurado
                        </label>
                        <input type="text" id="nomeJurado" class="jurado-input w-full rounded-lg px-4 py-3 focus:outline-none" placeholder="Digite o nome do jurado" required>
                    </div>

                    <!-- Display do Total -->
                    <div class="flex items-end">
                        <div class="total-card w-full p-4 rounded-xl text-center">
                            <p class="text-green-200 text-sm mb-1">Pontuação Total</p>
                            <p class="text-2xl font-bold text-white" id="totalPontuacaoDisplay">0/500</p>
                        </div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button onclick="salvarAvaliacao()" class="btn-primary flex-1 py-4 rounded-xl font-semibold text-white flex items-center justify-center gap-3 text-lg">
                        <i class="fas fa-save"></i>
                        Salvar Avaliação
                    </button>
                    <button onclick="fecharAvaliacao()" class="btn-secondary flex-1 py-4 rounded-xl font-semibold text-gray-300 flex items-center justify-center gap-3 text-lg">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let participantes = JSON.parse(localStorage.getItem('vestimentas_participantes') || '[]');
        let avaliacoes = JSON.parse(localStorage.getItem('vestimentas_avaliacoes') || '[]');
        let participanteAtual = null;

        const cursoColors = {
            'Enfermagem': 'from-red-500 to-pink-600',
            'Informática': 'from-blue-500 to-cyan-600', 
            'Meio Ambiente': 'from-green-500 to-emerald-600',
            'Administração': 'from-purple-500 to-indigo-600',
            'Edificações': 'from-orange-500 to-yellow-600'
        };

        const cursoTurmasPontuacao = {
            'ENFERMAGEM': [
                { ano: '1º ANO', quantidade: 2, pontosPorModelo: 100 },
                { ano: '2º ANO', quantidade: 2, pontosPorModelo: 100 },
                { ano: '3º ANO', quantidade: 1, pontosPorModelo: 100 }
            ],
            'INFORMÁTICA': [
                { ano: '1º ANO', quantidade: 2, pontosPorModelo: 100 },
                { ano: '2º ANO', quantidade: 2, pontosPorModelo: 100 },
                { ano: '3º ANO', quantidade: 1, pontosPorModelo: 100 }
            ],
            'MEIO AMBIENTE': [
                { ano: '2º ANO', quantidade: 2, pontosPorModelo: 250 }
            ],
            'ADMINISTRAÇÃO': [
                { ano: '1º ANO', quantidade: 2, pontosPorModelo: 150 },
                { ano: '3º ANO', quantidade: 1, pontosPorModelo: 200 }
            ],
            'EDIFICAÇÕES': [
                { ano: '1º ANO', quantidade: 2, pontosPorModelo: 100 },
                { ano: '2º ANO', quantidade: 2, pontosPorModelo: 100 },
                { ano: '3º ANO', quantidade: 1, pontosPorModelo: 100 }
            ]
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
                    descricao: document.getElementById('descricao').value,
                    timestamp: new Date().toISOString()
                };
                
                participantes.push(participante);
                localStorage.setItem('vestimentas_participantes', JSON.stringify(participantes));
                
                this.reset();
                renderParticipantes();
                
                showNotification('Participante cadastrado com sucesso!', 'success');
            });
        });

        function renderParticipantes() {
            const container = document.getElementById('participantsList');
            container.innerHTML = '';
            
            if (participantes.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-16">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-2xl bg-gray-700 flex items-center justify-center">
                            <i class="fas fa-tshirt text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-300 mb-2">Nenhum participante cadastrado</h3>
                        <p class="text-gray-400">Adicione o primeiro participante para começar</p>
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
                card.className = 'card-bg rounded-2xl p-6 transition-all duration-200 hover:transform hover:scale-105';
                
                card.innerHTML = `
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br ${cursoColors[participante.curso] || 'from-gray-600 to-gray-700'} flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-lg font-bold text-white mb-1">${participante.nome}</h3>
                            <p class="text-sm text-gray-400">${participante.curso}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-300 font-medium text-sm">Descrição:</span>
                            <p class="text-gray-400 text-sm mt-1">${participante.descricao || 'Não informado'}</p>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-t border-gray-600">
                            <span class="text-gray-300 font-medium">Média</span>
                            <span class="text-lg font-bold text-yellow-400">${mediaNotas}</span>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-xs text-gray-400 mb-3">Avaliações: ${avaliacoesParticipante.length}</p>
                            <button onclick="avaliarParticipante(${participante.id})" 
                                    class="btn-primary w-full py-2.5 rounded-lg font-medium text-white flex items-center justify-center gap-2">
                                <i class="fas fa-star text-sm"></i>
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
            if (!participanteAtual) {
                showNotification('Participante não encontrado!', 'error');
                return;
            }

            document.getElementById('participanteAvaliando').textContent = 
                `${participanteAtual.nome} (${participanteAtual.curso})`;
            
            document.getElementById('tabelaTitulo').textContent = `Tabela de Pontuação - ${participanteAtual.curso}`;
            
            document.getElementById('nomeJurado').value = '';
            gerarCardsAvaliacao(participanteAtual.curso);
            atualizarDetalhesPontuacao();
            
            document.getElementById('avaliacaoModal').classList.remove('hidden');
            document.getElementById('avaliacaoModal').classList.add('flex');
        }

        function gerarCardsAvaliacao(curso) {
            const turmas = cursoTurmasPontuacao[curso.toUpperCase()] || [];
            let totalModelos = turmas.reduce((acc, t) => acc + t.quantidade, 0);
            
            document.getElementById('tabelaSubtitulo').textContent = `Total de ${totalModelos} modelos • Pontuação máxima: 500 pontos`;
            document.getElementById('totalModelos').textContent = `${totalModelos} MODELO${totalModelos > 1 ? 'S' : ''}`;
            
            const container = document.getElementById('turmasContainer');
            container.innerHTML = '';
            
            turmas.forEach((turma, idx) => {
                const card = document.createElement('div');
                card.className = 'year-card p-5 rounded-xl';
                
                let inputsHTML = '';
                if (turma.quantidade === 2) {
                    inputsHTML = `
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Masculino</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" min="0" max="${turma.pontosPorModelo}" 
                                           class="score-input w-full px-3 py-2 rounded-lg text-center font-medium" 
                                           id="nota_${idx}_masc" 
                                           placeholder="${turma.pontosPorModelo}"
                                           oninput="atualizarDetalhesPontuacao()">
                                    <span class="text-xs text-gray-400 font-medium">pts</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Feminino</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" min="0" max="${turma.pontosPorModelo}" 
                                           class="score-input w-full px-3 py-2 rounded-lg text-center font-medium" 
                                           id="nota_${idx}_fem" 
                                           placeholder="${turma.pontosPorModelo}"
                                           oninput="atualizarDetalhesPontuacao()">
                                    <span class="text-xs text-gray-400 font-medium">pts</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-600 text-center">
                            <span class="text-lg font-bold text-yellow-400" id="subtotal_${idx}">0 (0+0)</span>
                        </div>`;
                } else {
                    inputsHTML = `
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-300">Modelo</label>
                            <div class="flex items-center gap-2">
                                <input type="number" min="0" max="${turma.pontosPorModelo}" 
                                       class="score-input w-full px-3 py-2 rounded-lg text-center font-medium" 
                                       id="nota_${idx}_unico" 
                                       placeholder="${turma.pontosPorModelo}"
                                       oninput="atualizarDetalhesPontuacao()">
                                <span class="text-xs text-gray-400 font-medium">pts</span>
                            </div>
                        </div>`;
                }
                
                card.innerHTML = `
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h4 class="text-lg font-bold text-white">${turma.ano}</h4>
                            <p class="text-sm text-gray-400">${turma.quantidade} modelo${turma.quantidade > 1 ? 's' : ''}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-400">Máximo</div>
                            <div class="text-lg font-bold text-blue-400">${turma.quantidade * turma.pontosPorModelo}</div>
                        </div>
                    </div>
                    ${inputsHTML}
                `;
                
                container.appendChild(card);
            });
        }

        function atualizarDetalhesPontuacao() {
            if (!participanteAtual) return 0;
            
            const curso = participanteAtual.curso.toUpperCase();
            const turmas = cursoTurmasPontuacao[curso] || [];
            let total = 0;
            
            turmas.forEach((turma, idx) => {
                let subtotal = 0;
                let detalhe = '';
                
                if (turma.quantidade === 2) {
                    const masc = parseInt(document.getElementById(`nota_${idx}_masc`)?.value) || 0;
                    const fem = parseInt(document.getElementById(`nota_${idx}_fem`)?.value) || 0;
                    subtotal = masc + fem;
                    detalhe = `${subtotal} (${masc}+${fem})`;
                } else {
                    const unico = parseInt(document.getElementById(`nota_${idx}_unico`)?.value) || 0;
                    subtotal = unico;
                    detalhe = `${subtotal}`;
                }
                
                const subtotalElement = document.getElementById(`subtotal_${idx}`);
                if (subtotalElement) {
                    subtotalElement.textContent = detalhe;
                }
                
                total += subtotal;
            });
            
            document.getElementById('totalPontuacao').textContent = total;
            document.getElementById('totalPontuacaoDisplay').textContent = `${total}/500`;
            
            const totalElement = document.getElementById('totalPontuacao');
            const displayElement = document.getElementById('totalPontuacaoDisplay');
            
            if (total === 500) {
                totalElement.className = 'text-3xl font-bold text-green-400';
                displayElement.className = 'text-2xl font-bold text-white';
            } else if (total > 500) {
                totalElement.className = 'text-3xl font-bold text-red-400';
                displayElement.className = 'text-2xl font-bold text-red-400';
            } else {
                totalElement.className = 'text-3xl font-bold text-yellow-400';
                displayElement.className = 'text-2xl font-bold text-yellow-400';
            }
            
            return total;
        }

        function salvarAvaliacao() {
            if (!participanteAtual || !document.getElementById('nomeJurado').value.trim()) {
                showNotification('Preencha o nome do jurado!', 'error');
                return;
            }
            
            const total = atualizarDetalhesPontuacao();
            if (total !== 500) {
                showNotification('A pontuação total deve ser exatamente 500 pontos!', 'error');
                return;
            }
            
            const notas = {};
            document.querySelectorAll('.score-input').forEach(input => {
                if (input.value) {
                    notas[input.id] = parseInt(input.value);
                }
            });
            
            const avaliacao = {
                id: Date.now(),
                participanteId: participanteAtual.id,
                jurado: document.getElementById('nomeJurado').value.trim(),
                curso: participanteAtual.curso,
                notas: notas,
                total: total,
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
                relatorio += `Curso: ${participante.curso}\n`;
                relatorio += `Descrição: ${participante.descricao}\n\n`;
                
                if (avaliacoesParticipante.length > 0) {
                    relatorio += 'AVALIAÇÕES:\n';
                    avaliacoesParticipante.forEach(av => {
                        relatorio += `  Jurado: ${av.jurado}\n`;
                        relatorio += `  Pontuação Total: ${av.total}/500\n`;
                        relatorio += `  Data: ${new Date(av.timestamp).toLocaleString()}\n\n`;
                    });
                    
                    const media = (avaliacoesParticipante.reduce((sum, a) => sum + a.total, 0) / avaliacoesParticipante.length).toFixed(2);
                    relatorio += `MÉDIA FINAL: ${media}/500\n`;
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
                relatorio += `Média: ${participante.media.toFixed(2)}/500\n`;
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
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg text-white font-medium ${
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            } shadow-lg`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

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
