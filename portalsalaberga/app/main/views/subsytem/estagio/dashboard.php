<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A90E2">
    <meta name="description" content="Dashboard - Sistema de Gerenciamento de Estágio">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <title>Dashboard - Sistema de Estágio</title>
</head>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#007A33',
                    secondary: '#FFA500',
                    success: '#10B981',
                    danger: '#EF4444',
                    warning: '#F59E0B',
                    info: '#3B82F6'
                }
            }
        }
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    :root {
        --background-color: #f0f7ff;
        --text-color: #333333;
        --header-color: #007A33;
        --accent-color: #FFA500;
        --card-bg: rgba(255, 255, 255, 0.9);
        --sidebar-bg: #ffffff;
        --sidebar-active: rgba(0, 122, 51, 0.1);
    }

    .dark {
        --background-color: #1a1a1a;
        --text-color: #ffffff;
        --header-color: #00b348;
        --accent-color: #ffb733;
        --card-bg: rgba(45, 45, 45, 0.9);
        --sidebar-bg: #2d2d2d;
        --sidebar-active: rgba(0, 179, 72, 0.2);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: var(--background-color);
        min-height: 100vh;
        background-image: radial-gradient(circle at 10% 20%, rgba(52, 152, 219, 0.05) 0%, rgba(52, 152, 219, 0) 20%), radial-gradient(circle at 90% 80%, rgba(46, 204, 113, 0.05) 0%, rgba(46, 204, 113, 0) 20%);
        color: var(--text-color);
        transition: background-color 0.3s ease;
    }

    .sidebar {
        background-color: var(--sidebar-bg);
        border-right: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.3s ease;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
        color: var(--text-color);
    }

    .sidebar-link:hover {
        background-color: var(--sidebar-active);
        color: var(--header-color);
    }

    .sidebar-link.active {
        background-color: var(--sidebar-active);
        color: var(--header-color);
        font-weight: 600;
    }

    .dashboard-card {
        background-color: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
</style>

<body class="select-none">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="sidebar w-64 hidden md:block">
            <div class="p-4 flex flex-col h-full">
                <div class="flex items-center gap-2 mb-6">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-10 w-auto">
                    <div>
                        <h1 class="text-lg font-bold text-primary">Sistema <span class="text-secondary">STGM</span></h1>
                        <div class="h-0.5 bg-primary/20 rounded-full mt-1"></div>
                    </div>
                </div>

                <nav class="flex-1">
                    <a href="#" class="sidebar-link active">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="gerenciar_alunos.php" class="sidebar-link">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="gerenciar_empresas.php" class="sidebar-link">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="vagas.php" class="sidebar-link">
                        <i class="fas fa-briefcase w-5 mr-3"></i>
                        Vagas
                    </a>
                    <a href="relatorios.php" class="sidebar-link">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        Relatórios
                    </a>
                </nav>

                <div class="mt-auto pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Configurações
                    </a>
                    <a href="login.php" class="sidebar-link text-danger">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        Sair
                    </a>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Toggle -->
        <div class="md:hidden fixed top-4 left-4 z-50">
            <button id="sidebarToggle" class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-md">
                <i class="fas fa-bars text-primary"></i>
            </button>
        </div>

        <!-- Mobile Sidebar -->
        <div id="mobileSidebar" class="fixed inset-y-0 left-0 z-40 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden sidebar">
            <div class="p-4 flex flex-col h-full">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-10 w-auto">
                        <h1 class="text-lg font-bold text-primary">Sistema <span class="text-secondary">STGM</span></h1>
                    </div>
                    <button id="closeSidebar" class="p-2">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <nav class="flex-1">
                    <a href="#" class="sidebar-link active">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="gerenciar_alunos.php" class="sidebar-link">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="gerenciar_empresas.php" class="sidebar-link">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="vagas.php" class="sidebar-link">
                        <i class="fas fa-briefcase w-5 mr-3"></i>
                        Vagas
                    </a>
                    <a href="relatorios.php" class="sidebar-link">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        Relatórios
                    </a>
                </nav>

                <div class="mt-auto pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Configurações
                    </a>
                    <a href="login.php" class="sidebar-link text-danger">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        Sair
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-8">
            <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Dashboard</h1>
                    <p class="text-gray-600 dark:text-gray-400">Bem-vindo ao Sistema de Gerenciamento de Estágio</p>
                </div>
                
                <div class="mt-4 md:mt-0 flex items-center">
                    <div class="mr-4">
                        <button id="darkModeToggle" class="inline-flex items-center justify-center p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5 sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <svg class="w-5 h-5 moon-icon hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                            A
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Admin</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Administrador</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Alunos</h3>
                            <p class="text-3xl font-bold mt-2 text-primary">49</p>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                            <i class="fas fa-user-graduate text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Empresas</h3>
                            <p class="text-3xl font-bold mt-2 text-info">12</p>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-info/10 flex items-center justify-center text-info">
                            <i class="fas fa-building text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Vagas</h3>
                            <p class="text-3xl font-bold mt-2 text-secondary">24</p>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary">
                            <i class="fas fa-briefcase text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Estágios Ativos</h3>
                            <p class="text-3xl font-bold mt-2 text-success">18</p>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-success/10 flex items-center justify-center text-success">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Ações Rápidas -->
                <div class="dashboard-card lg:col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Ações Rápidas</h3>
                    <div class="space-y-3">
                        <a href="gerenciar_alunos.php" class="flex items-center p-3 rounded-lg hover:bg-primary/10 transition-colors">
                            <div class="h-10 w-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary mr-3">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Cadastrar Aluno</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Adicionar novo aluno ao sistema</p>
                            </div>
                        </a>
                        
                        <a href="gerenciar_empresas.php" class="flex items-center p-3 rounded-lg hover:bg-info/10 transition-colors">
                            <div class="h-10 w-10 rounded-lg bg-info/10 flex items-center justify-center text-info mr-3">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Cadastrar Empresa</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Adicionar nova empresa parceira</p>
                            </div>
                        </a>
                        
                        <a href="vagas.php" class="flex items-center p-3 rounded-lg hover:bg-secondary/10 transition-colors">
                            <div class="h-10 w-10 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary mr-3">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Cadastrar Vaga</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Adicionar nova oportunidade</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Estatísticas por Área -->
                <div class="dashboard-card lg:col-span-2">
                    <h3 class="text-lg font-semibold mb-4">Estatísticas por Área</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <h4 class="font-medium text-blue-600 dark:text-blue-400">Desenvolvimento</h4>
                            <div class="mt-2 flex justify-between items-end">
                                <p class="text-2xl font-bold">8</p>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Vagas</span>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                            <h4 class="font-medium text-purple-600 dark:text-purple-400">Design</h4>
                            <div class="mt-2 flex justify-between items-end">
                                <p class="text-2xl font-bold">5</p>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Vagas</span>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <h4 class="font-medium text-green-600 dark:text-green-400">Mídia</h4>
                            <div class="mt-2 flex justify-between items-end">
                                <p class="text-2xl font-bold">6</p>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Vagas</span>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                            <h4 class="font-medium text-orange-600 dark:text-orange-400">Redes/Suporte</h4>
                            <div class="mt-2 flex justify-between items-end">
                                <p class="text-2xl font-bold">5</p>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Vagas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar modo escuro
            const darkModeToggle = document.getElementById('darkModeToggle');
            const sunIcon = darkModeToggle.querySelector('.sun-icon');
            const moonIcon = darkModeToggle.querySelector('.moon-icon');
            
            function updateIcons(isDark) {
                if (isDark) {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                } else {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                }
            }
            
            function updateDarkMode(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.removeItem('theme');
                }
                updateIcons(isDark);
            }
            
            const savedTheme = localStorage.getItem('theme');
            const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
            
            if (savedTheme) {
                updateDarkMode(savedTheme === 'dark');
            } else {
                updateDarkMode(prefersDarkScheme.matches);
            }
            
            darkModeToggle.addEventListener('click', function() {
                const isDark = !document.documentElement.classList.contains('dark');
                updateDarkMode(isDark);
            });
            
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const closeSidebar = document.getElementById('closeSidebar');
            const mobileSidebar = document.getElementById('mobileSidebar');
            
            sidebarToggle.addEventListener('click', function() {
                mobileSidebar.classList.remove('-translate-x-full');
            });
            
            closeSidebar.addEventListener('click', function() {
                mobileSidebar.classList.add('-translate-x-full');
            });
        });
    </script>
</body>
</html> 