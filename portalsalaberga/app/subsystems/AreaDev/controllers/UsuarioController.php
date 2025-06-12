<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Usuario.php';

session_start();

// Inicializa a conexão com o banco de dados
$database = new Database();
$pdo = $database->getConnection();

// Verificar se o usuário está logado e é admin (apenas admins devem criar usuários)
// Adapte esta verificação conforme a sua lógica de permissões
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    // Redirecionar para login ou página de erro de permissão
    header("Location: ../views/login.php?error=Acesso negado.");
    exit();
}

$usuario = new Usuario($pdo);

// Processar ações relacionadas a usuários
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] === 'criar_usuario') {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $tipo = $_POST['tipo'] ?? 'usuario';

        // Validar dados (adicione mais validações se necessário)
        if (empty($nome) || empty($email) || empty($senha)) {
            // Redirecionar de volta com mensagem de erro, se necessário
            header("Location: ../views/admin.php?error_usuario=Por favor, preencha todos os campos do usuário.");
            exit();
        }

        // Chamar a função para criar o usuário no modelo
        $sucesso = $usuario->criarUsuario($nome, $email, $senha, $tipo);

        if ($sucesso) {
            // Redirecionar de volta para a página de administração após sucesso
            header("Location: ../views/admin.php?success_usuario=Usuário criado com sucesso!");
            exit();
        } else {
            // Redirecionar de volta com mensagem de erro em caso de falha na inserção
            header("Location: ../views/admin.php?error_usuario=Erro ao criar usuário. Email já cadastrado ou outro erro.");
            exit();
        }
    }
    // Adicione aqui outras ações relacionadas a usuários (ex: editar, excluir, etc.)
}

// Se nenhuma ação POST foi processada ou se o acesso for direto, redirecionar ou mostrar algo
header("Location: ../views/admin.php");
exit();

?> 