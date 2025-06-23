<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 12 - Empreendedorismo | SESMATED</title>
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
            <h1 class="text-3xl font-bold text-center">Tarefa 12 - Empreendedorismo</h1>
            <p class="text-center mt-2 opacity-80">Sistema de Controle de Vendas - Barracas por Curso</p>
        </div>
    </header>

    <main class="container mx-auto p-6">
        <!-- Cadastro de Barracas -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Cadastrar Barraca</h2>
            <form id="barracaForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nome da Barraca</label>
                    <input type="text" id="nomeBarraca" class="custom-input w-full p-3 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Curso Responsável</label>
                    <select id="cursoBarraca" class="custom-input w-full p-3 rounded-lg" required>
                        <option value="">Selecione o curso</option>
                        <option value="Informática">Informática</option>
                        <option value="Enfermagem">Enfermagem</option>
                        <option value="Administração">Administração</option>
                        <option value="Agropecuária">Agropecuária</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Responsáveis (separar nomes por vírgula)</label>
                    <textarea id="responsaveisBarraca" class="custom-input w-full p-3 rounded-lg" rows="2"></textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="custom-button px-6 py-3 rounded-lg font-medium">
                        Cadastrar Barraca
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Barracas -->
        <div class="custom-card rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Barracas Cadastradas</h2>
            <div id="barracasList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Barracas serão inseridas aqui -->
            </div>
        </div>

        <!-- Gerenciar Produtos -->
        <div class="custom-card rounded-lg p-6 mb-8" id="produtosSection" style="display: none;">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Gerenciar Produtos</h2>
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2" id="barracaAtual"></h3>
            </div>
            
            <!-- Cadastro de Produtos -->
            <div class="custom-card p-4 rounded-lg mb-6">
                <h4 class="text-lg font-semibold mb-4">Cadastrar Produto</h4>
                <form id="produtoForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nome do Produto</label>
                        <input type="text" id="nomeProduto" class="custom-input w-full p-3 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Preço (R$)</label>
                        <input type="number" id="precoProduto" class="custom-input w-full p-3 rounded-lg" step="0.01" min="0" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Quantidade Inicial</label>
                        <input type="number" id="quantidadeProduto" class="custom-input w-full p-3 rounded-lg" min="0" required>
                    </div>
                    <div class="md:col-span-3">
                        <button type="submit" class="custom-button px-4 py-2 rounded font-medium">
                            Adicionar Produto
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Lista de Produtos -->
            <div class="custom-card p-4 rounded-lg mb-6">
                <h4 class="text-lg font-semibold mb-4">Produtos da Barraca</h4>
                <div id="produtosList" class="space-y-2">
                    <!-- Produtos serão inseridos aqui -->
                </div>
            </div>
            
            <!-- Registrar Venda -->
            <div class="custom-card p-4 rounded-lg mb-6">
                <h4 class="text-lg font-semibold mb-4">Registrar Venda</h4>
                <form id="vendaForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Produto</label>
                        <select id="produtoVenda" class="custom-input w-full p-3 rounded-lg" required>
                            <option value="">Selecione o produto</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Quantidade Vendida</label>
                        <input type="number" id="quantidadeVenda" class="custom-input w-full p-3 rounded-lg" min="1" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Valor Total</label>
                        <input type="number" id="valorVenda" class="custom-input w-full p-3 rounded-lg" step="0.01" readonly>
                    </div>
                    <div class="md:col-span-3">
                        <button type="submit" class="custom-button px-4 py-2 rounded font-medium">
                            Registrar Venda
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Resumo de Vendas -->
            <div class="custom-card p-4 rounded-lg mb-6">
                <h4 class="text-lg font-semibold mb-4">Resumo de Vendas</h4>
                <div id="resumoVendas">
                    <!-- Resumo será inserido aqui -->
                </div>
            </div>
            
            <div class="flex gap-4">
                <button onclick="fecharProdutos()" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-medium">
                    Fechar
                </button>
            </div>
        </div>

        <!-- Relatórios -->
        <div class="custom-card rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Relatórios</h2>
            <div class="flex flex-wrap gap-4">
                <button onclick="gerarRelatorioVendas()" class="custom-button px-6 py-3 rounded-lg font-medium">
                    Relatório de Vendas
                </button>
                <button onclick="gerarRanking()" class="bg-purple-600 text-white px-6 py-3 rounded-lg font-medium">
                    Ranking de Arrecadação
                </button>
                <button onclick="calcularPontuacao()" class="bg-yellow-600 text-white px-6 py-3 rounded-lg font-medium">
                    Calcular Pontuação
                </button>
                <button onclick="relatorioPrestacaoContas()" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
                    Prestação de Contas
                </button>
            </div>
        </div>
    </main>

    <script>
        let barracas = JSON.parse(localStorage.getItem('barracas') || '[]');
        let produtos = JSON.parse(localStorage.getItem('produtos_barracas') || '[]');
        let vendas = JSON.parse(localStorage.getItem('vendas_barracas') || '[]');
        let barracaAtual = null;

        document.getElementById('barracaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const barraca = {
                id: Date.now(),
                nome: document.getElementById('nomeBarraca').value,
                curso: document.getElementById('cursoBarraca').value,
                responsaveis: document.getElementById('responsaveisBarraca').value,
                timestamp: new Date().toISOString()
            };
            
            barracas.push(barraca);
            localStorage.setItem('barracas', JSON.stringify(barracas));
            
            this.reset();
            renderizarBarracas();
            
            alert('Barraca cadastrada com sucesso!');
        });

        function renderizarBarracas() {
            const container = document.getElementById('barracasList');
            container.innerHTML = '';
            
            barracas.forEach(barraca => {
                const vendasBarraca = vendas.filter(v => v.barracaId === barraca.id);
                const totalArrecadado = vendasBarraca.reduce((sum, v) => sum + v.valorTotal, 0);
                
                const card = document.createElement('div');
                card.className = 'custom-card p-4 rounded-lg';
                card.innerHTML = `
                    <h3 class="font-bold text-lg mb-2">${barraca.nome}</h3>
                    <p class="text-sm opacity-80 mb-1"><strong>Curso:</strong> ${barraca.curso}</p>
                    <p class="text-sm opacity-80 mb-3"><strong>Responsáveis:</strong> ${barraca.responsaveis}</p>
                    <p class="text-sm font-semibold text-green-400 mb-3">
                        Arrecadado: R$ ${totalArrecadado.toFixed(2)}
                    </p>
                    <button onclick="gerenciarProdutos(${barraca.id})" 
                            class="custom-button px-4 py-2 rounded text-sm font-medium w-full">
                        Gerenciar Produtos
                    </button>
                `;
                container.appendChild(card);
            });
        }

        function gerenciarProdutos(id) {
            barracaAtual = barracas.find(b => b.id === id);
            document.getElementById('barracaAtual').textContent = 
                `${barracaAtual.nome} (${barracaAtual.curso})`;
            
            document.getElementById('produtosSection').style.display = 'block';
            document.getElementById('produtosSection').scrollIntoView({ behavior: 'smooth' });
            
            renderizarProdutos();
            atualizarSelectProdutos();
            atualizarResumoVendas();
        }

        document.getElementById('produtoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!barracaAtual) return;
            
            const produto = {
                id: Date.now(),
                barracaId: barracaAtual.id,
                nome: document.getElementById('nomeProduto').value,
                preco: parseFloat(document.getElementById('precoProduto').value),
                quantidadeInicial: parseInt(document.getElementById('quantidadeProduto').value),
                quantidadeVendida: 0,
                timestamp: new Date().toISOString()
            };
            
            produtos.push(produto);
            localStorage.setItem('produtos_barracas', JSON.stringify(produtos));
            
            this.reset();
            renderizarProdutos();
            atualizarSelectProdutos();
            
            alert('Produto adicionado com sucesso!');
        });

        function renderizarProdutos() {
            if (!barracaAtual) return;
            
            const produtosBarraca = produtos.filter(p => p.barracaId === barracaAtual.id);
            const container = document.getElementById('produtosList');
            
            container.innerHTML = '';
            
            produtosBarraca.forEach(produto => {
                const estoque = produto.quantidadeInicial - produto.quantidadeVendida;
                const totalVendido = produto.quantidadeVendida * produto.preco;
                
                const item = document.createElement('div');
                item.className = 'flex justify-between items-center p-3 bg-gray-700 rounded';
                item.innerHTML = `
                    <div>
                        <span class="font-medium">${produto.nome}</span>
                        <span class="text-sm opacity-80 ml-2">R$ ${produto.preco.toFixed(2)}</span>
                    </div>
                    <div class="text-right text-sm">
                        <div>Estoque: ${estoque}</div>
                        <div>Vendido: ${produto.quantidadeVendida}</div>
                        <div class="text-green-400">R$ ${totalVendido.toFixed(2)}</div>
                    </div>
                `;
                container.appendChild(item);
            });
        }

        function atualizarSelectProdutos() {
            if (!barracaAtual) return;
            
            const produtosBarraca = produtos.filter(p => p.barracaId === barracaAtual.id);
            const select = document.getElementById('produtoVenda');
            
            select.innerHTML = '<option value="">Selecione o produto</option>';
            
            produtosBarraca.forEach(produto => {
                const estoque = produto.quantidadeInicial - produto.quantidadeVendida;
                if (estoque > 0) {
                    const option = document.createElement('option');
                    option.value = produto.id;
                    option.textContent = `${produto.nome} - R$ ${produto.preco.toFixed(2)} (Estoque: ${estoque})`;
                    select.appendChild(option);
                }
            });
        }

        // Atualizar valor da venda automaticamente
        document.getElementById('produtoVenda').addEventListener('change', calcularValorVenda);
        document.getElementById('quantidadeVenda').addEventListener('input', calcularValorVenda);

        function calcularValorVenda() {
            const produtoId = document.getElementById('produtoVenda').value;
            const quantidade = parseInt(document.getElementById('quantidadeVenda').value) || 0;
            
            if (produtoId && quantidade > 0) {
                const produto = produtos.find(p => p.id == produtoId);
                if (produto) {
                    const valor = produto.preco * quantidade;
                    document.getElementById('valorVenda').value = valor.toFixed(2);
                }
            } else {
                document.getElementById('valorVenda').value = '';
            }
        }

        document.getElementById('vendaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!barracaAtual) return;
            
            const produtoId = parseInt(document.getElementById('produtoVenda').value);
            const quantidade = parseInt(document.getElementById('quantidadeVenda').value);
            const produto = produtos.find(p => p.id === produtoId);
            
            if (!produto) {
                alert('Produto não encontrado!');
                return;
            }
            
            const estoque = produto.quantidadeInicial - produto.quantidadeVendida;
            if (quantidade > estoque) {
                alert('Quantidade insuficiente em estoque!');
                return;
            }
            
            const venda = {
                id: Date.now(),
                barracaId: barracaAtual.id,
                produtoId: produtoId,
                nomeProduto: produto.nome,
                quantidade: quantidade,
                precoUnitario: produto.preco,
                valorTotal: produto.preco * quantidade,
                timestamp: new Date().toISOString()
            };
            
            vendas.push(venda);
            localStorage.setItem('vendas_barracas', JSON.stringify(vendas));
            
            // Atualizar quantidade vendida do produto
            produto.quantidadeVendida += quantidade;
            localStorage.setItem('produtos_barracas', JSON.stringify(produtos));
            
            this.reset();
            renderizarProdutos();
            atualizarSelectProdutos();
            atualizarResumoVendas();
            renderizarBarracas();
            
            alert('Venda registrada com sucesso!');
        });

        function atualizarResumoVendas() {
            if (!barracaAtual) return;
            
            const vendasBarraca = vendas.filter(v => v.barracaId === barracaAtual.id);
            const totalArrecadado = vendasBarraca.reduce((sum, v) => sum + v.valorTotal, 0);
            const totalItensVendidos = vendasBarraca.reduce((sum, v) => sum + v.quantidade, 0);
            
            const container = document.getElementById('resumoVendas');
            container.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-gray-800 rounded">
                        <h5 class="text-lg font-semibold text-green-400">Total Arrecadado</h5>
                        <p class="text-2xl font-bold">R$ ${totalArrecadado.toFixed(2)}</p>
                    </div>
                    <div class="text-center p-4 bg-gray-800 rounded">
                        <h5 class="text-lg font-semibold text-blue-400">Itens Vendidos</h5>
                        <p class="text-2xl font-bold">${totalItensVendidos}</p>
                    </div>
                    <div class="text-center p-4 bg-gray-800 rounded">
                        <h5 class="text-lg font-semibold text-purple-400">Vendas Realizadas</h5>
                        <p class="text-2xl font-bold">${vendasBarraca.length}</p>
                    </div>
                </div>
            `;
        }

        function fecharProdutos() {
            document.getElementById('produtosSection').style.display = 'none';
            barracaAtual = null;
        }

        function gerarRelatorioVendas() {
            let relatorio = 'RELATÓRIO DE VENDAS - EMPREENDEDORISMO\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            barracas.forEach(barraca => {
                const vendasBarraca = vendas.filter(v => v.barracaId === barraca.id);
                const produtosBarraca = produtos.filter(p => p.barracaId === barraca.id);
                const totalArrecadado = vendasBarraca.reduce((sum, v) => sum + v.valorTotal, 0);
                
                relatorio += `BARRACA: ${barraca.nome}\n`;
                relatorio += `Curso: ${barraca.curso}\n`;
                relatorio += `Responsáveis: ${barraca.responsaveis}\n`;
                relatorio += `Total Arrecadado: R$ ${totalArrecadado.toFixed(2)}\n\n`;
                
                relatorio += 'PRODUTOS CADASTRADOS:\n';
                produtosBarraca.forEach(produto => {
                    const totalVendido = produto.quantidadeVendida * produto.preco;
                    relatorio += `  ${produto.nome} - R$ ${produto.preco.toFixed(2)}\n`;
                    relatorio += `    Quantidade inicial: ${produto.quantidadeInicial}\n`;
                    relatorio += `    Quantidade vendida: ${produto.quantidadeVendida}\n`;
                    relatorio += `    Total arrecadado: R$ ${totalVendido.toFixed(2)}\n\n`;
                });
                
                relatorio += 'VENDAS REALIZADAS:\n';
                vendasBarraca.forEach(venda => {
                    relatorio += `  ${new Date(venda.timestamp).toLocaleString('pt-BR')}\n`;
                    relatorio += `  ${venda.nomeProduto} - Qtd: ${venda.quantidade} - Valor: R$ ${venda.valorTotal.toFixed(2)}\n\n`;
                });
                
                relatorio += '-'.repeat(40) + '\n\n';
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'relatorio_vendas_empreendedorismo.txt';
            a.click();
        }

        function gerarRanking() {
            const ranking = barracas.map(barraca => {
                const vendasBarraca = vendas.filter(v => v.barracaId === barraca.id);
                const totalArrecadado = vendasBarraca.reduce((sum, v) => sum + v.valorTotal, 0);
                
                return {
                    ...barraca,
                    totalArrecadado: totalArrecadado
                };
            }).sort((a, b) => b.totalArrecadado - a.totalArrecadado);
            
            let relatorio = 'RANKING DE ARRECADAÇÃO - EMPREENDEDORISMO\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            ranking.forEach((barraca, index) => {
                relatorio += `${index + 1}º LUGAR\n`;
                relatorio += `Barraca: ${barraca.nome}\n`;
                relatorio += `Curso: ${barraca.curso}\n`;
                relatorio += `Total Arrecadado: R$ ${barraca.totalArrecadado.toFixed(2)}\n\n`;
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'ranking_arrecadacao_empreendedorismo.txt';
            a.click();
        }

        function calcularPontuacao() {
            const ranking = barracas.map(barraca => {
                const vendasBarraca = vendas.filter(v => v.barracaId === barraca.id);
                const totalArrecadado = vendasBarraca.reduce((sum, v) => sum + v.valorTotal, 0);
                
                return {
                    ...barraca,
                    totalArrecadado: totalArrecadado
                };
            }).sort((a, b) => b.totalArrecadado - a.totalArrecadado);
            
            let relatorio = 'PONTUAÇÃO - EMPREENDEDORISMO\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            const pontuacoes = [500, 450, 400, 350, 300];
            
            ranking.forEach((barraca, index) => {
                const posicao = index + 1;
                const pontos = index < pontuacoes.length ? pontuacoes[index] : 0;
                
                relatorio += `${posicao}º LUGAR - ${pontos} PONTOS\n`;
                relatorio += `Barraca: ${barraca.nome}\n`;
                relatorio += `Curso: ${barraca.curso}\n`;
                relatorio += `Total Arrecadado: R$ ${barraca.totalArrecadado.toFixed(2)}\n\n`;
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.download = 'pontuacao_empreendedorismo.txt';
            a.click();
        }

        function relatorioPrestacaoContas() {
            let relatorio = 'RELATÓRIO DE PRESTAÇÃO DE CONTAS - EMPREENDEDORISMO\n';
            relatorio += '='.repeat(60) + '\n\n';
            
            barracas.forEach(barraca => {
                const vendasBarraca = vendas.filter(v => v.barracaId === barraca.id);
                const produtosBarraca = produtos.filter(p => p.barracaId === barraca.id);
                const totalArrecadado = vendasBarraca.reduce((sum, v) => sum + v.valorTotal, 0);
                
                relatorio += `BARRACA: ${barraca.nome} (${barraca.curso})\n`;
                relatorio += `Responsáveis: ${barraca.responsaveis}\n`;
                relatorio += `Data do relatório: ${new Date().toLocaleString('pt-BR')}\n\n`;
                
                relatorio += 'PRODUTOS DECLARADOS:\n';
                produtosBarraca.forEach(produto => {
                    const totalVendido = produto.quantidadeVendida * produto.preco;
                    const estoque = produto.quantidadeInicial - produto.quantidadeVendida;
                    
                    relatorio += `  Produto: ${produto.nome}\n`;
                    relatorio += `  Preço unitário: R$ ${produto.preco.toFixed(2)}\n`;
                    relatorio += `  Quantidade inicial: ${produto.quantidadeInicial}\n`;
                    relatorio += `  Quantidade vendida: ${produto.quantidadeVendida}\n`;
                    relatorio += `  Estoque restante: ${estoque}\n`;
                    relatorio += `  Total arrecadado: R$ ${totalVendido.toFixed(2)}\n\n`;
                });
                
                relatorio += `TOTAL GERAL ARRECADADO: R$ ${totalArrecadado.toFixed(2)}\n`;
                relatorio += `TOTAL DE VENDAS REALIZADAS: ${vendasBarraca.length}\n\n`;
                
                relatorio += 'COMPROVANTES DE VENDAS:\n';
                vendasBarraca.forEach((venda, index) => {
                    relatorio += `  Venda ${index + 1}:\n`;
                    relatorio += `    Data/Hora: ${new Date(venda.timestamp).toLocaleString('pt-BR')}\n`;
                    relatorio += `    Produto: ${venda.nomeProduto}\n`;
                    relatorio += `    Quantidade: ${venda.quantidade}\n`;
                    relatorio += `    Preço unitário: R$ ${venda.precoUnitario.toFixed(2)}\n`;
                    relatorio += `    Valor total: R$ ${venda.valorTotal.toFixed(2)}\n`;
                    relatorio += `    ID da venda: ${venda.id}\n\n`;
                });
                
                relatorio += '='.repeat(60) + '\n\n';
            });
            
            const blob = new Blob([relatorio], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'prestacao_contas_empreendedorismo.txt';
            a.click();
        }

        // Inicializar
        renderizarBarracas();
    </script>
</body>
</html>
