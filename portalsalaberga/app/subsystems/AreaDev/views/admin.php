<?php
<<<<<<< HEAD
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_error_handler(function(
    $errno, $errstr, $errfile, $errline
) {
    $msg = addslashes("[$errno] $errstr em $errfile na linha $errline");
    echo "<script>console.log('PHP: $msg');</script>";
    return false;
});

set_exception_handler(function($exception) {
    $msg = addslashes($exception->getMessage() . ' em ' . $exception->getFile() . ' na linha ' . $exception->getLine());
    echo "<script>console.log('Exceção: $msg');</script>";
});

// Removido controle de sessão e permissões para acesso livre
require_once __DIR__ . '/../config/Database.php';
=======
require_once __DIR__ . '/../config/database.php';
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
require_once __DIR__ . '/../model/Demanda.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../model/Area.php';

<<<<<<< HEAD
// Função para mapear a área a partir da permissão
function areaFromPermissao($permissao) {
    if (strpos($permissao, 'usuario_area_design') === 0 || strpos($permissao, 'adm_area_design') === 0) return 'Design';
    if (strpos($permissao, 'usuario_area_dev') === 0 || strpos($permissao, 'adm_area_dev') === 0) return 'Desenvolvimento';
    if (strpos($permissao, 'usuario_area_suporte') === 0 || strpos($permissao, 'adm_area_suporte') === 0) return 'Suporte';
    return 'Sem Área';
}
=======
session_start();
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)

// Inicializa a conexão com o banco de dados
$database = Database::getInstance();
$pdo_salaberga = $database->getSalabergaConnection();
$pdo_area_dev = $database->getAreaDevConnection();

<<<<<<< HEAD
// Inicializa os modelos
$demanda = new Demanda($pdo_area_dev);
$usuario = new Usuario($pdo_salaberga);
$area = new Area($pdo_area_dev);
$areas = $area->listarAreas();

// Remover áreas duplicadas pelo nome
$nomesVistos = [];
$areas_unicas = [];
foreach ($areas as $a) {
    if (!in_array($a['nome'], $nomesVistos)) {
        $areas_unicas[] = $a;
        $nomesVistos[] = $a['nome'];
    }
}
$areas = $areas_unicas;

$permissoes = $usuario->listarPermissoes();

// Buscar usuários conforme permissões do sistema de demandas
$id_sistema_demandas = 3;
error_log("Buscando usuários para o sistema ID: " . $id_sistema_demandas);
error_log("SESSION DATA: " . print_r($_SESSION, true));

// Verificar permissões do usuário atual
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo_salaberga->prepare("
        SELECT p.descricao
        FROM usu_sist us
        INNER JOIN sist_perm sp ON us.sist_perm_id = sp.id
        INNER JOIN permissoes p ON sp.permissao_id = p.id
        WHERE us.usuario_id = ? AND sp.sistema_id = ?
    ");
    $stmt->execute([$_SESSION['user_id'], $id_sistema_demandas]);
    $permissoes_usuario = $stmt->fetchAll(PDO::FETCH_COLUMN);
    error_log("Permissões do usuário atual: " . print_r($permissoes_usuario, true));
}

$usuarios_permissoes = $usuario->listarUsuariosComPermissoes($id_sistema_demandas);
error_log("Total de usuários encontrados: " . count($usuarios_permissoes));

$admins_gerais = Usuario::filtrarAdminsGerais($usuarios_permissoes);
$admins_area = Usuario::filtrarAdminsArea($usuarios_permissoes);
$usuarios = Usuario::filtrarUsuariosComuns($usuarios_permissoes);

error_log("Admins gerais: " . count($admins_gerais));
error_log("Admins área: " . count($admins_area));
error_log("Usuários comuns: " . count($usuarios));

// Exibir todos os usuários de área se for admin geral
$isAdminGeral = false;
if (isset($_SESSION['permissao']) && strpos($_SESSION['permissao'], 'adm_geral') !== false) {
    $isAdminGeral = true;
}

// Combinar todos os tipos de usuários
$todos_usuarios = array_merge($admins_gerais, $admins_area, $usuarios);

// Agrupar usuários por área
$usuarios_por_area = [];
foreach ($todos_usuarios as $user) {
    $area = areaFromPermissao($user['permissao']);
    if (!isset($usuarios_por_area[$area])) {
        $usuarios_por_area[$area] = [];
    }
    $usuarios_por_area[$area][] = $user;
}

// Processar ações POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("\n=== PROCESSANDO FORMULÁRIO POST (ADMIN) ===");
    error_log("Dados do POST: " . print_r($_POST, true));

    if (isset($_POST['acao'])) {
        $admin_id_logado = $_SESSION['user_id'] ?? null; // Obter admin_id da sessão
        error_log("Admin ID Logado: " . $admin_id_logado);

        if (!$admin_id_logado) {
            error_log("Erro: Admin ID não encontrado na sessão.");
            // Redirecionar ou mostrar mensagem de erro se necessário
            // header('Location: erro.php?msg=admin_nao_logado');
            // exit;
=======
// Verificar se está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$demanda = new Demanda($pdo);
$usuario = new Usuario($pdo);

// Processar criação de demanda
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] === 'criar') {
        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $prioridade = $_POST['prioridade'] ?? 'media';
        $usuario_id = $_POST['usuario_id'] ?? null;

        if (!empty($titulo) && !empty($descricao)) {
            $sucesso = $demanda->criarDemanda($titulo, $descricao, $prioridade, $_SESSION['usuario_id'], $usuario_id);
            if ($sucesso) {
            header("Location: admin.php");
            exit();
            } else {
                $erro = "Erro ao criar demanda. Por favor, tente novamente.";
            }
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        }

        switch ($_POST['acao']) {
            case 'criar':
                if (isset($_POST['titulo'], $_POST['descricao'], $_POST['area_id'], $_POST['prioridade'])) {
                    error_log("Dados para criarDemanda:");
                    error_log("Título: " . $_POST['titulo']);
                    error_log("Descrição: " . $_POST['descricao']);
                    error_log("Prioridade: " . $_POST['prioridade']);
                    error_log("Admin ID: " . $admin_id_logado);
                    error_log("Area ID: " . $_POST['area_id']);

                    try {
                        $nova_demanda_id = $demanda->criarDemanda(
                            $_POST['titulo'],
                            $_POST['descricao'],
                            $_POST['prioridade'],
                            $admin_id_logado, // Usar admin_id da sessão
                            [], // Manter atribuição individual vazia por enquanto
                            null, // Prazo
                            $_POST['area_id'],
                            null // UsuarioModel não é mais necessário aqui
                        );

                        if ($nova_demanda_id) {
                            error_log("Demanda criada com sucesso. ID: " . $nova_demanda_id);
                            // Redirecionar para a mesma página para evitar re-submissão do formulário
                            header('Location: admin.php');
                            exit;
                        } else {
                             error_log("Falha ao criar demanda no modelo.");
                             // Tratar erro de criação
                        }

                    } catch (Exception $e) {
                        error_log("Exceção ao criar demanda: " . $e->getMessage());
                        // Tratar exceção, talvez mostrar uma mensagem para o usuário
                    }

                }
                break;
            case 'delete':
                if (isset($_POST['demanda_id'])) {
                    $demanda->excluirDemanda($_POST['demanda_id']);
                }
                break;
            case 'update_status':
                if (isset($_POST['demanda_id'], $_POST['novo_status'])) {
                    if ($_POST['novo_status'] === 'concluida') {
                        $demanda->marcarConcluida($_POST['demanda_id'], 1);
                    } else if ($_POST['novo_status'] === 'em_andamento') {
                        $demanda->marcarEmAndamento($_POST['demanda_id'], 1);
                    }
                }
                break;
        }
    }
}

// Listar todas as demandas
$demandas = $demanda->listarDemandas($_SESSION['user_id']);

// Calcular totais de demandas por status
$totalDemandas = count($demandas);
$demandasEmAndamento = 0;
$demandasConcluidas = 0;
$demandasPendentes = 0;
foreach ($demandas as $d) {
    if ($d['status'] === 'em_andamento') {
        $demandasEmAndamento++;
    } elseif ($d['status'] === 'concluida') {
        $demandasConcluidas++;
    } elseif ($d['status'] === 'pendente') {
        $demandasPendentes++;
    }
}

$areas_permitidas = [];
$id_sistema = 3; // ID do sistema de demandas
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo_salaberga->prepare("
        SELECT p.descricao
        FROM usu_sist us
        INNER JOIN sist_perm sp ON us.sist_perm_id = sp.id
        INNER JOIN permissoes p ON sp.permissao_id = p.id
        WHERE us.usuario_id = ? AND p.descricao LIKE 'adm_area_%' AND sp.sistema_id = ?
    ");
    $stmt->execute([$_SESSION['user_id'], $id_sistema]);
    $permissoes_admin = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($permissoes_admin as $permissao) {
        $permissao = preg_replace('/\(\d+\)$/', '', $permissao); // remove (3) do final
        if (preg_match('/adm_area_([a-z]+)/', $permissao, $matches)) {
            $area_slug = strtolower($matches[1]);
            foreach ($areas as $a) {
                if (strpos(strtolower($a['nome']), $area_slug) !== false) {
                    $areas_permitidas[] = $a;
                }
            }
        }
    }
}
if (empty($areas_permitidas)) $areas_permitidas = $areas; // fallback para admin geral ou erro

// Buscar permissões de usuários comuns para atribuição
$stmtPermissoesAtribuicao = $pdo_salaberga->prepare("
    SELECT p.id, p.descricao
    FROM sist_perm sp
    INNER JOIN permissoes p ON sp.permissao_id = p.id
    WHERE sp.sistema_id = 3 AND p.descricao LIKE 'usuario_area_%'
");
$stmtPermissoesAtribuicao->execute();
$permissoes_atribuicao = $stmtPermissoesAtribuicao->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Painel Administrativo - Sistema de Gestão de Demandas">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Painel Administrativo - Sistema de Gestão de Demandas</title>
</head>

<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: {
                        DEFAULT: '#007A33',
                        '50': '#00FF6B',
                        '100': '#00EB61',
                        '200': '#00C250',
                        '300': '#00993F',
                        '400': '#00802F',
                        '500': '#007A33',
                        '600': '#00661F',
                        '700': '#00521A',
                        '800': '#003D15',
                        '900': '#002910'
                    },
                    secondary: {
                        DEFAULT: '#FFA500',
                        '50': '#FFE9C0',
                        '100': '#FFE1AB',
                        '200': '#FFD183',
                        '300': '#FFC15A',
                        '400': '#FFB232',
                        '500': '#FFA500',
                        '600': '#C78000',
                        '700': '#8F5C00',
                        '800': '#573800',
                        '900': '#1F1400'
                    },
                    dark: {
                        DEFAULT: '#1a1a1a',
                        '50': '#2d2d2d',
                        '100': '#272727',
                        '200': '#232323',
                        '300': '#1f1f1f',
                        '400': '#1a1a1a',
                        '500': '#171717',
                        '600': '#141414',
                        '700': '#111111',
                        '800': '#0e0e0e',
                        '900': '#0a0a0a'
                    }
                },
                animation: {
                    'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    'bounce-gentle': 'bounce 2s infinite',
                    'fade-in': 'fadeIn 0.5s ease-out',
                    'slide-up': 'slideUp 0.6s ease-out',
                    'scale-in': 'scaleIn 0.3s ease-out',
                    'float': 'float 3s ease-in-out infinite',
                },
                boxShadow: {
                    'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.36)',
                    'card': '0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -4px rgba(0, 0, 0, 0.2)',
                    'card-hover': '0 20px 25px -5px rgba(0, 122, 51, 0.1), 0 10px 10px -5px rgba(0, 122, 51, 0.04)',
                }
            }
        }
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: #1a1a1a;
        color: #ffffff;
        min-height: 100vh;
        background-image:
            radial-gradient(circle at 10% 20%, rgba(0, 122, 51, 0.05) 0%, rgba(0, 122, 51, 0) 20%),
            radial-gradient(circle at 90% 80%, rgba(255, 165, 0, 0.05) 0%, rgba(255, 165, 0, 0) 20%),
            linear-gradient(135deg, rgba(0, 122, 51, 0.02) 0%, rgba(255, 165, 0, 0.02) 100%);
        transition: all 0.3s ease;
    }

    /* Cards Styles */
    .demand-card {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 1.75rem;
        margin-bottom: 1rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
<<<<<<< HEAD
=======
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    }

    .demand-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #007A33, #00FF6B);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .demand-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 122, 51, 0.15);
        border-color: rgba(0, 255, 107, 0.3);
    }

    .demand-card:hover::before {
        transform: scaleX(1);
    }

<<<<<<< HEAD
    .stats-card {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 122, 51, 0.1);
=======
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .card-title {
        flex: 1;
        min-width: 0;
    }

    .card-title h3 {
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 0.375rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
        margin-bottom: 0.375rem;
    }

    .card-id {
        font-size: 0.7rem;
        color: #888888;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.2rem 0.4rem;
        border-radius: 8px;
    }

    .card-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .card-description {
        color: #cccccc;
        font-size: 0.813rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        padding: 0.75rem;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 8px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .detail-label {
        font-size: 0.7rem;
        color: #888888;
    }

    .detail-value {
        font-size: 0.813rem;
        color: #ffffff;
        font-weight: 500;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card-actions {
        display: flex;
        gap: 0.375rem;
    }

    .card-participants {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .participants-title {
        font-size: 0.813rem;
        color: #888888;
        margin-bottom: 0.5rem;
    }

    .participants-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
    }

    .participant-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.2rem 0.5rem;
        background: rgba(0, 122, 51, 0.1);
        border-radius: 8px;
        font-size: 0.7rem;
    }

    .participant-avatar {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: linear-gradient(135deg, #007A33, #00FF6B);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
        color: white;
        font-weight: 600;
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    }

    /* Button Styles */
    .custom-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.025em;
    }

    .custom-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .custom-btn:hover::before {
        transform: translateX(100%);
    }

    .custom-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .btn-icon {
        transition: all 0.3s ease;
    }

    .custom-btn:hover .btn-icon {
        transform: translateX(3px) scale(1.1);
    }

    /* Search and Filter Styles */
    .search-container {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
    }

    .custom-input {
        background: rgba(35, 35, 35, 0.95);
        border: 2px solid rgba(0, 122, 51, 0.2);
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        color: #ffffff;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .custom-input:focus {
        border-color: #00FF6B;
        box-shadow: 0 0 0 4px rgba(0, 255, 107, 0.1);
        outline: none;
        background: rgba(35, 35, 35, 1);
    }

    .custom-input::placeholder {
        color: #888888;
        font-weight: 400;
    }

<<<<<<< HEAD
=======
    /* Custom Multi-Select Styles */
    .custom-multi-select {
        position: relative;
        width: 100%;
    }

    .multi-select-container {
        background: rgba(35, 35, 35, 0.95);
        border: 2px solid rgba(0, 122, 51, 0.2);
        border-radius: 12px;
        min-height: 50px;
        padding: 8px 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .multi-select-container:hover {
        border-color: rgba(0, 122, 51, 0.4);
    }

    .multi-select-container.active {
        border-color: #00FF6B;
        box-shadow: 0 0 0 4px rgba(0, 255, 107, 0.1);
    }

    .multi-select-display {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        min-height: 32px;
        align-items: center;
    }

    .multi-select-placeholder {
        color: #888888;
        font-weight: 400;
        font-size: 14px;
    }

    .selected-user-tag {
        background: linear-gradient(135deg, rgba(0, 122, 51, 0.3), rgba(0, 122, 51, 0.2));
        border: 1px solid rgba(0, 122, 51, 0.4);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 500;
        color: #00FF6B;
        display: flex;
        align-items: center;
        gap: 6px;
        animation: slideIn 0.3s ease;
        transition: all 0.2s ease;
    }

    .selected-user-tag:hover {
        background: linear-gradient(135deg, rgba(0, 122, 51, 0.4), rgba(0, 122, 51, 0.3));
        transform: scale(1.05);
    }

    .remove-user-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 10px;
        color: #ffffff;
    }

    .remove-user-btn:hover {
        background: rgba(239, 68, 68, 0.8);
        transform: scale(1.1);
    }

    .multi-select-arrow {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        transition: transform 0.3s ease;
        color: #888888;
        pointer-events: none;
    }

    .multi-select-container.active .multi-select-arrow {
        transform: translateY(-50%) rotate(180deg);
    }

    .multi-select-dropdown {
        position: absolute;
        bottom: 100%;
        left: 0;
        right: 0;
        background: rgba(35, 35, 35, 0.98);
        border: 2px solid rgba(0, 122, 51, 0.2);
        border-radius: 12px;
        margin-bottom: 4px;
        overflow-y: auto;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .multi-select-dropdown.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .multi-select-search {
        padding: 12px;
        border-bottom: 1px solid rgba(0, 122, 51, 0.1);
    }

    .multi-select-search input {
        width: 100%;
        background: rgba(45, 45, 45, 0.8);
        border: 1px solid rgba(0, 122, 51, 0.2);
        border-radius: 8px;
        padding: 8px 12px;
        color: #ffffff;
        font-size: 14px;
        outline: none;
        transition: all 0.3s ease;
    }

    .multi-select-search input:focus {
        border-color: #00FF6B;
        box-shadow: 0 0 0 2px rgba(0, 255, 107, 0.1);
    }

    .multi-select-search input::placeholder {
        color: #888888;
    }

    .multi-select-option {
        padding: 12px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .multi-select-option:last-child {
        border-bottom: none;
    }

    .multi-select-option:hover {
        background: rgba(0, 122, 51, 0.1);
        color: #00FF6B;
    }

    .multi-select-option.selected {
        background: rgba(0, 122, 51, 0.2);
        color: #00FF6B;
        font-weight: 500;
    }

    .multi-select-option.selected::before {
        content: '✓';
        font-weight: bold;
        margin-right: 8px;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #007A33, #00FF6B);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 12px;
        color: white;
        flex-shrink: 0;
    }

    .user-info {
        flex: 1;
    }

    .user-name {
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .user-email {
        font-size: 12px;
        color: #888888;
    }

    /* Search and Filter Styles */
    .search-container {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
    }

>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    .filter-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        border: 2px solid rgba(0, 122, 51, 0.3);
        background: rgba(35, 35, 35, 0.8);
        color: #ffffff;
        transition: all 0.3s ease;
        font-weight: 500;
        cursor: pointer;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #007A33, #00FF6B);
        border-color: #00FF6B;
        color: #000000;
        font-weight: 600;
    }

    .filter-btn:hover {
        border-color: #00FF6B;
        background: rgba(0, 122, 51, 0.1);
        transform: translateY(-2px);
    }

    /* Status Badges */
    .status-badge {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.3s ease;
>>>>>>> parent of 3f481e1 (finalizando sistema de demandas)
=======
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
=======
>>>>>>> parent of c5d2626 (.)
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.2rem 0.5rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .status-badge i {
        font-size: 0.875rem;
    }

    .status-badge:hover {
        transform: scale(1.05);
    }

    .status-pendente {
        background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(234, 179, 8, 0.1));
        color: #fbbf24;
        border: 1px solid rgba(234, 179, 8, 0.3);
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> parent of c5d2626 (.)
    .status-aceito {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-aceito i {
        color: #4ade80;
    }

    .status-em_andamento {
<<<<<<< HEAD
=======
    .status-em-andamento {
>>>>>>> parent of 3f481e1 (finalizando sistema de demandas)
=======
    .status-em_andamento {
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
=======
>>>>>>> parent of c5d2626 (.)
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.1));
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .status-concluida {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }
    
    .status-concluida i {
        color: #4ade80;
    }

<<<<<<< HEAD
    .status-concluido {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-concluido i {
        color: #4ade80;
    }

=======
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    .status-cancelada {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

<<<<<<< HEAD
    .status-cancelada i {
        color: #f87171;
    }

    .status-recusado {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .status-recusado i {
        color: #f87171;
    }

=======
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    /* Priority Badges */
    .priority-badge {
        padding: 0.2rem 0.5rem;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 600;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
        text-transform: uppercase;
>>>>>>> parent of 3f481e1 (finalizando sistema de demandas)
=======
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
=======
>>>>>>> parent of c5d2626 (.)
        letter-spacing: 0.05em;
    }

    .priority-alta {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .priority-media {
        background: rgba(234, 179, 8, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(234, 179, 8, 0.3);
    }

    .priority-baixa {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    /* Modal Styles */
    .modal {
<<<<<<< HEAD
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(12px);
=======
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        transition: all 0.3s ease;
    }

    .modal-content {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border: 1px solid rgba(0, 122, 51, 0.2);
<<<<<<< HEAD
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
        border-radius: 24px;
        backdrop-filter: blur(20px);
        max-height: 90vh;
        overflow-y: auto;
=======
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        border-radius: 24px;
        backdrop-filter: blur(20px);
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleIn {
        from {
<<<<<<< HEAD
        opacity: 0;
            transform: scale(0.9);
        }
        to {
        opacity: 1;
=======
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
            transform: scale(1);
        }
    }

<<<<<<< HEAD
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
=======
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .slide-up {
        animation: slideUp 0.6s ease-out forwards;
    }

    .scale-in {
        animation: scaleIn 0.3s ease-out forwards;
    }

<<<<<<< HEAD
    .float {
        animation: float 3s ease-in-out infinite;
    }

    /* Progress Bar */
    .progress-bar {
        width: 100%;
        height: 6px;
        background: rgba(0, 122, 51, 0.1);
        border-radius: 3px;
        overflow: hidden;
        margin: 1rem 0;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #007A33, #00FF6B);
        border-radius: 3px;
        transition: width 0.3s ease;
    }

=======
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
<<<<<<< HEAD
        background: #1a1a1a;
=======
        background: rgba(35, 35, 35, 0.5);
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
<<<<<<< HEAD
        background: linear-gradient(135deg, #007A33, #00FF6B);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #00FF6B, #007A33);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #888888;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
=======
        background: rgba(0, 122, 51, 0.5);
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 122, 51, 0.7);
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    }

    /* Responsive */
    @media (max-width: 768px) {
        .demand-card {
<<<<<<< HEAD
            padding: 1.25rem;
            margin-bottom: 0.75rem;
=======
            padding: 1rem;
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        }
        
        .stats-card {
            padding: 1.5rem;
        }
        
        .search-container {
            padding: 1.5rem;
        }
<<<<<<< HEAD
=======

        .multi-select-dropdown {
            max-height: 150px;
        }

        .selected-user-tag {
            font-size: 11px;
            padding: 3px 8px;
        }
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    }

    /* Loading Animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(0, 122, 51, 0.3);
        border-radius: 50%;
        border-top-color: #00FF6B;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Completion Button */
    .complete-btn {
        background: linear-gradient(135deg, #007A33, #00FF6B);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .complete-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 122, 51, 0.3);
    }

    .complete-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

<<<<<<< HEAD
    /* Select Styles */
    .custom-select {
        background: rgba(35, 35, 35, 0.95);
        border: 2px solid rgba(0, 122, 51, 0.2);
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        color: #ffffff;
        transition: all 0.3s ease;
        font-weight: 500;
        min-width: 200px;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .custom-select:focus {
        border-color: #00FF6B;
        box-shadow: 0 0 0 4px rgba(0, 255, 107, 0.1);
        outline: none;
        background: rgba(35, 35, 35, 1);
    }

    .custom-select option {
        background: #232323;
        color: #ffffff;
        padding: 1rem;
    }

    .custom-select:hover {
        border-color: rgba(0, 122, 51, 0.4);
    }

    .select-wrapper {
        position: relative;
        display: inline-block;
    }

    .select-wrapper::after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #888888;
        pointer-events: none;
    }

    .demand-card h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 0.375rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
        margin-bottom: 0.375rem;
    }

    /* User Cards */
    .user-card {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 122, 51, 0.1);
        border-color: rgba(0, 255, 107, 0.3);
=======
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #888888;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Hide original select */
    .hidden-select {
        display: none;
    }

    /* Estilização para o status 'concluido' dos participantes */
    .status-concluido {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-concluido i {
        color: #4ade80;
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
    }
</style>

<body class="select-none">
    <!-- Header -->
    <header class="bg-dark-200 shadow-lg border-b border-primary/20 sticky top-0 z-50 backdrop-blur-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-tasks text-white text-lg"></i>
                </div>
<<<<<<< HEAD

                <!-- Botões e Informações do Usuário -->
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                    <!-- Informações do Usuário -->
                    <div class="flex items-center gap-2 text-gray-300 bg-dark-300/50 px-4 py-2 rounded-lg">
                        <i class="fas fa-user-shield text-primary-50"></i>
                        <span class="text-sm truncate max-w-[200px]"><?php echo htmlspecialchars($_SESSION['Nome'] ?? 'Admin'); ?></span>
                        <span class="bg-red-600 text-white text-xs font-semibold px-2.5 py-0.5 rounded-full">
                            Admin
                        </span>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center gap-2 w-full sm:w-auto justify-center sm:justify-end">
                        <a href="../../../main/views/autenticacao/login.php?sair=true" class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm w-full sm:w-auto justify-center">
                            <i class="fas fa-sign-out-alt btn-icon"></i>
                            <span>Sair</span>
                        </a>
                    </div>
=======
                <h1 class="text-2xl font-bold bg-gradient-to-r from-primary-50 to-primary-200 bg-clip-text text-transparent">
                    Painel Administrativo
                </h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-2 text-gray-300">
                    <i class="fas fa-user-shield text-primary-50"></i>
                    <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                </div>
                <a href="logout.php" class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2">
                    <i class="fas fa-sign-out-alt btn-icon"></i> 
                    <span class="hidden md:inline">Sair</span>
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
<<<<<<< HEAD
=======
        <?php if (!empty($erro)): ?>
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg mb-6 fade-in">
            <div class="flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($erro); ?></span>
            </div>
        </div>
        <?php endif; ?>

>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        <!-- Search and Filters -->
        <div class="search-container slide-up" style="animation-delay: 0.6s">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="flex-1 w-full lg:max-w-md">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Buscar demandas..." 
                            class="custom-input w-full pl-12"
                            onkeyup="filterDemands()"
                        >
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-4">
                    <div class="select-wrapper">
                        <select class="custom-select" onchange="filterByStatus(this.value)">
                            <option value="all">Todas as Demandas</option>
                            <option value="pendente">Pendentes</option>
                            <option value="em_andamento">Em Andamento</option>
                            <option value="concluida">Concluídas</option>
                        </select>
                    </div>

                    <div class="select-wrapper">
                        <select class="custom-select" onchange="filterByPriority(this.value)">
                            <option value="all">Todas Prioridades</option>
                            <option value="alta">Alta</option>
                            <option value="media">Média</option>
                            <option value="baixa">Baixa</option>
                        </select>
                    </div>
                </div>
                
                <button onclick="openModal('criarDemandaModal')" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2">
                    <i class="fas fa-plus btn-icon"></i> Nova Demanda
                </button>
            </div>
        </div>

        <!-- Demands Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <i class="fas fa-clipboard-list text-primary-50"></i>
                Gerenciar Demandas
            </h2>
            
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> parent of c5d2626 (.)
            <!-- Grid de 3 colunas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Coluna Em Espera -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-clock text-yellow-500"></i>
                        Em Espera
                    </h3>
                    <div id="demandasEsperaContainer" class="space-y-4">
                        <?php 
                        $demandas_espera = array_filter($demandas, function($d) {
                            return $d['status'] === 'pendente';
                        });
                        
                        // Ordenar por prioridade
                        usort($demandas_espera, function($a, $b) {
                            $prioridades = ['alta' => 3, 'media' => 2, 'baixa' => 1];
                            return $prioridades[$b['prioridade']] - $prioridades[$a['prioridade']];
                        });
<<<<<<< HEAD
=======
            <div id="demandsContainer" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($demandas as $index => $d): ?>
=======
            <div id="demandsContainer" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($demandas as $index => $d): ?>
                
                <?php
                // DEBUG: Verificar os dados de cada demanda (Admin View)
                // echo '<h3>DEBUG ADMIN: Demanda ID: ' . $d['id'] . '</h3>';
                // var_dump($d);
                // echo '<hr>';
                ?>

>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                <div class="demand-card fade-in" 
                     style="animation-delay: <?php echo ($index * 0.1); ?>s"
                     data-status="<?php echo $d['status']; ?>"
                     data-title="<?php echo strtolower($d['titulo']); ?>"
<<<<<<< HEAD
                     data-description="<?php echo strtolower($d['descricao']); ?>">
                    
                    <!-- Card Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white mb-2 line-clamp-2">
                                <?php echo htmlspecialchars($d['titulo']); ?>
                            </h3>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $d['status'])); ?>">
                                    <?php
                                    $statusIcons = [
                                        'Pendente' => 'fas fa-clock',
                                        'Em Andamento' => 'fas fa-spinner fa-spin',
                                        'Concluída' => 'fas fa-check-circle',
                                        'Cancelada' => 'fas fa-ban'
                                    ];
                                    $status = ucfirst(strtolower($d['status']));
                                    ?>
                                    <i class="<?php echo $statusIcons[$status] ?? 'fas fa-question'; ?>"></i>
                                    <?php echo $status; ?>
=======
                     data-description="<?php echo strtolower($d['descricao']); ?>"
                     data-priority="<?php echo $d['prioridade']; ?>"
                     data-demanda-id="<?php echo $d['id']; ?>">
                    
                    <!-- Card Header -->
                    <div class="card-header">
                        <div class="card-title">
                            <h3><?php echo htmlspecialchars($d['titulo']); ?></h3>
                            <div class="card-meta">
                                <span class="status-badge status-<?php echo $d['status']; ?>">
                                    <?php
                                    $statusIcons = [
                                        'pendente' => 'fas fa-clock',
                                        'em_andamento' => 'fas fa-spinner fa-spin',
                                        'concluida' => 'fas fa-check-circle',
                                        'cancelada' => 'fas fa-ban'
                                    ];
                                    $status_display = ucfirst(str_replace('_', ' ', $d['status']));
                                    ?>
                                    <i class="<?php echo $statusIcons[$d['status']] ?? 'fas fa-question'; ?>"></i>
                                    <?php echo $status_display; ?>
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                                </span>
                                <span class="priority-badge priority-<?php echo $d['prioridade']; ?>">
                                    <?php echo ucfirst($d['prioridade']); ?>
                                </span>
                            </div>
                        </div>
                        <span class="card-id">#<?php echo $d['id']; ?></span>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="card-content">
                        <p class="card-description">
                            <?php echo htmlspecialchars($d['descricao']); ?>
                        </p>
                        
                        <div class="card-details">
                            <div class="detail-item">
                                <span class="detail-label">Criado em</span>
                                <span class="detail-value">
                                    <?php echo date('d/m/Y', strtotime($d['data_criacao'])); ?>
<<<<<<< HEAD
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-400">
                                    <?php echo !empty($d['data_conclusao']) ? 'Concluído em:' : 'Prazo:'; ?>
                                </span>
                                <p class="text-white font-medium">
                                    <?php 
                                    if (!empty($d['data_conclusao'])) {
                                        echo date('d/m/Y', strtotime($d['data_conclusao']));
=======
                                </span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">
                                    <?php echo !empty($d['data_conclusao']) ? 'Concluído em' : 'Prazo'; ?>
                                </span>
                                <span class="detail-value">
                                    <?php 
                                    if (!empty($d['data_conclusao'])) {
                                        echo date('d/m/Y', strtotime($d['data_conclusao']));
                                    } else if (!empty($d['prazo'])) {
                                        echo date('d/m/Y', strtotime($d['prazo']));
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                                    } else {
                                        echo 'Não definido';
                                    }
                                    ?>
<<<<<<< HEAD
                                </p>
=======
                                </span>
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                            </div>
                        </div>
                            </div>
                    
<<<<<<< HEAD
                    <!-- Card Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                        <div class="flex items-center gap-2">
=======
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="card-actions">
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                            <?php if ($d['admin_id'] == $_SESSION['usuario_id']): ?>
                            <button 
                                onclick="editarDemanda(<?php echo $d['id']; ?>)" 
                                class="custom-btn bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg"
                                title="Editar demanda">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button 
                                onclick="excluirDemanda(<?php echo $d['id']; ?>)" 
                                class="custom-btn bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg"
                                title="Excluir demanda">
                                <i class="fas fa-trash"></i>
                            </button>

<<<<<<< HEAD
                            <?php if (strtolower($d['status']) === 'pendente' && (is_null($d['usuario_id']) || $d['usuario_id'] == 0 || $d['usuario_id'] == '')): ?>
                            <form method="POST" action="../controllers/DemandaController.php" class="inline" onsubmit="return confirmarEmAndamento()">
                                <input type="hidden" name="acao" value="atualizar_status">
                                <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                <input type="hidden" name="novo_status" value="Em Andamento">
                                <button type="submit" class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white p-2 rounded-lg" title="Marcar como Em Andamento">
                                    <i class="fas fa-spinner"></i>
                                    Realizar Tarefa
=======
                            <?php 
                            $is_assigned = false;
                            if (!empty($d['usuarios_atribuidos'])) {
                                foreach ($d['usuarios_atribuidos'] as $atribuido) {
                                    if ($atribuido['id'] == $_SESSION['usuario_id']) {
                                        $is_assigned = true;
                                        break;
                                    }
                                }
                            }
                            $can_perform_action = $is_assigned || empty($d['usuarios_atribuidos']);

                            if ($d['status'] === 'pendente' && $can_perform_action): 
                            ?>
                            <form method="POST" action="../controllers/DemandaController.php" class="inline" onsubmit="return confirmarEmAndamento()">
                                <input type="hidden" name="acao" value="atualizar_status">
                                <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                <input type="hidden" name="novo_status" value="em_andamento">
                                <button type="submit" class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white p-2 rounded-lg" title="Marcar como Em Andamento">
                                    <i class="fas fa-spinner"></i>
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                                </button>
                            </form>
                            <?php endif; ?>

<<<<<<< HEAD
                            <?php if (strtolower($d['status']) === 'em_andamento' && (is_null($d['usuario_id']) || $d['usuario_id'] == 0 || $d['usuario_id'] == '')): ?>
                            <form method="POST" action="../controllers/DemandaController.php" class="inline" onsubmit="return confirmarConclusao()">
                                <input type="hidden" name="acao" value="atualizar_status">
                                <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                <input type="hidden" name="novo_status" value="Concluída">
                                <button type="submit" class="custom-btn bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg" title="Marcar como Concluída">
                                    <i class="fas fa-check"></i>
                                    Concluir
=======
                            <?php 
                            if ($d['status'] === 'em_andamento' && $can_perform_action): 
                            ?>
                            <form method="POST" action="../controllers/DemandaController.php" class="inline" onsubmit="return confirmarConclusao()">
                                <input type="hidden" name="acao" value="atualizar_status">
                                <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                <input type="hidden" name="novo_status" value="concluida">
                                <button type="submit" class="custom-btn bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg" title="Marcar como Concluída">
                                    <i class="fas fa-check"></i>
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                                </button>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
<<<<<<< HEAD
                        </div>
>>>>>>> parent of 3f481e1 (finalizando sistema de demandas)
=======
>>>>>>> parent of c5d2626 (.)
                        
                        foreach ($demandas_espera as $d): 
                        ?>
                        <div class="demand-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300"
                            data-title="<?php echo htmlspecialchars($d['titulo']); ?>"
                            data-description="<?php echo htmlspecialchars($d['descricao']); ?>"
                            data-status="<?php echo $d['status']; ?>"
                            data-priority="<?php echo $d['prioridade']; ?>">
                            <!-- Conteúdo do card (mantido igual) -->
                            <?php include 'components/demand_card.php'; ?>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if (empty($demandas_espera)): ?>
                        <div class="empty-state">
                            <i class="fas fa-clipboard"></i>
                            <h3 class="text-xl font-semibold mb-2">Nenhuma demanda em espera</h3>
                            <p>Todas as demandas pendentes estão sendo feitas ou foram concluídas/canceladas.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Coluna Em Andamento -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-spinner fa-spin text-blue-500"></i>
                        Em Andamento
                    </h3>
                    <div id="demandasAndamentoContainer" class="space-y-4">
                        <?php 
                        $demandas_andamento = array_filter($demandas, function($d) {
                            return $d['status'] === 'em_andamento';
                        });
                        
                        // Ordenar por prioridade
                        usort($demandas_andamento, function($a, $b) {
                            $prioridades = ['alta' => 3, 'media' => 2, 'baixa' => 1];
                            return $prioridades[$b['prioridade']] - $prioridades[$a['prioridade']];
                        });
                        
                        foreach ($demandas_andamento as $d): 
                        ?>
                        <div class="demand-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300"
                            data-title="<?php echo htmlspecialchars($d['titulo']); ?>"
                            data-description="<?php echo htmlspecialchars($d['descricao']); ?>"
                            data-status="<?php echo $d['status']; ?>"
                            data-priority="<?php echo $d['prioridade']; ?>">
                            <!-- Conteúdo do card (mantido igual) -->
                            <?php include 'components/demand_card.php'; ?>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if (empty($demandas_andamento)): ?>
                        <div class="empty-state">
                            <i class="fas fa-tasks"></i>
                            <h3 class="text-xl font-semibold mb-2">Nenhuma demanda em andamento</h3>
                            <p>Não há demandas sendo trabalhadas no momento.</p>
=======
                        </div>
                    </div>

                    <!-- Participants Section -->
                    <?php if (!empty($d['usuarios_atribuidos'])): ?>
                    <div class="card-participants">
                        <h4 class="participants-title">Participantes</h4>
                        <div class="participants-list">
                            <?php foreach ($d['usuarios_atribuidos'] as $u_atrib): ?>
                            <div class="participant-item">
                                <span class="participant-name"><?php echo htmlspecialchars($u_atrib['nome']); ?></span>
                                <span class="status-badge status-<?php echo $u_atrib['status']; ?>">
                                    <?php
                                    $statusIcons = [
                                        'pendente' => 'fas fa-clock',
                                        'em_andamento' => 'fas fa-spinner fa-spin',
                                        'concluido' => 'fas fa-check-circle'
                                    ];
                                    ?>
                                    <i class="<?php echo $statusIcons[$u_atrib['status']] ?? 'fas fa-question'; ?>"></i>
                                    <?php echo ucfirst($u_atrib['status']); ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
<<<<<<< HEAD

                <!-- Coluna Concluídas -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500"></i>
                        Concluídas
                    </h3>
                    <div id="demandasConcluidasContainer" class="space-y-4">
                        <?php 
                        $demandas_concluidas = array_filter($demandas, function($d) {
                            return $d['status'] === 'concluida';
                        });
                        
                        // Ordenar por prioridade
                        usort($demandas_concluidas, function($a, $b) {
                            $prioridades = ['alta' => 3, 'media' => 2, 'baixa' => 1];
                            return $prioridades[$b['prioridade']] - $prioridades[$a['prioridade']];
                        });
                        
                        foreach ($demandas_concluidas as $d): 
                        ?>
                        <div class="demand-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300"
                            data-title="<?php echo htmlspecialchars($d['titulo']); ?>"
                            data-description="<?php echo htmlspecialchars($d['descricao']); ?>"
                            data-status="<?php echo $d['status']; ?>"
                            data-priority="<?php echo $d['prioridade']; ?>">
                            <!-- Conteúdo do card (mantido igual) -->
                            <?php include 'components/demand_card.php'; ?>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if (empty($demandas_concluidas)): ?>
                        <div class="empty-state">
                            <i class="fas fa-check-double"></i>
                            <h3 class="text-xl font-semibold mb-2">Nenhuma demanda concluída</h3>
                            <p>Não há demandas concluídas no momento.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
=======
                <?php endforeach; ?>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="empty-state hidden">
                <i class="fas fa-search"></i>
                <h3 class="text-xl font-semibold mb-2">Nenhuma demanda encontrada</h3>
                <p>Tente ajustar os filtros ou criar uma nova demanda.</p>
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
            </div>
        </div>

        <!-- User Management Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-users text-primary-50"></i>
                    Gerenciar Usuários
                </h2>
                <button onclick="openModal('criarUsuarioModal')" class="custom-btn bg-gradient-to-r from-secondary-500 to-secondary-400 hover:from-secondary-400 hover:to-secondary-300 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2">
                    <i class="fas fa-user-plus btn-icon"></i> Novo Usuário
                </button>
            </div>

            <?php
            // Exibir usuários por área
            foreach ($usuarios_por_area as $area => $usuarios_area):
                if (empty($usuarios_area)) continue;
            ?>
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-primary-100 mb-4"><?php echo $area; ?></h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($usuarios_area as $index => $user): ?>
                    <div class="user-card fade-in" style="animation-delay: <?php echo ($index * 0.1); ?>s">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white">
                                    <?php echo isset($user['nome']) && $user['nome'] ? htmlspecialchars($user['nome']) : '<span class="text-gray-500">Sem nome</span>'; ?>
                                </h3>
                                <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user['email']); ?></p>
                                <?php
                                $tipo_usuario = '';
                                $cor_badge = '';
                                if (strpos($user['permissao'], 'adm_geral') === 0) {
                                    $tipo_usuario = 'Administrador Geral';
                                    $cor_badge = 'bg-purple-500/20 text-purple-400';
                                } elseif (strpos($user['permissao'], 'adm_area_') === 0) {
                                    $tipo_usuario = 'Administrador - ' . $area;
                                    $cor_badge = 'bg-blue-500/20 text-blue-400';
                                } else {
                                    $tipo_usuario = 'Usuário - ' . $area;
                                    $cor_badge = 'bg-green-500/20 text-green-400';
                                }
                                ?>
                                <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full <?php echo $cor_badge; ?>">
                                    <?php echo $tipo_usuario; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Modal de Descrição -->
    <div id="modalDescricao" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-2xl p-8 scale-in">
            <div class="flex justify-between items-start mb-6">
                <h3 id="modalTitulo" class="text-2xl font-bold text-white pr-4"></h3>
                <button onclick="closeModal('modalDescricao')" class="text-gray-400 hover:text-white transition-colors p-2">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="mb-6">
                <div class="flex items-center gap-4 mb-4">
                    <span id="modalStatus" class="status-badge"></span>
                    <span class="text-gray-400 text-sm" id="modalDates"></span>
                </div>
            </div>
            
            <div class="bg-gray-800/50 rounded-lg p-4 mb-6">
                <h4 class="text-sm font-semibold text-gray-400 mb-2">Descrição:</h4>
                <p id="modalDescricaoTexto" class="text-gray-300 text-base leading-relaxed"></p>
            </div>
            
            <div class="flex justify-end">
                <button onclick="closeModal('modalDescricao')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg">
                    Fechar
                </button>
            </div>
        </div>
    </div>

    <!-- Create Demand Modal -->
    <div id="criarDemandaModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-md p-6 scale-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Nova Demanda</h3>
                <button onclick="closeModal('criarDemandaModal')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="../controllers/DemandaController.php" method="POST" class="space-y-4" id="formCriarDemanda">
                <input type="hidden" name="acao" value="criar">
                <?php if (count($areas_permitidas) > 1): ?>
                <div>
                    <label for="area_id" class="block text-sm font-medium text-gray-300 mb-2">Área</label>
                    <select id="area_id" name="area_id" required class="custom-select w-full">
                        <option value="">Selecione a área</option>
                        <?php foreach ($areas_permitidas as $area): ?>
                            <option value="<?= $area['id'] ?>"><?= htmlspecialchars($area['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php elseif (count($areas_permitidas) === 1): ?>
                    <input type="hidden" name="area_id" value="<?= $areas_permitidas[0]['id'] ?>">
                <?php endif; ?>
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-300 mb-2">Título</label>
                    <input type="text" id="titulo" name="titulo" required class="custom-input w-full">
                </div>
                <div>
                    <label for="descricao" class="block text-sm font-medium text-gray-300 mb-2">Descrição</label>
                    <textarea id="descricao" name="descricao" required class="custom-input w-full" rows="4"></textarea>
                </div>
                <div>
                    <label for="prioridade" class="block text-sm font-medium text-gray-300 mb-2">Prioridade</label>
                    <select id="prioridade" name="prioridade" required class="custom-select w-full">
<<<<<<< HEAD
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                
                <!-- Novo campo para selecionar a Permissão de Atribuição -->
                <?php if (!empty($permissoes_atribuicao)): ?>
                <div>
                    <label for="permissao_atribuicao_id" class="block text-sm font-medium text-gray-300 mb-2">Atribuir à Permissão</label>
                    <select id="permissao_atribuicao_id" name="permissao_atribuicao_id" class="custom-select w-full">
                        <option value="">Selecionar Permissão (Opcional)</option>
                        <?php foreach ($permissoes_atribuicao as $permissao): ?>
                            <option value="<?= $permissao['id'] ?>"><?= htmlspecialchars($permissao['descricao']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>

                <div id="prazoCalculadoInfo" class="mt-2"></div>
=======
                        <option value="alta">Alta</option>
                        <option value="media" selected>Média</option>
                                    <option value="baixa">Baixa</option>
                                </select>
                            </div>
                            <div>
                    <label for="prazo" class="block text-sm font-medium text-gray-300 mb-2">Prazo</label>
                    <input type="date" id="prazo" name="prazo" required class="custom-input w-full" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div>
                    <label for="usuario_id" class="block text-sm font-medium text-gray-300 mb-2">Atribuir a</label>
                    
                    <!-- Custom Multi-Select -->
                    <div class="custom-multi-select">
                        <div class="multi-select-container" onclick="toggleMultiSelect('usuario_id')">
                            <div class="multi-select-display" id="usuario_id_display">
                                <span class="multi-select-placeholder">Selecione os usuários</span>
                            </div>
                            <i class="fas fa-chevron-down multi-select-arrow"></i>
                        </div>
                        
                        <div class="multi-select-dropdown" id="usuario_id_dropdown">
                            <div class="multi-select-search">
                                <input type="text" placeholder="Buscar usuários..." onkeyup="filterUsers('usuario_id', this.value)">
                            </div>
                            <div class="multi-select-options" id="usuario_id_options">
                                <?php foreach ($usuarios as $u): ?>
                                <div class="multi-select-option" data-value="<?php echo $u['id']; ?>" onclick="toggleUserSelection('usuario_id', <?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['nome']); ?>', '<?php echo htmlspecialchars($u['email']); ?>')">
                                    <div class="user-avatar">
                                        <?php echo strtoupper(substr($u['nome'], 0, 2)); ?>
                                    </div>
                                    <div class="user-info">
                                        <div class="user-name"><?php echo htmlspecialchars($u['nome']); ?></div>
                                        <div class="user-email"><?php echo htmlspecialchars($u['email']); ?></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden select for form submission -->
                    <select name="usuarios_ids[]" multiple class="hidden-select" id="usuario_id_hidden">
                                    <?php foreach ($usuarios as $u): ?>
                                    <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['nome']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeModal('criarDemandaModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" name="criar" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-2 px-4 rounded-lg">
                        Criar Demanda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="criarUsuarioModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-md p-6 scale-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Novo Usuário</h3>
                <button onclick="closeModal('criarUsuarioModal')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="../controllers/UsuarioController.php" method="POST" class="space-y-4">
                <input type="hidden" name="acao" value="criar_usuario">
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-300 mb-2">Nome</label>
                    <input type="text" id="nome" name="nome" required class="custom-input w-full">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" id="email" name="email" required class="custom-input w-full">
                </div>
                <div>
                    <label for="senha" class="block text-sm font-medium text-gray-300 mb-2">Senha</label>
                    <input type="password" id="senha" name="senha" required class="custom-input w-full">
                </div>
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-300 mb-2">Tipo de Usuário</label>
                    <select id="tipo" name="tipo" required class="custom-select w-full" onchange="toggleAreaField()">
                        <option value="">Selecione o tipo/permissão</option>
                        <optgroup label="Usuários">
                            <option value="usuario_area_dev(3)">Usuário - Área de Desenvolvimento</option>
                            <option value="usuario_area_design(3)">Usuário - Área de Design</option>
                            <option value="usuario_area_suporte(3)">Usuário - Área de Suporte</option>
                        </optgroup>
                        <optgroup label="Administradores">
                            <option value="adm_area_dev(3)">Administrador - Área de Desenvolvimento</option>
                            <option value="adm_area_design(3)">Administrador - Área de Design</option>
                            <option value="adm_area_suporte(3)">Administrador - Área de Suporte</option>
                            <option value="adm_geral(3)">Administrador Geral</option>
                        </optgroup>
                    </select>
                </div>
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeModal('criarUsuarioModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" name="criar_usuario" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-2 px-4 rounded-lg">
                        Criar Usuário
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Demand Modal -->
    <div id="editarDemandaModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-md p-6 scale-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Editar Demanda</h3>
                <button onclick="closeModal('editarDemandaModal')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="../controllers/DemandaController.php" method="POST" class="space-y-4">
                <input type="hidden" name="acao" value="atualizar_demanda">
                <input type="hidden" name="id" id="editar_demanda_id">
                <div>
                    <label for="editar_titulo" class="block text-sm font-medium text-gray-300 mb-2">Título</label>
                    <input type="text" id="editar_titulo" name="titulo" required class="custom-input w-full">
                </div>
                <div>
                    <label for="editar_descricao" class="block text-sm font-medium text-gray-300 mb-2">Descrição</label>
                    <textarea id="editar_descricao" name="descricao" required class="custom-input w-full" rows="4"></textarea>
                </div>
                <div>
                    <label for="editar_prioridade" class="block text-sm font-medium text-gray-300 mb-2">Prioridade</label>
                    <select id="editar_prioridade" name="prioridade" required class="custom-select w-full">
                        <option value="alta">Alta</option>
                        <option value="media">Média</option>
                        <option value="baixa">Baixa</option>
                    </select>
                </div>
<<<<<<< HEAD
                <div>
                    <label for="editar_status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select id="editar_status" name="status" required class="custom-select w-full">
                        <option value="pendente">Pendente</option>
                        <option value="em_andamento">Em Andamento</option>
                        <option value="concluida">Concluída</option>
                    </select>
                </div>
                <div>
                    <label for="editar_prazo" class="block text-sm font-medium text-gray-300 mb-2">Prazo</label>
                    <input type="date" id="editar_prazo" name="prazo" required class="custom-input w-full" min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div>
                    <label for="editar_usuario_id" class="block text-sm font-medium text-gray-300 mb-2">Atribuir a</label>
                    
                    <!-- Custom Multi-Select for Edit -->
                    <div class="custom-multi-select">
                        <div class="multi-select-container" onclick="toggleMultiSelect('editar_usuario_id')">
                            <div class="multi-select-display" id="editar_usuario_id_display">
                                <span class="multi-select-placeholder">Selecione os usuários</span>
                            </div>
                            <i class="fas fa-chevron-down multi-select-arrow"></i>
                        </div>
                        
                        <div class="multi-select-dropdown" id="editar_usuario_id_dropdown">
                            <div class="multi-select-search">
                                <input type="text" placeholder="Buscar usuários..." onkeyup="filterUsers('editar_usuario_id', this.value)">
                            </div>
                            <div class="multi-select-options" id="editar_usuario_id_options">
                                <?php foreach ($usuarios as $u): ?>
                                <div class="multi-select-option" data-value="<?php echo $u['id']; ?>" onclick="toggleUserSelection('editar_usuario_id', <?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['nome']); ?>', '<?php echo htmlspecialchars($u['email']); ?>')">
                                    <div class="user-avatar">
                                        <?php echo strtoupper(substr($u['nome'], 0, 2)); ?>
                                    </div>
                                    <div class="user-info">
                                        <div class="user-name"><?php echo htmlspecialchars($u['nome']); ?></div>
                                        <div class="user-email"><?php echo htmlspecialchars($u['email']); ?></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden select for form submission -->
                    <select name="usuarios_ids[]" multiple class="hidden-select" id="editar_usuario_id_hidden">
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['nome']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
<<<<<<< HEAD
<<<<<<< HEAD
                <div id="editPrazoCalculadoInfo" class="mt-2"></div>
=======
                <div>
                    <label for="editar_status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select id="editar_status" name="status" required class="custom-select w-full">
                        <option value="Pendente">Pendente</option>
                        <option value="Em Andamento">Em Andamento</option>
                        <option value="Concluída">Concluída</option>
                        <option value="Cancelada">Cancelada</option>
                    </select>
                </div>
                <div>
                    <label for="editar_usuario_id" class="block text-sm font-medium text-gray-300 mb-2">Atribuir a</label>
                    <select id="editar_usuario_id" name="usuario_id" class="custom-select w-full">
                        <option value="">Não atribuído</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['nome']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
>>>>>>> parent of 3f481e1 (finalizando sistema de demandas)
=======
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
=======
                <div id="editPrazoCalculadoInfo" class="mt-2"></div>
>>>>>>> parent of c5d2626 (.)
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeModal('editarDemandaModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" name="atualizar_demanda" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-2 px-4 rounded-lg">
                        Atualizar Demanda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Demand Modal -->
    <div id="excluirDemandaModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
<<<<<<< HEAD
        <div class="modal-content w-full max-w-md p-8 scale-in">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-500"></i>
=======
        <div class="modal-content w-full max-w-sm p-6 scale-in text-center">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Confirmar Exclusão</h3>
                <button onclick="closeModal('excluirDemandaModal')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
            </div>
            <p class="text-gray-300 mb-6">Tem certeza que deseja excluir esta demanda? Esta ação não pode ser desfeita.</p>
            <input type="hidden" id="demanda_a_excluir_id">
            <div class="flex justify-center gap-4">
                <button type="button" onclick="closeModal('excluirDemandaModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                    Cancelar
                </button>
                <button type="button" onclick="confirmarExclusao()" class="custom-btn bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                    Excluir
                </button>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function mostrarDescricao(titulo, descricao, status, dataCriacao, dataConclusao) {
            document.getElementById('modalTitulo').textContent = titulo;
            document.getElementById('modalDescricaoTexto').textContent = descricao;
            
            // Update status badge
            const statusBadge = document.getElementById('modalStatus');
            statusBadge.textContent = status;
            statusBadge.className = `status-badge status-${status.toLowerCase().replace(' ', '-')}`;
            
            // Update dates
            let datesText = `Criado em: ${dataCriacao}`;
            if (dataConclusao) {
                datesText += ` • Concluído em: ${dataConclusao}`;
            }
            document.getElementById('modalDates').textContent = datesText;
            
            openModal('modalDescricao');
        }

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
<<<<<<< HEAD
        }

        // Função para editar demanda
        async function editarDemanda(id) {
            try {
                const response = await fetch(`../controllers/DemandaController.php?action=get_demanda&id=${id}`);
                if (!response.ok) {
                    throw new Error('Erro ao buscar dados da demanda');
                }
                const data = await response.json();
                
                if (data) {
                    document.getElementById('editId').value = data.id;
                    document.getElementById('editTitulo').value = data.titulo;
                    document.getElementById('editDescricao').value = data.descricao;
                    document.getElementById('editPrioridade').value = data.prioridade;
                    
                    updateEditPrazoCalculadoInfo();
                    openModal('editarDemandaModal');
                } else {
                    alert('Erro ao carregar dados da demanda');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao carregar dados da demanda: ' + error.message);
            }
        }

        // Função para excluir demanda
        function excluirDemanda(id) {
            document.getElementById('demanda_a_excluir_id').value = id;
            openModal('excluirDemandaModal');
        }

        // Atualizar informação de prazo calculado ao selecionar prioridade
        const prioridadeSelect = document.getElementById('prioridade');
        const prazoCalculadoInfo = document.getElementById('prazoCalculadoInfo');

        function updatePrazoCalculadoInfo() {
            const prioridade = prioridadeSelect.value;
            let dias = 0;
            switch (prioridade) {
                case 'baixa': dias = 5; break;
                case 'media': dias = 3; break;
                case 'alta': dias = 1; break;
            }
            prazoCalculadoInfo.innerHTML = `
                <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-primary-500/20 text-primary-50 text-sm font-medium">
                    <i class="fas fa-clock"></i>
                    Prazo: até ${dias} dia${dias > 1 ? 's' : ''}
                </span>
            `;
        }

        updatePrazoCalculadoInfo();
        prioridadeSelect.addEventListener('change', updatePrazoCalculadoInfo);

        // Atualizar informação de prazo calculado no modal de edição
        const editPrioridadeSelect = document.getElementById('editPrioridade');
        const editPrazoCalculadoInfo = document.getElementById('editPrazoCalculadoInfo');

        function updateEditPrazoCalculadoInfo() {
            const prioridade = editPrioridadeSelect.value;
            let dias = 0;
            switch (prioridade) {
                case 'baixa': dias = 5; break;
                case 'media': dias = 3; break;
                case 'alta': dias = 1; break;
            }
            editPrazoCalculadoInfo.innerHTML = `
                <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-primary-500/20 text-primary-50 text-sm font-medium">
                    <i class="fas fa-clock"></i>
                    Prazo: até ${dias} dia${dias > 1 ? 's' : ''}
                </span>
            `;
        }

        editPrioridadeSelect.addEventListener('change', updateEditPrazoCalculadoInfo);

        // Função para realizar tarefa
        function realizarTarefa(demandaId, statusAtual) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../controllers/DemandaController.php';

            const acaoInput = document.createElement('input');
            acaoInput.type = 'hidden';
            acaoInput.name = 'acao';
            acaoInput.value = 'realizar_tarefa';

            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = demandaId;

            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'novo_status';
            statusInput.value = statusAtual === 'em_andamento' ? 'concluida' : 'em_andamento';

            form.appendChild(acaoInput);
            form.appendChild(idInput);
            form.appendChild(statusInput);

            document.body.appendChild(form);
            form.submit();
        }

        function concluirDemanda(demandaId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../controllers/DemandaController.php';
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'acao';
            actionInput.value = 'atualizar_status';
            
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = demandaId;
            
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'novo_status';
            statusInput.value = 'concluida';
            
            form.appendChild(actionInput);
            form.appendChild(idInput);
            form.appendChild(statusInput);
            
            document.body.appendChild(form);
            form.submit();
        }

=======
            
            // Reset multi-selects when closing modals
            if (modalId === 'criarDemandaModal') {
                resetMultiSelect('usuario_id');
            } else if (modalId === 'editarDemandaModal') {
                resetMultiSelect('editar_usuario_id');
            }
        }

        function resetMultiSelect(selectId) {
            if (multiSelectData[selectId]) {
                multiSelectData[selectId].selectedUsers = [];
                multiSelectData[selectId].isOpen = false;
                updateMultiSelectDisplay(selectId);
                updateHiddenSelect(selectId);
                updateOptionStates(selectId);
                
                const container = document.querySelector(`#${selectId}_dropdown`).parentElement.querySelector('.multi-select-container');
                const dropdown = document.getElementById(`${selectId}_dropdown`);
                container.classList.remove('active');
                dropdown.classList.remove('active');
            }
        }

>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        // Filter Functions
        function filterByStatus(status) {
            const containers = [
                'demandasEsperaContainer',
                'demandasAndamentoContainer',
                'demandasConcluidasContainer'
            ];

<<<<<<< HEAD
            containers.forEach(containerId => {
                const container = document.getElementById(containerId);
                if (!container) return;

                const cards = container.querySelectorAll('.demand-card');
                cards.forEach(card => {
                    if (status === 'all') {
                        card.style.display = 'block';
                    } else {
                        const cardStatus = card.dataset.status;
                        card.style.display = cardStatus === status ? 'block' : 'none';
                    }
                });

                updateEmptyState(containerId);
            });

            filterDemands();
=======
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        }

        function filterByPriority(priority) {
            const containers = [
                'demandasEsperaContainer',
                'demandasAndamentoContainer',
                'demandasConcluidasContainer'
            ];

<<<<<<< HEAD
            containers.forEach(containerId => {
                const container = document.getElementById(containerId);
                if (!container) return;

                const cards = container.querySelectorAll('.demand-card');
                cards.forEach(card => {
                    const cardPriority = card.dataset.priority;
                    const cardStatus = card.dataset.status;
                    
                    let isVisibleByPriority = (priority === 'all' || cardPriority === priority);
                    let isVisibleByStatus = true;
                    
                    // Verificar se o card pertence ao container correto
                    if (containerId === 'demandasEsperaContainer' && cardStatus !== 'pendente') {
                        isVisibleByStatus = false;
                    } else if (containerId === 'demandasAndamentoContainer' && cardStatus !== 'em_andamento') {
                        isVisibleByStatus = false;
                    } else if (containerId === 'demandasConcluidasContainer' && cardStatus !== 'concluida') {
                        isVisibleByStatus = false;
                    }
                    
                    card.style.display = (isVisibleByPriority && isVisibleByStatus) ? 'block' : 'none';
                });

                updateEmptyState(containerId);
            });
=======
            cards.forEach(card => {
                if (priority === 'all' || card.dataset.priority === priority) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        }

        function filterDemands() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusSelect = document.querySelector('select[onchange="filterByStatus(this.value)"]');
            const prioritySelect = document.querySelector('select[onchange="filterByPriority(this.value)"]');
            
            const containers = [
                'demandasEsperaContainer',
                'demandasAndamentoContainer',
                'demandasConcluidasContainer'
            ];

<<<<<<< HEAD
            const activeStatus = statusSelect ? statusSelect.value : 'all';
            const activePriority = prioritySelect ? prioritySelect.value : 'all';
=======
            cards.forEach(card => {
                const title = card.dataset.title.toLowerCase();
                const description = card.dataset.description.toLowerCase();
                const status = card.dataset.status;
                const priority = card.dataset.priority;
                const activeStatus = statusSelect.value;
                const activePriority = prioritySelect.value;
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)

            containers.forEach(containerId => {
                const container = document.getElementById(containerId);
                if (!container) return;

                const cards = container.querySelectorAll('.demand-card');
                cards.forEach(card => {
                    const title = card.dataset.title.toLowerCase();
                    const description = card.dataset.description.toLowerCase();
                    const status = card.dataset.status;
                    const priority = card.dataset.priority;

                    const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                    const matchesStatus = activeStatus === 'all' || status === activeStatus;
                    const matchesPriority = activePriority === 'all' || priority === activePriority;

                    let isVisibleByStatus = true;
                    if (containerId === 'demandasEsperaContainer' && status !== 'pendente') {
                        isVisibleByStatus = false;
                    } else if (containerId === 'demandasAndamentoContainer' && status !== 'em_andamento') {
                        isVisibleByStatus = false;
                    } else if (containerId === 'demandasConcluidasContainer' && status !== 'concluida') {
                        isVisibleByStatus = false;
                    }

                    if (matchesSearch && matchesStatus && matchesPriority && isVisibleByStatus) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });

                updateEmptyState(containerId);
            });
        }

<<<<<<< HEAD
        function updateEmptyState(containerId) {
            const container = document.getElementById(containerId);
            if (!container) return;

            const cards = container.querySelectorAll('.demand-card');
            let visibleCount = 0;
=======
        // Edit Demand Function
        function editarDemanda(id) {
            // Reset the edit form
            resetMultiSelect('editar_usuario_id');
            
            document.getElementById('editar_demanda_id').value = '';
            document.getElementById('editar_titulo').value = '';
            document.getElementById('editar_descricao').value = '';
            document.getElementById('editar_prioridade').value = 'media';
            document.getElementById('editar_status').value = 'pendente';
            document.getElementById('editar_prazo').value = '';
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)

            fetch(`../controllers/DemandaController.php?action=get_demanda&id=${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new TypeError("Resposta não é JSON! Content-Type: " + contentType);
                    }
                    
                    return response.text().then(text => {
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('Erro ao fazer parse do JSON:', e);
                            throw new Error('Resposta inválida do servidor');
                        }
                    });
                })
                .then(data => {
                    if (data.error) {
                        console.error('Erro ao buscar dados da demanda:', data.error);
                         if (data.debug_output) {
                             console.error('Saída inesperada de debug:', data.debug_output);
                             alert('Erro ao carregar dados da demanda: ' + data.error + '\nSaída de Debug: ' + data.debug_output);
                         } else {
                        alert('Erro ao carregar dados da demanda: ' + data.error);
                         }
                        return;
                    }
                    
                    if (!data.id || !data.titulo || !data.descricao) {
                        console.error('Dados incompletos recebidos:', data);
                        alert('Dados incompletos recebidos do servidor');
                        return;
                    }
                    
                    document.getElementById('editar_demanda_id').value = data.id;
                    document.getElementById('editar_titulo').value = data.titulo;
                    document.getElementById('editar_descricao').value = data.descricao;
                    document.getElementById('editar_prioridade').value = data.prioridade || 'media';
                    document.getElementById('editar_status').value = data.status || 'pendente';
                    document.getElementById('editar_prazo').value = data.prazo || '';
                    
                    // Set selected users for edit form
                    if (data.usuarios_atribuidos && data.usuarios_atribuidos.length > 0) {
                        initializeMultiSelect('editar_usuario_id');
                        multiSelectData['editar_usuario_id'].selectedUsers = data.usuarios_atribuidos.map(user => ({
                            id: user.id,
                            name: user.nome,
                            email: user.email
                        }));
                        updateMultiSelectDisplay('editar_usuario_id');
                        updateHiddenSelect('editar_usuario_id');
                        updateOptionStates('editar_usuario_id');
                    }
                    
                    openModal('editarDemandaModal');
                })
                .catch(error => {
                    console.error('Erro na requisição AJAX:', error);
                    alert('Erro ao carregar dados da demanda: ' + error.message);
                });
        }

        // Delete Demand Function
        function excluirDemanda(id) {
            document.getElementById('demanda_a_excluir_id').value = id;
            openModal('excluirDemandaModal');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
<<<<<<< HEAD
                const modalId = event.target.id;
                closeModal(modalId);
=======
                event.target.classList.add('hidden');
                event.target.classList.remove('flex');
                document.body.style.overflow = 'auto';
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
<<<<<<< HEAD
                const openModal = document.querySelector('.modal.flex');
                if (openModal) {
                    closeModal(openModal.id);
                }
            }
        });

        // Add loading states to forms
=======
                const openModals = document.querySelectorAll('.modal:not(.hidden)');
                openModals.forEach(modal => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });
                document.body.style.overflow = 'auto';
            }
        });

        // Add loading states to buttons
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<div class="loading"></div> Processando...';
                    submitBtn.disabled = true;
                }
            });
        });

<<<<<<< HEAD
        // Initialize animations and interactions
=======
        // Initialize tooltips and animations
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to cards
            document.querySelectorAll('.demand-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
<<<<<<< HEAD
                    this.style.transform = 'translateY(-10px) scale(1.02)';
=======
                    this.style.transform = 'translateY(-8px) scale(1.02)';
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add click animation to buttons
            document.querySelectorAll('.custom-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> parent of c5d2626 (.)
        function toggleAreaField() {
            const tipoSelect = document.getElementById('tipo');
            const areaField = document.getElementById('areaField');
            
            if (tipoSelect.value.startsWith('adm_area_')) {
                if (areaField) areaField.style.display = 'block';
            } else {
                if (areaField) areaField.style.display = 'none';
            }
<<<<<<< HEAD
=======
=======
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
        function confirmarEmAndamento() {
            return confirm('Tem certeza que deseja marcar esta demanda como Em Andamento?');
        }

        function confirmarConclusao() {
            return confirm('Tem certeza que deseja marcar esta demanda como Concluída?');
<<<<<<< HEAD
>>>>>>> parent of 3f481e1 (finalizando sistema de demandas)
=======
        }

        function confirmarExclusao() {
            const id = document.getElementById('demanda_a_excluir_id').value;
            window.location.href = `../controllers/DemandaController.php?action=excluir&id=${id}`;
        }

        // Function to update assigned users display
        function atualizarUsuariosAtribuidos(demandaId) {
            fetch(`../controllers/DemandaController.php?action=get_demanda&id=${demandaId}`)
                .then(response => response.json())
                .then(data => {
                    const card = document.querySelector(`[data-demanda-id="${demandaId}"]`);
                    if (card && data.usuarios_atribuidos) {
                        const usuariosContainer = card.querySelector('.usuarios-atribuidos');
                        if (usuariosContainer) {
                            const nomes = data.usuarios_atribuidos.map(u => u.nome).join(', ');
                            usuariosContainer.textContent = nomes || 'Não atribuído';
                        }
                    }
                });
>>>>>>> parent of 99d7ac6 (ajustando sistema de chamadas)
=======
>>>>>>> parent of c5d2626 (.)
        }
    </script>
</body>
</html> 
