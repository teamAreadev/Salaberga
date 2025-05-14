<?php
require_once('../models/select_model.php');
require_once('../models/sessions.php');
$select_model = new select_model();
$session = new sessions;
$session->tempo_session();
$session->autenticar_session();

if (isset($_POST['layout'])) {
    $session->quebra_session();
}
?>
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
        background-color: rgba(45, 45, 45, 0.95);
        background-image: linear-gradient(to bottom, #2d2d2d, #222222);
        border-right: 1px solid rgba(0, 122, 51, 0.2);
        transition: all 0.3s ease;
        box-shadow: 2px 0 10px rgba(0,0,0,0.2);
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
        color: #ffffff;
    }

    .sidebar-link:hover {
        background-color: rgba(0, 122, 51, 0.2);
        color: #00C250;
        transform: translateX(5px);
    }

    .sidebar-link.active {
        background-color: rgba(0, 122, 51, 0.3);
        color: #00FF6B;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 122, 51, 0.15);
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
                        <h1 class="text-lg font-bold text-primary-400">Sistema <span class="text-secondary">STGM</span></h1>
                        <div class="h-0.5 bg-primary-500/20 rounded-full mt-1"></div>
                    </div>
                </div>
                <nav class="flex-1">
                    <a href="dashboard.php" class="sidebar-link active">
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
                    <a href="selecionados.php" class="sidebar-link">
                        <i class="fas fa-check-circle w-5 mr-3"></i>
                        Selecionados
                    </a>
                </nav>
                <div class="mt-auto pt-4 border-t border-gray-700">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Configurações
                    </a>
                    <form action="" method="post">
                        <button type="submit" name="layout" class="sidebar-link text-red-400 hover:text-red-300">
                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Toggle -->
        <div class="md:hidden fixed top-4 left-4 z-50">
            <button id="sidebarToggle" class="bg-dark-50 p-2 rounded-lg shadow-md hover:bg-dark-100 transition-all">
                <i class="fas fa-bars text-primary-400"></i>
            </button>
        </div>

        <!-- Mobile Sidebar -->
        <div id="mobileSidebar" class="fixed inset-y-0 left-0 z-40 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden sidebar">
            <div class="p-4 flex flex-col h-full">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-10 w-auto">
                        <h1 class="text-lg font-bold text-primary-400">Sistema <span class="text-secondary">STGM</span></h1>
                    </div>
                    <button id="closeSidebar" class="p-2 text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="flex-1">
                    <a href="dashboard.php" class="sidebar-link active">
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
                    <a href="selecionados.php" class="sidebar-link">
                        <i class="fas fa-check-circle w-5 mr-3"></i>
                        Selecionados
                    </a>
                </nav>
                <div class="mt-auto pt-4 border-t border-gray-700">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Configurações
                    </a>
                    <form action="" method="post">
                        <button type="submit" name="layout" class="sidebar-link text-red-400 hover:text-red-300">
                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                            Sair
                        </button>
                    </form>
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
                            <p class="text-3xl font-bold mt-2 text-primary"><?php 
                            echo $dados = $select_model->total_alunos();
                            ?></p>
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
                            <?php
                            $dados = $select_model->total_empresa();
                            foreach ($dados as $dado) {

                            ?>
                                <p class="text-3xl font-bold mt-2 text-info"><?= $dado ?></p>
                            <?php } ?>
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
                            <?php
                            $dados = $select_model->total_vagas();
                            foreach ($dados as $dado) {
                            ?>
                                <p class="text-3xl font-bold mt-2 text-secondary"><?= $dado ?? 0 ?></p>
                            <?php
                            }
                            ?>
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
                            <?php
                            $dados = $select_model->estagios_ativas();

                            foreach ($dados as $dado) {
                            ?>
                                <p class="text-3xl font-bold mt-2 text-success"><?=$dado ?? 0?></p>
                            <?php } ?>
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
                                <?php
                                $dados = $select_model->total_vagas_dev();
                                foreach ($dados as $dado) {
                                ?>
                                    <p class="text-2xl font-bold"><?= $dado ?? 0 ?></p>
                                <?php } ?>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Vagas</span>
                            </div>
                        </div>

                        <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                            <h4 class="font-medium text-purple-600 dark:text-purple-400">Design</h4>
                            <div class="mt-2 flex justify-between items-end">
                                <?php
                                $dados = $select_model->total_vagas_sup();
                                foreach ($dados as $dado) {
                                ?>
                                    <p class="text-2xl font-bold"><?= $dado ?? 0 ?></p>
                                <?php } ?>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Vagas</span>
                            </div>
                        </div>

                        <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <h4 class="font-medium text-green-600 dark:text-green-400">Mídia</h4>
                            <div class="mt-2 flex justify-between items-end">
                                <?php
                                $dados = $select_model->total_vagas_des();
                                if ($dados == 0) {
                                } else {


                                    foreach ($dados as $dado) {
                                ?>
                                        <p class="text-2xl font-bold"><?= $dado ?? 0 ?></p>
                                <?php }
                                } ?>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Vagas</span>
                            </div>
                        </div>

                        <div class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                            <h4 class="font-medium text-orange-600 dark:text-orange-400">Redes/Suporte</h4>
                            <div class="mt-2 flex justify-between items-end">
                                <?php
                                $dados = $select_model->total_vagas_tut();
                                foreach ($dados as $dado) {
                                ?>
                                    <p class="text-2xl font-bold"><?= $dado ?? 0 ?></p>
                                <?php } ?>
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


            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const closeSidebar = document.getElementById('closeSidebar');
            const mobileSidebar = document.getElementById('mobileSidebar');

            sidebarToggle.addEventListener('click', () => {
                mobileSidebar.classList.remove('-translate-x-full');
                document.body.style.overflow = 'hidden';
            });

            closeSidebar.addEventListener('click', () => {
                mobileSidebar.classList.add('-translate-x-full');
                document.body.style.overflow = 'auto';
            });

            mobileSidebar.addEventListener('click', (e) => {
                if (e.target === mobileSidebar) {
                    mobileSidebar.classList.add('-translate-x-full');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
</body>

</html>