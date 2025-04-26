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
    <title>Gerenciar Inscrições - Copa Grêmio 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e6f2ec',
                            100: '#cce5d9',
                            200: '#99cbb3',
                            300: '#66b18d',
                            400: '#339766',
                            500: '#007d40',
                            600: '#006a36',
                            700: '#005A24', // Base primary color
                            800: '#004d1f',
                            900: '#00401a',
                        },
                        secondary: {
                            50: '#fff8e6',
                            100: '#ffefc0',
                            200: '#ffe099',
                            300: '#ffd066',
                            400: '#ffc033',
                            500: '#ffb000',
                            600: '#FF8C00', // Base secondary color
                            700: '#cc7000',
                            800: '#995400',
                            900: '#663800',
                        },
                        accent: {
                            50: '#ffede9',
                            100: '#ffdbd3',
                            200: '#ffb7a7',
                            300: '#ff937b',
                            400: '#FF6347', // Base accent color
                            500: '#ff3814',
                            600: '#e62600',
                            700: '#b31e00',
                            800: '#801500',
                            900: '#4d0c00',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .modal {
            transition: opacity 0.25s ease;
        }
        .table-row:hover {
            background-color: rgba(0, 90, 36, 0.05);
        }
        .status-badge {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-pendente {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-aprovado {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-reprovado {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        .hover-float:hover {
            transform: translateY(-3px);
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Cabeçalho -->
    <header class="bg-primary-700 text-white shadow-lg">
        <div class="container mx-auto py-4 px-4 md:px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold flex items-center animate-fadeInUp"><i class="fas fa-tachometer-alt mr-2 animate-pulse"></i>Painel Administrativo</h1>
                    <p class="text-primary-200">Copa Grêmio 2025</p>
                </div>
                <div class="flex items-center space-x-4 animate-fadeInUp" style="animation-delay:0.2s">
                    <span class="text-primary-100">
                        <i class="fas fa-user mr-1"></i> Olá, <?php echo htmlspecialchars($_SESSION['admin_nome']); ?>
                    </span>
                    <a href="../controllers/AdminController.php?action=logout" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm flex items-center hover-float">
                        <i class="fas fa-sign-out-alt mr-1"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="container mx-auto py-8 px-4 md:px-6 flex-grow">
        <div class="mb-6 bg-white rounded-lg shadow-md p-6 animate-fadeInUp">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-primary-800 flex items-center animate-fadeInUp"><i class="fas fa-list-alt mr-2 text-secondary-600"></i> Dashboard de Inscrições</h2>
                <div class="mt-4 md:mt-0 flex items-center animate-fadeInUp" style="animation-delay:0.2s">
                    <div class="relative mr-2">
                        <input type="text" id="search" placeholder="Buscar aluno..." class="w-64 pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <button id="refresh-btn" class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-2 rounded-md text-sm flex items-center hover-float">
                        <i class="fas fa-sync-alt mr-1"></i> Atualizar
                    </button>
                </div>
            </div>
            
            <!-- Cards de estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-primary-50 p-4 rounded-lg border border-primary-200 animate-fadeInUp hover-float">
                    <div class="flex items-center">
                        <div class="bg-primary-500 p-3 rounded-full mr-4 animate-pulse">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div>
                            <p class="text-primary-700 text-sm">Total de Alunos</p>
                            <h3 class="text-2xl font-bold text-primary-800" id="total-alunos">0</h3>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 animate-fadeInUp hover-float" style="animation-delay:0.1s">
                    <div class="flex items-center">
                        <div class="bg-yellow-500 p-3 rounded-full mr-4 animate-pulse">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <p class="text-yellow-700 text-sm">Pendentes</p>
                            <h3 class="text-2xl font-bold text-yellow-800" id="total-pendentes">0</h3>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-200 animate-fadeInUp hover-float" style="animation-delay:0.2s">
                    <div class="flex items-center">
                        <div class="bg-green-500 p-3 rounded-full mr-4 animate-pulse">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                        <div>
                            <p class="text-green-700 text-sm">Aprovadas</p>
                            <h3 class="text-2xl font-bold text-green-800" id="total-aprovadas">0</h3>
                        </div>
                    </div>
                </div>
                <div class="bg-red-50 p-4 rounded-lg border border-red-200 animate-fadeInUp hover-float" style="animation-delay:0.3s">
                    <div class="flex items-center">
                        <div class="bg-red-500 p-3 rounded-full mr-4 animate-pulse">
                            <i class="fas fa-times-circle text-white"></i>
                        </div>
                        <div>
                            <p class="text-red-700 text-sm">Reprovadas</p>
                            <h3 class="text-2xl font-bold text-red-800" id="total-reprovadas">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Placeholder para gráfico -->
            <div class="bg-white rounded-lg shadow p-6 mb-6 animate-fadeInUp hover-float" style="animation-delay:0.4s">
                <h3 class="text-lg font-semibold text-primary-700 mb-4 flex items-center"><i class="fas fa-chart-bar mr-2 text-secondary-600"></i> Gráfico de Inscrições (em breve)</h3>
                <div class="w-full h-40 flex items-center justify-center text-gray-400">
                    <i class="fas fa-spinner fa-pulse text-3xl mr-2"></i> Em breve um gráfico interativo aqui!
                </div>
            </div>
            
            <!-- Tabela de Inscrições -->
            <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turma</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modalidades</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tabela-inscricoes">
                        <!-- Preenchido via JavaScript -->
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Carregando inscrições...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Rodapé -->
    <footer class="bg-primary-800 text-white py-4 mt-auto">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p>&copy; 2025 Grêmio Estudantil José Ivan Pontes Júnior</p>
                    <p class="text-primary-200 text-sm">EEEP Salaberga Torquato Gomes de Matos</p>
                </div>
                <div>
                    <a href="../index.php" class="text-white hover:text-secondary-400 transition-colors">
                        <i class="fas fa-home mr-1"></i> Página Inicial
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Detalhes da Inscrição -->
    <div id="modal-detalhes" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-2xl mx-auto rounded shadow-lg z-50 overflow-y-auto max-h-screen">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3 border-b">
                    <p class="text-xl font-bold text-primary-700">Detalhes da Inscrição</p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>

                <div id="detalhes-inscricao" class="my-5">
                    <!-- Preenchido via JavaScript -->
                    <div class="flex justify-center items-center py-8">
                        <i class="fas fa-spinner fa-spin mr-2 text-primary-600"></i> Carregando detalhes...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabelaInscricoes = document.getElementById('tabela-inscricoes');
            const searchInput = document.getElementById('search');
            const refreshBtn = document.getElementById('refresh-btn');
            const modalDetalhes = document.getElementById('modal-detalhes');
            const detalhesInscricao = document.getElementById('detalhes-inscricao');
            
            // Estatísticas
            const totalAlunos = document.getElementById('total-alunos');
            const totalPendentes = document.getElementById('total-pendentes');
            const totalAprovadas = document.getElementById('total-aprovadas');
            const totalReprovadas = document.getElementById('total-reprovadas');
            
            // Fechar modal
            document.querySelectorAll('.modal-close, .modal-overlay').forEach(element => {
                element.addEventListener('click', function() {
                    fecharModal();
                });
            });
            
            // Fechar modal quando clicar fora
            window.addEventListener('click', function(e) {
                if (e.target === modalDetalhes) {
                    fecharModal();
                }
            });
            
            // Carregar inscrições
            function carregarInscricoes() {
                fetch('../controllers/AdminController.php?action=listar-inscricoes')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            renderizarInscricoes(data.inscricoes);
                            atualizarEstatisticas(data.inscricoes);
                        } else {
                            tabelaInscricoes.innerHTML = `<tr><td colspan="7" class="px-6 py-4 text-center text-red-500">Erro ao carregar inscrições: ${data.message}</td></tr>`;
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao carregar inscrições:', error);
                        tabelaInscricoes.innerHTML = `<tr><td colspan="7" class="px-6 py-4 text-center text-red-500">Erro ao carregar inscrições. Tente novamente.</td></tr>`;
                    });
            }
            
            // Renderizar inscrições na tabela
            function renderizarInscricoes(inscricoes) {
                if (inscricoes.length === 0) {
                    tabelaInscricoes.innerHTML = `<tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">Nenhuma inscrição encontrada.</td></tr>`;
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#${inscricao.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${inscricao.nome}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${inscricao.ano}º ${inscricao.turma}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${dataFormatada}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${inscricao.total_modalidades}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge ${statusStyle}">${statusText}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="btn-detalhes text-primary-600 hover:text-primary-800 mr-2" data-id="${inscricao.id}">
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
                modalDetalhes.classList.remove('opacity-0');
                modalDetalhes.classList.remove('pointer-events-none');
                
                detalhesInscricao.innerHTML = `
                    <div class="flex justify-center items-center py-8">
                        <i class="fas fa-spinner fa-spin mr-2 text-primary-600"></i> Carregando detalhes...
                    </div>
                `;
                
                fetch(`../controllers/AdminController.php?action=obter-inscricao&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            renderizarDetalhes(data.aluno, data.inscricoes);
                        } else {
                            detalhesInscricao.innerHTML = `
                                <div class="p-4 bg-red-100 text-red-700 rounded-lg">
                                    <p>${data.message}</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao carregar detalhes:', error);
                        detalhesInscricao.innerHTML = `
                            <div class="p-4 bg-red-100 text-red-700 rounded-lg">
                                <p>Erro ao carregar detalhes. Tente novamente.</p>
                            </div>
                        `;
                    });
            }
            
            // Fechar modal
            function fecharModal() {
                modalDetalhes.classList.add('opacity-0');
                modalDetalhes.classList.add('pointer-events-none');
            }
            
            // Renderizar detalhes
            function renderizarDetalhes(aluno, inscricoes) {
                const data = new Date(aluno.data_inscricao);
                const dataFormatada = `${data.getDate().toString().padStart(2, '0')}/${(data.getMonth()+1).toString().padStart(2, '0')}/${data.getFullYear()} às ${data.getHours().toString().padStart(2, '0')}:${data.getMinutes().toString().padStart(2, '0')}`;
                
                let html = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-primary-700 mb-2">Dados do Aluno</h3>
                            <ul class="space-y-2">
                                <li><strong>Nome:</strong> ${aluno.nome}</li>
                                <li><strong>Turma:</strong> ${aluno.ano}º ${aluno.turma}</li>
                                <li><strong>E-mail:</strong> ${aluno.email}</li>
                                <li><strong>Telefone:</strong> ${aluno.telefone}</li>
                                <li><strong>Data da Inscrição:</strong> ${dataFormatada}</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-primary-700 mb-2">Modalidades Inscritas</h3>
                            <p class="text-sm text-gray-500 mb-2">Total de modalidades: ${inscricoes.length}</p>
                            <ul class="space-y-2">
                `;
                
                // Calcular valor
                const totalModalidades = inscricoes.length;
                const valorUnitario = totalModalidades >= 3 ? 3.00 : 5.00;
                const valorTotal = valorUnitario * totalModalidades;
                
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
                        <li class="flex justify-between items-center border-b border-gray-200 pb-2">
                            <div>
                                <span class="capitalize">${modalidade}</span>
                                <span class="text-xs text-gray-500 block">Categoria: ${inscricao.categoria}</span>
                                ${inscricao.nome_equipe ? `<span class="text-xs text-gray-500 block">Equipe: ${inscricao.nome_equipe}</span>` : ''}
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="status-badge ${statusClass}">${statusText}</span>
                                <div class="relative">
                                    <button class="text-gray-500 hover:text-gray-700 btn-acao" data-inscricao-id="${inscricao.id}">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden dropdown-acoes z-10" data-dropdown="${inscricao.id}">
                                        <div class="py-1">
                                            <button class="btn-aprovar w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700" data-inscricao-id="${inscricao.id}">
                                                <i class="fas fa-check-circle mr-1 text-green-500"></i> Aprovar
                                            </button>
                                            <button class="btn-reprovar w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700" data-inscricao-id="${inscricao.id}">
                                                <i class="fas fa-times-circle mr-1 text-red-500"></i> Reprovar
                                            </button>
                                            <button class="btn-pendente w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700" data-inscricao-id="${inscricao.id}">
                                                <i class="fas fa-clock mr-1 text-yellow-500"></i> Marcar como Pendente
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `;
                });
                
                html += `
                            </ul>
                        </div>
                    </div>
                    <div class="bg-primary-50 p-4 rounded-lg mb-4">
                        <h3 class="text-lg font-semibold text-primary-700 mb-2">Pagamento</h3>
                        <div class="flex justify-between">
                            <div>
                                <p>Valor por modalidade: ${valorUnitario.toFixed(2).replace('.', ',')} R$</p>
                                <p class="text-xs text-gray-500">${totalModalidades >= 3 ? 'Desconto aplicado (3+ modalidades)' : 'Valor padrão'}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-xl">Total: ${valorTotal.toFixed(2).replace('.', ',')} R$</p>
                            </div>
                        </div>
                    </div>
                    <div id="feedback-message" class="hidden p-3 my-3 rounded-lg"></div>
                `;
                
                detalhesInscricao.innerHTML = html;
                
                // Adicionar event listeners para os botões de ação
                document.querySelectorAll('.btn-acao').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const id = this.getAttribute('data-inscricao-id');
                        document.querySelectorAll('.dropdown-acoes').forEach(dropdown => {
                            if (dropdown.getAttribute('data-dropdown') === id) {
                                dropdown.classList.toggle('hidden');
                            } else {
                                dropdown.classList.add('hidden');
                            }
                        });
                    });
                });
                
                // Fechar dropdowns ao clicar fora
                document.addEventListener('click', function() {
                    document.querySelectorAll('.dropdown-acoes').forEach(dropdown => {
                        dropdown.classList.add('hidden');
                    });
                });
                
                // Adicionar event listeners para aprovar/reprovar
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
                        const statusBadge = document.querySelector(`.btn-acao[data-inscricao-id="${inscricaoId}"]`)
                            .closest('li')
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
                        
                        // Fechar dropdown
                        document.querySelectorAll('.dropdown-acoes').forEach(dropdown => {
                            dropdown.classList.add('hidden');
                        });
                        
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