<?php
session_start();
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
                },
                boxShadow: {
                    'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.36)',
                    'card': '0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -4px rgba(0, 0, 0, 0.2)'
                }
            }
        }
    }
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

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
            radial-gradient(circle at 10% 20%, rgba(0, 122, 51, 0.03) 0%, rgba(0, 122, 51, 0) 20%),
            radial-gradient(circle at 90% 80%, rgba(255, 165, 0, 0.03) 0%, rgba(255, 165, 0, 0) 20%);
        transition: all 0.3s ease;
    }

    .custom-card {
        background: rgba(45, 45, 45, 0.97);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 24px rgba(0,0,0,0.18);
        border: 1.5px solid #007A3333;
        transition: box-shadow 0.3s, border 0.3s;
    }

    .custom-card:hover {
        box-shadow: 0 12px 32px rgba(0,122,51,0.18);
        border: 1.5px solid #00FF6B;
    }

    .custom-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .custom-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.5s ease;
    }

    .custom-btn:hover::before {
        transform: translateX(100%);
    }

    .btn-icon {
        transition: all 0.3s ease;
        opacity: 0.8;
    }

    .custom-btn:hover .btn-icon {
        transform: translateX(3px);
        opacity: 1;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #1a1a1a;
    }

    ::-webkit-scrollbar-thumb {
        background: #3d3d3d;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #007A33;
    }

    /* Animations */
    @keyframes scaleIn {
        0% {
            transform: translate(-50%, -50%) scale(0);
        }
        100% {
            transform: translate(-50%, -50%) scale(1);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
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
        animation: fadeIn 0.3s ease-out forwards;
    }

    .slide-up {
        animation: slideUp 0.4s ease-out forwards;
    }
</style>
<body class="select-none">
    <!-- Header -->
    <header class="bg-dark-200 shadow-lg border-b border-primary/20">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-primary-50">Sistema de Gestão de Demandas</h1>
            <a href="views/login.php" class="custom-btn bg-primary hover:bg-primary-400 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2">
                <i class="fas fa-sign-in-alt btn-icon"></i> Entrar
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12 fade-in">
            <h2 class="text-4xl font-bold text-white mb-4">Bem-vindo ao Sistema de Gestão de Demandas</h2>
            <p class="text-xl text-gray-300 mb-8">Gerencie suas demandas de forma eficiente e organizada</p>
            <a href="views/login.php" class="custom-btn bg-primary hover:bg-primary-400 text-white font-bold py-3 px-8 rounded-lg text-lg inline-flex items-center gap-2">
                <i class="fas fa-arrow-right btn-icon"></i> Acessar o Sistema
            </a>
        </div>

        <!-- Features -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="custom-card slide-up" style="animation-delay: 0.1s">
                <i class="fas fa-tasks text-4xl text-primary-50 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2 text-white">Gestão de Demandas</h3>
                <p class="text-gray-300">Crie, acompanhe e gerencie todas as suas demandas em um só lugar</p>
            </div>
            <div class="custom-card slide-up" style="animation-delay: 0.2s">
                <i class="fas fa-users text-4xl text-primary-50 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2 text-white">Colaboração</h3>
                <p class="text-gray-300">Trabalhe em equipe com atribuição de tarefas e acompanhamento</p>
            </div>
            <div class="custom-card slide-up" style="animation-delay: 0.3s">
                <i class="fas fa-chart-line text-4xl text-primary-50 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2 text-white">Acompanhamento</h3>
                <p class="text-gray-300">Monitore o progresso e mantenha tudo organizado</p>
            </div>
        </div>

        <!-- Benefits -->
        <div class="custom-card">
            <h2 class="text-2xl font-bold text-center mb-8 text-white">Benefícios do Sistema</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-primary-50 mt-1 mr-3"></i>
                    <div>
                        <h3 class="font-semibold mb-2 text-white">Organização Eficiente</h3>
                        <p class="text-gray-300">Mantenha todas as suas demandas organizadas e fáceis de encontrar</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-primary-50 mt-1 mr-3"></i>
                    <div>
                        <h3 class="font-semibold mb-2 text-white">Priorização</h3>
                        <p class="text-gray-300">Defina prioridades e foque no que é mais importante</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-primary-50 mt-1 mr-3"></i>
                    <div>
                        <h3 class="font-semibold mb-2 text-white">Comunicação Clara</h3>
                        <p class="text-gray-300">Mantenha todos informados sobre o progresso das demandas</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-primary-50 mt-1 mr-3"></i>
                    <div>
                        <h3 class="font-semibold mb-2 text-white">Controle Total</h3>
                        <p class="text-gray-300">Gerencie todas as etapas do processo de forma eficiente</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark-200 text-gray-300 mt-12 border-t border-primary/20">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center">
                <p>&copy; <?php echo date('Y'); ?> Sistema de Gestão de Demandas. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html> 