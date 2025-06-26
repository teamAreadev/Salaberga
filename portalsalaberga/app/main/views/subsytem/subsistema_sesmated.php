<?php
require_once('../../models/sessions.php');
$session = new sessions();
$session->autenticar_session();

if (isset($_GET['sair'])) {
    $session->quebra_session();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A90E2">
    <meta name="description" content="Portal do Professores - Acesse suas atividades e recursos escolares">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/service-worker.js"></script>
    <script src="../../assets/js/acessibilidades.js"></script>
    <link rel=" icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">

    <link rel="manifest" href="../../assets/js/manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="apple-touch-icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Portal Professores">

    <title>Subsistema SESMATED - STGM</title>
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

    .dark {
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



    .grid-container.transitioning {
        transition: all 0.3s ease-out;
    }

    .app-card-link {
        transition: all 0.3s ease-out;
        width: 100%;
    }

    @media (max-width: 768px) {
        .grid-container {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            padding: 1rem;
        }

        .app-card {
            min-height: 150px;
            padding: 1rem;
        }
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
        transition: all 0.3s ease-out;
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
        height: 100%;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
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

    .clear-search:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
    }


    .search-container {
        position: relative;
        max-width: 500px;
        margin: 0 auto;
    }

    .app-card-link {
        transition: all 0.3s ease-out;
    }

    .transitioning {
        pointer-events: none;
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
        background: linear-gradient(45deg, var(--header-color), var(--accent-color));
        color: white;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
        font-size: clamp(14px, 4vw, 16px);
        font-weight: 600;
        line-height: 1.5;
        text-align: center;
        border: none;
        border-radius: 9999px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1), background 0.3s ease;
        cursor: pointer;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
        outline: none;
    }

    .install-button:hover {
        transform: translateX(-50%) translateY(-4px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15), 0 4px 6px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .install-button:focus-visible {
        outline: 3px solid var(--accent-color);
        outline-offset: 2px;
    }

    .install-button:active {
        transform: translateX(-50%) translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12), 0 2px 4px rgba(0, 0, 0, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    @media (prefers-reduced-motion: reduce) {
        .install-button {
            transition: none;
        }
    }

    @media (prefers-color-scheme: dark) {
        .install-button {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3), 0 2px 4px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.05);
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

<body class="select-none">
    <noscript>
        <div class="fixed inset-0 bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center z-50">
            <div
                class="bg-white p-6 rounded-lg shadow-2xl border border-red-300 max-w-md w-full mx-4 text-center animate-pulse">
                <h1 class="text-2xl font-bold text-red-600 mb-4">Atenção!</h1>
                <p class="text-lg text-gray-800 mb-4">Este site requer JavaScript para funcionar corretamente.</p>
                <p class="text-md text-gray-600 mb-6">Por favor, ative o JavaScript no seu navegador para acessar todas
                    as funcionalidades do Portal do Aluno, como navegação interativa, modo escuro e acessibilidade.</p>
                <div class="flex justify-center gap-4">
                    <a href="https://www.enable-javascript.com/pt/" target="_blank"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">Como
                        Ativar JavaScript</a>
                    <button onclick="window.location.reload()"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">Recarregar
                        Página</button>
                </div>
                <p class="text-sm text-gray-500 mt-4">Se o problema persistir, entre em contato com o suporte.</p>
            </div>
        </div>
    </noscript>
    <header class="main-header">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo"
                        class="h-12 w-auto object-contain">
                    <div>
                        <h1 class="md:text-xl lg:text-lg font-bold text-primary">Subsistema Avaliadores <span class="text-secondary">SESMATED</span></h1>
                        <div class="h-0.5 bg-primary/20 rounded-full mt-1"></div>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-5">
                    <a href="../../" class="nav-link">Início</a>
                    <a href="./subsistema.php?sair" class="nav-link">Sair</a>
                    <button id="darkModeToggle"
                        class="inline-flex items-center justify-center p-2 rounded-lg transition-colors" role="switch"
                        aria-label="Alternar modo escuro">
                        <svg class="w-5 h-5 sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="w-5 h-5 moon-icon hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <span class="sr-only">Alternar modo escuro</span>
                    </button>

                    <div class="relative">
                        <button id="accessibilityBtnDesktop"
                            class="flex items-center gap-2 p-2 rounded-lg transition-colors duration-300"
                            aria-expanded="false" aria-haspopup="true">
                            <i class="fa-solid fa-universal-access text-xl"></i>
                        </button>

                        <div id="accessibilityMenuDesktop"
                            class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg py-2 hidden z-50"
                            role="menu">
                            <div class="px-4 py-2 border-b" style="color: #1a1a1a;">
                                <span class="block text-sm font-semibold mb-2">Tamanho do Texto</span>
                                <div class="flex gap-2">
                                    <button class="p-2 hover:bg-gray-100 rounded"
                                        aria-label="Diminuir tamanho do texto"><i
                                            class="fa-solid fa-a"></i><b>-</b></button>
                                    <button class="p-2 hover:bg-gray-100 rounded"
                                        aria-label="Tamanho padrão do texto"><i class="fa-solid fa-a"></i></button>
                                    <button class="p-2 hover:bg-gray-100 rounded"
                                        aria-label="Aumentar tamanho do texto"><i
                                            class="fa-solid fa-a"></i><b>+</b></button>
                                </div>
                            </div>

                            <button class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center gap-2"
                                style="color: #1a1a1a;">
                                <i class="fa-solid fa-ear-listen"></i>
                                <span>Leitor de Tela</span>
                            </button>

                            <button id="themeBtnDesktop"
                                class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center justify-between"
                                style="color: #1a1a1a;">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-half-stroke"></i>
                                    <span>Temas de Contraste</span>
                                </div>
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>

                        <div id="themeMenuDesktop"
                            class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg py-2 hidden z-50">
                            <div class="flex items-center px-4 py-2 border-b">
                                <button id="backToMainMenuDesktop" class="mr-2" style="color: #1a1a1a;">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </button>
                                <span class="font-semibold">Temas de Contraste</span>
                            </div>

                            <div class="py-2" style="color: #1a1a1a;">
                                <button class="w-full px-4 py-2 text-left hover:bg-gray-100"
                                    data-theme="monochrome">Monocromático</button>
                                <button class="w-full px-4 py-2 text-left hover:bg-gray-100"
                                    data-theme="inverted-grayscale">Escala de cinza invertida</button>
                                <button class="w-full px-4 py-2 text-left hover:bg-gray-100"
                                    data-theme="inverted-color">Cor invertida</button>
                                <button class="w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="original">Cores
                                    originais</button>
                            </div>
                        </div>
                    </div>
                    <!-- Profile dropdown placeholder -->
                </nav>

                <div class="md:hidden">
                    <!-- Mobile profile placeholder -->
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
            <a href="./subsistema.php?sair" class="nav-link">
                <i class="fa-solid fa-sign-out-alt text-xl"></i>
                <span class="text-xs">Sair</span>
            </a>
            <div class="relative">
                <button id="accessibilityBtnMobile" class="nav-link flex flex-col items-center">
                    <i class="fa-solid fa-universal-access text-xl"></i>
                    <span class="text-xs">Acessibilidade</span>
                </button>

                <div id="accessibilityMenuMobile" class="menu-base bottom-24 hidden">
                    <button class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center gap-2"
                        style="color: #1a1a1a;">
                        <i class="fa-solid fa-ear-listen"></i>
                        <span>Leitor de Tela</span>
                    </button>
                    <div class="relative">
                        <button id="themeBtnMobile"
                            class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center justify-between"
                            style="color: #1a1a1a;">
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
                        <button class="w-full px-4 py-3 text-left hover:bg-gray-100"
                            data-theme="monochrome">Monocromático</button>
                        <button class="w-full px-4 py-3 text-left hover:bg-gray-100"
                            data-theme="inverted-grayscale">Escala de cinza invertida</button>
                        <button class="w-full px-4 py-3 text-left hover:bg-gray-100" data-theme="inverted-color">Cor
                            invertida</button>
                        <button class="w-full px-4 py-3 text-left hover:bg-gray-100" data-theme="original">Cores
                            originais</button>
                    </div>
                </div>
            </div>
            <button id="darkModeToggleMobile" class="nav-link flex flex-col items-center">
                <svg class="w-6 h-6 sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg class="w-6 h-6 moon-icon hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <span class="text-xs sr-only">Alternar modo escuro</span>
                <span class="text-xs">Tema</span>
            </button>
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
            const darkModeToggle = document.getElementById('darkModeToggle');
            const darkModeToggleMobile = document.getElementById('darkModeToggleMobile');
            const sunIcon = darkModeToggle.querySelector('.sun-icon');
            const moonIcon = darkModeToggle.querySelector('.moon-icon');
            const sunIconMobile = darkModeToggleMobile.querySelector('.sun-icon');
            const moonIconMobile = darkModeToggleMobile.querySelector('.moon-icon');
            const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

            function updateIcons(isDark) {
                if (isDark) {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                    sunIconMobile.classList.add('hidden');
                    moonIconMobile.classList.remove('hidden');
                } else {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                    sunIconMobile.classList.remove('hidden');
                    moonIconMobile.classList.add('hidden');
                }
            }

            function updateDarkMode(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.removeItem('theme');
                }
                updateIcons(isDark);
            }

            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                updateDarkMode(savedTheme === 'dark');
            } else {
                updateDarkMode(prefersDarkScheme.matches);
            }

            prefersDarkScheme.addListener((e) => {
                if (!localStorage.getItem('theme')) {
                    updateDarkMode(e.matches);
                }
            });

            [darkModeToggle, darkModeToggleMobile].forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const isDark = !document.documentElement.classList.contains('dark');
                    updateDarkMode(isDark);
                });
            });

            const accessibilityBtnMobile = document.getElementById('accessibilityBtnMobile');
            const accessibilityMenuMobile = document.getElementById('accessibilityMenuMobile');
            const themeBtnMobile = document.getElementById('themeBtnMobile');
            const themeMenuMobile = document.getElementById('themeMenuMobile');
            const backToMainMenu = document.getElementById('backToMainMenu');
            const menuOverlay = document.getElementById('menuOverlay');

            const accessibilityBtnDesktop = document.getElementById('accessibilityBtnDesktop');
            const accessibilityMenuDesktop = document.getElementById('accessibilityMenuDesktop');
            const themeBtnDesktop = document.getElementById('themeBtnDesktop');
            const themeMenuDesktop = document.getElementById('themeMenuDesktop');
            const backToMainMenuDesktop = document.getElementById('backToMainMenuDesktop');

            function showOverlay() {
                menuOverlay.classList.add('active');
            }

            function hideOverlay() {
                menuOverlay.classList.remove('active');
            }

            function closeAllMenus() {
                accessibilityMenuMobile?.classList.add('hidden');
                themeMenuMobile?.classList.add('hidden');
                hideOverlay();

                accessibilityMenuDesktop?.classList.add('hidden');
                themeMenuDesktop?.classList.add('hidden');
            }

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

            menuOverlay?.addEventListener('click', closeAllMenus);

            document.addEventListener('click', function(e) {
                const isClickInsideAccessibilityMobile = accessibilityMenuMobile?.contains(e.target) || themeMenuMobile?.contains(e.target) || accessibilityBtnMobile?.contains(e.target);
                const isClickInsideAccessibilityDesktop = accessibilityMenuDesktop?.contains(e.target) || themeMenuDesktop?.contains(e.target) || accessibilityBtnDesktop?.contains(e.target);

                if (!isClickInsideAccessibilityMobile && !isClickInsideAccessibilityDesktop) {
                    closeAllMenus();
                }
            });

            [accessibilityMenuMobile, themeMenuMobile, accessibilityMenuDesktop, themeMenuDesktop].forEach(menu => {
                menu?.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            const themeButtons = document.querySelectorAll('[data-theme]');
            themeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const theme = this.dataset.theme;
                    closeAllMenus();
                });
            });

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
            const searchInput = document.getElementById('search-input');
            const appCardLinks = document.querySelectorAll('.grid-container a'); // Select the anchor tags
            const gridContainer = document.querySelector('.grid-container');

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                let visibleCards = [];
                let hiddenCards = [];

                if (searchTerm === '') {
                    showAllCards();
                    return;
                }

                appCardLinks.forEach(cardLink => { // Iterate through anchor tags
                    const appName = cardLink.querySelector('.app-name').textContent.toLowerCase();
                    const category = cardLink.querySelector('.category-tag').textContent.toLowerCase();

                    if (appName.includes(searchTerm) || category.includes(searchTerm)) {
                        visibleCards.push(cardLink);
                        cardLink.style.display = 'block';
                        setTimeout(() => {
                            cardLink.style.opacity = '1';
                            cardLink.style.transform = 'scale(1)';
                        }, 50);
                    } else {
                        hiddenCards.push(cardLink);
                        cardLink.style.opacity = '0';
                        cardLink.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            cardLink.style.display = 'none';
                        }, 300);
                    }
                });
            });

            function showAllCards() {
                // This function needs to operate on the existing rendered cards
                appCardLinks.forEach((cardLink, index) => {
                    cardLink.style.display = 'block';
                    setTimeout(() => {
                        cardLink.style.opacity = '1';
                        cardLink.style.transform = 'scale(1)';
                    }, index * 50); // Animate back in
                });
            }

            searchInput.addEventListener('search', function() {
                if (this.value === '') {
                    showAllCards();
                }
            });

            const clearButton = document.createElement('button');
            clearButton.textContent = '';
            clearButton.classList.add('clear-search');
            clearButton.style.display = 'none';

            searchInput.parentElement.appendChild(clearButton);

            clearButton.addEventListener('click', () => {
                searchInput.value = '';
                showAllCards();
                clearButton.style.display = 'none';
            });

            searchInput.addEventListener('input', function() {
                clearButton.style.display = this.value ? 'block' : 'none';
            });

            const mobileNavLinks = document.querySelectorAll('.mobile-nav a');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Prevent default only if you are handling navigation via JS or forms
                    // e.preventDefault(); // Uncomment if needed

                    mobileNavLinks.forEach(l => l.classList.remove('text-primary'));
                    this.classList.add('text-primary');

                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Card animation only on initial load
            const animateCards = () => {
                const initialAppCardLinks = document.querySelectorAll('.grid-container a'); // Select the links
                initialAppCardLinks.forEach((cardLink, index) => { // Iterate through links
                    cardLink.style.opacity = '0';
                    cardLink.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        cardLink.style.transition = 'all 0.3s ease-out';
                        cardLink.style.opacity = '1';
                        cardLink.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            };

            animateCards(); // Run animation on page load

            // Add event listeners to the .app-card element inside the link
            document.querySelectorAll('.app-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    const icon = this.querySelector('.icon-wrapper');
                    icon.style.transform = 'scale(1.1) rotate(5deg)';
                });

                card.addEventListener('mouseleave', function() {
                    const icon = this.querySelector('.icon-wrapper');
                    icon.style.transform = 'scale(1) rotate(0)';
                });
            });


            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
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

            const showLoading = () => {
                const loading = document.createElement('div');
                loading.className = 'loading-indicator'; // You'd need CSS for this class
                document.body.appendChild(loading);

                // Example: remove loading indicator after a delay (or on page load complete)
                // This might need to be tied to actual page load for dynamic content
                setTimeout(() => {
                    loading.remove();
                }, 1000); // Adjust as needed
            };

            // Add click listener to the anchor tags for loading indicator
            document.querySelectorAll('.grid-container a').forEach(link => {
                link.addEventListener('click', showLoading);
            });

        });
    </script>
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Buscar aplicativos..." id="search-input">
    </div>
    <main class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-8 md:gap-8 p-4 md:p-8 max-w-[1400px] mx-auto transition-all duration-300 grid-container">

            <a href="../../../subsystems/sesmated/views/abertura.php" class="app-card-link" data-card-key="Dashboard_abertura">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/sDLfn46k/dashboard-removebg-preview.png" alt="Dashboard abertura" class="app-icon">
                    </div>
                    <h3 class="app-name">Abertura</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/cordel.php" class="app-card-link" data-card-key="Cordel">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/YS6pCKr7/cordell-removebg-preview.png" alt="Cordel" class="app-icon">
                    </div>
                    <h3 class="app-name">Cordel</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/Empreendedorismo.php" class="app-card-link" data-card-key="Empreendedorismo">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/j2sCbqPB/emopreendedorismo-removebg-preview.png" alt="Empreendedorismo" class="app-icon">
                    </div>
                    <h3 class="app-name">Empreendedorismo</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/esquete.php" class="app-card-link" data-card-key="Esquete">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/ZqxSh8HK/esquete-removebg-preview.png" alt="Esquete" class="app-icon">
                    </div>
                    <h3 class="app-name">Esquete</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/logo.php" class="app-card-link" data-card-key="Logo">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/Y92w2vDN/logo-removebg-preview-1.png" alt="Logo" class="app-icon">
                    </div>
                    <h3 class="app-name">Logo</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/mascote.php" class="app-card-link" data-card-key="Mascote">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/SRJF8whJ/mawcote-removebg-preview.png" alt="Mascote" class="app-icon">
                    </div>
                    <h3 class="app-name">Mascote</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/Painel.php" class="app-card-link" data-card-key="Painel_26">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/ZqZGj9mk/painel-removebg-preview.png" alt="Painel" class="app-icon">
                    </div>
                    <h3 class="app-name">Painel</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/frequencia/index.php" class="app-card-link" data-card-key="Palestras">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/qRv9V9gj/palestras-removebg-preview.png" alt="Palestras" class="app-icon">
                    </div>
                    <h3 class="app-name">Palestras</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>

            <a href="../../../subsystems/sesmated/views/frequencia/index.php" class="app-card-link" data-card-key="Workshop">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/qRv9V9gj/palestras-removebg-preview.png" alt="Workshop" class="app-icon">
                    </div>
                    <h3 class="app-name">Workshop</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/parodia.php" class="app-card-link" data-card-key="Paródia">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/NMyv23YL/parodia-removebg-preview.png" alt="Paródia" class="app-icon">
                    </div>
                    <h3 class="app-name">Paródia</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/rifa.php" class="app-card-link" data-card-key="Rifa">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src=" https://i.postimg.cc/MprBmBVH/rifa-removebg-preview.png " alt="Rifa" class="app-icon">
                    </div>
                    <h3 class="app-name">Rifa</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/Sala_Tematica.php" class="app-card-link" data-card-key="Sala_temática">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/sgKk6jgv/sala-tematica-removebg-preview.png" alt="Sala temática" class="app-icon">
                    </div>
                    <h3 class="app-name">Sala temática</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>
            <a href="../../../subsystems/sesmated/views/" class="app-card-link" data-card-key="Vestimentas">
                <div class="app-card w-{100px} h-full">
                    <div class="icon-wrapper">
                        <img src="https://i.postimg.cc/LscNvwLJ/vestimenstas-removebg-preview.png" alt="Vestimentas" class="app-icon">
                    </div>
                    <h3 class="app-name">Vestimentas</h3>
                    <span class="category-tag">Evento</span>
                </div>
            </a>

        </div>
    </main>

    <script>
        // Função para formatar datas e horários
        function mostrarCardsPorDataEHora() {
            const agora = new Date();
            const dia = agora.getDate();
            const mes = agora.getMonth() + 1; // Janeiro = 0
            const hora = agora.getHours();
            const minuto = agora.getMinutes();

            // Esconde todos os cards primeiro
            document.querySelectorAll('.app-card-link').forEach(card => {
                card.style.display = 'none';
            });

            // Função auxiliar para mostrar cards por chave
            function mostrarPorChaves(chaves) {
                chaves.forEach(key => {
                    const card = document.querySelector('.app-card-link[data-card-key="' + key + '"]');
                    if (card) card.style.display = 'block';
                });
            }

            // 24/06
            if (dia === 24 && mes === 6) {
                mostrarPorChaves(['Palestras', 'Rifa', 'Empreendedorismo']);
            }
            // 25/06
            else if (dia === 25 && mes === 6) {
                // Das 8h às 12h
                if (hora >= 8 && hora < 12) {
                    mostrarPorChaves(['Workshop']);
                }
                // Das 13:30 às 17h
                else if ((hora === 13 && minuto >= 30) || (hora > 13 && hora < 17)) {
                    mostrarPorChaves(['Dashboard_abertura', 'Rifa']);
                }
            }
            // 26/06
            else if (dia === 26 && mes === 6) {
                // Das 8h às 12h
                if (hora >= 8 && hora < 12) {
                    mostrarPorChaves(['Empreendedorismo', 'Sala_temática', 'Painel_26', 'Esquete']);
                }
            }
            // 27/06
            else if (dia === 27 && mes === 6) {
                mostrarPorChaves(['Sala_temática']);
            }
        }

        // Executa ao carregar a página
        mostrarCardsPorDataEHora();
        // Atualiza a cada minuto
        setInterval(mostrarCardsPorDataEHora, 60000);
    </script>
</body>

</html>