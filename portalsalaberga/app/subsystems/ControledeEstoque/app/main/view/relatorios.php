<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Relatórios - STGM Estoque</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        white: '#FFFFFF',
                        success: '#28A745',
                        warning: '#FFC107',
                        danger: '#DC3545',
                        info: '#17A2B8'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif']
                    },
                    boxShadow: {
                        card: '0 10px 15px -3px rgba(0, 90, 36, 0.1), 0 4px 6px -2px rgba(0, 90, 36, 0.05)',
                        'card-hover': '0 20px 25px -5px rgba(0, 90, 36, 0.2), 0 10px 10px -5px rgba(0, 90, 36, 0.1)',
                        'glow': '0 0 20px rgba(255, 165, 0, 0.3)'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
                        'bounce-slow': 'bounce 2s infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': {
                                transform: 'translateY(20px)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
            background: linear-gradient(135deg, #F8FAF9 0%, #E6F4EA 100%);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #005A24 0%, #1A3C34 100%);
        }

        .page-title {
            position: relative;
            width: 100%;
            text-align: center;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #FFA500, #FF8C00);
            border-radius: 3px;
        }

        .stats-card {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #FFFFFF 0%, #F8FAF9 100%);
            border: 2px solid transparent;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 165, 0, 0.1) 0%, rgba(0, 90, 36, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .stats-card:hover::before {
            opacity: 1;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 90, 36, 0.2), 0 10px 10px -5px rgba(0, 90, 36, 0.1);
            border-color: #FFA500;
        }

        .report-card {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #FFFFFF 0%, #F8FAF9 100%);
            border: 2px solid transparent;
        }

        .report-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 165, 0, 0.1) 0%, rgba(0, 90, 36, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .report-card:hover::before {
            opacity: 1;
        }

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 90, 36, 0.2), 0 10px 10px -5px rgba(0, 90, 36, 0.1);
            border-color: #FFA500;
        }

        .card-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 100%);
            transform: skewX(-25deg);
            transition: all 0.75s ease;
            z-index: 2;
        }

        .stats-card:hover .card-shine,
        .report-card:hover .card-shine {
            left: 150%;
        }

        .stats-card:hover .card-icon,
        .report-card:hover .card-icon {
            transform: scale(1.1);
            color: #FFA500;
        }

        .stats-card p,
        .report-card p {
            z-index: 2;
            position: relative;
            transition: color 0.3s ease;
        }

        .stats-card:hover p,
        .report-card:hover p {
            color: #005A24;
        }

        .stats-card a,
        .stats-card button,
        .report-card a,
        .report-card button {
            position: relative;
            z-index: 3;
        }

        .header-nav-link {
            position: relative;
            transition: all 0.3s ease;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }

        .header-nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
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

        .header-nav-link:hover::after {
            width: 80%;
        }

        .header-nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .header-nav-link.active::after {
            width: 80%;
        }

        .mobile-menu-button {
            display: none;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: linear-gradient(135deg, #FFFFFF 0%, #F8FAF9 100%);
            padding: 2rem;
            border-radius: 1rem;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 90, 36, 0.25);
            animation: slideUp 0.5s ease-out;
            position: relative;
            border: 2px solid #E6F4EA;
        }

        .modal-content h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            color: #005A24;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .modal-content .form-group {
            margin-bottom: 1.5rem;
        }

        .modal-content label {
            display: block;
            font-size: 0.875rem;
            color: #1A3C34;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .modal-content input[type="date"],
        .modal-content select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #E6F4EA;
            border-radius: 0.5rem;
            font-size: 1rem;
            color: #1A3C34;
            background-color: #F8FAF9;
            transition: all 0.3s ease;
        }

        .modal-content input[type="date"]:focus,
        .modal-content select:focus {
            border-color: #FFA500;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 165, 0, 0.1);
        }

        .modal-content .confirm-btn {
            background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%);
            color: #FFFFFF;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .modal-content .confirm-btn:hover {
            background: linear-gradient(135deg, #E59400 0%, #E67E00 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 165, 0, 0.3);
        }

        .modal-content .close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #1A3C34;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .modal-content .close-btn:hover {
            color: #DC3545;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin: 1rem 0;
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-item {
            background: linear-gradient(135deg, #FFFFFF 0%, #F8FAF9 100%);
            border: 2px solid #E6F4EA;
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 90, 36, 0.15);
            border-color: #FFA500;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #005A24;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #646464;
            font-weight: 500;
        }

        .stat-icon {
            font-size: 1.5rem;
            color: #FFA500;
            margin-bottom: 0.5rem;
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
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
                background-color: rgba(255, 255, 255, 0.15);
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

            /* Overlay para fechar menu ao clicar fora */
            .header-nav::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.3);
                z-index: -1;
            }

            .quick-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col font-sans">
    <!-- Header -->
    <header class="sticky top-0 bg-gradient-to-r from-primary to-dark text-white py-4 shadow-lg z-50">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="../assets/imagens/logostgm.png" alt="Logo S" class="h-12 mr-3 transition-transform hover:scale-105">
                <span class="text-white font-heading text-xl font-semibold hidden md:inline">STGM Estoque</span>
            </div>

            <button class="mobile-menu-button focus:outline-none" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="header-nav md:flex items-center space-x-1">
                <a href="./paginainicial.php" class="header-nav-link flex items-center">
                    <i class="fas fa-home mr-2"></i>
                    <span>Início</span>
                </a>
                <a href="estoque.php" class="header-nav-link flex items-center">
                    <i class="fas fa-boxes mr-2"></i>
                    <span>Estoque</span>
                </a>
                <a href="adicionarproduto.php" class="header-nav-link flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    <span>Adicionar</span>
                </a>
            
                    <a href="solicitar.php" class="header-nav-link flex items-center cursor-pointer">
                        <i class="fas fa-clipboard-list mr-2"></i>
                        <span>Solicitar</span>
                      
                    </a>
                <a href="relatorios.php" class="header-nav-link active flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    <span>Relatórios</span>
                </a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 md:py-12 flex-1">
        <!-- Título da Página -->
        <div class="text-center mb-8">
            <h1 class="text-primary text-3xl md:text-4xl font-bold mb-4 page-title tracking-tight font-heading">
                <i class="fas fa-chart-line mr-3 text-secondary"></i>
                CENTRO DE RELATÓRIOS
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Acesse relatórios detalhados e estatísticas em tempo real do seu estoque
            </p>
        </div>

        <!-- Estatísticas Rápidas -->
        <div class="quick-stats mb-8">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-number" id="totalProdutos">-</div>
                <div class="stat-label">Total de Produtos</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                </div>
                <div class="stat-number" id="produtosCriticos">-</div>
                <div class="stat-label">Estoque Crítico</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-number" id="totalCategorias">-</div>
                <div class="stat-label">Categorias</div>
            </div>
        </div>

        <!-- Gráfico de Estoque -->
        <div class="bg-white rounded-xl shadow-card p-6 mb-8">
            <h2 class="text-xl font-bold text-primary mb-4 flex items-center">
                <i class="fas fa-chart-pie mr-2 text-secondary"></i>
                Visão Geral do Estoque
            </h2>
            <div class="chart-container">
                <canvas id="estoqueChart"></canvas>
            </div>
        </div>

        <!-- Relatórios Disponíveis -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Relatório de Estoque Completo -->
            <div class="report-card bg-white border-2 border-primary rounded-xl shadow-card p-6 flex flex-col items-center animate-fade-in">
                <div class="card-shine"></div>
                <div class="card-icon w-16 h-16 text-primary mb-4 flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-primary mb-2 text-center">Relatório Completo</h3>
                <p class="text-gray-600 text-center mb-4 text-sm">Relatório detalhado de todo o estoque atual</p>
                <a href="../control/controllerEstoqueAtual.php" class="bg-gradient-to-r from-secondary to-orange-500 text-white py-2 px-6 rounded-lg hover:from-orange-500 hover:to-secondary transition-all duration-300 font-semibold transform hover:scale-105" target="_blank">
                    <i class="fas fa-download mr-2"></i>
                    Gerar PDF
                </a>
            </div>

            <!-- Relatório por Período -->
            <div class="report-card bg-white border-2 border-primary rounded-xl shadow-card p-6 flex flex-col items-center animate-fade-in" style="animation-delay: 0.1s">
                <div class="card-shine"></div>
                <div class="card-icon w-16 h-16 text-primary mb-4 flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-primary mb-2 text-center">Relatório de Movimentações</h3>
                <p class="text-gray-600 text-center mb-4 text-sm">Relatório de movimentação de estoque por período específico</p>
                <button id="openDateModal" class="bg-gradient-to-r from-secondary to-orange-500 text-white py-2 px-6 rounded-lg hover:from-orange-500 hover:to-secondary transition-all duration-300 font-semibold transform hover:scale-105">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Selecionar Data
                </button>
            </div>

            <!-- Relatório de Estoque Crítico -->
            <div class="report-card bg-white border-2 border-primary rounded-xl shadow-card p-6 flex flex-col items-center animate-fade-in" style="animation-delay: 0.2s">
                <div class="card-shine"></div>
                <div class="card-icon w-16 h-16 text-primary mb-4 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-primary mb-2 text-center">Estoque Crítico</h3>
                <p class="text-gray-600 text-center mb-4 text-sm">Produtos com estoque baixo (≤ 5 unidades)</p>
                <a href="../control/controllerrelatoriocritico.php" class="bg-gradient-to-r from-warning to-yellow-500 text-white py-2 px-6 rounded-lg hover:from-yellow-500 hover:to-warning transition-all duration-300 font-semibold transform hover:scale-105" target="_blank">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    Ver Críticos
                </a>
            </div>

            <!-- Relatório por Produto -->
            <div class="report-card bg-white border-2 border-primary rounded-xl shadow-card p-6 flex flex-col items-center animate-fade-in" style="animation-delay: 0.3s">
                <div class="card-shine"></div>
                <div class="card-icon w-16 h-16 text-primary mb-4 flex items-center justify-center">
                    <i class="fas fa-search text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-primary mb-2 text-center">Por Produto</h3>
                <p class="text-gray-600 text-center mb-4 text-sm">Relatório detalhado de produto específico</p>
                <button id="openProductModal" class="bg-gradient-to-r from-secondary to-orange-500 text-white py-2 px-6 rounded-lg hover:from-orange-500 hover:to-secondary transition-all duration-300 font-semibold transform hover:scale-105">
                    <i class="fas fa-search-plus mr-2"></i>
                    Selecionar Produto
                </button>
            </div>

            <!-- Relatório por Data (Produtos Adicionados) -->
            <div class="report-card bg-white border-2 border-primary rounded-xl shadow-card p-6 flex flex-col items-center animate-fade-in" style="animation-delay: 0.4s">
                <div class="card-shine"></div>
                <div class="card-icon w-16 h-16 text-primary mb-4 flex items-center justify-center">
                    <i class="fas fa-plus-circle text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-primary mb-2 text-center">Produtos por Data</h3>
                <p class="text-gray-600 text-center mb-4 text-sm">Relatório de produtos adicionados em período específico</p>
                <a href="relatorio_por_data.php" class="bg-gradient-to-r from-secondary to-orange-500 text-white py-2 px-6 rounded-lg hover:from-orange-500 hover:to-secondary transition-all duration-300 font-semibold transform hover:scale-105">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Selecionar Período
                </a>
            </div>
        </div>

    </main>

    <!-- Modal para Seleção de Data -->
    <div id="dateModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" id="closeDateModal">×</button>
            <h2 class="font-heading">
                <i class="fas fa-calendar-alt mr-2 text-secondary"></i>
                Selecionar Período
            </h2>
            <form id="dateForm" action="../control/controllerRelatorioData.php" method="GET" target="_blank" class="space-y-4">
                <div class="form-group">
                    <label for="data_inicio" class="font-semibold">
                        <i class="fas fa-play mr-1"></i>
                        Data de Início
                    </label>
                    <input type="date" id="data_inicio" name="data_inicio" required>
                </div>
                <div class="form-group">
                    <label for="data_fim" class="font-semibold">
                        <i class="fas fa-stop mr-1"></i>
                        Data de Fim
                    </label>
                    <input type="date" id="data_fim" name="data_fim" required>
                </div>
                <button type="submit" class="confirm-btn">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Gerar Relatório
                </button>
            </form>
        </div>
    </div>

    <!-- Modal para Seleção de Produto -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" id="closeProductModal">×</button>
            <h2 class="font-heading">
                <i class="fas fa-search mr-2 text-secondary"></i>
                Selecionar Produto
            </h2>
            <form id="productForm" action="../control/controllerRelatorioProduto.php" method="GET" target="_blank" class="space-y-4">
                <div class="form-group">
                    <label for="data_inicio" class="font-semibold">
                        <i class="fas fa-play mr-1"></i>
                        Data de Início
                    </label>
                    <input type="date" id="data_inicio_product" name="data_inicio" required>
                </div>
                <div class="form-group">
                    <label for="data_fim" class="font-semibold">
                        <i class="fas fa-stop mr-1"></i>
                        Data de Fim
                    </label>
                    <input type="date" id="data_fim_product" name="data_fim" required>
                </div>
                <div class="form-group">
                    <label for="produto" class="font-semibold">
                        <i class="fas fa-box mr-1"></i>
                        Produto
                    </label>
                    <select id="produto" name="produto" required>
                        <option value="" disabled selected>SELECIONAR PRODUTO</option>
                        <?php
                        require_once('../model/functionsViews.php');
                        $select = new select();
                        $resultado = $select->modalRelatorio($barcode);
                        ?>
                    </select>
                </div>
                <button type="submit" class="confirm-btn">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Gerar Relatório
                </button>
            </form>
        </div>
    </div>

    <footer class="bg-gradient-to-r from-primary to-dark text-white py-6 mt-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Sobre a Escola -->
                <div>
                    <h3 class="font-heading text-lg font-semibold mb-3 flex items-center">
                        <i class="fas fa-school mr-2 text-sm"></i>
                        EEEP STGM
                    </h3>
                    <p class="text-xs leading-relaxed">
                        <i class="fas fa-map-marker-alt mr-1 text-xs"></i>
                        AV. Marta Maria Carvalho Nojoza, SN<br>
                        Maranguape - CE
                    </p>
                </div>

                <!-- Contato -->
                <div>
                    <h3 class="font-heading text-lg font-semibold mb-3 flex items-center">
                        <i class="fas fa-address-book mr-2 text-sm"></i>
                        Contato
                    </h3>
                    <div class="text-xs leading-relaxed space-y-1">
                        <p class="flex items-start">
                            <i class="fas fa-phone-alt mr-1 mt-0.5 text-xs"></i>
                            (85) 3341-3990
                        </p>
                        <p class="flex items-start">
                            <i class="fas fa-envelope mr-1 mt-0.5 text-xs"></i>
                            eeepsantariamata@gmail.com
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="font-heading text-lg font-semibold mb-3 flex items-center">
                        <i class="fas fa-code mr-2 text-sm"></i>
                        Dev Team
                    </h3>
                    <div class="grid grid-cols-2 gap-2">
                        <a
                            class="text-xs flex items-center hover:text-secondary transition-colors">
                            <i class="fab fa-instagram mr-1 text-xs"></i>
                            Matheus Felix
                        </a>
                        <a 
                            class="text-xs flex items-center hover:text-secondary transition-colors">
                            <i class="fab fa-instagram mr-1 text-xs"></i>
                           Roger Cavalcante
                        </a>
                        <a 
                            class="text-xs flex items-center hover:text-secondary transition-colors">
                            <i class="fab fa-instagram mr-1 text-xs"></i>
                            Matheus Machado
                        </a>
                     
                    </div>
                </div>
            </div>

            <!-- Rodapé inferior compacto -->
            <div class="border-t border-white/20 pt-4 mt-4 text-center">
                <p class="text-xs">
                    © 2024 STGM v1.2.0 | Desenvolvido por alunos EEEP STGM
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos do modal
            const openDateModalBtn = document.getElementById('openDateModal');
            const dateModal = document.getElementById('dateModal');
            const closeDateModalBtn = document.getElementById('closeDateModal');
            const dateForm = document.getElementById('dateForm');

            const openProductModalBtn = document.getElementById('openProductModal');
            const productModal = document.getElementById('productModal');
            const closeProductModalBtn = document.getElementById('closeProductModal');
            const productForm = document.getElementById('productForm');

            // Carregar estatísticas em tempo real
            loadStatistics();

            // Configurar gráfico
            // setupChart(); // Remover chamada antiga

            // Abrir Modal de Data
            openDateModalBtn.addEventListener('click', function() {
                dateModal.classList.add('show');
                const today = new Date();
                const thirtyDaysAgo = new Date(today);
                thirtyDaysAgo.setDate(today.getDate() - 30);
                document.getElementById('data_inicio').value = thirtyDaysAgo.toISOString().split('T')[0];
                document.getElementById('data_fim').value = today.toISOString().split('T')[0];
            });

            // Fechar Modal de Data
            closeDateModalBtn.addEventListener('click', function() {
                dateModal.classList.remove('show');
                dateForm.reset();
            });

            // Abrir Modal de Produto
            openProductModalBtn.addEventListener('click', function() {
                productModal.classList.add('show');
                const today = new Date();
                const thirtyDaysAgo = new Date(today);
                thirtyDaysAgo.setDate(today.getDate() - 30);
                document.getElementById('data_inicio_product').value = thirtyDaysAgo.toISOString().split('T')[0];
                document.getElementById('data_fim_product').value = today.toISOString().split('T')[0];
            });

            // Fechar Modal de Produto
            closeProductModalBtn.addEventListener('click', function() {
                productModal.classList.remove('show');
                productForm.reset();
            });

            // Fechar Modais ao clicar fora
            [dateModal, productModal].forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.remove('show');
                        if (modal === dateModal) {
                            dateForm.reset();
                        } else if (modal === productModal) {
                            productForm.reset();
                        }
                    }
                });
            });

            // Validação do formulário de data
            dateForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const data_inicio = document.getElementById('data_inicio').value;
                const data_fim = document.getElementById('data_fim').value;

                if (!data_inicio || !data_fim) {
                    showNotification('Por favor, preencha ambas as datas.', 'error');
                    return;
                }

                if (new Date(data_inicio) > new Date(data_fim)) {
                    showNotification('A data de início deve ser anterior à data de fim.', 'error');
                    return;
                }

                // Mostrar loading
                const submitBtn = dateForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="loading-spinner"></span> Gerando...';
                submitBtn.disabled = true;

                // Simular delay e enviar
                setTimeout(() => {
                    dateForm.submit();
                }, 1000);
            });

            // Validação do formulário de produto
            productForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const produto = document.getElementById('produto').value;
                const data_inicio = document.getElementById('data_inicio_product').value;
                const data_fim = document.getElementById('data_fim_product').value;

                if (!produto) {
                    showNotification('Por favor, selecione um produto.', 'error');
                    return;
                }
                if (!data_inicio || !data_fim) {
                    showNotification('Por favor, preencha ambas as datas.', 'error');
                    return;
                }
                if (new Date(data_inicio) > new Date(data_fim)) {
                    showNotification('A data de início deve ser anterior à data de fim.', 'error');
                    return;
                }

                // Mostrar loading
                const submitBtn = productForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="loading-spinner"></span> Gerando...';
                submitBtn.disabled = true;

                // Simular delay e enviar
                setTimeout(() => {
                    productForm.submit();
                }, 1000);
            });

            // Menu mobile
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const headerNav = document.querySelector('.header-nav');
            const menuSpans = document.querySelectorAll('.mobile-menu-button span');

            if (mobileMenuButton && headerNav) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    headerNav.classList.toggle('show');

                    // Animação para o botão do menu
                    menuSpans.forEach(span => {
                        span.classList.toggle('active');
                    });

                    // Prevenir scroll do body quando menu está aberto
                    document.body.style.overflow = headerNav.classList.contains('show') ? 'hidden' : '';
                });

                // Fechar menu ao clicar em um link
                const navLinks = headerNav.querySelectorAll('a');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        headerNav.classList.remove('show');
                        menuSpans.forEach(span => {
                            span.classList.remove('active');
                        });
                        document.body.style.overflow = '';
                    });
                });

                // Fechar menu ao clicar fora
                document.addEventListener('click', function(e) {
                    if (!headerNav.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                        headerNav.classList.remove('show');
                        menuSpans.forEach(span => {
                            span.classList.remove('active');
                        });
                        document.body.style.overflow = '';
                    }
                });

                // Fechar menu ao pressionar ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && headerNav.classList.contains('show')) {
                        headerNav.classList.remove('show');
                        menuSpans.forEach(span => {
                            span.classList.remove('active');
                        });
                        document.body.style.overflow = '';
                    }
                });
            }

            // Função para carregar estatísticas e gráfico reais
            function loadStatistics() {
                console.log('Carregando estatísticas...');
                fetch('../control/controllerEstatisticas.php')
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Dados recebidos:', data);
                        if (data.success) {
                            document.getElementById('totalProdutos').textContent = data.estatisticas.total_produtos;
                            document.getElementById('produtosCriticos').textContent = data.estatisticas.produtos_criticos;
                            document.getElementById('totalCategorias').textContent = data.estatisticas.total_categorias;
                            setupChart(data.grafico);
                            console.log('Estatísticas carregadas com sucesso');
                        } else {
                            console.error('Erro nos dados:', data.error);
                            document.getElementById('totalProdutos').textContent = '-';
                            document.getElementById('produtosCriticos').textContent = '-';
                            document.getElementById('totalCategorias').textContent = '-';
                            setupChart({em_estoque: 0, estoque_critico: 0, sem_estoque: 0});
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao carregar estatísticas:', error);
                        document.getElementById('totalProdutos').textContent = '-';
                        document.getElementById('produtosCriticos').textContent = '-';
                        document.getElementById('totalCategorias').textContent = '-';
                        setupChart({em_estoque: 0, estoque_critico: 0, sem_estoque: 0});
                    });
            }

            // Função para configurar gráfico com dados reais
            function setupChart(graficoData) {
                const ctx = document.getElementById('estoqueChart').getContext('2d');
                if (window.estoqueChartInstance) {
                    window.estoqueChartInstance.destroy();
                }
                window.estoqueChartInstance = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Em Estoque', 'Estoque Crítico', 'Sem Estoque'],
                        datasets: [{
                            data: [
                                graficoData.em_estoque || 0,
                                graficoData.estoque_critico || 0,
                                graficoData.sem_estoque || 0
                            ],
                            backgroundColor: [
                                '#28A745',
                                '#FFC107',
                                '#DC3545'
                            ],
                            borderWidth: 2,
                            borderColor: '#FFFFFF'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Função para mostrar notificações
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
                
                const bgColor = type === 'error' ? 'bg-red-500' : type === 'success' ? 'bg-green-500' : 'bg-blue-500';
                notification.className += ` ${bgColor} text-white`;
                
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'} mr-2"></i>
                        <span>${message}</span>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Animar entrada
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                // Remover após 3 segundos
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }
        });
    </script>
</body>

</html>