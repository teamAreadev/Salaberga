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
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EEEP Salaberga</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../../assets/img/Design sem nome.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <?php require_once('autenticar.php'); ?>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ceara-green': '#008C45',
                        'ceara-orange': '#FFA500',
                        'ceara-white': '#FFFFFF',
                        'accent-green': '#00A651',
                        'dark-green': '#006B35',
                        'light-orange': '#FFD54F',
                        'gradient-start': '#008C45',
                        'gradient-end': '#00A651'
                    },
                    backgroundImage: {
                        'gradient-primary': 'linear-gradient(135deg, #008C45 0%, #00A651 100%)',
                        'gradient-secondary': 'linear-gradient(135deg, #FFA500 0%, #FFD54F 100%)',
                        'gradient-dark': 'linear-gradient(135deg, #006B35 0%, #008C45 100%)',
                        'gradient-hero': 'linear-gradient(135deg, #008C45 0%, #FFA500 50%, #008C45 100%)'
                    },
                    boxShadow: {
                        'custom': '0 10px 25px -5px rgba(0, 140, 69, 0.3)',
                        'custom-orange': '0 10px 25px -5px rgba(255, 165, 0, 0.3)',
                        'glow': '0 0 20px rgba(0, 140, 69, 0.4)',
                        'inner-glow': 'inset 0 0 20px rgba(0, 140, 69, 0.1)'
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif']
                    },
                    screens: {
                        'xs': '475px',
                        // Adding a smaller breakpoint for better mobile responsiveness
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom animations and enhanced styles */
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
                box-shadow: 0 0 20px rgba(0, 140, 69, 0.4);
            }
            50% {
                box-shadow: 0 0 30px rgba(0, 140, 69, 0.6);
            }
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

        /* Enhanced input styles */
        .input-group {
            position: relative;
        }

        .input-group input {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-group input:focus {
            transform: translateY(-2px);
            outline: none;
        }

        .input-group label {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1rem;
            transition: all 0.3s ease;
            pointer-events: none;
            padding: 0 5px;
            background-color: var(--ceara-white);
            z-index: 1;
        }

        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
            top: -12px;
            left: 10px;
            font-size: 0.85rem;
            color: var(--ceara-orange);
            transform: translateY(0);
            background-color: var(--ceara-white);
            padding: 0 5px;
            font-weight: 600;
        }

        /* Enhanced button styles */
        .btn-enhanced {
            background: linear-gradient(135deg, #008C45 0%, #00A651 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
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
            box-shadow: 0 15px 35px rgba(0, 140, 69, 0.4);
        }

        /* Password strength indicator */
        .strength-bar {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
            background: linear-gradient(90deg, #ff4444 0%, #ffaa00 50%, #00aa00 100%);
        }

        /* Error message styling */
        .error-message {
            background: linear-gradient(135deg, #ff4444 0%, #cc0000 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            margin: 16px 0;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(255, 68, 68, 0.3);
            animation: fadeInUp 0.5s ease-out;
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

        /* Focus states for accessibility */
        *:focus {
            outline: 2px solid #FFA500;
            outline-offset: 2px;
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
            background: linear-gradient(135deg, #008C45 0%, #FFA500 100%);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #006B35 0%, #FF8F00 100%);
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

<body class="font-poppins bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-0 sm:p-4">
    
    <div class="main-container w-full max-w-6xl bg-white rounded-none sm:rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up">
        <div class="flex flex-col lg:flex-row min-h-[100vh] sm:min-h-[600px]">
            
            <!-- Enhanced Image Container - Hidden on small screens, visible on medium and up -->
            <div class="hidden md:block lg:flex-1 bg-gradient-hero relative overflow-hidden animate-slide-in-left">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-ceara-green/80 via-transparent to-ceara-orange/80"></div>
                
                <!-- Decorative elements -->
                <div class="absolute top-10 left-10 w-20 h-20 border-2 border-white/30 rounded-full"></div>
                <div class="absolute bottom-20 right-10 w-16 h-16 border-2 border-white/30 rounded-full"></div>
                <div class="absolute top-1/3 right-20 w-12 h-12 bg-white/20 rounded-full"></div>
                
                <div class="relative z-10 h-full flex flex-col justify-center items-center p-8 lg:p-12 text-center text-white">
                    <div class="mb-8 animate-pulse-glow">
                        <i class="fas fa-graduation-cap text-6xl lg:text-8xl mb-6 text-ceara-orange"></i>
                    </div>
                    
                    <h1 class="text-3xl lg:text-5xl font-bold mb-6 leading-tight">
                        EEEP <span class="text-ceara-orange">Salaberga</span>
                    </h1>
                    
                    <p class="text-lg lg:text-xl mb-8 max-w-md leading-relaxed opacity-90">
                        Transformando o futuro através da educação e inovação tecnológica
                    </p>
                    
                    <div class="flex space-x-4 text-sm opacity-80">
                        <div class="flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            <span>Comunidade</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-award mr-2"></i>
                            <span>Excelência</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-rocket mr-2"></i>
                            <span>Inovação</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Form Container - Full width on small screens -->
            <div class="w-full lg:flex-1 p-4 xs:p-6 sm:p-8 lg:p-12 flex flex-col justify-center animate-slide-in-right">
                
                <!-- Logo Container - Visible on all screens -->
                <div class="text-center mb-6 sm:mb-8">
                    <div class="inline-block p-3 sm:p-4  rounded-2xl ">
                        <img src="../../assets/img/Design sem nome.svg" 
                             alt="Logo EEEP Salaberga" 
                             class="w-16 h-16 sm:w-20 sm:h-20 object-contain">
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-ceara-green mb-2">
                        Bem-vindo
                    </h2>
                    <p class="text-gray-600 text-base sm:text-lg">
                        Acesse sua conta institucional
                    </p>
                </div>

                <!-- Enhanced Form -->
                <form id="loginForm" 
                      action="../../controllers/controller_login/controller_login_parcial.php" 
                      method="POST" 
                      class="space-y-4 sm:space-y-6">
                    
                    <!-- Email Input -->
                    <div class="input-group">
                        <div class="relative">
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   placeholder=" " 
                                   required
                                   class="w-full px-4 py-3 sm:py-4 pl-10 sm:pl-12 border-2 border-gray-200 rounded-xl text-gray-800 bg-gray-50 focus:bg-white focus:shadow-custom transition-all duration-300 peer text-sm sm:text-base">
                            <label for="email" 
                                   class="absolute left-10 mx-10 sm:left-12 top-3 sm:top-4 text-gray-500 transition-all duration-300 peer-focus:text-ceara-green peer-focus:text-xs sm:peer-focus:text-sm peer-focus:-translate-y--1 peer-focus:font-semibold peer-[:not(:placeholder-shown)]:text-xs sm:peer-[:not(:placeholder-shown)]:text-sm peer-[:not(:placeholder-shown)]:-translate-y-7 peer-[:not(:placeholder-shown)]:text-ceara-green peer-[:not(:placeholder-shown)]:font-semibold text-sm sm:text-base">
                                E-mail Institucional
                            </label>
                            <i class="fas fa-envelope absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-ceara-green text-base sm:text-lg"></i>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="input-group">
                        <div class="relative">
                            <input type="password" 
                                   name="senha" 
                                   id="password" 
                                   placeholder=" " 
                                   required
                                   class="w-full px-4 py-3 sm:py-4 pl-10 sm:pl-12 pr-10 sm:pr-12 border-2 border-gray-200 rounded-xl text-gray-800 bg-gray-50 focus:bg-white focus:shadow-custom transition-all duration-300 peer text-sm sm:text-base">
                            <label for="password" 
                                   class="absolute left-10 mx-10 sm:left-12 top-3 sm:top-4 text-gray-500 transition-all duration-300 peer-focus:text-ceara-green peer-focus:text-xs sm:peer-focus:text-sm peer-focus:-translate-y--1 peer-focus:font-semibold peer-[:not(:placeholder-shown)]:text-xs sm:peer-[:not(:placeholder-shown)]:text-sm peer-[:not(:placeholder-shown)]:-translate-y-7 peer-[:not(:placeholder-shown)]:text-ceara-green peer-[:not(:placeholder-shown)]:font-semibold text-sm sm:text-base">
                                Senha
                            </label>
                            <i class="fas fa-lock absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-ceara-green text-base sm:text-lg"></i>
                            <i class="fas fa-eye toggle-password absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-ceara-green cursor-pointer transition-colors duration-300 text-base sm:text-lg"></i>
                        </div>
                        
                        <!-- Password Strength Indicator -->
                        <div class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-1">
                                <div id="passwordStrength" class="strength-bar h-1 rounded-full w-0"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Fraca</span>
                                <span>Média</span>
                                <span>Forte</span>
                            </div>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <?php if (isset($_GET['login']) && $_GET['login'] == 'erro'): ?>
                        <div class="error-message flex items-center text-sm sm:text-base">
                            <i class="fas fa-exclamation-triangle mr-2 sm:mr-3"></i>
                            <span>Dados de login incorretos. Verifique suas credenciais e tente novamente.</span>
                        </div>
                    <?php endif; ?>

                    <!-- Enhanced Submit Button -->
                    <button type="submit" 
                            name="login" 
                            class="btn-enhanced w-full py-3 sm:py-4 px-4 sm:px-6 text-white font-semibold text-base sm:text-lg rounded-xl shadow-custom hover:shadow-glow transition-all duration-300 transform hover:-translate-y-1 focus:ring-4 focus:ring-ceara-green/30 mt-4 sm:mt-6">
                        <span class="flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2 sm:mr-3"></i>
                            Entrar na Plataforma
                        </span>
                    </button>
                </form>

                <!-- Additional Links -->
                <div class="mt-6 sm:mt-8 text-center space-y-3 sm:space-y-4">
                    <div class="flex flex-col xs:flex-row justify-between items-center space-y-2 xs:space-y-0">
                        <a href="./cadastro.php" 
                           class="text-ceara-green hover:text-ceara-orange transition-colors duration-300 font-medium flex items-center text-sm sm:text-base">
                            <i class="fas fa-user-plus mr-2"></i>
                            Criar conta
                        </a>
                        <a href="./recuperacaodesenha.php" 
                           class="text-ceara-green hover:text-ceara-orange transition-colors duration-300 font-medium flex items-center text-sm sm:text-base">
                            <i class="fas fa-key mr-2"></i>
                            Esqueceu sua senha?
                        </a>
                    </div>
                    
                    <div class="pt-3 sm:pt-4 border-t border-gray-200">
                        <p class="text-gray-500 text-xs sm:text-sm">
                            Precisa de ajuda? 
                            <a href="mailto:suporte@eeepsalaberga.edu.br" 
                               class="text-ceara-green hover:text-ceara-orange transition-colors duration-300 font-medium">
                                Entre em contato
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('passwordStrength');
            const submitButton = form.querySelector('button[type="submit"]');

            // Enhanced password visibility toggle
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Enhanced icon animation
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
            });

            // Enhanced password strength calculation
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
                
                // Update color based on strength
                if (strength < 40) {
                    passwordStrength.style.background = 'linear-gradient(90deg, #ff4444, #ff6666)';
                } else if (strength < 70) {
                    passwordStrength.style.background = 'linear-gradient(90deg, #ffaa00, #ffcc00)';
                } else {
                    passwordStrength.style.background = 'linear-gradient(90deg, #008C45, #00A651)';
                }
            }

            // Enhanced form submission with loading state
            form.addEventListener('submit', function(e) {
                submitButton.classList.add('loading');
                submitButton.disabled = true;
                
                // Add loading text
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<span>Entrando...</span>';
                
                // Re-enable if there's an error (form doesn't actually submit)
                setTimeout(() => {
                    if (submitButton.disabled) {
                        submitButton.classList.remove('loading');
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                    }
                }, 5000);
            });

            // Enhanced input animations
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Add ripple effect to button
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
                    background: rgba(255, 255, 255, 0.3);
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
            
            // Check for mobile devices and adjust UI accordingly
            function checkMobile() {
                const isMobile = window.innerWidth < 640;
                const elements = document.querySelectorAll('.mobile-adjust');
                
                elements.forEach(el => {
                    if (isMobile) {
                        el.classList.add('text-sm', 'py-3');
                        el.classList.remove('text-base', 'py-4');
                    } else {
                        el.classList.add('text-base', 'py-4');
                        el.classList.remove('text-sm', 'py-3');
                    }
                });
            }
            
            // Run on load and resize
            checkMobile();
            window.addEventListener('resize', checkMobile);
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