<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Vagas - Sistema de Estágio">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <title>Vagas - Sistema de Estágio</title>

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

        .dashboard-card, .vaga-card {
            background-color: #2d2d2d;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .dashboard-card:hover, .vaga-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 122, 51, 0.2);
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

        /* Chip de área */
        .area-chip {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .area-desenvolvimento {
            background-color: rgba(59, 130, 246, 0.2);
            color: #93c5fd;
        }

        .area-design {
            background-color: rgba(168, 85, 247, 0.2);
            color: #c4b5fd;
        }

        .area-midia {
            background-color: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .area-redes {
            background-color: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        /* Modal de candidatura */
        .candidatura-modal {
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Cards mobile */
        @media (max-width: 640px) {
            .vaga-card {
                padding: 1rem;
            }
            
            .mobile-stack {
                flex-direction: column;
            }
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
                    <h1 class="text-xl font-bold text-white text-center sm:text-left w-full">Vagas Disponíveis</h1>
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
                    <span class="text-white">Vagas</span>
                </div>
                
                <!-- Actions Bar -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 w-full">
                        <button id="addVagaBtn" class="inline-flex items-center justify-center px-4 py-2 border-0 rounded-md shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 focus:ring-offset-dark-400 w-full sm:w-auto transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Nova Vaga
                        </button>
                        <div class="relative w-full sm:w-64">
                            <input type="text" id="searchVaga" placeholder="Buscar vaga..." class="w-full pl-10 pr-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-dark-400">
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
                        <select id="filterEmpresa" class="pl-4 pr-8 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-dark-400 w-full sm:w-auto appearance-none bg-dark-100 text-white">
                            <option value="">Todas as empresas</option>
                            <!-- Empresas serão adicionadas via JavaScript -->
                        </select>
                    </div>
                </div>
                <!-- Grid de Vagas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="vagasGrid">
                    <!-- Cards das vagas serão inseridos aqui via JavaScript -->
                </div>
            </main>
        </div>
        <!-- Modal de Cadastro/Edição de Vaga -->
        <div id="vagaModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
            <div class="bg-dark-50 rounded-lg p-8 max-w-md w-full mx-4 shadow-2xl border border-gray-800 candidatura-modal">
                <h2 id="modalTitle" class="text-2xl font-bold mb-6 text-white">Nova Vaga</h2>
                <form id="vagaForm">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Título da Vaga</label>
                            <input type="text" id="vagaTitulo" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Empresa</label>
                            <select id="vagaEmpresa" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                <!-- Empresas serão adicionadas via JavaScript -->
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Área</label>
                            <select id="vagaArea" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                <option value="desenvolvimento">Desenvolvimento</option>
                                <option value="design">Design</option>
                                <option value="midia">Mídia</option>
                                <option value="redes">Redes/Suporte</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Descrição</label>
                            <textarea id="vagaDescricao" rows="4" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Requisitos</label>
                            <textarea id="vagaRequisitos" rows="4" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Bolsa (R$)</label>
                            <input type="number" id="vagaBolsa" min="0" step="0.01" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Carga Horária (horas/semana)</label>
                            <input type="number" id="vagaCargaHoraria" min="0" max="40" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
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
        
        <!-- Modal de Candidatura -->
        <div id="candidaturaModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
            <div class="bg-dark-50 rounded-lg p-8 max-w-md w-full mx-4 shadow-2xl border border-gray-800 candidatura-modal">
                <h2 id="candidaturaModalTitle" class="text-2xl font-bold mb-6 text-white">Candidatar-se à Vaga</h2>
                <form id="candidaturaForm">
                    <input type="hidden" id="vagaIdCandidatura">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Filtrar por Área</label>
                            <select id="filtroAreaCandidatura" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="">Todas as áreas</option>
                                <option value="desenvolvimento">Desenvolvimento</option>
                                <option value="design">Design</option>
                                <option value="midia">Mídia</option>
                                <option value="redes">Redes/Suporte</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Filtrar por Nota Mínima</label>
                            <input type="number" id="filtroNotaCandidatura" min="0" max="10" step="0.1" placeholder="0-10" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Selecionar Aluno</label>
                            <select id="alunoCandidatura" class="mt-1 block w-full rounded-md bg-dark-100 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                <option value="">Selecione um aluno</option>
                                <!-- Alunos serão carregados via JavaScript -->
                            </select>
                        </div>
                        <div id="alunoInfo" class="hidden p-4 bg-dark-100 rounded-md">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-400">Área:</p>
                                    <p id="alunoAreaInfo" class="text-sm font-medium"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Nota:</p>
                                    <p id="alunoNotaInfo" class="text-sm font-medium"></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-400">Projetos:</p>
                                    <p id="alunoProjetosInfo" class="text-sm"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" id="cancelarCandidaturaBtn" class="px-4 py-2 border border-gray-700 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 border-0 rounded-md shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                            Confirmar Candidatura
                        </button>
                    </div>
                </form>
            </div>
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
            { id: 1, nome: "ALEXANDRE NETO DANTAS DA SILVA", area: "desenvolvimento", status: "ativo", nota: 8.5, projetos: "Projeto A, Projeto B" },
            { id: 2, nome: "ANA CLARA CAVALCANTE LIMA", area: "design", status: "ativo", nota: 9.0, projetos: "Projeto C" },
            { id: 3, nome: "ANGELA MICHELE DOS SANTOS LIMA", area: "midia", status: "estagiando", nota: 8.7, projetos: "Projeto D" },
            { id: 4, nome: "CARLOS EDUARDO SILVA SANTOS", area: "redes", status: "ativo", nota: 7.8, projetos: "Projeto E, Projeto F" },
            { id: 5, nome: "DANIELA FERNANDES OLIVEIRA", area: "design", status: "inativo", nota: 8.2, projetos: "Projeto G" },
            { id: 6, nome: "EDUARDO MORAES COSTA", area: "desenvolvimento", status: "estagiando", nota: 9.1, projetos: "Projeto H, Projeto I" }
        ];

        // Dados das vagas
        const vagas = [
            {
                id: 1,
                titulo: "Desenvolvedor Web Jr",
                empresa: 1,
                area: "desenvolvimento",
                descricao: "Desenvolvimento de aplicações web utilizando HTML, CSS e JavaScript.",
                requisitos: "Conhecimento em HTML, CSS e JavaScript\nBoa lógica de programação\nDisposição para aprender",
                bolsa: 800.00,
                cargaHoraria: 30
            },
            {
                id: 2,
                titulo: "Designer UI/UX",
                empresa: 2,
                area: "design",
                descricao: "Criação de interfaces e experiências de usuário para aplicações digitais.",
                requisitos: "Conhecimento em Figma ou Adobe XD\nNoções de UI/UX\nCriatividade",
                bolsa: 750.00,
                cargaHoraria: 20
            },
            {
                id: 3,
                titulo: "Suporte Técnico",
                empresa: 3,
                area: "redes",
                descricao: "Suporte técnico para usuários e manutenção de redes.",
                requisitos: "Conhecimento básico em redes\nBoa comunicação\nProatividade",
                bolsa: 700.00,
                cargaHoraria: 25
            }
        ];

        // Dados de candidaturas
        const candidaturas = [];

        // Função para renderizar os cards das vagas
        function renderizarVagas(vagasFiltradas = vagas) {
            const grid = document.getElementById('vagasGrid');
            grid.innerHTML = '';

            vagasFiltradas.forEach(vaga => {
                const empresa = empresas.find(e => e.id === vaga.empresa);
                const card = document.createElement('div');
                card.className = 'vaga-card p-6 hover:border-primary-400 transition-all';
                card.innerHTML = `
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-white">${vaga.titulo}</h3>
                            <p class="text-sm text-gray-400">${empresa.nome}</p>
                            <div class="mt-2">
                                <span class="area-chip area-${vaga.area}">${vaga.area}</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="editarVaga(${vaga.id})" class="text-primary-400 hover:text-primary-300 transition-colors">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="excluirVaga(${vaga.id})" class="text-red-500 hover:text-red-400 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <p class="text-sm text-gray-300">${vaga.descricao}</p>
                        <div class="pt-4 border-t border-gray-700">
                            <h4 class="text-sm font-medium text-white mb-2">Requisitos:</h4>
                            <ul class="text-sm text-gray-300 list-disc list-inside">
                                ${vaga.requisitos.split('\n').map(req => `<li>${req}</li>`).join('')}
                            </ul>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between items-center pt-4 border-t border-gray-700">
                        <div>
                            <p class="text-sm font-medium text-white">Bolsa: <span class="text-secondary-400">R$ ${vaga.bolsa.toFixed(2)}</span></p>
                            <p class="text-sm text-gray-400">${vaga.cargaHoraria}h semanais</p>
                        </div>
                        <button onclick="abrirModalCandidatura(${vaga.id})" class="px-4 py-2 text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 rounded-md transition-colors">
                            Candidatar-se
                        </button>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        // Preencher selects de empresas
        function preencherSelectEmpresas() {
            const selects = ['filterEmpresa', 'vagaEmpresa'];
            selects.forEach(selectId => {
                const select = document.getElementById(selectId);
                select.innerHTML = '<option value="">Todas as empresas</option>';
                empresas.forEach(empresa => {
                    const option = document.createElement('option');
                    option.value = empresa.id;
                    option.textContent = empresa.nome;
                    select.appendChild(option);
                });
            });
        }

        // Função para abrir modal de candidatura
        function abrirModalCandidatura(vagaId) {
            document.getElementById('vagaIdCandidatura').value = vagaId;
            
            // Carregar alunos no select
            const selectAluno = document.getElementById('alunoCandidatura');
            selectAluno.innerHTML = '<option value="">Selecione um aluno</option>';
            
            alunos.forEach(aluno => {
                const option = document.createElement('option');
                option.value = aluno.id;
                option.textContent = aluno.nome;
                option.setAttribute('data-area', aluno.area);
                option.setAttribute('data-nota', aluno.nota);
                option.setAttribute('data-projetos', aluno.projetos);
                selectAluno.appendChild(option);
            });
            
            // Resetar filtros
            document.getElementById('filtroAreaCandidatura').value = '';
            document.getElementById('filtroNotaCandidatura').value = '';
            document.getElementById('alunoInfo').classList.add('hidden');
            
            // Abrir modal
            document.getElementById('candidaturaModal').classList.remove('hidden');
            document.getElementById('candidaturaModal').classList.add('flex');
            
            // Atualizar título com o nome da vaga
            const vaga = vagas.find(v => v.id === vagaId);
            if (vaga) {
                document.getElementById('candidaturaModalTitle').textContent = `Candidatar-se à vaga: ${vaga.titulo}`;
            }
        }

        // Função para filtrar alunos no modal de candidatura
        function filtrarAlunosCandidatura() {
            const areaFiltro = document.getElementById('filtroAreaCandidatura').value;
            const notaFiltro = parseFloat(document.getElementById('filtroNotaCandidatura').value) || 0;
            
            const selectAluno = document.getElementById('alunoCandidatura');
            const options = selectAluno.querySelectorAll('option');
            
            options.forEach(option => {
                if (option.value === "") {
                    option.hidden = false;
                    return;
                }
                
                const alunoArea = option.getAttribute('data-area');
                const alunoNota = parseFloat(option.getAttribute('data-nota'));
                
                const matchArea = !areaFiltro || alunoArea === areaFiltro;
                const matchNota = alunoNota >= notaFiltro;
                
                option.hidden = !(matchArea && matchNota);
            });
            
            // Resetar seleção
            selectAluno.value = "";
            document.getElementById('alunoInfo').classList.add('hidden');
        }

        // Função para mostrar informações do aluno selecionado
        function mostrarInfoAluno(alunoId) {
            const aluno = alunos.find(a => a.id === parseInt(alunoId));
            const alunoInfo = document.getElementById('alunoInfo');
            
            if (aluno) {
                document.getElementById('alunoAreaInfo').textContent = aluno.area;
                document.getElementById('alunoNotaInfo').textContent = aluno.nota;
                document.getElementById('alunoProjetosInfo').textContent = aluno.projetos;
                alunoInfo.classList.remove('hidden');
            } else {
                alunoInfo.classList.add('hidden');
            }
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

        // Modal de Cadastro/Edição de Vaga
        const vagaModal = document.getElementById('vagaModal');
        const addVagaBtn = document.getElementById('addVagaBtn');
        const cancelarBtn = document.getElementById('cancelarBtn');
        const vagaForm = document.getElementById('vagaForm');

        addVagaBtn.addEventListener('click', () => {
            document.getElementById('modalTitle').textContent = 'Nova Vaga';
            vagaForm.reset();
            vagaModal.classList.remove('hidden');
            vagaModal.classList.add('flex');
        });

        cancelarBtn.addEventListener('click', () => {
            vagaModal.classList.add('hidden');
            vagaModal.classList.remove('flex');
        });

        // Modal de Candidatura
        const candidaturaModal = document.getElementById('candidaturaModal');
        const cancelarCandidaturaBtn = document.getElementById('cancelarCandidaturaBtn');
        const candidaturaForm = document.getElementById('candidaturaForm');

        cancelarCandidaturaBtn.addEventListener('click', () => {
            candidaturaModal.classList.add('hidden');
            candidaturaModal.classList.remove('flex');
        });

        // Fechar modais ao clicar fora
        [vagaModal, candidaturaModal].forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });

        // Event listeners para filtros de candidatura
        document.getElementById('filtroAreaCandidatura').addEventListener('change', filtrarAlunosCandidatura);
        document.getElementById('filtroNotaCandidatura').addEventListener('input', filtrarAlunosCandidatura);
        document.getElementById('alunoCandidatura').addEventListener('change', function() {
            mostrarInfoAluno(this.value);
        });

        // Form submit de candidatura
        candidaturaForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const vagaId = parseInt(document.getElementById('vagaIdCandidatura').value)
            const alunoId = parseInt(document.getElementById('alunoCandidatura').value);
        
        if (!alunoId) {
            alert('Por favor, selecione um aluno');
            return;
        }
        
        const vaga = vagas.find(v => v.id === vagaId);
        const aluno = alunos.find(a => a.id === alunoId);
        
        // Verificar se já existe candidatura para este aluno e vaga
        const candidaturaExistente = candidaturas.find(c => 
            c.vagaId === vagaId && c.alunoId === alunoId
        );
        
        if (candidaturaExistente) {
            alert('Este aluno já está candidatado a esta vaga');
            return;
        }
        
        // Adicionar candidatura
        candidaturas.push({
            id: candidaturas.length + 1,
            vagaId,
            alunoId,
            data: new Date().toISOString(),
            status: 'pendente'
        });
        
        alert(`Candidatura de ${aluno.nome} para a vaga "${vaga.titulo}" realizada com sucesso!`);
        candidaturaModal.classList.add('hidden');
        candidaturaModal.classList.remove('flex');
    });

    // Busca e Filtros de vagas
    const searchInput = document.getElementById('searchVaga');
    const filterArea = document.getElementById('filterArea');
    const filterEmpresa = document.getElementById('filterEmpresa');

    function aplicarFiltros() {
        const searchTerm = searchInput.value.toLowerCase();
        const areaFiltro = filterArea.value;
        const empresaFiltro = filterEmpresa.value;

        const vagasFiltradas = vagas.filter(vaga => {
            const empresa = empresas.find(e => e.id === vaga.empresa);
            const matchSearch = vaga.titulo.toLowerCase().includes(searchTerm) || 
                              empresa.nome.toLowerCase().includes(searchTerm);
            const matchArea = !areaFiltro || vaga.area === areaFiltro;
            const matchEmpresa = !empresaFiltro || vaga.empresa === parseInt(empresaFiltro);
            return matchSearch && matchArea && matchEmpresa;
        });

        renderizarVagas(vagasFiltradas);
    }

    searchInput.addEventListener('input', aplicarFiltros);
    filterArea.addEventListener('change', aplicarFiltros);
    filterEmpresa.addEventListener('change', aplicarFiltros);

    // Funções para editar e excluir vagas (simuladas)
    function editarVaga(id) {
        const vaga = vagas.find(v => v.id === id);
        if (vaga) {
            document.getElementById('modalTitle').textContent = 'Editar Vaga';
            document.getElementById('vagaTitulo').value = vaga.titulo;
            document.getElementById('vagaEmpresa').value = vaga.empresa;
            document.getElementById('vagaArea').value = vaga.area;
            document.getElementById('vagaDescricao').value = vaga.descricao;
            document.getElementById('vagaRequisitos').value = vaga.requisitos;
            document.getElementById('vagaBolsa').value = vaga.bolsa;
            document.getElementById('vagaCargaHoraria').value = vaga.cargaHoraria;
            
            vagaModal.classList.remove('hidden');
            vagaModal.classList.add('flex');
        }
    }

    function excluirVaga(id) {
        if (confirm('Tem certeza que deseja excluir esta vaga?')) {
            // Simulação de exclusão
            const index = vagas.findIndex(v => v.id === id);
            if (index !== -1) {
                vagas.splice(index, 1);
                aplicarFiltros();
                alert('Vaga excluída com sucesso!');
            }
        }
    }

    // Inicializar página
    preencherSelectEmpresas();
    renderizarVagas();
</script>