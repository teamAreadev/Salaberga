<?php
// Iniciar sessão
session_start();

// Verificação mais robusta da sessão do admin
if (!isset($_SESSION['admin_id']) || 
    !isset($_SESSION['admin_logado']) || 
    $_SESSION['admin_logado'] !== true || 
    !isset($_SESSION['admin_usuario'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Inscrições - Copa Grêmio 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Design%20sem%20nome-MOpK2hbpuoqfoF8sir0Ue6SvciAArc.svg" type="image/svg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-500: #007d40;
            --primary-600: #006a36;
            --primary-700: #005A24;
        }
        
        .card {
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-weight: 500;
        }
        
        .btn-action {
            transition: all 0.2s ease;
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Header -->
    <header class="bg-gradient-to-r from-green-700 to-green-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Design%20sem%20nome-MOpK2hbpuoqfoF8sir0Ue6SvciAArc.svg" 
                         alt="Logo Copa Grêmio" 
                         class="h-12 w-12">
                    <div>
                        <h1 class="text-xl font-bold">Copa Grêmio 2025</h1>
                        <p class="text-green-200 text-sm">Painel Administrativo</p>
                    </div>
                </div>
                <a href="logout.php" class="flex items-center space-x-2 bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </a>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Gerenciar Inscrições</h1>
            <p class="text-gray-600">Gerencie todas as inscrições individuais e coletivas</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stats-grid">
            <div class="card bg-white rounded-xl p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg mr-4 text-green-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total de Inscrições</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="total-inscricoes">0</h3>
                    </div>
                </div>
            </div>
            
            <div class="card bg-white rounded-xl p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-lg mr-4 text-yellow-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Inscrições Pendentes</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="inscricoes-pendentes">0</h3>
                    </div>
                </div>
            </div>
            
            <div class="card bg-white rounded-xl p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg mr-4 text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Inscrições Aprovadas</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="inscricoes-aprovadas">0</h3>
                    </div>
                </div>
            </div>
            
            <div class="card bg-white rounded-xl p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded-lg mr-4 text-red-600">
                        <i class="fas fa-times-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Inscrições Reprovadas</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="inscricoes-reprovadas">0</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Inscrições Section -->
        <div class="card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-clipboard-list mr-3 text-green-600"></i> 
                            Todas as Inscrições
                </h2>
                        <p class="text-gray-500 text-sm mt-1">Gerencie inscrições individuais e coletivas</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative">
                            <input type="text" id="search" placeholder="Buscar inscrição..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        <div class="relative">
                            <select id="status-filter" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none bg-white pr-10">
                                <option value="todos">Todos os status</option>
                                <option value="pendente">Pendentes</option>
                                <option value="aprovado">Aprovados</option>
                                <option value="reprovado">Reprovados</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <button id="refresh-btn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center whitespace-nowrap">
                            <i class="fas fa-sync-alt mr-2"></i> Atualizar
                        </button>
                    </div>
                </div>
            </div>
            
            <div id="inscricoes-container" class="p-6">
                <div class="flex justify-center items-center py-12">
                    <i class="fas fa-spinner fa-spin mr-3 text-green-600 text-xl"></i>
                    <span class="text-gray-500">Carregando inscrições...</span>
                                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inscricoesContainer = document.getElementById('inscricoes-container');
            const searchInput = document.getElementById('search');
            const statusFilter = document.getElementById('status-filter');
            const refreshBtn = document.getElementById('refresh-btn');
            let inscricoes = [];

            // Função para carregar todas as inscrições
            async function carregarInscricoes() {
                try {
                    const response = await fetch('../controllers/AdminController.php?action=listar-inscricoes');
                    const data = await response.json();
                        
                        if (data.success) {
                        inscricoes = data.inscricoes;
                        renderizarInscricoes(inscricoes);
                        atualizarContadores(inscricoes);
                        } else {
                        throw new Error(data.message || 'Erro ao carregar inscrições');
                    }
                } catch (error) {
                    console.error('Erro:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Erro ao carregar inscrições'
                    });
                }
            }
            
            // Função para renderizar as inscrições
            function renderizarInscricoes(inscricoes) {
                inscricoesContainer.innerHTML = inscricoes.map(inscricao => {
                    // Verificar se é inscrição coletiva
                    if (inscricao.tipo_inscricao === 'coletiva') {
                        return `
                        <div class="card bg-white rounded-lg border border-gray-200 p-4 mb-4" data-inscricao-id="${inscricao.inscricao_id}">
                            <div class="flex flex-col">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">${inscricao.nome_equipe}</h3>
                                        <p class="text-gray-600 text-sm">
                                            Modalidade: ${inscricao.modalidade.charAt(0).toUpperCase() + inscricao.modalidade.slice(1)} • 
                                            Categoria: ${inscricao.categoria}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="status-badge ${getStatusClass(inscricao.status)}">
                                            ${inscricao.status.charAt(0).toUpperCase() + inscricao.status.slice(1)}
                                        </span>
                                        <div class="flex space-x-1">
                                            <button type="button" onclick="atualizarStatusInscricao(${inscricao.inscricao_id}, 'aprovado')" 
                                                    class="btn-action bg-green-100 text-green-700 hover:bg-green-200 px-3 py-2 rounded-md" 
                                                    title="Aprovar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" onclick="atualizarStatusInscricao(${inscricao.inscricao_id}, 'reprovado')" 
                                                    class="btn-action bg-red-100 text-red-700 hover:bg-red-200 px-3 py-2 rounded-md" 
                                                    title="Reprovar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button type="button" onclick="atualizarStatusInscricao(${inscricao.inscricao_id}, 'pendente')" 
                                                    class="btn-action bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-2 rounded-md" 
                                                    title="Pendente">
                                                <i class="fas fa-clock"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="text-sm font-medium text-gray-700">Membros da Equipe</h4>
                                        <span class="text-xs text-gray-500">1 / 12 membros</span>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-gray-800 flex items-center">
                                                    ${inscricao.nome}
                                                    <span class="ml-2 text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Líder</span>
                                                </p>
                                                <p class="text-xs text-gray-500">${inscricao.ano}º ${inscricao.turma} • ${inscricao.email}</p>
                                            </div>
                                            <span class="status-badge ${getStatusClass(inscricao.status)}">
                                                ${inscricao.status.charAt(0).toUpperCase() + inscricao.status.slice(1)}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    } else {
                        // Inscrições individuais mantêm o formato atual
                        return `
                        <div class="card bg-white rounded-lg border border-gray-100 p-6 mb-4" data-inscricao-id="${inscricao.inscricao_id}">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                                <div class="mb-3 md:mb-0">
                                    <h3 class="text-lg font-semibold text-gray-800">${inscricao.nome}</h3>
                                    <p class="text-gray-500 text-sm">
                                        <span class="font-medium">Modalidade:</span> ${inscricao.modalidade.charAt(0).toUpperCase() + inscricao.modalidade.slice(1)}
                                        <span class="mx-2">•</span>
                                        <span class="font-medium">Categoria:</span> ${inscricao.categoria}
                                        <span class="mx-2">•</span>
                                        <span class="font-medium">Tipo:</span> Individual
                                    </p>
                                    <p class="text-gray-500 text-sm">
                                        <span class="font-medium">Turma:</span> ${inscricao.ano}º ${inscricao.turma}
                                        <span class="mx-2">•</span>
                                        <span class="font-medium">Email:</span> ${inscricao.email}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="status-badge ${getStatusClass(inscricao.status)}">
                                        ${inscricao.status.charAt(0).toUpperCase() + inscricao.status.slice(1)}
                                    </span>
                                    <div class="flex space-x-2">
                                        <button type="button" onclick="atualizarStatusInscricao(${inscricao.inscricao_id}, 'aprovado')" 
                                                class="btn-action bg-green-100 text-green-700 hover:bg-green-200 px-3 py-2 rounded-md" 
                                                title="Aprovar Inscrição">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" onclick="atualizarStatusInscricao(${inscricao.inscricao_id}, 'reprovado')" 
                                                class="btn-action bg-red-100 text-red-700 hover:bg-red-200 px-3 py-2 rounded-md" 
                                                title="Reprovar Inscrição">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button type="button" onclick="atualizarStatusInscricao(${inscricao.inscricao_id}, 'pendente')" 
                                                class="btn-action bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-2 rounded-md" 
                                                title="Marcar como Pendente">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    }
                }).join('') || '<p class="text-center text-gray-500 py-8">Nenhuma inscrição encontrada</p>';
            }

            // Função para atualizar contadores
            function atualizarContadores(inscricoes) {
                const total = inscricoes.length;
                const pendentes = inscricoes.filter(i => i.status === 'pendente').length;
                const aprovadas = inscricoes.filter(i => i.status === 'aprovado').length;
                const reprovadas = inscricoes.filter(i => i.status === 'reprovado').length;

                document.getElementById('total-inscricoes').textContent = total;
                document.getElementById('inscricoes-pendentes').textContent = pendentes;
                document.getElementById('inscricoes-aprovadas').textContent = aprovadas;
                document.getElementById('inscricoes-reprovadas').textContent = reprovadas;
            }

            // Função para filtrar inscrições
            function filtrarInscricoes(termo, status = 'todos') {
                const termoLower = termo.toLowerCase();
                const inscricoesFiltradas = inscricoes.filter(inscricao => {
                    const matchTermo = inscricao.nome.toLowerCase().includes(termoLower) ||
                        inscricao.modalidade.toLowerCase().includes(termoLower) ||
                        inscricao.categoria.toLowerCase().includes(termoLower) ||
                        (inscricao.nome_equipe && inscricao.nome_equipe.toLowerCase().includes(termoLower)) ||
                        inscricao.email.toLowerCase().includes(termoLower);
                    
                    const matchStatus = status === 'todos' || inscricao.status === status;
                    
                    return matchTermo && matchStatus;
                });
                renderizarInscricoes(inscricoesFiltradas);
            }

            // Função para atualizar status de uma inscrição
            window.atualizarStatusInscricao = async function(inscricaoId, status) {
                try {
                const formData = new FormData();
                    formData.append('action', 'atualizar-status');
                    formData.append('inscricao_id', inscricaoId);
                formData.append('status', status);
                
                        const response = await fetch('../controllers/AdminController.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                    const data = await response.json();
                        
                        if (data.success) {
                        await carregarInscricoes();
                        Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                    } else {
                            throw new Error(data.message || 'Erro ao atualizar status');
                        }
                    } catch (error) {
                    console.error('Erro:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: error.message || 'Erro ao atualizar status da inscrição'
                    });
                }
            };

            // Função para obter classe CSS do status
            function getStatusClass(status) {
                return {
                    'pendente': 'bg-yellow-100 text-yellow-800',
                    'aprovado': 'bg-green-100 text-green-800',
                    'reprovado': 'bg-red-100 text-red-800'
                }[status] || 'bg-gray-100 text-gray-800';
            }

            // Event Listeners
            searchInput.addEventListener('input', (e) => filtrarInscricoes(e.target.value, statusFilter.value));
            statusFilter.addEventListener('change', (e) => filtrarInscricoes(searchInput.value, e.target.value));
            refreshBtn.addEventListener('click', () => {
                searchInput.value = '';
                statusFilter.value = 'todos';
                carregarInscricoes();
            });

            // Carregar inscrições inicialmente
            carregarInscricoes();
        });
    </script>
</body>
</html>