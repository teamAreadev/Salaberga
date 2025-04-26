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

    public function loginUsuario() {
        $email = $_POST['email'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        if (empty($email) || empty($telefone)) {
            echo json_encode(['success' => false, 'message' => 'Preencha todos os campos.']);
            return;
        }
        $model = new InscricaoModel();
        $usuario = $model->buscarPorEmailTelefone($email, $telefone);
        if ($usuario) {
            session_start();
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_id'] = $usuario['id'];
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Dados não encontrados.']);
        }
    }

    public function infoInscricao() {
        session_start();
        if (!isset($_SESSION['usuario_logado']) || !$_SESSION['usuario_id']) {
            echo json_encode(['success' => false, 'message' => 'Não autenticado.']);
            return;
        }
        $model = new InscricaoModel();
        $info = $model->buscarPorId($_SESSION['usuario_id']);
        if ($info) {
            // Ajustar para retornar array de nomes das modalidades
            $modalidades = array_map(function($m) {
                return $m['modalidade'];
            }, $info['modalidades']);
            $info['modalidades'] = $modalidades;
            echo json_encode(['success' => true, 'data' => $info]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Inscrição não encontrada.']);
        }
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
    case 'loginUsuario':
        $controller->loginUsuario();
        break;
    case 'infoInscricao':
        $controller->infoInscricao();
        break;
    case 'cadastrar':
    default:
        $controller->processarInscricao();
        break;
}
?>