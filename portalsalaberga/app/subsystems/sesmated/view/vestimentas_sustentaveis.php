<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 08 - Vestimentas Sustentáveis | SESMATED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        :root {
            --background-color:rgb(3, 3, 3);
            --text-color: #ffffff;
            --header-color: #00b348;
            --icon-bg: #2d2d2d;
            --icon-shadow: rgba(0, 0, 0, 0.3);
            --accent-color: #ffb733;
            --grid-color: #333333;
            --card-bg: rgba(45, 45, 45, 0.9);
            --header-bg: rgba(3, 3, 3);
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
            <h1 class="text-3xl font-bold text-center">Tarefa 08 - Vestimentas Sustentáveis</h1>
            <p class="text-center mt-2 opacity-80">Sistema de Avaliação e Votação</p>
        </div>
    </header>

    <main class="container mx-auto p-6">
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Cadastrar Participante</h2>
            <form id="participantForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nome do Modelo</label>
                    <input type="text" id="nomeModelo" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Curso</label>
                    <select id="curso" class="custom-input w-full p-3 rounded-lg" required>
                        <option value="">Selecione o curso</option>
                        <option value="Informática">Informática</option>
                        <option value="Enfermagem">Enfermagem</option>
                        <option value="Administração">Administração</option>
                        <option value="Agropecuária">Agropecuária</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Gênero</label>
                    <select id="genero" class="custom-input w-full p-3 rounded-lg" required>
                        <option value="">Selecione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Descrição da Vestimenta</label>
                    <textarea id="descricao" class="custom-input w-full p-3 rounded-lg" rows="3"></textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="custom-button px-6 py-3 rounded-lg font-medium hover:opacity-90 transition-all">
                        Cadastrar Participante
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Participantes -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Participantes Cadastrados</h2>
            <div id="participantsList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Participantes serão inseridos aqui -->
            </div>
        </div>

        <!-- Sistema de Avaliação -->
        <div class="custom-card rounded-lg p-6 mb-8" id="avaliacaoSection" style="display: none;">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Avaliar Participante</h2>
            <div id="avaliacaoForm">
                <div class="mb-4">
                    <h3 class="text-xl font-semibold mb-2" id="participanteAvaliando"></h3>
                </div>
                
                <!-- Critérios de Avaliação -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">♻️ Uso de Materiais Sustentáveis (0-20 pontos)</label>
                            <input type="range" id="materiais" min="0" max="20" value="0" class="w-full">
                            <span id="materiaisValue" class="text-sm text-yellow-400">0 pontos</span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">🎨 Criatividade e Design (0-20 pontos)</label>
                            <input type="range" id="criatividade" min="0" max="20" value="0" class="w-full">
                            <span id="criatividadeValue" class="text-sm text-yellow-400">0 pontos</span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">👗 Estética e Harmonia Visual (0-20 pontos)</label>
                            <input type="range" id="estetica" min="0" max="20" value="0" class="w-full">
                            <span id="esteticaValue" class="text-sm text-yellow-400">0 pontos</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">🎓 Identidade com o Curso (0-15 pontos)</label>
                            <input type="range" id="identidade" min="0" max="15" value="0" class="w-full">
                            <span id="identidadeValue" class="text-sm text-yellow-400">0 pontos</span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">🧍 Desfile e Apresentação (0-15 pontos)</label>
                            <input type="range" id="desfile" min="0" max="15" value="0" class="w-full">
                            <span id="desfileValue" class="text-sm text-yellow-400">0 pontos</span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">🧵 Acabamento e Estrutura (0-10 pontos)</label>
                            <input type="range" id="acabamento" min="0" max="10" value="0" class="w-full">
                            <span id="acabamentoValue" class="text-sm text-yellow-400">0 pontos</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-gray-800 rounded-lg">
                    <h4 class="text-lg font-semibold mb-2">Pontuação Total: <span id="totalPontos" class="text-yellow-400">0</span>/100</h4>
                </div>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium mb-2">Nome do Jurado</label>
                    <input type="text" id="nomeJurado" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                
                <div class="mt-6">
                    <button onclick="salvarAvaliacao()" class="custom-button px-6 py-3 rounded-lg font-medium mr-4">
                        Salvar Avaliação
                    </button>
                    <button onclick="fecharAvaliacao()" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-medium">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>

        <!-- Relatórios -->
        <div class="custom-card rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Relatórios</h2>
            <div class="flex flex-wrap gap-4">
                <button onclick="gerarRelatorioGeral()" class="custom-button px-6 py-3 rounded-lg font-medium">
                    Relatório Geral
                </button>
                <button onclick="gerarRanking()" class="bg-purple-600 text-white px-6 py-3 rounded-lg font-medium">
                    Ranking Final
                </button>
            </div>
        </div>
    </main>

    <script>
        let participantes = JSON.parse(localStorage.getItem('vestimentas_participantes') || '[]');
        let avaliacoes = JSON.parse(localStorage.getItem('vestimentas_avaliacoes') || '[]');
        let participanteAtual = null;

        document.querySelectorAll('input[type="range"]').forEach(slider => {
            slider.addEventListener('input', function() {
                document.getElementById(this.id + 'Value').textContent = this.value + ' pontos';
                calcularTotal();
            });
        });

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
            renderizarParticipantes();
            
            alert('Participante cadastrado com sucesso!');
        });

        function renderizarParticipantes() {
            const container = document.getElementById('participantsList');
            container.innerHTML = '';
            
            participantes.forEach(participante => {
                const avaliacoesParticipante = avaliacoes.filter(a => a.participanteId === participante.id);
                const mediaNotas = avaliacoesParticipante.length > 0 
                    ? (avaliacoesParticipante.reduce((sum, a) => sum + a.total, 0) / avaliacoesParticipante.length).toFixed(1)
                    : 'Não avaliado';
                
                const card = document.createElement('div');
                card.className = 'custom-card p-4 rounded-lg';
                card.innerHTML = `
                    <h3 class="font-bold text-lg mb-2">${participante.nome}</h3>
                    <p class="text-sm opacity-80 mb-1"><strong>Curso:</strong> ${participante.curso}</p>
                    <p class="text-sm opacity-80 mb-1"><strong>Gênero:</strong> ${participante.genero}</p>
                    <p class="text-sm opacity-80 mb-3"><strong>Descrição:</strong> ${participante.descricao}</p>
                    <p class="text-sm mb-3"><strong>Média:</strong> <span class="text-yellow-400">${mediaNotas}</span></p>
                    <p class="text-xs opacity-60 mb-3">Avaliações: ${avaliacoesParticipante.length}</p>
                    <button onclick="avaliarParticipante(${participante.id})" 
                            class="custom-button px-4 py-2 rounded text-sm font-medium w-full">
                        Avaliar
                    </button>
                `;
                container.appendChild(card);
            });
        }

        function avaliarParticipante(id) {
            participanteAtual = participantes.find(p => p.id === id);
            document.getElementById('participanteAvaliando').textContent = 
                `Avaliando: ${participanteAtual.nome} (${participanteAtual.curso})`;
            
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.value = 0;
                document.getElementById(slider.id + 'Value').textContent = '0 pontos';
            });
            document.getElementById('nomeJurado').value = '';
            calcularTotal();
            
            document.getElementById('avaliacaoSection').style.display = 'block';
            document.getElementById('avaliacaoSection').scrollIntoView({ behavior: 'smooth' });
        }

        function salvarAvaliacao() {
            if (!participanteAtual || !document.getElementById('nomeJurado').value) {
                alert('Preencha o nome do jurado!');
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
            
            alert('Avaliação salva com sucesso!');
            fecharAvaliacao();
            renderizarParticipantes();
        }

        function fecharAvaliacao() {
            document.getElementById('avaliacaoSection').style.display = 'none';
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
            
            // Download do relatório
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'relatorio_vestimentas_sustentaveis.txt';
            a.click();
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
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'ranking_vestimentas_sustentaveis.txt';
            a.click();
        }

        // Inicializar
        renderizarParticipantes();
    </script>
</body>
</html>
