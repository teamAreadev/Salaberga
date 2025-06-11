<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
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

        .custom-radio {
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .custom-radio:hover {
            background-color: rgba(0, 90, 36, 0.05);
        }

        .custom-radio input[type="radio"] {
            position: relative;
            cursor: pointer;
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #005A24;
            border-radius: 50%;
            margin-right: 10px;
            outline: none;
        }

        .custom-radio input[type="radio"]:checked {
            background-color: #FFA500;
            border-color: #FFA500;
        }

        .custom-radio input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: white;
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #FFA500;
            transition: width 0.3s ease;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background-color: white;
            margin: 2px 0;
            transition: all 0.3s ease;
        }

        .mobile-menu {
            transition: max-height 0.3s ease-in-out;
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }

            .nav-links {
                display: none;
            }

            .nav-links.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, #005A24 0%, #1A3C34 100%);
                padding: 1rem;
                max-height: 400px;
            }
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #FFA500;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            z-index: 1000;
        }

        .back-to-top.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .back-to-top:hover {
            background-color: #E69500;
            transform: scale(1.1);
        }

        .social-icon {
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px);
            filter: drop-shadow(0 4px 3px rgba(255, 165, 0, 0.3));
        }

        .page-title {
            position: relative;
            display: inline-block;
            background: linear-gradient(135deg, #005A24 0%, #1A3C34 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 90, 36, 0.3);
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 4px;
            background-color: #FFA500;
            border-radius: 4px;
        }

        /* Estilos para o header melhorado */
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
                top: -1px;
            }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col font-sans bg-light">
    <!-- Header Melhorado -->
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
                <a href="paginainicial.php" class="header-nav-link flex items-center">
                    <i class="fas fa-home mr-2"></i>
                    <span>Início</span>
                </a>
                <a href="estoque.php" class="header-nav-link flex items-center">
                    <i class="fas fa-boxes mr-2"></i>
                    <span>Estoque</span>
                </a>
                <a href="adicionarproduto.php" class="header-nav-link active flex items-center">
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
                <a href="relatorios.php" class="header-nav-link flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    <span>Relatórios</span>
                </a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 md:py-12 flex-1">
        <div class="text-center mb-10">
            <h1 class="text-primary text-3xl md:text-4xl font-bold mb-8 md:mb-6 text-center page-title tracking-tight font-heading inline-block mx-auto">ADICIONAR NOVO PRODUTO</h1>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl w-full border-2 border-primary mx-auto">
            <form action="../control/controllerAdicionarProduto.php?barcode=" method="POST" class="space-y-6">
                <div class="space-y-4">
                    <div>
                        <input type="text" placeholder="NOME DO PRODUTO" id="nome" name="nome" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required
                            class="w-full px-4 py-3 border-2 border-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-center font-semibold"
                            aria-label="Nome do produto">
                    </div>

                    <div>
                        <input type="number" placeholder="QUANTIDADE" min="1" id="quantidade" name="quantidade" required
                            class="w-full px-4 py-3 border-2 border-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-center font-semibold"
                            aria-label="Quantidade do produto">
                    </div>

                    <div class="p-4 border-2 border-primary rounded-lg">
                        <p class="font-semibold text-primary mb-3 text-center">Selecione a Categoria</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <label class="custom-radio p-2 rounded-lg">
                                <input type="radio" id="limpeza" name="natureza" value="limpeza" aria-label="Limpeza">
                                <span class="text-gray-700">Limpeza</span>
                            </label>

                            <label class="custom-radio p-2 rounded-lg">
                                <input type="radio" id="expedientes" name="natureza" value="expedientes" aria-label="Expedientes">
                                <span class="text-gray-700">Expedientes</span>
                            </label>

                            <label class="custom-radio p-2 rounded-lg">
                                <input type="radio" id="manutencao" name="natureza" value="manutencao" aria-label="Manutenção">
                                <span class="text-gray-700">Manutenção</span>
                            </label>

                            <label class="custom-radio p-2 rounded-lg">
                                <input type="radio" id="eletrico" name="natureza" value="eletrico" aria-label="Elétrico">
                                <span class="text-gray-700">Elétrico</span>
                            </label>

                            <label class="custom-radio p-2 rounded-lg">
                                <input type="radio" id="hidraulico" name="natureza" value="hidraulico" aria-label="Hidráulico">
                                <span class="text-gray-700">Hidráulico</span>
                            </label>

                            <label class="custom-radio p-2 rounded-lg">
                                <input type="radio" id="educacao_fisica" name="natureza" value="educacao_fisica" aria-label="Educação Física">
                                <span class="text-gray-700">Educação Física</span>
                            </label>

                            <label class="custom-radio p-2 rounded-lg">
                                <input type="radio" id="epi" name="natureza" value="epi" aria-label="EPI">
                                <span class="text-gray-700">EPI</span>
                            </label>

                            <label class="custom-radio p-2 rounded-lg">
                                <input type="radio" id="copa_e_cozinha" name="natureza" value="copa_e_cozinha" aria-label="Copa e Cozinha">
                                <span class="text-gray-700">Copa e Cozinha</span>
                            </label>

                            <label class="custom-radio p-2 rounded-lg">
                                <input type="radio" id="informatica" name="natureza" value="informatica" aria-label="Informática">
                                <span class="text-gray-700">Informática</span>
                            </label>

                            <label class="custom-radio p-2 rounded-lg">
                                <input type="radio" id="ferramentas" name="natureza" value="ferramentas" aria-label="Ferramentas">
                                <span class="text-gray-700">Ferramentas</span>
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="barcode" value="<?php echo htmlspecialchars($barcode); ?>">
                </div>
                <button type="submit" name="btn" value="Adicionar" class="w-full bg-secondary text-white font-bold py-3 px-4 rounded-lg hover:bg-opacity-90 transition-colors"
                    aria-label="Adicionar produto">
                    ADICIONAR
                </button>
        </div>


        </form>
        </div>
    </main>

    <!-- Footer -->
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
                            class="text-xs flex items-center hover:text-secondary transition-colors social-icon">
                            <i class="fab fa-instagram mr-1 text-xs"></i>
                            Carlos E.
                        </a>
                        <a href="https://www.instagram.com/millenafreires_/" target="_blank"
                            class="text-xs flex items-center hover:text-secondary transition-colors social-icon">
                            <i class="fab fa-instagram mr-1 text-xs"></i>
                            Millena F.
                        </a>
                        <a href="https://www.instagram.com/matheusz.mf/" target="_blank"
                            class="text-xs flex items-center hover:text-secondary transition-colors social-icon">
                            <i class="fab fa-instagram mr-1 text-xs"></i>
                            Matheus M.
                        </a>
                        <a href="https://www.instagram.com/yanlucas10__/" target="_blank"
                            class="text-xs flex items-center hover:text-secondary transition-colors social-icon">
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
        <button class="back-to-top hidden" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" aria-label="Voltar ao topo">
            <i class="fas fa-arrow-up"></i>
        </button>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menu mobile toggle
            const menuButton = document.getElementById('menuButton');
            const headerNav = document.getElementById('headerNav');

            if (menuButton && headerNav) {
                menuButton.addEventListener('click', function() {
                    headerNav.classList.toggle('show');

                    // Animação para o botão do menu
                    const spans = menuButton.querySelectorAll('span');
                    spans.forEach(span => {
                        span.classList.toggle('active');
                    });
                });
            }

            // Adicionar suporte para dropdown no mobile
            const dropdownToggle = document.querySelector('.group > a');
            const dropdownMenu = document.querySelector('.group > div');

            if (window.innerWidth <= 768) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdownMenu.classList.toggle('scale-0');
                    dropdownMenu.classList.toggle('scale-100');
                });
            }

            // Hamburger menu toggle
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');

            if (hamburger && navLinks) {
                hamburger.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                    hamburger.classList.toggle('open');
                });
            }

            // Back to top button visibility
            const backToTop = document.querySelector('.back-to-top');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTop.classList.add('visible');
                    backToTop.classList.remove('hidden');
                } else {
                    backToTop.classList.remove('visible');
                    backToTop.classList.add('hidden');
                }
            });

            // Lazy loading for images
            if ('loading' in HTMLImageElement.prototype) {
                const images = document.querySelectorAll('img[loading="lazy"]');
                images.forEach(img => {
                    img.loading = 'lazy';
                });
            }
        });
    </script>
</body>

</html>