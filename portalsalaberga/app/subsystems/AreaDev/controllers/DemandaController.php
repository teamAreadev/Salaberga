<?php
// session_start();
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
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
        case 'atualizar_status':
            if (isset($_POST['id']) && isset($_POST['novo_status'])) {
                $demanda = new Demanda($pdo);
                if ($_POST['novo_status'] === 'em_andamento') {
                    $demanda->marcarEmAndamento($_POST['id'], $_POST['usuario_id'] ?? 1);
                } elseif ($_POST['novo_status'] === 'concluida') {
                    // Removido isAdmin()
                    $pdo->beginTransaction();
                    try {
                        // Atualiza o status da demanda
                        $stmt = $pdo->prepare("
                            UPDATE demandas 
                            SET status = 'concluida', data_conclusao = CURRENT_TIMESTAMP 
                            WHERE id = ?
                        ");
                        $stmt->execute([$_POST['id']]);

                        // Atualiza apenas o status do admin
                        $stmt = $pdo->prepare("
                            UPDATE demanda_usuarios 
                            SET status = 'concluido', data_conclusao = CURRENT_TIMESTAMP 
                            WHERE demanda_id = ? AND usuario_id = ?
                        ");
                        $stmt->execute([$_POST['id'], 1]);

                        $pdo->commit();
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        header("Location: ../views/admin.php?error=Erro ao concluir demanda.");
                        exit();
                    }
                }
            }
            break;
        case 'aceitar_demanda':
            // Removido verificarUsuario();
            if (isset($_POST['id'])) {
                $demanda = new Demanda($pdo);
                $sucesso = $demanda->aceitarDemanda($_POST['id'], 1);
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
                $sucesso = $demanda->recusarDemanda($_POST['id'], 1);
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

// Removidas funções isAdmin, verificarAdmin e verificarUsuario 