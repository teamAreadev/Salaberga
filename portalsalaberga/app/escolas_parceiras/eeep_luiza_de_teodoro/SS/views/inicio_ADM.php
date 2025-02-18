<?php
require_once('../controllers/controller_sessao/autenticar_sessao.php');
require_once('../controllers/controller_sessao/verificar_sessao.php');
verificarSessao(600);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SS - Salaberga Seleciona </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../assets/theme/js/modal.js"></script>
    <script src="../assets/theme/js/sidebar.js"></script>
    <link rel="shortcut icon" href="../../SS/assets/images/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ceara-green': '#008C45',
                        'ceara-orange': '#FFA500',
                        'ceara-white': '#FFFFFF',
                        primary: '#4CAF50',
                        secondary: '#FFB74D',
                    }
                }
            }
        }
    </script>
    <?php if (isset($_GET['delete']) && $_GET['delete'] == 'erro') { ?>
        <script>
            window.alert('senha incorreta');
        </script>
    <?php } ?>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == '1') { ?>
        <script>
            window.alert('ID não existe ou está incorreto.');
        </script>
    <?php } ?>
    <style>
        :root {
            --ceara-green: #008C45;
            --ceara-green-dark: #004d00;
            --ceara-orange: #FFA500;
            --ceara-white: #ffffff;
            --gray-600: #666666;
            --gray-dark: #333333;
            --shadow-sm: 0 4px 8px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.15);
            --transition-timing: cubic-bezier(0.4, 0, 0.2, 1);
            --transition-duration: 0.4s;
            --hover-scale: 1.02;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
        }

        html {
            height: 100%;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        .header-main {
            background-color: var(--ceara-white);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 50;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 4rem;
        }

        /* Logo Styles */
        .logo-container {
            display: flex;
            align-items: center;
        }

        /* Navigation Styles */
        nav ul {
            display: flex;
            gap: 1rem;
            list-style: none;
        }

        .button {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            color: var(--ceara-white);
            transition: all var(--transition-duration) var(--transition-timing);
        }

        .button:hover {
            transform: scale(var(--hover-scale));
        }

        .button-update {
            background-color: var(--ceara-orange);
        }

        .button-reports {
            background-color: var(--ceara-green-dark);
        }

        .button-results {
            background-color: var(--gray-600);
        }

        .button-exit {
            background-color: #dc2626;
        }

        /* Main Content Styles */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }

        .course-card {
            background-color: var(--ceara-white);
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            text-align: center;
            transition: transform var(--transition-duration) var(--transition-timing);
        }

        .course-card:hover {
            transform: scale(var(--hover-scale));
        }

        .course-card h3 {
            margin-bottom: 1rem;
            color: var(--gray-dark);
        }

        .card-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .card-buttons .button {
            width: 100%;
        }

        /* Course-specific colors */
        .enfermagem .button {
            background-color: #dc2626;
        }

        .informatica .button {
            background-color: #2563eb;
        }

        .administracao .button {
            background-color: #16a34a;
        }

        .edificacoes .button {
            background-color: #d97706;
        }

        /* Footer Styles */
        footer {
            background-color: var(--ceara-green);
            color: var(--ceara-white);
            padding: 2rem 0;
            margin-top: auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .footer-section h4 {
            margin-bottom: 1rem;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
        }

        .social-icon {
            color: var(--ceara-white);
            text-decoration: none;
            font-size: 1.5rem;
            transition: color var(--transition-duration) var(--transition-timing);
        }

        .social-icon:hover {
            color: var(--ceara-orange);
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }


        .modal-content {
            background-color: var(--ceara-white);
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: var(--shadow-md);
            max-width: 500px;
            width: 90%;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--gray-dark);
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--gray-600);
            border-radius: 0.25rem;
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }


        .footer-link {
            position: relative;
        }

        .footer-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: rgb(249, 115, 22);
            /* tailwind: orange-500 */
            transition: width 0.3s ease;
        }

        .footer-link:hover::after {
            width: 100%;
        }

        /* Media Queries - apenas se precisar de algo muito específico que o Tailwind não cubra */
        @media (max-width: 640px) {
            .footer-title::after {
                left: 50%;
                transform: translateX(-50%);
            }
        }

        .swal2-confirm:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background-color: #e0e0e0 !important;
            border-color: #cccccc !important;
            color: #666666 !important;
            pointer-events: none;
            box-shadow: none;
        }

        .swal2-popup {
            animation: modalFade 0.3s ease-out;
        }

        @keyframes modalFade {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <?php if (isset($_GET['candidato_erro'])) { ?>
        <script>
            window.alert('ERRO ao deletar o candidato!');
        </script>
    <?php } ?>

    <?php if (isset($_GET['candidato_nao_existe'])) { ?>
        <script>
            window.alert('ERRO candidato não está cadastrado!');
        </script>

    <?php } ?>

    <?php if (isset($_GET['usuario_erro'])) { ?>
        <script>
            window.alert('ERRO ao deletar o usuario!');
        </script>

    <?php } ?>

    <?php if (isset($_GET['usuario_nao_existe'])) { ?>
        <script>
            window.alert('ERRO usuário não existe!');
        </script>
    <?php } ?>

    <header class="w-full bg-white shadow-sm">
        <nav class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <img
                        src="../assets/images/LOGO_new.png"
                        alt="Logo EEEP"
                        class="w-36 h-auto mt-2.5">
                </div>

                <!-- Botão Menu -->
                <div class="flex items-center">
                    <button
                        id="mobile-menu"
                        class="p-2 rounded-lg transition-all duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500"
                        aria-label="Menu"
                        onclick="toggleSidebar()">
                        <svg
                            class="w-8 h-8 text-[#008C45] transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Sidebar -->
                <div
                    id="sidebar"
                    class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg rounded-l-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-800">Menu</h3>
                            <button
                                id="closeSidebar"
                                class="p-2 rounded-lg transition-colors duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500"
                                aria-label="Fechar menu"
                                onclick="toggleSidebar()">
                                <svg
                                    class="w-6 h-6 text-[#008C45]"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <!-- Itens do Menu -->
                        <ul class="flex flex-col space-y-3">

                            <a href="../controllers/autentica.php?sair" class="w-full flex items-center px-4 py-3 text-base rounded-full border-2 border-red-600 text-red-600 font-semibold transition-all duration-300 ease-in-out hover:bg-red-600 hover:text-ceara-white hover:shadow-md transform hover:scale-100 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Sair
                            </a>
                            <li class="mt-4">
                                <button onclick="openInsertUserModal();" class="w-full flex items-center px-4 py-3 text-base rounded-full border-2 border-blue-500 text-blue-500 font-semibold transition-all duration-300 ease-in-out hover:bg-blue-500 hover:text-white hover:shadow-md transform hover:scale-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12v4m0 0l4 4m-4-4l-4 4m-4-4v-4m0 0l-4-4m4 4l4-4" />
                                    </svg>
                                    Inserir Usuário
                                </button>
                            </li>

                            <li>
                                <button onclick="showatualizModal(); toggleOverlay()" class="w-full flex items-center px-4 py-3 text-base rounded-full border-2 border-ceara-orange text-ceara-orange font-semibold transition-all duration-300 ease-in-out hover:bg-ceara-orange hover:text-ceara-white hover:shadow-md transform hover:scale-100 focus:outline-none focus:ring-2 focus:ring-ceara-orange">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Atualizar
                                </button>
                            </li>

                            <li>
                                <button onclick="showReportsModal(); toggleOverlay()" class="w-full flex items-center px-4 py-3 text-base rounded-full border-2 border-ceara-green text-ceara-green font-semibold transition-all duration-300 ease-in-out hover:bg-ceara-green hover:text-ceara-white hover:shadow-md transform hover:scale-100 focus:outline-none focus:ring-2 focus:ring-ceara-green">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Relatórios
                                </button>
                            </li>
                            <li>
                                <button onclick="showResultsModal(); toggleOverlay()" class="w-full flex items-center px-4 py-3 text-base rounded-full border-2 border-gray-600 text-gray-600 font-semibold transition-all duration-300 ease-in-out hover:bg-gray-600 hover:text-ceara-white hover:shadow-md transform hover:scale-100 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Resultados
                                </button>
                            </li>

                            <li>
                                <button onclick="showDeleteConfirmationModal(); toggleOverlay()" class="w-full flex items-center px-4 py-3 text-base rounded-full border-2 border-purple-600 text-purple-600 font-semibold transition-all duration-300 ease-in-out hover:bg-purple-600 hover:text-ceara-white hover:shadow-md transform hover:scale-100 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12v4m0 0l4 4m-4-4l-4 4m-4-4v-4m0 0l-4-4m4 4l4-4" />
                                    </svg>
                                    Limpar banco
                                </button>
                            </li>
                            <li>
                                <button onclick="showExcluirCandidatoModal(); toggleOverlay()" class="w-full flex items-center px-4 py-3 text-base rounded-full border-2 border-gray-600 text-gray-600 font-semibold transition-all duration-300 ease-in-out hover:bg-gray-600 hover:text-ceara-white hover:shadow-md transform hover:scale-100 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Excluir candidato
                                </button>
                            </li>
                            <li>
                                <button onclick="showExcluirUsuarioModal(); toggleOverlay()" class="w-full flex items-center px-4 py-3 text-base rounded-full border-2 border-gray-600 text-gray-600 font-semibold transition-all duration-300 ease-in-out hover:bg-gray-600 hover:text-ceara-white hover:shadow-md transform hover:scale-100 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Excluir usuário
                                </button>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

   <!-- Modal do Cadastrar cursos -->
<main class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center" style="position:relative; margin-top: 100px">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 justify-items-center">
        <!-- Card Enfermagem -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 lg:p-8 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl border border-gray-100">
            <div class="flex flex-col h-full justify-between">
                <h3 class="text-2xl lg:text-3xl text-gray-800 mb-6 lg:mb-8" style="font-family: 'Montserrat', sans-serif; font-weight: 700; letter-spacing: -0.5px;">Enfermagem</h3>
                <div class="space-y-4">
                    <button onclick="enfermagemPub()"
                        class="w-full py-2.5 lg:py-3 px-4 lg:px-6 bg-gradient-to-r from-red-500 to-red-700 text-white rounded-full text-base lg:text-lg transition-all duration-300 hover:from-red-600 hover:to-red-800 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-red-300"
                        style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; letter-spacing: 0.2px;">
                        Escola Pública
                    </button>
                    <button onclick="enfermagemPriv()"
                        class="w-full py-2.5 lg:py-3 px-4 lg:px-6 bg-gradient-to-r from-red-500 to-red-700 text-white rounded-full text-base lg:text-lg transition-all duration-300 hover:from-red-600 hover:to-red-800 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-red-300"
                        style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; letter-spacing: 0.2px;">
                        Escola Privada
                    </button>
                </div>
            </div>
        </div>

        <!-- Card Informática -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 lg:p-8 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl border border-gray-100">
            <div class="flex flex-col h-full justify-between">
                <h3 class="text-2xl lg:text-3xl text-gray-800 mb-6 lg:mb-8" style="font-family: 'Montserrat', sans-serif; font-weight: 700; letter-spacing: -0.5px;">Informática</h3>
                <div class="space-y-4">
                    <button onclick="informaticaPub()"
                        class="w-full py-2.5 lg:py-3 px-4 lg:px-6 bg-gradient-to-r from-[#4a90e2] to-[#4a90e2] text-white rounded-full text-base lg:text-lg transition-all duration-300 hover:from-[#6ba9e6] hover:to-[#6ba9e6] hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200"
                        style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; letter-spacing: 0.2px;">
                        Escola Pública
                    </button>
                    <button onclick="informaticaPriv()"
                        class="w-full py-2.5 lg:py-3 px-4 lg:px-6 bg-gradient-to-r from-[#4a90e2] to-[#4a90e2] text-white rounded-full text-base lg:text-lg transition-all duration-300 hover:from-[#6ba9e6] hover:to-[#6ba9e6] hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200"
                        style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; letter-spacing: 0.2px;">
                        Escola Privada
                    </button>
                </div>
            </div>
        </div>

        <!-- Card Logística -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 lg:p-8 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl border border-gray-100">
            <div class="flex flex-col h-full justify-between">
                <h3 class="text-2xl lg:text-3xl text-gray-800 mb-6 lg:mb-8" style="font-family: 'Montserrat', sans-serif; font-weight: 700; letter-spacing: -0.5px;">Logística</h3>
                <div class="space-y-4">
                    <button onclick="logisticaPub()"
                        class="w-full py-2.5 lg:py-3 px-4 lg:px-6 bg-gradient-to-r from-[#008000] to-[#008000] text-white rounded-full text-base lg:text-lg transition-all duration-300 hover:from-[#008000] hover:to-[#008000] hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-[#008000]"
                        style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; letter-spacing: 0.2px;">
                        Escola Pública
                    </button>
                    <button onclick="logisticaPriv()"
                        class="w-full py-2.5 lg:py-3 px-4 lg:px-6 bg-gradient-to-r from-[#008000] to-[#008000] text-white rounded-full text-base lg:text-lg transition-all duration-300 hover:from-[#008000] hover:to-[#008000] hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-[#008000]"
                        style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; letter-spacing: 0.2px;">
                        Escola Privada
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>


    <style>
        /* Estilos globais */
        h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        button {
            font-family: 'Source Sans Pro', sans-serif;
            font-weight: 600;
            letter-spacing: 0.2px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>





    <footer class="text-white font-sans w-full mt-auto py-4" style="background-color: #008C45">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Identificação Institucional -->
                <div class="p-2">
                    <h4 class="text-orange-400 text-lg font-bold mb-3">SEEPS</h4>
                    <p class="text-sm mb-3">Sistema de Ensino e Educação Profissional Salaberga</p>
                    <div class="flex gap-3">
                        <a aria-label="Facebook" target="_blank" rel="noopener noreferrer"
                            href="https://www.facebook.com/groups/salaberga/"
                            class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-orange-400 transition-all">
                            <i class="fab fa-facebook text-sm"></i>
                        </a>
                        <a aria-label="Instagram" target="_blank" rel="noopener noreferrer"
                            href="https://www.instagram.com/eeepsalabergampe/"
                            class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-orange-400 transition-all">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Contato -->
                <div class="p-2">
                    <h4 class="text-orange-400 text-lg font-bold mb-3">CONTATO</h4>
                    <div class="space-y-2 text-sm">
                        <a class="flex items-center hover:text-orange-400 transition-colors">
                            <i class="fas fa-envelope mr-2"></i>
                            eeepsantaritama@gmail.com
                        </a>
                        <a href="tel:+558531012100" class="flex items-center hover:text-orange-400 transition-colors">
                            <i class="fas fa-phone-alt mr-2"></i>
                            (85) 3101-2100
                        </a>
                    </div>
                </div>

                <div class="p-2">
                    <h4 class="text-orange-400 text-lg font-bold mb-3">DESENVOLVEDORES</h4>
                    <div class="flex gap-4">
                        <!-- Primeira coluna (3 desenvolvedores) -->
                        <ul class="space-y-2">
                            <li>
                                <a href="https://www.instagram.com/otavio.ce/" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center text-sm hover:text-orange-400 transition-colors">
                                    <i class="fab fa-instagram text-orange-400 mr-2"></i>
                                    Otavio Menezes
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/matheus-felix-74489329a/" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center text-sm hover:text-orange-400 transition-colors">
                                    <i class="fab fa-linkedin text-orange-400 mr-2"></i>
                                    Matheus Felix
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/lavosier-nascimento-4b124a2b8/?trk=opento_sprofile_topcard" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center text-sm hover:text-orange-400 transition-colors">
                                    <i class="fab fa-linkedin text-orange-400 mr-2"></i>
                                    Lavosier Nascimento
                                </a>
                            </li>
                        </ul>

                        <!-- Segunda coluna (2 desenvolvedores) -->
                        <ul class="space-y-2">
                            <li>
                                <a href="https://www.linkedin.com/in/roger-cavalcante/" target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex items-center text-sm hover:text-orange-400 transition-colors">
                                    <i class="fab fa-linkedin text-orange-400 mr-2"></i>
                                    Roger Cavalcante
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/pedro-uch%C3%B4a-de-abreu-67723429a/?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center text-sm hover:text-orange-400 transition-colors">
                                    <i class="fab fa-linkedin text-orange-400 mr-2"></i>
                                    Pedro Uchôa
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-white/10 pt-3 text-center text-xs">
            <p>&copy; 2024 SEEPS - Todos os direitos reservados</p>
        </div>
        </div>
    </footer>


    <style>
        /* Estilização do scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #666;
        }

        /* Animação do modal */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #modal>div {
            animation: modalFadeIn 0.3s ease-out;
        }

        /* Estilização dos inputs quando focados */
        input:focus,
        select:focus {
            outline: none;
            border-color: #93C5FD;
            box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.25);
        }

        /* Hover effect nos cards dos anos */
        .bg-gray-50:hover {
            background-color: #F8FAFC;
            transition: background-color 0.2s ease;
        }

        /* Estilização para inputs numéricos */
        input[type="text"] {
            transition: all 0.2s ease;
        }

        input[type="text"]:focus {
            transform: scale(1.02);
        }

        /* Tooltip para campos obrigatórios */
        [required] {
            position: relative;
        }

        [required]:after {
            content: '*';
            color: #EF4444;
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>



</body>

</html>