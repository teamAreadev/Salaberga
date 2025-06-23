<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 14 - Painel | SESMATED</title>
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
            <h1 class="text-3xl font-bold text-center">Tarefa 14 - Painel</h1>
            <p class="text-center mt-2 opacity-80">"Desenvolvimento econômico, social e sustentável para comunidades resilientes"</p>
            <p class="text-center mt-1 text-sm opacity-70">Tamanho: 2m x 1,8m</p>
        </div>
    </header>

    <main class="container mx-auto p-6">
        <!-- Cadastro de Painéis -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Cadastrar Painel</h2>
            <form id="painelForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Título do Painel</label>
                        <input type="text" id="tituloPainel" class="custom-input w-full p-3 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Curso Responsável</label>
                        <select id="cursoPainel" class="custom-input w-full p-3 rounded-lg" required>
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
                    <textarea id="equipePainel" class="custom-input w-full p-3 rounded-lg" rows="2"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Resumo do Conteúdo</label>
                    <textarea id="resumoPainel" class="custom-input w-full p-3 rounded-lg" rows="4" required></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Como aborda Desenvolvimento Econômico</label>
                    <textarea id="desenvolvimentoEconomico" class="custom-input w-full p-3 rounded-lg" rows="3" required></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Como aborda Desenvolvimento Social</label>
                    <textarea id="desenvolvimentoSocial" class="custom-input w-full p-3 rounded-lg" rows="3" required></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Como aborda Sustentabilidade</label>
                    <textarea id="sustentabilidade" class="custom-input w-full p-3 rounded-lg" rows="3" required></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Materiais Utilizados</label>
                        <textarea id="materiaisPainel" class="custom-input w-full p-3 rounded-lg" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Técnicas Aplicadas</label>
                        <textarea id="tecnicasPainel" class="custom-input w-full p-3 rounded-lg" rows="3"></textarea>
                    </div>
                </div>
                
                <button type="submit" class="custom-button px-6 py-3 rounded-lg font-medium">
                    Cadastrar Painel
                </button>
            </form>
        </div>

        <!-- Lista de Painéis -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Painéis Cadastrados</h2>
            <div id="paineisList" class="space-y-4">
                <!-- Painéis serão inseridos aqui -->
            </div>
        </div>

        <!-- Sistema de Avaliação -->
        <div class="custom-card rounded-lg p-6 mb-8" id="avaliacaoSection" style="display: none;">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Avaliar Painel</h2>
            <div id="avaliacaoForm">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2" id="painelAvaliando"></h3>
                    <p class="text-sm opacity-80" id="resumoAvaliando"></p>
                </div>
                
                <!-- Critérios de Avaliação -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">💰 Desenvolvimento Econômico (0-25 pontos)</label>
                        <input type="range" id="economico" min="0" max="25" value="0" class="w-full">
                        <span id="economicoValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Clareza na abordagem de aspectos econômicos para comunidades resilientes</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">👥 Desenvolvimento Social (0-25 pontos)</label>
                        <input type="range" id="social" min="0" max="25" value="0" class="w-full">
                        <span id="socialValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Abordagem de questões sociais e impacto na comunidade</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">🌱 Sustentabilidade (0-25 pontos)</label>
                        <input type="range" id="sustentabilidadePainel" min="0" max="25" value="0" class="w-full">
                        <span id="sustentabilidadePainelValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Integração de práticas sustentáveis e consciência ambiental</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">🎨 Qualidade Visual e Organização (0-15 pontos)</label>
                        <input type="range" id="qualidadeVisual" min="0" max="15" value="0" class="w-full">
                        <span id="qualidadeVisualValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Estética, organização e aproveitamento do espaço 2m x 1,8m</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">📚 Conteúdo e Informação (0-10 pontos)</label>
                        <input type="range" id="conteudoInfo" min="0" max="10" value="0" class="w-full">
                        <span id="conteudoInfoValue" class="text-sm text-yellow-400">0 pontos</span>
                        <p class="text-xs opacity-60 mt-1">Qualidade e relevância das informações apresentadas</p>
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
        let paineis = JSON.parse(localStorage.getItem('paineis') || '[]');
        let avaliacoes = JSON.parse(localStorage.getItem('avaliacoes_paineis') || '[]');
        let painelAtual = null;

        // Atualizar valores dos sliders
        document.querySelectorAll('input[type="range"]').forEach(slider => {
            slider.addEventListener('input', function() {
                document.getElementById(this.id + 'Value').textContent = this.value + ' pontos';
                calcularTotal();
            });
        });

        function calcularTotal() {
            const economico = parseInt(document.getElementById('economico').value);
            const social = parseInt(document.getElementById('social').value);
            const sustentabilidadePainel = parseInt(document.getElementById('sustentabilidadePainel').value);
            const qualidadeVisual = parseInt(document.getElementById('qualidadeVisual').value);
            const conteudoInfo = parseInt(document.getElementById('conteudoInfo').value);
            
            const total = economico + social + sustentabilidadePainel + qualidadeVisual + conteudoInfo;
            document.getElementById('totalPontos').textContent = total;
        }

        document.getElementById('painelForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const painel = {
                id: Date.now(),
                titulo: document.getElementById('tituloPainel').value,
                curso: document.getElementById('cursoPainel').value,
                equipe: document.getElementById('equipePainel').value,
                resumo: document.getElementById('resumoPainel').value,
                desenvolvimentoEconomico: document.getElementById('desenvolvimentoEconomico').value,
                desenvolvimentoSocial: document.getElementById('desenvolvimentoSocial').value,
                sustentabilidade: document.getElementById('sustentabilidade').value,
                materiais: document.getElementById('materiaisPainel').value,
                tecnicas: document.getElementById('tecnicasPainel').value,
                timestamp: new Date().toISOString()
            };
            
            paineis.push(painel);
            localStorage.setItem('paineis', JSON.stringify(paineis));
            
            this.reset();
            renderizarPaineis();
            
            alert('Painel cadastrado com sucesso!');
        });

        function renderizarPaineis() {
            const container = document.getElementById('paineisList');
            container.innerHTML = '';
            
            paineis.forEach(painel => {
                const avaliacoesPainel = avaliacoes.filter(a => a.painelId === painel.id);
                const mediaNotas = avaliacoesPainel.length > 0 
                    ? (avaliacoesPainel.reduce((sum, a) => sum + a.total, 0) / avaliacoesPainel.length).toFixed(1)
                    : 'Não avaliado';
                
                const card = document.createElement('div');
                card.className = 'custom-card p-6 rounded-lg';
                card.innerHTML = `
                    <div class="mb-4">
                        <h3 class="font-bold text-xl mb-2">${painel.titulo}</h3>
                        <p class="text-sm opacity-80 mb-2"><strong>Curso:</strong> ${painel.curso}</p>
                        <p class="text-sm opacity-80 mb-2"><strong>Equipe:</strong> ${painel.equipe}</p>
                        <p class="text-sm opacity-80 mb-3"><strong>Resumo:</strong> ${painel.resumo}</p>
                        
                        <div class="space-y-2 mb-4">
                            <p class="text-sm opacity-80"><strong>Desenvolvimento Econômico:</strong> ${painel.desenvolvimentoEconomico}</p>
                            <p class="text-sm opacity-80"><strong>Desenvolvimento Social:</strong> ${painel.desenvolvimentoSocial}</p>
                            <p class="text-sm opacity-80"><strong>Sustentabilidade:</strong> ${painel.sustentabilidade}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm opacity-80"><strong>Materiais:</strong> ${painel.materiais}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-80"><strong>Técnicas:</strong> ${painel.tecnicas}</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm mb-1"><strong>Média:</strong> <span class="text-yellow-400">${mediaNotas}</span>/100</p>
                                <p class="text-xs opacity-60">Avaliações: ${avaliacoesPainel.length}</p>
                            </div>
                            <button onclick="avaliarPainel(${painel.id})" 
                                    class="custom-button px-4 py-2 rounded text-sm font-medium">
                                Avaliar
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function avaliarPainel(id) {
            painelAtual = paineis.find(p => p.id === id);
            document.getElementById('painelAvaliando').textContent = 
                `${painelAtual.titulo} (${painelAtual.curso})`;
            document.getElementById('resumoAvaliando').textContent = painelAtual.resumo;
            
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
            if (!painelAtual || !document.getElementById('nomeJurado').value) {
                alert('Preencha o nome do jurado!');
                return;
            }
            
            const avaliacao = {
                id: Date.now(),
                painelId: painelAtual.id,
                jurado: document.getElementById('nomeJurado').value,
                economico: parseInt(document.getElementById('economico').value),
                social: parseInt(document.getElementById('social').value),
                sustentabilidadePainel: parseInt(document.getElementById('sustentabilidadePainel').value),
                qualidadeVisual: parseInt(document.getElementById('qualidadeVisual').value),
                conteudoInfo: parseInt(document.getElementById('conteudoInfo').value),
                total: parseInt(document.getElementById('totalPontos').textContent),
                observacoes: document.getElementById('observacoes').value,
                timestamp: new Date().toISOString()
            };
            
            avaliacoes.push(avaliacao);
            localStorage.setItem('avaliacoes_paineis', JSON.stringify(avaliacoes));
            
            alert('Avaliação salva com sucesso!');
            fecharAvaliacao();
            renderizarPaineis();
        }

        function fecharAvaliacao() {
            document.getElementById('avaliacaoSection').style.display = 'none';
            painelAtual = null;
        }

        function gerarRelatorioGeral() {
            let relatorio = 'RELATÓRIO GERAL - PAINÉIS\n';
            relatorio += '='.repeat(60) + '\n\n';
            relatorio += 'TEMA: "Desenvolvimento econômico, social e sustentável para comunidades resilientes"\n';
            relatorio += 'TAMANHO: 2m x 1,8m\n\n';
            
            paineis.forEach(painel => {
                const avaliacoesPainel = avaliacoes.filter(a => a.painelId === painel.id);
                relatorio += `PAINEL: ${painel.titulo}\n`;
                relatorio += `Curso: ${painel.curso}\n`;
                relatorio += `Equipe: ${painel.equipe}\n`;
                relatorio += `Resumo: ${painel.resumo}\n`;
                relatorio += `Desenvolvimento Econômico: ${painel.desenvolvimentoEconomico}\n`;
                relatorio += `Desenvolvimento Social: ${painel.desenvolvimentoSocial}\n`;
                relatorio += `Sustentabilidade: ${painel.sustentabilidade}\n`;
                relatorio += `Materiais: ${painel.materiais}\n`;
                relatorio += `Técnicas: ${painel.tecnicas}\n\n`;
                
                if (avaliacoesPainel.length > 0) {
                    relatorio += 'AVALIAÇÕES:\n';
                    avaliacoesPainel.forEach(av => {
                        relatorio += `  Jurado: ${av.jurado}\n`;
                        relatorio += `  Desenvolvimento Econômico: ${av.economico}/25\n`;
                        relatorio += `  Desenvolvimento Social: ${av.social}/25\n`;
                        relatorio += `  Sustentabilidade: ${av.sustentabilidadePainel}/25\n`;
                        relatorio += `  Qualidade Visual: ${av.qualidadeVisual}/15\n`;
                        relatorio += `  Conteúdo: ${av.conteudoInfo}/10\n`;
                        relatorio += `  TOTAL: ${av.total}/100\n`;
                        if (av.observacoes) {
                            relatorio += `  Observações: ${av.observacoes}\n`;
                        }
                        relatorio += '\n';
                    });
                    
                    const media = (avaliacoesPainel.reduce((sum, a) => sum + a.total, 0) / avaliacoesPainel.length).toFixed(2);
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
            a.download = 'relatorio_paineis.txt';
            a.click();
        }

        function gerarRanking() {
            const ranking = paineis.map(painel => {
                const avaliacoesPainel = avaliacoes.filter(a => a.painelId === painel.id);
                const media = avaliacoesPainel.length > 0 
                    ? avaliacoesPainel.reduce((sum, a) => sum + a.total, 0) / avaliacoesPainel.length
                    : 0;
                
                return {
                    ...painel,
                    media: media,
                    totalAvaliacoes: avaliacoesPainel.length
                };
            }).sort((a, b) => b.media - a.media);
            
            let relatorio = 'RANKING FINAL - PAINÉIS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            ranking.forEach((painel, index) => {
                relatorio += `${index + 1}º LUGAR\n`;
                relatorio += `Painel: ${painel.titulo}\n`;
                relatorio += `Curso: ${painel.curso}\n`;
                relatorio += `Equipe: ${painel.equipe}\n`;
                relatorio += `Média: ${painel.media.toFixed(2)}/100\n`;
                relatorio += `Avaliações: ${painel.totalAvaliacoes}\n\n`;
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'ranking_paineis.txt';
            a.click();
        }

        function calcularPontuacao() {
            const ranking = paineis.map(painel => {
                const avaliacoesPainel = avaliacoes.filter(a => a.painelId === painel.id);
                const media = avaliacoesPainel.length > 0 
                    ? avaliacoesPainel.reduce((sum, a) => sum + a.total, 0) / avaliacoesPainel.length
                    : 0;
                
                return {
                    ...painel,
                    media: media
                };
            }).sort((a, b) => b.media - a.media);
            
            let relatorio = 'PONTUAÇÃO POR POSIÇÃO - PAINÉIS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            const pontuacoes = [500, 450, 400, 350, 300];
            
            ranking.forEach((painel, index) => {
                const posicao = index + 1;
                const pontos = index < pontuacoes.length ? pontuacoes[index] : 0;
                
                relatorio += `${posicao}º LUGAR - ${pontos} PONTOS\n`;
                relatorio += `Painel: ${painel.titulo}\n`;
                relatorio += `Curso: ${painel.curso}\n`;
                relatorio += `Equipe: ${painel.equipe}\n`;
                relatorio += `Média de avaliação: ${painel.media.toFixed(2)}/100\n\n`;
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'pontuacao_posicao_paineis.txt';
            a.click();
        }

        // Inicializar
        renderizarPaineis();
    </script>
</body>
</html>
