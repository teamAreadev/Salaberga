<!-- //DEV SGTM (SALABERGA TORQUATO GOMES DE MATOS)

        S S S S S S S S
    S S S S S S S S S S
    S S S S S S S S S S S
    S S
    S S S S S S S S S S S
            S S S S S S           
                S S S S S
    S S S S S S S S S S S
    S S S S S S S S S
        S S S S S S S

        T T T T T T T T T
            T T T T
            T T T T
            T T T T
            T T T T
            T T T T
            T T T T

        G G G G G G G G
    G G G G G G G G G
    G G
    G G     G G G G G G
    G G             G G
    G G G G G G G G
        G G G G G G

        M             M
        M M         M M
        M   M     M   M
        M     M M     M
        M       M     M
        M             M
        M             M

        Qual é o seu superpoder? Talvez seja curiosidade já que você está olhando nosso código fonte.
        What’s your superpower? Perhaps it’s curiosity since you are looking at our source code. -->


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A90E2">
    <meta name="description" content="Portal do Aluno - Acesse suas atividades e recursos escolares">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/service-worker.js"></script>
    <script src="../../assets/js/acessibilidades.js"></script>
    <link rel="shortcut icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png"type="image/x-icon">
    <link rel="manifest" href="../../assets/js/manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="apple-touch-icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Portal Aluno">

    <title>Portal Aluno stgm</title>
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

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
:root {
    --background-color: #f0f7ff;
    --text-color: #333333;
    --header-color: #007A33;
    --icon-bg: #ffffff;
    --icon-shadow: rgba(0, 0, 0, 0.1);
    --accent-color: #FFA500;
    --grid-color: #e0e0e0;
    --card-bg: rgba(255, 255, 255, 0.9);
    --header-bg: rgba(255, 255, 255, 0.95);
    --mobile-nav-bg: rgba(255, 255, 255, 0.95);
    --search-bar-bg: white;
    --card-border-hover: var(--header-color);
}

@media (prefers-color-scheme: dark) {
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
    background-image:
        radial-gradient(circle at 10% 20%, rgba(52, 152, 219, 0.05) 0%, rgba(52, 152, 219, 0) 20%),
        radial-gradient(circle at 90% 80%, rgba(46, 204, 113, 0.05) 0%, rgba(46, 204, 113, 0) 20%);
    color: var(--text-color);
}

@media (max-width: 768px) {
    body {
        padding-bottom: 100px;
    }
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 2rem;
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

@media (max-width: 768px) {
    .grid-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        padding: 1rem;
    }
}

.app-card {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    backdrop-filter: blur(12px);
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.app-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transform: translateX(-100%);
    transition: 0.5s;
}

.app-card:hover::before {
    transform: translateX(100%);
}

.app-card:hover {
    transform: translateY(-5px) scale(1.02);
    border-color: var(--card-border-hover);
    box-shadow: 0 20px 30px rgba(0, 122, 51, 0.1);
}

.icon-wrapper {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: var(--icon-bg);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 8px 16px var(--icon-shadow);
}

.app-card:hover .icon-wrapper {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 12px 24px var(--icon-shadow);
}

.app-icon {
    width: 50px;
    height: 50px;
    transition: transform 0.3s ease;
}

.app-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-color);
    margin-top: 1rem;
    transition: color 0.3s ease;
}

.app-card:hover .app-name {
    color: var(--header-color);
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

.nav-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--header-color);
    transition: width 0.3s ease;
}

.nav-link:hover::after {
    width: 100%;
}

.category-tag {
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    background: rgba(0, 122, 51, 0.1);
    color: var(--header-color);
    margin-top: 0.5rem;
    display: inline-block;
}

.search-container {
    max-width: 600px;
    margin: 2rem auto;
    padding: 0 1rem;
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
    
    .icon-wrapper {
        width: 60px;
        height: 60px;
    }
    
    .app-icon {
        width: 40px;
        height: 40px;
    }
    
    .app-card {
        padding: 1rem;
    }
}

@media (max-width: 380px) {
    .grid-container {
        gap: 0.8rem;
        padding: 0.8rem;
    }
    
    .app-card {
        padding: 0.8rem;
    }
    
    .app-name {
        font-size: 0.9rem;
    }
}

.mobile-nav-enter {
    animation: slideUpNav 0.3s ease-out forwards;
}

@keyframes slideUpNav {
    from {
        transform: translate(-50%, 100%);
        opacity: 0;
    }
    to {
        transform: translate(-50%, 0);
        opacity: 1;
    }
}

.mobile-nav a {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-color);
    transition: all 0.3s ease;
}

.mobile-nav a:active {
    transform: scale(0.95);
}

.mobile-nav a:hover {
    color: var(--header-color);
}

.install-button {
    position: fixed;
    bottom: clamp(16px, 4vh, 32px); 
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    
    padding: clamp(12px, 3vw, 24px) clamp(24px, 5vw, 48px);
    min-width: min(200px, 80vw); 
    max-width: 90vw;
    
    background: linear-gradient(45deg, 
        var(--header-color), 
        var(--accent-color)
    );
    color: white;
    font-family: system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
    font-size: clamp(14px, 4vw, 16px);
    font-weight: 600;
    line-height: 1.5;
    text-align: center;
    
    border: none;
    border-radius: 9999px; 
    box-shadow: 
        0 4px 6px rgba(0, 0, 0, 0.1),
        0 2px 4px rgba(0, 0, 0, 0.06),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    
    transition: 
        transform 0.2s cubic-bezier(0.4, 0, 0.2, 1),
        box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1),
        background 0.3s ease;
    
    cursor: pointer;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    
    outline: none;
}

.install-button:hover {
    transform: translateX(-50%) translateY(-4px);
    box-shadow: 
        0 8px 12px rgba(0, 0, 0, 0.15),
        0 4px 6px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.install-button:focus-visible {
    outline: 3px solid var(--accent-color);
    outline-offset: 2px;
}

.install-button:active {
    transform: translateX(-50%) translateY(-2px);
    box-shadow: 
        0 4px 8px rgba(0, 0, 0, 0.12),
        0 2px 4px rgba(0, 0, 0, 0.08),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

@media (prefers-reduced-motion: reduce) {
    .install-button {
        transition: none;
    }
}

@media (prefers-color-scheme: dark) {
    .install-button {
        box-shadow: 
            0 4px 6px rgba(0, 0, 0, 0.3),
            0 2px 4px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
    }
}

@media (max-width: 768px) {
    .install-button {
        padding: 14px 28px;
        font-size: 15px;
    }
}
</style>
</head>

<body>
<header class="main-header">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="https://i.postimg.cc/V6SYb7P3/Design-sem-nome-15-removebg-preview.png" alt="Logo" class="h-12 w-auto object-contain">
                <div>
                    <h1 class="text-xl font-bold text-primary">
                        Portal do <span class="text-secondary">Aluno</span>
                    </h1>
                    <div class="h-0.5 bg-primary/20 rounded-full mt-1"></div>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-5">
                <a href="../../" class="nav-link">Início</a>
                <a href="suporte.html" class="nav-link">Suporte</a>

                <div class="relative">
                   <button id="accessibilityBtnDesktop" class="flex items-center gap-2 p-2 rounded-lg transition-colors duration-300" aria-expanded="false" aria-haspopup="true">
                    <i class="fa-solid fa-universal-access text-xl"></i>
                </button>

                    <div id="accessibilityMenuDesktop" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg py-2 hidden z-50" role="menu">
                        <div class="px-4 py-2 border-b" style="color: #1a1a1a;">
                            <span class="block text-sm font-semibold mb-2">Tamanho do Texto</span>
                            <div class="flex gap-2">
                                <button class="p-2 hover:bg-gray-100 rounded" aria-label="Diminuir tamanho do texto">
                                    <i class="fa-solid fa-a"></i><b>-</b>
                                </button>
                                <button class="p-2 hover:bg-gray-100 rounded" aria-label="Tamanho padrão do texto">
                                    <i class="fa-solid fa-a"></i>
                                </button>
                                <button class="p-2 hover:bg-gray-100 rounded" aria-label="Aumentar tamanho do texto">
                                    <i class="fa-solid fa-a"></i><b>+</b>
                                </button>
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
                            <button class="w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="monochrome">
                                Monocromático
                            </button>
                            <button class="w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="inverted-grayscale">
                                Escala de cinza invertida
                            </button>
                            <button class="w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="inverted-color">
                                Cor invertida
                            </button>
                            <button class="w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="original">
                                Cores originais
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 cursor-pointer">
                    <div class="relative">
                        <img src="https://i.postimg.cc/m2d5f5L3/images-removebg-preview.png" alt="Perfil" class="w-10 h-10 rounded-full border-2 border-transparent hover:border-secondary transition-colors duration-300">
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white">
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-700 hover:text-primary transition-colors duration-300">
                        <a href="../autenticação/perfil.php">Meu Perfil</a>
                    </span>
                </div>
            </nav>

            <div class="md:hidden">
                <div class="relative">
                    <img src="https://i.postimg.cc/m2d5f5L3/images-removebg-preview.png" alt="Perfil" class="w-10 h-10 rounded-full border-2 border-transparent hover:border-secondary transition-colors duration-300">
                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white">
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<nav class="mobile-nav md:hidden">
    <div class="flex justify-around items-center">
        <a href="../../" class="nav-link">
            <i class="fa-solid fa-home text-xl"></i>
            <span class="text-xs">Início</span>
        </a>

        <div class="relative">
            <button id="accessibilityBtnMobile" class="nav-link flex flex-col items-center">
                <i class="fa-solid fa-universal-access text-xl"></i>
                <span class="text-xs">Acessibilidade</span>
            </button>

            <div id="accessibilityMenuMobile" class="menu-base bottom-24 hidden">
                <div class="px-4 py-2 border-b" style="color: #1a1a1a;">
                    <span class="block text-sm font-semibold mb-2">Tamanho do Texto</span>
                    <div class="flex gap-2">
                        <button class="p-2 hover:bg-gray-100 rounded" aria-label="Diminuir tamanho do texto">
                            <i class="fa-solid fa-a"></i><b>-</b>
                        </button>
                        <button class="p-2 hover:bg-gray-100 rounded" aria-label="Tamanho padrão do texto">
                            <i class="fa-solid fa-a"></i>
                        </button>
                        <button class="p-2 hover:bg-gray-100 rounded" aria-label="Aumentar tamanho do texto">
                            <i class="fa-solid fa-a"></i><b>+</b>
                        </button>
                    </div>
                </div>

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
                    <button class="w-full px-4 py-3 text-left hover:bg-gray-100" data-theme="monochrome">
                        Monocromático
                    </button>
                    <button class="w-full px-4 py-3 text-left hover:bg-gray-100" data-theme="inverted-grayscale">
                        Escala de cinza invertida
                    </button>
                    <button class="w-full px-4 py-3 text-left hover:bg-gray-100" data-theme="inverted-color">
                        Cor invertida
                    </button>
                    <button class="w-full px-4 py-3 text-left hover:bg-gray-100" data-theme="original">
                        Cores originais
                    </button>
                </div>
            </div>
        </div>

        <a href="suporte.html" class="nav-link">
            <i class="fa-solid fa-headset text-xl"></i>
            <span class="text-xs">Suporte</span>
        </a>
    </div>

    <div id="menuOverlay" class="menu-overlay"></div>
</nav>

<style>
    .mobile-nav {
        transition: transform 0.3s ease-in-out;
    }

    #accessibilityMenuMobile,
    #themeMenuMobile {
        transition: all 0.3s ease-in-out;
        max-height: 80vh;
        overflow-y: auto;
    }

    .menu-base {
        position: fixed;
        left: 1rem;
        right: 1rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 50;
    }

    .menu-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
        pointer-events: none;
        z-index: 40;
    }

    .menu-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos Mobile
    const accessibilityBtnMobile = document.getElementById('accessibilityBtnMobile');
    const accessibilityMenuMobile = document.getElementById('accessibilityMenuMobile');
    const themeBtnMobile = document.getElementById('themeBtnMobile');
    const themeMenuMobile = document.getElementById('themeMenuMobile');
    const backToMainMenu = document.getElementById('backToMainMenu');
    const menuOverlay = document.getElementById('menuOverlay');

    // Elementos Desktop
    const accessibilityBtnDesktop = document.getElementById('accessibilityBtnDesktop');
    const accessibilityMenuDesktop = document.getElementById('accessibilityMenuDesktop');
    const themeBtnDesktop = document.getElementById('themeBtnDesktop');
    const themeMenuDesktop = document.getElementById('themeMenuDesktop');
    const backToMainMenuDesktop = document.getElementById('backToMainMenuDesktop');

    // Funções auxiliares
    function showOverlay() {
        menuOverlay.classList.add('active');
    }

    function hideOverlay() {
        menuOverlay.classList.remove('active');
    }

    function closeAllMenus() {
        // Mobile
        accessibilityMenuMobile?.classList.add('hidden');
        themeMenuMobile?.classList.add('hidden');
        hideOverlay();
        
        // Desktop
        accessibilityMenuDesktop?.classList.add('hidden');
        themeMenuDesktop?.classList.add('hidden');
    }

    // Mobile Event Listeners
    accessibilityBtnMobile?.addEventListener('click', function(e) {
        e.stopPropagation();
        const isHidden = accessibilityMenuMobile.classList.contains('hidden');
        if (isHidden) {
            closeAllMenus();
            accessibilityMenuMobile.classList.remove('hidden');
            showOverlay();
        } else {
            closeAllMenus();
        }
    });

    themeBtnMobile?.addEventListener('click', function(e) {
        e.stopPropagation();
        accessibilityMenuMobile.classList.add('hidden');
        themeMenuMobile.classList.remove('hidden');
    });

    backToMainMenu?.addEventListener('click', function(e) {
        e.stopPropagation();
        themeMenuMobile.classList.add('hidden');
        accessibilityMenuMobile.classList.remove('hidden');
    });

        // Desktop Event Listeners (continuação)
    accessibilityBtnDesktop?.addEventListener('click', function(e) {
        e.stopPropagation();
        const isHidden = accessibilityMenuDesktop.classList.contains('hidden');
        if (isHidden) {
            closeAllMenus();
            accessibilityMenuDesktop.classList.remove('hidden');
        } else {
            closeAllMenus();
        }
    });

    themeBtnDesktop?.addEventListener('click', function(e) {
        e.stopPropagation();
        accessibilityMenuDesktop.classList.add('hidden');
        themeMenuDesktop.classList.remove('hidden');
    });

    backToMainMenuDesktop?.addEventListener('click', function(e) {
        e.stopPropagation();
        themeMenuDesktop.classList.add('hidden');
        accessibilityMenuDesktop.classList.remove('hidden');
    });

    // Overlay click handler
    menuOverlay?.addEventListener('click', closeAllMenus);

    // Document click handler para fechar menus ao clicar fora
    document.addEventListener('click', function(e) {
        const isClickInsideAccessibilityMobile = 
            accessibilityMenuMobile?.contains(e.target) || 
            themeMenuMobile?.contains(e.target) || 
            accessibilityBtnMobile?.contains(e.target);

        const isClickInsideAccessibilityDesktop = 
            accessibilityMenuDesktop?.contains(e.target) || 
            themeMenuDesktop?.contains(e.target) || 
            accessibilityBtnDesktop?.contains(e.target);

        if (!isClickInsideAccessibilityMobile && !isClickInsideAccessibilityDesktop) {
            closeAllMenus();
        }
    });

    // Prevenir que cliques dentro dos menus os fechem
    [accessibilityMenuMobile, themeMenuMobile, accessibilityMenuDesktop, themeMenuDesktop].forEach(menu => {
        menu?.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    // Implementação dos temas (exemplo)
    const themeButtons = document.querySelectorAll('[data-theme]');
    themeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const theme = this.dataset.theme;
            // Implementar a lógica de mudança de tema aqui
            console.log('Tema selecionado:', theme);
            closeAllMenus();
        });
    });
});
</script>
    <!-- Barra de Pesquisa -->
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Buscar aplicativos..." id="search-input">
    </div>
    <!-- Grid de Apps -->
    <main class="container mx-auto px-4">
        <div class="grid-container">
            <!-- Portal STGM -->
            <a href="https://salaberga.com" target="_blank">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/8czCMpqx/Design-sem-nome-70-removebg-preview.png"
                            alt="Portal STGM" class="app-icon">
                    </div>
                    <h3 class="app-name">Portal STGM</h3>
                    <span class="category-tag">Sistema</span>
                </div>
            </a>

            <a href="https://aluno.seduc.ce.gov.br/">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://aluno.seduc.ce.gov.br/assets/icons/icon-512x512.png" alt="Aluno Online"
                            class="app-icon">
                    </div>
                    <h3 class="app-name">Aluno Online</h3>
                    <span class="category-tag">Portal</span>
                </div>
            </a>

            <!-- Google Classroom -->
            <a href="https://classroom.google.com/">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/BQNdZvgK/image-1599078642807-removebg-preview.png"
                            alt="Google Classroom" class="app-icon">
                    </div>
                    <h3 class="app-name">Google Classroom</h3>
                    <span class="category-tag">Aulas</span>
                </div>
            </a>

            <!-- Biblioteca Digital -->
            <a href="https://biblioteca.seduc.ce.gov.br/">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://play-lh.googleusercontent.com/t5OlleFEJuJ82Q9rIG479b5NUCGxl8DDn6h2Vqw8iBRYTOR9TbZtPrQpLVCO-MoW794" alt="Biblioteca Digital"
                            class="app-icon">
                    </div>
                    <h3 class="app-name">Biblioteca Digital</h3>
                    <span class="category-tag">Estudos</span>
                </div>
            </a>

            <!-- Boletim -->
            <a href="suporte.html">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://w7.pngwing.com/pngs/702/888/png-transparent-customer-service-technical-support-computer-icons-cabin-miscellaneous-service-photography-thumbnail.png" alt="Boletim" class="app-icon">
                    </div>
                    <h3 class="app-name">Suporte teste</h3>
                    <span class="category-tag">Teste</span>
                </div>
            </a>

            <!-- Calendário Escolar -->
            <a href="https://calendario.seduc.ce.gov.br">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://cdn.iconscout.com/icon/free/png-256/free-google-calendar-logo-icon-download-in-svg-png-gif-file-formats--workspace-redesign-logos-icons-2416655.png?f=webp" alt="Calendário" class="app-icon">
                    </div>
                    <h3 class="app-name">Calendário</h3>
                    <span class="category-tag">Agenda</span>
                </div>
            </a>

            <!-- Material Didático -->
            <a href="https://material.seduc.ce.gov.br">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://acode.foxdebug.com/plugin-icon/sebastianjnuwu.material.icons" alt="Material Didático" class="app-icon">
                    </div>
                    <h3 class="app-name">Material Didático</h3>
                    <span class="category-tag">Estudos</span>
                </div>
            </a>

            <!-- Mural de Avisos -->
            <a href="https://mural.seduc.ce.gov.br">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/CMX7vRKh/aviso-1.png" alt="Mural de Avisos" class="app-icon">
                    </div>
                    <h3 class="app-name">Mural de Avisos</h3>
                    <span class="category-tag">Comunicação</span>
                </div>
            </a>

            <!-- Google Forms -->
            <a href="https://forms.google.com/">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/Vkfm4T7j/png-transparent-g-suite-form-google-surveys-email-house-purple-violet-rectangle-removebg-preview.png"
                            alt="Google Forms" class="app-icon">
                    </div>
                    <h3 class="app-name">Google Forms</h3>
                    <span class="category-tag">Atividades</span>
                </div>
            </a>

            <!-- Chat GPT -->
            <a href="https://chat.openai.com/">
                <div class="app-card">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/DZqM9f0m/download-4-removebg-preview.png" alt="Chat GPT"
                            class="app-icon">
                    </div>
                    <h3 class="app-name">Chat GPT</h3>
                    <span class="category-tag">Auxílio</span>
                </div>
            </a>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Header Scroll Effect
            const header = document.querySelector('.main-header');
            const mobileNav = document.querySelector('.mobile-nav');
            let lastScroll = 0;

            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;

                if (currentScroll > lastScroll && currentScroll > 100) {
                    header.classList.add('scrolled');
                    mobileNav.style.transform = 'translate(-50%, 100%)';
                } else {
                    header.classList.remove('scrolled');
                    mobileNav.style.transform = 'translate(-50%, 0)';
                }

                lastScroll = currentScroll;
            });

            // Search Functionality
            const searchInput = document.getElementById('search-input');
            const appCards = document.querySelectorAll('.app-card');

            searchInput.addEventListener('input', function (e) {
                const searchTerm = e.target.value.toLowerCase();

                appCards.forEach(card => {
                    const appName = card.querySelector('.app-name').textContent.toLowerCase();
                    const category = card.querySelector('.category-tag').textContent.toLowerCase();

                    if (appName.includes(searchTerm) || category.includes(searchTerm)) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.3s ease';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // App Card Click Animation
            appCards.forEach(card => {
                card.addEventListener('click', function () {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Mobile Nav Animation
            const mobileNavLinks = document.querySelectorAll('.mobile-nav a');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Remove active class from all links
                    mobileNavLinks.forEach(l => l.classList.remove('text-primary'));

                    // Add active class to clicked link
                    this.classList.add('text-primary');

                    // Add click animation
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Animação de entrada dos cards
            const animateCards = () => {
                appCards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        card.style.transition = 'all 0.3s ease-out';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            };

            // Executar animação quando a página carregar
            animateCards();

            // Adicionar efeito de hover nos cards
            appCards.forEach(card => {
                card.addEventListener('mouseenter', function () {
                    const icon = this.querySelector('.icon-wrapper');
                    icon.style.transform = 'scale(1.1) rotate(5deg)';
                });

                card.addEventListener('mouseleave', function () {
                    const icon = this.querySelector('.icon-wrapper');
                    icon.style.transform = 'scale(1) rotate(0)';
                });
            });

            // Detectar modo escuro do sistema
            const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

            function handleDarkMode(e) {
                if (e.matches) {
                    document.body.classList.add('dark-mode');
                } else {
                    document.body.classList.remove('dark-mode');
                }
            }

            prefersDarkScheme.addListener(handleDarkMode);
            handleDarkMode(prefersDarkScheme);

            // Smooth scroll para links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Adicionar indicador de loading
            const showLoading = () => {
                const loading = document.createElement('div');
                loading.className = 'loading-indicator';
                document.body.appendChild(loading);

                setTimeout(() => {
                    loading.remove();
                }, 1000);
            };

            // Simular loading ao clicar nos cards
            appCards.forEach(card => {
                card.addEventListener('click', showLoading);
            });
        });
    </script>
</body>

</html>