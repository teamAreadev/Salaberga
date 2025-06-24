<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o parâmetro 'sair' está presente na URL para realizar o logout
if (isset($_GET['sair']) && $_GET['sair'] === 'true') {
    // Destroi todas as variáveis de sessão
    session_unset();
    // Destroi a sessão
    session_destroy();
    // Redireciona para a página de login (sem o parâmetro sair) para evitar logout automático em refresh
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="content-language" content="pt-BR">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="theme-color" content="#7FB069">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <title>Login | EEEP Salaberga Torquato Gomes de Matos</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Acesso ao sistema da EEEP Salaberga Torquato Gomes de Matos - Hub Educacional em Maranguape">
    <meta name="author" content="EEEP Salaberga Torquato Gomes de Matos">
    <meta name="keywords" content="login, acesso, EEEP Salaberga, sistema educacional, Maranguape">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../assets/img/S.png">

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Paleta Studio Ghibli baseada na imagem
                        'ghibli-sky': '#5BA3D4',
                        'ghibli-cloud': '#F8F8F8',
                        'ghibli-building': '#8B9DC3',
                        'ghibli-accent': '#D4A574',
                        'ghibli-green': '#7FB069',
                        'ghibli-sage': '#A4C3A2',
                        'ghibli-cream': '#F7F3E9',
                        'ghibli-peach': '#F4A261',
                        'ghibli-coral': '#E76F51',
                        'ghibli-lavender': '#B19CD9',
                        'ghibli-gold': '#F1C40F',
                        'ghibli-brown': '#8B4513',
                        'ghibli-forest': '#2D5016',
                        'ghibli-mist': '#E8F4F8',
                        'ghibli-sunset': '#FF6B6B'
                    },
                    backgroundImage: {
                        'ghibli-gradient': 'linear-gradient(135deg, #7FB069 0%, #A4C3A2 100%)',
                        'ghibli-sunset': 'linear-gradient(135deg, #F4A261 0%, #E76F51 100%)',
                        'ghibli-sky-gradient': 'linear-gradient(135deg, #5BA3D4 0%, #87CEEB 100%)',
                        'ghibli-forest': 'linear-gradient(135deg, #2D5016 0%, #7FB069 100%)',
                        'hero-ghibli': 'url("https://hebbkx1anhila5yf.public.blob.vercel-storage.com/img_index3-9IdYq3BVf9Sebk6O6b0ZJtyMde0HUW.png")'
                    },
                    fontFamily: {
                        'ghibli': ['Comfortaa', 'cursive'],
                        'ghibli-text': ['Nunito', 'sans-serif']
                    },
                    boxShadow: {
                        'ghibli': '0 10px 25px -5px rgba(127, 176, 105, 0.3)',
                        'ghibli-warm': '0 10px 25px -5px rgba(244, 162, 97, 0.3)',
                        'ghibli-soft': '0 5px 15px -3px rgba(164, 195, 162, 0.2)',
                        'ghibli-cloud': '0 8px 32px rgba(248, 248, 248, 0.4)'
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'sway': 'sway 4s ease-in-out infinite',
                        'drift': 'drift 8s linear infinite',
                        'sparkle': 'sparkle 2s ease-in-out infinite',
                        'bounce-gentle': 'bounce-gentle 3s ease-in-out infinite'
                    }
                }
            }
        }
    </script>

    <style>
        /* Fonte principal */
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #F7F3E9 0%, #E8F4F8 100%);
        }

        /* Animações Studio Ghibli */
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @keyframes sway {
            0%, 100% {
                transform: translateX(0px) rotate(0deg);
            }
            50% {
                transform: translateX(10px) rotate(2deg);
            }
        }

        @keyframes drift {
            0% {
                transform: translateY(-100px) translateX(0px) rotate(0deg);
            }
            100% {
                transform: translateY(calc(100vh + 100px)) translateX(50px) rotate(360deg);
            }
        }

        @keyframes sparkle {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(127, 176, 105, 0.4);
            }
            50% {
                box-shadow: 0 0 30px rgba(127, 176, 105, 0.6);
            }
        }

        /* Elementos flutuantes */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .leaf {
            position: absolute;
            width: 20px;
            height: 20px;
            background: #7FB069;
            border-radius: 0 100% 0 100%;
            animation: drift 15s linear infinite;
            opacity: 0.6;
        }

        .leaf:nth-child(2n) {
            background: #A4C3A2;
            animation-duration: 20s;
            animation-delay: -5s;
        }

        .leaf:nth-child(3n) {
            background: #F4A261;
            animation-duration: 18s;
            animation-delay: -10s;
        }

        .ghibli-cloud {
            position: absolute;
            background: rgba(248, 248, 248, 0.9);
            border-radius: 50px;
            animation: cloud-drift 30s linear infinite;
            opacity: 0.8;
            box-shadow: 0 4px 20px rgba(248, 248, 248, 0.3);
        }

        @keyframes cloud-drift {
            0% {
                transform: translateX(-200px);
            }
            100% {
                transform: translateX(calc(100vw + 200px));
            }
        }

        .ghibli-cloud::before,
        .ghibli-cloud::after {
            content: '';
            position: absolute;
            background: rgba(248, 248, 248, 0.9);
            border-radius: 50px;
        }

        .ghibli-cloud.small {
            width: 60px;
            height: 30px;
        }

        .ghibli-cloud.small::before {
            width: 40px;
            height: 40px;
            top: -15px;
            left: 10px;
        }

        .ghibli-cloud.small::after {
            width: 30px;
            height: 30px;
            top: -10px;
            right: 10px;
        }

        /* Enhanced input styles */
        .input-group {
            position: relative;
        }

        .input-group input {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, rgba(247, 243, 233, 0.8) 0%, rgba(255, 255, 255, 0.9) 100%);
            border: 2px solid rgba(127, 176, 105, 0.3);
            backdrop-filter: blur(5px);
        }

        .input-group input:focus {
            transform: translateY(-2px);
            outline: none;
            border-color: #F4A261;
            box-shadow: 0 8px 25px rgba(244, 162, 97, 0.3);
            background: rgba(255, 255, 255, 0.95);
        }

        .input-group label {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(45, 80, 22, 0.6);
            font-size: 1rem;
            transition: all 0.3s ease;
            pointer-events: none;
            padding: 0 5px;
            background-color: transparent;
            z-index: 1;
            font-family: 'Nunito', sans-serif;
        }

        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
            top: -12px;
            left: 10px;
            font-size: 0.85rem;
            color: #E76F51;
            transform: translateY(0);
            background: linear-gradient(135deg, #F7F3E9 0%, #E8F4F8 100%);
            padding: 0 8px;
            font-weight: 600;
            border-radius: 4px;
        }

        /* Enhanced button styles */
        .btn-enhanced {
            background: linear-gradient(135deg, #7FB069 0%, #A4C3A2 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-family: 'Comfortaa', cursive;
            box-shadow: 0 8px 20px rgba(127, 176, 105, 0.3);
        }

        .btn-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-enhanced:hover::before {
            left: 100%;
        }

        .btn-enhanced:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(127, 176, 105, 0.4);
        }

        /* Password strength indicator */
        .strength-bar {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
            background: linear-gradient(90deg, #ff4444 0%, #ffaa00 50%, #7FB069 100%);
        }

        /* Error message styling */
        .error-message {
            background: linear-gradient(135deg, #E76F51 0%, #F4A261 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            margin: 16px 0;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(231, 111, 81, 0.3);
            animation: fadeInUp 0.5s ease-out;
            font-family: 'Nunito', sans-serif;
        }

        /* Loading state */
        .loading {
            position: relative;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Efeitos especiais */
        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #F1C40F;
            border-radius: 50%;
            animation: sparkle 2s ease-in-out infinite;
        }

        /* Elementos com brilho mágico */
        .magical-glow {
            box-shadow: 0 0 20px rgba(127, 176, 105, 0.4), 0 0 40px rgba(244, 162, 97, 0.2);
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.8s ease-out forwards;
        }

        .pulse-glow {
            animation: pulse-glow 2s infinite;
        }

        /* Focus styles */
        *:focus {
            outline: 2px solid #F4A261;
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #7FB069 0%, #F4A261 100%);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #2D5016 0%, #E76F51 100%);
        }
        
        /* Enhanced responsive styles */
        @media (max-width: 640px) {
            .main-container {
                width: 95%;
                margin: 1rem auto;
            }
            
            .input-group label {
                font-size: 0.9rem;
            }
            
            .btn-enhanced {
                padding: 0.75rem 1rem;
            }
        }
        
        @media (max-width: 475px) {
            .main-container {
                width: 100%;
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
            }
            
            .form-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body class="font-ghibli-text bg-gradient-to-br from-ghibli-mist via-ghibli-cloud to-ghibli-sky min-h-screen flex items-center justify-center p-0 sm:p-4">
    
    <!-- Elementos flutuantes Studio Ghibli -->
    <div class="floating-elements">
        <div class="leaf" style="top: -10%; left: 10%; animation-delay: 0s;"></div>
        <div class="leaf" style="top: -10%; left: 80%; animation-delay: -3s;"></div>
        <div class="leaf" style="top: -10%; left: 20%; animation-delay: -6s;"></div>
        <div class="leaf" style="top: -10%; left: 70%; animation-delay: -9s;"></div>
        <div class="leaf" style="top: -10%; left: 90%; animation-delay: -12s;"></div>
        <div class="leaf" style="top: -10%; left: 40%; animation-delay: -15s;"></div>
        <div class="leaf" style="top: -10%; left: 60%; animation-delay: -18s;"></div>
        <div class="leaf" style="top: -10%; left: 30%; animation-delay: -21s;"></div>

        <!-- Nuvens flutuantes -->
        <div class="ghibli-cloud small" style="top: 20%; animation-delay: 0s;"></div>
        <div class="ghibli-cloud small" style="top: 60%; animation-delay: -10s;"></div>
        <div class="ghibli-cloud small" style="top: 40%; animation-delay: -20s;"></div>
    </div>

    <div class="main-container w-full max-w-6xl bg-ghibli-cream rounded-none sm:rounded-3xl shadow-ghibli overflow-hidden animate-fade-in-up relative z-10">
        <div class="flex flex-col lg:flex-row min-h-[100vh] sm:min-h-[600px]">
            
            <!-- Enhanced Image Container com traços Ghibli -->
            <div class="hidden md:block lg:flex-1 bg-ghibli-forest relative overflow-hidden animate-slide-in-left">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-ghibli-forest/80 via-transparent to-ghibli-coral/80"></div>
                
                <!-- Elementos decorativos Ghibli -->
                <div class="absolute top-10 left-10 w-20 h-20 border-2 border-white/30 rounded-full animate-float"></div>
                <div class="absolute bottom-20 right-10 w-16 h-16 border-2 border-white/30 rounded-full animate-sway"></div>
                <div class="absolute top-1/3 right-20 w-12 h-12 bg-white/20 rounded-full animate-bounce-gentle"></div>
                
                <!-- Sparkles mágicos -->
                <div class="sparkle" style="top: 15%; left: 20%; animation-delay: 0s;"></div>
                <div class="sparkle" style="top: 70%; left: 80%; animation-delay: 1s;"></div>
                <div class="sparkle" style="top: 40%; left: 15%; animation-delay: 2s;"></div>
                <div class="sparkle" style="top: 80%; left: 30%; animation-delay: 3s;"></div>
                
                <div class="relative z-10 h-full flex flex-col justify-center items-center p-8 lg:p-12 text-center text-white">
                    <div class="mb-8 ">
                        <i class="fas fa-graduation-cap text-6xl lg:text-8xl mb-6 text-ghibli-peach "></i>
                    </div>
                    
                    <h1 class="text-3xl lg:text-5xl font-bold mb-6 leading-tight font-ghibli">
                        EEEP <span class="text-ghibli-peach">Salaberga</span>
                    </h1>
                    
                    <p class="text-lg lg:text-xl mb-8 max-w-md leading-relaxed opacity-90 font-ghibli-text">
                        Transformando o futuro através da educação e inovação tecnológica
                    </p>
                    
                    <div class="flex space-x-4 text-sm opacity-80">
                        <div class="flex items-center animate-bounce-gentle" style="animation-delay: 0.5s;">
                            <i class="fas fa-users mr-2 text-ghibli-gold"></i>
                            <span>Comunidade</span>
                        </div>
                        <div class="flex items-center animate-bounce-gentle" style="animation-delay: 1s;">
                            <i class="fas fa-award mr-2 text-ghibli-gold"></i>
                            <span>Excelência</span>
                        </div>
                        <div class="flex items-center animate-bounce-gentle" style="animation-delay: 1.5s;">
                            <i class="fas fa-rocket mr-2 text-ghibli-gold"></i>
                            <span>Inovação</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Form Container com traços Ghibli -->
            <div class="w-full lg:flex-1 p-4 xs:p-6 sm:p-8 lg:p-12 flex flex-col justify-center animate-slide-in-right relative">
                
                <!-- Sparkles no formulário -->
                <div class="sparkle" style="top: 10%; right: 10%; animation-delay: 0s;"></div>
                <div class="sparkle" style="bottom: 20%; left: 15%; animation-delay: 2s;"></div>
                
                <!-- Logo Container com efeitos Ghibli -->
                <div class="text-center mb-6 sm:mb-8">
                    <div class="inline-block p-3 sm:p-4 rounded-2xl  ">
                        <img src="../../assets/img/S.png" 
                             alt="Logo EEEP Salaberga" 
                             class="w-16 h-16 sm:w-20 sm:h-20 object-contain">
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-ghibli-forest mb-2 font-ghibli">
                        Bem-vindo
                    </h2>
                    <p class="text-ghibli-forest/70 text-base sm:text-lg font-ghibli-text">
                        Acesse sua conta institucional
                    </p>
                </div>

                <!-- Enhanced Form com traços Ghibli -->
                <form id="loginForm" 
                      action="../../controllers/controller_login/controller_login.php" 
                      method="POST" 
                      class="space-y-4 sm:space-y-6">
                    
                    <!-- Email Input com estilo Ghibli -->
                    <div class="input-group">
                        <div class="relative">
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   placeholder=" " 
                                   required
                                   class="w-full px-4 py-3 sm:py-4 pl-10 sm:pl-12 rounded-xl text-ghibli-forest focus:shadow-ghibli-soft transition-all duration-300 peer text-sm sm:text-base">
                            <label for="email" 
                                   class="absolute left-10 mx-10 sm:left-12 top-3 sm:top-4 transition-all duration-300 peer-focus:text-ghibli-coral peer-focus:text-xs sm:peer-focus:text-sm peer-focus:-translate-y--1 peer-focus:font-semibold peer-[:not(:placeholder-shown)]:text-xs sm:peer-[:not(:placeholder-shown)]:text-sm peer-[:not(:placeholder-shown)]: peer-[:not(:placeholder-shown)]:text-ghibli-coral peer-[:not(:placeholder-shown)]:font-semibold text-sm sm:text-base">
                                E-mail Institucional
                            </label>
                            <i class="fas fa-envelope absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-ghibli-green text-base sm:text-lg"></i>
                        </div>
                    </div>

                    <!-- Password Input com estilo Ghibli -->
                    <div class="input-group">
                        <div class="relative">
                            <input type="password" 
                                   name="senha" 
                                   id="password" 
                                   placeholder=" " 
                                   required
                                   class="w-full px-4 py-3 sm:py-4 pl-10 sm:pl-12 pr-10 sm:pr-12 rounded-xl text-ghibli-forest focus:shadow-ghibli-soft transition-all duration-300 peer text-sm sm:text-base">
                            <label for="password" 
                                   class="absolute left-10 mx-10 sm:left-12 top-3 sm:top-4 transition-all duration-300 peer-focus:text-ghibli-coral peer-focus:text-xs sm:peer-focus:text-sm peer-focus:-translate-y--1 peer-focus:font-semibold peer-[:not(:placeholder-shown)]:text-xs sm:peer-[:not(:placeholder-shown)]:text-sm peer-[:not(:placeholder-shown)]:-translate-y-7 peer-[:not(:placeholder-shown)]:text-ghibli-coral peer-[:not(:placeholder-shown)]:font-semibold text-sm sm:text-base">
                                Senha
                            </label>
                            <i class="fas fa-lock absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-ghibli-green text-base sm:text-lg"></i>
                            <i class="fas fa-eye toggle-password absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2 text-ghibli-forest/40 hover:text-ghibli-coral cursor-pointer transition-colors duration-300 text-base sm:text-lg"></i>
                        </div>
                        
                        <!-- Password Strength Indicator com cores Ghibli -->
                        <div class="mt-2">
                            <div class="w-full bg-ghibli-sage/20 rounded-full h-1">
                                <div id="passwordStrength" class="strength-bar h-1 rounded-full w-0"></div>
                            </div>
                            <div class="flex justify-between text-xs text-ghibli-forest/60 mt-1 font-ghibli-text">
                                <span>Fraca</span>
                                <span>Média</span>
                                <span>Forte</span>
                            </div>
                        </div>
                    </div>

                    <!-- Error Message com estilo Ghibli -->
                    <?php if (isset($_GET['login']) && $_GET['login'] == 'erro'): ?>
                        <div class="error-message flex items-center text-sm sm:text-base">
                            <i class="fas fa-exclamation-triangle mr-2 sm:mr-3"></i>
                            <span>Dados de login incorretos. Verifique suas credenciais e tente novamente.</span>
                        </div>
                    <?php endif; ?>

                    <!-- Enhanced Submit Button com traços Ghibli -->
                    <div class="mt-4 sm:mt-6">
                        <button type="submit" 
                                class="btn-enhanced w-full px-6 py-3 sm:py-4 text-white rounded-xl transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-ghibli-sage focus:ring-opacity-50 magical-glow text-sm sm:text-base font-semibold bg-gradient-to-r from-ghibli-green to-ghibli-sage hover:from-ghibli-forest hover:to-ghibli-green">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <span>Entrar</span>
                        </button>
                    </div>
                </form>

                <!-- Additional Links com estilo Ghibli -->
                <div class="mt-6 sm:mt-8 text-center space-y-3 sm:space-y-4">
                    <div class="pt-3 sm:pt-4 border-t border-ghibli-sage/20">
                        <p class="text-ghibli-forest/60 text-xs sm:text-sm font-ghibli-text">
                            <a href="../../index.php" class="text-ghibli-coral hover:text-ghibli-peach transition-colors duration-300">
                                <i class="fas fa-arrow-left mr-1"></i>Voltar ao portal
                            </a>
                            <span class="mx-2">•</span>
                            Precisa de ajuda? 
                            <a href="mailto:suporte@eeepsalaberga.edu.br" 
                               class="text-ghibli-coral hover:text-ghibli-peach transition-colors duration-300">
                                Contate o suporte
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript com efeitos Ghibli -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('passwordStrength');
            const submitButton = form.querySelector('button[type="submit"]');

            // Enhanced password visibility toggle com animação Ghibli
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Enhanced icon animation
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
                this.style.transform = 'scale(1.2) rotate(10deg)';
                setTimeout(() => {
                    this.style.transform = 'scale(1) rotate(0deg)';
                }, 200);
            });

            // Enhanced password strength calculation com cores Ghibli
            passwordInput.addEventListener('input', function() {
                const strength = calculatePasswordStrength(this.value);
                updatePasswordStrength(strength);
            });

            function calculatePasswordStrength(password) {
                if (password.length === 0) return 0;
                
                let score = 0;
                const checks = {
                    length: password.length >= 8,
                    lowercase: /[a-z]/.test(password),
                    uppercase: /[A-Z]/.test(password),
                    numbers: /\d/.test(password),
                    special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                };
                
                // Calculate score based on criteria
                Object.values(checks).forEach(check => {
                    if (check) score += 20;
                });
                
                // Bonus for length
                if (password.length >= 12) score += 10;
                if (password.length >= 16) score += 10;
                
                return Math.min(100, score);
            }

            function updatePasswordStrength(strength) {
                passwordStrength.style.width = `${strength}%`;
                
                // Update color based on strength com cores Ghibli
                if (strength < 40) {
                    passwordStrength.style.background = 'linear-gradient(90deg, #E76F51, #FF6B6B)';
                } else if (strength < 70) {
                    passwordStrength.style.background = 'linear-gradient(90deg, #F4A261, #F1C40F)';
                } else {
                    passwordStrength.style.background = 'linear-gradient(90deg, #7FB069, #A4C3A2)';
                }
            }

            // Enhanced form submission with loading state
            form.addEventListener('submit', function(e) {
                submitButton.classList.add('loading');
                submitButton.disabled = true;
                
                // Add loading text
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<span><i class="fas fa-spinner fa-spin mr-2"></i>Entrando...</span>';
                
                // Re-enable if there's an error (form doesn't actually submit)
                setTimeout(() => {
                    if (submitButton.disabled) {
                        submitButton.classList.remove('loading');
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                    }
                }, 5000);
            });

            // Enhanced input animations com efeitos Ghibli
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 0 20px rgba(127, 176, 105, 0.3)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            // Add ripple effect to button com cores Ghibli
            submitButton.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(244, 162, 97, 0.4);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });

            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);

            // Auto-focus first input
            document.getElementById('email').focus();
            
            // Criar sparkles dinamicamente
            function createSparkle() {
                const sparkle = document.createElement('div');
                sparkle.className = 'sparkle';
                sparkle.style.top = Math.random() * 100 + '%';
                sparkle.style.left = Math.random() * 100 + '%';
                sparkle.style.animationDelay = Math.random() * 2 + 's';
                
                document.querySelector('.animate-slide-in-right').appendChild(sparkle);
                
                setTimeout(() => {
                    sparkle.remove();
                }, 2000);
            }

            // Criar sparkles periodicamente
            setInterval(createSparkle, 4000);
        });

        // Enhanced accessibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', function() {
            document.body.classList.remove('keyboard-navigation');
        });
        
        // Handle orientation changes on mobile
        window.addEventListener('orientationchange', function() {
            // Small delay to allow the browser to update dimensions
            setTimeout(() => {
                const vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
            }, 100);
        });
        
        // Set initial viewport height variable
        (function() {
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        })();
    </script>
</body>

</html>