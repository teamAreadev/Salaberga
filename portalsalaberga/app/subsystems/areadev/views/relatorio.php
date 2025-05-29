<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../model/Demanda.php';
require_once __DIR__ . '/../model/Usuario.php';

// Verificar se é admin
verificarAdmin();

// Inicializa a conexão com o banco de dados
$database = new Database();
$pdo = $database->getConnection();

$demanda = new Demanda($pdo);
$usuario = new Usuario($pdo);

// Buscar estatísticas gerais
$totalDemandas = $demanda->listarDemandas();
$demandasEmEspera = 0;
$demandasEmAndamento = 0;
$demandasConcluidas = 0;
$demandasCanceladas = 0;

foreach ($totalDemandas as $d) {
    if ($d['status'] === 'pendente') {
        $demandasEmEspera++;
    } elseif ($d['status'] === 'em_andamento') {
        $demandasEmAndamento++;
    } elseif ($d['status'] === 'concluida') {
        $demandasConcluidas++;
    } elseif ($d['status'] === 'cancelada') {
        $demandasCanceladas++;
    }
}

$totalDeDemandas = count($totalDemandas);
$totalDeUsuarios = count($usuario->listarUsuarios()); // Buscar total de usuários

// Buscar estatísticas por usuário
$usuarios = $usuario->listarUsuarios();
$estatisticasUsuarios = [];

foreach ($usuarios as $user) {
    $demandasUsuario = $demanda->listarDemandasPorUsuario($user['id']);
    $concluidas = 0;
    $pendentes = 0;
    
    foreach ($demandasUsuario as $d) {
        if (isset($d['status_usuario']) && $d['status_usuario'] === 'concluido') {
            $concluidas++;
        } elseif (isset($d['status_usuario']) && $d['status_usuario'] === 'pendente') {
            $pendentes++;
        }
    }
    
    $estatisticasUsuarios[] = [
        'nome' => $user['nome'],
        'concluidas' => $concluidas,
        'pendentes' => $pendentes
    ];
}

?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Página de Relatórios - Sistema de Gestão de Demandas">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Relatórios - Sistema de Gestão de Demandas</title>
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
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .btn-icon {
        transition: all 0.3s ease;
    }

    .custom-btn:hover .btn-icon {
        transform: translateX(3px) scale(1.1);
    }

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
</style>

<body class="select-none">
    <!-- Header -->
<!-- Header -->
<header class="bg-dark-400 shadow-lg border-b border-primary-500/20 sticky top-0 z-50 backdrop-blur-lg">
    <div class="container mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-4">
        <!-- Logo e Título -->
        <div class="flex items-center gap-3">
            <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="w-10 h-10">
            <div>
                <h1 class="text-xl md:text-2xl font-bold bg-gradient-to-r from-primary-50 to-primary-200 bg-clip-text text-transparent">
                    Relatórios
                </h1>
                <p class="text-sm text-gray-400 hidden md:block">Sistema de Gestão de Demandas</p>
            </div>
        </div>

        <!-- Botões e Informações do Usuário -->
        <div class="flex items-center gap-4 flex-wrap">
            <!-- Informações do Usuário -->
            <div class="flex items-center gap-2 text-gray-300">
                <i class="fas fa-user-shield text-primary-50"></i>
                <span class="text-sm"><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?> (Admin)</span>
            </div>

            <!-- Botões de Ação -->
            <div class="flex items-center gap-2 flex-wrap">
                <a href="admin.php" class="custom-btn bg-dark-300 hover:bg-dark-200 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm">
                    <i class="fas fa-arrow-left btn-icon"></i>
                    <span>Voltar</span>
                </a>
                <a href="relatorio/relatorio_estatisticas_fpdf.php" target="_blank" class="custom-btn bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm">
                    <i class="fas fa-chart-line btn-icon"></i>
                    <span>Estatísticas</span>
                </a>
                <a href="relatorio/relatorio_fpdf.php" target="_blank" class="custom-btn bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm">
                    <i class="fas fa-file-pdf btn-icon"></i>
                    <span>Relatório PDF</span>
                </a>
                <a href="logout.php" class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm">
                    <i class="fas fa-sign-out-alt btn-icon"></i>
                    <span>Sair</span>
                </a>
            </div>
        </div>
    </div>
</header>

    <main class="container mx-auto px-4 py-8">
        <!-- Estatísticas Gerais com Gráfico -->
        <div class="bg-dark-200 rounded-xl p-6 shadow-lg border border-primary/20 mb-8">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                <i class="fas fa-chart-pie text-primary-50"></i>
                Estatísticas da Equipe
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Cards de Estatísticas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-dark-300 rounded-xl p-4 shadow-lg border border-yellow-500/20">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-500"></i>
                            </div>
                            <div>
                                <h3 class="text-gray-400 text-sm">Em Espera</h3>
                                <p class="text-2xl font-bold text-white"><?php echo $demandasEmEspera; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark-300 rounded-xl p-4 shadow-lg border border-blue-500/20">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-spinner text-blue-500"></i>
                            </div>
                            <div>
                                <h3 class="text-gray-400 text-sm">Em Andamento</h3>
                                <p class="text-2xl font-bold text-white"><?php echo $demandasEmAndamento; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark-300 rounded-xl p-4 shadow-lg border border-green-500/20">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div>
                                <h3 class="text-gray-400 text-sm">Concluídas</h3>
                                <p class="text-2xl font-bold text-white"><?php echo $demandasConcluidas; ?></p>
                            </div>
                        </div>
                    </div>
                     <div class="bg-dark-300 rounded-xl p-4 shadow-lg border border-red-500/20">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-ban text-red-500"></i>
                            </div>
                            <div>
                                <h3 class="text-gray-400 text-sm">Canceladas</h3>
                                <p class="text-2xl font-bold text-white"><?php echo $demandasCanceladas; ?></p>
                            </div>
                        </div>
                    </div>
                     <div class="bg-dark-300 rounded-xl p-4 shadow-lg border border-blue-500/20">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-list text-blue-500"></i>
                            </div>
                            <div>
                                <h3 class="text-gray-400 text-sm">Total Demandas</h3>
                                <p class="text-2xl font-bold text-white"><?php echo $totalDeDemandas; ?></p>
                            </div>
                        </div>
                    </div>
                     <div class="bg-dark-300 rounded-xl p-4 shadow-lg border border-secondary-500/20">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-secondary-500/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-secondary-500"></i>
                            </div>
                            <div>
                                <h3 class="text-gray-400 text-sm">Total Usuários</h3>
                                <p class="text-2xl font-bold text-white"><?php echo $totalDeUsuarios; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico -->
                <div class="bg-dark-300 rounded-xl p-4 shadow-lg border border-primary/20 flex items-center justify-center">
                    <div class="w-full h-full max-w-sm max-h-sm">
                         <canvas id="demandasChart"></canvas>
                    </div>
                </div>
            </div>
          
        </div>

        <!-- Estatísticas por Usuário -->
        <div class="bg-dark-200 rounded-xl p-6 shadow-lg border border-primary/20">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                <i class="fas fa-users text-primary-50"></i>
                Estatísticas por Usuário
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($estatisticasUsuarios as $estat): ?>
                <div class="bg-dark-300 rounded-xl p-6 shadow-lg border border-primary/20 hover:border-primary/40 transition-all duration-300">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-50 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white"><?php echo htmlspecialchars($estat['nome']); ?></h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Concluídas</span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400">
                                <?php echo $estat['concluidas']; ?>
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Pendentes</span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400">
                                <?php echo $estat['pendentes']; ?>
                            </span>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-700">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Total</span>
                                <span class="text-lg font-bold text-white">
                                    <?php echo $estat['concluidas'] + $estat['pendentes']; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <script>
        // Configuração do gráfico
        const ctx = document.getElementById('demandasChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Em Espera', 'Em Andamento', 'Concluídas', 'Canceladas'],
                datasets: [{
                    data: [
                        <?php echo $demandasEmEspera; ?>,
                        <?php echo $demandasEmAndamento; ?>,
                        <?php echo $demandasConcluidas; ?>,
                        <?php echo $demandasCanceladas; ?>
                    ],
                    backgroundColor: [
                        'rgba(234, 179, 8, 0.8)',   // Amarelo para Em Espera
                        'rgba(59, 130, 246, 0.8)',  // Azul para Em Andamento
                        'rgba(34, 197, 94, 0.8)',    // Verde para Concluídas
                        'rgba(239, 68, 68, 0.8)'    // Vermelho para Canceladas
                    ],
                    borderColor: [
                        'rgba(234, 179, 8, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#ffffff',
                            font: {
                                family: "'Inter', sans-serif",
                                size: 14
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    </script>
</body>
</html> 