<?php
session_start();

// Processar registro se formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    $errors = [];
    
    // Validações
    if (empty($nome)) {
        $errors[] = "Nome é obrigatório";
    }
    
    if (empty($email)) {
        $errors[] = "Email é obrigatório";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido";
    }
    
    if (empty($errors)) {
        // Salvar usuário (aqui você salvaria no banco de dados)
        $usuarios = json_decode(file_get_contents('usuarios.json') ?? '[]', true);
        
        // Verificar se email já existe
        $emailExiste = false;
        foreach ($usuarios as $usuario) {
            if ($usuario['email'] === $email) {
                $emailExiste = true;
                break;
            }
        }
        
        if ($emailExiste) {
            $errors[] = "Este email já está cadastrado";
        } else {
            $novoUsuario = [
                'id' => uniqid(),
                'nome' => $nome,
                'email' => $email,
                'data_cadastro' => date('Y-m-d H:i:s')
            ];
            
            $usuarios[] = $novoUsuario;
            file_put_contents('usuarios.json', json_encode($usuarios, JSON_PRETTY_PRINT));
            
            $_SESSION['success'] = "Usuário cadastrado com sucesso!";
            $_SESSION['usuario'] = $novoUsuario;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário - SESMATED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="https://salaberga.com/salaberga/portalsalaberga/app/main/assets/img/S.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --background-color: #1a1a1a;
            --text-color: #ffffff;
            --header-color: #00b348;
            --icon-bg: #2d2d2d;
            --icon-shadow: rgba(0, 0, 0, 0.3);
            --accent-color: #ffb733;
            --grid-color: #333333;
            --card-bg: rgba(45, 45, 45, 0.9);
            --header-bg: rgba(28, 28, 28, 0.95);
            --mobile-nav-bg: rgba(28, 28, 28, 0.95);
            --search-bar-bg: #2d2d2d;
            --card-border-hover: var(--accent-color);
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #0f0f0f 100%);
            color: var(--text-color);
            min-height: 100vh;
        }
        
        .main-container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.4),
                0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }
        
        .header-section {
            background: linear-gradient(135deg, var(--header-color) 0%, #009639 100%);
            position: relative;
            overflow: hidden;
        }
        
        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
        }
        
        .icon-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        
        .form-section {
            background: rgba(28, 28, 28, 0.8);
            backdrop-filter: blur(10px);
        }
        
        .input-group {
            position: relative;
        }
        
        .input-field {
            background: var(--search-bar-bg);
            border: 2px solid transparent;
            color: var(--text-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .input-field:focus {
            outline: none;
            border-color: var(--header-color);
            background: rgba(45, 45, 45, 1);
            box-shadow: 
                0 0 0 4px rgba(0, 179, 72, 0.1),
                0 10px 15px -3px rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        
        .input-field:hover:not(:focus) {
            border-color: rgba(255, 255, 255, 0.2);
            background: rgba(45, 45, 45, 0.8);
        }
        
        .input-icon {
            color: #888;
            transition: color 0.3s ease;
        }
        
        .input-field:focus + .input-icon,
        .input-group:hover .input-icon {
            color: var(--header-color);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--header-color) 0%, #009639 100%);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 4px 14px 0 rgba(0, 179, 72, 0.3),
                0 2px 4px 0 rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 8px 25px 0 rgba(0, 179, 72, 0.4),
                0 4px 8px 0 rgba(0, 0, 0, 0.3);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .alert-error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.1) 100%);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            backdrop-filter: blur(10px);
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(22, 163, 74, 0.1) 100%);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
            backdrop-filter: blur(10px);
        }
        
        .text-accent {
            color: var(--accent-color);
            transition: color 0.3s ease;
        }
        
        .text-accent:hover {
            color: #e6a429;
        }
        
        .divider {
            background: linear-gradient(90deg, transparent, var(--grid-color), transparent);
            height: 1px;
        }
        
        .logo-text {
            background: linear-gradient(135deg, var(--accent-color) 0%, #e6a429 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .form-container {
            position: relative;
        }
        
        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--header-color), transparent);
        }
    </style>
</head>
<body class="flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="main-container rounded-2xl overflow-hidden">
            <div class="header-section px-8 py-12 text-center relative rounded-b-3xl shadow-lg" style="background: linear-gradient(140deg, #ffb733 3% , #00b348 100%);">
                <div class="icon-container w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 relative z-10 bg-white bg-opacity-20 shadow-2xl backdrop-blur-md border-4 border-white border-opacity-30">
                    <i class="fas fa-user-plus text-4xl" style="color:rgba(255, 255, 255, 0.87); text-shadow: 0 4px 16px #00000033;"></i>
                </div>
                <h1 class="text-4xl font-extrabold mb-2 relative z-10 text-white drop-shadow-lg tracking-wide">
                    Fazer Registro
                </h1>
                <p class="relative z-10 text-lg font-medium tracking-wide drop-shadow" style="color: #fff; text-shadow: 0 2px 8px #00000022;">
                    Junte-se ao <span style="color: #ffb733; font-weight: bold;">Sistema SESMATED</span> 
                </p>
            </div>

            <div class="form-section form-container px-8 py-8">
                <?php if (!empty($errors)): ?>
                    <div class="alert-error px-5 py-4 rounded-xl mb-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium mb-1">Erro no cadastro</h3>
                                <div class="text-sm opacity-90">
                                    <?php foreach ($errors as $error): ?>
                                        <p class="mb-1"><?php echo htmlspecialchars($error); ?></p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert-success px-5 py-4 rounded-xl mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium mb-1">Sucesso!</h3>
                                <p class="text-sm opacity-90"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" id="registerForm" class="space-y-6">
                    <div class="input-group">
                        <label for="nome" class="block text-sm font-semibold mb-3 text-gray-200">
                            Nome Completo
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="nome" 
                                name="nome" 
                                value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>"
                                class="input-field w-full pl-12 pr-4 py-4 rounded-xl text-sm font-medium"
                                placeholder="Digite seu nome completo"
                                required
                            >
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user input-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="email" class="block text-sm font-semibold mb-3 text-gray-200">
                            Endereço de Email
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                class="input-field w-full pl-12 pr-4 py-4 rounded-xl text-sm font-medium"
                                placeholder="Digite seu email"
                                required
                            >
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope input-icon"></i>
                            </div>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="btn-primary w-full py-4 px-6 rounded-xl font-semibold text-sm focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50 relative overflow-hidden"
                    >
                        <span class="relative z-10">
                            <i class="fas fa-user-plus mr-2"></i>
                            Criar Minha Conta
                        </span>
                    </button>
                </form>

                <div class="my-8">
                    <div class="divider"></div>
                </div>
            </div>
        </div>

        <div class="text-center mt-8">
            <p class="text-gray-500 text-xs">
                © 2025 <span class="logo-text font-semibold">SESMATED</span> - Salaberga
            </p>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const nome = document.getElementById('nome').value.trim();
            const email = document.getElementById('email').value.trim();
            
            if (!nome || !email) {
                e.preventDefault();
                showNotification('Por favor, preencha todos os campos obrigatórios', 'error');
                return;
            }
            
            if (!isValidEmail(email)) {
                e.preventDefault();
                showNotification('Por favor, insira um endereço de email válido', 'error');
                return;
            }
        });

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showNotification(message, type) {
            const existing = document.querySelector('.notification');
            if (existing) existing.remove();
            
            const notification = document.createElement('div');
            notification.className = `notification fixed top-6 right-6 p-4 rounded-xl text-white text-sm z-50 max-w-sm shadow-2xl ${
                type === 'error' 
                    ? 'bg-gradient-to-r from-red-600 to-red-700 border border-red-500' 
                    : 'bg-gradient-to-r from-green-600 to-green-700 border border-green-500'
            }`;
            notification.style.backdropFilter = 'blur(10px)';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'} mr-3 text-lg"></i>
                    <span class="font-medium">${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            notification.style.transform = 'translateX(100%)';
            notification.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });
        });
    </script>
</body>
</html>
