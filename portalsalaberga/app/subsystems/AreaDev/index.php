<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A90E2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Sistema de Gestão de Demandas</title>
</head>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#007A33',
                    secondary: '#FFA500',
                }
            }
        }
    }
</script>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-primary">Sistema de Gestão de Demandas</h1>
            <a href="views/login.php" class="bg-primary hover:bg-primary/90 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-sign-in-alt"></i> Entrar
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Bem-vindo ao Sistema de Gestão de Demandas</h2>
            <p class="text-xl text-gray-600 mb-8">Gerencie suas demandas de forma eficiente e organizada</p>
            <a href="views/login.php" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 px-8 rounded-lg text-lg">
                Acessar o Sistema
            </a>
        </div>

        <!-- Features -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <i class="fas fa-tasks text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Gestão de Demandas</h3>
                <p class="text-gray-600">Crie, acompanhe e gerencie todas as suas demandas em um só lugar</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <i class="fas fa-users text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Colaboração</h3>
                <p class="text-gray-600">Trabalhe em equipe com atribuição de tarefas e acompanhamento</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <i class="fas fa-chart-line text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Acompanhamento</h3>
                <p class="text-gray-600">Monitore o progresso e mantenha tudo organizado</p>
            </div>
        </div>

        <!-- Benefits -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-center mb-8">Benefícios do Sistema</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                    <div>
                        <h3 class="font-semibold mb-2">Organização Eficiente</h3>
                        <p class="text-gray-600">Mantenha todas as suas demandas organizadas e fáceis de encontrar</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                    <div>
                        <h3 class="font-semibold mb-2">Priorização</h3>
                        <p class="text-gray-600">Defina prioridades e foque no que é mais importante</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                    <div>
                        <h3 class="font-semibold mb-2">Comunicação Clara</h3>
                        <p class="text-gray-600">Mantenha todos informados sobre o progresso das demandas</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                    <div>
                        <h3 class="font-semibold mb-2">Controle Total</h3>
                        <p class="text-gray-600">Gerencie todas as etapas do processo de forma eficiente</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center">
                <p>&copy; <?php echo date('Y'); ?> Sistema de Gestão de Demandas. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html> 