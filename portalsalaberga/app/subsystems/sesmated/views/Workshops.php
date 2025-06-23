<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 10 - Workshops</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>
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
                        <i class="fas fa-tools text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                            TAREFA 10
                        </h1>
                        <p class="text-gray-400 text-xs font-medium tracking-wider uppercase">Workshops</p>
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
                    <i class="fas fa-plus-circle text-2xl" style="color: var(--header-color);"></i>
                    <h2 class="text-2xl font-bold">Cadastrar Workshop</h2>
                </div>
                
                <form id="workshopForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-heading mr-2"></i>Título do Workshop
                            </label>
                            <input type="text" id="tituloWorkshop" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>Instrutor
                            </label>
                            <input type="text" id="instrutor" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-calendar mr-2"></i>Data
                            </label>
                            <input type="date" id="dataWorkshop" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-clock mr-2"></i>Horário
                            </label>
                            <input type="time" id="horarioWorkshop" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-hourglass-half mr-2"></i>Duração (horas)
                            </label>
                            <input type="number" id="duracao" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" min="1" max="8" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-users mr-2"></i>Vagas Disponíveis
                            </label>
                            <input type="number" id="vagas" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" min="1" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-align-left mr-2"></i>Descrição
                            </label>
                            <textarea id="descricaoWorkshop" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary px-8 py-3 rounded-2xl font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Cadastrar Workshop
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Workshops Grid -->
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <i class="fas fa-list text-2xl" style="color: var(--header-color);"></i>
                <h2 class="text-2xl font-bold">Workshops Cadastrados</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="workshopsList">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <!-- Inscrições Modal -->
        <div id="inscricoesModal" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
            <div class="modal-bg rounded-3xl p-8 w-full max-w-4xl mx-4 slide-up max-h-[90vh] overflow-y-auto">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                        <i class="fas fa-user-plus text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold">Gerenciar Inscrições</h2>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2" id="workshopAtual"></h3>
                    <div class="flex gap-4 text-sm text-gray-400">
                        <span id="vagasInfo"></span>
                        <span id="duracaoInfo"></span>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-user mr-2"></i>Nome do Participante
                        </label>
                        <input type="text" id="nomeParticipante" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-graduation-cap mr-2"></i>Curso
                        </label>
                        <select id="cursoParticipante" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                            <option value="">Selecione o curso</option>
                            <option value="Informática">Informática</option>
                            <option value="Enfermagem">Enfermagem</option>
                            <option value="Administração">Administração</option>
                            <option value="Agropecuária">Agropecuária</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-4 mb-8">
                    <button onclick="registrarInscricao()" class="btn-primary px-6 py-3 rounded-2xl font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-user-plus"></i>
                        Registrar Inscrição
                    </button>
                    <button onclick="gerarQRCode()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center gap-2">
                        <i class="fas fa-qrcode"></i>
                        Gerar QR Code
                    </button>
                </div>
                
                <!-- QR Code -->
                <div id="qrCodeContainer" class="text-center mb-8 hidden">
                    <div class="card-bg rounded-2xl p-6">
                        <h4 class="text-lg font-semibold mb-4">QR Code para Inscrição</h4>
                        <div id="qrcode" class="inline-block p-4 bg-white rounded-lg"></div>
                        <p class="mt-4 text-sm text-gray-400">Escaneie para se inscrever automaticamente</p>
                    </div>
                </div>
                
                <!-- Lista de Inscritos -->
                <div class="card-bg rounded-2xl p-6 mb-8">
                    <h4 class="text-lg font-semibold mb-4">Participantes Inscritos</h4>
                    <div id="listaInscritos" class="space-y-2 max-h-60 overflow-y-auto">
                        <!-- Lista será preenchida dinamicamente -->
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button onclick="fecharInscricoes()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center gap-2">
                        <i class="fas fa-times"></i>
                        Fechar
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
                <button onclick="gerarRelatorioFrequencia()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-chart-bar"></i>
                    Relatório de Frequência
                </button>
                <button onclick="gerarRelatorioPorCurso()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-graduation-cap"></i>
                    Relatório por Curso
                </button>
                <button onclick="relatorioOcupacao()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-chart-pie"></i>
                    Relatório de Ocupação
                </button>
                <button onclick="calcularPontuacaoCursos()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2 shadow-lg transition-all duration-200 hover:bg-gradient-to-r hover:from-yellow-400 hover:to-green-500 hover:text-black focus:ring-4 focus:ring-yellow-400 focus:outline-none group" aria-label="Pontuação dos Cursos" title="Calcular pontuação dos cursos pela presença nos workshops">
                    <i class="fas fa-medal text-xl group-hover:scale-125 transition-transform"></i>
                    Pontuação dos Cursos
                </button>
            </div>
        </section>
    </main>

    <script>
        let workshops = JSON.parse(localStorage.getItem('workshops') || '[]');
        let presencas = JSON.parse(localStorage.getItem('presencas_workshops') || '[]');
        let workshopAtual = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderWorkshops();
            
            // Form submission
            document.getElementById('workshopForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const workshop = {
                    id: Date.now(),
                    titulo: document.getElementById('tituloWorkshop').value,
                    instrutor: document.getElementById('instrutor').value,
                    data: document.getElementById('dataWorkshop').value,
                    horario: document.getElementById('horarioWorkshop').value,
                    duracao: parseInt(document.getElementById('duracao').value),
                    vagas: parseInt(document.getElementById('vagas').value),
                    descricao: document.getElementById('descricaoWorkshop').value,
                    timestamp: new Date().toISOString()
                };
                
                workshops.push(workshop);
                localStorage.setItem('workshops', JSON.stringify(workshops));
                
                this.reset();
                renderWorkshops();
                
                showNotification('Workshop cadastrado com sucesso!', 'success');
            });
        });

        function renderWorkshops() {
            const container = document.getElementById('workshopsList');
            container.innerHTML = '';
            
            if (workshops.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-20">
                        <div class="w-32 h-32 mx-auto mb-8 rounded-3xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center">
                            <i class="fas fa-tools text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-300 mb-4">Nenhum workshop cadastrado</h3>
                        <p class="text-gray-400 mb-8 text-lg">Adicione o primeiro workshop para começar</p>
                    </div>
                `;
                return;
            }
            
            workshops.forEach(workshop => {
                const presencasWorkshop = presencas.filter(p => p.workshopId === workshop.id);
                const totalInscritos = presencasWorkshop.length;
                const vagasRestantes = workshop.vagas - totalInscritos;
                
                const card = document.createElement('div');
                card.className = 'card-bg rounded-3xl p-6 card-hover transition-all duration-300 fade-in';
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-tools text-white text-xl"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xl font-bold text-white mb-1">${workshop.titulo}</h3>
                                <p class="text-sm text-gray-400 font-medium">${workshop.instrutor}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-400">Data:</span>
                                <p class="text-white font-semibold">${new Date(workshop.data).toLocaleDateString('pt-BR')}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Horário:</span>
                                <p class="text-white font-semibold">${workshop.horario}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Duração:</span>
                                <p class="text-white font-semibold">${workshop.duracao}h</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Vagas:</span>
                                <p class="text-white font-semibold">${totalInscritos}/${workshop.vagas}</p>
                            </div>
                        </div>
                        
                        <div>
                            <span class="text-gray-400 text-sm">Descrição:</span>
                            <p class="text-gray-300 text-sm mt-1">${workshop.descricao || 'Não informado'}</p>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300 font-semibold">Status</span>
                            <span class="text-sm font-bold ${vagasRestantes > 0 ? 'text-green-400' : 'text-red-400'}">
                                ${vagasRestantes > 0 ? `${vagasRestantes} vagas restantes` : 'Lotado'}
                            </span>
                        </div>
                        
                        <div class="text-center pt-4">
                            <button onclick="gerenciarInscricoes(${workshop.id})" 
                                    class="btn-primary w-full py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                                <i class="fas fa-users"></i>
                                Gerenciar Inscrições
                            </button>
                        </div>
                    </div>
                `;
                
                container.appendChild(card);
            });
        }

        function gerenciarInscricoes(id) {
            workshopAtual = workshops.find(w => w.id === id);
            const presencasWorkshop = presencas.filter(p => p.workshopId === id);
            const vagasRestantes = workshopAtual.vagas - presencasWorkshop.length;
            
            document.getElementById('workshopAtual').textContent = 
                `${workshopAtual.titulo} - ${workshopAtual.instrutor}`;
            document.getElementById('vagasInfo').textContent = 
                `Vagas: ${presencasWorkshop.length}/${workshopAtual.vagas}`;
            document.getElementById('duracaoInfo').textContent = 
                `Duração: ${workshopAtual.duracao}h`;
            
            document.getElementById('nomeParticipante').value = '';
            document.getElementById('cursoParticipante').value = '';
            
            document.getElementById('inscricoesModal').classList.remove('hidden');
            document.getElementById('inscricoesModal').classList.add('flex');
            
            atualizarListaInscritos();
        }

        function registrarInscricao() {
            if (!workshopAtual || !document.getElementById('nomeParticipante').value || !document.getElementById('cursoParticipante').value) {
                showNotification('Preencha todos os campos!', 'error');
                return;
            }
            
            const nome = document.getElementById('nomeParticipante').value;
            const curso = document.getElementById('cursoParticipante').value;
            
            // Verificar vagas disponíveis
            const presencasWorkshop = presencas.filter(p => p.workshopId === workshopAtual.id);
            if (presencasWorkshop.length >= workshopAtual.vagas) {
                showNotification('Workshop lotado! Não há mais vagas disponíveis.', 'error');
                return;
            }
            
            // Verificar se já está registrado
            const jaRegistrado = presencas.some(p => 
                p.workshopId === workshopAtual.id && 
                p.nome.toLowerCase() === nome.toLowerCase()
            );
            
            if (jaRegistrado) {
                showNotification('Participante já inscrito neste workshop!', 'error');
                return;
            }
            
            const presenca = {
                id: Date.now(),
                workshopId: workshopAtual.id,
                nome: nome,
                curso: curso,
                timestamp: new Date().toISOString()
            };
            
            presencas.push(presenca);
            localStorage.setItem('presencas_workshops', JSON.stringify(presencas));
            
            document.getElementById('nomeParticipante').value = '';
            document.getElementById('cursoParticipante').value = '';
            
            atualizarListaInscritos();
            renderWorkshops();
            
            showNotification('Inscrição realizada com sucesso!', 'success');
        }

        function atualizarListaInscritos() {
            if (!workshopAtual) return;
            
            const presencasWorkshop = presencas.filter(p => p.workshopId === workshopAtual.id);
            const container = document.getElementById('listaInscritos');
            
            container.innerHTML = '';
            
            if (presencasWorkshop.length === 0) {
                container.innerHTML = '<p class="text-gray-400 text-center py-4">Nenhum participante inscrito ainda</p>';
                return;
            }
            
            presencasWorkshop.forEach((presenca, index) => {
                const item = document.createElement('div');
                item.className = 'flex justify-between items-center p-3 bg-gray-800/50 rounded-xl';
                item.innerHTML = `
                    <div>
                        <span class="font-medium text-white">${index + 1}. ${presenca.nome}</span>
                        <span class="text-sm text-gray-400 ml-2">${presenca.curso}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">${new Date(presenca.timestamp).toLocaleTimeString('pt-BR')}</span>
                        <button onclick="removerInscricao(${presenca.id})" class="text-red-400 hover:text-red-300 text-xs px-2 py-1 rounded">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                container.appendChild(item);
            });
            
            // Atualizar info de vagas
            const vagasRestantes = workshopAtual.vagas - presencasWorkshop.length;
            document.getElementById('vagasInfo').textContent = 
                `Vagas: ${presencasWorkshop.length}/${workshopAtual.vagas}`;
        }

        function removerInscricao(id) {
            if (confirm('Tem certeza que deseja remover esta inscrição?')) {
                presencas = presencas.filter(p => p.id !== id);
                localStorage.setItem('presencas_workshops', JSON.stringify(presencas));
                atualizarListaInscritos();
                renderWorkshops();
                showNotification('Inscrição removida com sucesso!', 'success');
            }
        }

        function gerarQRCode() {
            if (!workshopAtual) return;
            
            const qrData = JSON.stringify({
                type: 'workshop_inscricao',
                workshopId: workshopAtual.id,
                titulo: workshopAtual.titulo
            });
            
            const qrContainer = document.getElementById('qrcode');
            qrContainer.innerHTML = '';
            
            QRCode.toCanvas(qrContainer, qrData, {
                width: 200,
                height: 200,
                colorDark: '#000000',
                colorLight: '#ffffff'
            });
            
            document.getElementById('qrCodeContainer').classList.remove('hidden');
        }

        function fecharInscricoes() {
            document.getElementById('inscricoesModal').classList.add('hidden');
            document.getElementById('inscricoesModal').classList.remove('flex');
            document.getElementById('qrCodeContainer').classList.add('hidden');
            workshopAtual = null;
        }

        function gerarRelatorioFrequencia() {
            let relatorio = 'RELATÓRIO DE FREQUÊNCIA - WORKSHOPS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            // Agrupar participantes únicos
            const participantesUnicos = {};
            
            presencas.forEach(presenca => {
                const key = `${presenca.nome}_${presenca.curso}`;
                if (!participantesUnicos[key]) {
                    participantesUnicos[key] = {
                        nome: presenca.nome,
                        curso: presenca.curso,
                        workshops: []
                    };
                }
                
                const workshop = workshops.find(w => w.id === presenca.workshopId);
                if (workshop) {
                    participantesUnicos[key].workshops.push(workshop.titulo);
                }
            });
            
            Object.values(participantesUnicos).forEach(participante => {
                const percentual = ((participante.workshops.length / workshops.length) * 100).toFixed(1);
                relatorio += `PARTICIPANTE: ${participante.nome}\n`;
                relatorio += `Curso: ${participante.curso}\n`;
                relatorio += `Workshops participados: ${participante.workshops.length}/${workshops.length}\n`;
                relatorio += `Percentual: ${percentual}%\n`;
                relatorio += `Workshops: ${participante.workshops.join(', ')}\n\n`;
            });
            
            downloadFile(relatorio, 'relatorio_frequencia_workshops.txt');
        }

        function gerarRelatorioPorCurso() {
            let relatorio = 'RELATÓRIO POR CURSO - WORKSHOPS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            const cursos = ['Informática', 'Enfermagem', 'Administração', 'Agropecuária'];
            
            cursos.forEach(curso => {
                const presencasCurso = presencas.filter(p => p.curso === curso);
                const participantesUnicos = [...new Set(presencasCurso.map(p => p.nome))];
                
                relatorio += `CURSO: ${curso}\n`;
                relatorio += `Participantes únicos: ${participantesUnicos.length}\n`;
                relatorio += `Total de inscrições: ${presencasCurso.length}\n`;
                
                if (participantesUnicos.length > 0) {
                    const mediaInscricoes = (presencasCurso.length / participantesUnicos.length).toFixed(1);
                    relatorio += `Média de workshops por participante: ${mediaInscricoes}\n`;
                }
                
                relatorio += '\n';
            });
            
            downloadFile(relatorio, 'relatorio_por_curso_workshops.txt');
        }

        function relatorioOcupacao() {
            let relatorio = 'RELATÓRIO DE OCUPAÇÃO - WORKSHOPS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            workshops.forEach(workshop => {
                const presencasWorkshop = presencas.filter(p => p.workshopId === workshop.id);
                const ocupacao = ((presencasWorkshop.length / workshop.vagas) * 100).toFixed(1);
                
                relatorio += `WORKSHOP: ${workshop.titulo}\n`;
                relatorio += `Instrutor: ${workshop.instrutor}\n`;
                relatorio += `Data: ${new Date(workshop.data).toLocaleDateString('pt-BR')}\n`;
                relatorio += `Vagas: ${workshop.vagas}\n`;
                relatorio += `Inscritos: ${presencasWorkshop.length}\n`;
                relatorio += `Taxa de ocupação: ${ocupacao}%\n`;
                relatorio += `Status: ${presencasWorkshop.length >= workshop.vagas ? 'LOTADO' : 'VAGAS DISPONÍVEIS'}\n\n`;
            });
            
            downloadFile(relatorio, 'relatorio_ocupacao_workshops.txt');
        }

        function calcularPontuacaoCursos() {
            const cursos = ['Informática', 'Enfermagem', 'Administração', 'Agropecuária'];
            let relatorio = 'PONTUAÇÃO DOS CURSOS - WORKSHOPS\n';
            relatorio += '='.repeat(50) + '\n\n';
            cursos.forEach(curso => {
                const presencasCurso = presencas.filter(p => p.curso === curso);
                const participantesUnicos = [...new Set(presencasCurso.map(p => p.nome))];
                let somaPercentuais = 0;
                participantesUnicos.forEach(nome => {
                    const qtd = presencasCurso.filter(p => p.nome === nome).length;
                    somaPercentuais += (qtd / workshops.length) * 100;
                });
                const mediaPercentual = participantesUnicos.length > 0 ? (somaPercentuais / participantesUnicos.length) : 0;
                let pontos = 0;
                if (mediaPercentual === 100) pontos = 500;
                else if (mediaPercentual >= 80) pontos = 400;
                else if (mediaPercentual >= 50) pontos = 300;
                relatorio += `CURSO: ${curso}\n`;
                relatorio += `Média de participação: ${mediaPercentual.toFixed(1)}%\n`;
                relatorio += `Pontuação: ${pontos} pontos\n`;
                relatorio += '-'.repeat(30) + '\n';
            });
            downloadFile(relatorio, 'pontuacao_cursos_workshops.txt');
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
        document.getElementById('inscricoesModal').addEventListener('click', function(e) {
            if (e.target === this) fecharInscricoes();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!document.getElementById('inscricoesModal').classList.contains('hidden')) fecharInscricoes();
            }
        });
    </script>
</body>
</html>
