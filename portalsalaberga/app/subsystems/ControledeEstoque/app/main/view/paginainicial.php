<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Estoque</title>
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

        .card-item {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            will-change: transform;
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

        .card-icon {
            transition: all 0.3s ease;
            z-index: 2;
            position: relative;
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

        .logo-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: translateY(-50%) translateX(-50%) scale(1);
            }

            50% {
                transform: translateY(-50%) translateX(-50%) scale(1.05);
            }

            100% {
                transform: translateY(-50%) translateX(-50%) scale(1);
            }
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

        .card-item:hover .card-shine {
            left: 150%;
        }

        .card-badge {
            transition: all 0.3s ease;
        }

        .card-item:hover .card-badge {
            background-color: #FFA500;
            color: white;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            background-color: #FF5252;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
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
    </style>
</head>

<body class="min-h-screen flex flex-col font-sans bg-light">
    <!-- Improved Header -->
    <header class="sticky top-0 bg-gradient-to-r from-primary to-dark text-white py-4 shadow-lg z-50">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="../assets/imagens/logostgm.png" alt="Logo S" class="h-12 mr-3 transition-transform hover:scale-105">
                <span class="text-white font-heading text-xl font-semibold hidden md:inline">STGM Estoque</span>
                <a href="https://salaberga.com/salaberga/portalsalaberga/app/main/views/autenticacao/login.php" class="header-nav-link flex items-center text-sm md:text-base">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    <span>Sair</span>
                </a>
            </div>

            <button class="mobile-menu-button focus:outline-none" aria-label="Menu" id="menuButton">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="header-nav md:flex items-center space-x-1" id="headerNav">
                <a href="paginainicial.php" class="header-nav-link active flex items-center">
                    <i class="fas fa-home mr-2"></i>
                    <span>Início</span>
                </a>
                <a href="../view/estoque.php" class="header-nav-link flex items-center">
                    <i class="fas fa-boxes mr-2"></i>
                    <span>Estoque</span>
                </a>
                <a href="../view/adicionarproduto.php" class="header-nav-link flex items-center">
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
                        <a href="../view/solicitar.php" class="block px-4 py-2 text-primary hover:bg-primary hover:text-white transition-colors">
                            <i class="fas fa-clipboard-check mr-2"></i>Solicitar Produto
                        </a>
                        <a href="solicitarnovproduto.php" class="block px-4 py-2 text-primary hover:bg-primary hover:text-white transition-colors">
                            <i class="fas fa-plus-square mr-2"></i>Solicitar Novo Produto
                        </a>
                    </div>
                </div>
                <a href="../view/relatorios.php" class="header-nav-link flex items-center" target="_blank">
                    <i class="fas fa-chart-bar mr-2"></i>
                    <span>Relatórios</span>
                </a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-8 md:py-12 flex-1 flex flex-col items-center justify-center">
        <h1 class="text-primary text-3xl md:text-4xl font-bold mb-12 md:mb-16 mt-6 md:mt-8 text-center page-title tracking-tight font-heading">GERENCIAMENTO DE ESTOQUE</h1>

        <div class="w-full max-w-7xl grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6 px-2">
            <a href="../view/estoque.php" class="group animate-fade-in">
                <div class="card-item bg-white border-2 border-primary rounded-xl md:rounded-2xl shadow-card w-full h-48 md:h-56 flex flex-col items-center justify-center p-4 md:p-6 relative">
                    <div class="card-shine"></div>
                    <div class="card-badge absolute top-0 right-0 bg-accent w-10 h-10 md:w-12 md:h-12 rounded-bl-xl md:rounded-bl-2xl rounded-tr-xl md:rounded-tr-2xl flex items-center justify-center">
                        <span class="text-primary text-xs font-bold">1</span>
                    </div>
                    <i class="fas fa-boxes card-icon text-4xl md:text-5xl text-primary mb-4 md:mb-5"></i>
                    <p class="text-secondary font-bold text-center text-base md:text-lg leading-tight">ESTOQUE</p>
                </div>
            </a>

            <a href="../view/adicionarproduto.php" class="group animate-fade-in" style="animation-delay: 0.1s">
                <div class="card-item bg-white border-2 border-primary rounded-xl md:rounded-2xl shadow-card w-full h-48 md:h-56 flex flex-col items-center justify-center p-4 md:p-6 relative">
                    <div class="card-shine"></div>
                    <div class="card-badge absolute top-0 right-0 bg-accent w-10 h-10 md:w-12 md:h-12 rounded-bl-xl md:rounded-bl-2xl rounded-tr-xl md:rounded-tr-2xl flex items-center justify-center">
                        <span class="text-primary text-xs font-bold">2</span>
                    </div>
                    <i class="fas fa-plus-circle card-icon text-4xl md:text-5xl text-primary mb-4 md:mb-5"></i>
                    <p class="text-secondary font-bold text-center text-base md:text-lg leading-tight">ADICIONAR</p>
                </div>
            </a>

            <a href="../view/solicitar.php" class="group animate-fade-in" style="animation-delay: 0.2s">
                <div class="card-item bg-white border-2 border-primary rounded-xl md:rounded-2xl shadow-card w-full h-48 md:h-56 flex flex-col items-center justify-center p-4 md:p-6 relative">
                    <div class="card-shine"></div>
                    <div class="card-badge absolute top-0 right-0 bg-accent w-10 h-10 md:w-12 md:h-12 rounded-bl-xl md:rounded-bl-2xl rounded-tr-xl md:rounded-tr-2xl flex items-center justify-center">
                        <span class="text-primary text-xs font-bold">3</span>
                    </div>
                    <i class="fas fa-clipboard-list card-icon text-4xl md:text-5xl text-primary mb-4 md:mb-5"></i>
                    <p class="text-secondary font-bold text-center text-base md:text-lg leading-tight">SOLICITAR</p>
                </div>
            </a>

            <a href="../view/solicitarnovproduto.php" class="group animate-fade-in" style="animation-delay: 0.3s">
                <div class="card-item bg-white border-2 border-primary rounded-xl md:rounded-2xl shadow-card w-full h-48 md:h-56 flex flex-col items-center justify-center p-4 md:p-6 relative">
                    <div class="card-shine"></div>
                    <div class="card-badge absolute top-0 right-0 bg-accent w-10 h-10 md:w-12 md:h-12 rounded-bl-xl md:rounded-bl-2xl rounded-tr-xl md:rounded-tr-2xl flex items-center justify-center">
                        <span class="text-primary text-xs font-bold">4</span>
                    </div>
                    <i class="fas fa-truck-loading card-icon text-4xl md:text-5xl text-primary mb-4 md:mb-5"></i>
                    <p class="text-secondary font-bold text-center text-base md:text-lg leading-tight">SUPRIMENTOS</p>
                </div>
            </a>

            <a href="../view/relatorios.php" class="group animate-fade-in" style="animation-delay: 0.4s" target="_blank">
                <div class="card-item bg-white border-2 border-primary rounded-xl md:rounded-2xl shadow-card w-full h-48 md:h-56 flex flex-col items-center justify-center p-4 md:p-6 relative">
                    <div class="card-shine"></div>
                    <div class="card-badge absolute top-0 right-0 bg-accent w-10 h-10 md:w-12 md:h-12 rounded-bl-xl md:rounded-bl-2xl rounded-tr-xl md:rounded-tr-2xl flex items-center justify-center">
                        <span class="text-primary text-xs font-bold">5</span>
                    </div>
                    <i class="fas fa-chart-bar card-icon text-4xl md:text-5xl text-primary mb-4 md:mb-5"></i>
                    <p class="text-secondary font-bold text-center text-base md:text-lg leading-tight">RELATÓRIOS</p>
                </div>
            </a>
        </div>
    </main>

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

            if (window.innerWidth <= 768 && dropdownToggle && dropdownMenu) {
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

            // Card entrance animation
            const cards = document.querySelectorAll('.card-item');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('translate-y-0', 'opacity-100');
                    card.classList.remove('translate-y-4', 'opacity-0');
                }, index * 100);
            });

            // Lazy loading for images
            if ('loading' in HTMLImageElement.prototype) {
                const images = document.querySelectorAll('img[loading="lazy"]');
                images.forEach(img => {
                    img.loading = 'lazy';
                });
            }

            // Preload linked pages
            const links = document.querySelectorAll('a[target="_blank"]');
            links.forEach(link => {
                link.addEventListener('mouseover', () => {
                    const href = link.getAttribute('href');
                    if (href) {
                        fetch(href, {
                                mode: 'no-cors'
                            })
                            .catch(() => {});
                    }
                });
            });
        });
    </script>
</body>

</html>