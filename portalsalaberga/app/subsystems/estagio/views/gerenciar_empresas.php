<?php
require_once('../models/select_model.php');
$select_model = new select_model;
/*require_once('../models/sessions.php');
$session = new sessions;
$session->tempo_session(600);
$session->autenticar_session();

if (isset($_POST['logout'])) {
    $session->quebra_session();
}*/
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Gerenciamento de Empresas - Sistema de Estágio">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <title>Gerenciar Empresas - Sistema de Estágio</title>

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
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

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
                radial-gradient(circle at 10% 20%, rgba(0, 122, 51, 0.03) 0%, rgba(0, 122, 51, 0) 20%),
                radial-gradient(circle at 90% 80%, rgba(255, 165, 0, 0.03) 0%, rgba(255, 165, 0, 0) 20%);
            transition: all 0.3s ease;
        }

        .sidebar {
            background-color: #2d2d2d;
            border-right: 1px solid rgba(0, 122, 51, 0.2);
            transition: all 0.3s ease;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
            color: #ffffff;
        }

        .sidebar-link:hover {
            background-color: rgba(0, 122, 51, 0.2);
            color: #00C250;
        }

        .sidebar-link.active {
            background-color: rgba(0, 122, 51, 0.3);
            color: #00FF6B;
            font-weight: 600;
        }

        .empresa-card {
            background-color: #2d2d2d;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }

        .empresa-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 122, 51, 0.2);
            border: 1px solid rgba(0, 122, 51, 0.3);
        }

        .empresa-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #00FF6B, #007A33);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .empresa-card:hover::before {
            opacity: 1;
        }

        .empresa-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .empresa-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.2;
        }

        .empresa-card-actions {
            display: flex;
            gap: 0.5rem;
        }

        .empresa-card-action {
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .empresa-card-action:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .empresa-card-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .empresa-card-info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #d1d5db;
        }

        .area-chip {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .area-desenvolvimento {
            background-color: rgba(59, 130, 246, 0.2);
            color: #93c5fd;
        }

        .area-tutoria {
            background-color: rgba(168, 85, 247, 0.2);
            color: #c4b5fd;
        }

        .area-midia {
            background-color: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .area-suporte {
            background-color: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #3d3d3d;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #007A33;
        }

        input, select, textarea {
            background-color: #232323 !important;
            border-color: #3d3d3d !important;
            color: #ffffff !important;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #007A33 !important;
            box-shadow: 0 0 0 2px rgba(0, 122, 51, 0.2) !important;
        }
    </style>
</head>

<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="sidebar w-64 hidden md:block">
            <div class="p-4 flex flex-col h-full">
                <div class="flex items-center gap-2 mb-6">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-10 w-auto">
                    <div>
                        <h1 class="text-lg font-bold text-primary-400">Sistema <span class="text-secondary">STGM</span></h1>
                        <div class="h-0.5 bg-primary-500/20 rounded-full mt-1"></div>
                    </div>
                </div>
                <nav class="flex-1">
                    <a href="./dashboard.php" class="sidebar-link">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="./gerenciar_alunos.php" class="sidebar-link">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="./gerenciar_empresas.php" class="sidebar-link active">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="./vagas.php" class="sidebar-link">
                        <i class="fas fa-briefcase w-5 mr-3"></i>
                        Vagas
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        Relatórios
                    </a>
                </nav>
                <div class="mt-auto pt-4 border-t border-gray-700">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Configurações
                    </a>
                    <a href="#" class="sidebar-link text-red-400 hover:text-red-300">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        Sair
                    </a>
                </div>
            </div>
        </aside>
        <!-- Mobile Sidebar Toggle -->
        <div class="md:hidden fixed top-4 left-4 z-50">
            <button id="sidebarToggle" class="bg-dark-50 p-2 rounded-lg shadow-md">
                <i class="fas fa-bars text-primary-400"></i>
            </button>
        </div>
        <!-- Mobile Sidebar -->
        <div id="mobileSidebar" class="fixed inset-y-0 left-0 z-40 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden sidebar">
            <div class="p-4 flex flex-col h-full">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-10 w-auto">
                        <h1 class="text-lg font-bold text-primary-400">Sistema <span class="text-secondary">STGM</span></h1>
                    </div>
                    <button id="closeSidebar" class="p-2 text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="flex-1">
                    <a href="./dashboard.php" class="sidebar-link">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="./gerenciar_alunos.php" class="sidebar-link">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="./gerenciar_empresas.php" class="sidebar-link active">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="./vagas.php" class="sidebar-link">
                        <i class="fas fa-briefcase w-5 mr-3"></i>
                        Vagas
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        Relatórios
                    </a>
                </nav>
            </div>
        </div>
        <!-- Conteúdo principal -->
        <div class="flex-1 flex flex-col overflow-y-auto bg-dark-400">
            <!-- Header -->
            <header class="bg-dark-50 shadow-md sticky top-0 z-30 border-b border-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <h1 class="text-xl font-bold text-white text-center sm:text-left w-full">Gerenciamento de Empresas</h1>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-400">
                            <i class="fas fa-user-circle mr-1"></i> Admin
                        </span>
                    </div>
                </div>
            </header>
            <!-- Main Content -->
            <main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6 sm:py-8 w-full">
                <!-- Breadcrumbs -->
                <div class="text-sm text-gray-400 mb-6">
                    <a href="./dashboard.php" class="hover:text-primary-400">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-white">Gerenciar Empresas</span>
                </div>

                <!-- Actions Bar -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 w-full">
                        <button id="addEmpresaBtn" class="inline-flex items-center justify-center px-4 py-2 border-0 rounded-md shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 focus:ring-offset-dark-400 w-full sm:w-auto transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Nova Empresa
                        </button>
                        <div class="relative w-full sm:w-64">
                            <input type="text" id="searchEmpresa" placeholder="Buscar empresa..." class="w-full pl-10 pr-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-dark-400">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 w-full sm:w-auto">
                        <select id="filterArea" class="pl-4 pr-8 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-dark-400 w-full sm:w-auto appearance-none bg-dark-100 text-white">
                            <option value="">Todas as áreas</option>
                            <option value="desenvolvimento">Desenvolvimento</option>
                            <option value="tutoria">Tutoria</option>
                            <option value="midia">Design/Mídia</option>
                            <option value="suporte">Redes/Suporte</option>
                        </select>
                    </div>
                </div>
                <!-- Grid de Empresas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="empresasGrid">
                    <?php 
                    $dados = $select_model->concedentes();
                    if (empty($dados)): ?>
                        <div class="col-span-3 text-center py-8 text-gray-400">
                            Nenhuma empresa cadastrada no momento.
                        </div>
                    <?php else: ?>
                        <?php foreach ($dados as $dado): ?>
                            <div class="empresa-card" data-empresa-id="<?= htmlspecialchars($dado['id']) ?>" data-area="<?= htmlspecialchars($dado['perfil']) ?>">
                                <div class="empresa-card-header">
                                    <h3 class="empresa-card-title"><?= htmlspecialchars($dado['nome']) ?></h3>
                                    <div class="empresa-card-actions">
                                        <button class="empresa-card-action text-primary-400 hover:text-primary-300" onclick="editarEmpresa(<?= $dado['id'] ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="empresa-card-action text-red-500 hover:text-red-400" onclick="excluirEmpresa(<?= $dado['id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="area-chip area-<?= htmlspecialchars($dado['perfil']) ?>"><?= htmlspecialchars($dado['perfil']) ?></span>
                                </div>
                                <div class="empresa-card-info">
                                    <div class="empresa-card-info-item">
                                        <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                                        <span><?= htmlspecialchars($dado['endereco']) ?: 'Não informado' ?></span>
                                    </div>
                                    <div class="empresa-card-info-item">
                                        <i class="fas fa-phone w-5 text-gray-400"></i>
                                        <span><?= htmlspecialchars($dado['contato']) ?: 'Não informado' ?></span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-700">
                                    <a href="./vagas.php?empresa_id=<?= htmlspecialchars($dado['id']) ?>" class="text-primary-400 hover:text-primary-300 text-sm font-medium transition-colors">
                                        Ver vagas <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>
        <!-- Modal de Cadastro/Edição -->
        <div id="empresaModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
            <div class="bg-dark-50 rounded-lg p-8 max-w-md w-full mx-4 shadow-2xl border border-gray-800">
                <h2 id="modalTitle" class="text-2xl font-bold mb-6 text-white">Nova Empresa</h2>
                <form action="../controllers/controller.php" id="empresaForm" method="post">
                    <input type="hidden" id="empresaId" name="empresa_id" value="">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Nome da Empresa</label>
                            <input type="text" id="empresaNome" name="nome" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Área de Atuação</label>
                            <div class="mt-2 space-y-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-primary-500 bg-dark-200 border-dark-100" name="areas" value="desenvolvimento">
                                    <span class="ml-2 text-gray-300">Desenvolvimento</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-primary-500 bg-dark-200 border-dark-100" name="areas" value="tutoria">
                                    <span class="ml-2 text-gray-300">Tutoria</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-primary-500 bg-dark-200 border-dark-100" name="areas" value="midia">
                                    <span class="ml-2 text-gray-300">Design/Mídia</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-primary-500 bg-dark-200 border-dark-100" name="areas" value="suporte">
                                    <span class="ml-2 text-gray-300">Redes/Suporte</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Endereço</label>
                            <input type="text" id="empresaEndereco" name="endereco" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Telefone</label>
                            <input type="tel" id="empresaTelefone" name="telefone" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                       
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" id="cancelarBtn" class="px-4 py-2 border border-gray-700 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 border-0 rounded-md shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('empresaModal');
            const addEmpresaBtn = document.getElementById('addEmpresaBtn');
            const cancelarBtn = document.getElementById('cancelarBtn');
            const empresaForm = document.getElementById('empresaForm');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const closeSidebar = document.getElementById('closeSidebar');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const searchInput = document.getElementById('searchEmpresa');
            const filterArea = document.getElementById('filterArea');

            addEmpresaBtn.addEventListener('click', () => {
                document.getElementById('modalTitle').textContent = 'Nova Empresa';
                document.getElementById('empresaId').value = '';
                empresaForm.reset();
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            cancelarBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });

            sidebarToggle.addEventListener('click', () => {
                mobileSidebar.classList.remove('-translate-x-full');
            });

            closeSidebar.addEventListener('click', () => {
                mobileSidebar.classList.add('-translate-x-full');
            });

            function aplicarFiltros() {
                const searchTerm = searchInput.value.toLowerCase();
                const areaFiltro = filterArea.value;
                const empresaCards = document.querySelectorAll('.empresa-card');

                empresaCards.forEach(card => {
                    const nome = card.querySelector('.empresa-card-title').textContent.toLowerCase();
                    const area = card.dataset.area;
                    const matchSearch = nome.includes(searchTerm);
                    const matchArea = !areaFiltro || area === areaFiltro;

                    if (matchSearch && matchArea) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', aplicarFiltros);
            filterArea.addEventListener('change', aplicarFiltros);

            function editarEmpresa(id) {
                fetch(`get_empresa.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const empresa = data.empresa;
                            document.getElementById('modalTitle').textContent = 'Editar Empresa';
                            document.getElementById('empresaId').value = empresa.id;
                            document.getElementById('empresaNome').value = empresa.nome;
                            document.getElementById('empresaEndereco').value = empresa.endereco;
                            document.getElementById('empresaTelefone').value = empresa.contato;
                            document.getElementById('empresaVagasDisponiveis').value = empresa.vagas_disponiveis || 0;
                            const areaRadio = document.querySelector(`input[name="areas"][value="${empresa.perfil}"]`);
                            if (areaRadio) areaRadio.checked = true;

                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                        } else {
                            alert('Erro ao carregar dados da empresa');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao obter dados da empresa:', error);
                        alert('Erro ao carregar dados da empresa');
                    });
            }

            function excluirEmpresa(id) {
                if (confirm('Tem certeza que deseja excluir esta empresa?')) {
                    fetch('excluir_empresa.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${id}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Empresa excluída com sucesso!');
                            window.location.reload();
                        } else {
                            alert('Erro ao excluir empresa: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao excluir empresa');
                    });
                }
            }

            // Expor funções ao escopo global para os botões
            window.editarEmpresa = editarEmpresa;
            window.excluirEmpresa = excluirEmpresa;
        });
    </script>
</body>
</html>