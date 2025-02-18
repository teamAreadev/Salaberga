<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Escolas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="../main/assets/img/Design sem nome.svg" type="image/x-icon">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ceara-green': {
                            DEFAULT: '#008C45',
                            'light': '#00A050',
                            'dark': '#006633'
                        },
                        'ceara-orange': {
                            DEFAULT: '#FFA500',
                            'light': '#FFB733'
                        }
                    },
                    boxShadow: {
                        'card-hover': '0 25px 50px -12px rgba(0, 140, 69, 0.25)',
                        'input': '0 0 0 4px rgba(0, 140, 69, 0.15)'
                    },
                    borderRadius: {
                        'xl': '1rem',
                        '4xl': '2.5rem'
                    },
                    animation: {
                        'spin': 'spin 1s linear infinite',
                    },
                    keyframes: {
                        spin: {
                            '0%': {
                                transform: 'rotate(0deg)'
                            },
                            '100%': {
                                transform: 'rotate(360deg)'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .scroll-smooth {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
        }

        .scroll-smooth::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari and Opera */
        }

        /* Estilos para os cards */
        .shadow-card-hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .school-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .school-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        /* Adicione estes estilos para melhorar a experiência de rolagem */
        @media (max-width: 768px) {
            .snap-center {
                scroll-snap-align: center;
            }

            .snap-x {
                scroll-snap-type: x mandatory;
            }
        }

        .gradient-bg {
            background: linear-gradient(135deg, #008C45 0%, #006633 100%);
        }

        /* Estilos do Modal */
        .modal {
            display: none;
            opacity: 0;
            visibility: hidden;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transition: all 0.3s ease-in-out;

            /* Adicione estas propriedades para centralização */
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            transform: scale(0.7);
            opacity: 0;
            transition: all 0.3s ease-in-out;
            /* Remova margens automáticas se houver */
            margin: 0;
            /* Adicione uma largura máxima para garantir responsividade */
            width: 100%;
            max-width: 500px;
            /* Adicione um padding nas laterais para telas menores */
            padding: 0 1rem;
        }

        .modal.active .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        /* Adicione uma animação suave de entrada */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.7);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal.active .modal-content {
            animation: modalFadeIn 0.3s ease-out forwards;
        }

        /* Adicione um efeito de glass morphism (opcional) */
        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .modal.active .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        /* Animação de shake para erro de validação */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.6s cubic-bezier(.36, .07, .19, .97) both;
        }
    </style>
</head>


<body class="bg-gray-50 min-h-screen">
    <script>
        //Adiciona um novo estado no histórico, assim o botão de voltar não vai sair da página atual
        window.history.pushState(null, '', window.location.href);

        // Escuta o evento de popstate, que é acionado quando o usuário tenta voltar
        window.onpopstate = function() {
            // Redireciona o usuário para a página desejada
            window.location.href = ''; // Substitua pelo URL da página que você deseja
        };
    </script>
    <!-- Modal de Login -->
    <!-- Modal de Login -->
    <div id="loginModal" class="modal">
        <div class="modal-content bg-white rounded-2xl shadow-2xl">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Bem-vindo de volta!</h2>
                <button onclick="closeModal()" class="p-2 hover:bg-gray-100 rounded-full transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6">
                <form id="loginForm" action="controller.php" method="post" class="space-y-6">

                    <input type="hidden" id="schoolName" name="escola" value="">

                    <!-- Email/Nome Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input type="text" id="email" name="email"
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200"
                                placeholder="Digite seu email" required>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Senha
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input type="password" id="password" name="senha"
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200"
                                placeholder="Digite sua senha" required>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember"
                                class="w-4 h-4 text-ceara-green border-gray-300 rounded focus:ring-ceara-green transition-colors duration-200">
                            <label for="remember" class="ml-2 text-sm text-gray-600">
                                Lembrar-me
                            </label>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        <button type="button" onclick="closeModal()"
                            class="flex-1 px-4 py-3 text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 text-white bg-ceara-green rounded-xl hover:bg-ceara-green-dark transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center">
                                <span>Entrar</span>
                            </span>
                        </button>
                    </div>
                    <?php if (isset($_GET['erro'])) { ?>

                        <p>Nome ou senha incorretos!</p>
                    <?php } ?>
                </form>
            </div>

            <!-- Footer -->

        </div>
    </div>

    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16 mb-10 relative overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('path/to/your/background-image.jpg'); opacity: 0.2;"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-5xl font-bold mb-4" data-aos="fade-down">Portal das Escolas</h1>
            <p class="text-xl opacity-90 max-w-2xl mx-auto mb-6" data-aos="fade-up" data-aos-delay="200">
                Acesse o sistema da sua escola de forma rápida e simples
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Barra de Busca Melhorada -->
        <div class="max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <div class="relative group">
                <input type="text"
                    id="search-input"
                    placeholder="Encontre sua escola..."
                    class="w-full px-10 py-6 rounded-4xl border-2 border-gray-200 focus:border-ceara-green focus:ring-0 outline-none transition-all duration-300 text-lg placeholder:text-gray-500 shadow-lg"
                    oninput="filterCards()">
                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-ceara-green text-white p-4 rounded-full cursor-pointer hover:bg-ceara-orange transition-colors duration-300">
                    <i class="fas fa-search text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Cards Container com Scroll Suave -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 justify-items-center max-w-8xl mx-auto">

            <!-- Card 1 - EEEP Gonzaga Mota -->
            <div class="w-full max-w-[350px]">
                <div class="school-card bg-white rounded-4xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:shadow-card-hover hover:-translate-y-2 h-[600px]" data-aos="fade-up" data-name="EEEP Gonzaga Mota">
                    <div class="relative h-48 bg-gradient-to-r from-ceara-green-light to-ceara-orange-light">
                        <div class="absolute inset-0 opacity-80"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-school text-6xl text-white"></i>
                        </div>
                    </div>
                    <div class="p-8 text-center h-[calc(600px-12rem)]">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-3">EEEP Maria Carmem </h2>
                        <p class="flex items-center justify-center text-gray-600 mb-6">
                            <i class="fas fa-map-marker-alt mr-2 text-ceara-orange"></i>
                            Maracanaú, CE
                        </p>
                        <div class="flex flex-wrap justify-center gap-3 mb-8">
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 flex items-center">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Ensino Médio Profissional
                            </span>
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                Período Integral
                            </span>
                        </div>
                        <div class="space-y-4">
                            <button onclick="openModal(1)" class="block w-full bg-ceara-green hover:bg-ceara-green-dark text-white font-semibold py-4 rounded-2xl transition-all duration-300 transform hover:-translate-y-1">
                                Acessar Sistema
                            </button>
                            <a href="#" class="block w-full text-ceara-green border-2 border-ceara-green hover:bg-ceara-green/5 font-semibold py-4 rounded-2xl transition-all duration-300">
                                Mais Informações
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 - EEEP Luiza de Teodoro -->
            <div class="w-full max-w-[350px]">
                <div class="school-card bg-white rounded-4xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:shadow-card-hover hover:-translate-y-2 h-[600px]" data-aos="fade-up" data-name="EEEP Luiza de Teodoro">
                    <div class="relative h-48 bg-gradient-to-r from-ceara-green-light to-ceara-orange-light">
                        <div class="absolute inset-0 opacity-80"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-school text-6xl text-white"></i>
                        </div>
                    </div>
                    <div class="p-8 text-center h-[calc(600px-12rem)]">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-3">EEEP Luiza de Teodoro</h2>
                        <p class="flex items-center justify-center text-gray-600 mb-6">
                            <i class="fas fa-map-marker-alt mr-2 text-ceara-orange"></i>
                            Pacatuba, CE
                        </p>
                        <div class="flex flex-wrap justify-center gap-3 mb-8">
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 flex items-center">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Ensino Médio Profissional
                            </span>
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                Período Integral
                            </span>
                        </div>
                        <div class="space-y-4">
                            <button onclick="openModal(2)" class="block w-full bg-ceara-green hover:bg-ceara-green-dark text-white font-semibold py-4 rounded-2xl transition-all duration-300 transform hover:-translate-y-1">
                                Acessar Sistema
                            </button>
                            <a href="#" class="block w-full text-ceara-green border-2 border-ceara-green hover:bg-ceara-green/5 font-semibold py-4 rounded-2xl transition-all duration-300">
                                Mais Informações
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 - EEEP Antônio Valmir -->
            <div class="w-full max-w-[350px]">
                <div class="school-card bg-white rounded-4xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:shadow-card-hover hover:-translate-y-2 h-[600px]" data-aos="fade-up" data-name="EEEP Antônio Valmir">
                    <div class="relative h-48 bg-gradient-to-r from-ceara-green-light to-ceara-orange-light">
                        <div class="absolute inset-0 opacity-80"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-school text-6xl text-white"></i>
                        </div>
                    </div>
                    <div class="p-8 text-center h-[calc(600px-12rem)]">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-3">EEEP Antônio Valmir</h2>
                        <p class="flex items-center justify-center text-gray-600 mb-6">
                            <i class="fas fa-map-marker-alt mr-2 text-ceara-orange"></i>
                            Caucaia, CE
                        </p>
                        <div class="flex flex-wrap justify-center gap-3 mb-8">
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 flex items-center">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Ensino Médio Profissional
                            </span>
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                Período Integral
                            </span>
                        </div>
                        <div class="space-y-4">
                            <button onclick="openModal(3)" class="block w-full bg-ceara-green hover:bg-ceara-green-dark text-white font-semibold py-4 rounded-2xl transition-all duration-300 transform hover:-translate-y-1">
                                Acessar Sistema
                            </button>
                            <a href="#" class="block w-full text-ceara-green border-2 border-ceara-green hover:bg-ceara-green/5 font-semibold py-4 rounded-2xl transition-all duration-300">
                                Mais Informações
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-[350px]">
                <div class="school-card bg-white rounded-4xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:shadow-card-hover hover:-translate-y-2 h-[600px]" data-aos="fade-up" data-name="EEEP Antônio Valmir">
                    <div class="relative h-48 bg-gradient-to-r from-ceara-green-light to-ceara-orange-light">
                        <div class="absolute inset-0 opacity-80"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-school text-6xl text-white"></i>
                        </div>
                    </div>
                    <div class="p-8 text-center h-[calc(600px-12rem)]">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-3">EEEP Prof. Fco. Aristóles </h2>
                        <p class="flex items-center justify-center text-gray-600 mb-6">
                            <i class="fas fa-map-marker-alt mr-2 text-ceara-orange"></i>
                            Itaitinga, CE
                        </p>
                        <div class="flex flex-wrap justify-center gap-3 mb-8">
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 flex items-center">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Ensino Médio Profissional
                            </span>
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                Período Integral
                            </span>
                        </div>
                        <div class="space-y-4">
                            <button onclick="openModal(4)" class="block w-full bg-ceara-green hover:bg-ceara-green-dark text-white font-semibold py-4 rounded-2xl transition-all duration-300 transform hover:-translate-y-1">
                                Acessar Sistema
                            </button>
                            <a href="#" class="block w-full text-ceara-green border-2 border-ceara-green hover:bg-ceara-green/5 font-semibold py-4 rounded-2xl transition-all duration-300">
                                Mais Informações
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-white font-sans w-full mt-auto py-4" style="background-color: #008C45">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Identificação Institucional -->
                <div class="p-2">
                    <h4 class="text-ceara-orange text-lg font-bold mb-3">SEEPS</h4>
                    <p class="text-sm mb-3">Sistema de Ensino e Educação Profissional Salaberga</p>
                    <div class="flex gap-3">
                        <a aria-label="Facebook" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/groups/salaberga/"
                            class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-ceara-orange transition-all">
                            <i class="fab fa-facebook text-sm"></i>
                        </a>
                        <a aria-label="Instagram" target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/eeepsalabergampe/"
                            class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-ceara-orange transition-all">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Contato -->
                <div class="p-2">
                    <h4 class="text-ceara-orange text-lg font-bold mb-3">CONTATO</h4>
                    <div class="space-y-2 text-sm">
                        <a class="flex items-center hover:text-ceara-orange transition-colors">
                            <i class="fas fa-envelope mr-2"></i>
                            eeepsantaritama@gmail.com
                        </a>
                        <a href="tel:+558531012100" class="flex items-center hover:text-ceara-orange transition-colors">
                            <i class="fas fa-phone-alt mr-2"></i>
                            (85) 3101-2100
                        </a>
                    </div>
                </div>

                <!-- Desenvolvedores -->
                <div class="p-2">
                    <h4 class="text-ceara-orange text-lg font-bold mb-3">DESENVOLVEDORES</h4>
                    <div class="flex gap-4">
                        <ul class="space-y-2">
                            <li>
                                <a href="https://www.instagram.com/otavio.ce/" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center text-sm hover:text-ceara-orange transition-colors">
                                    <i class="fab fa-instagram text-ceara-orange mr-2"></i>
                                    Otavio Menezes
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/matheus-felix-74489329a/" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center text-sm hover:text-ceara-orange transition-colors">
                                    <i class="fab fa-linkedin text-ceara-orange mr-2"></i>
                                    Matheus Felix
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/lavosier-nascimento-4b124a2b8/" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center text-sm hover:text-ceara-orange transition-colors">
                                    <i class="fab fa-linkedin text-ceara-orange mr-2"></i>
                                    Lavosier Nascimento
                                </a>
                            </li>
                        </ul>
                        <ul class="space-y-2">
                            <li>
                                <a href="https://www.linkedin.com/in/roger-cavalcante/" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center text-sm hover:text-ceara-orange transition-colors">
                                    <i class="fab fa-linkedin text-ceara-orange mr-2"></i>
                                    Roger Cavalcante
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/pedro-uch%C3%B4a-de-abreu-67723429a/" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center text-sm hover:text-ceara-orange transition-colors">
                                    <i class="fab fa-linkedin text-ceara-orange mr-2"></i>
                                    Pedro Uchôa
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 pt-3 text-center text-xs">
                <p>&copy; 2024 SEEPS - Todos os direitos reservados</p>
            </div>
        </div>
    </footer>

    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
        });

        function filterCards() {
            const input = document.getElementById("search-input");
            const filter = input.value.toLowerCase();
            const cards = document.querySelectorAll(".school-card");

            cards.forEach(card => {
                const cardName = card.getAttribute("data-name").toLowerCase();
                if (cardName.includes(filter)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        }

        function openModal(schoolName) {
            const modal = document.getElementById("loginModal");
            document.getElementById("schoolName").value = schoolName;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }


        function closeModal() {
            const modal = document.getElementById("loginModal");
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Validação do formulário
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                const form = document.getElementById('loginForm');
                form.classList.add('shake');
                setTimeout(() => form.classList.remove('shake'), 600);
                return;
            }

            // Aqui você pode adicionar sua lógica de autenticação
            this.submit();
        });

        // Fechar modal ao pressionar ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Fechar modal ao clicar fora
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Loading state para o botão de login
        document.getElementById('loginForm').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Entrando...
            `;
        });
    </script>
</body>

</html>