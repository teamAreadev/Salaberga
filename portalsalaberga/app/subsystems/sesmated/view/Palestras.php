<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 09 - Palestras | SESMATED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>
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
            background-color: var(--background-color);
            color: var(--text-color);
        }
        
        .custom-card {
            background-color: var(--card-bg);
            border: 1px solid var(--grid-color);
        }
        
        .custom-card:hover {
            border-color: var(--card-border-hover);
        }
        
        .custom-header {
            background-color: var(--header-bg);
            color: var(--header-color);
        }
        
        .custom-button {
            background-color: var(--header-color);
            color: white;
        }
        
        .custom-button:hover {
            background-color: var(--accent-color);
        }
        
        .custom-input {
            background-color: var(--search-bar-bg);
            border: 1px solid var(--grid-color);
            color: var(--text-color);
        }
    </style>
</head>
<body class="min-h-screen">
    <header class="custom-header p-4 shadow-lg">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center">Tarefa 09 - Palestras</h1>
            <p class="text-center mt-2 opacity-80">Sistema de Controle de Presença</p>
        </div>
    </header>

    <main class="container mx-auto p-6">
        <!-- Cadastro de Palestras -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Cadastrar Palestra</h2>
            <form id="palestraForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Título da Palestra</label>
                    <input type="text" id="tituloPalestra" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Palestrante</label>
                    <input type="text" id="palestrante" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Data</label>
                    <input type="date" id="dataPalestra" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Horário</label>
                    <input type="time" id="horarioPalestra" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Descrição</label>
                    <textarea id="descricaoPalestra" class="custom-input w-full p-3 rounded-lg" rows="3"></textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="custom-button px-6 py-3 rounded-lg font-medium">
                        Cadastrar Palestra
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Palestras -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Palestras Cadastradas</h2>
            <div id="palestrasList" class="space-y-4">
                <!-- Palestras serão inseridas aqui -->
            </div>
        </div>

        <!-- Registro de Presença -->
        <div class="custom-card rounded-lg p-6 mb-8" id="presencaSection" style="display: none;">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Registrar Presença</h2>
            <div id="presencaForm">
                <div class="mb-4">
                    <h3 class="text-xl font-semibold mb-2" id="palestraAtual"></h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nome do Participante</label>
                        <input type="text" id="nomeParticipante" class="custom-input w-full p-3 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Curso</label>
                        <select id="cursoParticipante" class="custom-input w-full p-3 rounded-lg" required>
                            <option value="">Selecione o curso</option>
                            <option value="Informática">Informática</option>
                            <option value="Enfermagem">Enfermagem</option>
                            <option value="Administração">Administração</option>
                            <option value="Agropecuária">Agropecuária</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-4 mb-6">
                    <button onclick="registrarPresenca()" class="custom-button px-6 py-3 rounded-lg font-medium">
                        Registrar Presença
                    </button>
                    <button onclick="gerarQRCode()" class="bg-purple-600 text-white px-6 py-3 rounded-lg font-medium">
                        Gerar QR Code
                    </button>
                    <button onclick="fecharPresenca()" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-medium">
                        Fechar
                    </button>
                </div>
                
                <!-- QR Code -->
                <div id="qrCodeContainer" class="text-center mb-6" style="display: none;">
                    <h4 class="text-lg font-semibold mb-4">QR Code para Presença</h4>
                    <div id="qrcode" class="inline-block p-4 bg-white rounded-lg"></div>
                    <p class="mt-2 text-sm opacity-80">Escaneie para registrar presença automaticamente</p>
                </div>
                
                <!-- Lista de Presentes -->
                <div class="custom-card p-4 rounded-lg">
                    <h4 class="text-lg font-semibold mb-4">Participantes Presentes</h4>
                    <div id="listaPresentes" class="space-y-2">
                        <!-- Lista será preenchida dinamicamente -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Relatórios -->
        <div class="custom-card rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Relatórios</h2>
            <div class="flex flex-wrap gap-4">
                <button onclick="gerarRelatorioFrequencia()" class="custom-button px-6 py-3 rounded-lg font-medium">
                    Relatório de Frequência
                </button>
                <button onclick="gerarRelatorioPorCurso()" class="bg-purple-600 text-white px-6 py-3 rounded-lg font-medium">
                    Relatório por Curso
                </button>
                <button onclick="calcularPontuacao()" class="bg-yellow-600 text-white px-6 py-3 rounded-lg font-medium">
                    Calcular Pontuação
                </button>
            </div>
        </div>
    </main>

    <script>
        let palestras = JSON.parse(localStorage.getItem('palestras') || '[]');
        let presencas = JSON.parse(localStorage.getItem('presencas_palestras') || '[]');
        let palestraAtual = null;

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
            renderizarPalestras();
            
            alert('Palestra cadastrada com sucesso!');
        });

        function renderizarPalestras() {
            const container = document.getElementById('palestrasList');
            container.innerHTML = '';
            
            palestras.forEach(palestra => {
                const presencasPalestra = presencas.filter(p => p.palestraId === palestra.id);
                const totalPresentes = presencasPalestra.length;
                
                const card = document.createElement('div');
                card.className = 'custom-card p-4 rounded-lg';
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-lg mb-2">${palestra.titulo}</h3>
                            <p class="text-sm opacity-80 mb-1"><strong>Palestrante:</strong> ${palestra.palestrante}</p>
                            <p class="text-sm opacity-80 mb-1"><strong>Data:</strong> ${new Date(palestra.data).toLocaleDateString('pt-BR')}</p>
                            <p class="text-sm opacity-80 mb-1"><strong>Horário:</strong> ${palestra.horario}</p>
                            <p class="text-sm opacity-80 mb-3"><strong>Descrição:</strong> ${palestra.descricao}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-yellow-400">Presentes: ${totalPresentes}</p>
                        </div>
                    </div>
                    <button onclick="abrirPresenca(${palestra.id})" 
                            class="custom-button px-4 py-2 rounded text-sm font-medium">
                        Controlar Presença
                    </button>
                `;
                container.appendChild(card);
            });
        }

        function abrirPresenca(id) {
            palestraAtual = palestras.find(p => p.id === id);
            document.getElementById('palestraAtual').textContent = 
                `${palestraAtual.titulo} - ${palestraAtual.palestrante}`;
            
            document.getElementById('nomeParticipante').value = '';
            document.getElementById('cursoParticipante').value = '';
            
            document.getElementById('presencaSection').style.display = 'block';
            document.getElementById('presencaSection').scrollIntoView({ behavior: 'smooth' });
            
            atualizarListaPresentes();
        }

        function registrarPresenca() {
            if (!palestraAtual || !document.getElementById('nomeParticipante').value || !document.getElementById('cursoParticipante').value) {
                alert('Preencha todos os campos!');
                return;
            }
            
            const nome = document.getElementById('nomeParticipante').value;
            const curso = document.getElementById('cursoParticipante').value;
            
            // Verificar se já está registrado
            const jaRegistrado = presencas.some(p => 
                p.palestraId === palestraAtual.id && 
                p.nome.toLowerCase() === nome.toLowerCase()
            );
            
            if (jaRegistrado) {
                alert('Participante já registrado nesta palestra!');
                return;
            }
            
            const presenca = {
                id: Date.now(),
                palestraId: palestraAtual.id,
                nome: nome,
                curso: curso,
                timestamp: new Date().toISOString()
            };
            
            presencas.push(presenca);
            localStorage.setItem('presencas_palestras', JSON.stringify(presencas));
            
            document.getElementById('nomeParticipante').value = '';
            document.getElementById('cursoParticipante').value = '';
            
            atualizarListaPresentes();
            renderizarPalestras();
            
            alert('Presença registrada com sucesso!');
        }

        function atualizarListaPresentes() {
            if (!palestraAtual) return;
            
            const presencasPalestra = presencas.filter(p => p.palestraId === palestraAtual.id);
            const container = document.getElementById('listaPresentes');
            
            container.innerHTML = '';
            
            presencasPalestra.forEach(presenca => {
                const item = document.createElement('div');
                item.className = 'flex justify-between items-center p-2 bg-gray-700 rounded';
                item.innerHTML = `
                    <span>${presenca.nome} - ${presenca.curso}</span>
                    <span class="text-xs opacity-60">${new Date(presenca.timestamp).toLocaleTimeString('pt-BR')}</span>
                `;
                container.appendChild(item);
            });
        }

        function gerarQRCode() {
            if (!palestraAtual) return;
            
            const qrData = JSON.stringify({
                type: 'palestra_presenca',
                palestraId: palestraAtual.id,
                titulo: palestraAtual.titulo
            });
            
            const qrContainer = document.getElementById('qrcode');
            qrContainer.innerHTML = '';
            
            QRCode.toCanvas(qrContainer, qrData, {
                width: 200,
                height: 200,
                colorDark: '#000000',
                colorLight: '#ffffff'
            });
            
            document.getElementById('qrCodeContainer').style.display = 'block';
        }

        function fecharPresenca() {
            document.getElementById('presencaSection').style.display = 'none';
            document.getElementById('qrCodeContainer').style.display = 'none';
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
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'relatorio_frequencia_palestras.txt';
            a.click();
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
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'relatorio_por_curso_palestras.txt';
            a.click();
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
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'pontuacao_palestras.txt';
            a.click();
        }

        // Inicializar
        renderizarPalestras();
    </script>
</body>
</html>
