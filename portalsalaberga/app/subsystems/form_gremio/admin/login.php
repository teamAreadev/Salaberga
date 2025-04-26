<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Copa Grêmio 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                            700: '#005A24', // Base primary color
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
                            600: '#FF8C00', // Base secondary color
                            700: '#cc7000',
                            800: '#995400',
                            900: '#663800',
                        },
                        accent: {
                            50: '#ffede9',
                            100: '#ffdbd3',
                            200: '#ffb7a7',
                            300: '#ff937b',
                            400: '#FF6347', // Base accent color
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
    <style>
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(0, 90, 36, 0.2);
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md">
        <!-- Cabeçalho -->
        <div class="bg-primary-700 text-white rounded-t-lg py-6 px-8 text-center">
            <h1 class="text-2xl font-bold">Área Administrativa</h1>
            <p class="text-primary-200">Copa Grêmio 2025</p>
        </div>
        
        <!-- Formulário de Login -->
        <div class="bg-white shadow-md rounded-b-lg p-8">
            <div class="mb-6 text-center">
                <i class="fas fa-lock text-5xl text-primary-600 mb-3"></i>
                <h2 class="text-xl font-semibold text-gray-700">Login Administrativo</h2>
                <p class="text-gray-500 text-sm">Acesse para gerenciar as inscrições</p>
            </div>
            
            <form id="login-form" class="space-y-6">
                <div>
                    <label for="usuario" class="block text-sm font-medium text-gray-700 mb-1">Usuário</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="usuario" name="usuario" required 
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus"
                            placeholder="Nome de usuário">
                    </div>
                </div>
                
                <div>
                    <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="senha" name="senha" required 
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus"
                            placeholder="Sua senha">
                    </div>
                </div>
                
                <div id="mensagem-erro" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"></span>
                </div>
                
                <div>
                    <button type="submit" class="w-full bg-primary-600 text-white py-2 px-4 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors flex items-center justify-center">
                        <span>Entrar</span>
                        <i class="fas fa-sign-in-alt ml-2"></i>
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <a href="../index.php" class="text-sm text-primary-600 hover:text-primary-800 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-1"></i> Voltar para o formulário de inscrição
                </a>
            </div>
        </div>
        
        <div class="mt-4 text-center text-xs text-gray-500">
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
                
                const formData = new FormData(form);
                
                // Enviar dados para o controller
                fetch('../controllers/AdminController.php?action=login', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'inscricoes.php';
                    } else {
                        mensagemErro.classList.remove('hidden');
                        mensagemErro.querySelector('span').textContent = data.message;
                    }
                })
                .catch(error => {
                    console.error('Erro ao realizar login:', error);
                    mensagemErro.classList.remove('hidden');
                    mensagemErro.querySelector('span').textContent = 'Erro ao processar o login. Tente novamente.';
                });
            });
        });
    </script>
</body>
</html> 