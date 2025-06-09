<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Usuario.php';

session_start();

// Inicializa a conexão com o banco de dados
$database = new Database();
$pdo = $database->getConnection();

// Se já estiver logado, redireciona para a página principal
if (isset($_SESSION['usuario_id'])) {
    if ($_SESSION['usuario_tipo'] === 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: usuario.php");
    }
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos.';
    } else {
        $usuario = new Usuario($pdo);
        $resultado = $usuario->verificarLogin($email, $senha);

        if ($resultado) {
            $_SESSION['usuario_id'] = $resultado['id'];
            $_SESSION['usuario_nome'] = $resultado['nome'];
            $_SESSION['usuario_tipo'] = $resultado['tipo'];

            if ($resultado['tipo'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: usuario.php");
            }
            exit();
        } else {
            $erro = 'Email ou senha inválidos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Login - Sistema de Gestão de Demandas">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Login - Sistema de Gestão de Demandas</title>
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
                },
                animation: {
                    'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                },
                boxShadow: {
                    'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.36)',
                    'card': '0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -4px rgba(0, 0, 0, 0.2)'
                }
            }
        }
    }
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

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
            radial-gradient(circle at 10% 20%, rgba(0, 122, 51, 0.03) 0%, rgba(0, 122, 51, 0) 20%),
            radial-gradient(circle at 90% 80%, rgba(255, 165, 0, 0.03) 0%, rgba(255, 165, 0, 0) 20%);
        transition: all 0.3s ease;
    }

    .login-card {
        background: rgba(45, 45, 45, 0.97);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 8px 24px rgba(0,0,0,0.18);
        border: 1.5px solid #007A3333;
        transition: box-shadow 0.3s, border 0.3s;
        backdrop-filter: blur(10px);
    }

    .login-card:hover {
        box-shadow: 0 12px 32px rgba(0,122,51,0.18);
        border: 1.5px solid #00FF6B;
    }

    .custom-input {
        background: rgba(35, 35, 35, 0.9);
        border: 1.5px solid #007A3333;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        color: #ffffff;
        transition: all 0.3s ease;
    }

    .custom-input:focus {
        border-color: #00FF6B;
        box-shadow: 0 0 0 2px rgba(0, 255, 107, 0.1);
        outline: none;
    }

    .custom-input::placeholder {
        color: #666666;
    }

    .custom-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
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

    /* Custom scrollbar */
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

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }

    .slide-up {
        animation: slideUp 0.4s ease-out forwards;
    }

    .error-message {
        background: rgba(220, 38, 38, 0.1);
        border: 1px solid rgba(220, 38, 38, 0.2);
        color: #ef4444;
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
</style>
<body class="select-none">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="login-card w-full max-w-md slide-up">
        <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Bem-vindo</h1>
                <p class="text-gray-300">Faça login para acessar o sistema</p>
        </div>

            <?php if (isset($_GET['error'])): ?>
            <div class="error-message fade-in">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </span>
                        <input type="email" id="email" name="email" required
                            class="custom-input w-full pl-10"
                            placeholder="seu@email.com">
                    </div>
                </div>

                <div>
                    <label for="senha" class="block text-sm font-medium text-gray-300 mb-2">Senha</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                        <input type="password" id="senha" name="senha" required
                            class="custom-input w-full pl-10"
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" name="login"
                    class="custom-btn w-full bg-primary hover:bg-primary-400 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt btn-icon"></i>
                    Entrar
                    </button>
            </form>

            <div class="mt-6 text-center">
                <a href="../index.php" class="text-primary-50 hover:text-primary-200 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar para a página inicial
                </a>
            </div>
        </div>
    </div>
</body>
</html> 