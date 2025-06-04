<?php
session_start();

error_log("\n=== DEBUG BRUTO DA REQUISIÇÃO (update_status.php) ===");
error_log("SERVER: " . print_r($_SERVER, true));
error_log("REQUEST: " . print_r($_REQUEST, true));
error_log("=======================================================\n");

require_once __DIR__ . '/../../../main/config/Database.php';
require_once __DIR__ . '/../model/Demanda.php';

header('Content-Type: application/json; charset=utf-8');

try {
    error_log("\n=== INÍCIO DO PROCESSAMENTO DE UPDATE_STATUS (update_status.php) ===");
    error_log("Método da requisição: " . $_SERVER['REQUEST_METHOD']);
    error_log("Content-Type: " . ($_SERVER['CONTENT_TYPE'] ?? 'não definido'));
    error_log("Dados POST recebidos (update_status.php): " . print_r($_POST, true));
    error_log("Dados GET recebidos (update_status.php): " . print_r($_GET, true));
    error_log("Dados da sessão (update_status.php): " . print_r($_SESSION, true));
    error_log("Headers recebidos (update_status.php): " . print_r(getallheaders(), true));
    error_log("Raw input (update_status.php): " . file_get_contents('php://input'));

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        error_log("Erro (update_status.php): Método não permitido. Recebido: " . $_SERVER['REQUEST_METHOD']);
        throw new Exception('Método não permitido. Use POST.');
    }

    if (!isset($_POST['id']) || !isset($_POST['novo_status'])) {
        error_log("Erro (update_status.php): Parâmetros inválidos. POST data: " . print_r($_POST, true));
        throw new Exception('Parâmetros inválidos. ID e novo_status são obrigatórios.');
    }

    $demandaId = intval($_POST['id']);
    $novoStatus = $_POST['novo_status'];
    $usuarioId = $_SESSION['user_id'] ?? null;

    if (!$usuarioId) {
        error_log("Erro (update_status.php): Usuário não autenticado. Sessão: " . print_r($_SESSION, true));
        throw new Exception('Usuário não autenticado');
    }

    error_log("Dados processados (update_status.php) - Demanda ID: $demandaId, Novo Status: $novoStatus, Usuário ID: $usuarioId");

    $conexao = Database::getAreadevConnection();
    $demandaModel = new Demanda($conexao);

    error_log("Chamando método do modelo em update_status.php com Demanda ID: $demandaId, Novo Status: $novoStatus, Usuário ID: $usuarioId");

    $resultado = false;
    if ($novoStatus === 'concluida') {
        error_log("Tentando chamar marcarConcluida (update_status.php)");
        $resultado = $demandaModel->marcarConcluida($demandaId, $usuarioId);
    } else if ($novoStatus === 'em_andamento') {
        error_log("Tentando chamar marcarEmAndamento (update_status.php)");
        $resultado = $demandaModel->marcarEmAndamento($demandaId, $usuarioId);
    } else {
        error_log("Erro (update_status.php): Status inválido: " . $novoStatus);
        throw new Exception('Status inválido: ' . $novoStatus);
    }
    
    error_log("Resultado retornado pelo modelo (update_status.php): " . ($resultado ? 'true' : 'false'));

    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Status atualizado com sucesso']);
    } else {
        error_log("Modelo retornou false para a operação de status.");
        throw new Exception('Erro ao atualizar status');
    }
    
} catch (Exception $e) {
    error_log("Erro capturado (update_status.php): " . $e->getMessage());
    error_log("Stack trace (update_status.php): " . $e->getTraceAsString());
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    error_log("=== FIM DO PROCESSAMENTO DE UPDATE_STATUS (update_status.php) ===\n");
} 