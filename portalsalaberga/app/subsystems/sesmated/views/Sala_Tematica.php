<?php 
require_once('../../../main/models/sessions.php');
$session = new sessions;
$session->autenticar_session();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefa 13 - Sala Temática</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --background-color: #0a0a0a;
            --text-color: #ffffff;
            --header-color: #00b348;
            --icon-bg: #2d2d2d;
            --icon-shadow: rgba(0, 0, 0, 0.3);
            --accent-color: #ffb733;
            --grid-color: #333333;
            --card-bg: rgba(30, 30, 30, 0.95);
            --header-bg: rgba(15, 15, 15, 0.98);
            --search-bar-bg: #1a1a1a;
            --card-border-hover: var(--accent-color);
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }
        
        body {
            background: radial-gradient(ellipse at top, #1a1a1a 0%, #0a0a0a 100%);
            color: var(--text-color);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
        }
        
        .header-bg {
            background: linear-gradient(135deg, var(--header-bg) 0%, rgba(0, 0, 0, 0.95) 100%);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .card-bg {
            background: linear-gradient(145deg, var(--card-bg) 0%, rgba(25, 25, 25, 0.95) 100%);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        .input-field {
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(255, 183, 51, 0.1);
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%);
        }
        
        .card-hover:hover {
            border-color: rgba(255, 183, 51, 0.3);
            box-shadow: 0 12px 40px rgba(255, 183, 51, 0.15);
            transform: translateY(-4px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--header-color) 0%, #00a040 100%);
            box-shadow: 0 4px 20px rgba(0, 179, 72, 0.3);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            box-shadow: 0 8px 30px rgba(0, 179, 72, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: linear-gradient(145deg, #2a2a2a 0%, #1a1a1a 100%);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(145deg, #353535 0%, #252525 100%);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }
        
        .modal-bg {
            background: linear-gradient(145deg, rgba(25, 25, 25, 0.98) 0%, rgba(15, 15, 15, 0.98) 100%);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .slide-up {
            animation: slideUp 0.4s ease-out;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }
        
        @keyframes pulseGlow {
            from { box-shadow: 0 4px 20px rgba(0, 179, 72, 0.3); }
            to { box-shadow: 0 8px 40px rgba(0, 179, 72, 0.5); }
        }

        .range-slider {
            -webkit-appearance: none;
            appearance: none;
            height: 8px;
            border-radius: 5px;
            background: linear-gradient(90deg, #333 0%, #666 100%);
            outline: none;
        }

        .range-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--header-color) 0%, var(--accent-color) 100%);
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 179, 72, 0.4);
        }

        .range-slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--header-color) 0%, var(--accent-color) 100%);
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 179, 72, 0.4);
        }

        select.input-field {
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%) !important;
            color: var(--text-color) !important;
            border: 1px solid rgba(255,255,255,0.12);
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 2.5rem;
        }
        
        select.input-field option {
            color: #222 !important;
        }

        /* ===== HEADER NOVO - INÍCIO ===== */
        .container-responsive {
            width: 100%;
            max-width: none;
            padding: 0 clamp(1rem, 4vw, 2rem);
        }
        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            width: 100%;
        }
        .header-title-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .header-title-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }
        .user-chip {
            background: linear-gradient(145deg, #232d25 0%, #181f1a 100%);
            border: 1px solid #1f3a26;
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            font-weight: 600;
            color: #e5e7eb;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.08);
        }
        .user-chip-desktop {
            position: absolute;
            top: 0;
            right: 0;
        }
        @media (max-width: 640px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            .user-chip-desktop {
                position: relative;
                top: auto;
                right: auto;
            }
            .header-title-section {
                align-items: center;
            }
        }
        /* Títulos responsivos */
        .main-title {
            font-size: clamp(1.5rem, 6vw, 2.5rem);
            line-height: 1.2;
        }
        /* ===== HEADER NOVO - FIM ===== */

        .stats-card {
            background: linear-gradient(145deg, rgba(30, 30, 30, 0.8) 0%, rgba(20, 20, 20, 0.8) 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .input-field {
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(255, 183, 51, 0.1);
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%);
        }
        .score-input-wrapper {
            position: relative;
            width: 100%;
            margin-top: 1rem;
        }
        .score-input {
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: clamp(0.875rem, 2.5vw, 1rem);
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            text-align: center;
        }
        .score-input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(255, 183, 51, 0.1);
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%);
            outline: none;
        }
        .score-input:hover {
            border-color: rgba(255, 183, 51, 0.3);
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%);
        }
        .score-input::placeholder {
            color: #6b7280;
            font-weight: 500;
        }
        .score-input::-webkit-outer-spin-button,
        .score-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .score-input[type=number] {
            -moz-appearance: textfield;
        }
        .score-input.valid {
            border-color: var(--success-color);
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.1);
        }
        .score-input.invalid {
            border-color: var(--danger-color);
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--header-color) 0%, #00a040 100%);
            box-shadow: 0 4px 20px rgba(0, 179, 72, 0.3);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            box-shadow: 0 8px 30px rgba(0, 179, 72, 0.4);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: linear-gradient(145deg, #2a2a2a 0%, #1a1a1a 100%);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: linear-gradient(145deg, #353535 0%, #252525 100%);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }
        .user-chip {
            background: linear-gradient(145deg, #232d25 0%, #181f1a 100%);
            border: 1px solid #1f3a26;
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            font-weight: 600;
            color: #e5e7eb;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.08);
        }
        .select-wrapper {
            position: relative;
        }
        .select-wrapper::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-color);
            pointer-events: none;
            font-size: 0.875rem;
        }
        select.input-field {
            background: linear-gradient(145deg, var(--search-bar-bg) 0%, #151515 100%) !important;
            color: var(--text-color) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 3rem;
            cursor: pointer;
        }
        select.input-field:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 3px rgba(255, 183, 51, 0.1) !important;
            background: linear-gradient(145deg, #202020 0%, #1a1a1a 100%) !important;
        }
        select.input-field option {
            background-color: #232323 !important;
            color: #fff !important;
        }
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-up {
            animation: slideUp 0.4s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }
        @keyframes pulseGlow {
            from { box-shadow: 0 4px 20px rgba(0, 179, 72, 0.3); }
            to { box-shadow: 0 8px 40px rgba(0, 179, 72, 0.5); }
        }
        .criteria-item {
            background: linear-gradient(145deg, rgba(40, 40, 40, 0.6) 0%, rgba(30, 30, 30, 0.6) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1rem;
            padding: clamp(1rem, 3vw, 1.5rem);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            min-height: auto;
        }
        .criteria-item:hover {
            border-color: rgba(255, 183, 51, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 183, 51, 0.1);
        }
        .criteria-icon {
            width: clamp(2.5rem, 8vw, 3rem);
            height: clamp(2.5rem, 8vw, 3rem);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .criteria-icon i {
            font-size: clamp(1rem, 4vw, 1.25rem);
            color: white;
        }
        .criteria-title {
            font-size: clamp(0.875rem, 3.5vw, 1rem);
            font-weight: 700;
            color: white;
            margin-bottom: 0.25rem;
        }
        .criteria-subtitle {
            font-size: clamp(0.75rem, 2.5vw, 0.875rem);
            color: #9ca3af;
            margin-bottom: 1rem;
            line-height: 1.3;
        }
        .score-display {
            background: linear-gradient(135deg, rgba(255, 183, 51, 0.15) 0%, rgba(255, 183, 51, 0.05) 100%);
            border: 1px solid rgba(255, 183, 51, 0.3);
            border-radius: 0.5rem;
            padding: 0.75rem 0.5rem;
            margin-top: 0.75rem;
            font-size: clamp(0.75rem, 2.5vw, 0.875rem);
            font-weight: 700;
            color: var(--accent-color);
            text-align: center;
            width: 100%;
        }
        .criteria-grid {
            display: grid;
            gap: clamp(1rem, 3vw, 1.5rem);
            width: 100%;
        }
        @media (max-width: 640px) {
            .criteria-grid {
                grid-template-columns: 1fr;
            }
            .card-bg {
                padding: clamp(1rem, 4vw, 1.5rem);
                margin: 0.5rem;
            }
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            .user-chip-desktop {
                position: relative;
                top: auto;
                right: auto;
            }
            .header-title-section {
                align-items: center;
            }
        }
        @media (min-width: 641px) and (max-width: 1024px) {
            .criteria-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (min-width: 1025px) {
            .criteria-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        .container-responsive {
            width: 100%;
            max-width: none;
            padding: 0 clamp(1rem, 4vw, 2rem);
        }
        .main-title {
            font-size: clamp(1.5rem, 6vw, 2.5rem);
            line-height: 1.2;
        }
        .section-title {
            font-size: clamp(1rem, 4vw, 1.25rem);
        }
        .btn-responsive {
            padding: clamp(0.75rem, 3vw, 1rem) clamp(1.5rem, 6vw, 2rem);
            font-size: clamp(0.875rem, 3vw, 1rem);
            border-radius: 1rem;
            width: 100%;
            max-width: 20rem;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--header-color), var(--accent-color));
            border-radius: 4px;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="header-bg">
        <div class="container-responsive py-4">
            <div class="header-content">
                <!-- Título e Logo Centralizados -->
                <div class="header-title-section">
                    <div class="header-title-row">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 via-emerald-600 to-green-700 flex items-center justify-center pulse-glow">
                            <i class="fas fa-door-open text-white text-lg"></i>
                        </div>
                        <h1 class="main-title font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                            TAREFA 13
                        </h1>
                    </div>
                    <p class="text-gray-400 text-xs font-medium tracking-wider uppercase">Sala Temática</p>
                </div>
                
                <!-- Chip do Usuário - Posicionado à direita no desktop -->
                <div class="user-chip user-chip-desktop">
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                        <i class="fas fa-user text-green-300 text-xs"></i>
                    </div>
                    <span class="text-gray-100">João Silva</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container-responsive py-8">
        <div class="flex flex-col items-center justify-center min-h-[70vh]">
            <div class="card-bg rounded-3xl w-full max-w-6xl text-center fade-in">
                <!-- Formulário Principal -->
                <form id="salaTematicaForm" class="space-y-8">
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-yellow-600 flex items-center justify-center">
                            <i class="fas fa-door-open text-white text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="main-title font-black mb-4 bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                                Sala Temática
                            </h2>
                            <p class="text-lg text-gray-300 font-medium mb-4">
                                "Construindo Comunidades Sustentáveis: Saúde, Gestão e Inovação"
                            </p>
                            <p class="text-sm text-gray-400 font-medium">
                                Avalie cada critério com notas de 0 a 100 pontos
                            </p>
                        </div>
                    </div>
                    <!-- Botão Discreto para Regras -->
                    <div class="flex justify-center mb-6">
                        <button type="button" id="regrasButton" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-gray-700 to-gray-600 hover:from-gray-600 hover:to-gray-500 rounded-full text-sm font-medium text-gray-300 hover:text-white transition-all duration-300 border border-gray-600 hover:border-gray-500">
                            <i class="fas fa-info-circle text-xs"></i>
                            <span>Ver Regras</span>
                        </button>
                    </div>
                    <!-- Seletor de Curso -->
                    <div class="mb-8">
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-graduation-cap mr-2"></i>Curso
                        </label>
                        <div class="select-wrapper">
                            <select id="cursoInput" name="curso" required class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none">
                                <option value="" selected disabled>Selecione o curso</option>
                                <option value="Enfermagem">Enfermagem</option>
                                <option value="Informática">Informática</option>
                                <option value="Meio ambiente">Meio ambiente</option>
                                <option value="Administração">Administração</option>
                                <option value="Edificações">Edificações</option>
                            </select>
                        </div>
                    </div>
                    <!-- Critérios de Avaliação -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 justify-center mb-6">
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                            <span class="section-title font-bold text-gray-200">Critérios de Avaliação</span>
                        </div>
                        <div class="criteria-grid">
                            <!-- Adequação ao Tema Proposto -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-blue-500 to-cyan-600">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                                <h4 class="criteria-title">Adequação ao Tema</h4>
                                <p class="criteria-subtitle">Foco, pertinência e coerência com o tema</p>
                                <div class="score-input-wrapper">
                                    <input type="number" id="notaAdequacao" name="nota_adequacao" min="0" max="100" placeholder="0-100" class="score-input" value="">
                                </div>
                                <div id="displayAdequacao" class="score-display hidden">
                                    <span id="valorAdequacao">0</span> pontos
                                </div>
                            </div>
                            <!-- Qualidade do Conteúdo Apresentado -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-green-500 to-emerald-600">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <h4 class="criteria-title">Qualidade do Conteúdo</h4>
                                <p class="criteria-subtitle">Rigor informativo, valor educativo e conexão crítica</p>
                                <div class="score-input-wrapper">
                                    <input type="number" id="notaConteudo" name="nota_conteudo" min="0" max="100" placeholder="0-100" class="score-input" value="">
                                </div>
                                <div id="displayConteudo" class="score-display hidden">
                                    <span id="valorConteudo">0</span> pontos
                                </div>
                            </div>
                            <!-- Ambientação e Criatividade -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-purple-500 to-violet-600">
                                    <i class="fas fa-paint-brush"></i>
                                </div>
                                <h4 class="criteria-title">Ambientação e Criatividade</h4>
                                <p class="criteria-subtitle">Estética, criatividade e esforço no ambiente</p>
                                <div class="score-input-wrapper">
                                    <input type="number" id="notaAmbientacao" name="nota_ambientacao" min="0" max="100" placeholder="0-100" class="score-input" value="">
                                </div>
                                <div id="displayAmbientacao" class="score-display hidden">
                                    <span id="valorAmbientacao">0</span> pontos
                                </div>
                            </div>
                            <!-- Didática e Clareza na Apresentação Oral -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-yellow-500 to-orange-600">
                                    <i class="fas fa-microphone"></i>
                                </div>
                                <h4 class="criteria-title">Didática e Clareza</h4>
                                <p class="criteria-subtitle">Comunicação, domínio do tema e interação</p>
                                <div class="score-input-wrapper">
                                    <input type="number" id="notaDidatica" name="nota_didatica" min="0" max="100" placeholder="0-100" class="score-input" value="">
                                </div>
                                <div id="displayDidatica" class="score-display hidden">
                                    <span id="valorDidatica">0</span> pontos
                                </div>
                            </div>
                            <!-- Trabalho em Equipe e Organização -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-pink-500 to-red-600">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4 class="criteria-title">Trabalho em Equipe</h4>
                                <p class="criteria-subtitle">Organização e cooperação entre os alunos</p>
                                <div class="score-input-wrapper">
                                    <input type="number" id="notaEquipe" name="nota_equipe" min="0" max="100" placeholder="0-100" class="score-input" value="">
                                </div>
                                <div id="displayEquipe" class="score-display hidden">
                                    <span id="valorEquipe">0</span> pontos
                                </div>
                            </div>
                            <!-- Sustentabilidade na Execução -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-lime-500 to-green-700">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <h4 class="criteria-title">Sustentabilidade</h4>
                                <p class="criteria-subtitle">Coerência entre discurso e prática sustentável</p>
                                <div class="score-input-wrapper">
                                    <input type="number" id="notaSustentabilidade" name="nota_sustentabilidade" min="0" max="100" placeholder="0-100" class="score-input" value="">
                                </div>
                                <div id="displaySustentabilidade" class="score-display hidden">
                                    <span id="valorSustentabilidade">0</span> pontos
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Painel de Pontuação Total -->
                    <div id="pontosPainel" class="mt-8 hidden slide-up">
                        <div class="stats-card rounded-xl p-4 text-center max-w-sm mx-auto">
                            <div class="flex items-center justify-center gap-2 mb-3">
                                <i class="fas fa-calculator text-yellow-400"></i>
                                <h3 class="text-lg font-bold text-white">Pontuação Total</h3>
                            </div>
                            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg p-3">
                                <p class="text-2xl font-black text-black">
                                    <span id="pontosTotais">0</span> / 600
                                </p>
                                <p class="text-xs font-medium text-black opacity-75">
                                    Média: <span id="mediaPontos">0.0</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 pt-8">
                        <button type="submit" class="btn-primary flex-1 py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                            <i class="fas fa-vote-yea"></i>
                            Registrar Avaliação
                        </button>
                    </div>
                </form>
                <!-- Tela de Sucesso -->
                <div id="sucessoVotacao" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm p-4">
                    <div class="card-bg rounded-3xl p-8 w-full max-w-md text-center fade-in">
                        <div class="flex flex-col items-center gap-4 mb-6">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center pulse-glow">
                                <i class="fas fa-check-circle text-white text-4xl"></i>
                            </div>
                            <h2 class="text-2xl font-extrabold text-green-400 mb-2">Avaliação Registrada!</h2>
                            <p class="text-lg text-gray-200">A avaliação da sala foi computada com sucesso.</p>
                            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl p-3 mt-2">
                                <p class="text-xl font-black text-black">
                                    Total: <span id="pontosFinal">0</span> / 600 pontos
                                </p>
                            </div>
                        </div>
                        <button onclick="fecharSucessoVotacao()" class="btn-primary btn-responsive font-semibold text-white flex items-center justify-center gap-2 mx-auto mt-4 hover:scale-105 transition-transform">
                            <i class="fas fa-arrow-left"></i> Nova Avaliação
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Regras -->
    <div id="regrasModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm p-4">
        <div class="card-bg rounded-3xl p-8 w-full max-w-md text-center fade-in">
            <div class="flex flex-col items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                    <i class="fas fa-door-open text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-green-400 mb-2">Regras da Sala Temática</h2>
            </div>
            <div class="text-left space-y-4">
                <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-xl border border-blue-500/20">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-bullseye text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-white text-sm">Tema</p>
                        <p class="text-gray-300 text-xs">"Construindo Comunidades Sustentáveis: Saúde, Gestão e Inovação"</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-xl border border-green-500/20">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-star text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-white text-sm">Critérios</p>
                        <ul class="text-gray-300 text-xs list-disc ml-4">
                            <li>Adequação ao Tema Proposto</li>
                            <li>Qualidade do Conteúdo Apresentado</li>
                            <li>Ambientação e Criatividade</li>
                            <li>Didática e Clareza na Apresentação Oral</li>
                            <li>Trabalho em Equipe e Organização</li>
                            <li>Sustentabilidade na Execução</li>
                        </ul>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-yellow-500/10 to-orange-500/10 rounded-xl border border-yellow-500/20">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-calculator text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-white text-sm">Pontuação</p>
                        <p class="text-gray-300 text-xs">Cada critério vale de 0 a 100 pontos. Total máximo: 600 pontos.</p>
                    </div>
                </div>
            </div>
            <button onclick="fecharRegras()" class="btn-primary btn-responsive font-semibold text-white flex items-center justify-center gap-2 mx-auto mt-6 hover:scale-105 transition-transform">
                <i class="fas fa-check"></i> Entendi
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inputs dos critérios
            const notaAdequacao = document.getElementById('notaAdequacao');
            const notaConteudo = document.getElementById('notaConteudo');
            const notaAmbientacao = document.getElementById('notaAmbientacao');
            const notaDidatica = document.getElementById('notaDidatica');
            const notaEquipe = document.getElementById('notaEquipe');
            const notaSustentabilidade = document.getElementById('notaSustentabilidade');
            const cursoInput = document.getElementById('cursoInput');

            // Displays individuais
            const displayAdequacao = document.getElementById('displayAdequacao');
            const displayConteudo = document.getElementById('displayConteudo');
            const displayAmbientacao = document.getElementById('displayAmbientacao');
            const displayDidatica = document.getElementById('displayDidatica');
            const displayEquipe = document.getElementById('displayEquipe');
            const displaySustentabilidade = document.getElementById('displaySustentabilidade');
            const valorAdequacao = document.getElementById('valorAdequacao');
            const valorConteudo = document.getElementById('valorConteudo');
            const valorAmbientacao = document.getElementById('valorAmbientacao');
            const valorDidatica = document.getElementById('valorDidatica');
            const valorEquipe = document.getElementById('valorEquipe');
            const valorSustentabilidade = document.getElementById('valorSustentabilidade');
            const pontosTotais = document.getElementById('pontosTotais');
            const mediaPontos = document.getElementById('mediaPontos');
            const pontosPainel = document.getElementById('pontosPainel');
            const pontosFinal = document.getElementById('pontosFinal');
            const sucessoVotacao = document.getElementById('sucessoVotacao');
            const votacaoForm = document.getElementById('salaTematicaForm');

            // Garantir que os inputs começem vazios
            [notaAdequacao, notaConteudo, notaAmbientacao, notaDidatica, notaEquipe, notaSustentabilidade].forEach(input => input.value = '');

            // Função para validar nota
            function validarNota(input, valor) {
                if (valor < 0 || valor > 100 || isNaN(valor)) {
                    input.classList.add('invalid');
                    input.classList.remove('valid');
                    return false;
                } else {
                    input.classList.add('valid');
                    input.classList.remove('invalid');
                    return true;
                }
            }

            // Função para atualizar display de nota individual
            function atualizarDisplayNota(input, display, valorSpan) {
                const valor = parseInt(input.value);
                if (input.value !== '' && !isNaN(valor) && validarNota(input, valor)) {
                    valorSpan.textContent = valor;
                    display.classList.remove('hidden');
                } else {
                    display.classList.add('hidden');
                }
                atualizarPontuacaoTotal();
            }

            // Função para calcular e atualizar pontuação total
            function atualizarPontuacaoTotal() {
                const v1 = notaAdequacao.value !== '' ? parseInt(notaAdequacao.value) || 0 : 0;
                const v2 = notaConteudo.value !== '' ? parseInt(notaConteudo.value) || 0 : 0;
                const v3 = notaAmbientacao.value !== '' ? parseInt(notaAmbientacao.value) || 0 : 0;
                const v4 = notaDidatica.value !== '' ? parseInt(notaDidatica.value) || 0 : 0;
                const v5 = notaEquipe.value !== '' ? parseInt(notaEquipe.value) || 0 : 0;
                const v6 = notaSustentabilidade.value !== '' ? parseInt(notaSustentabilidade.value) || 0 : 0;
                const total = v1 + v2 + v3 + v4 + v5 + v6;
                const media = total > 0 ? total / 6 : 0;
                pontosTotais.textContent = total;
                mediaPontos.textContent = media.toFixed(1);
                // Mostrar painel se houver pelo menos uma nota e curso selecionado
                if ((v1 > 0 || v2 > 0 || v3 > 0 || v4 > 0 || v5 > 0 || v6 > 0) && cursoInput.value) {
                    pontosPainel.classList.remove('hidden');
                } else {
                    pontosPainel.classList.add('hidden');
                }
            }

            // Event listeners para os inputs de nota
            notaAdequacao.addEventListener('input', function() { atualizarDisplayNota(this, displayAdequacao, valorAdequacao); });
            notaConteudo.addEventListener('input', function() { atualizarDisplayNota(this, displayConteudo, valorConteudo); });
            notaAmbientacao.addEventListener('input', function() { atualizarDisplayNota(this, displayAmbientacao, valorAmbientacao); });
            notaDidatica.addEventListener('input', function() { atualizarDisplayNota(this, displayDidatica, valorDidatica); });
            notaEquipe.addEventListener('input', function() { atualizarDisplayNota(this, displayEquipe, valorEquipe); });
            notaSustentabilidade.addEventListener('input', function() { atualizarDisplayNota(this, displaySustentabilidade, valorSustentabilidade); });
            cursoInput.addEventListener('change', function() { atualizarPontuacaoTotal(); });

            // Validação em tempo real para limitar valores
            [notaAdequacao, notaConteudo, notaAmbientacao, notaDidatica, notaEquipe, notaSustentabilidade].forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (!/[0-9]/.test(String.fromCharCode(e.which))) {
                        e.preventDefault();
                    }
                });
                input.addEventListener('input', function(e) {
                    if (e.target.value !== '') {
                        let valor = parseInt(e.target.value);
                        if (valor > 100) {
                            e.target.value = 100;
                        } else if (valor < 0) {
                            e.target.value = 0;
                        }
                    }
                });
            });

            // Submissão do formulário de votação
            votacaoForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const v1 = notaAdequacao.value !== '' ? parseInt(notaAdequacao.value) || 0 : 0;
                const v2 = notaConteudo.value !== '' ? parseInt(notaConteudo.value) || 0 : 0;
                const v3 = notaAmbientacao.value !== '' ? parseInt(notaAmbientacao.value) || 0 : 0;
                const v4 = notaDidatica.value !== '' ? parseInt(notaDidatica.value) || 0 : 0;
                const v5 = notaEquipe.value !== '' ? parseInt(notaEquipe.value) || 0 : 0;
                const v6 = notaSustentabilidade.value !== '' ? parseInt(notaSustentabilidade.value) || 0 : 0;
                if (!cursoInput.value) {
                    alert('Por favor, selecione o curso.');
                    cursoInput.focus();
                    return;
                }
                if (v1 === 0 && v2 === 0 && v3 === 0 && v4 === 0 && v5 === 0 && v6 === 0) {
                    alert('Por favor, preencha pelo menos uma nota.');
                    notaAdequacao.focus();
                    return;
                }
                // Validar se todas as notas preenchidas estão no range correto
                const inputs = [notaAdequacao, notaConteudo, notaAmbientacao, notaDidatica, notaEquipe, notaSustentabilidade];
                for (let input of inputs) {
                    if (input.value !== '' && !validarNota(input, parseInt(input.value))) {
                        alert('Por favor, digite notas válidas entre 0 e 100.');
                        input.focus();
                        return;
                    }
                }
                // Atualizar pontuação final
                const total = v1 + v2 + v3 + v4 + v5 + v6;
                pontosFinal.textContent = total;
                // Mostrar tela de sucesso
                sucessoVotacao.classList.remove('hidden');
                votacaoForm.style.display = 'none';
            });

            // Função para resetar o formulário de votação
            window.fecharSucessoVotacao = function() {
                sucessoVotacao.classList.add('hidden');
                votacaoForm.style.display = 'block';
                votacaoForm.reset();
                pontosPainel.classList.add('hidden');
                [notaAdequacao, notaConteudo, notaAmbientacao, notaDidatica, notaEquipe, notaSustentabilidade].forEach(input => {
                    input.value = '';
                    input.classList.remove('valid', 'invalid');
                });
                [displayAdequacao, displayConteudo, displayAmbientacao, displayDidatica, displayEquipe, displaySustentabilidade].forEach(display => display.classList.add('hidden'));
            };

            // Modal de regras
            const regrasButton = document.getElementById('regrasButton');
            const regrasModal = document.getElementById('regrasModal');
            if (regrasButton && regrasModal) {
                regrasButton.addEventListener('click', function() {
                    regrasModal.classList.remove('hidden');
                });
                window.fecharRegras = function() {
                    regrasModal.classList.add('hidden');
                };
                regrasModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        window.fecharRegras();
                    }
                });
            }
        });
    </script>
</body>
</html>
