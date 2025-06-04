<?php
session_start();

require_once __DIR__ . '/../../../main/config/Database.php';
require_once __DIR__ . '/../model/Demanda.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../../../main/config/Database.php';

// Obter o ID do usuário da sessão
$usuario_id = $_SESSION['user_id'] ?? null;

// Obter as conexões com o banco de dados
$conexao = Database::getAreadevConnection();
$pdo_salaberga = Database::getInstance()->getSalabergaConnection();

// Verificar se o usuário está logado
if (!$usuario_id) {
    header('Location: ../../../main/views/autenticacao/login.php');
    exit;
}

// Instanciar o modelo de Demanda
$demandaModel = new Demanda($conexao);

// Processar formulários
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("\n=== PROCESSANDO FORMULÁRIO POST ===");
    error_log("Dados do POST: " . print_r($_POST, true));
    
    if (isset($_POST['acao'])) {
        error_log("Ação detectada: " . $_POST['acao']);
        
        switch ($_POST['acao']) {
            case 'aceitar':
                if (isset($_POST['demanda_id'])) {
                    error_log("Tentando aceitar demanda ID: " . $_POST['demanda_id']);
                    if ($demandaModel->aceitarDemanda($_POST['demanda_id'], $usuario_id)) {
                        error_log("Demanda aceita com sucesso");
                        $_SESSION['mensagem'] = 'Demanda aceita com sucesso!';
                    } else {
                        error_log("ERRO ao aceitar demanda");
                        $_SESSION['erro'] = 'Erro ao aceitar demanda.';
                    }
                }
                break;
            case 'recusar':
                if (isset($_POST['demanda_id'])) {
                    error_log("Tentando recusar demanda ID: " . $_POST['demanda_id']);
                    if ($demandaModel->recusarDemanda($_POST['demanda_id'], $usuario_id)) {
                        error_log("Demanda recusada com sucesso");
                        $_SESSION['mensagem'] = 'Demanda recusada com sucesso.';
                    } else {
                        error_log("ERRO ao recusar demanda");
                        $_SESSION['erro'] = 'Erro ao recusar demanda.';
                    }
                }
                break;
            case 'update_status':
                if (isset($_POST['id']) && isset($_POST['novo_status'])) {
                    error_log("\n=== INÍCIO DO PROCESSAMENTO DE UPDATE_STATUS ===");
                    error_log("Dados recebidos - ID: " . $_POST['id'] . ", Novo Status: " . $_POST['novo_status']);
                    error_log("Usuário ID: " . $usuario_id);
                    
                    if ($_POST['novo_status'] === 'em_andamento') {
                        error_log("Tentando marcar como em_andamento");
                        if ($demandaModel->marcarEmAndamento($_POST['id'], $usuario_id)) {
                            error_log("Status atualizado para em_andamento com sucesso");
                            $_SESSION['mensagem'] = 'Demanda marcada como em andamento!';
                        } else {
                            error_log("ERRO ao marcar como em_andamento");
                            $_SESSION['erro'] = 'Erro ao atualizar status da demanda.';
                        }
                    } elseif ($_POST['novo_status'] === 'concluida') {
                        error_log("Tentando marcar como concluida");
                        if ($demandaModel->marcarConcluida($_POST['id'], $usuario_id)) {
                            error_log("Status atualizado para concluida com sucesso");
                            $_SESSION['mensagem'] = 'Demanda marcada como concluída!';
                        } else {
                            error_log("ERRO ao marcar como concluida");
                            error_log("Detalhes do erro: " . print_r(error_get_last(), true));
                            $_SESSION['erro'] = 'Erro ao atualizar status da demanda.';
                        }
                    }
                    error_log("=== FIM DO PROCESSAMENTO DE UPDATE_STATUS ===\n");
                }
                break;
        }
    }
}

// Adicionar no início do arquivo, após os requires
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'update_status') {
    header('Content-Type: application/json');
    try {
        if (!isset($_POST['id']) || !isset($_POST['novo_status'])) {
            throw new Exception('Parâmetros inválidos');
        }

        $demandaId = $_POST['id'];
        $novoStatus = $_POST['novo_status'];
        $usuarioId = $_SESSION['user_id'];

        error_log("\n=== PROCESSANDO UPDATE_STATUS ===");
        error_log("Demanda ID: $demandaId");
        error_log("Novo Status: $novoStatus");
        error_log("Usuário ID: $usuarioId");

        if ($novoStatus === 'concluida') {
            if ($demandaModel->marcarConcluida($demandaId, $usuarioId)) {
                echo json_encode(['success' => true, 'message' => 'Status atualizado com sucesso']);
            } else {
                throw new Exception('Erro ao atualizar status');
            }
        } else if ($novoStatus === 'em_andamento') {
            if ($demandaModel->marcarEmAndamento($demandaId, $usuarioId)) {
                echo json_encode(['success' => true, 'message' => 'Status atualizado com sucesso']);
            } else {
                throw new Exception('Erro ao atualizar status');
            }
        } else {
            throw new Exception('Status inválido');
        }
    } catch (Exception $e) {
        error_log("Erro ao processar update_status: " . $e->getMessage());
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Buscar demandas do usuário
$demandas = $demandaModel->listarDemandasPorUsuario($usuario_id);

error_log("\n=== DEBUG GERAL DE DEMANDAS EM USUARIO.PHP (APÓS LISTAGEM) ===");
error_log("Usuário ID logado: " . $usuario_id);
error_log("Número total de demandas listadas pela função: " . count($demandas));
error_log("Conteúdo completo da variável \$demandas: " . print_r($demandas, true));

// Filtrar demandas por status
$demandas_espera = array_filter($demandas, function($demanda) use ($usuario_id) {
    // Use o status_usuario se existir, caso contrário, use o status geral
    $status_final = $demanda['status_usuario'] ?? $demanda['status'];
    error_log("DEBUG FILTER ESPERA - Demanda ID: " . ($demanda['id'] ?? 'N/A') . ", Status Usuário (direto): " . ($demanda['status_usuario'] ?? 'N/A') . ", Status Geral (direto): " . ($demanda['status'] ?? 'N/A') . ", Status Final para Lógica: " . $status_final);
    return $status_final === 'pendente';
});

$demandas_andamento = array_filter($demandas, function($demanda) use ($usuario_id) {
    // Use o status_usuario se existir, caso contrário, use o status geral
    $status_final = $demanda['status_usuario'] ?? $demanda['status'];
     error_log("DEBUG FILTER ANDAMENTO - Demanda ID: " . ($demanda['id'] ?? 'N/A') . ", Status Final: " . $status_final);
    return $status_final === 'em_andamento';
});

$demandas_concluidas = array_filter($demandas, function($demanda) use ($usuario_id) {
    // Use o status_usuario se existir, caso contrário, use o status geral
    $status_final = $demanda['status_usuario'] ?? $demanda['status'];
     error_log("DEBUG FILTER CONCLUIDAS - Demanda ID: " . ($demanda['id'] ?? 'N/A') . ", Status Final: " . $status_final);
    // Incluir ambos 'concluido' (status do usuário) e 'concluida' (status da demanda)
    return $status_final === 'concluido' || $status_final === 'concluida';
});

error_log("\n=== DEBUG RESUMO DOS FILTROS EM USUARIO.PHP ===");
error_log("Demandas em espera (após filtro): " . count($demandas_espera));
error_log("Demandas em andamento (após filtro): " . count($demandas_andamento));
error_log("Demandas concluídas (após filtro): " . count($demandas_concluidas));
error_log("Conteúdo completo das demandas em espera: " . print_r($demandas_espera, true));
error_log("Conteúdo completo das demandas em andamento: " . print_r($demandas_andamento, true));
error_log("Conteúdo completo das demandas concluídas: " . print_r($demandas_concluidas, true));

// Calcular estatísticas
$total_demandas = count($demandas);
$total_espera = count($demandas_espera);
$total_andamento = count($demandas_andamento);
$total_concluidas = count($demandas_concluidas);

error_log("\n=== ESTATÍSTICAS ===");
error_log("Total de demandas: $total_demandas");
error_log("Em espera: $total_espera");
error_log("Em andamento: $total_andamento");
error_log("Concluídas: $total_concluidas");

// Adicionar logs no console via JavaScript
echo "<script>
console.log('=== DEBUG DE DEMANDAS ===');
console.log('Total de demandas:', " . json_encode($total_demandas) . ");
console.log('Demandas em espera:', " . json_encode($total_espera) . ");
console.log('Demandas em andamento:', " . json_encode($total_andamento) . ");
console.log('Demandas concluídas:', " . json_encode($total_concluidas) . ");
console.log('Detalhes das demandas:', " . json_encode($demandas) . ");
console.log('Demandas em espera:', " . json_encode($demandas_espera) . ");
console.log('Demandas em andamento:', " . json_encode($demandas_andamento) . ");
console.log('Demandas concluídas:', " . json_encode($demandas_concluidas) . ");
</script>";

// Verificar permissões do usuário
error_log("\n=== VERIFICANDO PERMISSÕES DO USUÁRIO ===");
$stmt = $pdo_salaberga->prepare("
    SELECT p.descricao 
    FROM usu_sist us
    INNER JOIN sist_perm sp ON us.sist_perm_id = sp.id
    INNER JOIN permissoes p ON sp.permissao_id = p.id
    WHERE us.usuario_id = ? AND sp.sistema_id = 3
");
$stmt->execute([$usuario_id]);
$permissoes = $stmt->fetchAll(PDO::FETCH_COLUMN);
error_log("Permissões do usuário: " . print_r($permissoes, true));

// Verificar se é admin
$is_admin = false;
foreach ($permissoes as $permissao) {
    if (strpos($permissao, 'adm_') === 0) {
        $is_admin = true;
        break;
    }
}
error_log("Usuário é admin? " . ($is_admin ? 'Sim' : 'Não'));

// --- Início do código para obter a área do usuário --- //
$user_area = 'Não Definida'; // Valor padrão
if (isset($_SESSION['user_systems_permissions']) && is_array($_SESSION['user_systems_permissions'])) {
    error_log("DEBUG: Verificando permissões do usuário");
    foreach ($_SESSION['user_systems_permissions'] as $permission_info) {
        error_log("DEBUG PERMISSION INFO: " . print_r($permission_info, true));
        if ((isset($permission_info['sistema_nome']) && $permission_info['sistema_nome'] === 'Demandas') || 
            (isset($permission_info['sistema_id']) && $permission_info['sistema_id'] === 3)) {
            if (isset($permission_info['permissao_descricao'])) {
                $permissao = $permission_info['permissao_descricao'];
                error_log("DEBUG PERMISSÃO ENCONTRADA: " . $permissao);
                if (strpos($permissao, 'usuario_') === 0) {
                    $area_slug = substr($permissao, strlen('usuario_'));
                    $user_area = ucfirst(str_replace('_', ' ', $area_slug));
                    error_log("DEBUG ÁREA DEFINIDA (usuario): " . $user_area);
                    break;
                } elseif (strpos($permissao, 'adm_area_') === 0) {
                    $area_slug = substr($permissao, strlen('adm_area_'));
                    $user_area = 'Admin ' . ucfirst(str_replace('_', ' ', $area_slug));
                    error_log("DEBUG ÁREA DEFINIDA (admin): " . $user_area);
                    break;
                }
            }
        }
    }
}
error_log("DEBUG ÁREA FINAL DO USUÁRIO: " . $user_area);
// --- Fim do código para obter a área do usuário --- //

// Calcular estatísticas
$totalDemandas = count($demandas);
$demandasPendentes = count($demandas_espera);
$demandasEmAndamento = count($demandas_andamento);
$demandasConcluidas = count($demandas_concluidas);

// DEBUG: Adicionado para verificar o status do usuário antes de exibir os botões
echo '<script>';
echo 'console.log("DEBUG - Status do usuário para cada demanda:");';
foreach ($demandas as $d) {
    $usuario_logado_atribuido = false;
    $status_usuario_debug = null;
    if (!empty($d['usuarios_atribuidos'])) {
        foreach ($d['usuarios_atribuidos'] as $u_atrib) {
            if ($u_atrib['id'] == $usuario_id) {
                $usuario_logado_atribuido = true;
                $status_usuario_debug = $u_atrib['status'];
                break;
            }
        }
    }
    echo 'console.log("  Demanda ID: ' . $d['id'] . ', Status Usuário: ' . ($status_usuario_debug ?? 'null') . ', Atribuído: ' . ($usuario_logado_atribuido ? 'Sim' : 'Não') . '");';
    echo 'console.log("  Usuários Atribuídos: " + ' . json_encode($d['usuarios_atribuidos']) . ');';
}
echo '</script>';

// Debug no console
echo '<script>';
echo 'console.log("=== DEBUG DAS DEMANDAS ===");';
echo 'console.log("Usuário ID:", ' . json_encode($usuario_id) . ');';
echo 'console.log("Total de demandas:", ' . count($demandas) . ');';
echo 'console.log("Demandas:", ' . json_encode($demandas) . ');';
echo 'console.log("=== DEMANDAS EM ESPERA ===");';
echo 'console.log("Total de demandas em espera:", ' . count($demandas_espera) . ');';
echo 'console.log("Demandas em espera:", ' . json_encode($demandas_espera) . ');';
echo 'console.log("=== DEMANDAS EM ANDAMENTO ===");';
echo 'console.log("Total de demandas em andamento:", ' . count($demandas_andamento) . ');';
echo 'console.log("Demandas em andamento:", ' . json_encode($demandas_andamento) . ');';
echo 'console.log("=== DEMANDAS CONCLUÍDAS ===");';
echo 'console.log("Total de demandas concluídas:", ' . count($demandas_concluidas) . ');';
echo 'console.log("Demandas concluídas:", ' . json_encode($demandas_concluidas) . ');';
echo '</script>';
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Painel do Usuário - Sistema de Gestão de Demandas">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Painel do Usuário - Sistema de Gestão de Demandas</title>
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

    .status-aceito { /* Adicionado */
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-aceito i { /* Adicionado */
        color: #4ade80;
    }

    .status-em_andamento {
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

    .status-concluido { /* Para status de participante */
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-concluido i { /* Para status de participante */
        color: #4ade80;
    }

    .status-cancelada {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .status-cancelada i {
        color: #f87171;
    }

    /* Adicionando estilos para status recusado */
     .status-recusado {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

     .status-recusado i {
        color: #f87171;
    }

    /* Priority Badges */
    .priority-badge {
        padding: 0.2rem 0.5rem;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 600;
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
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(12px);
        transition: all 0.3s ease;
    }

    .modal-content {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border: 1px solid rgba(0, 122, 51, 0.2);
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
        border-radius: 24px;
        backdrop-filter: blur(20px);
        max-height: 90vh;
        overflow-y: auto;
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
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
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

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #1a1a1a;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
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
    }

    /* Responsive */
    @media (max-width: 768px) {
        .demand-card {
            padding: 1.25rem;
            margin-bottom: 0.75rem;
        }
        
        .stats-card {
            padding: 1.5rem;
        }
        
        .search-container {
            padding: 1.5rem;
        }
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

    .demand-card h3 { /* Ajustando tamanho da fonte do título */
        font-size: 1.25rem; /* Increased font size */
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
        font-size: 0.75rem;
        color: #888888;
        background: rgba(0, 0, 0, 0.2);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        display: inline-block;
    }
</style>

<body class="select-none">
    <!-- Header -->
    <header class="bg-dark-400 shadow-lg border-b border-primary-500/20 sticky top-0 z-50 backdrop-blur-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Logo e Título -->
                <div class="flex items-center gap-3 w-full sm:w-auto justify-center sm:justify-start">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="w-10 h-10">
                    <div class="text-center sm:text-left">
                        <h1 class="text-xl md:text-2xl font-bold bg-gradient-to-r from-primary-50 to-primary-200 bg-clip-text text-transparent">
                            Painel do Usuário
                        </h1>
                        <p class="text-sm text-gray-400">Sistema de Gestão de Demandas</p>
                    </div>
                </div>

                <!-- Botões e Informações do Usuário -->
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                    <!-- Informações do Usuário -->
                    <div class="flex items-center gap-2 text-gray-300 bg-dark-300/50 px-4 py-2 rounded-lg">
                        <i class="fas fa-user text-primary-50"></i>
                        <span class="text-sm truncate max-w-[200px]"><?php echo htmlspecialchars($_SESSION['Nome']); ?></span>
                        <!-- Adicionar box com o nome da área -->
                        <span class="bg-primary-600 text-white text-xs font-semibold px-2.5 py-0.5 rounded-full">
                            <?php echo htmlspecialchars($user_area); ?>
                        </span>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center gap-2 w-full sm:w-auto justify-center sm:justify-end">
                        <a href="relatorio.php" class="custom-btn bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm w-full sm:w-auto justify-center">
                            <i class="fas fa-chart-bar btn-icon"></i>
                            <span>Relatórios</span>
                        </a>
                        <a href="../../../main/views/autenticacao/login.php?sair=true" class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm w-full sm:w-auto justify-center">
                            <i class="fas fa-sign-out-alt btn-icon"></i>
                            <span>Sair</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <!-- Stats Cards -->


        <!-- Search and Filters -->
        <div class="search-container slide-up" style="animation-delay: 0.6s">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="flex-1 w-full lg:max-w-md">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Buscar suas demandas..." 
                            class="custom-input w-full pl-12"
                            onkeyup="filterDemands()"
                        >
                    </div>
                </div>

                <div class="flex flex-wrap gap-4">
                    <div class="select-wrapper">
                        <select class="custom-select" onchange="filterByStatus(this.value)">
                            <option value="all">Todas as Demandas</option>
                            <option value="pendente">Em Espera</option>
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
            </div>
        </div>

        <!-- Demands Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <i class="fas fa-clipboard-list text-primary-50"></i>
                Minhas Demandas
            </h2>
            
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
                        // Ordenar por prioridade
                        usort($demandas_espera, function($a, $b) {
                            $prioridades = ['alta' => 3, 'media' => 2, 'baixa' => 1];
                            return $prioridades[$b['prioridade']] - $prioridades[$a['prioridade']];
                        });
                        
                        foreach ($demandas_espera as $d): 
                            $d['status'] = $d['status_usuario'] ?? $d['status'];
                        ?>
                        <div class="demand-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300"
                            data-title="<?php echo htmlspecialchars($d['titulo']); ?>"
                            data-description="<?php echo htmlspecialchars($d['descricao']); ?>"
                            data-status="<?php echo $d['status']; ?>"
                            data-priority="<?php echo $d['prioridade']; ?>">
                            <?php include 'components/user_demand_card.php'; ?>
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
                        // Ordenar por prioridade
                        usort($demandas_andamento, function($a, $b) {
                            $prioridades = ['alta' => 3, 'media' => 2, 'baixa' => 1];
                            return $prioridades[$b['prioridade']] - $prioridades[$a['prioridade']];
                        });
                        
                        foreach ($demandas_andamento as $d): 
                            $d['status'] = $d['status_usuario'] ?? $d['status'];
                        ?>
                        <div class="demand-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300"
                            data-title="<?php echo htmlspecialchars($d['titulo']); ?>"
                            data-description="<?php echo htmlspecialchars($d['descricao']); ?>"
                            data-status="<?php echo $d['status']; ?>"
                            data-priority="<?php echo $d['prioridade']; ?>">
                            <?php include 'components/user_demand_card.php'; ?>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if (empty($demandas_andamento)): ?>
                        <div class="empty-state">
                            <i class="fas fa-tasks"></i>
                            <h3 class="text-xl font-semibold mb-2">Nenhuma demanda em andamento</h3>
                            <p>Não há demandas sendo trabalhadas no momento.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Coluna Concluídas -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500"></i>
                        Concluídas
                    </h3>
                    <div id="demandasConcluidasContainer" class="space-y-4">
                        <?php 
                        // Ordenar por prioridade
                        usort($demandas_concluidas, function($a, $b) {
                            $prioridades = ['alta' => 3, 'media' => 2, 'baixa' => 1];
                            return $prioridades[$b['prioridade']] - $prioridades[$a['prioridade']];
                        });
                        
                        foreach ($demandas_concluidas as $d): 
                            $d['status'] = $d['status_usuario'] ?? $d['status'];
                        ?>
                        <div class="demand-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300"
                            data-title="<?php echo htmlspecialchars($d['titulo']); ?>"
                            data-description="<?php echo htmlspecialchars($d['descricao']); ?>"
                            data-status="<?php echo $d['status']; ?>"
                            data-priority="<?php echo $d['prioridade']; ?>">
                            <?php include 'components/user_demand_card.php'; ?>
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
            </div>
        </div>
    </main>

    <!-- Modal de Descrição -->
    <div id="modalDescricao" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-2xl p-8 scale-in">
            <div class="flex justify-between items-start mb-6">
                <h3 id="modalTitulo" class="text-2xl font-bold text-white pr-4"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white transition-colors p-2">
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
                <button onclick="closeModal()" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg">
                    Fechar
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
            
            document.getElementById('modalDescricao').classList.remove('hidden');
            document.getElementById('modalDescricao').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modalDescricao').classList.add('hidden');
            document.getElementById('modalDescricao').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Filter Functions
        function filterByStatus(status) {
            console.log("=== FILTRANDO POR STATUS ===");
            console.log("Status selecionado:", status);
            
            const cards = document.querySelectorAll('.demand-card');
            console.log("Total de cards encontrados:", cards.length);
            
            const containers = {
                'demandasEsperaContainer': 'pendente',
                'demandasAndamentoContainer': 'em_andamento',
                'demandasConcluidasContainer': 'concluida'
            };

            cards.forEach(card => {
                const cardStatus = card.dataset.status;
                console.log("Card status:", cardStatus);
                
                let isVisible = false;
                if (status === 'all') {
                    isVisible = true;
                } else {
                    isVisible = cardStatus === status;
                }
                console.log("Card será visível?", isVisible);

                card.style.display = isVisible ? 'block' : 'none';
            });

            // Atualiza o estado vazio para cada container
            Object.keys(containers).forEach(containerId => {
                updateEmptyState(containerId);
            });
            
            // Reaplica outros filtros (texto e prioridade)
            filterDemands();
        }

        function filterByPriority(priority) {
            console.log("=== FILTRANDO POR PRIORIDADE ===");
            console.log("Prioridade selecionada:", priority);
            
            const cards = document.querySelectorAll('.demand-card');
            console.log("Total de cards encontrados:", cards.length);

            cards.forEach(card => {
                const cardPriority = card.dataset.priority;
                console.log("Card prioridade:", cardPriority);
                
                let isVisibleByPriority = (priority === 'all' || cardPriority === priority);
                console.log("Card será visível?", isVisibleByPriority);
                
                card.style.display = isVisibleByPriority ? 'block' : 'none';
            });
            
            // Reaplica o filtro de texto e status
            filterDemands();
        }

        function filterDemands() {
            console.log("=== FILTRANDO DEMANDAS ===");
            
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusSelect = document.querySelector('select[onchange="filterByStatus(this.value)"]');
            const prioritySelect = document.querySelector('select[onchange="filterByPriority(this.value)"]');
            const cards = document.querySelectorAll('.demand-card');
            
            const activeStatus = statusSelect ? statusSelect.value : 'all';
            const activePriority = prioritySelect ? prioritySelect.value : 'all';
            
            console.log("Termo de busca:", searchTerm);
            console.log("Status ativo:", activeStatus);
            console.log("Prioridade ativa:", activePriority);
            console.log("Total de cards:", cards.length);

            cards.forEach(card => {
                const title = card.dataset.title.toLowerCase();
                const description = card.dataset.description.toLowerCase();
                const status = card.dataset.status;
                const priority = card.dataset.priority;

                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                const matchesPriority = activePriority === 'all' || priority === activePriority;
                const matchesStatus = activeStatus === 'all' || status === activeStatus;

                console.log("Card:", {
                    title,
                    status,
                    priority,
                    matchesSearch,
                    matchesPriority,
                    matchesStatus
                });

                card.style.display = (matchesSearch && matchesStatus && matchesPriority) ? 'block' : 'none';
            });

            // Atualiza o estado vazio para cada container
            const containers = {
                'demandasEsperaContainer': 'pendente',
                'demandasAndamentoContainer': 'em_andamento',
                'demandasConcluidasContainer': 'concluida'
            };

            Object.keys(containers).forEach(containerId => {
                updateEmptyState(containerId);
            });
        }

        // Função para atualizar o estado vazio de um container específico
        function updateEmptyState(containerId) {
            console.log("=== ATUALIZANDO ESTADO VAZIO ===");
            console.log("Container ID:", containerId);
            
            const container = document.getElementById(containerId);
            if (!container) {
                console.log("Container não encontrado!");
                return;
            }

            const cards = container.querySelectorAll('.demand-card');
            let visibleCount = 0;

            cards.forEach(card => {
                if (card.style.display !== 'none') {
                    visibleCount++;
                }
            });

            console.log("Total de cards visíveis:", visibleCount);

            const emptyState = container.querySelector('.empty-state');
            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
                console.log("Estado vazio será exibido?", visibleCount === 0);
            } else {
                console.log("Elemento empty-state não encontrado!");
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.id === 'modalDescricao') {
                closeModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Add loading states to forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<div class="loading"></div> Processando...';
                    submitBtn.disabled = true;
                }
            });
        });

        // Initialize animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to cards
            document.querySelectorAll('.demand-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
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

            // Atualizar estados vazios inicialmente
            const containers = {
                'demandasEsperaContainer': 'pendente',
                'demandasAndamentoContainer': 'em_andamento',
                'demandasConcluidasContainer': 'concluida'
            };

            Object.keys(containers).forEach(containerId => {
                updateEmptyState(containerId);
            });
        });

        async function realizarTarefa(demandaId, statusAtual) {
            try {
                console.log('=== INÍCIO DA ATUALIZAÇÃO DE STATUS (usuario.php) ===');
                console.log('Dados iniciais (usuario.php):', { demandaId, statusAtual });

                const formData = new FormData();
                formData.append('id', demandaId);
                formData.append('acao', 'atualizar_status');
                const novoStatus = statusAtual === 'em_andamento' ? 'concluida' : 'em_andamento';
                formData.append('novo_status', novoStatus);

                console.log('Dados sendo enviados (usuario.php):', {
                    id: demandaId,
                    acao: 'atualizar_status',
                    novo_status: novoStatus
                });

                const url = new URL('../controllers/DemandaController.php', window.location.href).href;
                console.log('URL da requisição (usuario.php):', url);

                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                console.log('Resposta recebida (usuario.php):', {
                    status: response.status,
                    statusText: response.statusText
                });

                if (!response.ok) {
                    const errorData = await response.json(); 
                    throw new Error(errorData.error || 'Erro na requisição: Status ' + response.status);
                }

                const data = await response.json();
                console.log('Resposta em JSON (usuario.php):', data);

                if (!data.success) {
                    throw new Error(data.error || 'Erro ao atualizar status');
                }

                // Se chegou aqui, a atualização foi bem sucedida
                window.location.reload();
            } catch (error) {
                console.error('Erro (usuario.php):', error);
                alert('Erro ao processar a ação: ' + error.message);
            }
        }
    </script>
</body>
</html> 