<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Usuário - Copa Grêmio 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        .hover-float:hover {
            transform: translateY(-3px);
            transition: transform 0.3s ease;
        }
        .input-transition {
            transition: all 0.3s ease;
        }
        .input-transition:focus {
            border-color: #007d40;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md animate-fadeInUp" style="animation-delay: 0.1s">
        <div class="bg-gradient-to-r from-primary-700 to-primary-800 text-white rounded-t-lg py-6 px-8 text-center shadow-lg">
            <i class="fas fa-user text-4xl mb-3 text-secondary-300 animate-pulse"></i>
            <h1 class="text-2xl font-bold">Área do Usuário</h1>
            <p class="text-primary-200">Copa Grêmio 2025</p>
        </div>
        <div class="bg-white shadow-xl rounded-b-lg p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mt-16 -mr-16 opacity-50"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-secondary-50 rounded-full -mb-12 -ml-12 opacity-50"></div>
            <div class="mb-6 text-center relative z-10 animate-fadeInUp" style="animation-delay: 0.3s">
                <div class="inline-block p-4 bg-primary-50 rounded-full mb-3">
                    <i class="fas fa-user text-4xl text-primary-600"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-700">Login do Usuário</h2>
                <p class="text-gray-500 text-sm">Acesse para ver sua inscrição</p>
            </div>
            <form id="login-form" class="space-y-6 relative z-10">
                <div class="animate-fadeInUp" style="animation-delay: 0.4s">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 group-hover:text-primary-500 transition-colors"></i>
                        </div>
                        <input type="email" id="email" name="email" required 
                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-transition hover:border-primary-300"
                            placeholder="seu.email@exemplo.com">
                    </div>
                </div>
                <div class="animate-fadeInUp" style="animation-delay: 0.5s">
                    <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone/WhatsApp</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fab fa-whatsapp text-gray-400 group-hover:text-primary-500 transition-colors"></i>
                        </div>
                        <input type="tel" id="telefone" name="telefone" required 
                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-transition hover:border-primary-300"
                            placeholder="(00) 00000-0000">
                    </div>
                </div>
                <div id="mensagem-erro" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded relative animate-fadeInUp" role="alert">
                    <div class="flex">
                        <div class="py-1"><i class="fas fa-exclamation-circle mr-2"></i></div>
                        <div>
                            <span class="block sm:inline"></span>
                        </div>
                    </div>
                </div>
                <div class="animate-fadeInUp" style="animation-delay: 0.6s">
                    <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-primary-700 text-white py-3 px-4 rounded-md hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover-float shadow-md flex items-center justify-center">
                        <span>Entrar</span>
                        <i class="fas fa-sign-in-alt ml-2"></i>
                    </button>
                </div>
            </form>
            <div class="mt-6 text-center relative z-10 animate-fadeInUp" style="animation-delay: 0.7s">
                <a href="../index.php" class="text-sm text-primary-600 hover:text-primary-800 flex items-center justify-center transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-1"></i> Voltar para o formulário de inscrição
                </a>
            </div>
        </div>
        <div class="mt-4 text-center text-xs text-gray-500 animate-fadeInUp" style="animation-delay: 0.8s">
            <p>&copy; 2025 Grêmio Estudantil José Ivan Pontes Júnior</p>
            <p>EEEP Salaberga Torquato Gomes de Matos</p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('login-form');
            const mensagemErro = document.getElementById('mensagem-erro');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const button = form.querySelector('button[type="submit"]');
                button.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Entrando...';
                button.disabled = true;
                const formData = new FormData(form);
                fetch('../controllers/InscricaoController.php?action=loginUsuario', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        button.innerHTML = '<i class="fas fa-check"></i> Sucesso!';
                        button.classList.remove('from-primary-600', 'to-primary-700');
                        button.classList.add('from-green-500', 'to-green-600');
                        setTimeout(() => {
                            window.location.href = 'painel.php';
                        }, 500);
                    } else {
                        button.innerHTML = '<span>Entrar</span><i class="fas fa-sign-in-alt ml-2"></i>';
                        button.disabled = false;
                        mensagemErro.classList.remove('hidden');
                        mensagemErro.querySelector('span').textContent = data.message;
                    }
                })
                .catch(error => {
                    button.innerHTML = '<span>Entrar</span><i class="fas fa-sign-in-alt ml-2"></i>';
                    button.disabled = false;
                    mensagemErro.classList.remove('hidden');
                    mensagemErro.querySelector('span').textContent = 'Erro ao processar o login. Tente novamente.';
                });
            });
        });
    </script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e6f2ec',
                            100: '#cce5d9',
                            200: '#99cbb3',
                            300: '#66b18d',
                            400: '#339766',
                            500: '#007d40',
                            600: '#006a36',
                            700: '#005A24',
                            800: '#004d1f',
                            900: '#00401a',
                        },
                        secondary: {
                            50: '#fff8e6',
                            100: '#ffefc0',
                            200: '#ffe099',
                            300: '#ffd066',
                            400: '#ffc033',
                            500: '#ffb000',
                            600: '#FF8C00',
                            700: '#cc7000',
                            800: '#995400',
                            900: '#663800',
                        },
                        accent: {
                            50: '#ffede9',
                            100: '#ffdbd3',
                            200: '#ffb7a7',
                            300: '#ff937b',
                            400: '#FF6347',
                            500: '#ff3814',
                            600: '#e62600',
                            700: '#b31e00',
                            800: '#801500',
                            900: '#4d0c00',
                        }
                    }
                }
            }
        }
    </script>
</body>
</html> 