<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../model/Usuario.php';

session_start();

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

    // Debug: Mostrar dados recebidos
    echo "<pre>Dados recebidos:\n";
    echo "Email: " . htmlspecialchars($email) . "\n";
    echo "Senha: " . htmlspecialchars($senha) . "\n";
    echo "Hash da senha: " . md5($senha) . "\n</pre>";

    if (empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos.';
    } else {
        $usuario = new Usuario($pdo);
        $resultado = $usuario->verificarLogin($email, $senha);

        // Debug: Mostrar resultado da verificação
        echo "<pre>Resultado da verificação:\n";
        var_dump($resultado);
        echo "</pre>";

        if ($resultado) {
            $_SESSION['usuario_id'] = $resultado['id'];
            $_SESSION['usuario_nome'] = $resultado['nome'];
            $_SESSION['usuario_tipo'] = $resultado['tipo'];
            
            // Debug: Mostrar dados da sessão
            echo "<pre>Dados da sessão:\n";
            print_r($_SESSION);
            echo "</pre>";

            if ($resultado['tipo'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: usuario.php");
            }
            exit();
        } else {
            // Debug: Verificar se o usuário existe
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $usuario_existe = $stmt->fetch(PDO::FETCH_ASSOC);
            
            echo "<pre>Verificação do usuário:\n";
            echo "Usuário existe: " . ($usuario_existe ? "Sim" : "Não") . "\n";
            if ($usuario_existe) {
                echo "Hash armazenada: " . $usuario_existe['senha'] . "\n";
                echo "Hash gerada: " . md5($senha) . "\n";
                echo "Senhas correspondem: " . ($usuario_existe['senha'] === md5($senha) ? "Sim" : "Não") . "\n";
            }
            echo "</pre>";

            $erro = 'Email ou senha inválidos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A90E2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Login - Sistema de Gestão de Demandas</title>
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
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary">Sistema de Gestão de Demandas</h1>
            <p class="text-gray-600 mt-2">Faça login para acessar o sistema</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <?php if (!empty($erro)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($erro); ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                </div>

                <div>
                    <label for="senha" class="block text-sm font-medium text-gray-700">Senha</label>
                    <div class="mt-1">
                        <input type="password" name="senha" id="senha" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-sign-in-alt mr-2"></i> Entrar
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="../index.php" class="text-primary hover:text-primary/90">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar para a página inicial
                </a>
            </div>
        </div>
    </div>
</body>
</html> 