<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../model/Demanda.php';
require_once __DIR__ . '/../model/Usuario.php';

// Verificar se é admin


// Inicializa a conexão com o banco de dados
$database = new Database();
$pdo = $database->getConnection();

$demanda = new Demanda($pdo);
$usuario = new Usuario($pdo);

// Processar criação de demanda
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] === 'criar') {
        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $prioridade = $_POST['prioridade'] ?? 'media';
        $prazo = $_POST['prazo'] ?? null;

        if (!empty($titulo) && !empty($descricao)) {
            $sucesso = $demanda->criarDemanda($titulo, $descricao, $prioridade, $_SESSION['usuario_id'], [], $prazo);
            if ($sucesso) {
                header("Location: admin.php?success=Demanda criada com sucesso!");
                exit();
            } else {
                $erro = "Erro ao criar demanda. Por favor, tente novamente.";
            }
        }
    } elseif ($_POST['acao'] === 'excluir' && isset($_POST['id'])) {
        $demanda->excluirDemanda($_POST['id']);
        header("Location: admin.php");
        exit();
    } elseif ($_POST['acao'] === 'atualizar_status' && isset($_POST['id'])) {
        // Verifica se um novo status foi enviado e atualiza
        if (isset($_POST['novo_status'])) {
            $novo_status = $_POST['novo_status'];
            $id_demanda = $_POST['id'];
            // Adicione lógica para validar o novo status, se necessário
            
            if ($novo_status === 'concluida') {
                 $demanda->marcarConcluida($id_demanda);
            } elseif ($novo_status === 'em_andamento') {
                 $demanda->marcarEmAndamento($id_demanda);
            }
            // Adicione outras transições de status aqui, se houver
        }
        header("Location: admin.php");
        exit();
    }
}

$demandas = $demanda->listarDemandas();
$usuarios = $usuario->listarUsuarios();

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
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(0, 122, 51, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        padding: 1.25rem; /* Padding padrão para o card */
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
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 122, 51, 0.15);
        border-color: rgba(0, 255, 107, 0.3);
    }

    .demand-card:hover::before {
        transform: scaleX(1);
    }

    .demand-card.no-participants {
        /* Ajusta o padding inferior e potencialmente outros espaçamentos */
        padding-bottom: 1.5rem; /* Aumenta ligeiramente o padding inferior */
        /* Adicionar outras regras se necessário para reduzir espaço vertical */
    }

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
        padding-top: 0.75rem; /* Espaço acima dos botões de ação */
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card-actions {
        display: flex;
        gap: 0.375rem;
    }

    .card-participants {
        margin-top: 0.75rem; /* Espaço entre o rodapé e a lista de participantes */
        padding-top: 0.75rem; /* Espaço interno acima da lista de participantes */
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .participants-title {
        font-size: 0.813rem;
        color: #888888;
        margin-bottom: 0.5rem;
    }

    .participants-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .participants-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .participant-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        padding: 0.5rem;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .participant-item:hover {
        background: rgba(0, 0, 0, 0.2);
    }

    .participant-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.5rem;
    }

    .participant-name {
        font-weight: 500;
        color: #ffffff;
    }

    .participant-completion {
        font-size: 0.75rem;
        color: #888888;
        padding-left: 0.5rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-top: 0;
        margin-bottom: 0;
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

    .status-aceito {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-recusado {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .status-em_andamento {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.1));
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .status-concluida {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }
    
    .status-concluida i {
        color: #4ade80;
    }

    .status-cancelada {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
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
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        transition: all 0.3s ease;
    }

    .modal-content {
        background: linear-gradient(145deg, rgba(45, 45, 45, 0.98), rgba(35, 35, 35, 0.95));
        border: 1px solid rgba(0, 122, 51, 0.2);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        border-radius: 24px;
        backdrop-filter: blur(20px);
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

    /* Input Styles */
    .custom-input, .custom-select {
        background: rgba(35, 35, 35, 0.95);
        border: 2px solid rgba(0, 122, 51, 0.2);
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        color: #ffffff;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .custom-input:focus, .custom-select:focus {
        border-color: #00FF6B;
        box-shadow: 0 0 0 4px rgba(0, 255, 107, 0.1);
        outline: none;
        background: rgba(35, 35, 35, 1);
    }

    .custom-input::placeholder {
        color: #888888;
        font-weight: 400;
    }

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
        bottom: 100%; /* Position above the container */
        left: 0;
        right: 0;
        background: rgba(35, 35, 35, 0.98);
        border: 2px solid rgba(0, 122, 51, 0.2);
        border-radius: 12px;
        margin-bottom: 4px; /* Space between container and dropdown */
        max-height: 200px; /* Limit height */
        overflow-y: auto;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px); /* Start slightly below */
        transition: all 0.3s ease;
        backdrop-filter: blur(10px); /* Optional: add blur effect */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); /* Optional: add shadow */
    }

    .multi-select-dropdown.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0); /* Slide up to final position */
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
    }

    .prazo-info-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background: rgba(0, 122, 51, 0.2); /* Subtle green background */
        color: #4ade80; /* Green text color */
        font-size: 0.875rem;
        font-weight: 500;
        border: 1px solid rgba(0, 122, 51, 0.3);
    }

    .prazo-info-badge i {
        color: #00FF6B; /* Brighter green icon */
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
                            Painel Administrativo
                        </h1>
                        <p class="text-sm text-gray-400">Sistema de Gestão de Demandas</p>
                    </div>
                </div>

                <!-- Botões e Informações do Usuário -->
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                    <!-- Informações do Usuário -->
                    <div class="flex items-center gap-2 text-gray-300 bg-dark-300/50 px-4 py-2 rounded-lg">
                        <i class="fas fa-user-shield text-primary-50"></i>
                        <span class="text-sm truncate max-w-[200px]"><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center gap-2 w-full sm:w-auto justify-center sm:justify-end">
                        <a href="relatorio.php" class="custom-btn bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm w-full sm:w-auto justify-center">
                            <i class="fas fa-chart-bar btn-icon"></i>
                            <span>Relatórios</span>
                        </a>
                        <a href="logout.php" class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm w-full sm:w-auto justify-center">
                            <i class="fas fa-sign-out-alt btn-icon"></i>
                            <span>Sair</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <?php if (!empty($erro)): ?>
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg mb-6 fade-in">
            <div class="flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($erro); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Espaço restaurado antes dos filtros -->
        <div style="height: 2rem;"></div>

        <!-- Search and Filters -->
        <div class="search-container slide-up" style="animation-delay: 0.5s">
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

        <!-- Demands Cards -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <i class="fas fa-tasks text-primary-50"></i>
                Gerenciar Demandas
            </h2>
            
            <!-- Seção Em Espera -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-white mb-4">Em Espera</h3>
                <div id="demandasEsperaContainer" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 items-start">
                    <?php 
                    $count_espera = 0;
                    foreach ($demandas as $index => $d): 
                        // Verifica se o status é 'pendente' para a seção 'Em Espera'
                        if ($d['status'] === 'pendente'):
                            $count_espera++;
                    ?>
                
                <?php
                    // Determina se há participantes atribuídos para ajustar o padding
                    $has_participants = !empty($d['usuarios_atribuidos']);
                    ?>

                    <div class="demand-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300 <?php echo $has_participants ? '' : 'no-participants'; ?>"
                    data-title="<?php echo htmlspecialchars($d['titulo']); ?>"
                    data-description="<?php echo htmlspecialchars($d['descricao']); ?>"
                    data-status="<?php echo $d['status']; ?>"
                    data-priority="<?php echo $d['prioridade']; ?>">
                    
                    <!-- Card Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white mb-2 line-clamp-2 cursor-pointer hover:text-primary-50 transition-colors duration-300"
                                onclick="mostrarDescricao('<?php echo htmlspecialchars($d['titulo']); ?>', '<?php echo htmlspecialchars($d['descricao']); ?>', '<?php echo $d['status']; ?>', '<?php echo date('d/m/Y H:i', strtotime($d['data_criacao'])); ?>', '<?php echo !empty($d['data_conclusao']) ? date('d/m/Y H:i', strtotime($d['data_conclusao'])) : ''; ?>')">
                                <?php echo htmlspecialchars($d['titulo']); ?>
                            </h3>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="status-badge status-<?php echo $d['status']; ?>">
                                    <?php
                                    $statusIcons = [
                                        'pendente' => 'fas fa-clock',
                                        'em_andamento' => 'fas fa-spinner fa-spin',
                                        'concluida' => 'fas fa-check-circle',
                                        'cancelada' => 'fas fa-ban',
                                        'aceito' => 'fas fa-check-circle'
                                    ];
                                    
                                    $display_status = $d['status'];
                                    $display_icon = $statusIcons[$display_status] ?? 'fas fa-question';

                                        // Lógica para status do card baseado no participante único concluído (se houver)
                                    if (!empty($d['usuarios_atribuidos']) && count($d['usuarios_atribuidos']) === 1) {
                                                        $single_participant_status = $d['usuarios_atribuidos'][0]['status'] ?? null;
                                                        if ($single_participant_status === 'concluido') {
                                                $display_status = 'concluida';
                                                            $display_icon = $statusIcons[$display_status] ?? 'fas fa-question';
                                                        }
                                                    }
                                    
                                        $status_display = ucfirst(str_replace('_', ' ', $display_status));
                                    ?>
                                    <i class="<?php echo $display_icon; ?>"></i>
                                    <?php echo $status_display; ?>
                                </span>
                                <span class="priority-badge priority-<?php echo $d['prioridade']; ?>">
                                    <?php echo ucfirst($d['prioridade']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-gray-400">ID: #<?php echo $d['id']; ?></span>
                        </div>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="mb-4">
                        <p class="text-gray-300 text-sm line-clamp-3 mb-3">
                            <?php echo htmlspecialchars($d['descricao']); ?>
                        </p>
                        
                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-gray-400">Criado em:</span>
                                <p class="text-white font-medium">
                                    <?php echo date('d/m/Y', strtotime($d['data_criacao'])); ?>
                                </p>
                                <p class="text-gray-400">
                                    <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
                                </p>
                            </div>
                            <div>
                                    <?php if ($d['status'] === 'concluida'): ?>
                                        <span class="text-gray-400">Concluído em:</span>
                                <p class="text-white font-medium">
                                            <?php echo date('d/m/Y', strtotime($d['data_conclusao'])); ?>
                                        </p>
                                        <p class="text-gray-400">
                                            <?php echo date('H:i', strtotime($d['data_conclusao'])); ?>
                                        </p>
                                    <?php else: ?>
                                        <span class="text-gray-400">Prazo:</span>
                                    <?php 
                                        $dias_prazo = 0;
                                        switch ($d['prioridade']) {
                                            case 'baixa':
                                                $dias_prazo = 5;
                                                break;
                                            case 'media':
                                                $dias_prazo = 3;
                                                break;
                                            case 'alta':
                                                $dias_prazo = 1;
                                                break;
                                        }
                                        $data_prazo = date('d/m/Y', strtotime($d['data_criacao'] . " +{$dias_prazo} days"));
                                        $data_prazo_hora = date('H:i', strtotime($d['data_criacao']));
                                        ?>
                                        <p class="text-white font-medium">
                                            <?php echo $data_prazo; ?>
                                        </p>
                                <p class="text-gray-400">
                                            <?php echo $data_prazo_hora; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                            <div class="flex items-center gap-2">
                                <?php if ($d['status'] !== 'concluida'): ?>
                                    <?php if ($d['status'] === 'pendente'): ?>
                                        <button onclick="realizarTarefa(<?php echo $d['id']; ?>, '<?php echo $d['status']; ?>')" 
                                                class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg transition-all duration-300 flex items-center gap-2">
                                            <i class="fas fa-tasks"></i>
                                            Realizar Tarefa
                        </button>
                                    <?php elseif ($d['status'] === 'em_andamento'): ?>
                                        <button onclick="concluirDemanda(<?php echo $d['id']; ?>)" 
                                                class="custom-btn bg-green-600 hover:bg-green-700 text-white py-1 px-2 rounded-lg transition-all duration-300 flex items-center gap-2">
                                            <i class="fas fa-check"></i>
                                            Concluir
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <button onclick="editarDemanda(<?php echo $d['id']; ?>)" class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="excluirDemanda(<?php echo $d['id']; ?>)" class="custom-btn bg-red-600 hover:bg-red-700 text-white py-1 px-2 rounded-lg" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Status dos Usuários -->
                        <?php if (!empty($d['usuarios_atribuidos'])): ?>
                        <div class="mt-4 pt-4 border-t border-gray-700">
                            <h4 class="text-sm font-semibold text-gray-400 mb-2">Status dos Participantes:</h4>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($d['usuarios_atribuidos'] as $u_atrib): ?>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-300"><?php echo htmlspecialchars($u_atrib['nome']); ?>:</span>
                                        <span class="status-badge status-<?php echo $u_atrib['status']; ?>">
                                            <?php
                                            $statusIconsParticipante = [
                                                'pendente' => 'fas fa-clock',
                                                'aceito' => 'fas fa-check-circle',
                                                'em_andamento' => 'fas fa-spinner fa-spin',
                                                'concluido' => 'fas fa-check-circle',
                                                'recusado' => 'fas fa-times-circle'
                                            ];
                                            ?>
                                            <i class="<?php echo $statusIconsParticipante[$u_atrib['status']] ?? 'fas fa-question'; ?>"></i>
                                            <?php echo ucfirst($u_atrib['status']); ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php 
                        endif; // Fim da condição 'pendente'
                    endforeach; 
                    ?>
                </div>
                 <?php if ($count_espera === 0): ?>
                    <div class="empty-state">
                        <i class="fas fa-clipboard"></i>
                        <h3 class="text-xl font-semibold mb-2">Nenhuma demanda em espera</h3>
                        <p>Todas as demandas pendentes estão sendo feitas ou foram concluídas/canceladas.</p>
                    </div>
                <?php endif; ?>
            </div>

        
             <!-- O resto dos cards (Concluídas, Canceladas, etc.) -->
            <div class="mb-8">
                 <h3 class="text-xl font-bold text-white mb-4">Outras Demandas</h3>
                 <div id="demandasOutrasContainer" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 items-start">
                     <?php 
                     $count_outras = 0;
                     foreach ($demandas as $index => $d): 
                         // Verifica se o status NÃO é 'pendente' para a seção 'Outras Demandas'
                         if ($d['status'] !== 'pendente'):
                             $count_outras++;
                     ?>
                     
                     <?php
                     // Determina se há participantes atribuídos para ajustar o padding
                     $has_participants = !empty($d['usuarios_atribuidos']);
                     ?>

                     <div class="demand-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300 <?php echo $has_participants ? '' : 'no-participants'; ?>"
                         data-title="<?php echo htmlspecialchars($d['titulo']); ?>"
                         data-description="<?php echo htmlspecialchars($d['descricao']); ?>"
                         data-status="<?php echo $d['status']; ?>"
                         data-priority="<?php echo $d['prioridade']; ?>">
                         
                         <!-- Card Header -->
                         <div class="flex items-start justify-between mb-4">
                             <div class="flex-1">
                                 <h3 class="text-lg font-semibold text-white mb-2 line-clamp-2 cursor-pointer hover:text-primary-50 transition-colors duration-300"
                                     onclick="mostrarDescricao('<?php echo htmlspecialchars($d['titulo']); ?>', '<?php echo htmlspecialchars($d['descricao']); ?>', '<?php echo $d['status']; ?>', '<?php echo date('d/m/Y H:i', strtotime($d['data_criacao'])); ?>', '<?php echo !empty($d['data_conclusao']) ? date('d/m/Y H:i', strtotime($d['data_conclusao'])) : ''; ?>')">
                                     <?php echo htmlspecialchars($d['titulo']); ?>
                                 </h3>
                                 <div class="flex items-center gap-2 mb-2">
                                     <span class="status-badge status-<?php echo $d['status']; ?>">
                                         <?php
                                         $statusIcons = [
                                             'pendente' => 'fas fa-clock',
                                             'em_andamento' => 'fas fa-spinner fa-spin',
                                             'concluida' => 'fas fa-check-circle',
                                             'cancelada' => 'fas fa-ban',
                                             'aceito' => 'fas fa-check-circle'
                                         ];
                                         
                                         $display_status = $d['status'];
                                         $display_icon = $statusIcons[$display_status] ?? 'fas fa-question';

                                         // Lógica para status do card baseado no participante único concluído (se houver)
                                         if (!empty($d['usuarios_atribuidos']) && count($d['usuarios_atribuidos']) === 1) {
                                             $single_participant_status = $d['usuarios_atribuidos'][0]['status'] ?? null;
                                             if ($single_participant_status === 'concluido') {
                                                 $display_status = 'concluida';
                                                 $display_icon = $statusIcons[$display_status] ?? 'fas fa-question';
                                             }
                                         }

                                         $status_display = ucfirst(str_replace('_', ' ', $display_status));
                                         ?>
                                         <i class="<?php echo $display_icon; ?>"></i>
                                         <?php echo $status_display; ?>
                                     </span>
                                     <span class="priority-badge priority-<?php echo $d['prioridade']; ?>">
                                         <?php echo ucfirst($d['prioridade']); ?>
                                     </span>
                                 </div>
                             </div>
                             <div class="text-right">
                                 <span class="text-xs text-gray-400">ID: #<?php echo $d['id']; ?></span>
            </div>
                         </div>
                         
                         <!-- Card Content -->
                         <div class="mb-4">
                             <p class="text-gray-300 text-sm line-clamp-3 mb-3">
                                 <?php echo htmlspecialchars($d['descricao']); ?>
                             </p>
                             
                             <div class="grid grid-cols-2 gap-4 text-xs">
                                 <div>
                                     <span class="text-gray-400">Criado em:</span>
                                     <p class="text-white font-medium">
                                         <?php echo date('d/m/Y', strtotime($d['data_criacao'])); ?>
                                     </p>
                                     <p class="text-gray-400">
                                         <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
                                     </p>
                                 </div>
                                 <div>
                                     <?php if ($d['status'] === 'concluida'): ?>
                                         <span class="text-gray-400">Concluído em:</span>
                                         <p class="text-white font-medium">
                                             <?php echo date('d/m/Y', strtotime($d['data_conclusao'])); ?>
                                         </p>
                                         <p class="text-gray-400">
                                             <?php echo date('H:i', strtotime($d['data_conclusao'])); ?>
                                         </p>
                                     <?php else: ?>
                                         <span class="text-gray-400">Prazo:</span>
                                         <?php
                                         $dias_prazo = 0;
                                         switch ($d['prioridade']) {
                                             case 'baixa':
                                                 $dias_prazo = 5;
                                                 break;
                                             case 'media':
                                                 $dias_prazo = 3;
                                                 break;
                                             case 'alta':
                                                 $dias_prazo = 1;
                                                 break;
                                         }
                                         $data_prazo = date('d/m/Y', strtotime($d['data_criacao'] . " +{$dias_prazo} days"));
                                         $data_prazo_hora = date('H:i', strtotime($d['data_criacao']));
                                         ?>
                                         <p class="text-white font-medium">
                                             <?php echo $data_prazo; ?>
                                         </p>
                                         <p class="text-gray-400">
                                             <?php echo $data_prazo_hora; ?>
                                         </p>
                                     <?php endif; ?>
                                 </div>
                             </div>
                         </div>
                         
                         <!-- Card Actions -->
                         <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                        <div class="flex items-center gap-2">
                            <?php if ($d['status'] !== 'concluida'): ?>
                                <?php if ($d['status'] === 'pendente'): ?>
                                         <button onclick="realizarTarefa(<?php echo $d['id']; ?>, '<?php echo $d['status']; ?>')" 
                                                 class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg transition-all duration-300 flex items-center gap-2">
                                        <i class="fas fa-tasks"></i>
                                        Realizar Tarefa
                                    </button>
                                <?php elseif ($d['status'] === 'em_andamento'): ?>
                                    <button onclick="concluirDemanda(<?php echo $d['id']; ?>)" 
                                                 class="custom-btn bg-green-600 hover:bg-green-700 text-white py-1 px-2 rounded-lg transition-all duration-300 flex items-center gap-2">
                                        <i class="fas fa-check"></i>
                                        Concluir
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                                 <button onclick="editarDemanda(<?php echo $d['id']; ?>)" class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                                 <button onclick="excluirDemanda(<?php echo $d['id']; ?>)" class="custom-btn bg-red-600 hover:bg-red-700 text-white py-1 px-2 rounded-lg" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Status dos Usuários -->
                    <?php if (!empty($d['usuarios_atribuidos'])): ?>
                    <div class="mt-4 pt-4 border-t border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-400 mb-2">Status dos Participantes:</h4>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($d['usuarios_atribuidos'] as $u_atrib): ?>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-300"><?php echo htmlspecialchars($u_atrib['nome']); ?>:</span>
                                    <span class="status-badge status-<?php echo $u_atrib['status']; ?>">
                                        <?php
                                        $statusIconsParticipante = [
                                            'pendente' => 'fas fa-clock',
                                            'aceito' => 'fas fa-check-circle',
                                            'em_andamento' => 'fas fa-spinner fa-spin',
                                            'concluido' => 'fas fa-check-circle',
                                            'recusado' => 'fas fa-times-circle'
                                        ];
                                        ?>
                                        <i class="<?php echo $statusIconsParticipante[$u_atrib['status']] ?? 'fas fa-question'; ?>"></i>
                                        <?php echo ucfirst($u_atrib['status']); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                     <?php 
                         endif; // Fim da condição para 'Outras Demandas'
                     endforeach; 
                     ?>
            </div>
                  <?php if ($count_outras === 0): ?>
                     <div class="empty-state">
                         <i class="fas fa-list"></i>
                         <h3 class="text-xl font-semibold mb-2">Nenhuma outra demanda</h3>
                         <p>Todas as demandas estão em espera ou sendo feitas.</p>
            </div>
                 <?php endif; ?>
             </div>

            
            <!-- O Empty State geral foi removido daqui -->
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($usuarios as $index => $user): ?>
                <div class="user-card fade-in" style="animation-delay: <?php echo ($index * 0.1); ?>s">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white">
                                <?php echo htmlspecialchars($user['nome']); ?>
                            </h3>
                            <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user['email']); ?></p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full <?php echo $user['tipo'] === 'admin' ? 'bg-red-500/20 text-red-400' : 'bg-blue-500/20 text-blue-400'; ?>">
                                <?php echo ucfirst($user['tipo']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Create Demand Modal -->
    <div id="criarDemandaModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-md p-6 scale-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Nova Demanda</h3>
                <button onclick="closeModal('criarDemandaModal')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="../controllers/DemandaController.php" method="POST" class="space-y-4">
                            <input type="hidden" name="acao" value="criar">
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
                                    <option value="baixa">Baixa</option>
                                    <option value="media">Média</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>
                            <div id="prazoCalculadoInfo" class="mt-2"></div>
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
                    <select id="tipo" name="tipo" required class="custom-select w-full">
                        <option value="usuario">Usuário Comum</option>
                        <option value="admin">Administrador</option>
                    </select>
                                </div>
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeModal('criarUsuarioModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Cancelar
                                    </button>
                    <button type="submit" name="criar_usuario" class="custom-btn bg-gradient-to-r from-secondary-500 to-secondary-400 hover:from-secondary-400 hover:to-secondary-300 text-white font-bold py-2 px-4 rounded-lg">
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
                <input type="hidden" id="editId" name="id">
                
                <div>
                    <label for="editTitulo" class="block text-sm font-medium text-gray-300 mb-2">Título</label>
                    <input type="text" id="editTitulo" name="titulo" required class="custom-input w-full">
                </div>
                
                <div>
                    <label for="editDescricao" class="block text-sm font-medium text-gray-300 mb-2">Descrição</label>
                    <textarea id="editDescricao" name="descricao" rows="4" required class="custom-input w-full"></textarea>
                </div>
                
                <div>
                    <label for="editPrioridade" class="block text-sm font-medium text-gray-300 mb-2">Prioridade</label>
                    <select id="editPrioridade" name="prioridade" required class="custom-select w-full">
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                <div id="editPrazoCalculadoInfo" class="mt-2"></div>
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeModal('editarDemandaModal')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-2 px-4 rounded-lg">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Demand Modal -->
    <div id="excluirDemandaModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
        <div class="modal-content w-full max-w-md p-8 scale-in">
            <div class="flex flex-col items-center text-center">
                <!-- Ícone de Alerta -->
                <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-500"></i>
            </div>

                <h3 class="text-2xl font-bold text-white mb-4">Confirmar Exclusão</h3>
                
                <p class="text-gray-300 mb-8 text-lg">
                    Tem certeza que deseja excluir esta demanda? Esta ação não pode ser desfeita.
                </p>

                <form action="../controllers/DemandaController.php" method="POST" id="formExcluirDemanda" class="w-full">
                <input type="hidden" name="acao" value="excluir">
                <input type="hidden" name="id" id="demanda_a_excluir_id">
                    
            <div class="flex justify-center gap-4">
                        <button type="button" onclick="closeModal('excluirDemandaModal')" 
                                class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2 transition-all duration-300">
                            <i class="fas fa-times"></i>
                    Cancelar
                </button>
                        
                        <button type="submit" 
                                class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2 transition-all duration-300">
                            <i class="fas fa-trash"></i>
                    Excluir
                </button>
            </div>
            </form>
            </div>
        </div>
    </div>

    <script>
        // Multi-Select functionality
        const multiSelectData = {};

        function initializeMultiSelect(selectId) {
            if (!multiSelectData[selectId]) {
                multiSelectData[selectId] = {
                    selectedUsers: [],
                    isOpen: false
                };
            }
        }

        function toggleMultiSelect(selectId) {
            initializeMultiSelect(selectId);
            
            const container = document.querySelector(`#${selectId}_dropdown`).parentElement.querySelector('.multi-select-container');
            const dropdown = document.getElementById(`${selectId}_dropdown`);
            
            // Close other dropdowns
            document.querySelectorAll('.multi-select-dropdown.active').forEach(dd => {
                if (dd.id !== `${selectId}_dropdown`) {
                    dd.classList.remove('active');
                    dd.parentElement.querySelector('.multi-select-container').classList.remove('active');
                }
            });
            
            multiSelectData[selectId].isOpen = !multiSelectData[selectId].isOpen;
            
            if (multiSelectData[selectId].isOpen) {
                container.classList.add('active');
                dropdown.classList.add('active');
            } else {
                container.classList.remove('active');
                dropdown.classList.remove('active');
            }
        }

        function toggleUserSelection(selectId, userId, userName, userEmail) {
            initializeMultiSelect(selectId);
            
            const selectedUsers = multiSelectData[selectId].selectedUsers;
            const existingIndex = selectedUsers.findIndex(user => user.id === userId);
            
            if (existingIndex > -1) {
                // Remove user
                selectedUsers.splice(existingIndex, 1);
            } else {
                // Add user
                selectedUsers.push({
                    id: userId,
                    name: userName,
                    email: userEmail
                });
            }
            
            updateMultiSelectDisplay(selectId);
            updateHiddenSelect(selectId);
            updateOptionStates(selectId);
        }

        function updateMultiSelectDisplay(selectId) {
            const display = document.getElementById(`${selectId}_display`);
            const selectedUsers = multiSelectData[selectId].selectedUsers;
            
            if (selectedUsers.length === 0) {
                display.innerHTML = '<span class="multi-select-placeholder">Selecione os usuários</span>';
            } else {
                display.innerHTML = selectedUsers.map(user => `
                    <div class="selected-user-tag">
                        <span>${user.name}</span>
                        <button type="button" class="remove-user-btn" onclick="removeUser('${selectId}', ${user.id})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `).join('');
            }
        }

        function updateHiddenSelect(selectId) {
            const hiddenSelect = document.getElementById(`${selectId}_hidden`);
            const selectedUsers = multiSelectData[selectId].selectedUsers;
            
            // Clear all selections
            Array.from(hiddenSelect.options).forEach(option => {
                option.selected = false;
            });
            
            // Select the chosen users
            selectedUsers.forEach(user => {
                const option = hiddenSelect.querySelector(`option[value="${user.id}"]`);
                if (option) {
                    option.selected = true;
                }
            });
        }

        function updateOptionStates(selectId) {
            const selectedUsers = multiSelectData[selectId].selectedUsers;
            const options = document.querySelectorAll(`#${selectId}_options .multi-select-option`);
            
            options.forEach(option => {
                const userId = parseInt(option.dataset.value);
                const isSelected = selectedUsers.some(user => user.id === userId);
                
                if (isSelected) {
                    option.classList.add('selected');
                } else {
                    option.classList.remove('selected');
                }
            });
        }

        function removeUser(selectId, userId) {
            const selectedUsers = multiSelectData[selectId].selectedUsers;
            const index = selectedUsers.findIndex(user => user.id === userId);
            
            if (index > -1) {
                selectedUsers.splice(index, 1);
                updateMultiSelectDisplay(selectId);
                updateHiddenSelect(selectId);
                updateOptionStates(selectId);
            }
        }

        function filterUsers(selectId, searchTerm) {
            const options = document.querySelectorAll(`#${selectId}_options .multi-select-option`);
            const term = searchTerm.toLowerCase();
            
            options.forEach(option => {
                const userName = option.querySelector('.user-name').textContent.toLowerCase();
                const userEmail = option.querySelector('.user-email').textContent.toLowerCase();
                
                if (userName.includes(term) || userEmail.includes(term)) {
                    option.style.display = 'flex';
                } else {
                    option.style.display = 'none';
                }
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.custom-multi-select')) {
                document.querySelectorAll('.multi-select-dropdown.active').forEach(dropdown => {
                    dropdown.classList.remove('active');
                    dropdown.parentElement.querySelector('.multi-select-container').classList.remove('active');
                });
                
                Object.keys(multiSelectData).forEach(selectId => {
                    multiSelectData[selectId].isOpen = false;
                });
            }
        });

        // Modal Functions
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
                container.classList.remove('active');
            }
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
                    
                    // Atualiza a exibição do prazo calculado para edição
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
                case 'baixa':
                    dias = 5;
                    break;
                case 'media':
                    dias = 3;
                    break;
                case 'alta':
                    dias = 1;
                    break;
            }
            prazoCalculadoInfo.innerHTML = `
                <span class="prazo-info-badge">
                    <i class="fas fa-clock"></i>
                    Prazo: até ${dias} dia${dias > 1 ? 's' : ''}
                </span>
            `;
        }

        // Atualizar ao carregar a página e ao mudar a seleção
        updatePrazoCalculadoInfo(); // Chama uma vez ao carregar para mostrar o prazo inicial
        prioridadeSelect.addEventListener('change', updatePrazoCalculadoInfo);

        // Atualizar informação de prazo calculado ao selecionar prioridade no modal de edição
        const editPrioridadeSelect = document.getElementById('editPrioridade');
        const editPrazoCalculadoInfo = document.getElementById('editPrazoCalculadoInfo');

        function updateEditPrazoCalculadoInfo() {
            const prioridade = editPrioridadeSelect.value;
            let dias = 0;
            switch (prioridade) {
                case 'baixa':
                    dias = 5;
                    break;
                case 'media':
                    dias = 3;
                    break;
                case 'alta':
                    dias = 1;
                    break;
            }
            editPrazoCalculadoInfo.innerHTML = `
                <span class="prazo-info-badge">
                    <i class="fas fa-clock"></i>
                    Prazo: até ${dias} dia${dias > 1 ? 's' : ''}
                </span>
            `;
        }

        // Atualizar ao mudar a seleção no modal de edição
        editPrioridadeSelect.addEventListener('change', updateEditPrazoCalculadoInfo);

        // Função para realizar tarefa
        function realizarTarefa(demandaId, statusAtual) {
                // Criar um formulário dinâmico
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '../controllers/DemandaController.php';

                // Adicionar campos necessários
                const acaoInput = document.createElement('input');
                acaoInput.type = 'hidden';
                acaoInput.name = 'acao';
                acaoInput.value = 'atualizar_status';

                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'id';
                idInput.value = demandaId;

                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'novo_status';
                statusInput.value = statusAtual === 'em_andamento' ? 'concluida' : 'em_andamento';

                // Adicionar inputs ao formulário
                form.appendChild(acaoInput);
                form.appendChild(idInput);
                form.appendChild(statusInput);

                // Adicionar formulário ao documento e enviar
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

        // Filter Functions
        function filterByStatus(status) {
            const cards = document.querySelectorAll('.demand-card');
            const emptyState = document.getElementById('emptyState');
            let visibleCount = 0;

            cards.forEach(card => {
                // Use dataset para obter o status do card
                const cardStatus = card.dataset.status;
                
                if (status === 'all' || cardStatus === status) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
            // Após filtrar por status, reaplica o filtro de texto e prioridade
            filterDemands();
        }

        function filterByPriority(priority) {
            const cards = document.querySelectorAll('.demand-card');
            const emptyState = document.getElementById('emptyState');
            let visibleCount = 0;

            cards.forEach(card => {
                // Use dataset para obter a prioridade do card
                const cardPriority = card.dataset.priority;

                if (priority === 'all' || cardPriority === priority) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
            // Após filtrar por prioridade, reaplica o filtro de texto e status
            filterDemands();
        }

        function filterDemands() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusSelect = document.querySelector('select[onchange="filterByStatus(this.value)"]');
            const prioritySelect = document.querySelector('select[onchange="filterByPriority(this.value)"]');
            const cards = document.querySelectorAll('.demand-card');
            const emptyState = document.getElementById('emptyState');
            let visibleCount = 0;

            cards.forEach(card => {
                const title = card.dataset.title.toLowerCase();
                const description = card.dataset.description.toLowerCase();
                // Use dataset para obter status e prioridade
                const status = card.dataset.status;
                const priority = card.dataset.priority;
                
                const activeStatus = statusSelect ? statusSelect.value : 'all'; // Verifica se o select existe
                const activePriority = prioritySelect ? prioritySelect.value : 'all'; // Verifica se o select existe

                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                const matchesStatus = activeStatus === 'all' || status === activeStatus;
                const matchesPriority = activePriority === 'all' || priority === activePriority;

                if (matchesSearch && matchesStatus && matchesPriority) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        // Função para atualizar o estado vazio de um container específico
        function updateEmptyState(containerId) {
            const container = document.getElementById(containerId);
            const cards = container.querySelectorAll('.demand-card');
            let visibleCount = 0;

            cards.forEach(card => {
                if (card.style.display !== 'none') {
                    visibleCount++;
                }
            });

            const emptyState = container.querySelector('.empty-state');
            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.custom-multi-select')) {
                document.querySelectorAll('.multi-select-dropdown.active').forEach(dropdown => {
                    dropdown.classList.remove('active');
                    dropdown.parentElement.querySelector('.multi-select-container').classList.remove('active');
                });
                
                Object.keys(multiSelectData).forEach(selectId => {
                    multiSelectData[selectId].isOpen = false;
                });
            }
        });
    </script>
</body>
</html> 