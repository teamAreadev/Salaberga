<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A90E2">
    <meta name="description" content="Resultados da Seleção - STGM">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <title>Resultados da Seleção - STGM</title>
</head>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#007A33',
                    secondary: '#FFA500',
                    success: '#10B981',
                    danger: '#EF4444',
                    warning: '#F59E0B',
                    info: '#3B82F6'
                }
            }
        }
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    :root {
        --background-color: #1a1a1a;
        --text-color: #ffffff;
        --header-color: #00b348;
        --icon-bg: #2d2d2d;
        --icon-shadow: rgba(0, 0, 0, 0.3);
        --accent-color: #ffb733;
        --grid-color: #333333;
        --card-bg: rgba(45, 45, 45, 0.9);
        --header-bg: rgba(28, 28, 28, 0.95);
        --mobile-nav-bg: rgba(28, 28, 28, 0.95);
        --search-bar-bg: #2d2d2d;
        --card-border-hover: var(--accent-color);
    }



    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: var(--background-color);
        min-height: 100vh;
        padding-top: 80px;
        background-image: radial-gradient(circle at 10% 20%, rgba(52, 152, 219, 0.05) 0%, rgba(52, 152, 219, 0) 20%), radial-gradient(circle at 90% 80%, rgba(46, 204, 113, 0.05) 0%, rgba(46, 204, 113, 0) 20%);
        color: var(--text-color);
        transition: background-color 0.3s ease;
    }

    @media (max-width: 768px) {
        body {
            padding-bottom: 100px;
        }
    }

    .main-header {
        background: var(--header-bg);
        backdrop-filter: blur(10px);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        border-bottom: 2px solid rgba(0, 122, 51, 0.1);
        transition: all 0.3s ease;
    }

    .main-header.scrolled {
        background: var(--header-bg);
        box-shadow: 0 4px 20px var(--icon-shadow);
    }

    .nav-link {
        position: relative;
        padding: 0.5rem 1rem;
        color: var(--text-color);
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .search-container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 0 1rem;
        position: relative;
    }

    .search-bar {
        width: 100%;
        padding: 1rem 1.5rem;
        border-radius: 50px;
        border: 2px solid rgba(0, 122, 51, 0.2);
        background: var(--search-bar-bg);
        color: var(--text-color);
        transition: all 0.3s ease;
    }

    .search-bar:focus {
        outline: none;
        border-color: var(--header-color);
        box-shadow: 0 4px 12px rgba(0, 122, 51, 0.1);
    }

    .clear-search {
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        border-radius: 50%;
        padding: 8px;
        margin: 0;
        color: #666;
        transition: all 0.2s ease;
        opacity: 0.7;
        cursor: pointer;
        user-select: none;
        -webkit-user-select: none;
        min-width: 32px;
        min-height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .clear-search::before {
        content: "×";
        font-size: 20px;
        font-weight: 500;
        line-height: 1;
    }

    .clear-search:hover {
        color: #333;
        opacity: 1;
    }

    .mobile-nav {
        position: fixed;
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 400px;
        background: var(--mobile-nav-bg);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        padding: 1rem;
        box-shadow: 0 4px 20px var(--icon-shadow);
        z-index: 1000;
        transition: all 0.3s ease;
        display: none;
    }

    @media (max-width: 768px) {
        .mobile-nav {
            display: block;
        }
    }

    .candidate-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .candidate-card.approved {
        border-left-color: #10B981;
    }

    .candidate-card.waiting {
        border-left-color: #F59E0B;
    }

    .candidate-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-badge.approved {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10B981;
    }

    .status-badge.waiting {
        background-color: rgba(245, 158, 11, 0.1);
        color: #F59E0B;
    }

    .area-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        background-color: rgba(59, 130, 246, 0.1);
        color: #3B82F6;
    }

    .company-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        background-color: rgba(139, 92, 246, 0.1);
        color: #8B5CF6;
    }

    .filter-button {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .filter-button:hover {
        transform: translateY(-1px);
    }

    .filter-button.active {
        background-color: var(--header-color);
        color: white;
    }

    .filter-button:not(.active):hover {
        border-color: var(--header-color);
        color: var(--header-color);
    }
</style>

<body class="select-none">
    <header class="main-header">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-12 w-auto object-contain">
                    <div>
                        <h1 class="md:text-xl lg:text-lg font-bold text-primary">Resultados <span class="text-secondary">STGM</span></h1>
                        <div class="h-0.5 bg-primary/20 rounded-full mt-1"></div>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-5">
                    <a href="#" class="nav-link">Início</a>
                    <a href="#" class="nav-link">Sair</a>
                    <a href="./views/login.php" class="inline-flex items-center justify-center px-4 py-2 rounded-md bg-primary text-white hover:bg-primary/90 transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </a>
                   
                </nav>

            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold mb-2">Resultados da Seleção</h1>
                <p class="text-gray-600 dark:text-gray-400">Confira abaixo os resultados do processo seletivo</p>
            </div>

            <div class="search-container mb-6">
                <input type="text" id="search-input" class="search-bar" placeholder="Buscar por nome...">
                <button id="clear-search" class="clear-search" style="display: none;"></button>
            </div>

            <div class="mb-6">
                <div class="flex flex-wrap gap-2 justify-center">
                    <button class="filter-button status-filter active" data-filter="all">Todos</button>
                    <button class="filter-button status-filter" data-filter="approved">Aprovados</button>
                    <button class="filter-button status-filter" data-filter="waiting">Em espera</button>
                </div>
            </div>

            <div class="grid gap-4" id="candidates-container">
                <!-- Os candidatos serão inseridos aqui via JavaScript -->
            </div>
        </div>
    </main>

    <nav class="mobile-nav md:hidden mobile-nav-enter">
        <div class="flex justify-around items-center">
            <a href="#" class="nav-link">
                <i class="fa-solid fa-home text-xl"></i>
                <span class="text-xs">Início</span>
            </a>
            <a href="#" class="nav-link">
                <i class="fa-solid fa-sign-in-alt text-xl"></i>
                <span class="text-xs">Login</span>
            </a>
            <a href="#" class="nav-link">
                <i class="fa-solid fa-sign-out-alt text-xl"></i>
                <span class="text-xs">Sair</span>
            </a>
        </div>
    </nav>

    <script>
        // Dados dos candidatos
        const candidates = [
            { id: 1, name: "ALEXANDRE NETO DANTAS DA SILVA", status: "waiting" },
            { id: 2, name: "ANA CLARA CAVALCANTE LIMA", status: "waiting" },
            { id: 3, name: "ANGELA MICHELE DOS SANTOS LIMA", status: "waiting" },
            { id: 4, name: "ANTONIO FELIPE GOMES MOREIRA", status: "waiting" },
            { id: 5, name: "ATHILA SILVEIRA DA SILVA", status: "waiting" },
            { id: 6, name: "BIANCA VIEIRA GOMES", status: "waiting" },
            { id: 7, name: "CARLOS EDUARDO CARDOSO HOLANDA", status: "waiting" },
            { id: 8, name: "CARLOS EDUARDO DA COSTA LIMA", status: "waiting" },
            { id: 9, name: "CARLOS FRED ABREU PIRES", status: "waiting" },
            { id: 10, name: "CHRISTIAN UNIAS DOS SANTOS SIQUEIRA", status: "approved", area: "suporte", company: "Mallory" },
            { id: 11, name: "CLARICE ROCHA DE NOJOSA OLIVEIRA", status: "waiting" },
            { id: 12, name: "ELPIDIO THOMAS DE FREITAS BEZERRA", status: "waiting" },
            { id: 13, name: "FRANCISCO DENILSON ANDRADE COSTA", status: "waiting" },
            { id: 14, name: "FRANCISCO ERICK ALVES DE PINHO", status: "waiting" },
            { id: 15, name: "FRANCISCO ERICK HONORIO DE OLIVEIRA", status: "waiting" },
            { id: 16, name: "FRANCISCO KAUA MUNIZ DA SILVA", status: "waiting" },
            { id: 17, name: "FRANCISCO LAVOSIER SILVA NASCIMENTO", status: "waiting" },
            { id: 18, name: "FRANCISCO LUCAS DIAMANTE SOUZA", status: "waiting" },
            { id: 19, name: "FRANCISCO WEVERTON CIRILO MARQUES", status: "waiting" },
            { id: 20, name: "GIOVANNA THAYLA CARDOSO VIANA", status: "waiting" },
            { id: 21, name: "IAN LUCAS FREITAS DA SILVA DE ARAUJO", status: "waiting" },
            { id: 22, name: "JEFFERSON CASTRO DA SILVA", status: "waiting" },
            { id: 23, name: "JENNYFER NICOLY SOUSA MARQUES", status: "approved", area: "suporte", company: "Mallory" },
            { id: 24, name: "JOAO GABRIEL COSTA CORREIA", status: "waiting" },
            { id: 25, name: "JOÃO PAULO ARAUJO DA SILVA", status: "waiting" },
            { id: 26, name: "JOSE ARIMATEIA MACIEL DE SOUSA", status: "waiting" },
            { id: 27, name: "JULIA FROTA DE OLIVEIRA", status: "waiting" },
            { id: 28, name: "JULIO CEZAR TARGINO DA SILVA FILHO", status: "waiting" },
            { id: 29, name: "LARISSA MOURA DA SILVA", status: "waiting" },
            { id: 30, name: "LETICIA BARBOSA OLIVEIRA", status: "waiting" },
            { id: 31, name: "LETYCIA SANTOS DE SOUSA", status: "waiting" },
            { id: 32, name: "MARCELA DOS SANTOS COSTA", status: "waiting" },
            { id: 33, name: "MARCOS LUAN VIEIRA DA SILVA", status: "waiting" },
            { id: 34, name: "MARIA JOISSEANNE DA SILVA NASCIMENTO", status: "waiting" },
            { id: 35, name: "MARIA MAYSA DA SILVA ROCHA", status: "approved", area: "midia", company: "Fenix Soluções" },
            { id: 36, name: "MATHEUS FELIX LOPES", status: "waiting" },
            { id: 37, name: "MATHEUS MACHADO FERNANDES", status: "waiting" },
            { id: 38, name: "MILLENA DA SILVA ANDRADE FREIRES", status: "waiting" },
            { id: 39, name: "NATYELLEN FRANCA DE SOUSA", status: "waiting" },
            { id: 40, name: "NICOLE KELLY DE OLIVEIRA LOPES", status: "waiting" },
            { id: 41, name: "PAULO VITOR LIMA DUARTE", status: "waiting" },
            { id: 42, name: "PEDRO UCHOA DE ABREU", status: "waiting" },
            { id: 43, name: "RAFAEL MARTINS DOS SANTOS", status: "waiting" },
            { id: 44, name: "RAMON NUNES MENDONCA", status: "waiting" },
            { id: 45, name: "RAYSSA BEZERRA VAZ", status: "waiting" },
            { id: 46, name: "RODRIGO FRANCO CAMPOS", status: "waiting" },
            { id: 47, name: "ROGER SILVA CAVALCANTE", status: "waiting" },
            { id: 48, name: "SARAH HELLEN TOME DE OLIVEIRA", status: "waiting" },
            { id: 49, name: "YUDI BEZERRA BARBOSA", status: "waiting" }
        ];

        // Função para renderizar os candidatos
        function renderCandidates(filteredCandidates = candidates) {
            const container = document.getElementById('candidates-container');
            container.innerHTML = '';

            if (filteredCandidates.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Nenhum candidato encontrado com os filtros selecionados.</p>
                    </div>
                `;
                return;
            }

            filteredCandidates.forEach(candidate => {
                const card = document.createElement('div');
                card.className = `candidate-card ${candidate.status}`;
                
                // Tradução do status
                let statusText = '';
                switch(candidate.status) {
                    case 'approved':
                        statusText = 'Aprovado';
                        break;
                    case 'waiting':
                        statusText = 'Em espera';
                        break;
                }
                
                let cardContent = `
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold">${candidate.name}</h3>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <span class="status-badge ${candidate.status}">${statusText}</span>
                `;
                
                // Adicionar área e empresa apenas para aprovados
                if (candidate.status === 'approved') {
                    cardContent += `
                                <span class="area-badge">${candidate.area}</span>
                                <span class="company-badge">${candidate.company}</span>
                    `;
                }
                
                cardContent += `
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">#${candidate.id.toString().padStart(2, '0')}</div>
                    </div>
                `;
                
                card.innerHTML = cardContent;
                container.appendChild(card);
            });
        }

        // Inicializar a página
        document.addEventListener('DOMContentLoaded', function() {
            // Renderizar candidatos iniciais
            renderCandidates();
            
            // Configurar busca
            const searchInput = document.getElementById('search-input');
            const clearButton = document.getElementById('clear-search');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                clearButton.style.display = searchTerm ? 'block' : 'none';
                
                filterCandidates();
            });
            
            clearButton.addEventListener('click', function() {
                searchInput.value = '';
                clearButton.style.display = 'none';
                filterCandidates();
            });
            
            // Configurar filtros de status
            const statusFilters = document.querySelectorAll('.status-filter');
            statusFilters.forEach(button => {
                button.addEventListener('click', function() {
                    statusFilters.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    filterCandidates();
                });
            });
            
            // Função para aplicar todos os filtros
            function filterCandidates() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const activeStatusFilter = document.querySelector('.status-filter.active').dataset.filter;
                
                const filtered = candidates.filter(candidate => {
                    // Filtro de busca
                    const matchesSearch = candidate.name.toLowerCase().includes(searchTerm);
                    
                    // Filtro de status
                    const matchesStatus = activeStatusFilter === 'all' || candidate.status === activeStatusFilter;
                    
                    return matchesSearch && matchesStatus;
                });
                
                renderCandidates(filtered);
            }
            
           
            
            // Animação para os cards
            const animateCards = () => {
                const cards = document.querySelectorAll('.candidate-card');
                cards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        card.style.transition = 'all 0.3s ease-out';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 50);
                });
            };
            
            animateCards();
            
            // Atualizar animação quando os filtros mudam
            const observer = new MutationObserver(animateCards);
            observer.observe(document.getElementById('candidates-container'), { childList: true });
        });
        
        // Função para atualizar o status de um candidato (para uso administrativo)
        function updateCandidateStatus(id, newStatus, area = null, company = null) {
            const candidate = candidates.find(c => c.id === id);
            if (candidate) {
                candidate.status = newStatus;
                if (area) candidate.area = area;
                if (company) candidate.company = company;
                renderCandidates();
            }
        }
    </script>
</body>
</html>
