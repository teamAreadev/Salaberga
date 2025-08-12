<!DOCTYPE html>
<html lang="pt-BR">
<?php
        require_once('../model/sessions.php');
        $session = new sessions();
        $session->autenticar_session();
        
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Movimentações - STGM Estoque</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #F8FAF9 0%, #E6F4EA 100%);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #005A24 0%, #1A3C34 100%);
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="gradient-bg text-white py-4 shadow-lg">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="assets/imagens/logostgm.png" alt="Logo STGM" class="h-12 mr-3">
                <span class="text-white font-bold text-xl">STGM Estoque</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="relatorios.php" class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <button onclick="downloadPDF()" class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>Download PDF
                </button>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <!-- Título -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-exchange-alt text-orange-500 mr-3"></i>
                Relatório de Movimentações
            </h1>
            <p class="text-gray-600">
                Período: <span id="periodo"></span>
            </p>
        </div>

        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2" id="totalMovimentacoes">-</div>
                <div class="text-gray-600">Total de Movimentações</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2" id="totalProdutos">-</div>
                <div class="text-gray-600">Produtos Movimentados</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2" id="totalRetirado">-</div>
                <div class="text-gray-600">Total Retirado</div>
            </div>
        </div>

        <!-- Tabela -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-center">ID</th>
                            <th class="px-4 py-3 text-left">Barcode</th>
                            <th class="px-4 py-3 text-left">Produto</th>
                            <th class="px-4 py-3 text-center">Qtd. Retirada</th>
                            <th class="px-4 py-3 text-left">Responsável</th>
                            <th class="px-4 py-3 text-left">Cargo</th>
                            <th class="px-4 py-3 text-center">Data</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaMovimentacoes">
                        <!-- Dados serão carregados via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mensagem de carregamento -->
        <div id="loading" class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
            <p class="mt-2 text-gray-600">Carregando dados...</p>
        </div>

        <!-- Mensagem de erro -->
        <div id="error" class="hidden text-center py-8">
            <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
            <p class="text-red-600">Erro ao carregar os dados. Tente novamente.</p>
        </div>

        <!-- Mensagem de dados vazios -->
        <div id="empty" class="hidden text-center py-8">
            <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-600">Nenhuma movimentação encontrada para o período selecionado.</p>
        </div>
    </main>

    <script>
        // Obter parâmetros da URL
        const urlParams = new URLSearchParams(window.location.search);
        const dataInicio = urlParams.get('data_inicio');
        const dataFim = urlParams.get('data_fim');

        // Exibir período
        if (dataInicio && dataFim) {
            const inicio = new Date(dataInicio).toLocaleDateString('pt-BR');
            const fim = new Date(dataFim).toLocaleDateString('pt-BR');
            document.getElementById('periodo').textContent = `${inicio} a ${fim}`;
        }

        // Carregar dados
        async function carregarDados() {
            try {
                const response = await fetch(`../control/controllerRelatorioData.php?data_inicio=${dataInicio}&data_fim=${dataFim}&format=json`);
                
                if (!response.ok) {
                    throw new Error('Erro na requisição');
                }

                const data = await response.json();
                
                if (data.success) {
                    if (data.movimentacoes && data.movimentacoes.length > 0) {
                        exibirDados(data.movimentacoes);
                        calcularEstatisticas(data.movimentacoes);
                    } else {
                        document.getElementById('loading').classList.add('hidden');
                        document.getElementById('empty').classList.remove('hidden');
                    }
                } else {
                    throw new Error(data.error || 'Erro desconhecido');
                }
            } catch (error) {
                console.error('Erro:', error);
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('error').classList.remove('hidden');
            }
        }

        function exibirDados(movimentacoes) {
            const tbody = document.getElementById('tabelaMovimentacoes');
            tbody.innerHTML = '';

            movimentacoes.forEach((mov, index) => {
                const row = document.createElement('tr');
                row.className = index % 2 === 0 ? 'bg-gray-50' : 'bg-white';
                
                const dataMov = new Date(mov.datareg).toLocaleString('pt-BR');
                
                row.innerHTML = `
                    <td class="px-4 py-3 text-center font-mono text-sm">${mov.id}</td>
                    <td class="px-4 py-3 font-mono text-sm">${mov.barcode_produto || 'N/A'}</td>
                    <td class="px-4 py-3">${mov.nome_produto || 'N/A'}</td>
                    <td class="px-4 py-3 text-center font-semibold text-red-600">${mov.quantidade_retirada}</td>
                    <td class="px-4 py-3">${mov.nome_responsavel || 'N/A'}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                            ${mov.cargo || 'N/A'}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm text-gray-600">${dataMov}</td>
                `;
                
                tbody.appendChild(row);
            });

            document.getElementById('loading').classList.add('hidden');
        }

        function calcularEstatisticas(movimentacoes) {
            const totalMovimentacoes = movimentacoes.length;
            const produtosUnicos = [...new Set(movimentacoes.map(m => m.fk_produtos_id))];
            const totalRetirado = movimentacoes.reduce((sum, m) => sum + parseInt(m.quantidade_retirada || 0), 0);

            document.getElementById('totalMovimentacoes').textContent = totalMovimentacoes;
            document.getElementById('totalProdutos').textContent = produtosUnicos.length;
            document.getElementById('totalRetirado').textContent = totalRetirado;
        }

        function downloadPDF() {
            window.open(`../control/controllerRelatorioData.php?data_inicio=${dataInicio}&data_fim=${dataFim}&pdf=1`, '_blank');
        }

        // Carregar dados quando a página carregar
        document.addEventListener('DOMContentLoaded', carregarDados);
    </script>
</body>
</html> 