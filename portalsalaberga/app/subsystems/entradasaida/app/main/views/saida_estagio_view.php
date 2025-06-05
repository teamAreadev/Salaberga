<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">Você precisa estar logado para visualizar esta página.</div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salaberga - Visualizar Saídas de Estágio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ceara-green': '#008C45',
                        'ceara-light-green': '#3CB371',
                        'ceara-olive': '#8CA03E',
                        'ceara-orange': '#FFA500',
                    }
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f8fafc;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(90deg, #008C45, #3CB371);
        }

        .gradient-text {
            background: linear-gradient(45deg, #008C45, #3CB371);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .footer {
            background: white;
            border-top: 1px solid #e5e7eb;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: linear-gradient(70deg, #008C45, #FFA500);
        }

        .icon-container {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(0, 140, 69, 0.1);
            color: #008C45;
        }

        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Estilização da tabela */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        thead tr {
            background: linear-gradient(90deg, #f9fafb, #f3f4f6);
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
            white-space: nowrap;
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .refresh-icon {
            transition: transform 0.5s ease;
        }

        .refresh-icon.spinning {
            transform: rotate(360deg);
        }

        /* Mobile Card Styles */
        .mobile-card {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .mobile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mobile-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .mobile-card-content {
            display: grid;
            gap: 0.5rem;
        }

        .mobile-card-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-card-label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .mobile-card-value {
            color: #1f2937;
            font-weight: 500;
            font-size: 0.875rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mobile-card {
            animation: fadeInUp 0.3s ease-out forwards;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="header fixed top-0 left-0 right-0 h-16 flex items-center justify-between px-6 text-white shadow-md z-50">
        <div class="text-xl font-semibold">
            <i class="fas fa-graduation-cap mr-2"></i>
            Salaberga
        </div>
        <nav class="flex items-center gap-3">
            <a href="inicio.php" class="flex items-center gap-2 px-3 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors text-sm">
                <i class="fas fa-home"></i>
                <span>Menu</span>
            </a>
            <a href="saida_estagio.php" class="flex items-center gap-2 px-3 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors text-sm">
                <i class="fas fa-briefcase"></i>
                <span class="hidden sm:inline">Registrar Saída</span>
                <span class="sm:hidden">Registrar</span>
            </a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-4 py-8 mt-16 mb-16">
        <div class="max-w-5xl mx-auto slide-in">
            <!-- Title Section -->
            <div class="text-center mb-8">
                <div class="icon-container mx-auto mb-4">
                    <i class="fas fa-clipboard-list text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold mb-2">
                    <span class="gradient-text">Registros de Saída de Estágio</span>
                </h1>
                <p class="text-gray-600 text-sm">Visualize em tempo real as saídas de alunos para estágio</p>
            </div>

            <!-- Controls and Filters -->
            <div class="card p-4 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-2">
                        <button id="refreshBtn" class="flex items-center gap-2 px-3 py-2 bg-ceara-green text-white rounded-lg hover:bg-ceara-light-green transition-colors text-sm">
                            <i id="refreshIcon" class="fas fa-sync-alt refresh-icon"></i>
                            <span>Atualizar</span>
                        </button>
                        <span id="lastUpdate" class="text-xs text-gray-500">Última atualização: agora</span>
                    </div>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Buscar aluno..." 
                            class="pl-10 pr-4 py-2 border-2 border-gray-200 rounded-lg focus:border-ceara-green outline-none transition-all duration-300 text-sm w-full sm:w-64"
                        >
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card p-6">
                <!-- Desktop Table View -->
                <div class="table-container hidden md:block">
                    <table id="registros" class="w-full">
                        <thead>
                            <tr>
                                <th class="text-sm">ID</th>
                                <th class="text-sm">Nome do Aluno</th>
                                <th class="text-sm">Curso</th>
                                <th class="text-sm">Data e Hora</th>
                                <th class="text-sm">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center py-8">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <div class="w-8 h-8 mb-4 border-t-2 border-b-2 border-ceara-green rounded-full animate-spin"></div>
                                        <p>Carregando registros...</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div id="mobileCards" class="md:hidden space-y-4">
                    <!-- Loading State for Mobile -->
                    <div class="card-loading py-8 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <div class="w-8 h-8 mb-4 border-t-2 border-b-2 border-ceara-green rounded-full animate-spin"></div>
                            <p>Carregando registros...</p>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="hidden py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-500">
                        <div class="w-16 h-16 mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-clipboard text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 mb-1">Nenhum registro encontrado</h3>
                        <p class="text-sm text-gray-500 mb-4">Não há registros de saída de estágio no momento.</p>
                        <a href="saida_estagio.php" class="inline-flex items-center gap-2 px-4 py-2 bg-ceara-green text-white rounded-lg hover:bg-ceara-light-green transition-colors text-sm">
                            <i class="fas fa-plus"></i>
                            <span>Registrar Saída</span>
                        </a>
                    </div>
                </div>

                <!-- Error State -->
                <div id="errorState" class="hidden py-8 text-center">
                    <div class="flex flex-col items-center justify-center text-red-500">
                        <div class="w-16 h-16 mb-4 rounded-full bg-red-100 flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-red-700 mb-1">Erro ao carregar dados</h3>
                        <p id="errorMessage" class="text-sm text-red-500 mb-4">Ocorreu um erro ao buscar os registros.</p>
                        <button id="retryBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-ceara-green text-white rounded-lg hover:bg-ceara-light-green transition-colors text-sm">
                            <i class="fas fa-redo"></i>
                            <span>Tentar novamente</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card p-4 mt-6 bg-blue-50 border border-blue-200">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 text-blue-600">
                        <i class="fas fa-info-circle mt-0.5"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 mb-1">Atualização automática</h3>
                        <p class="text-xs text-blue-700">
                            Esta página atualiza automaticamente a cada 5 segundos para mostrar os registros mais recentes.
                            Você também pode atualizar manualmente clicando no botão "Atualizar".
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer relative py-4 text-center text-gray-600 text-xs">
        <div class="container mx-auto">
            <p>© 2025 Sistema Escolar Salaberga. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Elementos DOM
        const refreshBtn = document.getElementById('refreshBtn');
        const refreshIcon = document.getElementById('refreshIcon');
        const lastUpdate = document.getElementById('lastUpdate');
        const searchInput = document.getElementById('searchInput');
        const emptyState = document.getElementById('emptyState');
        const errorState = document.getElementById('errorState');
        const errorMessage = document.getElementById('errorMessage');
        const retryBtn = document.getElementById('retryBtn');
        const tbody = document.querySelector('#registros tbody');
        
        // Armazena os dados originais para filtragem
        let allRegistros = [];
        
        // Formata a data e hora
        function formatDateTime(dateTimeStr) {
            const date = new Date(dateTimeStr);
            return date.toLocaleString('pt-BR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        
        // Atualiza o texto de última atualização
        function updateLastUpdateText() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('pt-BR', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            lastUpdate.textContent = `Última atualização: ${timeStr}`;
        }
        
        // Animação de atualização
        function animateRefresh() {
            refreshIcon.classList.add('spinning');
            setTimeout(() => {
                refreshIcon.classList.remove('spinning');
            }, 1000);
        }
        
        // Filtra os registros com base na busca
        function filterRegistros() {
            const searchTerm = searchInput.value.toLowerCase();
            
            if (!searchTerm) {
                renderRegistros(allRegistros);
                return;
            }
            
            const filtered = allRegistros.filter(registro => 
                registro.nome_aluno.toLowerCase().includes(searchTerm) ||
                registro.curso.toLowerCase().includes(searchTerm)
            );
            
            renderRegistros(filtered);
        }
        
        // Renderiza os registros na tabela
        function renderRegistros(registros) {
            const tbody = document.querySelector('#registros tbody');
            const mobileCards = document.getElementById('mobileCards');
            
            tbody.innerHTML = '';
            mobileCards.innerHTML = '';
            
            if (registros.length === 0) {
                emptyState.classList.remove('hidden');
                return;
            }
            
            emptyState.classList.add('hidden');
            
            registros.forEach((registro, index) => {
                // Determina o status com base na data/hora
                const registroDate = new Date(registro.dae);
                const now = new Date();
                const diffHours = (now - registroDate) / (1000 * 60 * 60);
                
                let statusClass = 'bg-green-100 text-green-800';
                let statusText = 'Recente';
                let statusIcon = 'fa-clock';
                
                if (diffHours > 24) {
                    statusClass = 'bg-gray-100 text-gray-800';
                    statusText = 'Concluído';
                    statusIcon = 'fa-check';
                } else if (diffHours > 2) {
                    statusClass = 'bg-yellow-100 text-yellow-800';
                    statusText = 'Em andamento';
                    statusIcon = 'fa-spinner';
                }

                // Renderiza a linha da tabela (desktop)
                const row = document.createElement('tr');
                row.classList.add('fade-in');
                row.style.animationDelay = `${index * 0.05}s`;
                
                row.innerHTML = `
                    <td class="text-sm font-medium text-gray-700">${registro.id_saida}</td>
                    <td class="text-sm">${registro.nome_aluno}</td>
                    <td class="text-sm">${registro.curso}</td>
                    <td class="text-sm">${formatDateTime(registro.dae)}</td>
                    <td>
                        <span class="status-badge ${statusClass} px-2 py-1 rounded-full text-xs">
                            <i class="fas ${statusIcon} mr-1"></i>
                            ${statusText}
                        </span>
                    </td>
                `;
                
                tbody.appendChild(row);

                // Renderiza o card (mobile)
                const card = document.createElement('div');
                card.classList.add('mobile-card');
                card.style.animationDelay = `${index * 0.05}s`;
                
                card.innerHTML = `
                    <div class="mobile-card-header">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user-graduate text-ceara-green"></i>
                            <span class="font-medium text-gray-900">${registro.nome_aluno}</span>
                        </div>
                        <span class="status-badge ${statusClass} px-2 py-1 rounded-full text-xs">
                            <i class="fas ${statusIcon} mr-1"></i>
                            ${statusText}
                        </span>
                    </div>
                    <div class="mobile-card-content">
                        <div class="mobile-card-row">
                            <span class="mobile-card-label">ID:</span>
                            <span class="mobile-card-value">${registro.id_saida}</span>
                        </div>
                        <div class="mobile-card-row">
                            <span class="mobile-card-label">Curso:</span>
                            <span class="mobile-card-value">${registro.curso}</span>
                        </div>
                        <div class="mobile-card-row">
                            <span class="mobile-card-label">Data/Hora:</span>
                            <span class="mobile-card-value">${formatDateTime(registro.dae)}</span>
                        </div>
                    </div>
                `;
                
                mobileCards.appendChild(card);
            });
        }
        
        // Busca os registros do servidor
        function fetchRegistros() {
            animateRefresh();
            updateLastUpdateText();
            
            fetch('saida_estagio_fetch.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        throw new Error("Resposta não é JSON válido: " + text);
                    }
                    
                    // Esconde estados de erro
                    errorState.classList.add('hidden');
                    
                    // Armazena todos os registros
                    allRegistros = data.error ? [] : data;
                    
                    // Aplica filtro atual
                    filterRegistros();
                })
                .catch(error => {
                    console.error('Erro ao buscar registros:', error);
                    errorMessage.textContent = `Erro ao carregar registros: ${error.message}`;
                    errorState.classList.remove('hidden');
                    emptyState.classList.add('hidden');
                    tbody.innerHTML = '';
                });
        }
        
        // Event Listeners
        refreshBtn.addEventListener('click', fetchRegistros);
        retryBtn.addEventListener('click', fetchRegistros);
        searchInput.addEventListener('input', filterRegistros);
        
        // Inicialização
        document.addEventListener('DOMContentLoaded', () => {
            fetchRegistros();
            // Atualiza automaticamente a cada 5 segundos
            setInterval(fetchRegistros, 5000);
        });
    </script>
</body>
</html>