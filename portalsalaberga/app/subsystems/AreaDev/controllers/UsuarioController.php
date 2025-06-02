<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Usuario.php';

// Inicializa a conexão com o banco de dados
$database = Database::getInstance();
// Usar a conexão salaberga, pois as tabelas permissoes e sist_perm estão nela
$pdo = $database->getSalabergaConnection(); 

$usuario = new Usuario($pdo);

// Processar ações relacionadas a usuários
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] === 'criar_usuario') {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $tipo_descricao = $_POST['tipo'] ?? ''; // Renomeado para clareza, pois é a descrição da permissão
        $area_id = $_POST['area_id'] ?? null; // Obter area_id do formulário

        // Validar dados básicos
        if (empty($nome) || empty($email) || empty($senha) || empty($tipo_descricao)) {
            header("Location: ../views/admin.php?error_usuario=Por favor, preencha todos os campos básicos (Nome, E-mail, Senha, Tipo).");
            exit();
        }

        // Obter o ID da permissão baseado na descrição selecionada
        $stmtPermissao = $pdo->prepare("SELECT id FROM permissoes WHERE descricao = ?");
        $stmtPermissao->execute([$tipo_descricao]);
        $permissao = $stmtPermissao->fetch(PDO::FETCH_ASSOC);

        if (!$permissao) {
            header("Location: ../views/admin.php?error_usuario=Tipo de usuário inválido.");
            exit();
        }
        
        $permissao_id = $permissao['id'];

        // --- Buscar o sist_perm_id correto para o sistema de Demandas (ID 3) ---
        $sistema_demandas_id = 3; 
        $stmtSistPerm = $pdo->prepare("
            SELECT id 
            FROM sist_perm 
            WHERE sistema_id = ? AND permissao_id = ?
        ");
        $stmtSistPerm->execute([$sistema_demandas_id, $permissao_id]);
        $sist_perm = $stmtSistPerm->fetch(PDO::FETCH_ASSOC);

        if (!$sist_perm) {
             // Se não encontrar sist_perm_id para o sistema 3 e a permissão, pode ser um problema de configuração
             // ou o usuário selecionou uma permissão que não se aplica a este sistema.
             header("Location: ../views/admin.php?error_usuario=Configuração de permissão inválida para este sistema.");
             exit();
        }
        
        $sist_perm_id_correto = $sist_perm['id'];
        // --- Fim da busca pelo sist_perm_id ---

        // Chamar a função para criar o usuário no modelo, passando o sist_perm_id correto
        // Também passar area_id, pois a função criarUsuario na classe Usuario foi modificada para recebê-lo
        $resultado = $usuario->criarUsuario($nome, $email, $senha, $sist_perm_id_correto, $area_id);

        if ($resultado === true) {
            header("Location: ../views/admin.php?success_usuario=Usuário criado com sucesso!");
            exit();
        } elseif ($resultado === "email_ja_cadastrado") {
            header("Location: ../views/admin.php?error_usuario=E-mail já cadastrado.");
            exit();
        } else {
            // Para depuração, você pode logar $resultado ou exibi-lo de forma segura
            error_log("Erro ao criar usuário: " . $resultado); 
            header("Location: ../views/admin.php?error_usuario=Erro técnico ao criar usuário. Consulte os logs para mais detalhes.");
            exit();
        }
    }
    // Adicione aqui outras ações relacionadas a usuários (ex: editar, excluir, etc.)
}

// Se nenhuma ação POST foi processada ou se o acesso for direto, redirecionar ou mostrar algo
header("Location: ../views/admin.php");
exit();

?> 