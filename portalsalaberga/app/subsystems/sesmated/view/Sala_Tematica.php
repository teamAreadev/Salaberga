<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 13 - Sala Temática | SESMATED</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <h1 class="text-3xl font-bold text-center">Tarefa 13 - Sala Temática</h1>
            <p class="text-center mt-2 opacity-80">"Construindo Comunidades Sustentáveis: Saúde, Gestão e Inovação"</p>
        </div>
    </header>

    <main class="container mx-auto p-6">
        <!-- Cadastro de Salas -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Cadastrar Sala Temática</h2>
            <form id="salaForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nome da Sala</label>
                        <input type="text" id="nomeSala" class="custom-input w-full p-3 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Curso Responsável</label>
                        <select id="cursoSala" class="custom-input w-full p-3 rounded-lg" required>
                            <option value="">Selecione o curso</option>
                            <option value="Informática">Informática</option>
                            <option value="Enfermagem">Enfermagem</option>
                            <option value="Administração">Administração</option>
                            <option value="Agropecuária">Agropecuária</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Equipe Responsável (separar nomes por vírgula)</label>
                    <textarea id="equipeSala" class="custom-input w-full p-3 rounded-lg" rows="2"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Descrição da Proposta</label>
                    <textarea id="descricaoSala" class="custom-input w-full p-3 rounded-lg" rows="4" required></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Como aborda Saúde, Gestão e Inovação</label>
                    <textarea id="abordagemTema" class="custom-input w-full p-3 rounded-lg" rows="4" required></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Materiais Utilizados</label>
                        <textarea id="materiaisSala" class="custom-input w-full p-3 rounded-lg" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Recursos Sustentáveis</label>
                        <textarea id="recursosSustentaveis" class="custom-input w-full p-3 rounded-lg" rows="3"></textarea>
                    </div>
                </div>
                
                <button type="submit" class="custom-button px-6 py-3 rounded-lg font-medium">
                    Cadastrar Sala
                </button>
            </form>
        </div>

        <!-- Lista de Salas -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Salas Cadastradas</h2>
            <div id="salasList" class="space-y-4">
                <!-- Salas serão inseridas aqui -->
            </div>
        </div>

        <!-- Sistema de Avaliação -->
        <div class="custom-card rounded-lg p-6 mb-8" id="avaliacaoSection" style="display: none;">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Avaliar Sala Temática</h2>
            <div id="avaliacaoForm">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2" id="salaAvaliando"></h3>
                    <p class="text-sm opacity-80" id="descricaoAvaliando"></p>
                </div>
                
                <!-- Critérios de Avaliação -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">🎯 Adequação ao Tema Proposto (0-20 pontos)</label>
                        <input type="range" id="adequacaoTema" min="0" max="20" value="0" class="w-full">
                        <span id="adequacaoTemaValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Foco temático, pertinência e coerência com a proposta geral do evento</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">🧠 Qualidade do Conteúdo Apresentado (0-20 pontos)</label>
                        <input type="range" id="qualidadeConteudo" min="0" max="20" value="0" class="w-full">
                        <span id="qualidadeConteudoValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Rigor informativo, valor educativo e conexão crítica</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">🖼 Ambientação e Criatividade (0-15 pontos)</label>
                        <input type="range" id="ambientacao" min="0" max="15" value="0" class="w-full">
                        <span id="ambientacaoValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Estética, criatividade e esforço na construção do ambiente</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">📚 Didática e Clareza na Apresentação Oral (0-15 pontos)</label>
                        <input type="range" id="didatica" min="0" max="15" value="0" class="w-full">
                        <span id="didaticaValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Comunicação, domínio do tema e interação com os visitantes</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">🤝 Trabalho em Equipe e Organização (0-10 pontos)</label>
                        <input type="range" id="trabalhoEquipe" min="0" max="10" value="0" class="w-full">
                        <span id="trabalhoEquipeValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Organização e cooperação entre os alunos</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">♻️ Sustentabilidade na Execução (0-10 pontos)</label>
                        <input type="range" id="sustentabilidadeExecucao" min="0" max="10" value="0" class="w-full">
                        <span id="sustentabilidadeExecucaoValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Coerência entre discurso e prática sustentável</p>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-gray-800 rounded-lg">
                    <h4 class="text-lg font-semibold mb-2">Pontuação Total: <span id="totalPontos" class="text-yellow-400">0</span>/100</h4>
                </div>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium mb-2">Nome do Jurado</label>
                    <input type="text" id="nomeJurado" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium mb-2">Observações</label>
                    <textarea id="observacoes" class="custom-input w-full p-3 rounded-lg" rows="3"></textarea>
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
                <button onclick="calcularPontuacao()" class="bg-yellow-600 text-white px-6 py-3 rounded-lg font-medium">
                    Calcular Pontuação por Posição
                </button>
            </div>
        </div>
    </main>

    <script>
        let salas = JSON.parse(localStorage.getItem('salas_tematicas') || '[]');
        let avaliacoes = JSON.parse(localStorage.getItem('avaliacoes_salas') || '[]');
        let salaAtual = null;

        // Atualizar valores dos sliders
        document.querySelectorAll('input[type="range"]').forEach(slider => {
            slider.addEventListener('input', function() {
                document.getElementById(this.id + 'Value').textContent = this.value + ' pontos';
                calcularTotal();
            });
        });

        function calcularTotal() {
            const adequacaoTema = parseInt(document.getElementById('adequacaoTema').value);
            const qualidadeConteudo = parseInt(document.getElementById('qualidadeConteudo').value);
            const ambientacao = parseInt(document.getElementById('ambientacao').value);
            const didatica = parseInt(document.getElementById('didatica').value);
            const trabalhoEquipe = parseInt(document.getElementById('trabalhoEquipe').value);
            const sustentabilidadeExecucao = parseInt(document.getElementById('sustentabilidadeExecucao').value);
            
            const total = adequacaoTema + qualidadeConteudo + ambientacao + didatica + trabalhoEquipe + sustentabilidadeExecucao;
            document.getElementById('totalPontos').textContent = total;
        }

        document.getElementById('salaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const sala = {
                id: Date.now(),
                nome: document.getElementById('nomeSala').value,
                curso: document.getElementById('cursoSala').value,
                equipe: document.getElementById('equipeSala').value,
                descricao: document.getElementById('descricaoSala').value,
                abordagemTema: document.getElementById('abordagemTema').value,
                materiais: document.getElementById('materiaisSala').value,
                recursosSustentaveis: document.getElementById('recursosSustentaveis').value,
                timestamp: new Date().toISOString()
            };
            
            salas.push(sala);
            localStorage.setItem('salas_tematicas', JSON.stringify(salas));
            
            this.reset();
            renderizarSalas();
            
            alert('Sala temática cadastrada com sucesso!');
        });

        function renderizarSalas() {
            const container = document.getElementById('salasList');
            container.innerHTML = '';
            
            salas.forEach(sala => {
                const avaliacoesSala = avaliacoes.filter(a => a.salaId === sala.id);
                const mediaNotas = avaliacoesSala.length > 0 
                    ? (avaliacoesSala.reduce((sum, a) => sum + a.total, 0) / avaliacoesSala.length).toFixed(1)
                    : 'Não avaliado';
                
                const card = document.createElement('div');
                card.className = 'custom-card p-6 rounded-lg';
                card.innerHTML = `
                    <div class="mb-4">
                        <h3 class="font-bold text-xl mb-2">${sala.nome}</h3>
                        <p class="text-sm opacity-80 mb-2"><strong>Curso:</strong> ${sala.curso}</p>
                        <p class="text-sm opacity-80 mb-2"><strong>Equipe:</strong> ${sala.equipe}</p>
                        <p class="text-sm opacity-80 mb-3"><strong>Descrição:</strong> ${sala.descricao}</p>
                        <p class="text-sm opacity-80 mb-2"><strong>Abordagem do Tema:</strong> ${sala.abordagemTema}</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm opacity-80"><strong>Materiais:</strong> ${sala.materiais}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-80"><strong>Recursos Sustentáveis:</strong> ${sala.recursosSustentaveis}</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm mb-1"><strong>Média:</strong> <span class="text-yellow-400">${mediaNotas}</span>/100</p>
                                <p class="text-xs opacity-60">Avaliações: ${avaliacoesSala.length}</p>
                            </div>
                            <button onclick="avaliarSala(${sala.id})" 
                                    class="custom-button px-4 py-2 rounded text-sm font-medium">
                                Avaliar
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function avaliarSala(id) {
            salaAtual = salas.find(s => s.id === id);
            document.getElementById('salaAvaliando').textContent = 
                `${salaAtual.nome} (${salaAtual.curso})`;
            document.getElementById('descricaoAvaliando').textContent = salaAtual.descricao;
            
            // Reset form
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.value = 0;
                document.getElementById(slider.id + 'Value').textContent = '0 pontos';
            });
            document.getElementById('nomeJurado').value = '';
            document.getElementById('observacoes').value = '';
            calcularTotal();
            
            document.getElementById('avaliacaoSection').style.display = 'block';
            document.getElementById('avaliacaoSection').scrollIntoView({ behavior: 'smooth' });
        }

        function salvarAvaliacao() {
            if (!salaAtual || !document.getElementById('nomeJurado').value) {
                alert('Preencha o nome do jurado!');
                return;
            }
            
            const avaliacao = {
                id: Date.now(),
                salaId: salaAtual.id,
                jurado: document.getElementById('nomeJurado').value,
                adequacaoTema: parseInt(document.getElementById('adequacaoTema').value),
                qualidadeConteudo: parseInt(document.getElementById('qualidadeConteudo').value),
                ambientacao: parseInt(document.getElementById('ambientacao').value),
                didatica: parseInt(document.getElementById('didatica').value),
                trabalhoEquipe: parseInt(document.getElementById('trabalhoEquipe').value),
                sustentabilidadeExecucao: parseInt(document.getElementById('sustentabilidadeExecucao').value),
                total: parseInt(document.getElementById('totalPontos').textContent),
                observacoes: document.getElementById('observacoes').value,
                timestamp: new Date().toISOString()
            };
            
            avaliacoes.push(avaliacao);
            localStorage.setItem('avaliacoes_salas', JSON.stringify(avaliacoes));
            
            alert('Avaliação salva com sucesso!');
            fecharAvaliacao();
            renderizarSalas();
        }

        function fecharAvaliacao() {
            document.getElementById('avaliacaoSection').style.display = 'none';
            salaAtual = null;
        }

        function gerarRelatorioGeral() {
            let relatorio = 'RELATÓRIO GERAL - SALAS TEMÁTICAS\n';
            relatorio += '='.repeat(60) + '\n\n';
            relatorio += 'TEMA: "Construindo Comunidades Sustentáveis: Saúde, Gestão e Inovação"\n\n';
            
            salas.forEach(sala => {
                const avaliacoesSala = avaliacoes.filter(a => a.salaId === sala.id);
                relatorio += `SALA: ${sala.nome}\n`;
                relatorio += `Curso: ${sala.curso}\n`;
                relatorio += `Equipe: ${sala.equipe}\n`;
                relatorio += `Descrição: ${sala.descricao}\n`;
                relatorio += `Abordagem do Tema: ${sala.abordagemTema}\n`;
                relatorio += `Materiais: ${sala.materiais}\n`;
                relatorio += `Recursos Sustentáveis: ${sala.recursosSustentaveis}\n\n`;
                
                if (avaliacoesSala.length > 0) {
                    relatorio += 'AVALIAÇÕES:\n';
                    avaliacoesSala.forEach(av => {
                        relatorio += `  Jurado: ${av.jurado}\n`;
                        relatorio += `  Adequação ao Tema: ${av.adequacaoTema}/20\n`;
                        relatorio += `  Qualidade do Conteúdo: ${av.qualidadeConteudo}/20\n`;
                        relatorio += `  Ambientação: ${av.ambientacao}/15\n`;
                        relatorio += `  Didática: ${av.didatica}/15\n`;
                        relatorio += `  Trabalho em Equipe: ${av.trabalhoEquipe}/10\n`;
                        relatorio += `  Sustentabilidade: ${av.sustentabilidadeExecucao}/10\n`;
                        relatorio += `  TOTAL: ${av.total}/100\n`;
                        if (av.observacoes) {
                            relatorio += `  Observações: ${av.observacoes}\n`;
                        }
                        relatorio += '\n';
                    });
                    
                    const media = (avaliacoesSala.reduce((sum, a) => sum + a.total, 0) / avaliacoesSala.length).toFixed(2);
                    relatorio += `MÉDIA FINAL: ${media}/100\n`;
                } else {
                    relatorio += 'Não avaliado\n';
                }
                
                relatorio += '-'.repeat(40) + '\n\n';
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'relatorio_salas_tematicas.txt';
            a.click();
        }

        function gerarRanking() {
            const ranking = salas.map(sala => {
                const avaliacoesSala = avaliacoes.filter(a => a.salaId === sala.id);
                const media = avaliacoesSala.length > 0 
                    ? avaliacoesSala.reduce((sum, a) => sum + a.total, 0) / avaliacoesSala.length
                    : 0;
                
                return {
                    ...sala,
                    media: media,
                    totalAvaliacoes: avaliacoesSala.length
                };
            }).sort((a, b) => b.media - a.media);
            
            let relatorio = 'RANKING FINAL - SALAS TEMÁTICAS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            ranking.forEach((sala, index) => {
                relatorio += `${index + 1}º LUGAR\n`;
                relatorio += `Sala: ${sala.nome}\n`;
                relatorio += `Curso: ${sala.curso}\n`;
                relatorio += `Equipe: ${sala.equipe}\n`;
                relatorio += `Média: ${sala.media.toFixed(2)}/100\n`;
                relatorio += `Avaliações: ${sala.totalAvaliacoes}\n\n`;
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'ranking_salas_tematicas.txt';
            a.click();
        }

        function calcularPontuacao() {
            const ranking = salas.map(sala => {
                const avaliacoesSala = avaliacoes.filter(a => a.salaId === sala.id);
                const media = avaliacoesSala.length > 0 
                    ? avaliacoesSala.reduce((sum, a) => sum + a.total, 0) / avaliacoesSala.length
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
                relatorio += `Equipe: ${sala.equipe}\n`;
                relatorio += `Média de avaliação: ${sala.media.toFixed(2)}/100\n\n`;
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'pontuacao_posicao_salas_tematicas.txt';
            a.click();
        }

        // Inicializar
        renderizarSalas();
    </script>
</body>
</html>
