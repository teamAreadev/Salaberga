<?php

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

        if ($demanda_data) {
            $response = [
                'id' => $demanda_data['id'],
                'titulo' => $demanda_data['titulo'],
                'descricao' => $demanda_data['descricao'],
                'prioridade' => $demanda_data['prioridade'],
                'status' => $demanda_data['status'],
                'usuario_id' => $demanda_data['usuario_id'],
                'admin_id' => $demanda_data['admin_id']
            ];
            
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            exit();
        } else {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => 'Demanda não encontrada.']);
            exit();
        }
    } elseif ($_GET['action'] === 'excluir' && isset($_GET['id'])) {
        $demanda->excluirDemanda($_GET['id']);
        header("Location: ../views/admin.php");
        exit();
    }
}

// Tratamento de requisições POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] === 'criar') {
        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $prioridade = $_POST['prioridade'] ?? 'media';
        $usuario_id = $_POST['usuario_id'] ?? null;

        if (empty($titulo) || empty($descricao)) {
            header("Location: ../views/admin.php?error=Por favor, preencha título e descrição.");
            exit();
        }

        $admin_id = $_SESSION['usuario_id'];
        $sucesso = $demanda->criarDemanda($titulo, $descricao, $prioridade, $admin_id, $usuario_id);

        if ($sucesso) {
            header("Location: ../views/admin.php?success=Demanda criada com sucesso!");
        } else {
            header("Location: ../views/admin.php?error=Erro ao criar demanda.");
        }
        exit();
    } elseif ($_POST['acao'] === 'atualizar_demanda' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $prioridade = $_POST['prioridade'] ?? 'media';
        $status = $_POST['status'] ?? 'pendente';
        $usuario_id = $_POST['usuario_id'] ?? null;

        if (empty($titulo) || empty($descricao)) {
            header("Location: ../views/admin.php?error=Por favor, preencha título e descrição.");
            exit();
        }

        $sucesso = $demanda->atualizarDemanda($id, $titulo, $descricao, $prioridade, $status, $usuario_id);
        
        if ($sucesso) {
            header("Location: ../views/admin.php?success=Demanda atualizada com sucesso!");
        } else {
            header("Location: ../views/admin.php?error=Erro ao atualizar demanda.");
        }
        exit();
    } elseif ($_POST['acao'] === 'atualizar_status' && isset($_POST['id']) && isset($_POST['novo_status'])) {
        $id_demanda = $_POST['id'];
        $novo_status = $_POST['novo_status'];

        if (!$demanda->verificarPermissaoUsuario($id_demanda, $_SESSION['usuario_id'])) {
            header("Location: " . (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin' ? '../views/admin.php' : '../views/usuario.php') . "?error=Você não tem permissão para alterar o status desta demanda.");
            exit();
        }

        $sucesso = false;
        if ($novo_status === 'concluida') {
            $sucesso = $demanda->marcarConcluida($id_demanda);
        } elseif ($novo_status === 'em_andamento') {
            $sucesso = $demanda->marcarEmAndamento($id_demanda);
        }

        if ($sucesso) {
            header("Location: " . (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin' ? '../views/admin.php' : '../views/usuario.php') . "?success=Status atualizado com sucesso!");
        } else {
            header("Location: " . (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin' ? '../views/admin.php' : '../views/usuario.php') . "?error=Erro ao atualizar status.");
        }
        exit();
    }
}

// Redirecionamento padrão
header("Location: ../views/admin.php");
exit();

?> 