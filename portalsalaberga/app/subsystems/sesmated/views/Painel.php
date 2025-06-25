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
    <main class="container mx-auto px-4 sm:px-6 py-8">
        <!-- Cadastro Section -->
        <section class="mb-12">
            <div class="card-bg rounded-3xl p-8 fade-in">
                <div class="flex items-center gap-3 mb-8">
                    <i class="fas fa-plus-circle text-2xl" style="color: var(--header-color);"></i>
                    <h2 class="text-2xl font-bold">Cadastrar Painel</h2>
                </div>
                
                <form id="painelForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-heading mr-2"></i>Título do Painel
                            </label>
                            <input type="text" id="tituloPainel" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-graduation-cap mr-2"></i>Curso Responsável
                            </label>
                            <select id="cursoPainel" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                                <option value="">Selecione o curso</option>
                                <option value="Enfermagem">Enfermagem</option>
                                <option value="Informática">Informática</option>
                                <option value="Meio ambiente">Meio ambiente</option>
                                <option value="Administração">Administração</option>
                                <option value="Edificações">Edificações</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-users mr-2"></i>Equipe Responsável (separar nomes por vírgula)
                        </label>
                        <textarea id="equipePainel" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="2"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-align-left mr-2"></i>Resumo do Conteúdo
                        </label>
                        <textarea id="resumoPainel" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="4" required></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-chart-line mr-2"></i>Como aborda Desenvolvimento Econômico
                        </label>
                        <textarea id="desenvolvimentoEconomico" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3" required></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-users mr-2"></i>Como aborda Desenvolvimento Social
                        </label>
                        <textarea id="desenvolvimentoSocial" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3" required></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                            <i class="fas fa-leaf mr-2"></i>Como aborda Sustentabilidade
                        </label>
                        <textarea id="sustentabilidade" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3" required></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-tools mr-2"></i>Materiais Utilizados
                            </label>
                            <textarea id="materiaisPainel" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-4 text-gray-300 uppercase tracking-wide">
                                <i class="fas fa-cogs mr-2"></i>Técnicas Aplicadas
                            </label>
                            <textarea id="tecnicasPainel" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary px-8 py-3 rounded-2xl font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Cadastrar Painel
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Painéis Grid -->
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <i class="fas fa-list text-2xl" style="color: var(--header-color);"></i>
                <h2 class="text-2xl font-bold">Painéis Cadastrados</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="paineisList">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </section>

        <!-- Avaliação Modal -->
        <div id="avaliacaoModal" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
            <div class="modal-bg rounded-3xl p-8 w-full max-w-4xl mx-4 slide-up max-h-[90vh] overflow-y-auto">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold">Avaliar Painel</h2>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2" id="painelAvaliando"></h3>
                    <p class="text-sm text-gray-400" id="resumoAvaliando"></p>
                </div>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-3">💰 Desenvolvimento Econômico (0-25 pontos)</label>
                        <input type="range" id="economico" min="0" max="25" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="economicoValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>25</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Clareza na abordagem de aspectos econômicos para comunidades resilientes</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-3">👥 Desenvolvimento Social (0-25 pontos)</label>
                        <input type="range" id="social" min="0" max="25" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="socialValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>25</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Abordagem de questões sociais e impacto na comunidade</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-3">🌱 Sustentabilidade (0-25 pontos)</label>
                        <input type="range" id="sustentabilidadePainel" min="0" max="25" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="sustentabilidadePainelValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>25</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Integração de práticas sustentáveis e consciência ambiental</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-3">🎨 Qualidade Visual e Organização (0-15 pontos)</label>
                        <input type="range" id="qualidadeVisual" min="0" max="15" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="qualidadeVisualValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>15</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Estética, organização e aproveitamento do espaço 2m x 1,8m</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-3">📚 Conteúdo e Informação (0-10 pontos)</label>
                        <input type="range" id="conteudoInfo" min="0" max="10" value="0" class="range-slider w-full">
                        <div class="flex justify-between text-sm mt-2">
                            <span>0</span>
                            <span id="conteudoInfoValue" class="text-yellow-400 font-bold">0 pontos</span>
                            <span>10</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Qualidade e relevância das informações apresentadas</p>
                    </div>
                </div>
                
                <div class="mt-8 p-6 bg-gray-800/50 rounded-2xl">
                    <h4 class="text-lg font-semibold mb-2">Pontuação Total: <span id="totalPontos" class="text-yellow-400 text-2xl font-bold">0</span>/100</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium mb-3">Nome do Jurado</label>
                        <input type="text" id="nomeJurado" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-3">Observações</label>
                        <textarea id="observacoes" class="input-field w-full rounded-2xl px-4 py-3 text-white focus:outline-none" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 pt-8">
                    <button onclick="salvarAvaliacao()" class="btn-primary flex-1 py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Salvar Avaliação
                    </button>
                    <button onclick="fecharAvaliacao()" class="btn-secondary flex-1 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                </div>
            </div>
        </div>

        <!-- Relatórios Section -->
        <section class="text-center space-y-6">
            <div class="flex items-center justify-center gap-3 mb-8">
                <i class="fas fa-chart-line text-2xl" style="color: var(--accent-color);"></i>
                <h2 class="text-2xl font-bold">Relatórios Detalhados</h2>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="gerarRelatorioGeral()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-file-alt"></i>
                    Relatório Geral
                </button>
                <button onclick="gerarRanking()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-trophy"></i>
                    Ranking Final
                </button>
                <button onclick="calcularPontuacao()" class="btn-secondary px-6 py-3 rounded-2xl font-semibold text-gray-300 flex items-center justify-center gap-2">
                    <i class="fas fa-medal"></i>
                    Pontuação por Posição
                </button>
            </div>
        </section>
    </main>

    <script>
        let paineis = JSON.parse(localStorage.getItem('paineis') || '[]');
        let avaliacoes = JSON.parse(localStorage.getItem('avaliacoes_paineis') || '[]');
        let painelAtual = null;

        const cursoColors = {
            'Informática': 'from-blue-500 to-cyan-600',
            'Enfermagem': 'from-red-500 to-pink-600',
            'Administração': 'from-purple-500 to-indigo-600',
            'Agropecuária': 'from-green-500 to-emerald-600'
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderPaineis();
            
            // Form submission
            document.getElementById('painelForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const painel = {
                    id: Date.now(),
                    titulo: document.getElementById('tituloPainel').value,
                    curso: document.getElementById('cursoPainel').value,
                    equipe: document.getElementById('equipePainel').value,
                    resumo: document.getElementById('resumoPainel').value,
                    desenvolvimentoEconomico: document.getElementById('desenvolvimentoEconomico').value,
                    desenvolvimentoSocial: document.getElementById('desenvolvimentoSocial').value,
                    sustentabilidade: document.getElementById('sustentabilidade').value,
                    materiais: document.getElementById('materiaisPainel').value,
                    tecnicas: document.getElementById('tecnicasPainel').value,
                    timestamp: new Date().toISOString()
                };
                
                paineis.push(painel);
                localStorage.setItem('paineis', JSON.stringify(paineis));
                
                this.reset();
                renderPaineis();
                
                showNotification('Painel cadastrado com sucesso!', 'success');
            });

            // Atualizar valores dos sliders
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.addEventListener('input', function() {
                    document.getElementById(this.id + 'Value').textContent = this.value + ' pontos';
                    calcularTotal();
                });
            });
        });

        function renderPaineis() {
            const container = document.getElementById('paineisList');
            container.innerHTML = '';
            
            if (paineis.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-20">
                        <div class="w-32 h-32 mx-auto mb-8 rounded-3xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center">
                            <i class="fas fa-chalkboard text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-300 mb-4">Nenhum painel cadastrado</h3>
                        <p class="text-gray-400 mb-8 text-lg">Adicione o primeiro painel para começar</p>
                    </div>
                `;
                return;
            }
            
            paineis.forEach(painel => {
                const avaliacoesPainel = avaliacoes.filter(a => a.painelId === painel.id);
                const mediaNotas = avaliacoesPainel.length > 0 
                    ? (avaliacoesPainel.reduce((sum, a) => sum + a.total, 0) / avaliacoesPainel.length).toFixed(1)
                    : 'Não avaliado';
                
                const card = document.createElement('div');
                card.className = 'card-bg rounded-3xl p-6 card-hover transition-all duration-300 fade-in';
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br ${cursoColors[painel.curso] || 'from-gray-600 to-gray-700'} flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-chalkboard text-white text-xl"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xl font-bold text-white mb-1">${painel.titulo}</h3>
                                <p class="text-sm text-gray-400 font-medium">${painel.curso}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-gray-400 text-sm">Equipe:</span>
                            <p class="text-gray-300 text-sm mt-1">${painel.equipe || 'Não informado'}</p>
                        </div>
                        
                        <div>
                            <span class="text-gray-400 text-sm">Resumo:</span>
                            <p class="text-gray-300 text-sm mt-1">${painel.resumo.substring(0, 100)}${painel.resumo.length > 100 ? '...' : ''}</p>
                        </div>
                        
                        <div class="space-y-2 text-xs">
                            <div>
                                <span class="text-gray-400">Desenvolvimento Econômico:</span>
                                <p class="text-gray-300">${painel.desenvolvimentoEconomico.substring(0, 80)}${painel.desenvolvimentoEconomico.length > 80 ? '...' : ''}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Desenvolvimento Social:</span>
                                <p class="text-gray-300">${painel.desenvolvimentoSocial.substring(0, 80)}${painel.desenvolvimentoSocial.length > 80 ? '...' : ''}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Sustentabilidade:</span>
                                <p class="text-gray-300">${painel.sustentabilidade.substring(0, 80)}${painel.sustentabilidade.length > 80 ? '...' : ''}</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300 font-semibold">Média de Avaliação</span>
                            <span class="text-2xl font-bold" style="color: var(--accent-color);">${mediaNotas}</span>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-xs text-gray-400 mb-3">Avaliações: ${avaliacoesPainel.length}</p>
                            <button onclick="avaliarPainel(${painel.id})" 
                                    class="btn-primary w-full py-3 rounded-2xl font-semibold text-white flex items-center justify-center gap-2">
                                <i class="fas fa-star"></i>
                                Avaliar
                            </button>
                        </div>
                    </div>
                `;
                
                container.appendChild(card);
            });
        }

        function avaliarPainel(id) {
            painelAtual = paineis.find(p => p.id === id);
            document.getElementById('painelAvaliando').textContent = 
                `${painelAtual.titulo} (${painelAtual.curso})`;
            document.getElementById('resumoAvaliando').textContent = painelAtual.resumo;
            
            // Reset form
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.value = 0;
                document.getElementById(slider.id + 'Value').textContent = '0 pontos';
            });
            document.getElementById('nomeJurado').value = '';
            document.getElementById('observacoes').value = '';
            calcularTotal();
            
            document.getElementById('avaliacaoModal').classList.remove('hidden');
            document.getElementById('avaliacaoModal').classList.add('flex');
        }

        function calcularTotal() {
            const economico = parseInt(document.getElementById('economico').value);
            const social = parseInt(document.getElementById('social').value);
            const sustentabilidadePainel = parseInt(document.getElementById('sustentabilidadePainel').value);
            const qualidadeVisual = parseInt(document.getElementById('qualidadeVisual').value);
            const conteudoInfo = parseInt(document.getElementById('conteudoInfo').value);
            
            const total = economico + social + sustentabilidadePainel + qualidadeVisual + conteudoInfo;
            document.getElementById('totalPontos').textContent = total;
        }

        function salvarAvaliacao() {
            if (!painelAtual || !document.getElementById('nomeJurado').value) {
                showNotification('Preencha o nome do jurado!', 'error');
                return;
            }
            
            const avaliacao = {
                id: Date.now(),
                painelId: painelAtual.id,
                jurado: document.getElementById('nomeJurado').value,
                economico: parseInt(document.getElementById('economico').value),
                social: parseInt(document.getElementById('social').value),
                sustentabilidadePainel: parseInt(document.getElementById('sustentabilidadePainel').value),
                qualidadeVisual: parseInt(document.getElementById('qualidadeVisual').value),
                conteudoInfo: parseInt(document.getElementById('conteudoInfo').value),
                total: parseInt(document.getElementById('totalPontos').textContent),
                observacoes: document.getElementById('observacoes').value,
                timestamp: new Date().toISOString()
            };
            
            avaliacoes.push(avaliacao);
            localStorage.setItem('avaliacoes_paineis', JSON.stringify(avaliacoes));
            
            showNotification('Avaliação salva com sucesso!', 'success');
            fecharAvaliacao();
            renderPaineis();
        }

        function fecharAvaliacao() {
            document.getElementById('avaliacaoModal').classList.add('hidden');
            document.getElementById('avaliacaoModal').classList.remove('flex');
            painelAtual = null;
        }

        function gerarRelatorioGeral() {
            let relatorio = 'RELATÓRIO GERAL - PAINÉIS\n';
            relatorio += '='.repeat(60) + '\n\n';
            relatorio += 'TEMA: "Desenvolvimento econômico, social e sustentável para comunidades resilientes"\n';
            relatorio += 'TAMANHO: 2m x 1,8m\n\n';
            
            paineis.forEach(painel => {
                const avaliacoesPainel = avaliacoes.filter(a => a.painelId === painel.id);
                relatorio += `PAINEL: ${painel.titulo}\n`;
                relatorio += `Curso: ${painel.curso}\n`;
                relatorio += `Equipe: ${painel.equipe}\n`;
                relatorio += `Resumo: ${painel.resumo}\n`;
                relatorio += `Desenvolvimento Econômico: ${painel.desenvolvimentoEconomico}\n`;
                relatorio += `Desenvolvimento Social: ${painel.desenvolvimentoSocial}\n`;
                relatorio += `Sustentabilidade: ${painel.sustentabilidade}\n`;
                relatorio += `Materiais: ${painel.materiais}\n`;
                relatorio += `Técnicas: ${painel.tecnicas}\n\n`;
                
                if (avaliacoesPainel.length > 0) {
                    relatorio += 'AVALIAÇÕES:\n';
                    avaliacoesPainel.forEach(av => {
                        relatorio += `  Jurado: ${av.jurado}\n`;
                        relatorio += `  Desenvolvimento Econômico: ${av.economico}/25\n`;
                        relatorio += `  Desenvolvimento Social: ${av.social}/25\n`;
                        relatorio += `  Sustentabilidade: ${av.sustentabilidadePainel}/25\n`;
                        relatorio += `  Qualidade Visual: ${av.qualidadeVisual}/15\n`;
                        relatorio += `  Conteúdo: ${av.conteudoInfo}/10\n`;
                        relatorio += `  TOTAL: ${av.total}/100\n`;
                        if (av.observacoes) {
                            relatorio += `  Observações: ${av.observacoes}\n`;
                        }
                        relatorio += '\n';
                    });
                    
                    const media = (avaliacoesPainel.reduce((sum, a) => sum + a.total, 0) / avaliacoesPainel.length).toFixed(2);
                    relatorio += `MÉDIA FINAL: ${media}/100\n`;
                } else {
                    relatorio += 'Não avaliado\n';
                }
                
                relatorio += '-'.repeat(40) + '\n\n';
            });
            
            downloadFile(relatorio, 'relatorio_paineis.txt');
        }

        function gerarRanking() {
            const ranking = paineis.map(painel => {
                const avaliacoesPainel = avaliacoes.filter(a => a.painelId === painel.id);
                const media = avaliacoesPainel.length > 0 
                    ? avaliacoesPainel.reduce((sum, a) => sum + a.total, 0) / avaliacoesPainel.length
                    : 0;
                
                return {
                    ...painel,
                    media: media,
                    totalAvaliacoes: avaliacoesPainel.length
                };
            }).sort((a, b) => b.media - a.media);
            
            let relatorio = 'RANKING FINAL - PAINÉIS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            ranking.forEach((painel, index) => {
                relatorio += `${index + 1}º LUGAR\n`;
                relatorio += `Painel: ${painel.titulo}\n`;
                relatorio += `Curso: ${painel.curso}\n`;
                relatorio += `Equipe: ${painel.equipe}\n`;
                relatorio += `Média: ${painel.media.toFixed(2)}/100\n`;
                relatorio += `Avaliações: ${painel.totalAvaliacoes}\n\n`;
            });
            
            downloadFile(relatorio, 'ranking_paineis.txt');
        }

        function calcularPontuacao() {
            const ranking = paineis.map(painel => {
                const avaliacoesPainel = avaliacoes.filter(a => a.painelId === painel.id);
                const media = avaliacoesPainel.length > 0 
                    ? avaliacoesPainel.reduce((sum, a) => sum + a.total, 0) / avaliacoesPainel.length
                    : 0;
                
                return {
                    ...painel,
                    media: media
                };
            }).sort((a, b) => b.media - a.media);
            
            let relatorio = 'PONTUAÇÃO POR POSIÇÃO - PAINÉIS\n';
            relatorio += '='.repeat(50) + '\n\n';
            
            const pontuacoes = [500, 450, 400, 350, 300];
            
            ranking.forEach((painel, index) => {
                const posicao = index + 1;
                const pontos = index < pontuacoes.length ? pontuacoes[index] : 0;
                
                relatorio += `${posicao}º LUGAR - ${pontos} PONTOS\n`;
                relatorio += `Painel: ${painel.titulo}\n`;
                relatorio += `Curso: ${painel.curso}\n`;
                relatorio += `Equipe: ${painel.equipe}\n`;
                relatorio += `Média de avaliação: ${painel.media.toFixed(2)}/100\n\n`;
            });
            
            downloadFile(relatorio, 'pontuacao_posicao_paineis.txt');
        }

        function downloadFile(content, filename) {
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            a.click();
            URL.revokeObjectURL(url);
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-2xl text-white font-semibold ${
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            } slide-up`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Event listeners
        document.getElementById('avaliacaoModal').addEventListener('click', function(e) {
            if (e.target === this) fecharAvaliacao();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!document.getElementById('avaliacaoModal').classList.contains('hidden')) fecharAvaliacao();
            }
        });
    </script>
</body>
</html>
