<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 10 - Workshops | SESMATED</title>
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
            <h1 class="text-3xl font-bold text-center">Tarefa 10 - Workshops</h1>
            <p class="text-center mt-2 opacity-80">Sistema de Controle de Presença</p>
        </div>
    </header>

    <main class="container mx-auto p-6">
        <!-- Cadastro de Workshops -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Cadastrar Workshop</h2>
            <form id="workshopForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Título do Workshop</label>
                    <input type="text" id="tituloWorkshop" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Instrutor</label>
                    <input type="text" id="instrutor" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Data</label>
                    <input type="date" id="dataWorkshop" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Horário</label>
                    <input type="time" id="horarioWorkshop" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Duração (horas)</label>
                    <input type="number" id="duracao" class="custom-input w-full p-3 rounded-lg" min="1" max="8" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Vagas Disponíveis</label>
                    <input type="number" id="vagas" class="custom-input w-full p-3 rounded-lg" min="1" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Descrição</label>
                    <textarea id="descricaoWorkshop" class="custom-input w-full p-3 rounded-lg" rows="3"></textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="custom-button px-6 py-3 rounded-lg font-medium">
                        Cadastrar Workshop
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Workshops -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Workshops Cadastrados</h2>
            <div id="workshopsList" class="space-y-4">
                <!-- Workshops serão inseridos aqui -->
            </div>
        </div>

        <!-- Registro de Presença -->
        <div class="custom-card rounded-lg p-6 mb-8" id="presencaSection" style="display: none;">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Registrar Presença</h2>
            <div id="presencaForm">
                <div class="mb-4">
                    <h3 class="text-xl font-semibold mb-2" id="workshopAtual"></h3>
                    <div class="flex gap-4 text-sm opacity-80">
                        <span id="vagasInfo"></span>
                        <span id="duracaoInfo"></span>
                    </div>
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
                    <h4 class="text-lg font-semibold mb-4">Participantes Inscritos</h4>
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
                <button onclick="relatorioOcupacao()" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
                    Relatório de Ocupação
                </button>
            </div>
        </div>
    </main>

    <script>
        let workshops = JSON.parse(localStorage.getItem('workshops') || '[]');
        let presencas = JSON.parse(localStorage.getItem('presencas_workshops') || '[]');
        let workshopAtual = null;

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
            renderizarWorkshops();
            
            alert('Workshop cadastrado com sucesso!');
        });

        function renderizarWorkshops() {
            const container = document.getElementById('workshopsList');
            container.innerHTML = '';
            
            workshops.forEach(workshop => {
                const presencasWorkshop = presencas.filter(p => p.workshopId === workshop.id);
                const totalInscritos = presencasWorkshop.length;
                const vagasRestantes = workshop.vagas - totalInscritos;
                
                const card = document.createElement('div');
                card.className = 'custom-card p-4 rounded-lg';
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg mb-2">${workshop.titulo}</h3>
                            <p class="text-sm opacity-80 mb-1"><strong>Instrutor:</strong> ${workshop.instrutor}</p>
                            <p class="text-sm opacity-80 mb-1"><strong>Data:</strong> ${new Date(workshop.data).toLocaleDateString('pt-BR')}</p>
                            <p class="text-sm opacity-80 mb-1"><strong>Horário:</strong> ${workshop.horario}</p>
                            <p class="text-sm opacity-80 mb-1"><strong>Duração:</strong> ${workshop.duracao}h</p>
                            <p class="text-sm opacity-80 mb-3"><strong>Descrição:</strong> ${workshop.descricao}</p>
                        </div>
                        <div class="text-right ml-4">
                            <p class="text-sm font-semibold text-yellow-400">Inscritos: ${totalInscritos}/${workshop.vagas}</p>
                            <p class="text-xs ${vagasRestantes > 0 ? 'text-green-400' : 'text-red-400'}">
                                ${vagasRestantes > 0 ? `${vagasRestantes} vagas restantes` : 'Lotado'}
                            </p>
                        </div>
                    </div>
                    <button onclick="abrirPresenca(${workshop.id})" 
                            class="custom-button px-4 py-2 rounded text-sm font-medium">
                        Gerenciar Inscrições
                    </button>
                `;
                container.appendChild(card);
            });
        }

        function abrirPresenca(id) {
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
            
            document.getElementById('presencaSection').style.display = 'block';
            document.getElementById('presencaSection').scrollIntoView({ behavior: 'smooth' });
            
            atualizarListaPresentes();
        }

        function registrarPresenca() {
            if (!workshopAtual || !document.getElementById('nomeParticipante').value || !document.getElementById('cursoParticipante').value) {
                alert('Preencha todos os campos!');
                return;
            }
            
            const nome = document.getElementById('nomeParticipante').value;
            const curso = document.getElementById('cursoParticipante').value;
            
            // Verificar vagas disponíveis
            const presencasWorkshop = presencas.filter(p => p.workshopId === workshopAtual.id);
            if (presencasWorkshop.length >= workshopAtual.vagas) {
                alert('Workshop lotado! Não há mais vagas disponíveis.');
                return;
            }
            
            // Verificar se já está registrado
            const jaRegistrado = presencas.some(p => 
                p.workshopId === workshopAtual.id && 
                p.nome.toLowerCase() === nome.toLowerCase()
            );
            
            if (jaRegistrado) {
                alert('Participante já inscrito neste workshop!');
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
            
            atualizarListaPresentes();
            renderizarWorkshops();
            
            alert('Inscrição realizada com sucesso!');
        }

        function atualizarListaPresentes() {
            if (!workshopAtual) return;
            
            const presencasWorkshop = presencas.filter(p => p.workshopId === workshopAtual.id);
            const container = document.getElementById('listaPresentes');
            
            container.innerHTML = '';
            
            presencasWorkshop.forEach((presenca, index) => {
                const item = document.createElement('div');
                item.className = 'flex justify-between items-center p-2 bg-gray-700 rounded';
                item.innerHTML = `
                    <span>${index + 1}. ${presenca.nome} - ${presenca.curso}</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs opacity-60">${new Date(presenca.timestamp).toLocaleTimeString('pt-BR')}</span>
                        <button onclick="removerInscricao(${presenca.id})" class="text-red-400 hover:text-red-300 text-xs">
                            Remover
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
                atualizarListaPresentes();
                renderizarWorkshops();
            }
        }

        function gerarQRCode() {
            if (!workshopAtual) return;
            
            const qrData = JSON.stringify({
                type: 'workshop_presenca',
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
            
            document.getElementById('qrCodeContainer').style.display = 'block';
        }

        function fecharPresenca() {
            document.getElementById('presencaSection').style.display = 'none';
            document.getElementById('qrCodeContainer').style.display = 'none';
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
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'relatorio_frequencia_workshops.txt';
            a.click();
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
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'relatorio_por_curso_workshops.txt';
            a.click();
        }

        function calcularPontuacao() {
            let relatorio = 'PONTUAÇÃO - WORKSHOPS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            const participantesUnicos = {};
            
            presencas.forEach(presenca => {
                const key = `${presenca.nome}_${presenca.curso}`;
                if (!participantesUnicos[key]) {
                    participantesUnicos[key] = {
                        nome: presenca.nome,
                        curso: presenca.curso,
                        workshopsParticipados: 0
                    };
                }
                participantesUnicos[key].workshopsParticipados++;
            });
            
            Object.values(participantesUnicos).forEach(participante => {
                const percentual = (participante.workshopsParticipados / workshops.length) * 100;
                let pontos = 0;
                
                if (percentual === 100) {
                    pontos = 500;
                } else if (percentual >= 80) {
                    pontos = 400;
                } else if (percentual >= 50) {
                    pontos = 300;
                }
                
                relatorio += `${participante.nome} (${participante.curso})\n`;
                relatorio += `Participação: ${percentual.toFixed(1)}%\n`;
                relatorio += `Pontuação: ${pontos} pontos\n\n`;
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'pontuacao_workshops.txt';
            a.click();
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
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'relatorio_ocupacao_workshops.txt';
            a.click();
        }

        // Inicializar
        renderizarWorkshops();
    </script>
</body>
</html>
