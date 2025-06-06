<?php
// Iniciar sessão e buffer de saída no início do arquivo
session_start();
ob_start();

// Definir BASE_URL
define('BASE_URL', '/portalsalaberga/app/subsystems/AreaDev');

// Configuração de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Log para debug
error_log("REQUEST METHOD: " . $_SERVER['REQUEST_METHOD']);
error_log("POST DATA: " . print_r($_POST, true));
error_log("GET DATA: " . print_r($_GET, true));
error_log("SESSION DATA: " . print_r($_SESSION, true));

// Incluir arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Demanda.php';
require_once __DIR__ . '/../model/Usuario.php';

// Função para verificar sessão
function verificarSessao() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /portalsalaberga/app/subsystems/AreaDev/views/login.php?error=Sessão expirada. Por favor, faça login novamente.");
        exit();
    }
    return $_SESSION['user_id'];
}

// Função para redirecionar
function redirecionar($pagina, $mensagem, $tipo = 'error') {
    $url = "../views/{$pagina}.php?{$tipo}=" . urlencode($mensagem);
    error_log("Redirecionando para: " . $url);
    header("Location: " . $url);
    exit();
}

// Inicializa a conexão com o banco de dados
try {
    $database = Database::getInstance();
    $pdo = $database->getConnection();
    $pdo_salaberga = $database->getSalabergaConnection();
    
    $demanda = new Demanda($pdo);
    $usuarioModel = new Usuario($pdo_salaberga);
} catch (Exception $e) {
    error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
    redirecionar('error', 'Erro de conexão com o banco de dados');
}

// Determinar a ação (pode vir de POST['acao'] ou GET['action'])
$acao = $_POST['acao'] ?? $_GET['action'] ?? null;

// Tratamento de requisições GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $acao) {
    switch ($acao) {
        case 'get_demanda':
            if (!isset($_GET['id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID não fornecido']);
                exit;
            }

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
            $usuario_id = verificarSessao();
            if (!isset($_GET['id'])) {
                redirecionar('admin', 'ID não fornecido');
            }
            $sucesso = $demanda->excluirDemanda($_GET['id']);
            redirecionar('admin', $sucesso ? 'Demanda excluída com sucesso!' : 'Erro ao excluir demanda', $sucesso ? 'success' : 'error');
            break;
    }
}

// Tratamento de requisições POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $acao) {
    $usuario_id = verificarSessao();
    
    switch ($acao) {
        case 'criar':
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $prioridade = $_POST['prioridade'] ?? 'media';
            $usuarios_ids = isset($_POST['usuarios_ids']) ? (is_array($_POST['usuarios_ids']) ? $_POST['usuarios_ids'] : [$_POST['usuarios_ids']]) : [];
            $prazo = $_POST['prazo'] ?? null;
            $area_id = $_POST['area_id'] ?? null;

            if (empty($titulo) || empty($descricao)) {
                redirecionar('admin', 'Por favor, preencha título e descrição');
            }

            if (empty($area_id) || !in_array((int)$area_id, [1, 2, 3])) {
                redirecionar('admin', 'Selecione uma área válida');
            }

            try {
                $sucesso = $demanda->criarDemanda($titulo, $descricao, $prioridade, $usuario_id, $usuarios_ids, $prazo, $area_id, $usuarioModel);
                redirecionar('admin', 'Demanda criada com sucesso!', 'success');
            } catch (Exception $e) {
                error_log('ERRO NO CONTROLLER: ' . $e->getMessage());
                redirecionar('admin', $e->getMessage());
            }
            break;

        case 'atualizar_demanda':
            if (!isset($_POST['id'])) {
                redirecionar('admin', 'ID não fornecido');
            }

            $id = $_POST['id'];
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $prioridade = $_POST['prioridade'] ?? 'media';
            $prazo = $_POST['prazo'] ?? null;

            if (empty($titulo) || empty($descricao)) {
                redirecionar('admin', 'Por favor, preencha título e descrição');
            }

            $sucesso = $demanda->atualizarDemanda($id, $titulo, $descricao, $prioridade, null, [], $prazo);
            redirecionar('admin', $sucesso ? 'Demanda atualizada com sucesso!' : 'Erro ao atualizar demanda', $sucesso ? 'success' : 'error');
            break;

        case 'aceitar_demanda':
            if (!isset($_POST['id'])) {
                redirecionar('usuario', 'ID não fornecido');
            }

            $sucesso = $demanda->aceitarDemanda($_POST['id'], $usuario_id);
            redirecionar('usuario', $sucesso ? 'Demanda aceita com sucesso!' : 'Erro ao aceitar demanda', $sucesso ? 'success' : 'error');
            break;

        case 'recusar_demanda':
            if (!isset($_POST['id'])) {
                redirecionar('usuario', 'ID não fornecido');
            }

            $sucesso = $demanda->recusarDemanda($_POST['id'], $usuario_id);
            redirecionar('usuario', $sucesso ? 'Demanda recusada com sucesso!' : 'Erro ao recusar demanda', $sucesso ? 'success' : 'error');
            break;

        case 'atualizar_status':
            error_log("\n=== INÍCIO DO PROCESSAMENTO DE ATUALIZAR_STATUS ===");
            error_log("POST data: " . print_r($_POST, true));
            error_log("Usuário ID: " . $usuario_id);
            
            // Limpar qualquer saída anterior
            ob_clean();
            
            // Garantir que a resposta será JSON
            header('Content-Type: application/json; charset=utf-8');
            
            if (!isset($_POST['id']) || !isset($_POST['novo_status'])) {
                error_log("Parâmetros ausentes - id: " . (isset($_POST['id']) ? $_POST['id'] : 'não definido') . 
                         ", novo_status: " . (isset($_POST['novo_status']) ? $_POST['novo_status'] : 'não definido'));
                echo json_encode(['success' => false, 'error' => 'Parâmetros ausentes']);
                exit;
            }
            
            $demandaId = intval($_POST['id']);
            $novoStatus = $_POST['novo_status'];
            $usuarioId = intval($_SESSION['user_id']);
            
            error_log("Dados recebidos - Demanda ID: $demandaId, Novo Status: $novoStatus, Usuário ID: $usuarioId");
            
            // Validar status
            if (!in_array($novoStatus, ['em_andamento', 'concluida'])) {
                error_log("Status inválido: $novoStatus");
                echo json_encode(['success' => false, 'error' => 'Status inválido']);
                exit;
            }
            
            try {
                // Verificar se a demanda existe
                $demandaAtual = $demanda->buscarDemanda($demandaId);
                if (!$demandaAtual) {
                    error_log("Demanda não encontrada - ID: $demandaId");
                    echo json_encode(['success' => false, 'error' => 'Demanda não encontrada']);
                    exit;
                }
                
                error_log("Demanda encontrada - Status atual: " . $demandaAtual['status']);
                
                // Verificar se o usuário tem permissão para atualizar o status
                $temPermissao = $demanda->verificarPermissaoUsuario($demandaId, $usuarioId);
                error_log("Resultado da verificação de permissão: " . ($temPermissao ? 'tem permissão' : 'sem permissão'));
                
                if (!$temPermissao) {
                    error_log("Usuário não tem permissão para atualizar esta demanda");
                    echo json_encode(['success' => false, 'error' => 'Sem permissão para atualizar esta demanda']);
                    exit;
                }
                
                if ($novoStatus === 'em_andamento') {
                    error_log("Chamando marcarEmAndamento");
                    $resultado = $demanda->marcarEmAndamento($demandaId, $usuarioId);
                } elseif ($novoStatus === 'concluida') {
                    error_log("Chamando marcarConcluida");
                    $resultado = $demanda->marcarConcluida($demandaId, $usuarioId);
                }
                
                error_log("Resultado da operação: " . ($resultado ? 'sucesso' : 'falha'));
                
                if ($resultado) {
                    echo json_encode(['success' => true, 'message' => 'Status atualizado com sucesso']);
                } else {
                    error_log("Erro ao atualizar status - Operação retornou false");
                    echo json_encode(['success' => false, 'error' => 'Erro ao atualizar status']);
                }
            } catch (Exception $e) {
                error_log("Exceção ao atualizar status: " . $e->getMessage());
                error_log("Stack trace: " . $e->getTraceAsString());
                echo json_encode(['success' => false, 'error' => 'Erro ao atualizar status: ' . $e->getMessage()]);
            }
            exit;
            break;

        case 'realizar_tarefa':
            if (!isset($_POST['id']) || !isset($_POST['novo_status'])) {
                redirecionar('usuario', 'Parâmetros inválidos');
            }

            $sucesso = false;
            if ($_POST['novo_status'] === 'em_andamento') {
                $sucesso = $demanda->marcarEmAndamento($_POST['id'], $usuario_id);
            } elseif ($_POST['novo_status'] === 'concluida') {
                $sucesso = $demanda->marcarConcluida($_POST['id'], $usuario_id);
            }

            redirecionar('usuario', $sucesso ? 'Status atualizado com sucesso!' : 'Erro ao atualizar status', $sucesso ? 'success' : 'error');
            break;

        case 'criar_teste':
            error_log("Iniciando criação de demanda de teste via controlador");
            try {
                $demanda_id = $demanda->criarDemandaTeste();
                error_log("Demanda de teste criada com sucesso. ID: " . $demanda_id);
                header('Location: ' . BASE_URL . '?subsystem=AreaDev&action=usuario');
                exit;
            } catch (Exception $e) {
                error_log("Erro ao criar demanda de teste: " . $e->getMessage());
                error_log("Stack trace: " . $e->getTraceAsString());
                header('Location: ' . BASE_URL . '?subsystem=AreaDev&action=usuario&error=Erro ao criar demanda de teste');
                exit;
            }
            break;

        default:
            error_log("Ação não reconhecida: " . $acao);
            redirecionar('error', 'Ação não reconhecida: ' . $acao);
            break;
    }
}

// Se chegou aqui, é uma requisição inválida
error_log("Requisição inválida - Sem ação definida");
redirecionar('error', 'Requisição inválida - Sem ação definida'); 