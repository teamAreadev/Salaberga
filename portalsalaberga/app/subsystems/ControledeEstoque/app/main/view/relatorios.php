<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Relatórios</title>
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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
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
            background-color: #F8FAF9;
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
            background-color: #FFA500;
            border-radius: 3px;
        }

        .card-item {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            will-change: transform;
            width: 100%;
            max-width: 320px;
        }

        .card-item::before {
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

        .card-item:hover::before {
            opacity: 1;
        }

        .card-item:hover {
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

        .card-item:hover .card-icon {
            transform: scale(1.1);
            color: #FFA500;
        }

        .card-item p {
            z-index: 2;
            position: relative;
            transition: color 0.3s ease;
        }

        .card-item:hover p {
            color: #005A24;
        }

        .card-item a,
        .card-item button {
            position: relative;
            z-index: 3;
        }

        .card-item:hover .card-shine {
            left: 150%;
        }

        .social-icon {
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px);
            filter: drop-shadow(0 4px 3px rgba(255, 165, 0, 0.3));
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

        .bottom-row {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1.5rem;
            margin-left: auto;
            margin-right: auto;
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
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background-color: #FFFFFF;
            padding: 2rem;
            border-radius: 1rem;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 15px -3px rgba(0, 90, 36, 0.2);
            animation: slideUp 0.5s ease-out;
            position: relative;
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
        }

        .modal-content input[type="date"] {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #E6F4EA;
            border-radius: 0.5rem;
            font-size: 1rem;
            color: #1A3C34;
            background-color: #F8FAF9;
            transition: border-color 0.3s ease;
        }

        .modal-content input[type="date"]:focus {
            border-color: #FFA500;
            outline: none;
        }

        .modal-content .confirm-btn {
            background-color: #FFA500;
            color: #FFFFFF;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .modal-content .confirm-btn:hover {
            background-color: #E59400;
            transform: translateY(-2px);
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

        @media (max-width: 768px) {
            .header-nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, #005A24 0%, #1A3C34 100%);
                padding: 1rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                z-index: 40;
            }

            .header-nav.show {
                display: flex;
                flex-direction: column;
            }

            .header-nav-link {
                padding: 0.75rem 1rem;
                text-align: center;
                margin: 0.25rem 0;
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
                z-index: 10;
            }

            .mobile-menu-button span {
                width: 100%;
                height: 3px;
                background-color: white;
                border-radius: 10px;
                transition: all 0.3s linear;
                position: relative;
                transform-origin: 1px;
            }

            .mobile-menu-button span:first-child.active {
                transform: rotate(45deg);
                top: 0px;
            }

            .mobile-menu-button span:nth-child(2).active {
                opacity: 0;
            }

            .mobile-menu-button span:nth-child(3).active {
                transform: rotate(-45deg);
                top: auto;
                bottom: 0px;
            }

            .bottom-row {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 1.5rem;
            }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col font-sans bg-light">
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
                <div class="relative group">
                    <a class="header-nav-link flex items-center cursor-pointer">
                        <i class="fas fa-clipboard-list mr-2"></i>
                        <span>Solicitar</span>
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </a>
                    <div class="absolute left-0 mt-1 w-48 bg-white rounded-lg shadow-lg overflow-hidden transform scale-0 group-hover:scale-100 transition-transform origin-top z-50">
                        <a href="solicitar.php" class="block px-4 py-2 text-primary hover:bg-primary hover:text-white transition-colors">
                            <i class="fas fa-clipboard-check mr-2"></i>Solicitar Produto
                        </a>
                        <a href="solicitarnovproduto.php" class="block px-4 py-2 text-primary hover:bg-primary hover:text-white transition-colors">
                            <i class="fas fa-plus-square mr-2"></i>Solicitar Novo Produto
                        </a>
                    </div>
                </div>
                <a href="relatorios.php" class="header-nav-link active flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    <span>Relatórios</span>
                </a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 md:py-12 flex-1 flex flex-col items-center">
        <h1 class="text-primary text-3xl md:text-4xl font-bold mb-8 md:mb-12 text-center page-title tracking-tight font-heading w-full">GERAR RELATÓRIOS</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-6xl mx-auto justify-items-center">
            <!-- Relatório de Estoque -->
            <div class="card-item bg-white border-2 border-primary rounded-xl shadow-lg p-6 flex flex-col items-center animate-fade-in">
                <div class="card-shine"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-primary mb-4 card-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <h2 class="text-xl font-bold text-primary mb-2">Relatório de Estoque</h2>
                <p class="text-gray-600 text-center mb-4">Gerar relatório completo do estoque atual</p>
                <a href="../control/controllerEstoqueAtual.php" class="bg-secondary text-white py-2 px-4 rounded-lg hover:bg-opacity-90 transition-colors font-semibold" target="_blank">
                    Gerar Relatório
                </a>
            </div>

            <!-- Relatório de Estoque por Data -->
            <div class="card-item bg-white border-2 border-primary rounded-xl shadow-lg p-6 flex flex-col items-center animate-fade-in" style="animation-delay: 0.1s">
                <div class="card-shine"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-primary mb-4 card-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h2 class="text-xl font-bold text-primary mb-2">Estoque por Data</h2>
                <p class="text-gray-600 text-center mb-4">Relatório de estoque por período</p>
                <button id="openDateModal" class="bg-secondary text-white py-2 px-4 rounded-lg hover:bg-opacity-90 transition-colors font-semibold">
                    Gerar Relatório
                </button>
            </div>

            <!-- Relatório de Estoque Crítico -->
            <div class="card-item bg-white border-2 border-primary rounded-xl shadow-lg p-6 flex flex-col items-center animate-fade-in" style="animation-delay: 0.2s">
                <div class="card-shine"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-primary mb-4 card-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-xl font-bold text-primary mb-2">Estoque Crítico</h2>
                <p class="text-gray-600 text-center mb-4">Relatório de itens com estoque baixo igual ou abaixo de 5</p>
                <a href="../control/controllerrelatoriocritico.php" class="bg-secondary text-white py-2 px-4 rounded-lg hover:bg-opacity-90 transition-colors font-semibold" target="_blank">
                    Gerar Relatório
                </a>
            </div>

            <!-- Relatório de Estoque por Produto -->
            <div class="card-item bg-white border-2 border-primary rounded-xl shadow-lg p-6 flex flex-col items-center animate-fade-in" style="animation-delay: 0.3s">
                <div class="card-shine"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-primary mb-4 card-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h2 class="text-xl font-bold text-primary mb-2">Estoque por Produto</h2>
                <p class="text-gray-600 text-center mb-4">Relatório detalhado por produto e data específica</p>
                <button id="openProductModal" class="bg-secondary text-white py-2 px-4 rounded-lg hover:bg-opacity-90 transition-colors font-semibold">
                    Gerar Relatório
                </button>
            </div>
        </div>
    </main>

    <!-- Modal for Date Selection -->
    <div id="dateModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" id="closeDateModal">×</button>
            <h2 class="font-heading">Selecionar Período</h2>
            <form id="dateForm" action="../control/controllerRelatorioData.php" method="GET" target="_blank" class="space-y-4">
                <div class="form-group">
                    <label for="data_inicio" class="font-semibold">Data de Início</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="border border-accent rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-secondary" required>
                </div>
                <div class="form-group">
                    <label for="data_fim" class="font-semibold">Data de Fim</label>
                    <input type="date" id="data_fim" name="data_fim" class="border border-accent rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-secondary" required>
                </div>
                <button type="submit" class="confirm-btn">Confirmar</button>
            </form>
        </div>
    </div>

    <!-- Modal for Product Selection -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" id="closeProductModal">×</button>
            <h2 class="font-heading">Selecionar Produto</h2>
            <form id="productForm" action="../control/controllerRelatorioProduto.php" method="GET" target="_blank" class="space-y-4">
                <div class="form-group">
                    <label for="data_inicio" class="font-semibold">Data de Início</label>
                    <input type="date" id="data_inicio_product" name="data_inicio" class="border border-accent rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-secondary" required>
                </div>
                <div class="form-group">
                    <label for="data_fim" class="font-semibold">Data de Fim</label>
                    <input type="date" id="data_fim_product" name="data_fim" class="border border-accent rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-secondary" required>
                </div>
                <div class="form-group">
                    <label for="produto" class="font-semibold">Produto</label>
                    <select id="produto" name="produto" class="border border-accent rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-secondary" required>
                        <option value="" disabled selected>SELECIONAR PRODUTO</option>
                        <?php
                        require_once('../model/functionsViews.php');
                        $select = new select();
                        $resultado = $select->modalRelatorio($barcode);
                        ?>
                    </select>
                </div>
                <button type="submit" class="confirm-btn">Confirmar</button>
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

                <!-- Desenvolvedores em Grid -->
                <div>
                    <h3 class="font-heading text-lg font-semibold mb-3 flex items-center">
                        <i class="fas fa-code mr-2 text-sm"></i>
                        Dev Team
                    </h3>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="https://www.instagram.com/dudu.limasx/" target="_blank"
                            class="text-xs flex items-center hover:text-secondary transition-colors">
                            <i class="fab fa-instagram mr-1 text-xs"></i>
                            Carlos E.
                        </a>
                        <a href="https://www.instagram.com/millenafreires_/" target="_blank"
                            class="text-xs flex items-center hover:text-secondary transition-colors">
                            <i class="fab fa-instagram mr-1 text-xs"></i>
                            Millena F.
                        </a>
                        <a href="https://www.instagram.com/matheusz.mf/" target="_blank"
                            class="text-xs flex items-center hover:text-secondary transition-colors">
                            <i class="fab fa-instagram mr-1 text-xs"></i>
                            Matheus M.
                        </a>
                        <a href="https://www.instagram.com/yanlucas10__/" target="_blank"
                            class="text-xs flex items-center hover:text-secondary transition-colors">
                            <i class="fab fa-instagram mr-1 text-xs"></i>
                            Ian Lucas
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
            const openDateModalBtn = document.getElementById('openDateModal');
            const dateModal = document.getElementById('dateModal');
            const closeDateModalBtn = document.getElementById('closeDateModal');
            const dateForm = document.getElementById('dateForm');

            const openProductModalBtn = document.getElementById('openProductModal');
            const productModal = document.getElementById('productModal');
            const closeProductModalBtn = document.getElementById('closeProductModal');
            const productForm = document.getElementById('productForm');

            // Open Date Modal
            openDateModalBtn.addEventListener('click', function() {
                dateModal.classList.add('show');
                const today = new Date();
                const thirtyDaysAgo = new Date(today);
                thirtyDaysAgo.setDate(today.getDate() - 30);
                document.getElementById('data_inicio').value = thirtyDaysAgo.toISOString().split('T')[0];
                document.getElementById('data_fim').value = today.toISOString().split('T')[0];
            });

            // Close Date Modal
            closeDateModalBtn.addEventListener('click', function() {
                dateModal.classList.remove('show');
                dateForm.reset();
            });

            // Open Product Modal
            openProductModalBtn.addEventListener('click', function() {
                productModal.classList.add('show');
                const today = new Date();
                const thirtyDaysAgo = new Date(today);
                thirtyDaysAgo.setDate(today.getDate() - 30);
                document.getElementById('data_inicio_product').value = thirtyDaysAgo.toISOString().split('T')[0];
                document.getElementById('data_fim_product').value = today.toISOString().split('T')[0];
            });

            // Close Product Modal
            closeProductModalBtn.addEventListener('click', function() {
                productModal.classList.remove('show');
                productForm.reset();
            });

            // Close Modals when clicking outside
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

            // Form Submission for Date
            dateForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const data_inicio = document.getElementById('data_inicio').value;
                const data_fim = document.getElementById('data_fim').value;

                if (!data_inicio || !data_fim) {
                    alert('Por favor, preencha ambas as datas.');
                    return;
                }

                if (new Date(data_inicio) > new Date(data_fim)) {
                    alert('A data de início deve ser anterior à data de fim.');
                    return;
                }

                dateForm.submit();
            });

            // Form Submission for Product
            productForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const produto = document.getElementById('produto').value;
                const data_inicio = document.getElementById('data_inicio_product').value;
                const data_fim = document.getElementById('data_fim_product').value;

                if (!produto) {
                    alert('Por favor, selecione um produto.');
                    return;
                }
                if (!data_inicio || !data_fim) {
                    alert('Por favor, preencha ambas as datas.');
                    return;
                }
                if (new Date(data_inicio) > new Date(data_fim)) {
                    alert('A data de início deve ser anterior à data de fim.');
                    return;
                }

                productForm.submit();
            });

            // Mobile Menu Toggle
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const headerNav = document.querySelector('.header-nav');
            const menuSpans = document.querySelectorAll('.mobile-menu-button span');

            mobileMenuButton.addEventListener('click', () => {
                headerNav.classList.toggle('show');
                menuSpans.forEach(span => span.classList.toggle('active'));
            });
        });
    </script>
</body>

</html>