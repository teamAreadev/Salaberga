<?php
// Desativar exibição de erros no output
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json; charset=utf8');

require_once '../model/model_indexClass.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    http_response_code(403);
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

try {
    $model = new SaidaEstagioModel();
    $registros = $model->getSaidasByDateRange($id_aluno, $startDate = null, $endDate = null); // Busca todos os registros
    echo json_encode($registros ?: []);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar registros: ' . $e->getMessage()]);
}
?>