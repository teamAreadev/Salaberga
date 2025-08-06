<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Produto</title>
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

        .social-icon {
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px);
            filter: drop-shadow(0 4px 3px rgba(255, 165, 0, 0.3));
        }

        .custom-input,
        .custom-select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #005A24;
            border-radius: 0.5rem;
            font-size: 1rem;
            color: #1A3C34;
            background-color: #F8FAF9;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            text-align: center;
        }

        .custom-select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22%23005A24%22%3E%3Cpath%20d%3D%22M7%2010l5%205%205-5H7z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
            text-align: center;
            text-align-last: center;
        }

        .select-wrapper {
            margin: 0 auto;
            width: 100%;
        }

        .custom-select option {
            text-align: left;
            padding-left: 10px;
        }

        .custom-input:focus,
        .custom-select:focus {
            border-color: #FFA500;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 165, 0, 0.2);
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
                <a href="paginainicial.php" class="header-nav-link flex items-center">
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
            
                    <a href="solicitar.php" class="header-nav-link active flex items-center cursor-pointer">
                        <i class="fas fa-clipboard-list mr-2"></i>
                        <span>Solicitar</span>
                      
                    </a>
                <a href="relatorios.php" class="header-nav-link flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    <span>Relatórios</span>
                </a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 md:py-12 flex-1">
        <div class="text-center mb-10">
            <h1 class="text-primary text-3xl md:text-4xl font-bold mb-8 md:mb-6 text-center page-title tracking-tight font-heading inline-block mx-auto">SOLICITAR PRODUTO</h1>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl w-full border-2 border-primary mx-auto">
            <form action="../control/controllersolicitar.php" method="POST" class="space-y-6">
                <div class="space-y-4">
                    <div class="select-wrapper">
                        <select id="produto" name="produto" required class="custom-select" aria-label="Selecionar produto">
                            <option value="" disabled selected>SELECIONAR PRODUTO</option>
                            <?php
                            require_once('../model/functionsViews.php');
                            $select = new select();
                            $resultado = $select->selectSolicitarProdutos($barcode);
                            ?>
                        </select>
                    </div>

                    <div>
                        <input type="number" placeholder="QUANTIDADE" min="1" id="quantidade" name="quantidade" required
                            class="custom-input" aria-label="Quantidade do produto">
                    </div>

                    <div class="select-wrapper">
                        <select id="retirante" name="retirante" required class="custom-select" aria-label="Selecionar retirante">
                            <option value="" disabled selected>SELECIONAR RESPONSÁVEL</option>
                            <?php
                            require_once('../model/functionsViews.php');
                            $select = new select();
                            $resultado = $select->selectSolicitarResponsaveis($barcode);
                            ?>
                        </select>
                    </div>
                </div>

                <button type="submit" name="btn" class="w-full bg-secondary text-white font-bold py-3 px-4 rounded-lg hover:bg-opacity-90 transition-colors"
                    aria-label="Confirmar solicitação">
                    CONFIRMAR
                </button>
            </form>
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
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menu mobile toggle
            const menuButton = document.getElementById('menuButton');
            const headerNav = document.getElementById('headerNav');

            if (menuButton && headerNav) {
                menuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    headerNav.classList.toggle('show');

                    // Animação para o botão do menu
                    const spans = menuButton.querySelectorAll('span');
                    spans.forEach(span => {
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
                        const spans = menuButton.querySelectorAll('span');
                        spans.forEach(span => {
                            span.classList.remove('active');
                        });
                        document.body.style.overflow = '';
                    });
                });

                // Fechar menu ao clicar fora
                document.addEventListener('click', function(e) {
                    if (!headerNav.contains(e.target) && !menuButton.contains(e.target)) {
                        headerNav.classList.remove('show');
                        const spans = menuButton.querySelectorAll('span');
                        spans.forEach(span => {
                            span.classList.remove('active');
                        });
                        document.body.style.overflow = '';
                    }
                });

                // Fechar menu ao pressionar ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && headerNav.classList.contains('show')) {
                        headerNav.classList.remove('show');
                        const spans = menuButton.querySelectorAll('span');
                        spans.forEach(span => {
                            span.classList.remove('active');
                        });
                        document.body.style.overflow = '';
                    }
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
        });
    </script>
</body>

</html>