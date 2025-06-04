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
                        'ceara-orange': '#FFA500',
                        'ceara-white': '#FFFFFF',
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
        @import url('https://fonts.googleapis.com/css2?family=Anton&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        .gradient-text {
            background: linear-gradient(45deg, #008C45, #FFA500);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        body {
            background: url('../../assets/img/fundo.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .content-bg {
            background: rgba(255,255,255,0.85);
            border-radius: 1rem;
            box-shadow: 0 2px 16px 0 rgba(0,0,0,0.08);
        }
    </style>
</head>

<body class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-8 content-bg">
        <h1 class="text-3xl mb-8 text-center" style="font-family: 'Anton', serif;">
            <span class="gradient-text text-4x1">Frequências registradas em:</span>
            <span class="text-2xl" style="color: black !important; -webkit-text-fill-color: black !important;"><?php echo date('d/m/Y'); ?></span>
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- 3A -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="h-1.5 bg-gradient-to-r from-danger to-danger/80"></div>
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4 text-danger">3º Ano A</h2>
                    <div class="space-y-2">
                        <?php
                        $dados = $select->saida_estagio_3A();
                        foreach ($dados as $dado) {
                        ?>
                            <p class="text-gray-600 hover:text-danger transition-colors">
                                <i class="fas fa-user-graduate mr-2"></i><?= $dado['nome'] ?>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- 3B -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="h-1.5 bg-gradient-to-r from-info to-info/70"></div>
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4 text-info">3º Ano B</h2>
                    <div class="space-y-2">
                        <?php
                        $dados = $select->saida_estagio_3B();
                        foreach ($dados as $dado) {
                        ?>
                            <p class="text-gray-600 hover:text-info transition-colors">
                                <i class="fas fa-user-graduate mr-2"></i><?= $dado['nome'] ?>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- 3C -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="h-1.5 bg-gradient-to-r from-admin to-admin/80"></div>
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4 text-admin">3º Ano C</h2>
                    <div class="space-y-2">
                        <?php
                        $dados = $select->saida_estagio_3C();
                        foreach ($dados as $dado) {
                        ?>
                            <p class="text-gray-600 hover:text-admin transition-colors">
                                <i class="fas fa-user-graduate mr-2"></i><?= $dado['nome'] ?>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- 3D -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="h-1.5 bg-gradient-to-r from-grey to-grey/70"></div>
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4 text-grey">3º Ano D</h2>
                    <div class="space-y-2">
                        <?php
                        $dados = $select->saida_estagio_3D();
                        foreach ($dados as $dado) {
                        ?>
                            <p class="text-gray-600 hover:text-grey transition-colors">
                                <i class="fas fa-user-graduate mr-2"></i><?= $dado['nome'] ?>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
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