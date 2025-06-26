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
    <title>Tarefa 14 - Painel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --background-color: #0a0a0a;
            --text-color: #ffffff;
            --header-color: #00b348;
            --accent-color: #ffb733;
            --card-bg: rgba(30, 30, 30, 0.95);
            --header-bg: rgba(15, 15, 15, 0.98);
            --search-bar-bg: #1a1a1a;
            --success-color: #10b981;
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
        .user-chip-desktop {
            position: absolute;
            top: 0;
            right: 0;
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
                            <i class="fas fa-chalkboard text-white text-lg"></i>
                        </div>
                        <h1 class="main-title font-black bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                            TAREFA 14
                        </h1>
                    </div>
                    <p class="text-gray-400 text-xs font-medium tracking-wider uppercase">Painel</p>
                </div>
                <div class="flex items-center gap-2 user-chip-desktop">
                    <a href="../../../main/views/subsytem/subsistema_sesmated.php" class="btn-secondary px-4 py-2 rounded-2xl font-semibold text-gray-300 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Voltar
                    </a>
                    <div class="user-chip">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                            <i class="fas fa-user text-green-300 text-xs"></i>
                        </div>
                        <span class="text-gray-100"><?=$_SESSION['Nome']?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content -->
    <main class="container-responsive py-8">
        <div class="flex flex-col items-center justify-center min-h-[70vh]">
            <div class="card-bg rounded-3xl w-full max-w-6xl text-center fade-in">
                <!-- Formulário Principal -->
                <form id="painelForm" class="space-y-8">
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-yellow-600 flex items-center justify-center">
                            <i class="fas fa-chalkboard text-white text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="main-title font-black mb-4 bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 bg-clip-text text-transparent">
                                Avaliação do Painel
                            </h2>
                            <p class="text-lg text-gray-300 font-medium mb-4">
                                "Desenvolvimento econômico, social e sustentável para comunidades resilientes"
                            </p>
                            <p class="text-sm text-gray-400 font-medium">
                                Avalie cada critério com notas de 0 a 100 pontos
                            </p>
                            <p class="text-xs text-gray-400 mt-2">Tamanho do painel: 2m x 1,8m</p>
                        </div>
                    </div>
                    <!-- Critérios de Avaliação -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 justify-center mb-6">
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                            <span class="section-title font-bold text-gray-200">Critérios de Avaliação</span>
                        </div>
                        <div class="criteria-grid">
                            <!-- Adequação ao Tema -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-blue-500 to-cyan-600">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                                <h4 class="criteria-title">Adequação ao Tema</h4>
                                <p class="criteria-subtitle">O painel aborda claramente o tema proposto</p>
                                <div class="score-input-wrapper">
                                    <input 
                                        type="number" 
                                        id="notaTema" 
                                        name="nota_tema" 
                                        min="0" 
                                        max="100" 
                                        placeholder="0-100"
                                        class="score-input"
                                        value=""
                                    >
                                </div>
                                <div id="displayTema" class="score-display hidden">
                                    <span id="valorTema">0</span> pontos
                                </div>
                            </div>
                            <!-- Qualidade do Conteúdo -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-green-500 to-emerald-600">
                                    <i class="fas fa-book"></i>
                                </div>
                                <h4 class="criteria-title">Qualidade do Conteúdo</h4>
                                <p class="criteria-subtitle">Informações relevantes, corretas e bem apresentadas</p>
                                <div class="score-input-wrapper">
                                    <input 
                                        type="number" 
                                        id="notaConteudo" 
                                        name="nota_conteudo" 
                                        min="0" 
                                        max="100" 
                                        placeholder="0-100"
                                        class="score-input"
                                        value=""
                                    >
                                </div>
                                <div id="displayConteudo" class="score-display hidden">
                                    <span id="valorConteudo">0</span> pontos
                                </div>
                            </div>
                            <!-- Organização Visual e Layout -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-purple-500 to-violet-600">
                                    <i class="fas fa-th-large"></i>
                                </div>
                                <h4 class="criteria-title">Organização Visual e Layout</h4>
                                <p class="criteria-subtitle">Clareza, disposição dos elementos e aproveitamento do espaço</p>
                                <div class="score-input-wrapper">
                                    <input 
                                        type="number" 
                                        id="notaLayout" 
                                        name="nota_layout" 
                                        min="0" 
                                        max="100" 
                                        placeholder="0-100"
                                        class="score-input"
                                        value=""
                                    >
                                </div>
                                <div id="displayLayout" class="score-display hidden">
                                    <span id="valorLayout">0</span> pontos
                                </div>
                            </div>
                            <!-- Estética e Criatividade Visual -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-yellow-500 to-orange-600">
                                    <i class="fas fa-paint-brush"></i>
                                </div>
                                <h4 class="criteria-title">Estética e Criatividade Visual</h4>
                                <p class="criteria-subtitle">Beleza, originalidade e impacto visual</p>
                                <div class="score-input-wrapper">
                                    <input 
                                        type="number" 
                                        id="notaEstetica" 
                                        name="nota_estetica" 
                                        min="0" 
                                        max="100" 
                                        placeholder="0-100"
                                        class="score-input"
                                        value=""
                                    >
                                </div>
                                <div id="displayEstetica" class="score-display hidden">
                                    <span id="valorEstetica">0</span> pontos
                                </div>
                            </div>
                            <!-- Sustentabilidade na Construção -->
                            <div class="criteria-item">
                                <div class="criteria-icon bg-gradient-to-br from-green-700 to-lime-500">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <h4 class="criteria-title">Sustentabilidade na Construção</h4>
                                <p class="criteria-subtitle">Uso de materiais e práticas sustentáveis</p>
                                <div class="score-input-wrapper">
                                    <input 
                                        type="number" 
                                        id="notaSustentabilidade" 
                                        name="nota_sustentabilidade" 
                                        min="0" 
                                        max="100" 
                                        placeholder="0-100"
                                        class="score-input"
                                        value=""
                                    >
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
                                    <span id="pontosTotais">0</span> / 500
                                </p>
                                <p class="text-xs font-medium text-black opacity-75">
                                    Média: <span id="mediaPontos">0.0</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Botão de Envio -->
                    <div class="pt-8 flex justify-center">
                        <button type="submit" class="btn-primary btn-responsive font-bold text-white flex items-center justify-center gap-3 hover:scale-105 transition-transform">
                            <i class="fas fa-paper-plane"></i>
                            Confirmar Avaliação
                        </button>
                    </div>
                </form>
                <!-- Botão para Voltar -->
                <div id="voltarButton" class="mt-8 hidden">
                    <button onclick="resetForm()" class="btn-secondary btn-responsive font-semibold text-gray-300 flex items-center justify-center gap-2 mx-auto hover:scale-105 transition-transform">
                        <i class="fas fa-arrow-left"></i>
                        Nova Avaliação
                    </button>
                </div>
            </div>
        </div>
    </main>
    <!-- Tela de Sucesso -->
    <div id="sucessoPainel" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm p-4">
        <div class="card-bg rounded-3xl p-8 w-full max-w-md text-center fade-in">
            <div class="flex flex-col items-center gap-4 mb-6">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center pulse-glow">
                    <i class="fas fa-check-circle text-white text-4xl"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-green-400 mb-2">Avaliação Registrada!</h2>
                <p class="text-lg text-gray-200">As notas do painel foram computadas com sucesso.</p>
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl p-3 mt-2">
                    <p class="text-xl font-black text-black">
                        Total: <span id="pontosFinal">0</span> / 500 pontos
                    </p>
                </div>
            </div>
            <button onclick="fecharSucesso()" class="btn-primary btn-responsive font-semibold text-white flex items-center justify-center gap-2 mx-auto mt-4 hover:scale-105 transition-transform">
                <i class="fas fa-arrow-left"></i> Nova Avaliação
            </button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('painelForm');
            const pontosPainel = document.getElementById('pontosPainel');
            const voltarButton = document.getElementById('voltarButton');
            // Inputs
            const notaTema = document.getElementById('notaTema');
            const notaConteudo = document.getElementById('notaConteudo');
            const notaLayout = document.getElementById('notaLayout');
            const notaEstetica = document.getElementById('notaEstetica');
            const notaSustentabilidade = document.getElementById('notaSustentabilidade');
            // Displays
            const displayTema = document.getElementById('displayTema');
            const displayConteudo = document.getElementById('displayConteudo');
            const displayLayout = document.getElementById('displayLayout');
            const displayEstetica = document.getElementById('displayEstetica');
            const displaySustentabilidade = document.getElementById('displaySustentabilidade');
            const valorTema = document.getElementById('valorTema');
            const valorConteudo = document.getElementById('valorConteudo');
            const valorLayout = document.getElementById('valorLayout');
            const valorEstetica = document.getElementById('valorEstetica');
            const valorSustentabilidade = document.getElementById('valorSustentabilidade');
            const pontosTotais = document.getElementById('pontosTotais');
            const mediaPontos = document.getElementById('mediaPontos');
            // Garantir que os inputs começem vazios
            notaTema.value = '';
            notaConteudo.value = '';
            notaLayout.value = '';
            notaEstetica.value = '';
            notaSustentabilidade.value = '';
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
                const tema = notaTema.value !== '' ? parseInt(notaTema.value) || 0 : 0;
                const conteudo = notaConteudo.value !== '' ? parseInt(notaConteudo.value) || 0 : 0;
                const layout = notaLayout.value !== '' ? parseInt(notaLayout.value) || 0 : 0;
                const estetica = notaEstetica.value !== '' ? parseInt(notaEstetica.value) || 0 : 0;
                const sustentabilidade = notaSustentabilidade.value !== '' ? parseInt(notaSustentabilidade.value) || 0 : 0;
                const total = tema + conteudo + layout + estetica + sustentabilidade;
                const media = total > 0 ? total / 5 : 0;
                pontosTotais.textContent = total;
                mediaPontos.textContent = media.toFixed(1);
                // Mostrar painel se houver pelo menos uma nota
                if ((tema > 0 || conteudo > 0 || layout > 0 || estetica > 0 || sustentabilidade > 0)) {
                    pontosPainel.classList.remove('hidden');
                } else {
                    pontosPainel.classList.add('hidden');
                }
            }
            // Event listeners para os inputs de nota
            notaTema.addEventListener('input', function() {
                atualizarDisplayNota(this, displayTema, valorTema);
            });
            notaConteudo.addEventListener('input', function() {
                atualizarDisplayNota(this, displayConteudo, valorConteudo);
            });
            notaLayout.addEventListener('input', function() {
                atualizarDisplayNota(this, displayLayout, valorLayout);
            });
            notaEstetica.addEventListener('input', function() {
                atualizarDisplayNota(this, displayEstetica, valorEstetica);
            });
            notaSustentabilidade.addEventListener('input', function() {
                atualizarDisplayNota(this, displaySustentabilidade, valorSustentabilidade);
            });
            // Validação em tempo real para limitar valores
            [notaTema, notaConteudo, notaLayout, notaEstetica, notaSustentabilidade].forEach(input => {
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
            // Submissão do formulário
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const tema = notaTema.value !== '' ? parseInt(notaTema.value) || 0 : 0;
                const conteudo = notaConteudo.value !== '' ? parseInt(notaConteudo.value) || 0 : 0;
                const layout = notaLayout.value !== '' ? parseInt(notaLayout.value) || 0 : 0;
                const estetica = notaEstetica.value !== '' ? parseInt(notaEstetica.value) || 0 : 0;
                const sustentabilidade = notaSustentabilidade.value !== '' ? parseInt(notaSustentabilidade.value) || 0 : 0;
                if (tema === 0 && conteudo === 0 && layout === 0 && estetica === 0 && sustentabilidade === 0) {
                    alert('Por favor, preencha pelo menos uma nota.');
                    notaTema.focus();
                    return;
                }
                const inputs = [notaTema, notaConteudo, notaLayout, notaEstetica, notaSustentabilidade];
                for (let input of inputs) {
                    if (input.value !== '' && !validarNota(input, parseInt(input.value))) {
                        alert('Por favor, digite notas válidas entre 0 e 100.');
                        input.focus();
                        return;
                    }
                }
                const total = tema + conteudo + layout + estetica + sustentabilidade;
                document.getElementById('pontosFinal').textContent = total;
                form.style.display = 'none';
                voltarButton.classList.add('hidden');
                document.getElementById('sucessoPainel').classList.remove('hidden');
            });
            // Função global para reset
            window.resetForm = function() {
                form.style.display = 'block';
                voltarButton.classList.add('hidden');
                form.reset();
                pontosPainel.classList.add('hidden');
                notaTema.value = '';
                notaConteudo.value = '';
                notaLayout.value = '';
                notaEstetica.value = '';
                notaSustentabilidade.value = '';
                displayTema.classList.add('hidden');
                displayConteudo.classList.add('hidden');
                displayLayout.classList.add('hidden');
                displayEstetica.classList.add('hidden');
                displaySustentabilidade.classList.add('hidden');
                [notaTema, notaConteudo, notaLayout, notaEstetica, notaSustentabilidade].forEach(input => {
                    input.classList.remove('valid', 'invalid');
                });
            };
            // Função global para fechar sucesso
            window.fecharSucesso = function() {
                document.getElementById('sucessoPainel').classList.add('hidden');
                resetForm();
            };
        });
    </script>
</body>
</html>
