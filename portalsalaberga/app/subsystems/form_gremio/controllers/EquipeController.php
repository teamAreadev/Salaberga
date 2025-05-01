<?php
session_start();
require_once '../model/EquipeModel.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['aluno_id'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Usuário não autenticado'
    ]);
    exit();
}

$equipeModel = new EquipeModel();
$response = [];

// Verificar a ação solicitada
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    switch ($action) {
        case 'criarEquipe':
            // Validar campos
            if (empty($_POST['nome']) || empty($_POST['modalidade']) || empty($_POST['categoria'])) {
                $response = [
                    'success' => false,
                    'message' => 'Todos os campos são obrigatórios'
                ];
                break;
            }
            
            // Dados da equipe
            $dados = [
                'nome' => $_POST['nome'],
                'modalidade' => $_POST['modalidade'],
                'categoria' => $_POST['categoria'],
                'aluno_id' => $_SESSION['aluno_id'] // Líder da equipe
            ];
            
            // Criar equipe
            $result = $equipeModel->criarEquipe($dados);
            $response = $result;
            break;
            
        case 'entrarEquipe':
            // Validar campos
            if (empty($_POST['codigo'])) {
                $response = [
                    'success' => false,
                    'message' => 'Código da equipe é obrigatório'
                ];
                break;
            }
            
            // Entrar na equipe
            $result = $equipeModel->entrarEquipe($_SESSION['aluno_id'], $_POST['codigo']);
            $response = $result;
            break;
            
        case 'listarEquipes':
            // Listar equipes do usuário
            $result = $equipeModel->listarEquipesUsuario($_SESSION['aluno_id']);
            $response = $result;
            break;
            
        case 'listarMembros':
            // Validar campos
            if (empty($_POST['equipe_id'])) {
                $response = [
                    'success' => false,
                    'message' => 'ID da equipe é obrigatório'
                ];
                break;
            }
            
            // Listar membros da equipe
            $result = $equipeModel->listarMembrosEquipe($_POST['equipe_id']);
            $response = $result;
            break;
            
        case 'sairEquipe':
            // Validar campos
            if (empty($_POST['equipe_id'])) {
                $response = [
                    'success' => false,
                    'message' => 'ID da equipe é obrigatório'
                ];
                break;
            }
            
            // Sair da equipe
            $result = $equipeModel->sairEquipe($_SESSION['aluno_id'], $_POST['equipe_id']);
            $response = $result;
            break;
            
        case 'calcularValor':
            // Validar campos
            if (empty($_POST['equipe_id'])) {
                $response = [
                    'success' => false,
                    'message' => 'ID da equipe é obrigatório'
                ];
                break;
            }
            
            // Verificar se o usuário é o líder da equipe
            $equipes = $equipeModel->listarEquipesUsuario($_SESSION['aluno_id']);
            
            if (!$equipes['success']) {
                $response = $equipes;
                break;
            }
            
            $isLider = false;
            foreach ($equipes['equipes'] as $equipe) {
                if ($equipe['id'] == $_POST['equipe_id'] && $equipe['is_lider']) {
                    $isLider = true;
                    break;
                }
            }
            
            if (!$isLider) {
                $response = [
                    'success' => false,
                    'message' => 'Apenas o líder da equipe pode calcular o valor'
                ];
                break;
            }
            
            // Calcular valor da inscrição
            $result = $equipeModel->calcularValorInscricao($_POST['equipe_id']);
            $response = $result;
            break;
            
        default:
            $response = [
                'success' => false,
                'message' => 'Ação inválida'
            ];
            break;
    }
}

// Retornar resposta em JSON
header('Content-Type: application/json');
echo json_encode($response);
?> 