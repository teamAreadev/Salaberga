<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 09 - Palestras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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
                            <i class="fas fa-microphone text-white text-lg"></i>
                        </div>
                        <h1 class="main-title font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                            TAREFA 9
                        </h1>
                    </div>
                    <p class="text-gray-400 text-xs font-medium tracking-wider uppercase">Palestras</p>
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
                    <h2 class="text-2xl font-bold">Cadastrar Palestra</h2>
                </div>
                
                <form id="palestraForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-heading mr-2"></i>Título da Palestra
                            </label>
                            <input type="text" id="tituloPalestra" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-user-tie mr-2"></i>Palestrante
                            </label>
                            <input type="text" id="palestrante" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-calendar mr-2"></i>Data
                            </label>
                            <input type="date" id="dataPalestra" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-clock mr-2"></i>Horário
                            </label>
                            <input type="time" id="horarioPalestra" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-align-left mr-2"></i>Descrição
                            </label>
                            <textarea id="descricaoPalestra" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary px-8 py-3 rounded-2xl font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Cadastrar Palestra
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Palestras Grid -->
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <i class="fas fa-list text-2xl" style="color: var(--header-color);"></i>
                <h2 class="text-2xl font-bold">Palestras Cadastradas</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="palestrasList">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <!-- Presença Modal -->
        <div id="presencaModal" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
            <div class="modal-bg rounded-3xl p-8 w-full max-w-4xl mx-4 slide-up max-h-[90vh] overflow-y-auto">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold">Registrar Presença</h2>
                </div>
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2" id="palestraAtual"></h3>
                </div>
                <div class="mb-8 text-center">
                    <p class="text-lg text-yellow-400 font-semibold mb-4">Aproxime o crachá do leitor de QR Code para registrar presença</p>
                    <input id="inputLeitorQR" type="text" autocomplete="off" class="opacity-0 absolute pointer-events-none" style="width:1px;height:1px;" tabindex="0">
                </div>
                <div class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-user mr-2"></i>Nome do Participante
                            </label>
                            <div id="nomeParticipanteDisplay" class="input-field w-full rounded-2xl px-4 py-3 text-white"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-graduation-cap mr-2"></i>Curso
                            </label>
                            <div id="cursoParticipanteDisplay" class="input-field w-full rounded-2xl px-4 py-3 text-white"></div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mb-8">
                    <button onclick="registrarPresencaAuto()" class="btn-primary px-6 py-3 rounded-2xl font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-check"></i>
                        Registrar Presença
                    </button>
                </div>
                
                <!-- Lista de Presentes -->
                <div class="card-bg rounded-2xl p-6 mb-8">
                    <h4 class="text-lg font-semibold mb-4">Participantes Presentes</h4>
                    <div id="listaPresentes" class="space-y-2 max-h-60 overflow-y-auto">
                        <!-- Lista será preenchida dinamicamente -->
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button onclick="fecharPresenca()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center gap-2">
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
                <button onclick="calcularPontuacao()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-calculator"></i>
                    Calcular Pontuação
                </button>
            </div>
        </section>
    </main>

    <script>
        let palestras = JSON.parse(localStorage.getItem('palestras') || '[]');
        let presencas = JSON.parse(localStorage.getItem('presencas_palestras') || '[]');
        let palestraAtual = null;
        let nomeLidoQR = '';
        let cursoLidoQR = '';

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderPalestras();
            
            // Form submission
            document.getElementById('palestraForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const palestra = {
                    id: Date.now(),
                    titulo: document.getElementById('tituloPalestra').value,
                    palestrante: document.getElementById('palestrante').value,
                    data: document.getElementById('dataPalestra').value,
                    horario: document.getElementById('horarioPalestra').value,
                    descricao: document.getElementById('descricaoPalestra').value,
                    timestamp: new Date().toISOString()
                };
                
                palestras.push(palestra);
                localStorage.setItem('palestras', JSON.stringify(palestras));
                
                this.reset();
                renderPalestras();
                
                showNotification('Palestra cadastrada com sucesso!', 'success');
            });
        });

        function renderPalestras() {
            const container = document.getElementById('palestrasList');
            container.innerHTML = '';
            
            if (palestras.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-20">
                        <div class="w-32 h-32 mx-auto mb-8 rounded-3xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center">
                            <i class="fas fa-microphone text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-300 mb-4">Nenhuma palestra cadastrada</h3>
                        <p class="text-gray-400 mb-8 text-lg">Adicione a primeira palestra para começar</p>
                    </div>
                `;
                return;
            }
            
            palestras.forEach(palestra => {
                const presencasPalestra = presencas.filter(p => p.palestraId === palestra.id);
                const totalPresentes = presencasPalestra.length;
                
                const card = document.createElement('div');
                card.className = 'card-bg rounded-3xl p-6 card-hover transition-all duration-300 fade-in';
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-microphone text-white text-xl"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xl font-bold text-white mb-1">${palestra.titulo}</h3>
                                <p class="text-sm text-gray-400 font-medium">${palestra.palestrante}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-400">Data:</span>
                                <p class="text-white font-semibold">${new Date(palestra.data).toLocaleDateString('pt-BR')}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Horário:</span>
                                <p class="text-white font-semibold">${palestra.horario}</p>
                            </div>
                        </div>
                        
                        <div>
                            <span class="text-gray-400 text-sm">Descrição:</span>
                            <p class="text-gray-300 text-sm mt-1">${palestra.descricao || 'Não informado'}</p>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300 font-semibold">Presentes</span>
                            <span class="text-2xl font-bold" style="color: var(--accent-color);">${totalPresentes}</span>
                        </div>
                        
                        <div class="text-center pt-4">
                            <button onclick="abrirPresenca(${palestra.id})" 
                                    class="btn-primary w-full py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                Controlar Presença
                            </button>
                        </div>
                    </div>
                `;
                
                container.appendChild(card);
            });
        }

        function abrirPresenca(id) {
            palestraAtual = palestras.find(p => p.id === id);
            document.getElementById('palestraAtual').textContent = 
                `${palestraAtual.titulo} - ${palestraAtual.palestrante}`;
            document.getElementById('nomeParticipanteDisplay').textContent = '';
            document.getElementById('cursoParticipanteDisplay').textContent = '';
            nomeLidoQR = '';
            cursoLidoQR = '';
            document.getElementById('presencaModal').classList.remove('hidden');
            document.getElementById('presencaModal').classList.add('flex');
            atualizarListaPresentes();
            // Foca no input oculto para receber o QR do leitor físico
            setTimeout(() => {
                const input = document.getElementById('inputLeitorQR');
                input.value = '';
                input.focus();
            }, 200);
        }

        function registrarPresencaAuto() {
            if (!palestraAtual || !nomeLidoQR || !cursoLidoQR) {
                showNotification('Erro ao ler o QR Code do crachá!', 'error');
                return;
            }
            // Verificar se já está registrado
            const jaRegistrado = presencas.some(p => 
                p.palestraId === palestraAtual.id && 
                p.nome.toLowerCase() === nomeLidoQR.toLowerCase()
            );
            if (jaRegistrado) {
                showNotification('Participante já registrado nesta palestra!', 'error');
                return;
            }
            const presenca = {
                id: Date.now(),
                palestraId: palestraAtual.id,
                nome: nomeLidoQR,
                curso: cursoLidoQR,
                timestamp: new Date().toISOString()
            };
            presencas.push(presenca);
            localStorage.setItem('presencas_palestras', JSON.stringify(presencas));
            nomeLidoQR = '';
            cursoLidoQR = '';
            document.getElementById('nomeParticipanteDisplay').textContent = '';
            document.getElementById('cursoParticipanteDisplay').textContent = '';
            atualizarListaPresentes();
            showNotification('Presença registrada com sucesso!', 'success');
        }

        function atualizarListaPresentes() {
            if (!palestraAtual) return;
            
            const presencasPalestra = presencas.filter(p => p.palestraId === palestraAtual.id);
            const container = document.getElementById('listaPresentes');
            
            container.innerHTML = '';
            
            if (presencasPalestra.length === 0) {
                container.innerHTML = '<p class="text-gray-400 text-center py-4">Nenhum participante registrado ainda</p>';
                return;
            }
            
            presencasPalestra.forEach(presenca => {
                const item = document.createElement('div');
                item.className = 'flex justify-between items-center p-3 bg-gray-800/50 rounded-xl';
                item.innerHTML = `
                    <div>
                        <span class="font-medium text-white">${presenca.nome}</span>
                        <span class="text-sm text-gray-400 ml-2">${presenca.curso}</span>
                    </div>
                    <span class="text-xs text-gray-500">${new Date(presenca.timestamp).toLocaleTimeString('pt-BR')}</span>
                `;
                container.appendChild(item);
            });
        }

        function fecharPresenca() {
            document.getElementById('presencaModal').classList.add('hidden');
            document.getElementById('presencaModal').classList.remove('flex');
            palestraAtual = null;
        }

        function gerarRelatorioFrequencia() {
            let relatorio = 'RELATÓRIO DE FREQUÊNCIA - PALESTRAS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            // Agrupar participantes únicos
            const participantesUnicos = {};
            
            presencas.forEach(presenca => {
                const key = `${presenca.nome}_${presenca.curso}`;
                if (!participantesUnicos[key]) {
                    participantesUnicos[key] = {
                        nome: presenca.nome,
                        curso: presenca.curso,
                        palestras: []
                    };
                }
                
                const palestra = palestras.find(p => p.id === presenca.palestraId);
                if (palestra) {
                    participantesUnicos[key].palestras.push(palestra.titulo);
                }
            });
            
            Object.values(participantesUnicos).forEach(participante => {
                const percentual = ((participante.palestras.length / palestras.length) * 100).toFixed(1);
                relatorio += `PARTICIPANTE: ${participante.nome}\n`;
                relatorio += `Curso: ${participante.curso}\n`;
                relatorio += `Palestras assistidas: ${participante.palestras.length}/${palestras.length}\n`;
                relatorio += `Percentual: ${percentual}%\n`;
                relatorio += `Palestras: ${participante.palestras.join(', ')}\n\n`;
            });
            
            downloadFile(relatorio, 'relatorio_frequencia_palestras.txt');
        }

        function gerarRelatorioPorCurso() {
            let relatorio = 'RELATÓRIO POR CURSO - PALESTRAS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            const cursos = ['Informática', 'Enfermagem', 'Administração', 'Agropecuária'];
            
            cursos.forEach(curso => {
                const presencasCurso = presencas.filter(p => p.curso === curso);
                const participantesUnicos = [...new Set(presencasCurso.map(p => p.nome))];
                
                relatorio += `CURSO: ${curso}\n`;
                relatorio += `Participantes únicos: ${participantesUnicos.length}\n`;
                relatorio += `Total de presenças: ${presencasCurso.length}\n`;
                
                if (participantesUnicos.length > 0) {
                    const mediaPresencas = (presencasCurso.length / participantesUnicos.length).toFixed(1);
                    relatorio += `Média de palestras por participante: ${mediaPresencas}\n`;
                }
                
                relatorio += '\n';
            });
            
            downloadFile(relatorio, 'relatorio_por_curso_palestras.txt');
        }

        function calcularPontuacao() {
            let relatorio = 'PONTUAÇÃO - PALESTRAS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            const participantesUnicos = {};
            
            presencas.forEach(presenca => {
                const key = `${presenca.nome}_${presenca.curso}`;
                if (!participantesUnicos[key]) {
                    participantesUnicos[key] = {
                        nome: presenca.nome,
                        curso: presenca.curso,
                        palestrasAssistidas: 0
                    };
                }
                participantesUnicos[key].palestrasAssistidas++;
            });
            
            Object.values(participantesUnicos).forEach(participante => {
                const percentual = (participante.palestrasAssistidas / palestras.length) * 100;
                let pontos = 0;
                
                if (percentual === 100) {
                    pontos = 500;
                } else if (percentual >= 80) {
                    pontos = 400;
                } else if (percentual >= 50) {
                    pontos = 300;
                }
                
                relatorio += `${participante.nome} (${participante.curso})\n`;
                relatorio += `Presença: ${percentual.toFixed(1)}%\n`;
                relatorio += `Pontuação: ${pontos} pontos\n\n`;
            });
            
            downloadFile(relatorio, 'pontuacao_palestras.txt');
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
        document.getElementById('presencaModal').addEventListener('click', function(e) {
            if (e.target === this) fecharPresenca();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!document.getElementById('presencaModal').classList.contains('hidden')) fecharPresenca();
            }
        });

        document.getElementById('inputLeitorQR').addEventListener('input', function(e) {
            const qrCodeMessage = this.value.trim();
            if (!qrCodeMessage) return;
            // Tenta ler JSON ou CSV
            let nome = '', curso = '';
            try {
                const obj = JSON.parse(qrCodeMessage);
                nome = obj.nome || '';
                curso = obj.curso || '';
            } catch (e) {
                // Tenta CSV: nome,curso
                const parts = qrCodeMessage.split(',');
                if (parts.length >= 2) {
                    nome = parts[0].trim();
                    curso = parts[1].trim();
                } else {
                    nome = qrCodeMessage;
                }
            }
            nomeLidoQR = nome;
            cursoLidoQR = curso;
            document.getElementById('nomeParticipanteDisplay').textContent = nome;
            document.getElementById('cursoParticipanteDisplay').textContent = curso;
            // Registrar presença automaticamente
            registrarPresencaAuto();
            this.value = '';
        });
    </script>
</body>
</html>
