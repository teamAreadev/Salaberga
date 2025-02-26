<?php

require_once('../../controllers/controller_sessao/autenticar_sessao.php');
require_once('../../controllers/controller_sessao/verificar_sessao.php');
verificarSessao(60);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#007A33">
    <meta name="description" content="Portal do Professores - Acesse suas atividades e recursos escolares">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/acessibilidades.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Subsistemas STGM</title>
</head>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#007A33',
                    secondary: '#FFA500',
                }
            }
        }
    }
</script>
<body class="select-none">
<noscript>
    <div class="fixed inset-0 bg-gradient-to-br from-[#007A33]/10 to-[#FFA500]/10 flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-8 rounded-xl shadow-2xl border-2 border-[#007A33]/20 max-w-md w-full mx-4 text-center">
            <div class="mb-6">
                <svg class="w-16 h-16 mx-auto text-[#007A33]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold text-[#007A33] mb-4">JavaScript Necessário</h1>
            
            <div class="space-y-4 mb-6">
                <p class="text-lg text-gray-800">Para uma melhor experiência, ative o JavaScript.</p>
                <p class="text-md text-gray-600">O Portal do Aluno necessita do JavaScript para fornecer:</p>
                
                <ul class="text-gray-700 space-y-2">
                    <li class="flex items-center justify-center gap-2">
                        <span class="text-[#FFA500]">✓</span> Navegação interativa
                    </li>
                    <li class="flex items-center justify-center gap-2">
                        <span class="text-[#FFA500]">✓</span> Recursos de acessibilidade
                    </li>
                    <li class="flex items-center justify-center gap-2">
                        <span class="text-[#FFA500]">✓</span> Personalização da interface
                    </li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-3 mb-6">
                <a href="https://www.enable-javascript.com/pt/" 
                   target="_blank" 
                   class="bg-[#007A33] text-white px-6 py-2.5 rounded-lg hover:bg-[#007A33]/90 transition-all duration-300 shadow-md hover:shadow-lg">
                    Como Ativar JavaScript
                </a>
                <button onclick="window.location.reload()" 
                        class="bg-[#FFA500] text-white px-6 py-2.5 rounded-lg hover:bg-[#FFA500]/90 transition-all duration-300 shadow-md hover:shadow-lg">
                    Recarregar Página
                </button>
            </div>

            <div class="text-sm text-gray-500 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Precisa de ajuda? Entre em contato com o suporte técnico</span>
            </div>
        </div>
    </div>
</noscript>
    <header class="main-header">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-12 w-auto object-contain">
                    <div>
                        <h1 class="md:text-xl lg:text-lg font-bold text-primary ">Subsistemas <span class="text-secondary">STGM</span></h1>
                        <div class="h-0.5 bg-primary/20 rounded-full mt-1"></div>
                    </div>
                </div>
                <nav class="hidden md:flex items-center gap-5">
                    <a href="/" class="nav-link">Início</a>
                    <a href="/controllers/controller_sessao/autenticar_sessao.php?sair" class="nav-link">Sair</a>
                    <button id="darkModeToggle" class="inline-flex items-center justify-center p-2 rounded-lg transition-colors" role="switch" aria-label="Alternar modo escuro">
                        <svg class="w-5 h-5 sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="w-5 h-5 moon-icon hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <span class="sr-only">Alternar modo escuro</span>
                    </button>
                    <div class="relative">
                        <button id="accessibilityBtnDesktop" class="flex items-center gap-2 p-2 rounded-lg transition-colors duration-300" aria-expanded="false" aria-haspopup="true">
                            <i class="fa-solid fa-universal-access text-xl"></i>
                        </button>
                        <div id="accessibilityMenuDesktop" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg py-2 hidden z-50" role="menu">
                            <div class="px-4 py-2 border-b" style="color: #1a1a1a;">
                                <span class="block text-sm font-semibold mb-2">Tamanho do Texto</span>
                                <div class="flex gap-2">
                                    <button class="p-2 hover:bg-gray-100 rounded" aria-label="Diminuir tamanho do texto"><i class="fa-solid fa-a"></i><b>-</b></button>
                                    <button class="p-2 hover:bg-gray-100 rounded" aria-label="Tamanho padrão do texto"><i class="fa-solid fa-a"></i></button>
                                    <button class="p-2 hover:bg-gray-100 rounded" aria-label="Aumentar tamanho do texto"><i class="fa-solid fa-a"></i><b>+</b></button>
                                </div>
                            </div>
                            <button class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center gap-2" style="color: #1a1a1a;">
                                <i class="fa-solid fa-ear-listen"></i>
                                <span>Leitor de Tela</span>
                            </button>
                            <button id="themeBtnDesktop" class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center justify-between" style="color: #1a1a1a;">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-half-stroke"></i>
                                    <span>Temas de Contraste</span>
                                </div>
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                        <div id="themeMenuDesktop" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg py-2 hidden z-50">
                            <div class="flex items-center px-4 py-2 border-b">
                                <button id="backToMainMenuDesktop" class="mr-2" style="color: #1a1a1a;">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </button>
                                <span class="font-semibold">Temas de Contraste</span>
                            </div>
                            <div class="py-2" style="color: #1a1a1a;">
                                <button class="w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="monochrome">Monocromático</button>
                                <button class="w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="inverted-grayscale">Escala de cinza invertida</button>
                                <button class="w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="inverted-color">Cor invertida</button>
                                <button class="w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="original">Cores originais</button>
                            </div>
                        </div>
                    </div>
                    <a href="/autenticacao/perfil.php">
                        <div class="flex items-center gap-3 cursor-pointer">
                            <div class="relative">
                                <img src="https://i.postimg.cc/m2d5f5L3/images-removebg-preview.png" alt="Perfil" class="w-10 h-10 rounded-full border-2 border-transparent hover:border-secondary transition-colors duration-300">
                                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                            </div>
                        </div>
                    </a>
                </nav>
                <div class="md:hidden">
                    <div class="relative">
                        <a href="/autenticacao/perfil.php">
                            <img src="https://i.postimg.cc/m2d5f5L3/images-removebg-preview.png" alt="Perfil" class="w-10 h-10 rounded-full border-2 border-transparent hover:border-secondary transition-colors duration-300">
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <nav class="mobile-nav md:hidden">
        <div class="flex justify-around items-center">
            <a href="/" class="nav-link">
                <i class="fa-solid fa-home text-xl"></i>
                <span class="text-xs">Início</span>
            </a>
            <a href="/controllers/controller_sessao/autenticar_sessao.php?sair" class="nav-link">
                <i class="fa-solid fa-sign-out-alt text-xl"></i>
                <span class="text-xs">Sair</span>
            </a>
            <div class="relative">
                <button id="accessibilityBtnMobile" class="nav-link flex flex-col items-center">
                    <i class="fa-solid fa-universal-access text-xl"></i>
                    <span class="text-xs">Acessibilidade</span>
                </button>
                <div id="accessibilityMenuMobile" class="menu-base bottom-24 hidden">
                    <button class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center gap-2" style="color: #1a1a1a;">
                        <i class="fa-solid fa-ear-listen"></i>
                        <span>Leitor de Tela</span>
                    </button>
                    <div class="relative">
                        <button id="themeBtnMobile" class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center justify-between" style="color: #1a1a1a;">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-half-stroke"></i>
                                <span>Temas de Contraste</span>
                            </div>
                            <i class="fa-solid fa-chevron-right transition-transform duration-200"></i>
                        </button>
                    </div>
                </div>
                <div id="themeMenuMobile" class="menu-base bottom-24 hidden">
                    <div class="flex items-center px-4 py-2 border-b">
                        <button id="backToMainMenu" class="mr-2" style="color: #1a1a1a;">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <span class="font-semibold">Temas de Contraste</span>
                    </div>
                    <div class="py-2" style="color: #1a1a1a;">
                        <button class="w-full px-4 py-3 text-left hover:bg-gray-100" data-theme="monochrome">Monocromático</button>
                        <button class="w-full px-4 py-3 text-left hover:bg-gray-100" data-theme="inverted-grayscale">Escala de cinza invertida</button>
                        <button class="w-full px-4 py-3 text-left hover:bg-gray-100" data-theme="inverted-color">Cor invertida</button>
                        <button class="w-full px-4 py-3 text-left hover:bg-gray-100" data-theme="original">Cores originais</button>
                    </div>
                </div>
            </div>
            <button id="darkModeToggleMobile" class="nav-link flex flex-col items-center">
                <svg class="w-6 h-6 sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg class="w-6 h-6 moon-icon hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <span class="text-xs sr-only">Alternar modo escuro</span>
                <span class="text-xs">Tema</span>
            </button>
        </div>
        <div id="menuOverlay" class="menu-overlay"></div>
    </nav>
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Buscar aplicativos..." id="search-input">
    </div>
    <main class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-8 md:gap-8 p-4 md:p-8 max-w-[1400px] mx-auto transition-all duration-300">
            <a href="https://salaberga.com" target="_blank">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Portal STGM" class="app-icon">
                    </div>
                    <h3 class="app-name">Portal STGM</h3>
                    <span class="category-tag">Sistema</span>
                </div>
            </a>
            <a href="https://aluno.seduc.ce.gov.br/">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/MGhrtrk4/aluna.png" alt="Aluno Online" class="app-icon">
                    </div>
                    <h3 class="app-name">Aluno Online</h3>
                    <span class="category-tag">Portal</span>
                </div>
            </a>
            <a href="https://classroom.google.com/">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/BQNdZvgK/image-1599078642807-removebg-preview.png" alt="Google Classroom" class="app-icon">
                    </div>
                    <h3 class="app-name">Google Classroom</h3>
                    <span class="category-tag">Aulas</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/cJn3sprk/logout-15423241.png" alt="Entrada e Saída de Alunos" class="app-icon">
                    </div>
                    <h3 class="app-name">Entrada e Saída de Alunos</h3>
                    <span class="category-tag">Administração</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/gjNXSdTj/diet-561611.png" alt="Gestão da Alimentação Escolar" class="app-icon">
                    </div>
                    <h3 class="app-name">Gestão da Alimentação Escolar</h3>
                    <span class="category-tag">Nutrição</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/VNQ6Fdk4/racking-system-11392607.png" alt="Controle de Estoque de Materiais" class="app-icon">
                    </div>
                    <h3 class="app-name">Controle de Estoque de Materiais</h3>
                    <span class="category-tag">Logística</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/B6zBhTLR/estagio.png" alt="Gestão de Estágio" class="app-icon">
                    </div>
                    <h3 class="app-name">Gestão de Estágio</h3>
                    <span class="category-tag">Carreira</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/d04BCPqs/suporte-tecnico.png" alt="Chamados de Suporte" class="app-icon">
                    </div>
                    <h3 class="app-name">Chamados de Suporte</h3>
                    <span class="category-tag">TI</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/G2vvjWRT/manutencao.png" alt="Gerência de Espaços e Equipamentos" class="app-icon">
                    </div>
                    <h3 class="app-name">Gerência de Espaços e Equipamentos</h3>
                    <span class="category-tag">Infraestrutura</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="banco de questoes.png" alt="Banco de Questões" class="app-icon">
                    </div>
                    <h3 class="app-name">Banco de Questões</h3>
                    <span class="category-tag">Educação</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/Ls3gGHcR/pilha-de-livros.png" alt="Biblioteca" class="app-icon">
                    </div>
                    <h3 class="app-name">Biblioteca</h3>
                    <span class="category-tag">Recursos</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/8kFH70xG/pessoa.png" alt="Registros PCD" class="app-icon">
                    </div>
                    <h3 class="app-name">Registros PCD</h3>
                    <span class="category-tag">Inclusão</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/C5VsTF74/scan-facial.png" alt="Tombamento" class="app-icon">
                    </div>
                    <h3 class="app-name">Tombamento</h3>
                    <span class="category-tag">Patrimônio</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/6qjqVc8G/profits-1571029.png" alt="Financeiro" class="app-icon">
                    </div>
                    <h3 class="app-name">Financeiro</h3>
                    <span class="category-tag">Economia</span>
                </div>
            </a>
            <a href="#">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/hjnXKfFh/businessman-1253671.png" alt="Professor Diretor de Turma" class="app-icon">
                    </div>
                    <h3 class="app-name">Professor Diretor de Turma</h3>
                    <span class="category-tag">Educação</span>
                </div>
            </a>
            <a href="https://mural.seduc.ce.gov.br">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/CMX7vRKh/aviso-1.png" alt="Mural de Avisos" class="app-icon">
                    </div>
                    <h3 class="app-name">Mural de Avisos</h3>
                    <span class="category-tag">Comunicação</span>
                </div>
            </a>
            <a href="https://forms.google.com/">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/Vkfm4T7j/png-transparent-g-suite-form-google-surveys-email-house-purple-violet-rectangle-removebg-preview.png" alt="Google Forms" class="app-icon">
                    </div>
                    <h3 class="app-name">Google Forms</h3>
                    <span class="category-tag">Atividades</span>
                </div>
            </a>
            <a href="https://chat.openai.com/">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/DZqM9f0m/download-4-removebg-preview.png" alt="Chat GPT" class="app-icon">
                    </div>
                    <h3 class="app-name">Chat GPT</h3>
                    <span class="category-tag">Auxílio</span>
                </div>
            </a>
        </div>
    </main>
</body>
</html>