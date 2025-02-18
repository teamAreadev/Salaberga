<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-language" content="pt-BR">
    <meta name="robots" content="index, follow">
    <title>EEEP Salaberga Torquato Gomes de Matos | Hub Educacional</title>
    <meta name="description"
        content="EEEP Salaberga Torquato Gomes de Matos: Hub Educacional em Maranguape.">
    <meta name="author" content="EEEP Salaberga Torquato Gomes de Matos">
    <meta name="keywords"
        content="educação profissional, ensino médio técnico, [Maranguape] educação, cursos técnicos, EEEP Salaberga Torquato">
    <meta name="keywords" content="EEEP Salaberga, Salaberga, Escola Salaberga, Salaberga Torquato">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://salaberga.com/">
    <meta property="og:title" content="EEEP Salaberga Torquato Gomes de Matos | Hub Educacional">
    <meta property="og:description"
        content="Educação profissional de qualidade em Maranguape. Preparando alunos para um futuro brilhante com ensino médio integrado ao técnico.">
    <meta property="og:image" content="https://www.seusite.com.br/imagem-da-escola.jpg">
    <meta name="geo.region" content="BR-Ceará">
    <meta name="geo.placename" content="Maranguape">
    <meta name="viewport" content="width = device-width, initial-scale = 1, maximum-scale = 1, user-scalable = no ">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../main/assets/js/timeline.js"></script>
    <script src="../main/assets/js/parallax.js"></script>
    <script src="../main/assets/js/movelbtn.js"></script>
    <script src="../main/assets/js/timeline-function.js"></script>
    <script src="../main/assets/js/tecsSEO.json"></script>
    <script src="../main/assets/js/main.js"></script>
    <link rel="stylesheet" href="../main/assets/css/timeline.css">
    <link rel="stylesheet" href="../main/assets/css/acessibility.css">
    <link rel="stylesheet" href="../main/assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="shortcut icon" href="../main/assets/img/Design sem nome.svg" type="image/x-icon">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ceara-green': '#008C45',
                        'ceara-orange': '#FFA500',
                        'ceara-white': '#FFFFFF',
                        primary: '#4CAF50',
                        secondary: '#FFB74D',
                    }
                }
            }
        }
    </script>
    <style>
        .gallery-img {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .gallery-img:hover {
            transform: scale(1.05);
        }

        #imageModal {
            transition: opacity 0.3s ease;
        }

        #modalImage {
            transition: opacity 0.3s ease;
        }

        #prevButton,
        #nextButton {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 50%;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        section {
            opacity: 0;
        }

        .hover-scale {
            transition: transform 0.3s ease-in-out;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }


        .section.lb.page-section {
            background-color: #f8f9fa;
            color: #333;
            padding: 80px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h3 {
            color: #007a33;
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 3px;
            background-color: #ffa500;
        }

        .section-title p.lead {
            color: #555;
            font-size: 20px;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto;
        }

        @media (max-width: 1200px) {
            .container {
                max-width: 960px;
            }
        }

        @media (max-width: 992px) {
            .container {
                max-width: 720px;
            }

            .section-title h3 {
                font-size: 36px;
            }

            .section-title p.lead {
                font-size: 18px;
            }
        }

        @media (max-width: 768px) {
            .container {
                max-width: 540px;
            }

            .section-title h3 {
                font-size: 32px;
            }

            .section-title p.lead {
                font-size: 16px;
            }
        }

        @media (max-width: 576px) {
            .container {
                max-width: 100%;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
        }

        .content-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            will-change: transform;
        }
    </style>

<body class="select-none" x-data="{ 
    mobileMenuOpen: false, 
    showEditalMessage: true,
    async remindLater() {
        this.showEditalMessage = false;
        
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            try {
                const registration = await navigator.serviceWorker.register('/service-worker.js');
                const permission = await Notification.requestPermission();
                
                if (permission === 'granted') {
                    const subscribeOptions = {
                        userVisibleOnly: true,
                        applicationServerKey: urlBase64ToUint8Array('YOUR_PUBLIC_VAPID_KEY')
                    };
                    
                    const subscription = await registration.pushManager.subscribe(subscribeOptions);
                    
                    // Envie a subscription para o seu servidor
                    await fetch('/api/save-subscription', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(subscription),
                    });
                    
                    // Agende a notificação no servidor
                    await fetch('/api/schedule-notification', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            subscription: subscription,
                            delay: 600000 // 10 minutos em milissegundos
                        }),
                    });
                }
            } catch (error) {
                console.error('Erro ao configurar notificações:', error);
            }
        }
    }
    }" >
    <script>
        //Adiciona um novo estado no histórico, assim o botão de voltar não vai sair da página atual
        window.history.pushState(null, '', window.location.href);

        // Escuta o evento de popstate, que é acionado quando o usuário tenta voltar
        window.onpopstate = function() {
            // Redireciona o usuário para a página desejada
            window.location.href = ''; // Substitua pelo URL da página que você deseja
        };
    </script>
  <!--x-show="showEditalMessage"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 transform translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95"
        class="fixed inset-0 flex items-center justify-center z-50 px-4 sm:px-0">-->
       
        <!-- class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-filter backdrop-blur-sm"></div>

       
        <div class="bg-white rounded-lg shadow-2xl p-6 sm:p-8 m-4 max-w-lg w-full relative z-10 border-t-4 border-ceara-green">
         
            <button @click="showEditalMessage = false" class="absolute top-4 right-4 text-gray-400 hover:text-ceara-orange transition duration-150">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="flex items-center mb-6">
                <svg class="h-10 w-10 text-ceara-green mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-800">Atenção, futuros alunos!</h2>
            </div>

            <p class="text-lg text-gray-600 mb-6">
                O edital para novos alunos 2025 está disponível. Não perca essa oportunidade de fazer parte da nossa instituição!
            </p>

        <div class="flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4">
    <button @click="remindLater()"
        class="w-full sm:w-auto px-6 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ceara-green flex items-center justify-center">
        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Lembrar depois
    </button>
    <a href="https://www.crede01.seduc.ce.gov.br/wp-content/uploads/sites/124/2024/11/EEEP-Salaberga-Torquato-Maranguape-Edital-Selecao-Alunos-2025.pdf"
        target="_blank"
        class="w-full sm:w-auto bg-gradient-to-r from-ceara-green to-primary hover:from-primary hover:to-ceara-green text-ceara-white font-medium py-2 px-6 rounded-lg transition-all duration-300 text-center inline-flex items-center justify-center group focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ceara-green shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
        <span>Acessar Edital</span>
        <svg class="w-5 h-5 ml-2 transform transition-transform duration-200 group-hover:translate-x-1"
            fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </a>
</div>
 -->
        </div>
    </div>
    <script>
        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }
    </script>
    <script type="text/javascript">
        (function(d, t) {
            var g = d.createElement(t),
                s = d.getElementsByTagName(t)[0];
            g.src = "https://cdn.pushalert.co/integrate_3e3979b887cb8c83ce2f425dde988024.js";
            s.parentNode.insertBefore(g, s);
        }(document, "script"));
    </script>
    </head>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .header-active {
            color: #FFA500 !important;
        }
    </style>
    </head>

    <header x-data="{ mobileMenuOpen: false, mobileDropdownOpen: false, init() { this.$watch('mobileMenuOpen', value => { if (value) { document.body.classList.add('overflow-hidden'); } else { document.body.classList.remove('overflow-hidden'); } }); window.addEventListener('resize', () => { if (window.innerWidth >= 1024) { this.mobileMenuOpen = false; } }); } }" class="bg-ceara-green text-ceara-white sticky top-0 z-50 shadow-md">
        <div class="container mx-auto px-4">
            <nav class="flex items-center justify-between flex-wrap py-4">
                <div class="flex items-center space-x-2">
                    <span class="text-sm"><b>Acessibilidade</b></span>
                    <button class="text-sm hover:text-ceara-orange transition duration-300 px-1" aria-label="Diminuir tamanho do texto">
                        <i class="fa-solid fa-a"></i><b>-</b>
                    </button>
                    <button class="text-sm hover:text-ceara-orange transition duration-300 px-1" aria-label="Tamanho padrão do texto">
                        <i class="fa-solid fa-a"></i>
                    </button>
                    <button class="text-sm hover:text-ceara-orange transition duration-300 px-1" aria-label="Aumentar tamanho do texto">
                        <i class="fa-solid fa-a"></i><b>+</b>
                    </button>
                    <button id="screenReaderBtn" class="text-sm hover:text-ceara-orange transition duration-300 px-1 flex items-center" aria-label="Ativar narração de tela">
                        <i class="fa-solid fa-ear-listen mr-1"></i>
                    </button>
                    <div class="theme-toggle-container">
                        <button class="theme-toggle-btn hover:text-ceara-orange transition duration-300 px-1" aria-label="Opções de visualização" aria-expanded="false">
                            <i class="fa-solid fa-circle-half-stroke" style="color: white;"></i>
                        </button>
                        <div class="theme-options" style="color: #000000;">
                            <!-- <button class="theme-option" data-theme="dark" aria-label="Alternar modo escuro">Modo Escuro</button> -->
                            <button class="theme-option" data-theme="monochrome" aria-label="Ativar monocromático">Monocromático</button>
                            <button class="theme-option" data-theme="inverted-grayscale" aria-label="Ativar escala de cinza invertida">Escala de cinza invertida</button>
                            <button class="theme-option" data-theme="inverted-color" aria-label="Ativar cor invertida">Cor invertida</button>
                            <button class="theme-option" data-theme="original" aria-label="Restaurar cores originais">Cores originais</button>
                        </div>
                    </div>
                    <!-- <button id="vlibrasButton" class="hover:text-ceara-orange transition duration-300 px-1" aria-label="VLibras">
                    <img src="../main/assets/img/libras.svg" alt="VLibras" style="border-radius: 14%; width: 24px; height: auto;" class="zoom">
                </button> -->
                </div>
                <div class="flex items-center">
                    <div class="hidden lg:flex space-x-4">
                        <a href="#home" class="text-ceara-white hover:text-ceara-orange transition duration-300 header-link">
                            <i class="fas fa-home mr-1"></i> Início
                        </a>
                        <a href="#sobre" class="text-ceara-white hover:text-ceara-orange transition duration-300 header-link">
                            <i class="fas fa-info-circle mr-1"></i> Sobre
                        </a>
                        <a href="#cursos" class="text-ceara-white hover:text-ceara-orange transition duration-300 header-link">
                            <i class="fas fa-book mr-1"></i> Cursos
                        </a>
                        <a href="#galeria" class="text-ceara-white hover:text-ceara-orange transition duration-300 header-link">
                            <i class="fas fa-newspaper mr-1"></i> Galeria
                        </a>
                        <div class="relative group">
                            <a href="#parceiros" class="text-ceara-white hover:text-ceara-orange transition duration-300 header-link">
                                <i class="fas fa-images mr-1"></i> Parceiros
                            </a>
                        </div>
                        <div class="relative" x-data="{ isOpen: false }">
                            <!-- Botão do Dropdown -->
                            <button @click="isOpen = !isOpen"
                                @click.away="isOpen = false"
                                type="button"
                                class="group flex items-center space-x-2 text-ceara-white hover:text-ceara-orange transition-all duration-300 focus:outline-none">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-school transform group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="font-medium">Entrar</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-all duration-300"
                                    :class="{ 'transform rotate-180 text-ceara-orange': isOpen }"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="isOpen"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
                                x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
                                class="absolute right-0 w-64 mt-2 origin-top-right bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50 overflow-hidden"
                                style="display: none;">

                                <!-- Cabeçalho do Dropdown -->
                                <div class="bg-gradient-to-r from-ceara-green to-ceara-orange px-4 py-3">
                                    <h3 class="text-sm font-medium text-white">Nossas Escolas</h3>
                                </div>

                                <!-- Links do Dropdown -->
                                <div class="divide-y divide-gray-100">
                                    <!-- Link Salaberga -->
                                    <a href="../main/views/autenticacao/login.php"
                                        @click="isOpen = false"
                                        class="group flex items-center px-4 py-3 hover:bg-gradient-to-r hover:from-ceara-green/5 hover:to-ceara-orange/5 transition-all duration-300">
                                        <!-- Ícone -->
                                        <div class="flex-shrink-0 mr-3">
                                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-ceara-green/10 group-hover:bg-ceara-green/20 transition-all duration-200">
                                                <i class="fas fa-school text-ceara-green duration-200"></i>
                                            </div>
                                        </div>
                                        <!-- Texto -->
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-800 group-hover:text-ceara-green transition-colors duration-200">
                                                Salaberga
                                            </p>
                                            <p class="text-xs text-gray-500">Conheça nossa escola</p>
                                        </div>
                                        <!-- Seta -->
                                        <i class="fas fa-arrow-right text-ceara-orange opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-200"></i>
                                    </a>
                                    <!--
                                    <a href="../escolas_parceiras/index.php"
                                        @click="isOpen = false"
                                        class="group flex items-center px-4 py-3 hover:bg-gradient-to-r hover:from-ceara-green/5 hover:to-ceara-orange/5 transition-all duration-300">
                                        <div class="flex-shrink-0 mr-3">
                                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-ceara-green/10 group-hover:bg-ceara-green/20 transition-all duration-200">
                                                <i class="fas fa-handshake text-ceara-green  duration-200"></i>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-800 group-hover:text-ceara-green transition-colors duration-200">
                                                Escolas Parceiras
                                            </p>
                                            <p class="text-xs text-gray-500">Conheça nossas parcerias</p>
                                        </div>
                                        -->
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="flex items-center px-3 py-2 border rounded text-ceara-orange border-ceara-orange hover:text-ceara-white hover:border-ceara-white transition duration-300" aria-label="Toggle menu" :aria-expanded="mobileMenuOpen">
                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Menu</title>
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                        </svg>
                    </button>
                </div>
        </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen"
            x-cloak
            @click.away="mobileMenuOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4"
            class="fixed inset-0 z-50 lg:hidden bg-ceara-green/95 backdrop-blur-sm">

            <!-- Container do Menu -->
            <div class="min-h-screen px-4 py-6 overflow-y-auto">
                <!-- Cabeçalho do Menu -->
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-semibold text-ceara-white">Menu</h2>
                    <button @click="mobileMenuOpen = false"
                        class="p-2 text-ceara-white hover:text-ceara-orange transition-colors duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Links do Menu -->
                <nav class="space-y-6">
                    <!-- Início -->
                    <a href="#home"
                        @click="mobileMenuOpen = false"
                        class="group flex items-center space-x-3 text-ceara-white hover:text-ceara-orange transition-all duration-300">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 group-hover:bg-white/20 transition-all duration-200">
                            <i class="fas fa-home"></i>
                        </div>
                        <span class="text-lg font-medium">Início</span>
                    </a>

                    <!-- Sobre -->
                    <a href="#sobre"
                        @click="mobileMenuOpen = false"
                        class="group flex items-center space-x-3 text-ceara-white hover:text-ceara-orange transition-all duration-300">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 group-hover:bg-white/20 transition-all duration-200">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <span class="text-lg font-medium">Sobre</span>
                    </a>

                    <!-- Cursos -->
                    <a href="#cursos"
                        @click="mobileMenuOpen = false"
                        class="group flex items-center space-x-3 text-ceara-white hover:text-ceara-orange transition-all duration-300">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 group-hover:bg-white/20 transition-all duration-200">
                            <i class="fas fa-book"></i>
                        </div>
                        <span class="text-lg font-medium">Cursos</span>
                    </a>

                    <!-- Galeria -->
                    <a href="#galeria"
                        @click="mobileMenuOpen = false"
                        class="group flex items-center space-x-3 text-ceara-white hover:text-ceara-orange transition-all duration-300">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 group-hover:bg-white/20 transition-all duration-200">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <span class="text-lg font-medium">Galeria</span>
                    </a>

                    <!-- Parceiros -->
                    <a href="#parceiros"
                        @click="mobileMenuOpen = false"
                        class="group flex items-center space-x-3 text-ceara-white hover:text-ceara-orange transition-all duration-300">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 group-hover:bg-white/20 transition-all duration-200">
                            <i class="fas fa-images"></i>
                        </div>
                        <span class="text-lg font-medium">Parceiros</span>
                    </a>

                    <!-- Dropdown Escolas -->
                    <div x-data="{ isOpen: false }" class="space-y-4">
                        <!-- Botão do Dropdown -->
                        <button @click="isOpen = !isOpen"
                            class="group flex items-center justify-between w-full text-ceara-white hover:text-ceara-orange transition-all duration-300">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 group-hover:bg-white/20 transition-all duration-200">
                                    <i class="fas fa-school"></i>
                                </div>
                                <span class="text-lg font-medium">Escolas</span>
                            </div>
                            <i class="fas fa-chevron-down transition-transform duration-300"
                                :class="{ 'transform rotate-180': isOpen }"></i>
                        </button>

                        <!-- Conteúdo do Dropdown -->
                        <div x-show="isOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-4"
                            class="pl-13 space-y-4">

                            <!-- Salaberga -->
                            <a href="../main/views/autenticacao/login.php"
                                @click="mobileMenuOpen = false"
                                class="group flex items-center space-x-3 text-ceara-white hover:text-ceara-orange transition-all duration-300">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 group-hover:bg-white/20 transition-all duration-200">
                                    <i class="fas fa-school"></i>
                                </div>
                                <div>
                                    <span class="text-lg font-medium block">Salaberga</span>
                                    <span class="text-sm text-white/70">Conheça nossa escola</span>
                                </div>
                            </a>

                            <!-- Escolas Parceiras -->
                           <!-- <a href="../escolas_parceiras/index.php"
                                @click="mobileMenuOpen = false"
                                class="group flex items-center space-x-3 text-ceara-white hover:text-ceara-orange transition-all duration-300">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 group-hover:bg-white/20 transition-all duration-200">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <div>
                                    <span class="text-lg font-medium block">Escolas Parceiras</span>
                                    <span class="text-sm text-white/70">Conheça nossas parcerias</span>
                                </div>
                            </a>
                            -->
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>


    <script>
        let isReading = false;
        let currentSection = 0;
        const synth = window.speechSynthesis;
        let utterance = null;
        let initialInstructionsGiven = false;

        function toggleScreenReader() {
            if (isReading) {
                stopReading();
            } else {
                startReading();
            }
        }

        function startReading() {
            isReading = true;
            currentSection = 0;
            readNextSection();
            updateButtonState();
            window.addEventListener('scroll', handleScroll);
            document.addEventListener('click', handleElementClick);
            document.addEventListener('focus', handleElementFocus, true);
            announceStatus('Narração ativada');
        }

        function stopReading() {
            if (synth.speaking) {
                synth.cancel();
            }
            isReading = false;
            updateButtonState();
            window.removeEventListener('scroll', handleScroll);
            document.removeEventListener('click', handleElementClick);
            document.removeEventListener('focus', handleElementFocus, true);
            announceStatus('Narração desativada');
        }

        function readNextSection() {
            const sections = document.querySelectorAll('section, article, div.section');
            if (currentSection < sections.length) {
                const textToRead = sections[currentSection].innerText;
                speakText(textToRead);
            } else {
                stopReading();
            }
        }

        function handleScroll() {
            if (!isReading) return;

            const sections = document.querySelectorAll('section, article, div.section');
            const scrollPosition = window.scrollY + window.innerHeight / 2;

            for (let i = 0; i < sections.length; i++) {
                const section = sections[i];
                const sectionTop = section.offsetTop;
                const sectionBottom = sectionTop + section.offsetHeight;

                if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                    if (i !== currentSection) {
                        currentSection = i;
                        if (synth.speaking) {
                            synth.cancel();
                        }
                        readNextSection();
                    }
                    break;
                }
            }
        }

        function scrollToSection(sectionIndex) {
            const sections = document.querySelectorAll('section, article, div.section');
            if (sections[sectionIndex]) {
                sections[sectionIndex].scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        function updateButtonState() {
            const btn = document.getElementById('screenReaderBtn');
            if (isReading) {
                btn.classList.add('text-ceara-orange');
                btn.setAttribute('aria-label', 'Desativar narração de tela');
            } else {
                btn.classList.remove('text-ceara-orange');
                btn.setAttribute('aria-label', 'Ativar narração de tela');
            }
        }

        function announceStatus(message) {
            speakText(message);
        }

     

        function handleElementClick(event) {
            if (!isReading) return;

            const element = event.target;
            const textToSpeak = getElementDescription(element);

            if (textToSpeak) {
                speakText(textToSpeak);
            }
        }

        function handleElementFocus(event) {
            if (!isReading) return;

            const element = event.target;
            const textToSpeak = getElementDescription(element);

            if (textToSpeak) {
                speakText(textToSpeak);
            }
        }

        function getElementDescription(element) {
            if (element.tagName === 'IMG') {
                return element.alt || 'Imagem sem descrição';
            } else if (element.tagName === 'A') {
                return `Link: ${element.textContent || element.href}`;
            } else if (element.tagName === 'BUTTON') {
                return `Botão: ${element.textContent || element.value || 'Sem texto'}`;
            } else if (element.tagName === 'INPUT') {
                return `Campo de entrada: ${element.placeholder || element.name || 'Sem descrição'}`;
            } else {
                return element.textContent || 'Elemento sem texto';
            }
        }

        function speakText(text) {
            if (synth.speaking) {
                synth.cancel();
            }
            utterance = new SpeechSynthesisUtterance(text);

            const voices = synth.getVoices();
            const portugueseVoice = voices.find(voice => voice.lang === 'pt-BR');
            if (portugueseVoice) {
                utterance.voice = portugueseVoice;
            }

            synth.speak(utterance);
        }

        const screenReaderBtn = document.getElementById('screenReaderBtn');
        screenReaderBtn.addEventListener('click', toggleScreenReader);

        document.addEventListener('keydown', function(event) {
            if (event.key === 'n' || event.key === 'N') {
                toggleScreenReader();
            }
        });

        window.addEventListener('load', function() {
            screenReaderBtn.focus();
            provideInitialInstructions();
        });

        if (speechSynthesis.onvoiceschanged !== undefined) {
            speechSynthesis.onvoiceschanged = function() {
                const voices = synth.getVoices();
                console.log('Vozes disponíveis:', voices);
            };
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetID = this.getAttribute('href');
                const targetElement = document.querySelector(targetID);

                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    window.scrollBy(0, -100);
                }
            });
        });
    </script>

    <main>
        <section id="home"
            class="relative bg-cover bg-center bg-no-repeat min-h-screen flex flex-col items-center justify-center fade-in overflow-hidden">
            <img src="../main/assets/img/background03.jpeg" class="absolute top-0 left-0 w-full h-full object-cover z-0" autoplay loop muted playsinline>

            </img>
            <div class="absolute inset-0 bg-black opacity-50"></div>


            <div class="container mx-auto px-4 text-center relative z-10 mt-20 md:mt-0">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-white leading-tight">EEEP Salaberga
                    Torquato<br>Gomes de Matos</h1>
                <p class="text-xl md:text-2xl mb-12 text-white">Educação de qualidade para um futuro brilhante</p>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#cursos"
                        class="bg-ceara-white text-ceara-green hover:bg-ceara-orange hover:text-ceara-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 shadow-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap mr-2"></i> Conheça nossos cursos
                    </a> <!--
                    <a href="../main/views/autenticação/precadastro.php"
                        class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-ceara-green font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 shadow-lg flex items-center justify-center">
                        <i class="fas fa-user mr-2"></i> Pré-Cadastro
                    </a>
                        -->
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 text-center pb-8">
                <a href="#sobre" class="text-white hover:text-ceara-orange transition duration-300">
                    <i class="fas fa-chevron-down text-3xl animate-bounce"></i>
                </a>
            </div>
        </section>

        <section class="section lb page-section" id="sobre">
            <div class="container">
                <div class="section-title row text-center">
                    <div class="col-md-8 offset-md-2">
                        <h3>Nossa História</h3>

                    </div>
                </div>
                <div class="timeline timeline--loaded timeline--horizontal" style="opacity: 1;">
                    <div class="timeline__wrap">
                        <div class="timeline__items"
                            style="width: 1658px; height: 682px; transform: translate3d(0px, 0px, 0px);">
                            <div class="timeline__item timeline__item--top fadeIn"
                                style="width: 207.25px; height: 341px;">
                                <div class="timeline__item__inner">
                                    <div class="timeline__content__wrap">
                                        <div class="timeline__content img-bg-01 border-2 shadow-md  p-5 rounded-xl  ">
                                            <h2 style="color:#008C45">2009</h2>
                                            <p>A escola Santa Rita se torna a primeira escola profissionalizante do município, agora chamada de EEEP Santa Rita, oferecendo cursos técnicos em Enfermagem, Informática e Meio Ambiente.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline__item timeline__item--bottom fadeIn"
                                style="width: 207.25px; height: 341px; transform: translateY(341px);">
                                <div class="timeline__item__inner">
                                    <div class="timeline__content__wrap">
                                        <div class="timeline__content img-bg-02  border-2 shadow-md  p-5 rounded-xl">
                                            <h2 style="color:#008C45">2011</h2>
                                            <p>Formamos as primeiras turmas da nossa escola. Técnicos em Enfermagem, Informática e Meio Ambiente.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline__item timeline__item--top fadeIn"
                                style="width: 207.25px; height: 341px;">
                                <div class="timeline__item__inner">
                                    <div class="timeline__content__wrap">
                                        <div class="timeline__content img-bg-03  border-2 shadow-md  p-5 rounded-xl">
                                            <h2 style="color:#008C45">2014</h2>
                                            <p>Neste ano deixamos o prédio da Eeep Santa Rita no bairro da Guabiraba para ocupar o prédio atual, passando a se chamar Eeep Salaberga Torquato Gomes de Matos.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline__item timeline__item--bottom fadeIn"
                                style="width: 207.25px; height: 341px; transform: translateY(341px);">
                                <div class="timeline__item__inner">
                                    <div class="timeline__content__wrap">
                                        <div class="timeline__content img-bg-05  border-2 shadow-md  p-4 rounded-xl">
                                            <h2 style="color:#008C45">2016</h2>
                                            <p>Os alunos José Carlos, Ana Byatriz e Gabriella Vital representaram o Brasil na 13ª Olimpíada Internacional de Geografia (IGEO) em Pequi - China, depois de concorrer com 35.000 inscritos até a final.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline__item timeline__item--top fadeIn"
                                style="width: 207.25px; height: 341px;">
                                <div class="timeline__item__inner">
                                    <div class="timeline__content__wrap">
                                        <div class="timeline__content img-bg-06  border-2 shadow-md  p-5 rounded-xl">
                                            <h2 style="color:#008C45">2019</h2>
                                            <p>Conquistamos o selo escola sustentável de organização da Secretaria Estadual de Educação com validação da Secretaria Estadual de Meio Ambiente.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="timeline__item timeline__item--bottom fadeIn"
                                style="width: 207.25px; height: 341px; transform: translateY(341px);">
                                <div class="timeline__item__inner">
                                    <div class="timeline__content__wrap">
                                        <div class="timeline__content img-bg-09  border-2 shadow-md  p-5 rounded-xl">
                                            <h2 style="color:#008C45">2021</h2>
                                            <p>Nos colocamos no seleto grupo das 100 melhores escolas públicas do país, ficando em 20º do estado. 77 das 100 melhores foram do nosso estado.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline__item timeline__item--top fadeIn"
                                style="width: 207.25px; height: 341px;">
                                <div class="timeline__item__inner">
                                    <div class="timeline__content__wrap">
                                        <div class="timeline__content img-bg-11  border-2 shadow-md  p-5 rounded-xl">
                                            <h2 style="color:#008C45">2022</h2>
                                            <p>Os alunos Kaiky Diniz e Leonardo de Sousa conquistaram vaga na final presencial da ONHB em Campinas (Unicamp).</p>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="timeline__item timeline__item--bottom fadeIn"
                                style="width: 207.25px; height: 341px; transform: translateY(341px);">
                                <div class="timeline__item__inner">
                                    <div class="timeline__content__wrap">
                                        <div class="timeline__content img-bg-14  border-2 shadow-md  p-5 rounded-xl">
                                            <h2 style="color:#008C45">2023</h2>
                                            <p>É ofertado pela primeira vez o curso técnico em Administração.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="timeline__item timeline__item--top fadeIn"
                                style="width: 207.25px; height: 341px;">
                                <div class="timeline__item__inner">
                                    <div class="timeline__content__wrap">
                                        <div class="timeline__content img-bg-16  border-2 shadow-md  p-5 rounded-xl">
                                            <h2 style="color:#008C45">2024</h2>
                                            <p>Representamos o Brasil na primeira Expociência na Costa Rica por meio do projeto das alunas Natassa Uchôa e Gabriele Ferreira. Orientadas pela professora Diva.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="timeline-nav-button timeline-nav-button--prev" disabled=""
                        style="top: 341px;">Previous</button>
                    <button class="timeline-nav-button timeline-nav-button--next" style="top: 341px;">Next</button>
                    <span class="timeline-divider" style="top: 341px;"></span>
                </div>
            </div>
        </section>

        <style>
            .timeline__content h2::after {
                display: none !important;
            }
        </style>

        <section id="cursos" class="bg-gray-100 py-12 fade-in" x-data="{ activeSlide: 0 }">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-8 text-ceara-green">Nossos Cursos</h2>
                <div class="overflow-x-auto">
                    <div class="flex space-x-6 pb-6 carousel"
                        x-init="setInterval(() => { activeSlide = (activeSlide + 1) % 5; document.querySelector('.carousel').scrollLeft += 300; if(activeSlide === 0) { document.querySelector('.carousel').scrollLeft = 0; } }, 5000)">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover-scale min-w-[300px] relative group card"
                            :class="{ 'active': activeSlide === 0 }">
                            <img src="../main/assets/img/img-logoscursos/enfermagem.jpg" alt="Curso de Enfermagem"
                                class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3
                                    class="font-bold text-xl mb-2 text-ceara-green border-b-2 border-ceara-green text-center">
                                    Enfermagem</h3>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="content-overlay">
                                        <p class="text-white text-center text-xs"> O Curso Técnico em Enfermagem tem
                                            como objetivo formar profissionais para atuarem no processo de promoção,
                                            recuperação e manutenção da saúde da comunidade sob a supervisão do
                                            enfermeiro, com os objetivos de proporcionar ao aluno o desenvolvimento de
                                            conhecimentos e habilidades para o exercício da profissão, como também
                                            inserir no mercado de trabalho profissionais
                                            qualificados e competentes para atuarem nos diversos campos de prestação de
                                            serviços de técnico em Enfermagem.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover-scale min-w-[300px] relative group card"
                            :class="{ 'active': activeSlide === 1 }">
                            <img src="../main/assets/img/img-logoscursos/informatica.jpg" alt="Curso de Informática"
                                class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3
                                    class="font-bold text-xl mb-2 text-ceara-green border-b-2 border-ceara-green text-center">
                                    Informática</h3>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="content-overlay">
                                        <p class="text-white text-center text-xs">O Curso Técnico em Informática com
                                            ênfase em
                                            Desenvolvimento Web oferece formação prática focada no mercado. Os alunos
                                            aprendem a desenvolver softwares, abrangendo modelagem, banco de dados e
                                            testes, além de disciplinas em design, robótica e gestão de startups. Essa
                                            formação diversificada amplia as oportunidades de carreira e prepara os
                                            estudantes para se destacarem na tecnologia. Venha construir seu futuro!

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover-scale min-w-[300px] relative group card"
                            :class="{ 'active': activeSlide === 2 }">
                            <img src="../main/assets/img/img-logoscursos/meio_ambiente.jpg" alt="Curso de Meio Ambiente"
                                class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3
                                    class="font-bold text-xl mb-2 text-ceara-green border-b-2 border-ceara-green text-center">
                                    Meio Ambiente</h3>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="content-overlay">
                                        <p class="text-white text-center text-xs"> O Curso Técnico em Meio Ambiente
                                            forma profissionais para a preservação, recuperação e gestão dos recursos
                                            naturais, promovendo a sustentabilidade e a conscientização ambiental. O
                                            objetivo é desenvolver conhecimentos e habilidades essenciais para enfrentar
                                            desafios na proteção do meio ambiente, preparando os alunos para atuar em
                                            consultorias, órgãos públicos e empresas, contribuindo para um futuro
                                            sustentável. </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover-scale min-w-[300px] relative group card"
                            :class="{ 'active': activeSlide === 4 }">
                            <img src="../main/assets/img/img-logoscursos/edificações.jpg" alt="Curso de Edificações"
                                class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3
                                    class="font-bold text-xl mb-2 text-ceara-green border-b-2 border-ceara-green text-center">
                                    Edificações</h3>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="content-overlay">
                                        <p class="text-white text-center text-xs"> O curso Técnico de Edificações forma
                                            profissionais para atuar na construção civil, como desenhar projetos,
                                            elaborar orçamentos, coordenar manutenção e realizar pesquisas. O técnico
                                            pode trabalhar
                                            em empresas de construção, escritórios, canteiros de obras, laboratórios ou
                                            como autônomo. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover-scale min-w-[300px] relative group card"
                            :class="{ 'active': activeSlide === 3 }">
                            <img src="../main/assets/img/img-logoscursos/adm.jpg" alt="Curso de Administração"
                                class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3
                                    class="font-bold text-xl mb-2 text-ceara-green border-b-2 border-ceara-green text-center">
                                    Administração</h3>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="content-overlay">
                                        <p class="text-white text-center text-xs">O Curso Técnico em Administração forma profissionais para a gestão de empresas em diversos setores. O objetivo
                                            é desenvolver conhecimentos e habilidades em planejamento, organização, direção e controle das atividades administrativas,
                                            preparando os alunos para enfrentar desafios no mundo corporativo e contribuir para a eficiência e competitividade das organizações.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .perspective {
                perspective: 1000px;
            }

            .card {
                transform-style: preserve-3d;
                transition: transform 0.5s ease;
            }

            .card:hover {
                transform: scale(1.05) rotateY(10deg);
            }

            .carousel {
                scroll-behavior: smooth;
            }

            .group:hover .group-hover\:opacity-100 {
                transition: all 0.3s ease-in-out;
            }



            .card {
                transition: all 0.5s ease-in-out;
            }

            .card:hover {
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
            }

            .perspective {
                perspective: 2000px;
                perspective-origin: center;
            }

            .content-overlay {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100%;
                padding: 1rem;
                overflow-y: auto;
                mask-image: linear-gradient(to bottom, black 80%, transparent 100%);
                -webkit-mask-image: linear-gradient(to bottom, black 80%, transparent 100%);
            }
        </style>

        <script>
            function smoothScroll(element, target, duration) {
                const start = element.scrollLeft;
                const change = target - start;
                const startTime = performance.now();

                function animation(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    element.scrollLeft = start + change * easeInOutQuad(progress);
                    if (progress < 1) {
                        requestAnimationFrame(animation);
                    }
                }
                requestAnimationFrame(animation);
            }

            function easeInOutQuad(t) {
                return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
            }

            document.addEventListener('DOMContentLoaded', () => {
                const carousel = document.querySelector('.carousel');
                let currentIndex = 0;
                const cardWidth = 300; // Ajustando a largura da carta
                setInterval(() => {
                    currentIndex = (currentIndex + 1) % 5;
                    smoothScroll(carousel, currentIndex * cardWidth, 1000);
                }, 5000);
            });
        </script>


        <section id="eventos" class="py-24 fade-in">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center mb-12 text-ceara-green">Próximos Eventos</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">


                    <div class="bg-white rounded-lg shadow-lg p-6 hover-scale">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-user-graduate text-3xl text-ceara-orange mr-4"></i>
                            <div>
                                <h3 class="font-bold text-xl mb-1 text-ceara-green">Processo Seletivo 2025</h3>
                                <p class="text-gray-600">29 de novembro, 2024</p>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-4">Edital para o processo seletivo do próximo ano letivo!
                        </p>
                        <a href="https://www.crede01.seduc.ce.gov.br/wp-content/uploads/sites/124/2024/11/EEEP-Salaberga-Torquato-Maranguape-Edital-Selecao-Alunos-2025.pdf" target="_blank"
                            class="inline-block bg-ceara-white text-ceara-green border border-ceara-green hover:bg-ceara-green hover:text-ceara-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                            <i class="fas fa-file-alt mr-1"></i> Ler Edital
                        </a>
                    </div>

                </div>
            </div>


        </section>




        <section id="galeria" class="py-24 fade-in">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center mb-12 text-ceara-green">Galeria de Fotos</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <img src="../main/assets/img/galeria/galeria-1.png" alt="Imagem 1"
                        class="gallery-img w-full h-64 object-cover rounded-lg shadow-lg hover-scale">
                    <img src="../main/assets/img/galeria/galeria-2.jpg" alt="Imagem 2"
                        class="gallery-img w-full h-64 object-cover rounded-lg shadow-lg hover-scale">
                    <img src="../main/assets/img/galeria/galeria-3.jpg" alt="Imagem 3"
                        class="gallery-img w-full h-64 object-cover rounded-lg shadow-lg hover-scale">
                    <img src="../main/assets/img/galeria/galeria-4.jpg" alt="Imagem 4"
                        class="gallery-img w-full h-64 object-cover rounded-lg shadow-lg hover-scale">
                    <img src="../main/assets/img/galeria/galeria-5.jpg" alt="Imagem 5"
                        class="gallery-img w-full h-64 object-cover rounded-lg shadow-lg hover-scale">
                    <img src="../main/assets/img/galeria/galeria-6.jpg" alt="Imagem 6"
                        class="gallery-img w-full h-64 object-cover rounded-lg shadow-lg hover-scale">
                    <img src="../main/assets/img/galeria/galeria-7.jpg" alt="Imagem 7"
                        class="gallery-img w-full h-64 object-cover rounded-lg shadow-lg hover-scale">
                    <img src="../main/assets/img/galeria/galeria-8.jpg" alt="Imagem 8"
                        class="gallery-img w-full h-64 object-cover rounded-lg shadow-lg hover-scale">
                </div>
            </div>
        </section>

        <div id="imageModal"
            class="fixed inset-0 bg-black bg-opacity-90 hidden items-center justify-center z-50 transition-all duration-300 ease-in-out opacity-0">
            <div class="relative max-w-4xl w-full mx-4">
                <button id="closeModal"
                    class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors duration-200 z-50">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <div class="relative">
                    <img id="modalImage" src="" alt="Imagem ampliada"
                        class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
                    <button id="prevButton"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white p-2 rounded-full transition-all duration-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>
                    <button id="nextButton"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white p-2 rounded-full transition-all duration-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                const closeButton = document.getElementById('closeModal');
                const prevButton = document.getElementById('prevButton');
                const nextButton = document.getElementById('nextButton');
                const galleryImages = document.querySelectorAll('.gallery-img');
                let currentIndex = 0;

                function openModal(index) {
                    if (modal && modalImage && galleryImages[index]) {
                        currentIndex = index;
                        updateModalImage();
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';

                        setTimeout(() => {
                            modal.classList.add('opacity-100');
                            modal.classList.remove('opacity-0');
                        }, 10);
                    }
                }

                function closeModal() {
                    if (modal) {
                        modal.classList.add('opacity-0');
                        modal.classList.remove('opacity-100');

                        setTimeout(() => {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                            document.body.style.overflow = '';
                        }, 300);
                    }
                }

                function updateModalImage() {
                    if (modalImage && galleryImages[currentIndex]) {
                        const newSrc = galleryImages[currentIndex].src;
                        const newAlt = galleryImages[currentIndex].alt;

                        modalImage.style.opacity = '0';
                        setTimeout(() => {
                            modalImage.src = newSrc;
                            modalImage.alt = newAlt;
                            modalImage.style.opacity = '1';
                        }, 200);
                    }
                }

                function nextImage() {
                    currentIndex = (currentIndex + 1) % galleryImages.length;
                    updateModalImage();
                }

                function prevImage() {
                    currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
                    updateModalImage();
                }

                galleryImages.forEach((img, index) => {
                    img.addEventListener('click', () => openModal(index));
                });

                if (closeButton) {
                    closeButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        closeModal();
                    });
                }

                if (prevButton) {
                    prevButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        prevImage();
                    });
                }

                if (nextButton) {
                    nextButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        nextImage();
                    });
                }

                modal?.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        closeModal();
                    }
                });

                document.addEventListener('keydown', (e) => {
                    if (!modal?.classList.contains('hidden')) {
                        switch (e.key) {
                            case 'Escape':
                                closeModal();
                                break;
                            case 'ArrowLeft':
                                prevImage();
                                break;
                            case 'ArrowRight':
                                nextImage();
                                break;
                        }
                    }
                });

                const style = document.createElement('style');
                style.textContent = `
                    #modalImage {
                        transition: opacity 0.3s ease-in-out;
                    }
                    
                    .modal-button {
                        opacity: 0.7;
                        transition: opacity 0.2s ease-in-out;
                    }
                    
                    .modal-button:hover {
                        opacity: 1;
                    }
                `;
                document.head.appendChild(style);
            });
        </script>


        <section id="parceiros" class="bg-white py-8 md:py-16 fade-in overflow-hidden">
            <div class="container mx-auto px-4 md:px-8">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 md:mb-12 text-ceara-green">Nossos Parceiros
                </h2>

                <div class="relative w-full overflow-hidden">
                    <div class="swiper-container parceiros-swiper w-full">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/fenix Soluções.png" alt="Fenix"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/crede1.png" alt="Crede"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/netway cursoss.png" alt="netway"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/r2_telecom.jpeg" alt="R2"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/softway_fibra.webp" alt="software fibra"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/TRE_CE.png" alt="tre"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/vp23telecomm.png" alt="vp3"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/ifce.png" alt="ifce"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/prefeitura_municial.png" alt="prefeitura"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/EUNICE WEVER HH.jpg" alt="eunice"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/anchieta.png" alt="anchieta"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/mallory.png" alt="mallory"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/inovax (2).png" alt="inovax"
                                        class="h-24 md:h-40 w-auto object-contain hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="flex items-center justify-center">
                                    <img src="../main/assets/img/logo empresas/cl_delecom.jpeg" alt="Cl-telecom"
                                        class="h-24 md:h-40 w-32 md:w-40 object-contain rounded-full hover:grayscale-0 transition-all duration-300">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Swiper('.parceiros-swiper', {
                    slidesPerView: 'auto',
                    spaceBetween: 40,
                    loop: true,
                    centeredSlides: false,
                    autoplay: {
                        delay: 2000, // Alterado de 3000 para 2000 (2 segundos)
                        disableOnInteraction: false,
                    },
                    breakpoints: {
                        320: {
                            slidesPerView: 1,
                            spaceBetween: 20
                        },
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 30
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 40
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 40
                        },
                        1280: {
                            slidesPerView: 5,
                            spaceBetween: 40
                        }
                    },
                    speed: 800,
                    effect: 'slide',
                });

                const swiperContainer = document.querySelector('.parceiros-swiper');
                if (swiperContainer) {
                    swiperContainer.addEventListener('mouseenter', function() {
                        const swiper = this.swiper;
                        swiper.autoplay.stop();
                    });
                    swiperContainer.addEventListener('mouseleave', function() {
                        const swiper = this.swiper;
                        swiper.autoplay.start();
                    });
                }
            });
        </script>

        <section id="location">
            <div class="container">
                <h2 class="localfont"><b>Localização</b></h2>
                <div class="map-container">
                    <div class="map-frame">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4727.003608944703!2d-38.67658031627441!3d-3.888242185992357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7c0aca1962c7027%3A0xe5da63c87e731b04!2sEscola%20Estadual%20de%20Educa%C3%A7%C3%A3o%20Profissional%20Salaberga%20Torquato%20Gomes%20de%20Matos!5e1!3m2!1spt-BR!2sbr!4v1728757517751!5m2!1spt-BR!2sbr"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <div class="contact-info">
                        <h3 class="informefont">Informações de Contato</h3>
                        <ul>
                            <li><i class="fas fa-map-marker-alt"></i>Av. Marta Maria Carvalho Nojoza, sn - Outra Banda,
                                Maranguape - CE</li>
                            <li><i class="fas fa-phone"></i> (85) 3101-2100</li>
                            <li><i class="fas fa-envelope"></i> eeepsalaberga@escola.ce.gov.br</li>
                        </ul>
                        <a href="https://www.google.com/maps/place/Escola+Estadual+de+Educa%C3%A7%C3%A3o+Profissional+Salaberga+Torquato+Gomes+de+Matos/@-3.888242,-38.6765803,17z/"
                            target="_blank" class="directions-button">
                            <i class="fas fa-directions"></i> Como Chegar
                        </a>
                    </div>
                </div>
            </div>
        </section>


    </main>

    <footer class="bg-gradient-to-b from-black via-[#000] to-black text-white py-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

                <div class="md:col-span-3 space-y-6">
                    <img src="https://i.postimg.cc/yx26GhLv/lavosier-nas-3.png" alt="stgm Logo"
                        class="h-12 transition-all duration-300 hover:grayscale-0" style="background-color: #000000;">
                    <p class="text-gray-400 text-sm leading-relaxed">
                        © 2024 Eeep salaberga torquato gomes de matos. Todos os direitos reservados.
                        Sistema Educacional Integrado | CNPJ: 07.954.514/0256-24 |
                        Av. Marta Maria Carvalho Nojoza, sn - Outra Banda, Maranguape - CE
                        Tel: (85) 3341-3990| E-mail:eeepsantaritama@gmail.com |
                        Horário de Atendimento: Segunda a Sexta, das 7h às 17h
                    </p>
                </div>

                <div class="md:col-span-3 space-y-4">
                    <h3 class="text-lg font-semibold text-[#FFF]">Links Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="https://www.instagram.com/eeepsalabergampe/"
                                class="text-gray-400 hover:text-[#FFA500] transition-colors duration-300">Instagram</a>
                        </li>
                        <li><a href="https://www.facebook.com/groups/salaberga/"
                                class="text-gray-400 hover:text-[#FFA500] transition-colors duration-300">Facebook</a>
                        </li>
                        <li><a href="#sobre" class="text-gray-400 hover:text-[#FFA500] transition-colors duration-300">Sobre
                                Nós</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-[#FFA500] transition-colors duration-300">Contato</a>
                        </li>
                    </ul>
                </div>

                <div class="md:col-span-3 space-y-4">
                    <h3 class="text-lg font-semibold text-[#FFF]">Desenvolvedores</h3>
                    <ul class="space-y-2">
                        <li><a href="https://www.instagram.com/otavio.ce/"
                                class="text-gray-400 hover:text-[#FFA500] transition-colors duration-300">
                                <i class="fab fa-instagram text-sm mr-2"></i>Otavio Menezes</a>
                        </li>
                        <li><a href="https://www.instagram.com/mth_fl/"
                                class="text-gray-400 hover:text-[#FFA500] transition-colors duration-300">
                                <i class="fab fa-instagram text-sm mr-2"></i>Matheus Felix</a>
                        </li>
                        <li><a href="https://www.instagram.com/lvnas._/"
                                class="text-gray-400 hover:text-[#FFA500] transition-colors duration-300">
                                <i class="fab fa-instagram text-sm mr-2"></i>Lavosier Nascimento</a>
                        </li>
                        <li><a href="https://www.instagram.com/rogercavalcantetz/"
                                class="text-gray-400 hover:text-[#FFA500] transition-colors duration-300">
                                <i class="fab fa-instagram text-sm mr-2"></i>Roger Cavalcante</a>
                        </li>
                        <li><a href="https://www.instagram.com/p_.uchoa/"
                                class="text-gray-400 hover:text-[#FFA500] transition-colors duration-300">
                                <i class="fab fa-instagram text-sm mr-2"></i>Pedro Uchôa</a>
                        </li>
                    </ul>

                    <h3 class="text-lg font-semibold text-[#FFF] mt-6">Colaboradores</h3>
                    <ul class="space-y-2">
                        <li><a href="https://www.instagram.com/_jefferson.castro/"
                                class="text-gray-400 hover:text-[#FFA500] transition-colors duration-300">
                                <i class="fab fa-instagram text-sm mr-2"></i>Jefferson Castro</a>
                        </li>
                    </ul>
                </div>

                <div class="md:col-span-3 flex flex-col items-center justify-center space-y-4">
                    <img src="https://i.postimg.cc/SsTx6bC0/Dev-2.jpg" alt="DevStgm Logo"
                        class="h-16 w-16 transition-all duration-300 filter grayscale hover:grayscale-0">
                    <p class="text-xs text-gray-400 text-center">Desenvolvido por Dev.Stgm</p>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-800 text-center">
                <p class="text-gray-400 text-sm">&copy; 2024 DevStgm. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <!-- <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
    <script>
        document.getElementById('vlibrasButton').addEventListener('click', function () {
            window.open('https://www.gov.br/governodigital/pt-br/acessibilidade-e-usuario/vlibras', '_blank');
        });

    </script> -->


    <style>
        *:focus {
            outline: none;
        }
    </style>
</body>

</html>