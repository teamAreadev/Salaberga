<?php
session_start();
// Removido controle de sessão e permissões para permitir acesso livre

ob_start(); // Iniciar buffering de saída para capturar qualquer saída inesperada

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';
// require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../model/Demanda.php';

// Inicializa a conexão com o banco de dados
$database = Database::getInstance();
$pdo = $database->getConnection();

$demanda = new Demanda($pdo);

// Tratamento de requisições GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'get_demanda':
            if (!isset($_GET['id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID não fornecido']);
                exit;
            }

            $demanda = new Demanda($pdo);
            $dados = $demanda->buscarDemanda($_GET['id']);

            if (!$dados) {
                http_response_code(404);
                echo json_encode(['error' => 'Demanda não encontrada']);
                exit;
            }

            header('Content-Type: application/json');
            echo json_encode($dados);
            exit;
            break;
        case 'excluir':
            // Removido verificarAdmin();
            if (!isset($_GET['id'])) {
                $error_response = ['error' => 'ID não fornecido'];
                http_response_code(400);
                echo json_encode($error_response);
                exit();
            }
            $demanda->excluirDemanda($_GET['id']);
            header("Location: ../views/admin.php");
            exit();
            break;
    }
}

// Tratamento de requisições POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se a ação é para atualizar o status
    if (isset($_GET['action']) && $_GET['action'] === 'updateStatus') {
        if (isset($_POST['id']) && isset($_POST['novo_status'])) {
            $demanda = new Demanda($pdo);
            
            // Obter o ID do usuário logado da sessão
            $usuario_id_logado = $_SESSION['user_id'] ?? null;

            // Verificar se o usuário está logado
            if (!$usuario_id_logado) {
                header("Location: ../views/usuario.php?error=Usuário não logado.");
                exit();
            }

            if ($_POST['novo_status'] === 'em_andamento') {
                error_log("DEBUG Controller: Tentando marcar demanda ID " . $_POST['id'] . " como em andamento para usuário " . $usuario_id_logado);
                $sucesso = $demanda->marcarEmAndamento($_POST['id'], $usuario_id_logado);
                error_log("DEBUG Controller: Resultado de marcarEmAndamento: " . ($sucesso ? 'Sucesso' : 'Falha'));
                if ($sucesso) {
                    error_log("DEBUG Controller: Preparando para redirecionar para sucesso - em_andamento");
                    header("Location: ../views/usuario.php?success=Demanda marcada como em andamento!");
                    error_log("DEBUG Controller: Chamada header() executada para sucesso - em_andamento");
                } else {
                    error_log("DEBUG Controller: Preparando para redirecionar para erro - em_andamento");
                    header("Location: ../views/usuario.php?error=Erro ao marcar demanda como em andamento.");
                    error_log("DEBUG Controller: Chamada header() executada para erro - em_andamento");
                }
            } elseif ($_POST['novo_status'] === 'concluida') {
                error_log("DEBUG Controller: Tentando marcar demanda ID " . $_POST['id'] . " como concluída para usuário " . $usuario_id_logado);
                $sucesso = $demanda->marcarConcluida($_POST['id'], $usuario_id_logado);
                error_log("DEBUG Controller: Resultado de marcarConcluida: " . ($sucesso ? 'Sucesso' : 'Falha'));
                if ($sucesso) {
                    header("Location: ../views/usuario.php?success=Sua parte na demanda foi marcada como concluída!");
                } else {
                    header("Location: ../views/usuario.php?error=Erro ao marcar sua parte na demanda como concluída.");
                }
            }
            exit();
        }
    }
    
    // Switch para outras ações POST que usam o parâmetro 'acao' no corpo
    if (isset($_POST['acao'])) {
    switch ($_POST['acao']) {
        case 'excluir':
            // Removido verificarAdmin();
            if (isset($_POST['id'])) {
                $demanda = new Demanda($pdo);
                $sucesso = $demanda->excluirDemanda($_POST['id']);
                if ($sucesso) {
                    header("Location: ../views/admin.php?success=Demanda excluída com sucesso!");
                } else {
                    header("Location: ../views/admin.php?error=Erro ao excluir demanda.");
                }
                exit();
            }
            break;
        case 'criar':
            // Removido verificarAdmin();
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $prioridade = $_POST['prioridade'] ?? 'media';
            $usuarios_ids = isset($_POST['usuarios_ids']) ? (is_array($_POST['usuarios_ids']) ? $_POST['usuarios_ids'] : [$_POST['usuarios_ids']]) : [];
            $prazo = $_POST['prazo'] ?? null;
            $area_id = $_POST['area_id'] ?? null;

            if (empty($titulo) || empty($descricao)) {
                header("Location: ../views/admin.php?error=Por favor, preencha título e descrição.");
                exit();
            }

            require_once __DIR__ . '/../model/Usuario.php';
            $database = Database::getInstance();
            $pdo_salaberga = $database->getSalabergaConnection();
            $usuarioModel = new Usuario($pdo_salaberga);

            // Removido uso de $_SESSION['usuario_id']
            $admin_id = 1; // Valor fixo para admin_id
            $sucesso = $demanda->criarDemanda($titulo, $descricao, $prioridade, $admin_id, $usuarios_ids, $prazo, $area_id, $usuarioModel);

            if ($sucesso) {
                header("Location: ../views/admin.php?success=Demanda criada com sucesso!");
            } else {
                header("Location: ../views/admin.php?error=Erro ao criar demanda.");
            }
            exit();
        case 'atualizar_demanda':
            // Removido verificarAdmin();
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $titulo = $_POST['titulo'] ?? '';
                $descricao = $_POST['descricao'] ?? '';
                $prioridade = $_POST['prioridade'] ?? 'media';
                $prazo = $_POST['prazo'] ?? null;

                if (empty($titulo) || empty($descricao)) {
                    header("Location: ../views/admin.php?error=Por favor, preencha título e descrição.");
                    exit();
                }

                $sucesso = $demanda->atualizarDemanda($id, $titulo, $descricao, $prioridade, null, [], $prazo);
                if ($sucesso) {
                    header("Location: ../views/admin.php?success=Demanda atualizada com sucesso!");
                } else {
                    header("Location: ../views/admin.php?error=Erro ao atualizar demanda.");
                }
                exit();
            }
            break;
        case 'aceitar_demanda':
            // Removido verificarUsuario();
            if (isset($_POST['id'])) {
                $demanda = new Demanda($pdo);
                $usuario_id_logado = $_SESSION['user_id'] ?? null; // Obter o ID do usuário logado da sessão

                // Verificar se o usuário está logado
                if (!$usuario_id_logado) {
                    // Redirecionar ou retornar erro se o usuário não estiver logado
                    header("Location: ../views/usuario.php?error=Usuário não logado.");
                    exit();
                }

                $sucesso = $demanda->aceitarDemanda($_POST['id'], $usuario_id_logado);
                if ($sucesso) {
                    header("Location: ../views/usuario.php?success=Demanda aceita com sucesso!");
                } else {
                    header("Location: ../views/usuario.php?error=Erro ao aceitar demanda.");
                }
                exit();
            }
            break;
        case 'recusar_demanda':
            // Removido verificarUsuario();
            if (isset($_POST['id'])) {
                $demanda = new Demanda($pdo);
                $usuario_id_logado = $_SESSION['user_id'] ?? null; // Obter o ID do usuário logado da sessão

                // Verificar se o usuário está logado
                if (!$usuario_id_logado) {
                    // Redirecionar ou retornar erro se o usuário não estiver logado
                    header("Location: ../views/usuario.php?error=Usuário não logado.");
                    exit();
                }

                $sucesso = $demanda->recusarDemanda($_POST['id'], $usuario_id_logado);
                if ($sucesso) {
                    header("Location: ../views/usuario.php?success=Demanda recusada com sucesso!");
                } else {
                    header("Location: ../views/usuario.php?error=Erro ao recusar demanda.");
                }
                exit();
            }
            break;
    }
}

// Removidas funções isAdmin, verificarAdmin e verificarUsuario 
} 