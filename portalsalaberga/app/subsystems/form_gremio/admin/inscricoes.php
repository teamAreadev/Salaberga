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
        
        /* Estilo personalizado para os botões do SweetAlert */
        .swal2-popup .swal2-actions {
            gap: 1.5rem !important;
            padding: 1rem 0 !important;
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
                        <div class="relative">
                            <select id="modalidade-filter" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none bg-white pr-10">
                                <option value="todas">Todas as modalidades</option>
                                <option value="futsal">Futsal</option>
                                <option value="volei">Vôlei</option>
                                <option value="basquete">Basquete</option>
                                <option value="handebol">Handebol</option>
                                <option value="queimada">Queimada</option>
                                <option value="futmesa">Futmesa</option>
                                <option value="teqball">Teqball</option>
                                <option value="teqvolei">Teqvôlei</option>
                                <option value="tenis_de_mesa">Tênis de Mesa</option>
                                <option value="dama">Dama</option>
                                <option value="xadrez">Xadrez</option>
                                <option value="x2">X2</option>
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
            const modalidadeFilter = document.getElementById('modalidade-filter');
            let inscricoes = [];

            // Função para carregar todas as inscrições
            async function carregarInscricoes() {
                try {
                    const response = await fetch('../controllers/AdminController.php?action=listar-inscricoes');
                    const data = await response.json();
                        
                    if (data.success) {
                        inscricoes = data.inscricoes;
                        filtrarInscricoes();
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
                // Agrupamento de inscrições coletivas por equipe
                const equipes = {};
                const individuais = [];
                inscricoes.forEach(inscricao => {
                    if (inscricao.tipo_inscricao === 'coletiva') {
                        const chave = `${inscricao.nome_equipe}|${inscricao.modalidade}|${inscricao.categoria}`;
                        if (!equipes[chave]) {
                            equipes[chave] = {
                                nome_equipe: inscricao.nome_equipe,
                                modalidade: inscricao.modalidade,
                                categoria: inscricao.categoria,
                                status: inscricao.status,
                                membros: [],
                                is_lider: false,
                                equipe_id: inscricao.equipe_id || null,
                                inscricao_id_lider: null
                            };
                        }
                        equipes[chave].membros.push(inscricao);
                        if (inscricao.is_lider) {
                            equipes[chave].is_lider = true;
                            equipes[chave].inscricao_id_lider = inscricao.inscricao_id;
                        }
                    } else {
                        individuais.push(inscricao);
                    }
                });

                // Renderizar equipes coletivas
                let html = Object.values(equipes).map(equipe => {
                    return `
                    <div class="card bg-white rounded-lg border border-gray-200 p-4 mb-4">
                        <div class="flex flex-col">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">${equipe.nome_equipe}</h3>
                                    <p class="text-gray-600 text-sm">
                                        Modalidade: ${equipe.modalidade.charAt(0).toUpperCase() + equipe.modalidade.slice(1)} • 
                                        Categoria: ${equipe.categoria}
                                    </p>
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="status-badge inline-block whitespace-nowrap ${getStatusClass(equipe.status)}">
                                        ${equipe.status.charAt(0).toUpperCase() + equipe.status.slice(1)}
                                    </span>
                                    <div class="flex flex-wrap gap-1">
                                        ${equipe.is_lider && equipe.inscricao_id_lider ? `
                                        <button type="button" onclick="atualizarStatusInscricao(${equipe.inscricao_id_lider}, 'aprovado')" 
                                                class="btn-action bg-green-100 text-green-700 hover:bg-green-200 px-3 py-2 rounded-md" 
                                                title="Aprovar">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" onclick="atualizarStatusInscricao(${equipe.inscricao_id_lider}, 'reprovado')" 
                                                class="btn-action bg-red-100 text-red-700 hover:bg-red-200 px-3 py-2 rounded-md" 
                                                title="Reprovar">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button type="button" onclick="atualizarStatusInscricao(${equipe.inscricao_id_lider}, 'pendente')" 
                                                class="btn-action bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-2 rounded-md" 
                                                title="Pendente">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                        <button type="button" onclick="excluirInscricao(${equipe.inscricao_id_lider})" 
                                                class="btn-action bg-red-200 text-red-800 hover:bg-red-300 px-3 py-2 rounded-md" 
                                                title="Excluir Inscrição">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-sm font-medium text-gray-700">Membros da Equipe</h4>
                                    <span class="text-xs text-gray-500">${equipe.membros.length} / 12 membros</span>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    ${equipe.membros.map(membro => `
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-2">
                                            <div>
                                                <p class="font-medium text-gray-800 flex items-center gap-2">
                                                    ${membro.nome}
                                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">${membro.is_lider ? 'Líder' : 'Membro'}</span>
                                                    ${membro.is_lider ? `<button type="button" onclick="enviarMensagem('${membro.telefone}')" class="ml-2 text-green-600 hover:text-green-800" title="Enviar WhatsApp"><i class="fab fa-whatsapp"></i></button>` : ''}
                                                </p>
                                                <p class="text-xs text-gray-500">${membro.ano}º ${membro.turma} • ${membro.email}</p>
                                            </div>
                                            <span class="status-badge inline-block whitespace-nowrap ${getStatusClass(membro.status)}">
                                                ${membro.status.charAt(0).toUpperCase() + membro.status.slice(1)}
                                            </span>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    </div>`;
                }).join('');

                // Renderizar inscrições individuais
                html += individuais.map(inscricao => {
                    return `
                    <div class="card bg-white rounded-lg border border-gray-100 p-4 mb-4" data-inscricao-id="${inscricao.inscricao_id}">
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">${inscricao.nome}
                                        <button type="button" onclick="enviarMensagem('${inscricao.telefone}')" class="ml-2 text-green-600 hover:text-green-800" title="Enviar WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                    </h3>
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
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="status-badge inline-block whitespace-nowrap ${getStatusClass(inscricao.status)}">
                                        ${inscricao.status.charAt(0).toUpperCase() + inscricao.status.slice(1)}
                                    </span>
                                    <div class="flex flex-wrap gap-1">
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
                                        <button type="button" onclick="excluirInscricao(${inscricao.inscricao_id})" 
                                                class="btn-action bg-red-200 text-red-800 hover:bg-red-300 px-3 py-2 rounded-md" 
                                                title="Excluir Inscrição">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }).join('');

                inscricoesContainer.innerHTML = html || '<p class="text-center text-gray-500 py-8">Nenhuma inscrição encontrada</p>';
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
            function filtrarInscricoes() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const modalidadeValue = modalidadeFilter.value;

                const inscricoesFiltradas = inscricoes.filter(inscricao => {
                    const matchSearch = inscricao.nome.toLowerCase().includes(searchTerm) ||
                                      inscricao.nome_equipe?.toLowerCase().includes(searchTerm);
                    const matchStatus = statusValue === 'todos' || inscricao.status === statusValue;
                    const matchModalidade = modalidadeValue === 'todas' || inscricao.modalidade === modalidadeValue;

                    return matchSearch && matchStatus && matchModalidade;
                });

                renderizarInscricoes(inscricoesFiltradas);
                atualizarContadores(inscricoesFiltradas);
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
                    'pendente': 'bg-yellow-100 text-yellow-800 px-2 py-1 text-xs rounded-full',
                    'aprovado': 'bg-green-100 text-green-800 px-2 py-1 text-xs rounded-full',
                    'reprovado': 'bg-red-100 text-red-800 px-2 py-1 text-xs rounded-full'
                }[status] || 'bg-gray-100 text-gray-800 px-2 py-1 text-xs rounded-full';
            }

            // Função para enviar mensagem via WhatsApp
            window.enviarMensagem = function(telefone) {
                if (!telefone) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Número de telefone não disponível'
                    });
                    return;
                }
                
                // Remove caracteres não numéricos do telefone
                const numeroLimpo = telefone.replace(/\D/g, '');
                
                // Adiciona o código do país se não estiver presente
                const numeroCompleto = numeroLimpo.startsWith('55') ? numeroLimpo : '55' + numeroLimpo;
                
                const url = `https://wa.me/${numeroCompleto}`;
                window.open(url, '_blank');
            };

            // Função para excluir inscrição
            window.excluirInscricao = function(inscricaoId) {
                // Buscar o nome do inscrito/equipe no DOM
                const card = document.querySelector(`[data-inscricao-id='${inscricaoId}']`);
                let nome = '';
                if (card) {
                    const nomeEl = card.querySelector('h3');
                    if (nomeEl) nome = nomeEl.textContent.trim();
                }
                Swal.fire({
                    title: 'Confirmar Exclusão',
                    html: `
                        <div class="text-center">
                            <i class="fas fa-exclamation-circle text-red-500 text-4xl mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Excluir inscrição de <span class="text-gray-800">${nome}</span>?</h3>
                            <p class="text-sm text-gray-500 mb-4">Esta ação é <span class="font-semibold text-red-600">irreversível</span> e removerá permanentemente a inscrição.</p>
                        </div>
                    `,
                    icon: null,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-trash mr-2"></i>Excluir',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancelar',
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#4b5563',
                    focusCancel: true,
                    buttonsStyling: false,
                    customClass: {
                        popup: 'rounded-xl shadow-2xl p-6 max-w-md',
                        title: 'text-xl font-bold text-gray-800 mb-4',
                        htmlContainer: 'text-gray-600',
                        confirmButton: 'bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center',
                        cancelButton: 'bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200 flex items-center',
                        actions: 'mt-4 flex justify-end gap-4' // Aumentei o gap aqui para mais espaço
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp animate__faster'
                    }
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const formData = new FormData();
                            formData.append('action', 'excluir-inscricao');
                            formData.append('inscricao_id', inscricaoId);
                            const response = await fetch('../controllers/AdminController.php', {
                                method: 'POST',
                                body: formData
                            });
                            const data = await response.json();
                            if (data.success) {
                                await carregarInscricoes();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Excluída!',
                                    text: 'A inscrição foi excluída com sucesso.',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'rounded-xl shadow-2xl',
                                        title: 'text-xl font-bold text-gray-800',
                                        content: 'text-gray-600'
                                    }
                                });
                            } else {
                                throw new Error(data.message || 'Erro ao excluir inscrição');
                            }
                        } catch (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: error.message || 'Erro ao excluir inscrição',
                                customClass: {
                                    popup: 'rounded-xl shadow-2xl',
                                    title: 'text-xl font-bold text-gray-800',
                                    content: 'text-gray-600'
                                }
                            });
                        }
                    }
                });
            };

            // Event listeners para filtros
            searchInput.addEventListener('input', filtrarInscricoes);
            statusFilter.addEventListener('change', filtrarInscricoes);
            modalidadeFilter.addEventListener('change', filtrarInscricoes);

            // Carregar inscrições ao iniciar
            carregarInscricoes();
        });
    </script>
</body>
</html>