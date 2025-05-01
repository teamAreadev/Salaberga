<?php
session_start();
require_once '../model/InscricaoModel.php';

// Verificar se há uma ação AJAX (inscrição individual do dashboard)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'inscricaoIndividual') {
    if (!isset($_SESSION['aluno_id'])) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Usuário não autenticado'
        ]);
        exit();
    }
    
    // Validar campos
    if (empty($_POST['modalidade']) || empty($_POST['categoria'])) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Todos os campos são obrigatórios'
        ]);
        exit();
    }
    
    $inscricaoModel = new InscricaoModel();
    
    // Dados da inscrição individual
    $dados = [
        'aluno_id' => $_SESSION['aluno_id'],
        'modalidade' => $_POST['modalidade'],
        'categoria' => $_POST['categoria']
    ];
    
    // Realizar inscrição individual
    $resultado = $inscricaoModel->cadastrarInscricaoIndividual($dados);
    
    header('Content-Type: application/json');
    echo json_encode($resultado);
    exit();
}

// Classe controladora para as requisições normais
class InscricaoController {
    private $model;

    public function __construct() {
        $this->model = new InscricaoModel();
    }

    public function processarInscricao() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            return;
        }

        $dados = $_POST;
        $resultado = $this->model->cadastrarInscricao($dados);
        
        echo json_encode($resultado);
    }
    
    public function verificarStatusInscricao() {
        header('Content-Type: application/json');
        
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID da inscrição não fornecido']);
            return;
        }
        
        $alunoId = $_GET['id'];
        $resultado = $this->model->verificarStatusInscricao($alunoId);
        
        echo json_encode($resultado);
    }
    
    public function cancelarInscricao() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            return;
        }
        
        if (!isset($_POST['inscricao_id']) || empty($_POST['inscricao_id'])) {
            echo json_encode(['success' => false, 'message' => 'ID da inscrição não fornecido']);
            return;
        }
        
        $inscricaoId = $_POST['inscricao_id'];
        $resultado = $this->model->cancelarInscricao($inscricaoId);
        
        echo json_encode($resultado);
    }
}

// Se não for uma solicitação AJAX do dashboard, processa como inscrição normal
if (!isset($_POST['action']) || $_POST['action'] !== 'inscricaoIndividual') {
    // Instancia e executa o controller
    $controller = new InscricaoController();

    // Determina qual ação executar
    $action = isset($_GET['action']) ? $_GET['action'] : 'cadastrar';

    switch ($action) {
        case 'verificar':
            $controller->verificarStatusInscricao();
            break;
        case 'cancelar':
            $controller->cancelarInscricao();
            break;
        case 'cadastrar':
        default:
            $controller->processarInscricao();
            break;
    }
}
?>