<?php
// Iniciar sessão
session_start();

// Verificar se o admin está logado
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        green: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .card {
            @apply bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 transition-all duration-200;
        }
        .card:hover {
            @apply shadow-md border-green-100;
        }
        .status-badge {
            @apply px-2 py-1 rounded-full text-xs font-medium;
        }
        .status-pendente {
            @apply bg-yellow-100 text-yellow-800;
        }
        .status-aprovado {
            @apply bg-green-100 text-green-800;
        }
        .status-reprovado {
            @apply bg-red-100 text-red-800;
        }
        .btn-primary {
            @apply bg-green-600 hover:bg-green-700 text-white px-3 py-1 sm:px-4 sm:py-2 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm;
        }
        .btn-secondary {
            @apply bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 sm:px-4 sm:py-2 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm;
        }
        .btn-danger {
            @apply bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 sm:px-4 sm:py-2 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm;
        }
        .btn-action {
            @apply px-2 py-1 rounded-md text-xs sm:text-sm transition-colors duration-200 flex items-center justify-center;
        }
        .btn-aprovar {
            @apply bg-green-100 text-green-700 hover:bg-green-200;
        }
        .btn-reprovar {
            @apply bg-red-100 text-red-700 hover:bg-red-200;
        }
        .btn-pendente {
            @apply bg-yellow-100 text-yellow-700 hover:bg-yellow-200;
        }
        .table-row {
            @apply hover:bg-green-50 transition-colors duration-200;
        }
        .truncate-text {
            @apply truncate max-w-[100px] sm:max-w-[150px] lg:max-w-[200px];
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div class="flex items-center space-x-3">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Design%20sem%20nome-MOpK2hbpuoqfoF8sir0Ue6SvciAArc.svg" alt="Logo" class="h-8 w-8">
                    <div>
                        <h1 class="font-bold text-gray-900">Copa Grêmio</h1>
                        <p class="text-xs text-gray-500">Painel Administrativo</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4 w-full sm:w-auto">
                   
                    
                    <a href="../controllers/AdminController.php?action=logout" class="btn-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500">Bem-vindo ao painel administrativo da Copa Grêmio 2025</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="card">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total de Alunos</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="total-alunos">0</h3>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Pendentes</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="total-pendentes">0</h3>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Aprovadas</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="total-aprovadas">0</h3>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Reprovadas</p>
                        <h3 class="text-2xl font-bold text-gray-800" id="total-reprovadas">0</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Inscrições Table -->
        <div class="card mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-list-alt mr-2 text-green-600"></i> Gerenciar Inscrições
                </h2>
                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                    <div class="relative w-full sm:w-auto">
                        <input type="text" id="search" placeholder="Buscar aluno..." class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <button id="refresh-btn" class="btn-primary w-full sm:w-auto">
                        <i class="fas fa-sync-alt mr-1"></i> Atualizar
                    </button>
                </div>
            </div>
            
            <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                        
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                          
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                       
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tabela-inscricoes">
                        <!-- Preenchido via JavaScript -->
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                <div class="flex justify-center items-center">
                                    <i class="fas fa-spinner fa-spin mr-2 text-green-600"></i> Carregando inscrições...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-4 mt-6">
        <div class="container mx-auto px-4">
            <div class="text-center text-sm text-gray-500">
                <p>&copy; 2025 Grêmio Estudantil José Ivan Pontes Júnior</p>
                <p>EEEP Salaberga Torquato Gomes de Matos</p>
                <p class="mt-1">Desenvolvido por <span class="font-medium text-green-600">Matheus Felix</span></p>
            </div>
        </div>
    </footer>

    <!-- Modal Detalhes da Inscrição -->
    <div id="modal-detalhes" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg sm:max-w-3xl mx-4 max-h-[90vh]">
            <div class="p-4 sm:p-5">
                <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-3">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">Detalhes da Inscrição</h3>
                    <button class="modal-close text-gray-400 hover:text-gray-600 text-lg sm:text-xl p-2">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div id="detalhes-inscricao" class="space-y-4">
                    <!-- Preenchido via JavaScript -->
                    <div class="flex justify-center items-center py-6">
                        <i class="fas fa-spinner fa-spin mr-2 text-green-600"></i> Carregando detalhes...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal
            const modalDetalhes = document.getElementById('modal-detalhes');
            const modalClose = document.querySelector('.modal-close');
            
            modalClose.addEventListener('click', function() {
                fecharModal();
            });
            
            window.addEventListener('click', function(e) {
                if (e.target === modalDetalhes) {
                    fecharModal();
                }
            });
            
            function fecharModal() {
                modalDetalhes.classList.add('hidden');
            }
            
            // Tabela de inscrições
            const tabelaInscricoes = document.getElementById('tabela-inscricoes');
            const searchInput = document.getElementById('search');
            const refreshBtn = document.getElementById('refresh-btn');
            const detalhesInscricao = document.getElementById('detalhes-inscricao');
            
            // Estatísticas
            const totalAlunos = document.getElementById('total-alunos');
            const totalPendentes = document.getElementById('total-pendentes');
            const totalAprovadas = document.getElementById('total-aprovadas');
            const totalReprovadas = document.getElementById('total-reprovadas');
            
            // Carregar inscrições
            function carregarInscricoes() {
                fetch('../controllers/AdminController.php?action=listar-inscricoes')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            renderizarInscricoes(data.inscricoes);
                            atualizarEstatisticas(data.inscricoes);
                        } else {
                            tabelaInscricoes.innerHTML = `<tr><td colspan="7" class="px-4 py-4 text-center text-red-500">Erro ao carregar inscrições: ${data.message}</td></tr>`;
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao carregar inscrições:', error);
                        tabelaInscricoes.innerHTML = `<tr><td colspan="7" class="px-4 py-4 text-center text-red-500">Erro ao carregar inscrições. Tente novamente.</td></tr>`;
                    });
            }
            
            // Renderizar inscrições na tabela
            function renderizarInscricoes(inscricoes) {
                if (inscricoes.length === 0) {
                    tabelaInscricoes.innerHTML = `<tr><td colspan="7" class="px-4 py-4 text-center text-gray-500">Nenhuma inscrição encontrada.</td></tr>`;
                    return;
                }
                
                let html = '';
                
                inscricoes.forEach(inscricao => {
                    const data = new Date(inscricao.data_inscricao);
                    const dataFormatada = `${data.getDate().toString().padStart(2, '0')}/${(data.getMonth()+1).toString().padStart(2, '0')}/${data.getFullYear()}`;
                    
                    let statusStyle = '';
                    let statusText = '';
                    
                    if (inscricao.pendentes > 0) {
                        statusStyle = 'status-pendente';
                        statusText = 'Pendente';
                    } else if (inscricao.reprovadas > 0) {
                        statusStyle = 'status-reprovado';
                        statusText = 'Reprovada';
                    } else {
                        statusStyle = 'status-aprovado';
                        statusText = 'Aprovada';
                    }
                    
                    html += `
                        <tr class="table-row" data-id="${inscricao.id}">
                          
                            <td class="px-4 py-3 text-sm text-gray-500 truncate-text" title="${inscricao.nome}">${inscricao.nome}</td>
                       
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${dataFormatada}</td>
                      
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="status-badge ${statusStyle}">${statusText}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <button class="btn-detalhes text-green-600 hover:text-green-800 mr-2" data-id="${inscricao.id}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                tabelaInscricoes.innerHTML = html;
                
                // Adicionar event listeners para os botões de detalhes
                document.querySelectorAll('.btn-detalhes').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        abrirDetalhes(id);
                    });
                });
            }
            
            // Filtrar inscrições
            searchInput.addEventListener('input', function() {
                const termo = this.value.toLowerCase();
                const linhas = document.querySelectorAll('#tabela-inscricoes tr');
                
                linhas.forEach(linha => {
                    const id = linha.querySelector('td:nth-child(1)')?.textContent.toLowerCase() || '';
                    const nome = linha.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                    const turma = linha.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                    
                    if (id.includes(termo) || nome.includes(termo) || turma.includes(termo)) {
                        linha.style.display = '';
                    } else {
                        linha.style.display = 'none';
                    }
                });
            });
            
            // Abrir modal de detalhes
            function abrirDetalhes(id) {
                modalDetalhes.classList.remove('hidden');
                
                detalhesInscricao.innerHTML = `
                    <div class="flex justify-center items-center py-6">
                        <i class="fas fa-spinner fa-spin mr-2 text-green-600"></i> Carregando detalhes...
                    </div>
                `;
                
                fetch(`../controllers/AdminController.php?action=obter-inscricao&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            renderizarDetalhes(data.aluno, data.inscricoes);
                        } else {
                            detalhesInscricao.innerHTML = `
                                <div class="p-3 bg-red-100 text-red-700 rounded-lg">
                                    <p>${data.message}</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao carregar detalhes:', error);
                        detalhesInscricao.innerHTML = `
                            <div class="p-3 bg-red-100 text-red-700 rounded-lg">
                                <p>Erro ao carregar detalhes. Tente novamente.</p>
                            </div>
                        `;
                    });
            }
            
            // Renderizar detalhes
            function renderizarDetalhes(aluno, inscricoes) {
                const data = new Date(aluno.data_inscricao);
                const dataFormatada = `${data.getDate().toString().padStart(2, '0')}/${(data.getMonth()+1).toString().padStart(2, '0')}/${data.getFullYear()} às ${data.getHours().toString().padStart(2, '0')}:${data.getMinutes().toString().padStart(2, '0')}`;
                
                let html = `
                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-5 mb-4">
                        <div class="card flex-1">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-user-circle mr-2 text-green-600"></i> Dados do Aluno
                            </h3>
                            <ul class="space-y-2 text-sm">
                                <li class="flex flex-col">
                                    <span class="text-gray-500 mb-1">Nome:</span>
                                    <span class="font-medium truncate-text" title="${aluno.nome}">${aluno.nome}</span>
                                </li>
                                <li class="flex flex-col">
                                    <span class="text-gray-500 mb-1">Turma:</span>
                                    <span class="font-medium">${aluno.ano}º ${aluno.turma}</span>
                                </li>
                                <li class="flex flex-col">
                                    <span class="text-gray-500 mb-1">E-mail:</span>
                                    <span class="font-medium truncate-text" title="${aluno.email}">${aluno.email}</span>
                                </li>
                                <li class="flex flex-col">
                                    <span class="text-gray-500 mb-1">Telefone:</span>
                                    <span class="font-medium">${aluno.telefone}</span>
                                </li>
                                <li class="flex flex-col">
                                    <span class="text-gray-500 mb-1">Data:</span>
                                    <span class="font-medium">${dataFormatada}</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="card flex-1">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-trophy mr-2 text-green-600"></i> Resumo
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-500 mb-2">Total de modalidades: ${inscricoes.length}</p>
                            <div class="bg-green-50 p-3 rounded-lg">
                                <div class="flex justify-between items-center text-xs sm:text-sm">
                                    <div>
                                        <p class="text-gray-700">Valor por modalidade:</p>
                                        <p class="text-xs text-gray-500">${inscricoes.length >= 3 ? 'Desconto (3+)' : 'Padrão'}</p>
                                    </div>
                                    <p class="text-gray-700">R$ ${inscricoes.length >= 3 ? '3,00' : '5,00'}</p>
                                </div>
                                <div class="border-t border-green-100 my-2"></div>
                                <div class="flex justify-between items-center">
                                    <p class="font-medium text-sm">Total:</p>
                                    <p class="font-bold text-base sm:text-lg text-green-700">R$ ${(inscricoes.length >= 3 ? 3.00 : 5.00) * inscricoes.length},00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-list-alt mr-2 text-green-600"></i> Modalidades Inscritas
                        </h3>
                        <div class="min-w-full">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Modalidade</th>
                                        <th scope="col" class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Categoria</th>
                                        <th scope="col" class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Equipe</th>
                                        <th scope="col" class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th scope="col" class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                `;
                
                inscricoes.forEach(inscricao => {
                    const modalidade = inscricao.modalidade.replace(/-/g, ' ');
                    let statusClass = '';
                    let statusText = '';
                    
                    switch(inscricao.status) {
                        case 'pendente':
                            statusClass = 'status-pendente';
                            statusText = 'Pendente';
                            break;
                        case 'aprovado':
                            statusClass = 'status-aprovado';
                            statusText = 'Aprovada';
                            break;
                        case 'reprovado':
                            statusClass = 'status-reprovado';
                            statusText = 'Reprovada';
                            break;
                    }
                    
                    html += `
                        <tr class="table-row">
                            <td class="px-2 sm:px-4 py-2 text-xs sm:text-sm font-medium text-gray-900 capitalize truncate-text" title="${modalidade}">${modalidade}</td>
                            <td class="px-2 sm:px-4 py-2 text-xs sm:text-sm text-gray-500 capitalize">${inscricao.categoria}</td>
                            <td class="px-2 sm:px-4 py-2 text-xs sm:text-sm text-gray-500 truncate-text" title="${inscricao.nome_equipe || '-'}">${inscricao.nome_equipe || '-'}</td>
                            <td class="px-2 sm:px-4 py-2 whitespace-nowrap">
                                <span class="status-badge ${statusClass}">${statusText}</span>
                            </td>
                            <td class="px-2 sm:px-4 py-2 whitespace-nowrap flex space-x-1 sm:space-x-2">
                                <button class="btn-action btn-aprovar" data-inscricao-id="${inscricao.id}" title="Aprovar">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </button>
                                <button class="btn-action btn-reprovar" data-inscricao-id="${inscricao.id}" title="Reprovar">
                                    <i class="fas fa-times-circle text-red-500"></i>
                                </button>
                                <button class="btn-action btn-pendente" data-inscricao-id="${inscricao.id}" title="Pendente">
                                    <i class="fas fa-clock text-yellow-500"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                html += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="feedback-message" class="hidden p-3 my-2 rounded-lg text-sm"></div>
                `;
                
                detalhesInscricao.innerHTML = html;
                
                // Adicionar event listeners para aprovar/reprovar/pendente
                document.querySelectorAll('.btn-aprovar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-inscricao-id');
                        atualizarStatusInscricao(id, 'aprovado');
                    });
                });
                
                document.querySelectorAll('.btn-reprovar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-inscricao-id');
                        atualizarStatusInscricao(id, 'reprovado');
                    });
                });
                
                document.querySelectorAll('.btn-pendente').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-inscricao-id');
                        atualizarStatusInscricao(id, 'pendente');
                    });
                });
            }
            
            // Atualizar status de inscrição
            function atualizarStatusInscricao(inscricaoId, status) {
                const feedback = document.getElementById('feedback-message');
                feedback.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
                feedback.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Atualizando...';
                feedback.classList.add('bg-blue-100', 'text-blue-700');
                
                const formData = new FormData();
                formData.append('inscricao_id', inscricaoId);
                formData.append('status', status);
                
                fetch('../controllers/AdminController.php?action=atualizar-status', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    feedback.classList.remove('bg-blue-100', 'text-blue-700');
                    
                    if (data.success) {
                        feedback.classList.add('bg-green-100', 'text-green-700');
                        feedback.innerHTML = `<i class="fas fa-check-circle mr-2"></i> ${data.message}`;
                        
                        // Atualizar status visualmente
                        const statusBadge = document.querySelector(`.btn-aprovar[data-inscricao-id="${inscricaoId}"]`)
                            .closest('tr')
                            .querySelector('.status-badge');
                        
                        statusBadge.classList.remove('status-pendente', 'status-aprovado', 'status-reprovado');
                        
                        let statusClass, statusText;
                        switch(status) {
                            case 'pendente':
                                statusClass = 'status-pendente';
                                statusText = 'Pendente';
                                break;
                            case 'aprovado':
                                statusClass = 'status-aprovado';
                                statusText = 'Aprovada';
                                break;
                            case 'reprovado':
                                statusClass = 'status-reprovado';
                                statusText = 'Reprovada';
                                break;
                        }
                        
                        statusBadge.classList.add(statusClass);
                        statusBadge.textContent = statusText;
                        
                        // Recarregar lista após 2 segundos
                        setTimeout(() => {
                            carregarInscricoes();
                        }, 2000);
                        
                    } else {
                        feedback.classList.add('bg-red-100', 'text-red-700');
                        feedback.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i> ${data.message}`;
                    }
                    
                    // Esconder feedback após 3 segundos
                    setTimeout(() => {
                        feedback.classList.add('hidden');
                    }, 3000);
                })
                .catch(error => {
                    console.error('Erro ao atualizar status:', error);
                    feedback.classList.remove('bg-blue-100', 'text-blue-700');
                    feedback.classList.add('bg-red-100', 'text-red-700');
                    feedback.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i> Erro ao processar a solicitação. Tente novamente.';
                    
                    // Esconder feedback após 3 segundos
                    setTimeout(() => {
                        feedback.classList.add('hidden');
                    }, 3000);
                });
            }
            
            // Atualizar estatísticas
            function atualizarEstatisticas(inscricoes) {
                let pendentes = 0;
                let aprovadas = 0;
                let reprovadas = 0;
                
                inscricoes.forEach(inscricao => {
                    pendentes += parseInt(inscricao.pendentes) || 0;
                    aprovadas += parseInt(inscricao.aprovadas) || 0;
                    reprovadas += parseInt(inscricao.reprovadas) || 0;
                });
                
                totalAlunos.textContent = inscricoes.length;
                totalPendentes.textContent = pendentes;
                totalAprovadas.textContent = aprovadas;
                totalReprovadas.textContent = reprovadas;
            }
            
            // Event listener para botão de atualizar
            refreshBtn.addEventListener('click', function() {
                carregarInscricoes();
            });
            
            // Carregar inscrições ao carregar a página
            carregarInscricoes();
        });
    </script>
</body>
</html>