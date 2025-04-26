<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição - Copa Grêmio 2025</title>
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
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            scroll-behavior: smooth;
        }
        .progress-bar {
            transition: width 0.3s ease;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .checkbox-custom:checked + label:before {
            background-color: #005A24;
            border-color: #005A24;
        }
        .checkbox-custom + label:before {
            content: '';
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid #cbd5e1;
            border-radius: 4px;
            margin-right: 8px;
            vertical-align: middle;
            transition: all 0.2s ease;
        }
        .checkbox-custom:checked + label:after {
            content: '✓';
            position: absolute;
            left: 4px;
            top: 0px;
            color: white;
            font-size: 14px;
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(0, 90, 36, 0.2);
        }
        .section-card {
            transition: box-shadow 0.2s ease;
        }
        .tooltip {
            position: relative;
        }
        .tooltip .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
        .custom-checkbox {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            user-select: none;
        }
        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 4px;
        }
        .custom-checkbox:hover input ~ .checkmark {
            border-color: #005A24;
        }
        .custom-checkbox input:checked ~ .checkmark {
            background-color: #005A24;
            border-color: #005A24;
        }
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
        .custom-checkbox input:checked ~ .checkmark:after {
            display: block;
        }
        .custom-checkbox .checkmark:after {
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Cabeçalho -->
        <header class="bg-primary-700 text-white shadow-lg sticky top-0 z-10">
            <div class="container mx-auto py-4 px-4 md:px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-center md:text-left mb-4 md:mb-0">
                        <h1 class="text-3xl font-bold">Copa Grêmio 2025</h1>
                        <p class="text-primary-200">Grêmio Estudantil José Ivan Pontes Júnior</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Design%20sem%20nome-MOpK2hbpuoqfoF8sir0Ue6SvciAArc.svg" alt="Logo Copa Grêmio" class="h-16 w-16">
                        <a href="admin/login.php" class="bg-secondary-600 hover:bg-secondary-700 text-white px-4 py-2 rounded-md shadow-md transition-colors flex items-center animate-fadeInUp">
                            <i class="fas fa-user-shield mr-2"></i> Admin
                        </a>
                        <a href="usuario/login.php" class="bg-primary-500 hover:bg-primary-700 text-white px-4 py-2 rounded-md shadow-md transition-colors flex items-center animate-fadeInUp" style="animation-delay:0.2s">
                            <i class="fas fa-user mr-2"></i> Área do Usuário
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Barra de Progresso -->
        <div class="bg-white shadow-md py-2 sticky top-[76px] z-10">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-primary-700" id="progress-text">Progresso da inscrição: 0%</span>
                    <span class="text-sm font-medium text-primary-700" id="progress-steps">Etapa 0 de 4</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-secondary-600 h-2.5 rounded-full progress-bar" id="progress-bar" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Formulário de Inscrição -->
        <main class="container mx-auto py-8 px-4 md:px-6 flex-grow">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-md p-6 mb-8 section-card">
                    <h2 class="text-2xl font-bold text-primary-800 mb-6 pb-2 border-b border-gray-200 flex items-center">
                        <i class="fas fa-clipboard-list mr-2 text-secondary-600"></i>
                        Formulário de Inscrição
                        <span class="ml-2 text-sm bg-primary-100 text-primary-800 py-1 px-2 rounded-full">Copa Grêmio 2025</span>
                    </h2>
                    
                    <!-- Seção de verificação de inscrição -->
                    <div class="mb-8 p-5 border border-gray-200 rounded-lg bg-gray-50">
                        <h3 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                            <i class="fas fa-search mr-2 text-secondary-600"></i>
                            <span>Verificar Status da Inscrição</span>
                        </h3>
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-grow">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                    <input type="text" id="verificar-id" 
                                        class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus"
                                        placeholder="Digite o número da sua inscrição">
                                </div>
                            </div>
                            <button type="button" id="btn-verificar" class="px-4 py-2 bg-primary-600 text-white font-medium rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                <i class="fas fa-search mr-1"></i> Verificar
                            </button>
                        </div>
                        <div id="resultado-verificacao" class="mt-4 hidden">
                            <!-- Será preenchido via JavaScript -->
                        </div>
                    </div>
                    
                    <form id="inscricaoForm" class="space-y-8">
                        <!-- Dados Pessoais -->
                        <section id="secao-dados-pessoais" class="p-5 border border-gray-200 rounded-lg bg-white shadow-sm section-card animate-fadeInUp">
                            <h3 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                                <i class="fas fa-user-circle mr-2 text-secondary-600"></i>
                                <span>1. Dados Pessoais</span>
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo*</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input type="text" id="nome" name="nome" required 
                                            class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus"
                                            placeholder="Digite seu nome completo">
                                    </div>
                                </div>
                                <div>
                                    <label for="ano" class="block text-sm font-medium text-gray-700 mb-1">Turma*</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-graduation-cap text-gray-400"></i>
                                            </div>
                                            <select id="ano" name="ano" required 
                                                class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus appearance-none">
                                                <option value="" disabled selected>Ano</option>
                                                <option value="1">1º Ano</option>
                                                <option value="2">2º Ano</option>
                                                <option value="3">3º Ano</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400"></i>
                                            </div>
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-users text-gray-400"></i>
                                            </div>
                                            <select id="turma" name="turma" required 
                                                class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus appearance-none">
                                                <option value="" disabled selected>Turma</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail*</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input type="email" id="email" name="email" required 
                                            class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus"
                                            placeholder="seu.email@exemplo.com">
                                    </div>
                                </div>
                                <div>
                                    <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone/WhatsApp*</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fab fa-whatsapp text-gray-400"></i>
                                        </div>
                                        <input type="tel" id="telefone" name="telefone" required 
                                            class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus"
                                            placeholder="(00) 00000-0000">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <button type="button" id="btn-proximo-1" class="px-4 py-2 bg-secondary-600 text-white font-medium rounded-md hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors">
                                    Próximo <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </section>

                        <!-- Dados Escolares -->
                        <section id="secao-dados-escolares" class="p-5 border border-gray-200 rounded-lg bg-white shadow-sm section-card animate-fadeInUp">
                            <h3 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                                <i class="fas fa-school mr-2 text-secondary-600"></i>
                                <span>2. Dados Escolares</span>
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="escola" class="block text-sm font-medium text-gray-700 mb-1">Escola*</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-school text-gray-400"></i>
                                        </div>
                                        <input type="text" id="escola" name="escola" required 
                                            class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus"
                                            placeholder="Digite o nome da sua escola">
                                    </div>
                                </div>
                                <div>
                                    <label for="serie" class="block text-sm font-medium text-gray-700 mb-1">Série*</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-book text-gray-400"></i>
                                            </div>
                                            <select id="serie" name="serie" required 
                                                class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus appearance-none">
                                                <option value="" disabled selected>Série</option>
                                                <option value="1">1º Ano</option>
                                                <option value="2">2º Ano</option>
                                                <option value="3">3º Ano</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400"></i>
                                            </div>
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-users text-gray-400"></i>
                                            </div>
                                            <select id="turma-escola" name="turma-escola" required 
                                                class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 input-focus appearance-none">
                                                <option value="" disabled selected>Turma</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <button type="button" id="btn-proximo-2" class="px-4 py-2 bg-secondary-600 text-white font-medium rounded-md hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors">
                                    Próximo <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </section>

                        <!-- Modalidades -->
                        <section id="secao-modalidades" class="p-5 border border-gray-200 rounded-lg bg-white shadow-sm section-card animate-fadeInUp">
                            <h3 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                                <i class="fas fa-trophy mr-2 text-secondary-600"></i>
                                <span>3. Modalidades Esportivas</span>
                            </h3>
                            
                            <!-- Modalidades Individuais -->
                            <div class="mb-6">
                                <h4 class="text-lg font-medium text-primary-600 mb-3 flex items-center">
                                    <i class="fas fa-user mr-2 text-secondary-600"></i> Modalidades Individuais
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="futmesa" name="modalidades" value="futmesa" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Futmesa</span>
                                                <p class="text-xs text-gray-500">Individual ou dupla</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="tenis-mesa" name="modalidades" value="tenis-mesa" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Tênis de Mesa</span>
                                                <p class="text-xs text-gray-500">Individual</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="teqball" name="modalidades" value="teqball" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Teqball</span>
                                                <p class="text-xs text-gray-500">Dupla</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="teqvolei" name="modalidades" value="teqvolei" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Teqvôlei</span>
                                                <p class="text-xs text-gray-500">Dupla</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="beach-tenis" name="modalidades" value="beach-tenis" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Beach Tênis</span>
                                                <p class="text-xs text-gray-500">Dupla</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="volei-praia" name="modalidades" value="volei-praia" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Vôlei de Praia</span>
                                                <p class="text-xs text-gray-500">Dupla</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="dama" name="modalidades" value="dama" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Dama</span>
                                                <p class="text-xs text-gray-500">Individual</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="xadrez" name="modalidades" value="xadrez" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Xadrez</span>
                                                <p class="text-xs text-gray-500">Individual</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="jiu-jitsu" name="modalidades" value="jiu-jitsu" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Jiu-jitsu</span>
                                                <p class="text-xs text-gray-500">Individual</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modalidades Coletivas -->
                            <div>
                                <h4 class="text-lg font-medium text-primary-600 mb-3 flex items-center">
                                    <i class="fas fa-users mr-2 text-secondary-600"></i> Modalidades Coletivas
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="futsal" name="modalidades" value="futsal" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Futsal</span>
                                                <p class="text-xs text-gray-500">5-9 jogadores</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="volei" name="modalidades" value="volei" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Vôlei</span>
                                                <p class="text-xs text-gray-500">6-12 jogadores</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative flex items-center p-3 border border-gray-200 rounded-md hover:bg-primary-50 transition-colors">
                                        <label class="custom-checkbox flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="queimada" name="modalidades" value="queimada" class="modalidade-checkbox">
                                            <span class="checkmark"></span>
                                            <div class="ml-2">
                                                <span class="font-medium">Queimada</span>
                                                <p class="text-xs text-gray-500">12 jogadores</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between mt-6">
                                <button type="button" id="btn-anterior-2" class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                    <i class="fas fa-arrow-left mr-1"></i> Anterior
                                </button>
                                <button type="button" id="btn-proximo-2" class="px-4 py-2 bg-secondary-600 text-white font-medium rounded-md hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors">
                                    Próximo <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </section>

                        <!-- Detalhes das Modalidades -->
                        <section id="secao-detalhes" class="p-5 border border-gray-200 rounded-lg bg-white shadow-sm section-card hidden">
                            <h3 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-secondary-600"></i>
                                <span>4. Detalhes das Modalidades</span>
                            </h3>
                            <div id="detalhesModalidades" class="space-y-6">
                                <!-- Os detalhes das modalidades serão adicionados dinamicamente via JavaScript -->
                                <div class="text-center py-8 text-gray-500" id="sem-modalidades">
                                    <i class="fas fa-exclamation-circle text-4xl mb-2 text-accent-400"></i>
                                    <p>Nenhuma modalidade selecionada. Por favor, volte e selecione pelo menos uma modalidade.</p>
                                </div>
                            </div>

                            <div class="flex justify-between mt-6">
                                <button type="button" id="btn-anterior-3" class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                    <i class="fas fa-arrow-left mr-1"></i> Anterior
                                </button>
                                <button type="button" id="btn-proximo-3" class="px-4 py-2 bg-secondary-600 text-white font-medium rounded-md hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors">
                                    Próximo <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </section>

                        <!-- Termos e Condições -->
                        <section id="secao-termo" class="p-5 border border-gray-200 rounded-lg bg-white shadow-sm section-card animate-fadeInUp">
                            <h3 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                                <i class="fas fa-file-signature mr-2 text-secondary-600"></i>
                                <span>5. Termos e Condições</span>
                            </h3>
                            <div class="flex items-start mb-3">
                                <div class="flex items-center h-5 mt-1">
                                    <input id="termos" name="termos" type="checkbox" required class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="termos" class="font-medium text-gray-700">Declaro que li e concordo com o <button type="button" id="btnRegulamento" class="text-secondary-600 underline hover:text-secondary-800">regulamento da Copa Grêmio 2025</button></label>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5 mt-1">
                                    <input id="dados" name="dados" type="checkbox" required class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="dados" class="font-medium text-gray-700">Concordo com o armazenamento dos meus dados para fins de organização do evento</label>
                                    <p class="text-gray-500 text-xs mt-1">Seus dados serão armazenados em nosso banco de dados e utilizados apenas para a organização da Copa Grêmio 2025.</p>
                                </div>
                            </div>
                            <div class="flex justify-between mt-6">
                                <button type="button" id="btn-anterior-4" class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                    <i class="fas fa-arrow-left mr-1"></i> Anterior
                                </button>
                                <button type="submit" class="px-6 py-3 bg-secondary-600 text-white font-medium rounded-md hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-colors">
                                    <i class="fas fa-paper-plane mr-1"></i> Finalizar Inscrição
                                </button>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </main>

        <!-- Rodapé -->
        <footer class="bg-primary-800 text-white py-8 mt-auto">
            <div class="container mx-auto px-4 md:px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-bold mb-4">Copa Grêmio 2025</h3>
                        <p class="text-primary-200">Organizado pelo Grêmio Estudantil José Ivan Pontes Júnior</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-4">Contato</h3>
                        <div class="flex space-x-4">
                            <a href="https://www.linkedin.com/in/matheus-felix-9b1a3b123/" target="_blank" class="text-primary-200 hover:text-secondary-500 transition-colors">
                                <i class="fab fa-linkedin-in text-2xl"></i>
                            </a>
                            <a href="https://www.instagram.com/matheusfelix.dev/" target="_blank" class="text-primary-200 hover:text-secondary-500 transition-colors">
                                <i class="fab fa-instagram text-2xl"></i>
                            </a>
                        </div>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-primary-200">Desenvolvido por Matheus Felix</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Modal do Regulamento -->
    <div id="regulamentoModal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-3xl mx-auto rounded shadow-lg z-50 overflow-y-auto max-h-screen">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold text-primary-700">Regulamento Copa Grêmio 2025</p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>

                <div class="my-5 max-h-96 overflow-y-auto pr-2">
                    <h3 class="text-lg font-semibold mb-2">I. Finalidade</h3>
                    <p class="mb-4">A Copa Grêmio tem por finalidade, promover a mobilização do segmento escolar, incentivando os alunos a prática de esportes físicos, mentais e a socialização entre as turmas.</p>
                    
                    <h3 class="text-lg font-semibold mb-2">II. Objetivos</h3>
                    <ul class="list-disc pl-5 mb-4 space-y-1">
                        <li>Fomentar a prática do esporte na EEEP Salaberga Torquato Gomes de Matos;</li>
                        <li>Contribuir para com o desenvolvimento integral do aluno/atleta como ser social, autônomo, democrático e participante, estimulando o pleno exercício da cidadania através do esporte;</li>
                        <li>Garantir o conhecimento do esporte de modo a oferecer mais oportunidade de acesso à sua prática na escola.</li>
                    </ul>
                    
                    <h3 class="text-lg font-semibold mb-2">V. Inscrições e Participação</h3>
                    <p class="mb-2">Poderão participar da COPA GRÊMIO os alunos regularmente matriculados na EEEP Salaberga Torquato Gomes de Matos que realizarem suas inscrições dentro do período estabelecido.</p>
                    <p class="mb-2">É OBRIGATÓRIA a apresentação da ficha de inscrição devidamente assinada e carimbada pela a presidência do GRÊMIO ESTUDANTIL ou INSCRIÇÃO NO SITE no dia da competição.</p>
                    <p class="mb-4">Cada participante deve pagar o valor de R$5,00 para a inscrição em cada modalidade. Em casos em que o aluno se inscreva em 3 ou mais modalidades, ele passará a pagar o valor de R$3,00 por cada modalidade inscrita.</p>
                    
                    <h3 class="text-lg font-semibold mb-2">VI. Premiação e Cerimônia de Abertura</h3>
                    <p class="mb-2">Serão concedidos os seguintes prêmios aos participantes:</p>
                    <ul class="list-disc pl-5 mb-4 space-y-1">
                        <li>As equipes vencedoras de esportes coletivos ganharão um troféu.</li>
                        <li>Nos esportes individuais as premiações serão por medalhas.</li>
                    </ul>
                    
                    <p class="text-sm text-gray-600 mt-4">Para mais detalhes, consulte o regulamento completo disponibilizado pelo Grêmio Estudantil.</p>
                </div>

                <div class="flex justify-end pt-2">
                    <button class="modal-close px-4 bg-secondary-600 p-3 rounded-lg text-white hover:bg-secondary-700">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Sucesso -->
    <div id="sucessoModal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-6 text-left px-6">
                <div class="flex flex-col items-center text-center pb-3">
                    <div class="bg-green-100 p-3 rounded-full mb-4">
                        <i class="fas fa-check-circle text-4xl text-green-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Inscrição Realizada!</h3>
                    <p class="text-gray-600 mb-6">Sua inscrição para a Copa Grêmio 2025 foi realizada com sucesso!</p>
                    
                    <div class="bg-gray-100 w-full p-4 rounded-lg mb-6">
                        <p class="font-medium text-gray-800 mb-1">Resumo da Inscrição:</p>
                        <div id="resumo-modal" class="text-sm text-gray-600 text-left"></div>
                        <p class="font-medium text-gray-800 mt-3 mb-1">Valor Total:</p>
                        <p id="valor-modal" class="text-lg font-bold text-primary-700">R$ 0,00</p>
                    </div>
                    
                    <div class="flex flex-col w-full gap-3">
                        <a id="enviar-comprovante" href="#" target="_blank" class="w-full px-4 py-3 bg-accent-400 text-white font-medium rounded-md hover:bg-accent-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 transition-colors flex items-center justify-center">
                            <i class="fab fa-whatsapp mr-2 text-lg"></i> Enviar Comprovante via WhatsApp
                        </a>
                        <button id="fechar-sucesso" class="w-full px-4 py-3 bg-gray-200 text-gray-700 font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de resultado da verificação -->
    <div id="resultado-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-2xl mx-auto rounded shadow-lg z-50 overflow-y-auto max-h-screen">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3 border-b">
                    <p id="resultado-titulo" class="text-2xl font-bold text-primary-700">Resultado da Verificação</p>
                    <div class="modal-close-resultado cursor-pointer z-50">
                        <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>

                <div id="resultado-conteudo" class="my-5">
                    <!-- Será preenchido via JavaScript -->
                </div>
                
                <div class="flex justify-end pt-2 border-t">
                    <button class="modal-close-resultado px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos do DOM
    const form = document.getElementById('inscricaoForm');
    const checkboxes = document.querySelectorAll('.modalidade-checkbox');
    const detalhesModalidades = document.getElementById('detalhesModalidades');
    const valorTotalElement = document.getElementById('valorTotal');
    const btnRegulamento = document.getElementById('btnRegulamento');
    const modal = document.getElementById('regulamentoModal');
    const closeModal = document.querySelectorAll('.modal-close');
    const sucessoModal = document.getElementById('sucessoModal');
    const fecharSucesso = document.getElementById('fechar-sucesso');
    const enviarComprovante = document.getElementById('enviar-comprovante');
    const resumoModal = document.getElementById('resumo-modal');
    const valorModal = document.getElementById('valor-modal');
    const semModalidades = document.getElementById('sem-modalidades');
    
    // Elementos de navegação
    const secaoDadosPessoais = document.getElementById('secao-dados-pessoais');
    const secaoModalidades = document.getElementById('secao-modalidades');
    const secaoDetalhes = document.getElementById('secao-detalhes');
    const secaoConfirmacao = document.getElementById('secao-confirmacao');
    
    const btnProximo1 = document.getElementById('btn-proximo-1');
    const btnAnterior2 = document.getElementById('btn-anterior-2');
    const btnProximo2 = document.getElementById('btn-proximo-2');
    const btnAnterior3 = document.getElementById('btn-anterior-3');
    const btnProximo3 = document.getElementById('btn-proximo-3');
    const btnAnterior4 = document.getElementById('btn-anterior-4');
    
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const progressSteps = document.getElementById('progress-steps');
    
    // Configurações das modalidades
    const modalidadesConfig = {
        'futsal': { tipo: 'coletiva', min: 5, max: 9, genero: ['masculino', 'feminino'] },
        'volei': { tipo: 'coletiva', min: 6, max: 12, genero: ['misto'] },
        'queimada': { tipo: 'coletiva', min: 12, max: 12, genero: ['misto'] },
        'futmesa': { tipo: 'individual', min: 1, max: 2, genero: ['masculino', 'feminino'] },
        'tenis-mesa': { tipo: 'individual', min: 1, max: 1, genero: ['misto'] },
        'teqball': { tipo: 'individual', min: 2, max: 2, genero: ['masculino', 'feminino', 'misto'] },
        'teqvolei': { tipo: 'individual', min: 2, max: 2, genero: ['masculino', 'feminino', 'misto'] },
        'beach-tenis': { tipo: 'individual', min: 2, max: 2, genero: ['masculino', 'feminino', 'misto'] },
        'volei-praia': { tipo: 'individual', min: 2, max: 2, genero: ['masculino', 'feminino', 'misto'] },
        'dama': { tipo: 'individual', min: 1, max: 1, genero: ['misto'] },
        'xadrez': { tipo: 'individual', min: 1, max: 1, genero: ['misto'] },
        'jiu-jitsu': { tipo: 'individual', min: 1, max: 1, genero: ['masculino', 'feminino'] }
    };
    
    // Função para atualizar o progresso
    function atualizarProgresso(etapa) {
        const porcentagem = etapa * 25;
        progressBar.style.width = `${porcentagem}%`;
        progressText.textContent = `Progresso da inscrição: ${porcentagem}%`;
        progressSteps.textContent = `Etapa ${etapa} de 4`;
    }
    
    // Navegação entre seções
    btnProximo1.addEventListener('click', function() {
        // Validar campos da seção 1
        const nome = document.getElementById('nome').value;
        const ano = document.getElementById('ano').value;
        const turma = document.getElementById('turma').value;
        const email = document.getElementById('email').value;
        const telefone = document.getElementById('telefone').value;
        
        if (!nome || !ano || !turma || !email || !telefone) {
            alert('Por favor, preencha todos os campos obrigatórios.');
            return;
        }
        
        secaoDadosPessoais.classList.add('hidden');
        secaoModalidades.classList.remove('hidden');
        secaoModalidades.classList.add('fade-in');
        atualizarProgresso(2);
        window.scrollTo(0, 0);
    });
    
    btnAnterior2.addEventListener('click', function() {
        secaoModalidades.classList.add('hidden');
        secaoDadosPessoais.classList.remove('hidden');
        secaoDadosPessoais.classList.add('fade-in');
        atualizarProgresso(1);
        window.scrollTo(0, 0);
    });
    
    btnProximo2.addEventListener('click', function() {
        // Verificar se pelo menos uma modalidade foi selecionada
        const modalidadesSelecionadas = Array.from(checkboxes).filter(cb => cb.checked);
        
        if (modalidadesSelecionadas.length === 0) {
            alert('Por favor, selecione pelo menos uma modalidade.');
            return;
        }
        
        atualizarCamposModalidades();
        secaoModalidades.classList.add('hidden');
        secaoDetalhes.classList.remove('hidden');
        secaoDetalhes.classList.add('fade-in');
        atualizarProgresso(3);
        window.scrollTo(0, 0);
    });
    
    btnAnterior3.addEventListener('click', function() {
        secaoDetalhes.classList.add('hidden');
        secaoModalidades.classList.remove('hidden');
        secaoModalidades.classList.add('fade-in');
        atualizarProgresso(2);
        window.scrollTo(0, 0);
    });
    
    btnProximo3.addEventListener('click', function() {
        // Atualizar resumo da inscrição
        atualizarResumoInscricao();
        
        secaoDetalhes.classList.add('hidden');
        secaoConfirmacao.classList.remove('hidden');
        secaoConfirmacao.classList.add('fade-in');
        atualizarProgresso(4);
        window.scrollTo(0, 0);
    });
    
    btnAnterior4.addEventListener('click', function() {
        secaoConfirmacao.classList.add('hidden');
        secaoDetalhes.classList.remove('hidden');
        secaoDetalhes.classList.add('fade-in');
        atualizarProgresso(3);
        window.scrollTo(0, 0);
    });
    
    // Função para atualizar o valor total
    function atualizarValorTotal() {
        const modalidadesSelecionadas = Array.from(checkboxes).filter(cb => cb.checked);
        const quantidade = modalidadesSelecionadas.length;
        let valorUnitario = 5.00;
        
        if (quantidade >= 3) {
            valorUnitario = 3.00;
        }
        
        const valorTotal = quantidade * valorUnitario;
        valorTotalElement.textContent = `R$ ${valorTotal.toFixed(2)}`;
        valorModal.textContent = `R$ ${valorTotal.toFixed(2)}`;
        
        return valorTotal;
    }
    
    // Função para criar campos de detalhes da modalidade
    function criarCamposModalidade(modalidade, config) {
        const modalidadeNome = modalidade.replace('-', ' ');
        const modalidadeId = modalidade;
        
        // Criar container para a modalidade
        const container = document.createElement('div');
        container.id = `detalhes-${modalidadeId}`;
        container.className = 'p-4 border border-primary-200 rounded-md bg-primary-50 fade-in';
        
        // Título da modalidade
        const titulo = document.createElement('h4');
        titulo.className = 'text-lg font-medium text-primary-700 mb-3 capitalize flex items-center';
        
        // Ícone baseado no tipo de modalidade
        let icone = 'fas fa-user';
        if (config.tipo === 'coletiva') {
            icone = 'fas fa-users';
        }
        
        titulo.innerHTML = `<i class="${icone} mr-2 text-secondary-600"></i> ${modalidadeNome}`;
        container.appendChild(titulo);
        
        // Informações sobre a modalidade
        const info = document.createElement('p');
        info.className = 'text-sm text-gray-600 mb-3';
        
        if (config.tipo === 'coletiva') {
            info.textContent = `Modalidade coletiva: Mínimo de ${config.min} e máximo de ${config.max} participantes.`;
        } else {
            if (config.min === config.max && config.min === 1) {
                info.textContent = 'Modalidade individual: Participação individual.';
            } else {
                info.textContent = `Modalidade individual: Necessário ${config.min} participante(s).`;
            }
        }
        container.appendChild(info);
        
        // Campo de seleção de gênero
        if (config.genero.length > 1) {
            const generoDiv = document.createElement('div');
            generoDiv.className = 'mb-3';
            
            const generoLabel = document.createElement('label');
            generoLabel.className = 'block text-sm font-medium text-gray-700 mb-1';
            generoLabel.textContent = 'Categoria:';
            generoDiv.appendChild(generoLabel);
            
            const generoSelect = document.createElement('select');
            generoSelect.name = `genero-${modalidadeId}`;
            generoSelect.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500';
            
            config.genero.forEach(gen => {
                const option = document.createElement('option');
                option.value = gen;
                option.textContent = gen.charAt(0).toUpperCase() + gen.slice(1);
                generoSelect.appendChild(option);
            });
            
            generoDiv.appendChild(generoSelect);
            container.appendChild(generoDiv);
        }
        
        // Campos para equipes coletivas
        if (config.tipo === 'coletiva' || config.min > 1) {
            const equipesDiv = document.createElement('div');
            
            // Nome da equipe
            const nomeEquipeDiv = document.createElement('div');
            nomeEquipeDiv.className = 'mb-3';
            
            const nomeEquipeLabel = document.createElement('label');
            nomeEquipeLabel.className = 'block text-sm font-medium text-gray-700 mb-1';
            nomeEquipeLabel.textContent = 'Nome da Equipe:';
            nomeEquipeDiv.appendChild(nomeEquipeLabel);
            
            const nomeEquipeInput = document.createElement('input');
            nomeEquipeInput.type = 'text';
            nomeEquipeInput.name = `equipe-nome-${modalidadeId}`;
            nomeEquipeInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500';
            nomeEquipeDiv.appendChild(nomeEquipeInput);
            
            equipesDiv.appendChild(nomeEquipeDiv);
            container.appendChild(equipesDiv);
            
            // Observação sobre membros da equipe
            if (config.min > 1) {
                const obsEquipe = document.createElement('p');
                obsEquipe.className = 'text-sm text-gray-500 italic mt-2';
                obsEquipe.textContent = 'Observação: Cada membro da equipe deve fazer sua inscrição individual.';
                container.appendChild(obsEquipe);
            }
        }
        
        return container;
    }
    
    // Função para atualizar os campos de detalhes das modalidades
    function atualizarCamposModalidades() {
        // Limpar campos existentes
        detalhesModalidades.innerHTML = '';
        
        // Adicionar campos para modalidades selecionadas
        const modalidadesSelecionadas = Array.from(checkboxes).filter(cb => cb.checked);
        
        if (modalidadesSelecionadas.length === 0) {
            detalhesModalidades.appendChild(semModalidades);
            return;
        }
        
        modalidadesSelecionadas.forEach(checkbox => {
            const modalidade = checkbox.value;
            const config = modalidadesConfig[modalidade];
            
            if (config) {
                const camposModalidade = criarCamposModalidade(modalidade, config);
                detalhesModalidades.appendChild(camposModalidade);
            }
        });
        
        // Atualizar valor total
        atualizarValorTotal();
    }
    
    // Função para atualizar o resumo da inscrição
    function atualizarResumoInscricao() {
        const resumoInscricao = document.getElementById('resumo-inscricao');
        const nome = document.getElementById('nome').value;
        const ano = document.getElementById('ano').value;
        const turma = document.getElementById('turma').value;
        const email = document.getElementById('email').value;
        const telefone = document.getElementById('telefone').value;
        
        const modalidadesSelecionadas = Array.from(checkboxes).filter(cb => cb.checked);
        
        let html = `
            <div class="space-y-3">
                <div>
                    <h5 class="font-medium text-gray-700">Dados Pessoais:</h5>
                    <p class="text-sm text-gray-600">Nome: ${nome}</p>
                    <p class="text-sm text-gray-600">Turma: ${ano}º ${turma}</p>
                    <p class="text-sm text-gray-600">E-mail: ${email}</p>
                    <p class="text-sm text-gray-600">Telefone: ${telefone}</p>
                </div>
                
                <div>
                    <h5 class="font-medium text-gray-700">Modalidades:</h5>
                    <ul class="list-disc pl-5 text-sm text-gray-600">
        `;
        
        modalidadesSelecionadas.forEach(checkbox => {
            const modalidade = checkbox.value;
            const modalidadeNome = modalidade.replace('-', ' ');
            const generoSelect = document.querySelector(`select[name="genero-${modalidade}"]`);
            const genero = generoSelect ? generoSelect.value : 'misto';
            const nomeEquipeInput = document.querySelector(`input[name="equipe-nome-${modalidade}"]`);
            const nomeEquipe = nomeEquipeInput ? nomeEquipeInput.value : 'N/A';
            
            html += `
                <li class="capitalize">
                    ${modalidadeNome}
                    <span class="text-xs"> (Categoria: ${genero.charAt(0).toUpperCase() + genero.slice(1)})</span>
                    ${nomeEquipe !== 'N/A' ? `<span class="text-xs"> - Equipe: ${nomeEquipe}</span>` : ''}
                </li>`;
        });
        
        html += `
                    </ul>
                </div>
            </div>
        `;
        
        resumoInscricao.innerHTML = html;
        
        // Atualizar também o resumo no modal de sucesso
        let resumoHtml = `
            <p>Nome: ${nome}</p>
            <p>Turma: ${ano}º ${turma}</p>
            <p>Modalidades: ${modalidadesSelecionadas.length}</p>
        `;
        
        resumoModal.innerHTML = resumoHtml;
    }
    
    // Event listeners para checkboxes de modalidades
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            atualizarValorTotal();
        });
    });
    
    // Event listener para o formulário
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Verificar se pelo menos uma modalidade foi selecionada
        const modalidadesSelecionadas = Array.from(checkboxes).filter(cb => cb.checked);
        
        if (modalidadesSelecionadas.length === 0) {
            alert('Por favor, selecione pelo menos uma modalidade.');
            return;
        }
        
        // Verificar se os termos foram aceitos
        if (!document.getElementById('termos').checked || !document.getElementById('dados').checked) {
            alert('Por favor, aceite os termos e condições para continuar.');
            return;
        }
        
        // Coleta os dados do formulário
        const formData = new FormData(form);
        const modalidades = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        formData.append('modalidades', JSON.stringify(modalidades));
        
        // Envia os dados para o controller via AJAX
        fetch('controllers/InscricaoController.php?action=cadastrar', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar modal de sucesso
                sucessoModal.classList.remove('opacity-0');
                sucessoModal.classList.remove('pointer-events-none');
                
                // Atualizar o resumo com o ID do aluno
                const resumoHtml = resumoModal.innerHTML + `<p>ID da Inscrição: ${data.aluno_id}</p>`;
                resumoModal.innerHTML = resumoHtml;
                
                // Configurar link do WhatsApp
                const nome = document.getElementById('nome').value;
                const ano = document.getElementById('ano').value;
                const turma = document.getElementById('turma').value;
                const valorTotal = atualizarValorTotal();
                
                const mensagem = `Olá! Sou ${nome} da turma ${ano}º ${turma}. Estou enviando o comprovante de pagamento da minha inscrição na Copa Grêmio 2025 (ID: ${data.aluno_id}) no valor de R$ ${valorTotal.toFixed(2)}.`;
                const numeroWhatsApp = '5585999999999'; // Substitua pelo número correto
                enviarComprovante.href = `https://wa.me/${numeroWhatsApp}?text=${encodeURIComponent(mensagem)}`;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro ao enviar inscrição:', error);
            alert('Ocorreu um erro ao enviar a inscrição. Tente novamente.');
        });
    });
    
    // Funções para o modal do regulamento
    btnRegulamento.addEventListener('click', function() {
        modal.classList.remove('opacity-0');
        modal.classList.remove('pointer-events-none');
    });
    
    closeModal.forEach(button => {
        button.addEventListener('click', function() {
            modal.classList.add('opacity-0');
            modal.classList.add('pointer-events-none');
        });
    });
    
    // Fechar modal ao clicar fora
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('opacity-0');
            modal.classList.add('pointer-events-none');
        }
    });
    
    // Fechar modal de sucesso
    fecharSucesso.addEventListener('click', function() {
        sucessoModal.classList.add('opacity-0');
        sucessoModal.classList.add('pointer-events-none');
        
        // Resetar o formulário
        form.reset();
        detalhesModalidades.innerHTML = '';
        atualizarValorTotal();
        
        // Voltar para a primeira seção
        secaoConfirmacao.classList.add('hidden');
        secaoDadosPessoais.classList.remove('hidden');
        atualizarProgresso(1);
    });
    
    // Inicializar progresso
    atualizarProgresso(1);

    // Event listener para verificar inscrição
    document.getElementById('btn-verificar').addEventListener('click', function() {
        const inscricaoId = document.getElementById('verificar-id').value.trim();
        
        if (!inscricaoId) {
            alert('Por favor, digite o número da sua inscrição.');
            return;
        }
        
        // Exibir carregamento
        const resultadoModal = document.getElementById('resultado-modal');
        const resultadoConteudo = document.getElementById('resultado-conteudo');
        
        resultadoModal.classList.remove('opacity-0');
        resultadoModal.classList.remove('pointer-events-none');
        
        resultadoConteudo.innerHTML = `
            <div class="flex justify-center items-center py-8">
                <i class="fas fa-spinner fa-spin mr-2 text-primary-600"></i> Verificando sua inscrição...
            </div>
        `;
        
        // Fazer a requisição para verificar o status
        fetch(`controllers/InscricaoController.php?action=verificar&id=${inscricaoId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderizarResultadoVerificacao(data.inscricoes);
                } else {
                    resultadoConteudo.innerHTML = `
                        <div class="p-5 bg-red-50 text-red-700 rounded-lg text-center">
                            <i class="fas fa-exclamation-circle text-4xl mb-3 text-red-500"></i>
                            <p class="font-medium text-lg">${data.message}</p>
                            <p class="mt-2">Verifique o número da inscrição e tente novamente.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Erro ao verificar inscrição:', error);
                resultadoConteudo.innerHTML = `
                    <div class="p-5 bg-red-50 text-red-700 rounded-lg text-center">
                        <i class="fas fa-exclamation-circle text-4xl mb-3 text-red-500"></i>
                        <p class="font-medium text-lg">Erro ao verificar inscrição</p>
                        <p class="mt-2">Ocorreu um erro ao processar sua solicitação. Tente novamente mais tarde.</p>
                    </div>
                `;
            });
    });
    
    // Renderizar resultado da verificação
    function renderizarResultadoVerificacao(inscricoes) {
        const resultadoConteudo = document.getElementById('resultado-conteudo');
        const primeiraInscricao = inscricoes[0]; // Para obter dados do aluno
        
        // Verificar status geral
        const todasAprovadas = inscricoes.every(i => i.status === 'aprovado');
        const algumaReprovada = inscricoes.some(i => i.status === 'reprovado');
        
        let statusGeral = 'pendente';
        let statusTexto = 'Pendente';
        let statusIcone = 'clock';
        let statusCor = 'yellow';
        
        if (todasAprovadas) {
            statusGeral = 'aprovado';
            statusTexto = 'Aprovada';
            statusIcone = 'check-circle';
            statusCor = 'green';
        } else if (algumaReprovada) {
            statusGeral = 'reprovado';
            statusTexto = 'Reprovada';
            statusIcone = 'times-circle';
            statusCor = 'red';
        }
        
        // Atualizar título do modal com o status
        document.getElementById('resultado-titulo').innerHTML = `
            Inscrição <span class="text-${statusCor}-600">${statusTexto}</span>
        `;
        
        let html = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-primary-700 mb-2">Dados do Aluno</h3>
                    <ul class="space-y-2">
                        <li><strong>Nome:</strong> ${primeiraInscricao.nome}</li>
                        <li><strong>Turma:</strong> ${primeiraInscricao.ano}º ${primeiraInscricao.turma}</li>
                        <li><strong>Nº de Inscrição:</strong> #${primeiraInscricao.id}</li>
                    </ul>
                </div>
                <div class="bg-${statusCor}-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-${statusCor}-700 mb-2">Status da Inscrição</h3>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-${statusIcone} text-3xl text-${statusCor}-500 mr-3"></i>
                        <span class="text-xl font-bold text-${statusCor}-600">${statusTexto}</span>
                    </div>
                    <p class="text-sm text-${statusCor}-600">
                        ${statusGeral === 'aprovado' 
                            ? 'Sua inscrição foi aprovada! Você está oficialmente inscrito na Copa Grêmio 2025.' 
                            : statusGeral === 'reprovado'
                                ? 'Sua inscrição foi reprovada. Entre em contato com a organização para mais informações.'
                                : 'Sua inscrição está em análise. Verifique novamente mais tarde para atualizações.'}
                    </p>
                </div>
            </div>
            
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-primary-700 mb-3">Modalidades Inscritas</h3>
                <div class="bg-white border border-gray-200 rounded-md overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Modalidade</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoria</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
        `;
        
        inscricoes.forEach(inscricao => {
            const modalidade = inscricao.modalidade.replace(/-/g, ' ');
            let statusClass = '';
            let statusBg = '';
            let statusIcon = '';
            
            switch(inscricao.status) {
                case 'pendente':
                    statusClass = 'text-yellow-700';
                    statusBg = 'bg-yellow-100';
                    statusIcon = 'clock';
                    break;
                case 'aprovado':
                    statusClass = 'text-green-700';
                    statusBg = 'bg-green-100';
                    statusIcon = 'check-circle';
                    break;
                case 'reprovado':
                    statusClass = 'text-red-700';
                    statusBg = 'bg-red-100';
                    statusIcon = 'times-circle';
                    break;
            }
            
            html += `
                <tr>
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">${modalidade}</td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">${inscricao.categoria}</td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium ${statusClass} ${statusBg} rounded-full">
                            <i class="fas fa-${statusIcon} mr-1"></i>
                            ${inscricao.status.charAt(0).toUpperCase() + inscricao.status.slice(1)}
                        </span>
                    </td>
                </tr>
            `;
        });
        
        html += `
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="bg-primary-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-primary-700 mb-2">Próximos passos</h3>
                <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                    ${statusGeral === 'aprovado' 
                        ? `
                            <li>Confira os detalhes das modalidades em que você foi aprovado.</li>
                            <li>Realize o pagamento da inscrição no valor correspondente ao número de modalidades.</li>
                            <li>Prepare-se para o evento! O calendário será divulgado em breve.</li>
                        ` 
                        : statusGeral === 'reprovado'
                            ? `
                                <li>Entre em contato com a organização pelo WhatsApp para entender os motivos da reprovação.</li>
                                <li>Caso necessário, faça uma nova inscrição corrigindo as pendências identificadas.</li>
                            ` 
                            : `
                                <li>Aguarde a análise da sua inscrição pela equipe organizadora.</li>
                                <li>Você pode verificar o status novamente mais tarde usando seu número de inscrição.</li>
                                <li>Em caso de dúvidas, entre em contato com a organização.</li>
                            `
                    }
                </ol>
            </div>
        `;
        
        resultadoConteudo.innerHTML = html;
    }
    
    // Fechar modal de resultado
    document.querySelectorAll('.modal-close-resultado').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('resultado-modal').classList.add('opacity-0');
            document.getElementById('resultado-modal').classList.add('pointer-events-none');
        });
    });
});
    </script>
</body>
</html>