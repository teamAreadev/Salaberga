<?php
require_once '../model/UsuarioModel.php';

class UsuarioController {
    private $model;

    public function __construct() {
        $this->model = new UsuarioModel();
        
        // Iniciar sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Processa o login do usuário
     */
    public function login() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            return;
        }

        $email = $_POST['email'] ?? '';
        $nome = $_POST['nome'] ?? '';
        
        // Valida dados de entrada
        if (empty($email) || empty($nome)) {
            echo json_encode(['success' => false, 'message' => 'Email e nome são obrigatórios']);
            return;
        }
        
        // Verifica as credenciais
        $resultado = $this->model->verificarUsuario($email, $nome);
        
        if ($resultado['success']) {
            // Armazena informações na sessão
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_id'] = $resultado['aluno']['id'];
            $_SESSION['usuario_nome'] = $resultado['aluno']['nome'];
            $_SESSION['usuario_email'] = $resultado['aluno']['email'];
            $_SESSION['usuario_telefone'] = $resultado['aluno']['telefone'];
            $_SESSION['usuario_ano'] = $resultado['aluno']['ano'];
            $_SESSION['usuario_turma'] = $resultado['aluno']['turma'];
            $_SESSION['usuario_inscricoes'] = $resultado['inscricoes'];
        }
        
        echo json_encode($resultado);
    }

    /**
     * Realiza o logout do usuário
     */
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ../usuario/login.php');
        exit;
    }

    /**
     * Obtém os dados do usuário atual
     * @return array Dados do usuário
     */
    public function dadosUsuario() {
        $this->verificarAutenticacao();
        
        header('Content-Type: application/json');
        
        $alunoId = $_SESSION['usuario_id'] ?? 0;
        $resultado = $this->model->obterDadosUsuario($alunoId);
        
        echo json_encode($resultado);
    }

    /**
     * Verifica se o usuário está autenticado
     */
    private function verificarAutenticacao() {
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false, 
                'message' => 'Acesso não autorizado',
                'redirect' => '../usuario/login.php'
            ]);
            exit;
        }
    }

    /**
     * Cadastra um novo usuário
     */
    public function cadastrar() {
        header('Content-Type: application/json');
        
        try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            return;
        }

        // Validar dados obrigatórios
        $campos = ['nome', 'email', 'telefone', 'ano', 'turma'];
        $dados = [];
        
        foreach ($campos as $campo) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios']);
                return;
            }
            $dados[$campo] = $_POST[$campo];
        }
        
        // Validar email
        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Email inválido']);
            return;
        }
        
        // Cadastrar usuário
        $resultado = $this->model->cadastrarUsuario($dados);
        echo json_encode($resultado);
            
        } catch (Exception $e) {
            error_log("Erro no cadastro de usuário: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Erro interno do servidor ao processar o cadastro'
            ]);
        }
    }
}

// Se chamado diretamente, determina qual método executar
if (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) {
    try {
    $controller = new UsuarioController();
    
    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    
    switch ($action) {
        case 'cadastrar':
            $controller->cadastrar();
            break;
        case 'login':
            $controller->login();
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'dados':
            $controller->dadosUsuario();
            break;
        default:
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Ação não reconhecida']);
            break;
        }
    } catch (Exception $e) {
        error_log("Erro ao processar requisição: " . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Erro interno do servidor'
        ]);
    }
}
?> 