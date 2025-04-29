<?php
require_once '../model/InscricaoModel.php';
require_once '../model/AdminModel.php';

class AdminController {
    private $inscricaoModel;
    private $adminModel;

    public function __construct() {
        $this->inscricaoModel = new InscricaoModel();
        $this->adminModel = new AdminModel();
        
        // Iniciar sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function realizarLogin() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            return;
        }

        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        $resultado = $this->adminModel->verificarCredenciais($usuario, $senha);
        
        if ($resultado['success']) {
            $_SESSION['admin_logado'] = true;
            $_SESSION['admin_id'] = $resultado['admin_id'];
            $_SESSION['admin_nome'] = $resultado['admin_nome'];
        }
        
        echo json_encode($resultado);
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ../admin/login.php');
        exit;
    }

    public function obterTodasInscricoes() {
        $this->verificarAutenticacao();
        
        $inscricoes = $this->inscricaoModel->obterTodasInscricoes();
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'inscricoes' => $inscricoes]);
    }

    public function obterInscricaoPorId() {
        $this->verificarAutenticacao();
        
        header('Content-Type: application/json');
        
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID não fornecido']);
            return;
        }
        
        $alunoId = $_GET['id'];
        $resultado = $this->inscricaoModel->obterInscricaoPorId($alunoId);
        
        echo json_encode($resultado);
    }

    public function atualizarStatusInscricao() {
        $this->verificarAutenticacao();
        
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            return;
        }

        $inscricaoId = $_POST['inscricao_id'] ?? '';
        $status = $_POST['status'] ?? '';
        
        if (empty($inscricaoId) || empty($status)) {
            echo json_encode(['success' => false, 'message' => 'Campos obrigatórios não fornecidos']);
            return;
        }
        
        $resultado = $this->inscricaoModel->atualizarStatusInscricao($inscricaoId, $status);
        
        echo json_encode($resultado);
    }

    private function verificarAutenticacao() {
        if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false, 
                'message' => 'Acesso não autorizado',
                'redirect' => '../admin/login.php'
            ]);
            exit;
        }
    }
}

// Se chamado diretamente, determina qual método executar
if (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) {
    $controller = new AdminController();
    
    $action = $_GET['action'] ?? '';
    
    switch ($action) {
        case 'login':
            $controller->realizarLogin();
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'listar-inscricoes':
            $controller->obterTodasInscricoes();
            break;
        case 'obter-inscricao':
            $controller->obterInscricaoPorId();
            break;
        case 'atualizar-status':
            $controller->atualizarStatusInscricao();
            break;
        default:
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Ação não reconhecida']);
            break;
    }
}
?> 