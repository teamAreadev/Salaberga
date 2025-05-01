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
    <title>Dashboard Admin - Copa Grêmio 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600">Bem-vindo ao painel administrativo</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stats-grid">
            <div class="card bg-white rounded-xl p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg mr-4 text-green-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total de Equipes</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="total-equipes">0</h3>
                    </div>
                </div>
            </div>
            
            <div class="card bg-white rounded-xl p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-lg mr-4 text-yellow-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Equipes Pendentes</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="equipes-pendentes">0</h3>
                    </div>
                </div>
            </div>
            
            <div class="card bg-white rounded-xl p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg mr-4 text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Equipes Aprovadas</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="equipes-aprovadas">0</h3>
                    </div>
                </div>
            </div>
            
            <div class="card bg-white rounded-xl p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded-lg mr-4 text-red-600">
                        <i class="fas fa-times-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Equipes Reprovadas</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="equipes-reprovadas">0</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Equipes Section -->
        <div class="card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-users mr-3 text-green-600"></i> 
                            Gerenciar Equipes
                </h2>
                        <p class="text-gray-500 text-sm mt-1">Gerencie todas as inscrições de equipes</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative">
                            <input type="text" id="search" placeholder="Buscar equipe..." 
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
            
            <div id="equipes-container" class="p-6">
                <div class="flex justify-center items-center py-12">
                    <i class="fas fa-spinner fa-spin mr-3 text-green-600 text-xl"></i>
                    <span class="text-gray-500">Carregando equipes...</span>
                                </div>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>© 2025 Copa Grêmio - Grêmio Estudantil José Ivan Pontes Júnior</p>
            <p class="text-gray-400 text-sm mt-1">Todos os direitos reservados</p>
        </div>
    </footer>

    <!-- Modal -->
    <div id="modal-detalhes" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0">
            <div class="p-6">
                <div class="flex justify-between items-center pb-4 mb-4 border-b">
                    <h3 class="text-xl font-bold text-gray-800">Detalhes da Inscrição</h3>
                    <button class="modal-close text-gray-400 hover:text-gray-600 p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div id="detalhes-inscricao">
                    <div class="flex justify-center items-center py-12">
                        <i class="fas fa-spinner fa-spin mr-3 text-green-600 text-xl"></i>
                        <span class="text-gray-500">Carregando detalhes...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Todo o JavaScript original permanece EXATAMENTE o mesmo
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const refreshBtn = document.getElementById('refresh-btn');
            const equipesContainer = document.getElementById('equipes-container');
            
            let equipes = [];
            
            // Função para carregar equipes
            async function carregarEquipes() {
                try {
                    const response = await fetch('../controllers/AdminController.php?action=listar-equipes');
                    if (!response.ok) {
                        throw new Error('Erro ao carregar equipes: ' + response.status);
                    }
                    
                    const responseText = await response.text();
                    try {
                        const data = JSON.parse(responseText);
                        
                        if (data.success) {
                            equipes = data.equipes;
                            atualizarContadores(equipes);
                            renderizarEquipes(equipes);
                        } else {
                            throw new Error(data.message || 'Erro ao carregar equipes');
                        }
                    } catch (e) {
                        console.error('Resposta inválida:', responseText);
                        throw new Error('Erro ao processar resposta do servidor');
                    }
                } catch (error) {
                    console.error('Erro ao carregar equipes:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: error.message,
                        confirmButtonText: 'Tentar Novamente'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            carregarEquipes();
                        }
                    });
                }
            }
            
            // Função para atualizar contadores
            function atualizarContadores(equipes) {
                const totalEquipes = equipes.length;
                const equipesPendentes = equipes.filter(e => e.status_equipe === 'pendente').length;
                const equipesAprovadas = equipes.filter(e => e.status_equipe === 'aprovado').length;
                const equipesReprovadas = equipes.filter(e => e.status_equipe === 'reprovado').length;
                
                document.getElementById('total-equipes').textContent = totalEquipes;
                document.getElementById('equipes-pendentes').textContent = equipesPendentes;
                document.getElementById('equipes-aprovadas').textContent = equipesAprovadas;
                document.getElementById('equipes-reprovadas').textContent = equipesReprovadas;
            }
            
            // Função para renderizar equipes
            function renderizarEquipes(equipes) {
                equipesContainer.innerHTML = equipes.map(equipe => `
                    <div class="card bg-white rounded-lg border border-gray-100 p-6 mb-4 " data-equipe-id="${equipe.id}">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                            <div class="mb-3 md:mb-0">
                                <h3 class="text-lg font-semibold text-gray-800">${equipe.nome}</h3>
                                <p class="text-gray-500 text-sm">
                                    <span class="font-medium">Modalidade:</span> ${equipe.modalidade.charAt(0).toUpperCase() + equipe.modalidade.slice(1)}
                                    <span class="mx-2">•</span>
                                    <span class="font-medium">Categoria:</span> ${equipe.categoria}
                                </p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="status-badge ${getStatusClass(equipe.status_equipe)}">
                                    ${equipe.status_equipe.charAt(0).toUpperCase() + equipe.status_equipe.slice(1)}
                                </span>
                                <div class="flex space-x-2">
                                    <button type="button" onclick="window.atualizarStatusEquipe(${equipe.id}, 'aprovado')" class="btn-action bg-green-100 text-green-700 hover:bg-green-200 px-3 py-2 rounded-md" title="Aprovar Equipe">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" onclick="window.atualizarStatusEquipe(${equipe.id}, 'reprovado')" class="btn-action bg-red-100 text-red-700 hover:bg-red-200 px-3 py-2 rounded-md" title="Reprovar Equipe">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button type="button" onclick="window.atualizarStatusEquipe(${equipe.id}, 'pendente')" class="btn-action bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-2 rounded-md" title="Marcar como Pendente">
                                        <i class="fas fa-clock"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t pt-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-medium text-gray-700">Membros da Equipe</h4>
                                <span class="text-sm text-gray-500">${equipe.total_membros} / ${equipe.limite_membros} membros</span>
                            </div>
                            <div class="space-y-3">
                                ${equipe.membros.map(membro => `
                                    <div class="flex justify-between items-center py-2 px-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-gray-800">
                                                ${membro.nome}
                                                ${membro.is_lider ? '<span class="ml-2 text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Líder</span>' : ''}
                                            </p>
                                            <p class="text-sm text-gray-500">${membro.ano}º ${membro.turma} • ${membro.email}</p>
                                        </div>
                                        <span class="status-badge ${getStatusClass(membro.status || 'pendente')}">
                                            ${(membro.status || 'pendente').charAt(0).toUpperCase() + (membro.status || 'pendente').slice(1)}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `).join('') || '<p class="text-center text-gray-500 py-8">Nenhuma equipe encontrada</p>';
                
                function getStatusClass(status) {
                    return {
                        'pendente': 'bg-yellow-100 text-yellow-800',
                        'aprovado': 'bg-green-100 text-green-800',
                        'reprovado': 'bg-red-100 text-red-800'
                    }[status] || 'bg-gray-100 text-gray-800';
                }
            }
            
            // Função para filtrar equipes
            function filtrarEquipes(termo, status = 'todos') {
                const termoLower = termo.toLowerCase();
                const equipeFiltradas = equipes.filter(equipe => {
                    const matchTermo = equipe.nome.toLowerCase().includes(termoLower) ||
                        equipe.modalidade.toLowerCase().includes(termoLower) ||
                        equipe.categoria.toLowerCase().includes(termoLower) ||
                        equipe.membros.some(membro => 
                            membro.nome.toLowerCase().includes(termoLower) ||
                            membro.email.toLowerCase().includes(termoLower)
                        );
                    
                    const matchStatus = status === 'todos' || equipe.status_equipe === status;
                    
                    return matchTermo && matchStatus;
                });
                renderizarEquipes(equipeFiltradas);
            }
            
            // Event Listeners
            const statusFilter = document.getElementById('status-filter');
            searchInput.addEventListener('input', (e) => filtrarEquipes(e.target.value, statusFilter.value));
            statusFilter.addEventListener('change', (e) => filtrarEquipes(searchInput.value, e.target.value));
            refreshBtn.addEventListener('click', () => {
                // Resetar filtros
                searchInput.value = '';
                statusFilter.value = 'todos';
                carregarEquipes();
            });
            
            // Função global para atualizar status
            window.atualizarStatusEquipe = async function(equipeId, status) {
                try {
                    console.log('=== Início atualizarStatusEquipe ===');
                    console.log('Parâmetros:', { equipeId, status });
                    
                    // Desabilitar os botões da equipe durante o processamento
                    const equipeElement = document.querySelector(`[data-equipe-id="${equipeId}"]`);
                    if (equipeElement) {
                        const botoes = equipeElement.querySelectorAll('button');
                        botoes.forEach(btn => btn.disabled = true);
                    }
                    
                    // Mostrar loading
                    const loadingAlert = Swal.fire({
                        title: 'Processando...',
                        text: 'Atualizando status da equipe',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                
                const formData = new FormData();
                    formData.append('action', 'atualizar-status-equipe');
                    formData.append('equipe_id', equipeId);
                formData.append('status', status);
                
                    console.log('Enviando requisição para:', '../controllers/AdminController.php');
                    
                    try {
                        const response = await fetch('../controllers/AdminController.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                        console.log('Status da resposta:', response.status);
                        
                        // Log da resposta bruta para debug
                        const responseText = await response.text();
                        console.log('Resposta bruta do servidor:', responseText);
                        
                        let data;
                        try {
                            data = JSON.parse(responseText);
                            console.log('Resposta processada:', data);
                        } catch (e) {
                            throw new Error('Resposta inválida do servidor: ' + responseText);
                        }
                        
                        if (data.success) {
                            console.log('Operação realizada com sucesso:', data.message);
                            
                            // Fechar o loading antes de recarregar
                            await loadingAlert.close();
                            
                            // Recarregar os dados
                            await carregarEquipes();
                            
                            // Mostrar mensagem de sucesso
                            await Swal.fire({
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
                        throw error;
                    } finally {
                        // Reabilitar os botões
                        if (equipeElement) {
                            const botoes = equipeElement.querySelectorAll('button');
                            botoes.forEach(btn => btn.disabled = false);
                        }
                    }
                    
                    console.log('=== Fim atualizarStatusEquipe ===');
                } catch (error) {
                    console.error('Erro ao atualizar status:', error);
                    console.error('Stack trace:', error.stack);
                    
                    // Fechar o loading se estiver aberto
                    Swal.close();
                    
                    // Mostrar erro
                    await Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: error.message || 'Erro ao atualizar status da equipe',
                        confirmButtonText: 'OK'
                    });
                    
                    // Recarregar os dados para garantir consistência
                    await carregarEquipes();
                }
            };
            
            // Carregar equipes inicialmente
            carregarEquipes();
        });
    </script>
</body>
</html>