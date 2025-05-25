<?php

ob_start(); // Iniciar buffering de saída para capturar qualquer saída inesperada

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Demanda.php';

session_start();

// Inicializa a conexão com o banco de dados
$database = new Database();
$pdo = $database->getConnection();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit();
}

$demanda = new Demanda($pdo);

// Tratamento de requisições GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] === 'get_demanda' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $demanda_data = $demanda->buscarDemanda($id);

        // Capturar qualquer saída inesperada antes de enviar o JSON
        $unexpected_output = ob_get_clean();
        ob_start(); // Reiniciar o buffer para a saída JSON

        if ($demanda_data) {
            $response = [
                'id' => $demanda_data['id'],
                'titulo' => $demanda_data['titulo'],
                'descricao' => $demanda_data['descricao'],
                'prioridade' => $demanda_data['prioridade'],
                'status' => $demanda_data['status'],
                'admin_id' => $demanda_data['admin_id'],
                'usuarios_atribuidos' => $demanda_data['usuarios_atribuidos'] ?? []
            ];

            // Se houver saída inesperada, adicione ao JSON de sucesso (para não perder a info)
             if (!empty($unexpected_output)) {
                 $response['debug_output'] = $unexpected_output;
             }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            exit(); // Termina a execução após enviar JSON
        } else {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(404);
            $error_response = ['error' => 'Demanda não encontrada.'];
            
            // Se houver saída inesperada, adicione ao JSON de erro
            if (!empty($unexpected_output)) {
                $error_response['debug_output'] = $unexpected_output;
            }

            echo json_encode($error_response);
            exit(); // Termina a execução após enviar JSON
        }
    } elseif ($_GET['action'] === 'excluir' && isset($_GET['id'])) {
        $demanda->excluirDemanda($_GET['id']);
        header("Location: ../views/admin.php");
        exit();
    }
}

// Tratamento de requisições POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    switch ($_POST['acao']) {
        case 'criar':
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $prioridade = $_POST['prioridade'] ?? 'media';
            $usuarios_ids = isset($_POST['usuarios_ids']) ? (is_array($_POST['usuarios_ids']) ? $_POST['usuarios_ids'] : [$_POST['usuarios_ids']]) : [];

            if (empty($titulo) || empty($descricao)) {
                header("Location: ../views/admin.php?error=Por favor, preencha título e descrição.");
                exit();
            }

            $admin_id = $_SESSION['usuario_id'];
            $sucesso = $demanda->criarDemanda($titulo, $descricao, $prioridade, $admin_id, $usuarios_ids);

            if ($sucesso) {
                header("Location: ../views/admin.php?success=Demanda criada com sucesso!");
            } else {
                header("Location: ../views/admin.php?error=Erro ao criar demanda.");
            }
            exit();
        case 'atualizar_demanda':
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $titulo = $_POST['titulo'] ?? '';
                $descricao = $_POST['descricao'] ?? '';
                $prioridade = $_POST['prioridade'] ?? 'media';
                $status = $_POST['status'] ?? 'pendente';
                $usuarios_ids = isset($_POST['usuarios_ids']) ? (is_array($_POST['usuarios_ids']) ? $_POST['usuarios_ids'] : [$_POST['usuarios_ids']]) : [];

                if (empty($titulo) || empty($descricao)) {
                    header("Location: ../views/admin.php?error=Por favor, preencha título e descrição.");
                    exit();
                }

                $sucesso = $demanda->atualizarDemanda($id, $titulo, $descricao, $prioridade, $status, $usuarios_ids);
                
                if ($sucesso) {
                    header("Location: ../views/admin.php?success=Demanda atualizada com sucesso!");
                } else {
                    header("Location: ../views/admin.php?error=Erro ao atualizar demanda.");
                }
                exit();
            }
            break;
        case 'atualizar_status':
            if (isset($_POST['id']) && isset($_POST['novo_status'])) {
                $demanda = new Demanda($pdo);
                if ($_POST['novo_status'] === 'em_andamento') {
                    $demanda->marcarEmAndamento($_POST['id'], $_POST['usuario_id'] ?? $_SESSION['usuario_id']);
                } elseif ($_POST['novo_status'] === 'concluida') {
                    $demanda->marcarConcluida($_POST['id'], $_POST['usuario_id'] ?? $_SESSION['usuario_id']);
                }
                
                // Redireciona para a página correta baseado no tipo de usuário
                if ($_SESSION['usuario_tipo'] === 'admin') {
                    header("Location: ../views/admin.php");
                } else {
                    header("Location: ../views/usuario.php");
                }
                exit();
            }
            break;
    }
}

// Redirecionamento padrão
header("Location: ../views/admin.php");
exit(); 