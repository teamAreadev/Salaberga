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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
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
        background-image:
            radial-gradient(circle at 10% 20%, rgba(0, 122, 51, 0.05) 0%, rgba(0, 122, 51, 0) 20%),
            radial-gradient(circle at 90% 80%, rgba(255, 165, 0, 0.05) 0%, rgba(255, 165, 0, 0) 20%),
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cpath fill='%23007A33' fill-opacity='0.03' d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z'%3E%3C/path%3E%3C/svg%3E");
        color: var(--text-color);
        transition: background-color 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        background: linear-gradient(135deg, rgba(49, 49, 49, 0.95) 0%, rgba(37, 37, 37, 0.95) 100%);
        border-radius: 16px;
        padding: 2.5rem;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.05);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(to bottom, #00FF6B, #007A33);
        opacity: 0.6;
        transition: all 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(0, 122, 51, 0.3);
    }

    .login-card:hover::before {
        opacity: 1;
        box-shadow: 0 0 15px rgba(0, 255, 107, 0.4);
    }

    .custom-input {
        background-color: rgba(35, 35, 35, 0.8);
        border: 2px solid rgba(61, 61, 61, 0.8);
        border-radius: 10px;
        color: #ffffff;
        padding: 0.75rem 2.5rem 0.75rem 2.5rem;
        width: 100%;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .custom-input:focus {
        border-color: #007A33;
        box-shadow: 0 0 0 2px rgba(0, 122, 51, 0.2), inset 0 2px 4px rgba(0, 0, 0, 0.1);
        outline: none;
        background-color: rgba(40, 40, 40, 0.9);
    }

    .custom-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .custom-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .custom-btn-primary {
        background: linear-gradient(135deg, #007A33 0%, #009940 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 122, 51, 0.3);
    }

    .custom-btn-primary:hover {
        background: linear-gradient(135deg, #00993F 0%, #00B64B 100%);
        transform: translateY(-3px);
        box-shadow: 0 7px 15px rgba(0, 122, 51, 0.4);
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

    .toggle-password {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.6);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle-password:hover {
        color: rgba(255, 255, 255, 0.9);
    }

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

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in { animation: fadeIn 0.3s ease-out forwards; }
    .slide-up { animation: slideUp 0.4s ease-out forwards; }
</style>

<body class="select-none">
    <div class="login-card slide-up">
        <div class="text-center mb-6">
            <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-20 mx-auto mb-3 fade-in">
            <h1 class="text-2xl font-bold text-primary">Sistema de <span class="text-secondary">Estágio</span></h1>
            <div class="h-0.5 bg-primary/20 rounded-full mt-1 mx-auto w-3/4"></div>
        </div>

        <form action="../controllers/controller.php" id="loginForm" class="space-y-4">
            <div>
                <label for="username" class="block mb-1 font-medium text-gray-300">Usuário</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    <input name="email" type="text" id="username" class="custom-input pl-10" placeholder="Digite seu usuário" required>
                </div>
            </div>
            
            <div>
                <label for="password" class="block mb-1 font-medium text-gray-300">Senha</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    <input name="senha" type="password" id="password" class="custom-input" placeholder="Digite sua senha" required>
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
            </div>
            
            <div class="flex items-center justify-end mt-6">
                <a href="#" class="text-sm text-primary hover:text-primary/80 transition-colors">Esqueceu a senha?</a>
            </div>
            
            <button type="submit" class="custom-btn custom-btn-primary w-full mt-6">
                <i class="fas fa-sign-in-alt btn-icon"></i>
                <span>Entrar</span>
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar formulário de login
            const loginForm = document.getElementById('loginForm');
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            
            // Lógica para revelar/ocultar senha
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;
                
                // Simular autenticação
                if (username && password) {
                    // Redirecionamento para o dashboard
                    window.location.href = 'dashboard.php';
                } else {
                    showToast('Por favor, preencha todos os campos.', 'error');
                }
            });

            // Exibir toast de erro se houver parâmetro 'erro'
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('erro')) {
                showToast('Senha ou email incorretos.', 'error');
            }

            // GSAP Animations
            gsap.from('.login-card', { opacity: 0, y: 50, duration: 0.6, ease: 'power3.out' });
            gsap.from('.login-card img, .login-card h1, .login-card .h-0.5', {
                opacity: 0,
                y: 20,
                duration: 0.5,
                stagger: 0.1,
                ease: 'power2.out',
                delay: 0.2
            });
            gsap.from('.custom-input, .custom-btn, .text-sm, .toggle-password', {
                opacity: 0,
                y: 20,
                duration: 0.4,
                stagger: 0.1,
                ease: 'power2.out',
                delay: 0.4
            });

            // Função para exibir toast
            function showToast(message, type) {
                const toast = document.createElement('div');
                toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 fade-in ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } text-white`;
                toast.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-3"></i>
                        <span>${message}</span>
                    </div>
                `;
                document.body.appendChild(toast);
                setTimeout(() => {
                    gsap.to(toast, {
                        opacity: 0,
                        y: 20,
                        duration: 0.3,
                        onComplete: () => {
                            document.body.removeChild(toast);
                        }
                    });
                }, type === 'success' ? 3000 : 4000);
            }
        });
    </script>
</body>
</html>