<?php
require_once __DIR__ . '/config/auth.php';
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Sistema de Gestão de Demandas - STGM">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Sistema de Gestão de Demandas</title>
</head>

<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: {
                        DEFAULT: '#007A33',
                        '50': '#00FF6B',
                        '100': '#00EB61',
                        '200': '#00C250',
                        '300': '#00993F',
                        '400': '#00802F',
                        '500': '#007A33',
                        '600': '#00661F',
                        '700': '#00521A',
                        '800': '#003D15',
                        '900': '#002910'
                    },
                    secondary: {
                        DEFAULT: '#FFA500',
                        '50': '#FFE9C0',
                        '100': '#FFE1AB',
                        '200': '#FFD183',
                        '300': '#FFC15A',
                        '400': '#FFB232',
                        '500': '#FFA500',
                        '600': '#C78000',
                        '700': '#8F5C00',
                        '800': '#573800',
                        '900': '#1F1400'
                    },
                    dark: {
                        DEFAULT: '#1a1a1a',
                        '50': '#2d2d2d',
                        '100': '#272727',
                        '200': '#232323',
                        '300': '#1f1f1f',
                        '400': '#1a1a1a',
                        '500': '#171717',
                        '600': '#141414',
                        '700': '#111111',
                        '800': '#0e0e0e',
                        '900': '#0a0a0a'
                    }
                },
                animation: {
                    'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    'bounce-gentle': 'bounce 2s infinite',
                    'fade-in': 'fadeIn 0.5s ease-out',
                    'slide-up': 'slideUp 0.6s ease-out',
                    'scale-in': 'scaleIn 0.3s ease-out',
                    'float': 'float 6s ease-in-out infinite',
                },
                boxShadow: {
                    'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.36)',
                    'card': '0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -4px rgba(0, 0, 0, 0.2)',
                    'card-hover': '0 20px 25px -5px rgba(0, 122, 51, 0.1), 0 10px 10px -5px rgba(0, 122, 51, 0.04)',
                }
            }
        }
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: #1a1a1a;
        color: #ffffff;
        min-height: 100vh;
        background-image:
            radial-gradient(circle at 10% 20%, rgba(0, 122, 51, 0.05) 0%, rgba(0, 122, 51, 0) 20%),
            radial-gradient(circle at 90% 80%, rgba(255, 165, 0, 0.05) 0%, rgba(255, 165, 0, 0) 20%),
            linear-gradient(135deg, rgba(0, 122, 51, 0.02) 0%, rgba(255, 165, 0, 0.02) 100%);
        transition: all 0.3s ease;
    }

    /* Glass Cards */
    .glass-card {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #007A33, #00FF6B);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 122, 51, 0.15);
        border-color: rgba(0, 255, 107, 0.3);
    }

    .glass-card:hover::before {
        transform: scaleX(1);
    }

    /* Feature Cards */
    .feature-card {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 122, 51, 0.15);
        border-color: rgba(0, 255, 107, 0.3);
    }

    .feature-icon {
        background: linear-gradient(135deg, rgba(0, 122, 51, 0.1), rgba(0, 122, 51, 0.05));
        transition: all 0.4s ease;
        border-radius: 20px;
    }

    .feature-card:hover .feature-icon {
        background: linear-gradient(135deg, rgba(0, 122, 51, 0.2), rgba(0, 122, 51, 0.1));
        transform: scale(1.1) rotate(5deg);
    }

    /* Button Styles */
    .custom-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.025em;
    }

    .custom-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .custom-btn:hover::before {
        transform: translateX(100%);
    }

    .custom-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 122, 51, 0.3);
    }

    .btn-icon {
        transition: all 0.3s ease;
    }

    .custom-btn:hover .btn-icon {
        transform: translateX(3px) scale(1.1);
    }

    /* Hero Title */
    .hero-title {
        background: linear-gradient(135deg, #ffffff, #00FF6B);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

 

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .floating {
        animation: float 6s ease-in-out infinite;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .slide-up {
        animation: slideUp 0.6s ease-out forwards;
    }

    .scale-in {
        animation: scaleIn 0.3s ease-out forwards;
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #1a1a1a;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #007A33, #00FF6B);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #00FF6B, #007A33);
    }

    /* Stats Cards */
    .stats-card {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 122, 51, 0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .glass-card, .feature-card, .stats-card {
            padding: 1.5rem;
        }
    }
</style>

<body class="select-none">
    <!-- Header -->
    <header class="bg-dark-400 shadow-lg border-b border-primary-500/20 sticky top-0 z-50 backdrop-blur-lg">
        <div class="container mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-4">
            <!-- Logo e Título -->
            <div class="flex items-center gap-3">
                <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="w-10 h-10">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold bg-gradient-to-r from-primary-50 to-primary-200 bg-clip-text text-transparent">
                        Sistema de Gestão de Demandas
                    </h1>
                    <p class="text-sm text-gray-400 hidden md:block"></p>
                </div>
            </div>

            <!-- Botões de Ação e Informações do Usuário (Removidos para página inicial) -->
            <div>
              
             
         
                    <a href="./views/login.php" class="custom-btn bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm">
                        <i class="fas fa-sign-in-alt btn-icon"></i>
                        <span>Login</span>
                    </a>
                   
              
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6">
        <!-- Hero Section -->
        <section class="py-20 text-center">
            <div class="floating">
                <h2 class="hero-title text-6xl font-bold mb-6 leading-tight">
                    Gestão de Demandas
                    <span class="block">Inteligente</span>
                </h2>
            </div>
            <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
                Transforme a forma como você gerencia demandas com nossa plataforma moderna, eficiente e intuitiva
            </p>
            <a href="views/login.php" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-4 px-10 rounded-xl text-lg inline-flex items-center gap-3">
                <i class="fas fa-rocket btn-icon"></i> Começar Agora
            </a>
        </section>

        <!-- Stats Section -->

        <!-- Features Section -->
        <section class="py-16">
          
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card text-center slide-up stagger-1">
                    <div class="feature-icon w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-tasks text-3xl text-primary-50"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-white">Gestão Completa</h3>
                    <p class="text-gray-300">Controle total sobre todas as suas demandas em uma interface moderna e intuitiva</p>
                </div>

                <div class="feature-card text-center slide-up stagger-2">
                    <div class="feature-icon w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-3xl text-primary-50"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-white">Colaboração Avançada</h3>
                    <p class="text-gray-300">Trabalhe em equipe com ferramentas de colaboração em tempo real</p>
                </div>

                <div class="feature-card text-center slide-up stagger-3">
                    <div class="feature-icon w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-bar text-3xl text-primary-50"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-white">Analytics Inteligente</h3>
                    <p class="text-gray-300">Relatórios detalhados e insights para otimizar sua produtividade</p>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="py-16 mb-16">
            <div class="glass-card">
                <h2 class="text-3xl font-bold text-center mb-12 text-white">
                    Por Que Escolher Nossa Plataforma?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2 text-white">Eficiência Máxima</h3>
                            <p class="text-gray-300">Aumente sua produtividade em até 300% com automações inteligentes e fluxos otimizados</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2 text-white">Priorização Inteligente</h3>
                            <p class="text-gray-300">IA integrada para sugerir prioridades baseadas em dados reais e histórico</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2 text-white">Transparência Total</h3>
                            <p class="text-gray-300">Visibilidade completa do progresso em tempo real para toda a equipe</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2 text-white">Interface Moderna</h3>
                            <p class="text-gray-300">Design intuitivo e responsivo que facilita o uso diário</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

      
    </main>

    <!-- Footer -->
    <footer class="bg-dark-200/50 backdrop-blur-md text-gray-400 text-center py-8 border-t border-primary/20">
        <div class="container mx-auto px-6">
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestão de Demandas. Desenvolvido por Matheus Felix.</p>
        </div>
    </footer>

    <script>
        // Add hover effects to cards
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.feature-card, .stats-card, .glass-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add click animation to buttons
            document.querySelectorAll('.custom-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
