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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#005A24',
                        secondary: '#FFA500',
                        accent: '#E6F4EA',
                        dark: '#1A3C34',
                        light: '#F8FAF9',
                        white: '#FFFFFF'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif']
                    },
                    boxShadow: {
                        card: '0 10px 15px -3px rgba(0, 90, 36, 0.1), 0 4px 6px -2px rgba(0, 90, 36, 0.05)',
                        'card-hover': '0 20px 25px -5px rgba(0, 90, 36, 0.2), 0 10px 10px -5px rgba(0, 90, 36, 0.1)'
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            scroll-behavior: smooth; 
            background-color: #F8FAF9; 
        }
        .gradient-bg { 
            background: linear-gradient(135deg, #005A24 0%, #1A3C34 100%); 
        }
        .page-title { 
            position: relative; 
            display: inline-block; 
        }
        .page-title::after { 
            content: ''; 
            position: absolute; 
            bottom: -8px; 
            left: 50%; 
            transform: translateX(-50%); 
            width: 80px; 
            height: 3px; 
            background-color: #FFA500; 
            border-radius: 3px; 
        }
        .header-nav-link { 
            position: relative; 
            transition: all 0.3s ease; 
            font-weight: 500; 
            padding: 0.5rem 1rem; 
            border-radius: 0.5rem; 
        }
        .header-nav-link:hover { 
            background-color: rgba(255,255,255,0.1); 
        }
        .header-nav-link::after { 
            content: ''; 
            position: absolute; 
            bottom: -2px; 
            left: 50%; 
            width: 0; 
            height: 2px; 
            background-color: #FFA500; 
            transition: all 0.3s ease; 
            transform: translateX(-50%); 
        }
        .header-nav-link:hover::after, .header-nav-link.active::after { 
            width: 80%; 
        }
        .header-nav-link.active { 
            background-color: rgba(255,255,255,0.15); 
        }
        .mobile-menu-button { 
            display: none; 
        }
        @media (max-width: 768px) {
            .header-nav { 
                display: none; 
                position: fixed; 
                top: 0; 
                left: 0; 
                right: 0; 
                bottom: 0; 
                background: linear-gradient(135deg, #005A24 0%, #1A3C34 100%); 
                padding: 2rem 1rem; 
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); 
                z-index: 50; 
                flex-direction: column; 
                justify-content: center; 
                align-items: center; 
                backdrop-filter: blur(10px); 
            }
            .header-nav.show { 
                display: flex; 
                animation: slideIn 0.3s ease-out; 
            }
            @keyframes slideIn { 
                from { 
                    opacity: 0; 
                    transform: translateY(-20px); 
                } 
                to { 
                    opacity: 1; 
                    transform: translateY(0); 
                } 
            }
            .header-nav-link { 
                padding: 1rem 1.5rem; 
                text-align: center; 
                margin: 0.5rem 0; 
                font-size: 1.1rem; 
                border-radius: 0.75rem; 
                transition: all 0.3s ease; 
                width: 100%; 
                max-width: 300px; 
            }
            .header-nav-link:hover { 
                background-color: rgba(255,255,255,0.15); 
                transform: translateX(5px); 
            }
            .mobile-menu-button { 
                display: flex; 
                flex-direction: column; 
                justify-content: space-between; 
                width: 30px; 
                height: 21px; 
                background: transparent; 
                border: none; 
                cursor: pointer; 
                padding: 0; 
                z-index: 60; 
                position: relative; 
            }
            .mobile-menu-button span { 
                width: 100%; 
                height: 3px; 
                background-color: white; 
                border-radius: 10px; 
                transition: all 0.3s ease; 
                position: relative; 
                transform-origin: center; 
            }
            .mobile-menu-button span:first-child.active { 
                transform: rotate(45deg) translate(6px, 6px); 
            }
            .mobile-menu-button span:nth-child(2).active { 
                opacity: 0; 
                transform: scale(0); 
            }
            .mobile-menu-button span:nth-child(3).active { 
                transform: rotate(-45deg) translate(6px, -6px); 
            }
            .header-nav::before { 
                content: ''; 
                position: absolute; 
                top: 0; 
                left: 0; 
                right: 0; 
                bottom: 0; 
                background: rgba(0,0,0,0.3); 
                z-index: -1; 
            }
        }
        .max-w-5xl { 
            max-width: 64rem; 
            width: 100%; 
        }
        .desktop-table { 
            display: block; 
            width: 100%; 
        }
        .mobile-cards { 
            display: none; 
        }
        @media screen and (max-width: 768px) { 
            .desktop-table { 
                display: none; 
            } 
            .mobile-cards { 
                display: flex; 
                flex-direction: column; 
                gap: 0.75rem; 
                margin-top: 1rem; 
                padding: 0 0.5rem; 
                width: 100%; 
            } 
            .card-item { 
                margin-bottom: 0.75rem; 
            } 
        }
        .card-item { 
            transition: all 0.3s ease; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); 
        }
        .card-item:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }
    </style>
</head>
<body class="min-h-screen flex flex-col font-sans bg-light">
    <!-- Header -->
    <header class="sticky top-0 bg-gradient-to-r from-primary to-dark text-white py-4 shadow-lg z-50">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="../assets/imagens/logostgm.png" alt="Logo STGM" class="h-12 mr-3 transition-transform hover:scale-105">
                <span class="text-white font-heading text-xl font-semibold hidden md:inline">STGM Estoque</span>
            </div>
            <button class="mobile-menu-button focus:outline-none" aria-label="Menu" id="menuButton">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="header-nav md:flex items-center space-x-1" id="headerNav">
                <a href="paginainicial.php" class="header-nav-link flex items-center"><i class="fas fa-home mr-2"></i><span>Início</span></a>
                <a href="estoque.php" class="header-nav-link flex items-center"><i class="fas fa-boxes mr-2"></i><span>Estoque</span></a>
                <a href="adicionarproduto.php" class="header-nav-link flex items-center"><i class="fas fa-plus-circle mr-2"></i><span>Adicionar</span></a>
                <a href="solicitar.php" class="header-nav-link flex items-center cursor-pointer"><i class="fas fa-clipboard-list mr-2"></i><span>Solicitar</span></a>
                <a href="relatorios.php" class="header-nav-link active flex items-center"><i class="fas fa-chart-bar mr-2"></i><span>Relatórios</span></a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 md:py-12 flex-1">
        <!-- Título -->
        <div class="text-center mb-10">
            <h1 class="text-primary text-3xl md:text-4xl font-bold mb-8 md:mb-6 text-center page-title tracking-tight font-heading inline-block mx-auto">
                <i class="fas fa-exchange-alt text-secondary mr-3"></i>
                RELATÓRIO DE MOVIMENTAÇÕES
            </h1>
            <p class="text-gray-600 text-lg">
                Período: <span id="periodo" class="font-semibold text-primary"></span>
            </p>
        </div>


        <!-- Tabela para desktop -->
        <div class="desktop-table bg-white rounded-xl shadow-lg overflow-hidden border-2 border-primary max-w-5xl mx-auto">
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-primary to-primary/90">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-table mr-3"></i>
                    Detalhamento das Movimentações
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="px-4 py-3 text-center font-semibold">
                                <i class="fas fa-hashtag mr-2"></i>ID
                            </th>
                            <th class="px-4 py-3 text-left font-semibold">
                                <i class="fas fa-barcode mr-2"></i>Barcode
                            </th>
                            <th class="px-4 py-3 text-left font-semibold">
                                <i class="fas fa-box mr-2"></i>Produto
                            </th>
                            <th class="px-4 py-3 text-center font-semibold">
                                <i class="fas fa-sort-numeric-down mr-2"></i>Qtd. Retirada
                            </th>
                            <th class="px-4 py-3 text-left font-semibold">
                                <i class="fas fa-user mr-2"></i>Responsável
                            </th>
                            <th class="px-4 py-3 text-left font-semibold">
                                <i class="fas fa-id-badge mr-2"></i>Cargo
                            </th>
                            <th class="px-4 py-3 text-center font-semibold">
                                <i class="fas fa-calendar-alt mr-2"></i>Data
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tabelaMovimentacoes">
                        <!-- Dados serão carregados via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cards para mobile -->
        <div class="mobile-cards mt-6 max-w-5xl mx-auto">
            <!-- Os cards serão gerados via JavaScript -->
        </div>

        <!-- Mensagem de carregamento -->
        <div id="loading" class="text-center py-8 max-w-5xl mx-auto">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-full mb-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
            </div>
            <p class="text-gray-600 font-medium">Carregando dados...</p>
        </div>

        <!-- Mensagem de erro -->
        <div id="error" class="hidden text-center py-8 max-w-5xl mx-auto">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
            </div>
            <p class="text-red-600 font-medium">Erro ao carregar os dados. Tente novamente.</p>
        </div>

        <!-- Mensagem de dados vazios -->
        <div id="empty" class="hidden text-center py-8 max-w-5xl mx-auto">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-600 font-medium">Nenhuma movimentação encontrada para o período selecionado.</p>
        </div>

        <!-- Botões de ação -->
        <div class="mt-12 flex justify-center w-full gap-6">
            <a href="relatorios.php" class="group">
                <button class="bg-gradient-to-r from-primary to-primary/90 text-white font-bold py-4 px-8 rounded-xl hover:from-primary/90 hover:to-primary transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center">
                    <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform duration-300"></i>
                    Voltar aos Relatórios
                </button>
            </a>
           
        </div>
    </main>

    <footer class="bg-gradient-to-r from-primary to-dark text-white py-6 mt-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="font-heading text-lg font-semibold mb-3 flex items-center"><i class="fas fa-school mr-2 text-sm"></i>EEEP STGM</h3>
                    <p class="text-xs leading-relaxed"><i class="fas fa-map-marker-alt mr-1 text-xs"></i> AV. Marta Maria Carvalho Nojoza, SN<br>Maranguape - CE</p>
                </div>
                <div>
                    <h3 class="font-heading text-lg font-semibold mb-3 flex items-center"><i class="fas fa-address-book mr-2 text-sm"></i>Contato</h3>
                    <div class="text-xs leading-relaxed space-y-1">
                        <p class="flex items-start"><i class="fas fa-phone-alt mr-1 mt-0.5 text-xs"></i>(85) 3341-3990</p>
                        <p class="flex items-start"><i class="fas fa-envelope mr-1 mt-0.5 text-xs"></i>eeepsantariamata@gmail.com</p>
                    </div>
                </div>
                <div>
                    <h3 class="font-heading text-lg font-semibold mb-3 flex items-center"><i class="fas fa-code mr-2 text-sm"></i>Dev Team</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="https://www.instagram.com/dudu.limasx/" target="_blank" class="text-xs flex items-center hover:text-secondary transition-colors"><i class="fab fa-instagram mr-1 text-xs"></i>Carlos E.</a>
                        <a href="https://www.instagram.com/millenafreires_/" target="_blank" class="text-xs flex items-center hover:text-secondary transition-colors"><i class="fab fa-instagram mr-1 text-xs"></i>Millena F.</a>
                        <a href="https://www.instagram.com/matheusz.mf/" target="_blank" class="text-xs flex items-center hover:text-secondary transition-colors"><i class="fab fa-instagram mr-1 text-xs"></i>Matheus M.</a>
                        <a href="https://www.instagram.com/yanlucas10__/" target="_blank" class="text-xs flex items-center hover:text-secondary transition-colors"><i class="fab fa-instagram mr-1 text-xs"></i>Ian Lucas</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/20 pt-4 mt-4 text-center">
                <p class="text-xs">© 2024 STGM v1.2.0 | Desenvolvido por alunos EEEP STGM</p>
            </div>
        </div>
    </footer>

    <script>
        // Menu mobile toggle
        const menuButton = document.getElementById('menuButton');
        const headerNav = document.getElementById('headerNav');
        if (menuButton && headerNav) {
            menuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                headerNav.classList.toggle('show');
                const spans = menuButton.querySelectorAll('span');
                spans.forEach(span => { span.classList.toggle('active'); });
                document.body.style.overflow = headerNav.classList.contains('show') ? 'hidden' : '';
            });
            // Fechar menu ao clicar em um link
            const navLinks = headerNav.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    headerNav.classList.remove('show');
                    const spans = menuButton.querySelectorAll('span');
                    spans.forEach(span => { span.classList.remove('active'); });
                    document.body.style.overflow = '';
                });
            });
            // Fechar menu ao clicar fora
            document.addEventListener('click', function(e) {
                if (!headerNav.contains(e.target) && !menuButton.contains(e.target)) {
                    headerNav.classList.remove('show');
                    const spans = menuButton.querySelectorAll('span');
                    spans.forEach(span => { span.classList.remove('active'); });
                    document.body.style.overflow = '';
                }
            });
            // Fechar menu ao pressionar ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && headerNav.classList.contains('show')) {
                    headerNav.classList.remove('show');
                    const spans = menuButton.querySelectorAll('span');
                    spans.forEach(span => { span.classList.remove('active'); });
                    document.body.style.overflow = '';
                }
            });
        }

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
                console.log('Iniciando carregamento de dados...');
                console.log('Data início:', dataInicio);
                console.log('Data fim:', dataFim);
                
                if (!dataInicio || !dataFim) {
                    throw new Error('Parâmetros de data não fornecidos');
                }

                const url = `../control/controllerRelatorioData.php?data_inicio=${dataInicio}&data_fim=${dataFim}&format=json`;
                console.log('URL da requisição:', url);
                
                const response = await fetch(url);
                console.log('Status da resposta:', response.status);
                console.log('Headers da resposta:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`Erro HTTP: ${response.status} - ${response.statusText}`);
                }

                const responseText = await response.text();
                console.log('Resposta bruta:', responseText);
                
                let data;
                try {
                    data = JSON.parse(responseText);
                } catch (parseError) {
                    console.error('Erro ao fazer parse do JSON:', parseError);
                    throw new Error('Resposta do servidor não é um JSON válido');
                }
                
                console.log('Dados parseados:', data);
                
                if (data.success) {
                    if (data.movimentacoes && data.movimentacoes.length > 0) {
                        console.log('Exibindo dados:', data.movimentacoes.length, 'movimentações');
                        exibirDados(data.movimentacoes);
                        // Remover chamada para calcularEstatisticas pois não temos mais os elementos
                    } else {
                        console.log('Nenhuma movimentação encontrada');
                        document.getElementById('loading').classList.add('hidden');
                        document.getElementById('empty').classList.remove('hidden');
                    }
                } else {
                    throw new Error(data.error || 'Erro desconhecido retornado pelo servidor');
                }
            } catch (error) {
                console.error('Erro detalhado:', error);
                console.error('Stack trace:', error.stack);
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('error').classList.remove('hidden');
                
                // Mostrar detalhes do erro para debug
                const errorElement = document.getElementById('error');
                if (errorElement) {
                    const errorText = errorElement.querySelector('p');
                    if (errorText) {
                        errorText.innerHTML = `Erro ao carregar os dados: ${error.message}<br><small class="text-red-400">Verifique o console para mais detalhes</small>`;
                    }
                }
            }
        }

        function exibirDados(movimentacoes) {
            const tbody = document.getElementById('tabelaMovimentacoes');
            const mobileCards = document.querySelector('.mobile-cards');
            tbody.innerHTML = '';
            mobileCards.innerHTML = '';

            movimentacoes.forEach((mov, index) => {
                // Linha da tabela desktop
                const row = document.createElement('tr');
                row.className = index % 2 === 0 ? 'bg-gray-50 hover:bg-gray-100' : 'bg-white hover:bg-gray-50';
                row.classList.add('transition-colors', 'duration-200');
                
                const dataMov = new Date(mov.datareg).toLocaleString('pt-BR');
                
                row.innerHTML = `
                    <td class="px-4 py-3 text-center font-mono text-sm text-gray-600">${mov.id}</td>
                    <td class="px-4 py-3 font-mono text-sm text-primary font-medium">${mov.barcode_produto || 'N/A'}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">${mov.nome_produto || 'N/A'}</td>
                    <td class="px-4 py-3 text-center font-bold text-red-600 bg-red-50 rounded-lg mx-2">${mov.quantidade_retirada}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">${mov.nome_responsavel || 'N/A'}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                            ${mov.cargo || 'N/A'}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm text-gray-600 font-medium">${dataMov}</td>
                `;
                
                tbody.appendChild(row);

                // Card mobile
                const card = document.createElement('div');
                card.className = 'card-item bg-white shadow rounded-lg border-l-4 border-primary p-4 mb-3';
                
                card.innerHTML = `
                    <div class="flex justify-between items-start w-full">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-primary mb-2">${mov.nome_produto || 'N/A'}</h3>
                            <div class="flex flex-col space-y-2">
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-hashtag text-primary mr-2"></i>
                                    <span class="font-mono">ID: ${mov.id}</span>
                                </p>
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-barcode text-primary mr-2"></i>
                                    <span class="font-mono">${mov.barcode_produto || 'N/A'}</span>
                                </p>
                                <p class="text-sm flex items-center">
                                    <i class="fas fa-sort-numeric-down text-red-500 mr-2"></i>
                                    <span class="font-bold text-red-600">Qtd. Retirada: ${mov.quantidade_retirada}</span>
                                </p>
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-user text-primary mr-2"></i>
                                    <span>${mov.nome_responsavel || 'N/A'}</span>
                                </p>
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-id-badge text-primary mr-2"></i>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">${mov.cargo || 'N/A'}</span>
                                </p>
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                    <span>${dataMov}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                `;
                
                mobileCards.appendChild(card);
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