<?php
require_once(__DIR__ . '/../../model/select_model.php');
$select = new select_model();

session_start();
function redirect_to_login()
{
  header('Location: ../../../../../../main/views/autenticacao/login.php');
}
if (!isset($_SESSION['Email'])) {
  session_destroy();
  redirect_to_login();
}   
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Últimas Saídas</title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ceara-green': '#008C45',
                        'ceara-light-green': '#3CB371',
                        'ceara-olive': '#8CA03E',
                        'ceara-orange': '#FFA500',
                        primary: '#4CAF50',
                        secondary: '#FFB74D',
                        danger: '#dc3545',
                        admin: '#0dcaf0',
                        grey: '#6c757d',
                        info: '#4169E1'
                    },
                },
            },
        };
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #ffffff;
            min-height: 100vh;
            position: relative;
            padding-bottom: 100px; 
        }

        .main-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .class-card {
            background: white;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .class-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .student-item {
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.15s ease;
        }

        .student-item:hover {
            background-color: #f9fafb;
        }

        .student-list {
            max-height: 300px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #e5e7eb #ffffff;
        }

        .student-list::-webkit-scrollbar {
            width: 6px;
        }

        .student-list::-webkit-scrollbar-track {
            background: #ffffff;
            border-radius: 3px;
        }

        .student-list::-webkit-scrollbar-thumb {
            background-color: #e5e7eb;
            border-radius: 3px;
        }

        .student-list::-webkit-scrollbar-thumb:hover {
            background-color: #d1d5db;
        }

        .header-bar-3a { background: linear-gradient(90deg, #dc3545, #c82333); }
        .header-bar-3b { background: linear-gradient(90deg, #4169E1, #3651d1); }
        .header-bar-3c { background: linear-gradient(90deg, #0dcaf0, #0bb5d6); }
        .header-bar-3d { background: linear-gradient(90deg, #6c757d, #5a6268); }

        .gradient-text {
            background: linear-gradient(45deg, #008C45, #008C45);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-name-1 {
            background: linear-gradient(45deg, #008C45, #00BFA5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-name-2 {
            background: linear-gradient(45deg, #6C63FF, #4A90E2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-name-3 {
            background: linear-gradient(45deg, #FF6B6B, #FF8E53);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-name-4 {
            background: linear-gradient(45deg, #9B59B6, #8E44AD);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-text-3a {
            background: linear-gradient(45deg, #dc3545, #ff6b6b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-text-3b {
            background: linear-gradient(45deg, #4169E1, #6c8fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-text-3c {
            background: linear-gradient(45deg, #0dcaf0, #4dd4ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-text-3d {
            background: linear-gradient(45deg, #6c757d, #9ca3af);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .geometric-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            z-index: -1;
            overflow: hidden;
        }

        .geometric-shape {
            position: absolute;
            bottom: 0;
        }

        .shape-1 {
            left: 0;
            width: 0;
            height: 0;
            border-left: 200px solid #FFA500;
            border-top: 100px solid transparent;
        }

        .shape-2 {
            left: 150px;
            width: 0;
            height: 0;
            border-left: 250px solid #8CA03E;
            border-top: 80px solid transparent;
            opacity: 0.9;
        }

        .shape-3 {
            left: 350px;
            width: 0;
            height: 0;
            border-left: 300px solid #008C45;
            border-top: 60px solid transparent;
            opacity: 0.8;
        }

        .shape-4 {
            right: 0;
            width: 0;
            height: 0;
            border-right: 200px solid #FFA500;
            border-top: 100px solid transparent;
            opacity: 0.7;
        }

        .shape-5 {
            right: 150px;
            width: 0;
            height: 0;
            border-right: 250px solid #8CA03E;
            border-top: 80px solid transparent;
            opacity: 0.6;
        }

        .shape-6 {
            right: 350px;
            width: 0;
            height: 0;
            border-right: 300px solid #008C45;
            border-top: 60px solid transparent;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 16px;
                padding: 24px;
            }
            
            .grid-responsive {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .shape-1 { border-left-width: 120px; }
            .shape-2 { border-left-width: 150px; left: 100px; }
            .shape-3 { border-left-width: 180px; left: 200px; }
            
            .shape-4 { border-right-width: 120px; }
            .shape-5 { border-right-width: 150px; right: 100px; }
            .shape-6 { border-right-width: 180px; right: 200px; }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .grid-responsive {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }
        }

        @media (min-width: 1025px) {
            .grid-responsive {
                grid-template-columns: repeat(4, 1fr);
                gap: 24px;
            }
        }
    </style>
</head>

<body class="min-h-screen p-4 md:p-8">
    <div class="main-container max-w-7xl mx-auto p-6 md:p-8">
        <div class="text-center mb-6">
            <div class="flex items-center justify-center gap-4">
                <h1 class="text-2xl md:text-3xl font-semibold">
                    <span class="gradient-text">Relatório de Frequências em:</span>
                </h1>
                <div class="inline-flex items-center bg-white rounded-lg px-3 py-1.5 shadow-sm border">
                    <i class="fas fa-calendar-day text-ceara-green mr-2"></i>
                    <span class="text-base font-medium text-gray-700"><?php echo date('d/m/Y'); ?></span>
                </div>
            </div>
        </div>

        <div class="grid grid-responsive">
            <div class="class-card card-3a">
                <div class="p-3 flex-1">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-medium text-danger flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            3º Ano A
                        </h2>
                        <?php
                        $dados_3a = $select->saida_estagio_3A();
                        $count_3a = count($dados_3a);
                        ?>
                        <span class="bg-red-100 text-danger px-2 py-0.5 rounded-full text-sm">
                            <?= $count_3a ?>
                        </span>
                    </div>
                    <div class="student-list space-y-1">
                        <?php foreach ($dados_3a as $dado) { ?>
                            <div class="student-item">
                                <i class="fas fa-user-graduate mr-2 text-danger text-sm"></i>
                                <span class="text-gray-900"><?= $dado['nome'] ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="class-card card-3b">
                <div class="p-3 flex-1">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-medium text-info flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            3º Ano B
                        </h2>
                        <?php
                        $dados_3b = $select->saida_estagio_3B();
                        $count_3b = count($dados_3b);
                        ?>
                        <span class="bg-blue-100 text-info px-2 py-0.5 rounded-full text-sm">
                            <?= $count_3b ?>
                        </span>
                    </div>
                    <div class="student-list space-y-1">
                        <?php foreach ($dados_3b as $dado) { ?>
                            <div class="student-item">
                                <i class="fas fa-user-graduate mr-2 text-info text-sm"></i>
                                <span class="text-gray-900"><?= $dado['nome'] ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="class-card card-3c">
                <div class="p-3 flex-1">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-medium text-admin flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            3º Ano C
                        </h2>
                        <?php
                        $dados_3c = $select->saida_estagio_3C();
                        $count_3c = count($dados_3c);
                        ?>
                        <span class="bg-cyan-100 text-admin px-2 py-0.5 rounded-full text-sm">
                            <?= $count_3c ?>
                        </span>
                    </div>
                    <div class="student-list space-y-1">
                        <?php foreach ($dados_3c as $dado) { ?>
                            <div class="student-item">
                                <i class="fas fa-user-graduate mr-2 text-admin text-sm"></i>
                                <span class="text-gray-900"><?= $dado['nome'] ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="class-card card-3d">
                <div class="p-3 flex-1">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-medium text-grey flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            3º Ano D
                        </h2>
                        <?php
                        $dados_3d = $select->saida_estagio_3D();
                        $count_3d = count($dados_3d);
                        ?>
                        <span class="bg-gray-100 text-grey px-2 py-0.5 rounded-full text-sm">
                            <?= $count_3d ?>
                        </span>
                    </div>
                    <div class="student-list space-y-1">
                        <?php foreach ($dados_3d as $dado) { ?>
                            <div class="student-item">
                                <i class="fas fa-user-graduate mr-2 text-grey text-sm"></i>
                                <span class="text-gray-900"><?= $dado['nome'] ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-8">
            <div class="inline-flex items-center text-gray-600 bg-white rounded-lg px-4 py-2 shadow-sm border">
                <i class="fas fa-sync-alt mr-2 text-ceara-green animate-spin"></i>
                <span class="text-sm">Atualizando automaticamente...</span>
            </div>
        </div>
    </div>

    <div class="geometric-footer">
        <div class="geometric-shape shape-1"></div>
        <div class="geometric-shape shape-2"></div>
        <div class="geometric-shape shape-3"></div>
        <div class="geometric-shape shape-4"></div>
        <div class="geometric-shape shape-5"></div>
        <div class="geometric-shape shape-6"></div>
    </div>

    <script>
        function redirect() {
            setTimeout(() => {
                window.location = 'ultimo_registro.php';
            }, 1000);
        }
        redirect();
    </script>
</body>

</html>