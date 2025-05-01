<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A90E2">
    <meta name="description" content="Sistema de Gerenciamento de Estágio - STGM">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <title>Login - Sistema de Estágio</title>
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
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 2rem;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .login-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 2px solid rgba(0, 122, 51, 0.2);
        background: var(--background-color);
        color: var(--text-color);
        transition: all 0.3s ease;
    }

    .login-input:focus {
        outline: none;
        border-color: var(--header-color);
        box-shadow: 0 4px 12px rgba(0, 122, 51, 0.1);
    }

    .login-button {
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        background-color: var(--header-color);
        color: white;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .login-button:hover {
        background-color: #00692c;
        transform: translateY(-2px);
    }
</style>

<body class="select-none">
    <div class="login-card">
        <div class="text-center mb-6">
            <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-20 mx-auto mb-3">
            <h1 class="text-2xl font-bold text-primary">Sistema de <span class="text-secondary">Estágio</span></h1>
            <div class="h-0.5 bg-primary/20 rounded-full mt-1 mx-auto w-3/4"></div>
        </div>

        <form action="../controllers/controller.php" id="loginForm" class="space-y-4">
            <div>
                <label for="username" class="block mb-1 font-medium">Usuário</label>
                <input name="email" type="text" id="username" class="login-input" placeholder="Digite seu usuário" required>
            </div>

            <div>
                <label for="password" class="block mb-1 font-medium">Senha</label>
                <input name="senha" type="password" id="password" class="login-input" placeholder="Digite sua senha" required>
            </div>

            <div class="flex items-center justify-between mt-6">
                <?php
                if (isset($_GET['erro'])) {
                ?>
                    <p>senha ou email incorretos</p>
                <?php } ?>
                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm">Lembrar-me</label>
                </div>

                <a href="#" class="text-sm text-primary hover:underline">Esqueceu a senha?</a>
            </div>

            <button type="submit" class="login-button mt-6">Entrar</button>
        </form>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar modo escuro


            // Configurar formulário de login
            const loginForm = document.getElementById('loginForm');

            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;

                // Simular autenticação
                if (username && password) {
                    // Redirecionamento para o dashboard
                    window.location.href = 'dashboard.php';
                }
            });
        });
    </script>
</body>

</html>