<?php
require_once '../model/InscricaoModel.php';
require_once '../model/AdminModel.php';
require_once '../model/EquipeModel.php';

class AdminController {
    private $inscricaoModel;
    private $adminModel;
    private $equipeModel;

    public function __construct() {
        error_log("Iniciando AdminController");
        try {
        $this->inscricaoModel = new InscricaoModel();
        $this->adminModel = new AdminModel();
            $this->equipeModel = new EquipeModel();
        
        // Iniciar sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
            error_log("AdminController iniciado com sucesso");
        } catch (Exception $e) {
            error_log("Erro ao inicializar AdminController: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lista todas as equipes com seus membros
     */
    public function listarEquipes() {
        $this->verificarAutenticacao();
        
        header('Content-Type: application/json');
        $resultado = $this->equipeModel->listarTodasEquipes();
        echo json_encode($resultado);
    }

    /**
     * Atualiza o status de uma equipe inteira
     */
    public function atualizarStatusEquipe() {
        error_log("=== Início atualizarStatusEquipe ===");
        
        try {
            // Verificar autenticação
            if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
                error_log("Usuário não autenticado");
                echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
                exit;
            }
            
            // Limpar qualquer saída anterior
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            header('Content-Type: application/json; charset=utf-8');
            
            error_log("Método da requisição: " . $_SERVER['REQUEST_METHOD']);
            error_log("POST data: " . print_r($_POST, true));
            
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                error_log("Método não permitido: " . $_SERVER['REQUEST_METHOD']);
                echo json_encode(['success' => false, 'message' => 'Método não permitido']);
                exit;
            }

            $equipeId = $_POST['equipe_id'] ?? '';
            $status = $_POST['status'] ?? '';
            
            error_log("Dados recebidos - equipeId: $equipeId, status: $status");
            
            if (empty($equipeId) || empty($status)) {
                error_log("Campos obrigatórios não fornecidos");
                echo json_encode(['success' => false, 'message' => 'Campos obrigatórios não fornecidos']);
                exit;
            }
            
            // Verificar se o InscricaoModel está disponível
            if (!isset($this->inscricaoModel)) {
                error_log("InscricaoModel não está disponível");
                throw new Exception('Erro de conexão com o banco de dados');
            }
            
            // Usar o novo método do InscricaoModel
            $resultado = $this->inscricaoModel->atualizarStatusEquipeCompleta($equipeId, $status);
            error_log("Resultado da atualização: " . print_r($resultado, true));
            
            echo json_encode($resultado);
            
        } catch (Exception $e) {
            error_log("Exceção: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao atualizar status: ' . $e->getMessage()
            ]);
        }
        
        error_log("=== Fim atualizarStatusEquipe ===");
        exit;
    }

    /**
     * Processa o login do admin
     */
    public function login() {
        // Garantir que a sessão está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        error_log("AdminController::login - Método chamado");
        error_log("Método da requisição: " . $_SERVER['REQUEST_METHOD']);
        
        // Limpar qualquer sessão existente
        session_unset();
        
        // Debug dos dados recebidos
        error_log("POST: " . print_r($_POST, true));
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            return;
        }

        $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
        $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';
        
        error_log("Tentativa de login: Usuário=$usuario");
        
        // Valida dados de entrada
        if (empty($usuario) || empty($senha)) {
            echo json_encode([
                'success' => false, 
                'message' => 'Por favor, preencha todos os campos',
                'error_type' => 'campos_vazios'
            ]);
            return;
        }
        
        // Verifica as credenciais
        $resultado = $this->adminModel->verificarAdmin($usuario, $senha);
        
        error_log("Resultado da verificação: " . print_r($resultado, true));
        
        if ($resultado['success']) {
            // Regenerar ID da sessão por segurança
            session_regenerate_id(true);
            
            // Armazena informações na sessão
            $_SESSION['admin_logado'] = true;
            $_SESSION['admin_id'] = $resultado['admin']['id'];
            $_SESSION['admin_nome'] = $resultado['admin']['nome'];
            $_SESSION['admin_usuario'] = $resultado['admin']['usuario'];
            
            error_log("Login realizado com sucesso para: $usuario");
            error_log("Sessão atual: " . print_r($_SESSION, true));
            
            // Adicionar flag de redirecionamento na resposta
            $resultado['redirect'] = 'inscricoes.php';
        } else {
            // Adicionar mensagem de erro mais específica
            $resultado['message'] = 'Credenciais inválidas. Por favor, verifique seu usuário e senha.';
            $resultado['error_type'] = 'credenciais_invalidas';
        }
        
        echo json_encode($resultado);
    }

    /**
     * Realiza o logout do admin
     */
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: login.php');
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

    /**
     * Verifica se o admin está autenticado
     */
    private function verificarAutenticacao() {
        if (!isset($_SESSION['admin_id']) || 
            !isset($_SESSION['admin_logado']) || 
            $_SESSION['admin_logado'] !== true || 
            !isset($_SESSION['admin_usuario'])) {
            
            // Limpar a sessão por segurança
            session_unset();
            session_destroy();
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false, 
                'message' => 'Acesso não autorizado',
                'redirect' => 'login.php'
            ]);
            exit;
        }
    }
}

// Se chamado diretamente, determina qual método executar
if (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) {
    $controller = new AdminController();
    
    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    
    switch ($action) {
        case 'login':
            $controller->login();
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'listar-equipes':
            $controller->listarEquipes();
            break;
        case 'atualizar-status-equipe':
            $controller->atualizarStatusEquipe();
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