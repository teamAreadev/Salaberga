<?php
session_start();

// Se o usuário já estiver logado, redirecionar para o dashboard
if (isset($_SESSION['aluno_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Processa o login quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../model/UsuarioModel.php';
    
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    
    // Validação básica
    $error = '';
    if (empty($email)) {
        $error = 'O campo email é obrigatório';
    } elseif (empty($nome)) {
        $error = 'O campo nome é obrigatório';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email inválido';
    }
    
    if (empty($error)) {
        $usuarioModel = new UsuarioModel();
        $resultado = $usuarioModel->verificarUsuario($email, $nome);
        
        if ($resultado['success']) {
            // Salva os dados do usuário na sessão
            $_SESSION['aluno_id'] = $resultado['aluno']['id'];
            $_SESSION['aluno_nome'] = $resultado['aluno']['nome'];
            $_SESSION['aluno_email'] = $resultado['aluno']['email'];
            
            // Redireciona para o dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = $resultado['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Usuário - Copa Grêmio 2025</title>
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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'pulse-slow': 'pulse 3s infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        }
        
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 90, 36, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(0, 90, 36, 0.2);
            transition: all 0.2s ease;
        }
        
        .input-container:focus-within .input-icon {
            color: #007d40;
            transition: color 0.2s ease;
        }
        
        .btn-login {
            transition: all 0.3s ease;
            background-size: 200% auto;
            background-image: linear-gradient(to right, #007d40 0%, #339766 50%, #007d40 100%);
        }
        
        .btn-login:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 90, 36, 0.15);
        }
        
        .form-container {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }
        
        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-3px, 0, 0); }
            40%, 60% { transform: translate3d(3px, 0, 0); }
        }
        
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsividade aprimorada */
        @media (max-width: 640px) {
            .form-container {
                width: 90%;
                margin: 0 auto;
            }
        }
        
        /* Efeito de foco nos campos */
        .input-field {
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            transform: translateY(-2px);
        }
        
        /* Animação para o logo */
        .logo-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md form-container">
        <!-- Card Principal -->
        <div class="bg-white rounded-2xl overflow-hidden card-shadow">
            <!-- Cabeçalho -->
            <div class="bg-gradient-to-r from-primary-700 to-primary-600 text-white py-8 px-8 text-center relative">
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\' fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
                </div>
                <h1 class="text-3xl font-bold mb-1 relative">Área do Usuário</h1>
                <p class="text-primary-100 text-lg relative">Copa Grêmio 2025</p>
            </div>
            
            <!-- Formulário de Login -->
            <div class="px-8 py-10">
                <div class="mb-8 text-center">
                    <div class="inline-block p-3 bg-primary-50 rounded-full mb-4">
                        <i class="fas fa-user-circle text-4xl text-primary-600"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-1">Login do Usuário</h2>
                    <p class="text-gray-500">Acesse para visualizar suas informações</p>
                </div>
                
                <?php if (isset($error) && !empty($error)): ?>
                <div id="mensagem-erro" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm"><?php echo $error; ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <form id="login-form" method="post" class="space-y-6">
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                        <div class="relative input-container">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400 input-icon"></i>
                            </div>
                            <input type="email" id="email" name="email" required 
                                class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus input-field"
                                placeholder="Seu e-mail"
                                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="space-y-1">
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                        <div class="relative input-container">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400 input-icon"></i>
                            </div>
                            <input type="text" id="nome" name="nome" required 
                                class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus input-field"
                                placeholder="Seu nome completo"
                                value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full btn-login text-white py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors flex items-center justify-center font-medium text-base">
                            <span>Entrar</span>
                            <i class="fas fa-sign-in-alt ml-2"></i>
                            <div class="loading-spinner ml-2" id="loading-spinner"></div>
                        </button>
                    </div>
                </form>
                
                <div class="mt-6 text-center">
                    <a href="../index.php" class="text-primary-600 hover:text-primary-800 font-medium">
                        <i class="fas fa-arrow-left mr-1"></i> Voltar para o início
                    </a>
                </div>
            </div>
        </div>
        
      
    </div>

    <script>
        // Exibir spinner de carregamento ao submeter o formulário
        document.getElementById('login-form').addEventListener('submit', function() {
            document.getElementById('loading-spinner').style.display = 'block';
        });
    </script>
</body>
</html>