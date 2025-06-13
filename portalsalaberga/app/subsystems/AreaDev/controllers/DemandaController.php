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
    switch ($_GET['action']) {
        case 'get_demanda':
            if (!isset($_GET['id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID não fornecido']);
                exit;
            }

            $demanda = new Demanda($pdo);
            $dados = $demanda->buscarDemanda($_GET['id']);

            if (!$dados) {
                http_response_code(404);
                echo json_encode(['error' => 'Demanda não encontrada']);
                exit;
            }

            header('Content-Type: application/json');
            echo json_encode($dados);
            exit;
            break;
        case 'excluir':
            if (!isset($_GET['id'])) {
                $error_response = ['error' => 'ID não fornecido'];
                http_response_code(400);
                echo json_encode($error_response);
                exit();
            }
            $demanda->excluirDemanda($_GET['id']);
            header("Location: ../views/admin.php");
            exit();
            break;
    }
}

// Tratamento de requisições POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    switch ($_POST['acao']) {
        case 'excluir':
            if (isset($_POST['id'])) {
                $demanda = new Demanda($pdo);
                $sucesso = $demanda->excluirDemanda($_POST['id']);
                
                if ($sucesso) {
                    header("Location: ../views/admin.php?success=Demanda excluída com sucesso!");
                } else {
                    header("Location: ../views/admin.php?error=Erro ao excluir demanda.");
                }
                exit();
            }
            break;
        case 'criar':
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $prioridade = $_POST['prioridade'] ?? 'media';
            $usuarios_ids = isset($_POST['usuarios_ids']) ? (is_array($_POST['usuarios_ids']) ? $_POST['usuarios_ids'] : [$_POST['usuarios_ids']]) : [];
            $prazo = $_POST['prazo'] ?? null;

            if (empty($titulo) || empty($descricao)) {
                header("Location: ../views/admin.php?error=Por favor, preencha título e descrição.");
                exit();
            }

            $admin_id = $_SESSION['usuario_id'];
            $sucesso = $demanda->criarDemanda($titulo, $descricao, $prioridade, $admin_id, $usuarios_ids, $prazo);

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
                $prazo = $_POST['prazo'] ?? null;

                if (empty($titulo) || empty($descricao)) {
                    header("Location: ../views/admin.php?error=Por favor, preencha título e descrição.");
                    exit();
                }

                $sucesso = $demanda->atualizarDemanda($id, $titulo, $descricao, $prioridade, null, [], $prazo);
                
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
                    if ($_SESSION['usuario_tipo'] === 'admin') {
                        // Se for admin, marca a demanda como concluída e apenas o admin como concluído
                        $pdo->beginTransaction();
                        try {
                            // Atualiza o status da demanda
                            $stmt = $pdo->prepare("
                                UPDATE demandas 
                                SET status = 'concluida', data_conclusao = CURRENT_TIMESTAMP 
                                WHERE id = ?
                            ");
                            $stmt->execute([$_POST['id']]);

                            // Atualiza apenas o status do admin
                            $stmt = $pdo->prepare("
                                UPDATE demanda_usuarios 
                                SET status = 'concluido', data_conclusao = CURRENT_TIMESTAMP 
                                WHERE demanda_id = ? AND usuario_id = ?
                            ");
                            $stmt->execute([$_POST['id'], $_SESSION['usuario_id']]);

                            $pdo->commit();
                        } catch (Exception $e) {
                            $pdo->rollBack();
                            header("Location: ../views/admin.php?error=Erro ao concluir demanda.");
                            exit();
                        }
                    } else {
                        // Se for usuário normal, usa o método existente
                        $demanda->marcarConcluida($_POST['id'], $_POST['usuario_id'] ?? $_SESSION['usuario_id']);
                    }
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
        case 'aceitar_demanda':
            if (isset($_POST['id'])) {
                $demanda = new Demanda($pdo);
                $sucesso = $demanda->aceitarDemanda($_POST['id'], $_SESSION['usuario_id']);
                
                if ($sucesso) {
                    header("Location: ../views/usuario.php?success=Demanda aceita com sucesso!");
                } else {
                    header("Location: ../views/usuario.php?error=Erro ao aceitar demanda.");
                }
                exit();
            }
            break;
        case 'recusar_demanda':
            if (isset($_POST['id'])) {
                $demanda = new Demanda($pdo);
                $sucesso = $demanda->recusarDemanda($_POST['id'], $_SESSION['usuario_id']);
                
                if ($sucesso) {
                    header("Location: ../views/usuario.php?success=Demanda recusada com sucesso!");
                } else {
                    header("Location: ../views/usuario.php?error=Erro ao recusar demanda.");
                }
                exit();
            }
            break;
    }
}

// Redirecionamento padrão
header("Location: ../views/admin.php");
exit(); 