<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Seleção de Alunos - Sistema de Estágio">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <title>Seleção de Alunos - Sistema de Estágio</title>

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

        /* Tabela estilizada */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            background-color: #2d2d2d;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table thead th {
            background-color: #232323;
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            color: #b0b0b0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .custom-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }

        .custom-table tbody tr:hover {
            background-color: rgba(0, 122, 51, 0.1);
        }

        .custom-table tbody td {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #e0e0e0;
        }

        /* Checkbox estilizado */
        .custom-checkbox {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-checkbox input[type="checkbox"] {
            appearance: none;
            width: 1.125rem;
            height: 1.125rem;
            border: 2px solid #4b4b4b;
            border-radius: 0.25rem;
            background-color: #2d2d2d;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .custom-checkbox input[type="checkbox"]:checked {
            background-color: #007A33;
            border-color: #007A33;
        }

        .custom-checkbox input[type="checkbox"]:checked::after {
            content: '✓';
            display: block;
            color: white;
            font-size: 0.875rem;
            text-align: center;
            line-height: 1;
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

        /* Status chips */
        .chip {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .chip-green {
            background-color: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .chip-yellow {
            background-color: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        .chip-red {
            background-color: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
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
                    <a href="gerenciar_alunos.php" class="sidebar-link">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="gerenciar_empresas.php" class="sidebar-link">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="vagas.php" class="sidebar-link active">
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
                    <a href="gerenciar_alunos.php" class="sidebar-link">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="gerenciar_empresas.php" class="sidebar-link">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="vagas.php" class="sidebar-link active">
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
                    <h1 class="text-xl font-bold text-white text-center sm:text-left w-full">Selecionar Alunos para Vaga</h1>
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
                    <a href="vagas.php" class="hover:text-primary-400">Vagas</a>
                    <span class="mx-2">/</span>
                    <span class="text-white">Selecionar Alunos</span>
                </div>
                
                <!-- Info da Vaga -->
                <div class="bg-dark-50 p-6 rounded-lg shadow-md mb-6 border border-gray-800">
                    <h2 id="vagaTitulo" class="text-xl font-bold text-white mb-2">Carregando...</h2>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <div>
                            <span class="text-gray-400">Empresa:</span>
                            <span id="vagaEmpresa" class="text-white ml-1">Carregando...</span>
                        </div>
                        <div>
                            <span class="text-gray-400">Área:</span>
                            <span id="vagaArea" class="text-white ml-1">Carregando...</span>
                        </div>
                    </div>
                </div>
                
                <!-- Actions Bar -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 w-full">
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
                        <button id="selectAllBtn" class="px-4 py-2 border-0 rounded-md shadow-sm text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 focus:ring-offset-dark-400 w-full sm:w-auto transition-colors duration-200">
                            Selecionar Todos
                        </button>
                    </div>
                </div>
                
                <!-- Tabela de Alunos -->
                <div class="table-container">
                    <form id="alunosForm">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th width="40px" class="text-center">#</th>
                                    <th width="50px"></th>
                                    <th>Nome</th>
                                    <th width="80px">Média</th>
                                    <th>Projetos</th>
                                    <th width="100px">Área</th>
                                    <th width="100px">Ocorrências</th>
                                    <th width="100px">Custeio</th>
                                </tr>
                            </thead>
                            <tbody id="alunosTableBody">
                                <!-- Linhas da tabela serão geradas por JavaScript -->
                            </tbody>
                        </table>
                    </form>
                </div>
                
                <!-- Botões de Ação -->
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="vagas.php" class="px-4 py-2 border border-gray-700 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700 transition-colors">
                        Cancelar
                    </a>
                    <button id="confirmarSelecaoBtn" class="px-4 py-2 border-0 rounded-md shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        Confirmar Seleção
                    </button>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Dados das empresas
        const empresas = [
            { id: 1, nome: "TechCorp Solutions" },
            { id: 2, nome: "Mídia Digital" },
            { id: 3, nome: "Redes & Cia" }
        ];

        // Dados dos alunos
        const alunos = [
            { 
                id: 1, 
                nome: "ALEXANDRE NETO DANTAS DA SILVA", 
                area: "desenvolvimento", 
                status: "ativo", 
                nota: 8.5, 
                projetos: "Projeto A, Projeto B",
                ocorrencias: 0,
                custeio: "Integral"
            },
            { 
                id: 2, 
                nome: "ANA CLARA CAVALCANTE LIMA", 
                area: "design", 
                status: "ativo", 
                nota: 9.0, 
                projetos: "Projeto C",
                ocorrencias: 1,
                custeio: "Parcial"
            },
            { 
                id: 3, 
                nome: "ANGELA MICHELE DOS SANTOS LIMA", 
                area: "midia", 
                status: "estagiando", 
                nota: 8.7, 
                projetos: "Projeto D",
                ocorrencias: 0,
                custeio: "Integral"
            },
            { 
                id: 4, 
                nome: "CARLOS EDUARDO SILVA SANTOS", 
                area: "redes", 
                status: "ativo", 
                nota: 7.8, 
                projetos: "Projeto E, Projeto F",
                ocorrencias: 2,
                custeio: "Não"
            },
            { 
                id: 5, 
                nome: "DANIELA FERNANDES OLIVEIRA", 
                area: "design", 
                status: "inativo", 
                nota: 8.2, 
                projetos: "Projeto G",
                ocorrencias: 1,
                custeio: "Parcial"
            },
            { 
                id: 6, 
                nome: "EDUARDO MORAES COSTA", 
                area: "desenvolvimento", 
                status: "estagiando", 
                nota: 9.1, 
                projetos: "Projeto H, Projeto I",
                ocorrencias: 0,
                custeio: "Integral"
            }
        ];

        // Dados das vagas
        const vagas = [
            {
                id: 1,
                titulo: "Desenvolvedor Web Jr",
                empresa: 1,
                area: "desenvolvimento"
            },
            {
                id: 2,
                titulo: "Designer UI/UX",
                empresa: 2,
                area: "design"
            },
            {
                id: 3,
                titulo: "Suporte Técnico",
                empresa: 3,
                area: "redes"
            }
        ];

        // Obter ID da vaga da URL
        const urlParams = new URLSearchParams(window.location.search);
        const vagaId = parseInt(urlParams.get('vaga_id')) || 1;

        // Preencher informações da vaga
        function preencherInfoVaga() {
            const vaga = vagas.find(v => v.id === vagaId);
            if (vaga) {
                const empresa = empresas.find(e => e.id === vaga.empresa);
                document.getElementById('vagaTitulo').textContent = vaga.titulo;
                document.getElementById('vagaEmpresa').textContent = empresa.nome;
                document.getElementById('vagaArea').textContent = vaga.area;
            }
        }

        // Renderizar tabela de alunos
        function renderizarTabelaAlunos(alunosFiltrados = alunos) {
            const tbody = document.getElementById('alunosTableBody');
            tbody.innerHTML = '';

            alunosFiltrados.forEach((aluno, index) => {
                const tr = document.createElement('tr');
                
                tr.innerHTML = `
                    <td class="text-center">${index + 1}</td>
                    <td class="custom-checkbox">
                        <input type="checkbox" id="aluno_${aluno.id}" name="alunos[]" value="${aluno.id}">
                    </td>
                    <td>${aluno.nome}</td>
                    <td>${aluno.nota.toFixed(1)}</td>
                    <td>${aluno.projetos || '-'}</td>
                    <td>${aluno.area}</td>
                    <td class="text-center">
                        ${getOcorrenciasHTML(aluno.ocorrencias)}
                    </td>
                    <td>${aluno.custeio}</td>
                `;
                
                tbody.appendChild(tr);
            });
        }

        // Gerar HTML para ocorrências
        function getOcorrenciasHTML(ocorrencias) {
            if (ocorrencias === 0) {
                return '<span class="chip chip-green">0</span>';
            } else if (ocorrencias === 1) {
                return '<span class="chip chip-yellow">1</span>';
            } else {
                return `<span class="chip chip-red">${ocorrencias}</span>`;
            }
        }

        // Aplicar filtros na tabela
        function aplicarFiltros() {
            const searchTerm = document.getElementById('searchAluno').value.toLowerCase();
            const areaFiltro = document.getElementById('filterArea').value;

            const alunosFiltrados = alunos.filter(aluno => {
                const matchSearch = aluno.nome.toLowerCase().includes(searchTerm);
                const matchArea = !areaFiltro || aluno.area === areaFiltro;
                return matchSearch && matchArea;
            });

            renderizarTabelaAlunos(alunosFiltrados);
        }

        // Selecionar/Deselecionar todos os alunos
        let todosSelecaionados = false;
        function toggleSelectAll() {
            const checkboxes = document.querySelectorAll('#alunosTableBody input[type="checkbox"]');
            todosSelecaionados = !todosSelecaionados;
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = todosSelecaionados;
            });
            
            document.getElementById('selectAllBtn').textContent = todosSelecaionados ? 'Desmarcar Todos' : 'Selecionar Todos';
        }

        // Confirmar seleção de alunos
        function confirmarSelecao() {
            const checkboxes = document.querySelectorAll('#alunosTableBody input[type="checkbox"]:checked');
            const alunosSelecionados = Array.from(checkboxes).map(cb => parseInt(cb.value));
            
            if (alunosSelecionados.length === 0) {
                alert('Por favor, selecione pelo menos um aluno.');
                return;
            }
            
            const vaga = vagas.find(v => v.id === vagaId);
            const alunosNomes = alunosSelecionados.map(id => {
                const aluno = alunos.find(a => a.id === id);
                return aluno.nome;
            }).join(', ');
            
            alert(`Alunos selecionados para a vaga "${vaga.titulo}":\n${alunosNomes}`);
            window.location.href = 'vagas.php';
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

        // Event listeners
        document.getElementById('searchAluno').addEventListener('input', aplicarFiltros);
        document.getElementById('filterArea').addEventListener('change', aplicarFiltros);
        document.getElementById('selectAllBtn').addEventListener('click', toggleSelectAll);
        document.getElementById('confirmarSelecaoBtn').addEventListener('click', confirmarSelecao);

        // Inicializar página
        document.addEventListener('DOMContentLoaded', () => {
            preencherInfoVaga();
            renderizarTabelaAlunos();
        });
    </script>
</body>
</html> 