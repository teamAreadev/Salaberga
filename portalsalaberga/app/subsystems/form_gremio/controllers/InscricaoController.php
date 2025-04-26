<?php
require_once '../model/InscricaoModel.php';

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
}

// Instancia e executa o controller
$controller = new InscricaoController();

// Determina qual ação executar
$action = isset($_GET['action']) ? $_GET['action'] : 'cadastrar';

switch ($action) {
    case 'verificar':
        $controller->verificarStatusInscricao();
        break;
    case 'cadastrar':
    default:
        $controller->processarInscricao();
        break;
}
?>