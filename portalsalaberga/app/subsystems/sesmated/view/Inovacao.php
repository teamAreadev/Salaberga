<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 11 - Inovação | SESMATED</title>
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
            <h1 class="text-3xl font-bold text-center">Tarefa 11 - Inovação</h1>
            <p class="text-center mt-2 opacity-80">Produtos Úteis à Comunidade Maranguapense</p>
        </div>
    </header>

    <main class="container mx-auto p-6">
        <!-- Cadastro de Projetos -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Cadastrar Projeto de Inovação</h2>
            <form id="projetoForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nome do Projeto</label>
                        <input type="text" id="nomeProjeto" class="custom-input w-full p-3 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Curso</label>
                        <select id="cursoProjeto" class="custom-input w-full p-3 rounded-lg" required>
                            <option value="">Selecione o curso</option>
                            <option value="Informática">Informática</option>
                            <option value="Enfermagem">Enfermagem</option>
                            <option value="Administração">Administração</option>
                            <option value="Agropecuária">Agropecuária</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Equipe (separar nomes por vírgula)</label>
                    <textarea id="equipeProjeto" class="custom-input w-full p-3 rounded-lg" rows="2" placeholder="João Silva, Maria Santos, Pedro Oliveira"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Descrição do Projeto</label>
                    <textarea id="descricaoProjeto" class="custom-input w-full p-3 rounded-lg" rows="4" required></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Problema que Resolve</label>
                    <textarea id="problemaProjeto" class="custom-input w-full p-3 rounded-lg" rows="3" required></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Benefícios para a Comunidade</label>
                    <textarea id="beneficiosProjeto" class="custom-input w-full p-3 rounded-lg" rows="3" required></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Recursos Necessários</label>
                        <textarea id="recursosProjeto" class="custom-input w-full p-3 rounded-lg" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Tecnologias Utilizadas</label>
                        <textarea id="tecnologiasProjeto" class="custom-input w-full p-3 rounded-lg" rows="3"></textarea>
                    </div>
                </div>
                
                <button type="submit" class="custom-button px-6 py-3 rounded-lg font-medium">
                    Cadastrar Projeto
                </button>
            </form>
        </div>

        <!-- Lista de Projetos -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Projetos Cadastrados</h2>
            <div id="projetosList" class="space-y-4">
                <!-- Projetos serão inseridos aqui -->
            </div>
        </div>

        <!-- Sistema de Avaliação -->
        <div class="custom-card rounded-lg p-6 mb-8" id="avaliacaoSection" style="display: none;">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Avaliar Projeto</h2>
            <div id="avaliacaoForm">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2" id="projetoAvaliando"></h3>
                    <p class="text-sm opacity-80" id="descricaoAvaliando"></p>
                </div>
                
                <!-- Critérios de Avaliação -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">💡 Originalidade e Inovação (0-20 pontos)</label>
                        <input type="range" id="originalidade" min="0" max="20" value="0" class="w-full">
                        <span id="originalidadeValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Grau de inovação, inventividade e criatividade na abordagem</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">🧩 Relevância e Aplicabilidade para a Comunidade (0-20 pontos)</label>
                        <input type="range" id="relevancia" min="0" max="20" value="0" class="w-full">
                        <span id="relevanciaValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Conexão com necessidades reais, impacto direto ou indireto</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">⚙️ Viabilidade Técnica (0-15 pontos)</label>
                        <input type="range" id="viabilidade" min="0" max="15" value="0" class="w-full">
                        <span id="viabilidadeValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Exequibilidade e nível de prototipagem</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">🌱 Sustentabilidade e Responsabilidade Socioambiental (0-15 pontos)</label>
                        <input type="range" id="sustentabilidade" min="0" max="15" value="0" class="w-full">
                        <span id="sustentabilidadeValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Compromisso com o meio ambiente e ética social</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">📊 Clareza e Organização da Apresentação (0-10 pontos)</label>
                        <input type="range" id="apresentacao" min="0" max="10" value="0" class="w-full">
                        <span id="apresentacaoValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Comunicação e domínio do conteúdo</p>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-gray-800 rounded-lg">
                    <h4 class="text-lg font-semibold mb-2">Pontuação Total: <span id="totalPontos" class="text-yellow-400">0</span>/80</h4>
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
        let projetos = JSON.parse(localStorage.getItem('projetos_inovacao') || '[]');
        let avaliacoes = JSON.parse(localStorage.getItem('avaliacoes_inovacao') || '[]');
        let projetoAtual = null;

        // Atualizar valores dos sliders
        document.querySelectorAll('input[type="range"]').forEach(slider => {
            slider.addEventListener('input', function() {
                document.getElementById(this.id + 'Value').textContent = this.value + ' pontos';
                calcularTotal();
            });
        });

        function calcularTotal() {
            const originalidade = parseInt(document.getElementById('originalidade').value);
            const relevancia = parseInt(document.getElementById('relevancia').value);
            const viabilidade = parseInt(document.getElementById('viabilidade').value);
            const sustentabilidade = parseInt(document.getElementById('sustentabilidade').value);
            const apresentacao = parseInt(document.getElementById('apresentacao').value);
            
            const total = originalidade + relevancia + viabilidade + sustentabilidade + apresentacao;
            document.getElementById('totalPontos').textContent = total;
        }

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
            renderizarProjetos();
            
            alert('Projeto cadastrado com sucesso!');
        });

        function renderizarProjetos() {
            const container = document.getElementById('projetosList');
            container.innerHTML = '';
            
            projetos.forEach(projeto => {
                const avaliacoesProjeto = avaliacoes.filter(a => a.projetoId === projeto.id);
                const mediaNotas = avaliacoesProjeto.length > 0 
                    ? (avaliacoesProjeto.reduce((sum, a) => sum + a.total, 0) / avaliacoesProjeto.length).toFixed(1)
                    : 'Não avaliado';
                
                const card = document.createElement('div');
                card.className = 'custom-card p-6 rounded-lg';
                card.innerHTML = `
                    <div class="mb-4">
                        <h3 class="font-bold text-xl mb-2">${projeto.nome}</h3>
                        <p class="text-sm opacity-80 mb-2"><strong>Curso:</strong> ${projeto.curso}</p>
                        <p class="text-sm opacity-80 mb-2"><strong>Equipe:</strong> ${projeto.equipe}</p>
                        <p class="text-sm opacity-80 mb-3"><strong>Descrição:</strong> ${projeto.descricao}</p>
                        <p class="text-sm opacity-80 mb-2"><strong>Problema:</strong> ${projeto.problema}</p>
                        <p class="text-sm opacity-80 mb-3"><strong>Benefícios:</strong> ${projeto.beneficios}</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm opacity-80"><strong>Recursos:</strong> ${projeto.recursos}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-80"><strong>Tecnologias:</strong> ${projeto.tecnologias}</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm mb-1"><strong>Média:</strong> <span class="text-yellow-400">${mediaNotas}</span>/80</p>
                                <p class="text-xs opacity-60">Avaliações: ${avaliacoesProjeto.length}</p>
                            </div>
                            <button onclick="avaliarProjeto(${projeto.id})" 
                                    class="custom-button px-4 py-2 rounded text-sm font-medium">
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
            
            document.getElementById('avaliacaoSection').style.display = 'block';
            document.getElementById('avaliacaoSection').scrollIntoView({ behavior: 'smooth' });
        }

        function salvarAvaliacao() {
            if (!projetoAtual || !document.getElementById('nomeJurado').value) {
                alert('Preencha o nome do jurado!');
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
            
            alert('Avaliação salva com sucesso!');
            fecharAvaliacao();
            renderizarProjetos();
        }

        function fecharAvaliacao() {
            document.getElementById('avaliacaoSection').style.display = 'none';
            projetoAtual = null;
        }

        function gerarRelatorioGeral() {
            let relatorio = 'RELATÓRIO GERAL - PROJETOS DE INOVAÇÃO\n';
            relatorio += '='.repeat(60) + '\n\n';
            
            projetos.forEach(projeto => {
                const avaliacoesProjeto = avaliacoes.filter(a => a.projetoId === projeto.id);
                relatorio += `PROJETO: ${projeto.nome}\n`;
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
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'relatorio_projetos_inovacao.txt';
            a.click();
        }

        function gerarRanking() {
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
                relatorio += `${index + 1}º LUGAR\n`;
                relatorio += `Projeto: ${projeto.nome}\n`;
                relatorio += `Curso: ${projeto.curso}\n`;
                relatorio += `Equipe: ${projeto.equipe}\n`;
                relatorio += `Média: ${projeto.media.toFixed(2)}/80\n`;
                relatorio += `Avaliações: ${projeto.totalAvaliacoes}\n\n`;
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'ranking_projetos_inovacao.txt';
            a.click();
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
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'pontuacao_posicao_inovacao.txt';
            a.click();
        }

        // Inicializar
        renderizarProjetos();
    </script>
</body>
</html>
