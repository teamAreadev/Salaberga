<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Gerenciamento de Alunos - Sistema de Estágio">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <title>Gerenciar Alunos - Sistema de Estágio</title>

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

        .dashboard-card, .table-container {
            background-color: #2d2d2d;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .dashboard-card:hover, .table-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 122, 51, 0.2);
        }

        thead {
            background-color: #232323;
        }

        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        tbody tr:hover {
            background-color: rgba(0, 122, 51, 0.1);
        }

        .status-pill {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-ativo {
            background-color: rgba(0, 194, 80, 0.2);
            color: #00FF6B;
        }

        .status-inativo {
            background-color: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }

        .status-estagiando {
            background-color: rgba(255, 165, 0, 0.2);
            color: #FBBF24;
        }

        /* Scrollbar customizada */
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

        /* Input e botões estilizados */
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

<body class="select-none">
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
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="gerenciar_alunos.php" class="sidebar-link active">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="gerenciar_empresas.php" class="sidebar-link">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="vagas.php" class="sidebar-link">
                        <i class="fas fa-briefcase w-5 mr-3"></i>
                        Vagas
                    </a>
                    <a href="relatorios.php" class="sidebar-link">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        Relatórios
                    </a>
                </nav>
                <div class="mt-auto pt-4 border-t border-gray-700">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Configurações
                    </a>
                    <a href="login.php" class="sidebar-link text-red-400 hover:text-red-300">
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
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="gerenciar_alunos.php" class="sidebar-link active">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="gerenciar_empresas.php" class="sidebar-link">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="vagas.php" class="sidebar-link">
                        <i class="fas fa-briefcase w-5 mr-3"></i>
                        Vagas
                    </a>
                    <a href="relatorios.php" class="sidebar-link">
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
                    <h1 class="text-xl font-bold text-white text-center sm:text-left w-full">Gerenciamento de Alunos</h1>
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
                    <a href="dashboard.php" class="hover:text-primary-400">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-white">Gerenciar Alunos</span>
                </div>
                
                <!-- Actions Bar -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 w-full">
                        <button id="addAlunoBtn" class="inline-flex items-center justify-center px-4 py-2 border-0 rounded-md shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 focus:ring-offset-dark-400 w-full sm:w-auto transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Novo Aluno
                        </button>
                        <div class="relative w-full sm:w-64">
                            <input type="text" id="searchAluno" placeholder="Buscar aluno..." class="w-full pl-10 pr-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-dark-400">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 w-full sm:w-auto">
                        <select id="filterArea" class="pl-4 pr-8 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-dark-400 w-full sm:w-auto appearance-none bg-dark-100 text-white">
                            <option value="">Todas as áreas</option>
                            <option value="desenvolvimento">Desenvolvimento</option>
                            <option value="design">Design</option>
                            <option value="midia">Mídia</option>
                            <option value="redes">Redes/Suporte</option>
                        </select>
                        <select id="filterStatus" class="pl-4 pr-8 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-dark-400 w-full sm:w-auto appearance-none bg-dark-100 text-white">
                            <option value="">Todos os status</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                            <option value="estagiando">Estagiando</option>
                        </select>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-container overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700 text-sm">
                        <thead>
                            <tr>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nome</th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Área</th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nota</th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Projetos</th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="alunosTableBody">
                            <!-- Dados dos alunos serão inseridos aqui via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
        <!-- Modal de Cadastro/Edição -->
        <div id="alunoModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
            <div class="bg-dark-50 rounded-lg p-8 max-w-md w-full mx-4 shadow-2xl border border-gray-800">
                <h2 id="modalTitle" class="text-2xl font-bold mb-6 text-white">Novo Aluno</h2>
                <form id="alunoForm">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Nome</label>
                            <input type="text" id="alunoNome" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Área</label>
                            <select id="alunoArea" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="desenvolvimento">Desenvolvimento</option>
                                <option value="design">Design</option>
                                <option value="midia">Mídia</option>
                                <option value="redes">Redes/Suporte</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Status</label>
                            <select id="alunoStatus" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="ativo">Ativo</option>
                                <option value="inativo">Inativo</option>
                                <option value="estagiando">Estagiando</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Nota</label>
                            <input type="number" id="alunoNota" min="0" max="10" step="0.1" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Projetos Participados</label>
                            <input type="text" id="alunoProjetos" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
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
        // Dados dos alunos
        const alunos = [
            { id: 1, nome: "ALEXANDRE NETO DANTAS DA SILVA", area: "desenvolvimento", status: "ativo", nota: 8.5, projetos: "Projeto A, Projeto B" },
            { id: 2, nome: "ANA CLARA CAVALCANTE LIMA", area: "design", status: "ativo", nota: 9.0, projetos: "Projeto C" },
            { id: 3, nome: "ANGELA MICHELE DOS SANTOS LIMA", area: "midia", status: "estagiando", nota: 8.7, projetos: "Projeto D" },
            // ... adicionar os demais alunos
        ];

        // Função para renderizar a tabela de alunos
        function renderizarTabela(alunosFiltrados = alunos) {
            const tbody = document.getElementById('alunosTableBody');
            tbody.innerHTML = '';

            alunosFiltrados.forEach(aluno => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-dark-50 transition-colors';
                tr.innerHTML = `
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-300">${aluno.id}</td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-white">${aluno.nome}</td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        <span class="px-2 py-1 text-xs font-medium rounded-full ${
                            aluno.area === 'desenvolvimento' ? 'bg-blue-900 text-blue-300' : 
                            aluno.area === 'design' ? 'bg-purple-900 text-purple-300' : 
                            aluno.area === 'midia' ? 'bg-green-900 text-green-300' : 
                            'bg-orange-900 text-orange-300'
                        }">${aluno.area}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="status-pill ${
                            aluno.status === 'ativo' ? 'status-ativo' : 
                            aluno.status === 'inativo' ? 'status-inativo' : 
                            'status-estagiando'
                        }">${aluno.status}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-300">${aluno.nota}</td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-300">${aluno.projetos}</td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="editarAluno(${aluno.id})" class="text-primary-400 hover:text-primary-300 mr-3 transition-colors">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="excluirAluno(${aluno.id})" class="text-red-500 hover:text-red-400 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Sidebar mobile toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const closeSidebar = document.getElementById('closeSidebar');
        const mobileSidebar = document.getElementById('mobileSidebar');

        sidebarToggle.addEventListener('click', () => {
            mobileSidebar.classList.remove('-translate-x-full');
        });

        closeSidebar.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
        });

        // Modal de Cadastro/Edição
        const modal = document.getElementById('alunoModal');
        const addAlunoBtn = document.getElementById('addAlunoBtn');
        const cancelarBtn = document.getElementById('cancelarBtn');
        const alunoForm = document.getElementById('alunoForm');

        addAlunoBtn.addEventListener('click', () => {
            document.getElementById('modalTitle').textContent = 'Novo Aluno';
            alunoForm.reset();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        cancelarBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        // Busca e Filtros
        const searchInput = document.getElementById('searchAluno');
        const filterArea = document.getElementById('filterArea');
        const filterStatus = document.getElementById('filterStatus');

        function aplicarFiltros() {
            const searchTerm = searchInput.value.toLowerCase();
            const areaFiltro = filterArea.value;
            const statusFiltro = filterStatus.value;

            const alunosFiltrados = alunos.filter(aluno => {
                const matchSearch = aluno.nome.toLowerCase().includes(searchTerm);
                const matchArea = !areaFiltro || aluno.area === areaFiltro;
                const matchStatus = !statusFiltro || aluno.status === statusFiltro;
                return matchSearch && matchArea && matchStatus;
            });

            renderizarTabela(alunosFiltrados);
        }

        searchInput.addEventListener('input', aplicarFiltros);
        filterArea.addEventListener('change', aplicarFiltros);
        filterStatus.addEventListener('change', aplicarFiltros);

        // Inicializar tabela
        renderizarTabela();
    </script>
</body>
</html> 