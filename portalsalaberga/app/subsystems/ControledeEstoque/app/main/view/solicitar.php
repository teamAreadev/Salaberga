<?php
require_once('../model/sessions.php');
$session = new sessions();
$session->autenticar_session();

?>
<?php
// Processar mensagens de URL
$mensagem = '';
$tipoMensagem = '';
$mostrarNotificacao = false;

// Definir variável $barcode para evitar warnings
$barcode = '';

if (isset($_GET['success']) && $_GET['success'] == '1' && isset($_GET['message'])) {
    $mensagem = $_GET['message'];
    $tipoMensagem = 'success';
    $mostrarNotificacao = true;
} elseif (isset($_GET['error']) && $_GET['error'] == '1' && isset($_GET['message'])) {
    $mensagem = $_GET['message'];
    $tipoMensagem = 'error';
    $mostrarNotificacao = true;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Produto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#005A24',
                        secondary: '#FFA500',
                        accent: '#E6F4EA',
                        dark: '#1A3C34',
                        light: '#F8FAF9',
                        white: '#FFFFFF'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif']
                    },
                    boxShadow: {
                        card: '0 10px 15px -3px rgba(0, 90, 36, 0.1), 0 4px 6px -2px rgba(0, 90, 36, 0.05)',
                        'card-hover': '0 20px 25px -5px rgba(0, 90, 36, 0.2), 0 10px 10px -5px rgba(0, 90, 36, 0.1)'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        slideUp: {
                            '0%': {
                                transform: 'translateY(20px)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
            background-color: #F8FAF9;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #005A24 0%, #1A3C34 100%);
        }

        .page-title {
            position: relative;
            display: inline-block;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: #FFA500;
            border-radius: 3px;
        }

        .social-icon {
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px);
            filter: drop-shadow(0 4px 3px rgba(255, 165, 0, 0.3));
        }

        .custom-input,
        .custom-select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #005A24;
            border-radius: 0.5rem;
            font-size: 1rem;
            color: #1A3C34;
            background-color: #F8FAF9;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            text-align: center;
        }

        .custom-select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22%23005A24%22%3E%3Cpath%20d%3D%22M7%2010l5%205%205-5H7z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
            text-align: center;
            text-align-last: center;
        }

        .select-wrapper {
            margin: 0 auto;
            width: 100%;
        }

        .custom-select option {
            text-align: left;
            padding-left: 10px;
        }

        .custom-input:focus,
        .custom-select:focus {
            border-color: #FFA500;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 165, 0, 0.2);
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #FFA500;
            transition: width 0.3s ease;
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #FFA500;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            z-index: 1000;
        }

        .back-to-top.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .back-to-top:hover {
            background-color: #E69500;
            transform: scale(1.1);
        }

        /* Estilos para a sidebar */
        .sidebar-link {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }
        
        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(0.5rem);
        }
        
        .sidebar-link.active {
            background-color: rgba(255, 165, 0, 0.2);
            color: #FFA500;
        }
        
        /* Responsividade da sidebar */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }
            
            #sidebar.show {
                transform: translateX(0);
            }
            
            main {
                margin-left: 0 !important;
            }
            
            /* Botão do menu mobile */
            #menuButton {
                transition: all 0.3s ease;
            }
            
            #menuButton.hidden {
                opacity: 0;
                visibility: hidden;
                transform: scale(0.8);
            }
            
            /* Footer responsivo para mobile */
            footer {
                margin-left: 0 !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            footer .ml-64 {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col font-sans bg-light">
    <!-- Sidebar -->
    <div class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-primary to-dark text-white shadow-xl z-50 transform transition-transform duration-300 ease-in-out" id="sidebar">
        <div class="flex flex-col h-full">
            <!-- Logo e título -->
            <div class="p-6 border-b border-white/20">
                <div class="flex items-center">
                    <img src="../assets/imagens/logostgm.png" alt="Logo STGM" class="h-12 mr-3 transition-transform hover:scale-105">
                    <span class="text-white font-heading text-lg font-semibold">STGM Estoque</span>
                </div>
            </div>
            
            <!-- Menu de navegação -->
            <nav class="flex-1 p-4 space-y-2">
                <a href="paginainicial.php" class="sidebar-link flex items-center p-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-2">
                    <i class="fas fa-home mr-3 text-lg"></i>
                    <span>Início</span>
                </a>
                <a href="estoque.php" class="sidebar-link flex items-center p-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-2">
                    <i class="fas fa-boxes mr-3 text-lg"></i>
                    <span>Estoque</span>
                </a>
                <a href="adicionarproduto.php" class="sidebar-link flex items-center p-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-2">
                    <i class="fas fa-plus-circle mr-3 text-lg"></i>
                    <span>Adicionar</span>
                </a>
                <a href="solicitar.php" class="sidebar-link flex items-center p-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-2 active">
                    <i class="fas fa-clipboard-list mr-3 text-lg"></i>
                    <span>Solicitar</span>
                </a>
                <a href="relatorios.php" class="sidebar-link flex items-center p-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-2">
                    <i class="fas fa-chart-bar mr-3 text-lg"></i>
                    <span>Relatórios</span>
                </a>
            </nav>
            
            <!-- Botão de fechar sidebar no mobile -->
            <div class="p-4 border-t border-white/20 md:hidden">
                <button class="w-full bg-white/10 hover:bg-white/20 text-white py-2 px-4 rounded-lg transition-all duration-200" id="closeSidebar">
                    <i class="fas fa-times mr-2"></i>
                    Fechar Menu
                </button>
            </div>
        </div>
    </div>
    
    <!-- Botão de menu mobile -->
    <button class="fixed top-4 left-4 z-50 md:hidden bg-primary text-white p-3 rounded-lg shadow-lg hover:bg-primary/90 transition-all duration-200" id="menuButton">
        <i class="fas fa-bars text-lg"></i>
    </button>
    
    <!-- Overlay para mobile -->
    <div class="fixed inset-0 bg-black/50 z-40 md:hidden hidden" id="overlay"></div>
    
    <!-- Botão Voltar ao Topo -->
    <button class="back-to-top hidden fixed bottom-6 right-6 z-50 bg-secondary hover:bg-secondary/90 text-white w-12 h-12 rounded-full shadow-lg transition-all duration-300 flex items-center justify-center group">
        <i class="fas fa-chevron-up text-lg group-hover:scale-110 transition-transform duration-300"></i>
    </button>

    <!-- Main content -->
    <main class="ml-64 px-4 py-8 md:py-12 flex-1 transition-all duration-300">
        <div class="text-center mb-10">
            <h1 class="text-primary text-3xl md:text-4xl font-bold mb-8 md:mb-6 text-center page-title tracking-tight font-heading inline-block mx-auto">SOLICITAR PRODUTO</h1>
        </div>

        <!-- Notificação -->
        <div id="notificacao" class="max-w-2xl mx-auto mb-4 <?php echo isset($_SESSION['erro_solicitacao']) ? '' : 'hidden'; ?>">
            <div id="notificacaoConteudo" class="p-4 rounded-lg shadow-lg bg-red-500 text-white">
                <div class="flex items-center">
                    <i id="notificacaoIcon" class="fas fa-exclamation-circle mr-2"></i>
                    <span id="notificacaoTexto"><?php echo $_SESSION['erro_solicitacao'] ?? 'Erro desconhecido'; ?></span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl w-full border-2 border-primary mx-auto">
            <form action="../control/controllersolicitar.php" method="POST" class="space-y-6" id="solicitarForm">
                <div class="space-y-4">
                    <!-- Opções de seleção de produto -->
                    <div class="mb-4">
                        <div class="flex space-x-2 mb-3">
                            <button type="button" id="btnSelect" class="flex-1 bg-primary text-white py-2 px-4 rounded-lg font-semibold transition-colors" onclick="mostrarOpcao('select')">
                                <i class="fas fa-list mr-2"></i>Selecionar da Lista
                            </button>
                            <button type="button" id="btnBarcode" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg font-semibold transition-colors" onclick="mostrarOpcao('barcode')">
                                <i class="fas fa-barcode mr-2"></i>Ler Código de Barras
                            </button>
                        </div>
                    </div>

                    <!-- Opção 1: Select de produtos -->
                    <div id="opcaoSelect" class="select-wrapper">
                        <select id="produto" name="produto" required class="custom-select" aria-label="Selecionar produto" onchange="validarSelecao()">
                            <option value="" disabled selected>SELECIONAR PRODUTO</option>
                            <?php
                            require_once('../model/functionsViews.php');
                            $select = new select();
                            $resultado = $select->selectSolicitarProdutos(null);
                            if ($resultado) {
                                foreach ($resultado as $produto) {
                                    echo "<option value=\"{$produto['id']}\">{$produto['nome_produto']} (Estoque: {$produto['quantidade']})</option>";
                                }
                            } else {
                                echo "<option value=\"\">Nenhum produto disponível</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Opção 2: Input para código de barras -->
                    <div id="opcaoBarcode" class="hidden">
                        <div class="relative">
                            <input type="text" id="barcodeInput" name="barcode" value="<? echo $_GET['barcode'] ?? ''?>" placeholder="ESCANEIE O CÓDIGO DE BARRAS" 
                                   class="custom-input text-center text-lg font-mono tracking-wider" 
                                   aria-label="Código de barras">
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-barcode text-gray-400"></i>
                            </div>
                        </div>
                        <div id="produtoInfo" class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg hidden">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-green-800" id="produtoNome"></p>
                                    <p class="text-sm text-green-600" id="produtoEstoque"></p>
                                </div>
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                            </div>
                        </div>
                        <input type="hidden" id="produtoIdHidden" name="produto" value="">
                    </div>

                    <div>
                        <input type="number" placeholder="QUANTIDADE" min="1" id="quantidade" name="quantidade" required
                            class="custom-input" aria-label="Quantidade do produto">
                    </div>

                    <div class="select-wrapper">
                        <select id="retirante" name="retirante" required class="custom-select" aria-label="Selecionar retirante">
                            <option value="" disabled selected>SELECIONAR RESPONSÁVEL</option>
                            <?php
                            require_once('../model/functionsViews.php');
                            $select = new select();
                            $resultado = $select->selectSolicitarResponsaveis(null);
                            if ($resultado) {
                                foreach ($resultado as $responsavel) {
                                    echo "<option value=\"{$responsavel['id']}\">{$responsavel['nome']}</option>";
                                }
                            } else {
                                echo "<option value=\"\">Nenhum responsável disponível</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <button type="submit" name="btn" class="w-full bg-secondary text-white font-bold py-3 px-4 rounded-lg hover:bg-opacity-90 transition-colors"
                    aria-label="Confirmar solicitação">
                    CONFIRMAR
                </button>
            </form>
        </div>
    </main>

    <footer class="bg-gradient-to-r from-primary to-dark text-white py-8 md:py-10 mt-auto relative transition-all duration-300">
        <!-- Efeito de brilho sutil no topo -->
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-secondary to-transparent opacity-30"></div>
        
        <div class="ml-64 px-4 md:px-8 transition-all duration-300" id="footerContent">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                    <!-- Sobre a Escola -->
                    <div class="group">
                        <h3 class="font-heading text-lg md:text-xl font-semibold mb-4 flex items-center text-white group-hover:text-secondary transition-colors duration-300">
                            <i class="fas fa-school mr-3 text-secondary group-hover:scale-110 transition-transform duration-300"></i>
                            EEEP STGM
                        </h3>
                        <p class="text-sm md:text-base leading-relaxed text-gray-200 group-hover:text-white transition-colors duration-300">
                            <i class="fas fa-map-marker-alt mr-2 text-secondary"></i>
                            AV. Marta Maria Carvalho Nojoza, SN<br>
                            Maranguape - CE
                        </p>
                    </div>

                    <!-- Contato -->
                    <div class="group">
                        <h3 class="font-heading text-lg md:text-xl font-semibold mb-4 flex items-center text-white group-hover:text-secondary transition-colors duration-300">
                            <i class="fas fa-address-book mr-3 text-secondary group-hover:scale-110 transition-transform duration-300"></i>
                            Contato
                        </h3>
                        <div class="space-y-3">
                            <a href="tel:+558533413990" class="flex items-center text-sm md:text-base text-gray-200 hover:text-white transition-colors duration-300 group/item">
                                <i class="fas fa-phone-alt mr-3 text-secondary group-hover/item:scale-110 transition-transform duration-300"></i>
                                (85) 3341-3990
                            </a>
                            <a href="mailto:eeepsantariamata@gmail.com" class="flex items-center text-sm md:text-base text-gray-200 hover:text-white transition-colors duration-300 group/item">
                                <i class="fas fa-envelope mr-3 text-secondary group-hover/item:scale-110 transition-transform duration-300"></i>
                                eeepsantariamata@gmail.com
                            </a>
                        </div>
                    </div>

                    <!-- Desenvolvedores -->
                    <div class="group">
                        <h3 class="font-heading text-lg md:text-xl font-semibold mb-4 flex items-center text-white group-hover:text-secondary transition-colors duration-300">
                            <i class="fas fa-code mr-3 text-secondary group-hover:scale-110 transition-transform duration-300"></i>
                            Dev Team
                        </h3>
                        <div class="grid grid-cols-1 gap-3">
                            <a href="#" class="flex items-center text-sm md:text-base text-gray-200 hover:text-white transition-all duration-300 group/item hover:translate-x-1">
                                <i class="fab fa-instagram mr-3 text-secondary group-hover/item:scale-110 transition-transform duration-300"></i>
                                Matheus Felix
                            </a>
                            <a href="#" class="flex items-center text-sm md:text-base text-gray-200 hover:text-white transition-all duration-300 group/item hover:translate-x-1">
                                <i class="fab fa-instagram mr-3 text-secondary group-hover/item:scale-110 transition-transform duration-300"></i>
                                Roger Cavalcante
                            </a>
                            <a href="#" class="flex items-center text-sm md:text-base text-gray-200 hover:text-white transition-all duration-300 group/item hover:translate-x-1">
                                <i class="fab fa-instagram mr-3 text-secondary group-hover/item:scale-110 transition-transform duration-300"></i>
                                Matheus Machado
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Rodapé inferior -->
                <div class="border-t border-white/20 pt-6 mt-8 text-center">
                    <p class="text-sm md:text-base text-gray-300 hover:text-white transition-colors duration-300">
                        © 2024 STGM v1.2.0 | Desenvolvido por alunos EEEP STGM
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Efeito de brilho sutil na base -->
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-secondary to-transparent opacity-30"></div>
    </footer>

    <script>
        let opcaoAtual = 'select';
        let produtoSelecionado = null;

        function mostrarOpcao(opcao) {
            const btnSelect = document.getElementById('btnSelect');
            const btnBarcode = document.getElementById('btnBarcode');
            const opcaoSelect = document.getElementById('opcaoSelect');
            const opcaoBarcode = document.getElementById('opcaoBarcode');
            const produtoSelect = document.getElementById('produto');
            const barcodeInput = document.getElementById('barcodeInput');

            produtoSelect.value = '';
            barcodeInput.value = '';
            document.getElementById('produtoInfo').classList.add('hidden');
            document.getElementById('produtoIdHidden').value = '';
            produtoSelecionado = null;

            if (opcao === 'select') {
                btnSelect.className = 'flex-1 bg-primary text-white py-2 px-4 rounded-lg font-semibold transition-colors';
                btnBarcode.className = 'flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg font-semibold transition-colors';
                opcaoSelect.classList.remove('hidden');
                opcaoBarcode.classList.add('hidden');
                produtoSelect.required = true;
                produtoSelect.removeAttribute('disabled');
                barcodeInput.required = false;
                barcodeInput.setAttribute('disabled', 'disabled');
                opcaoAtual = 'select';
            } else {
                btnSelect.className = 'flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg font-semibold transition-colors';
                btnBarcode.className = 'flex-1 bg-primary text-white py-2 px-4 rounded-lg font-semibold transition-colors';
                opcaoSelect.classList.add('hidden');
                opcaoBarcode.classList.remove('hidden');
                produtoSelect.required = false;
                produtoSelect.setAttribute('disabled', 'disabled');
                barcodeInput.required = true;
                barcodeInput.removeAttribute('disabled');
                opcaoAtual = 'barcode';
                setTimeout(() => barcodeInput.focus(), 100);
            }
        }

        async function buscarProdutoPorBarcode(barcode) {
            try {
                const response = await fetch(`../control/controllerBuscarProduto.php?barcode=${encodeURIComponent(barcode)}`);
                const data = await response.json();
                if (data.success && data.produto) {
                    return data.produto;
                } else {
                    throw new Error(data.error || 'Produto não encontrado');
                }
            } catch (error) {
                console.error('Erro ao buscar produto:', error);
                return null;
            }
        }

        function exibirProdutoInfo(produto) {
            const produtoInfo = document.getElementById('produtoInfo');
            const produtoNome = document.getElementById('produtoNome');
            const produtoEstoque = document.getElementById('produtoEstoque');
            const produtoIdHidden = document.getElementById('produtoIdHidden');

            produtoNome.textContent = produto.nome_produto;
            produtoEstoque.textContent = `Estoque: ${produto.quantidade} unidades`;
            produtoInfo.classList.remove('hidden');
            produtoSelecionado = produto;
            produtoIdHidden.value = produto.id;
        }

        function validarSelecao() {
            const produtoSelect = document.getElementById('produto');
            if (produtoSelect.value !== '' && produtoSelect.value !== null) {
                produtoSelecionado = { id: produtoSelect.value };
                console.log('Produto selecionado:', produtoSelecionado);
            } else {
                produtoSelecionado = null;
            }
        }

        function validarFormulario() {
            if (opcaoAtual === 'select') {
                const produtoSelect = document.getElementById('produto');
                return produtoSelect.value !== '' && produtoSelect.value !== null;
            } else {
                const produtoIdHidden = document.getElementById('produtoIdHidden');
                return produtoSelecionado !== null && produtoIdHidden.value !== '';
            }
        }

        function mostrarNotificacao(mensagem, tipo) {
            const notificacao = document.getElementById('notificacao');
            const notificacaoConteudo = document.getElementById('notificacaoConteudo');
            const notificacaoIcon = document.getElementById('notificacaoIcon');
            const notificacaoTexto = document.getElementById('notificacaoTexto');

            notificacaoTexto.textContent = mensagem;
            if (tipo === 'success') {
                notificacaoConteudo.className = 'p-4 rounded-lg shadow-lg bg-green-500 text-white';
                notificacaoIcon.className = 'fas fa-check-circle mr-2';
            } else if (tipo === 'error') {
                notificacaoConteudo.className = 'p-4 rounded-lg shadow-lg bg-red-500 text-white';
                notificacaoIcon.className = 'fas fa-exclamation-circle mr-2';
            }
            notificacao.classList.remove('hidden');
            setTimeout(() => notificacao.classList.add('hidden'), 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar mobile toggle
            const menuButton = document.getElementById('menuButton');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const closeSidebar = document.getElementById('closeSidebar');

            if (menuButton && sidebar) {
                menuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('hidden');
                    
                    // Mostrar/ocultar o botão do menu
                    if (sidebar.classList.contains('show')) {
                        menuButton.classList.add('hidden');
                    } else {
                        menuButton.classList.remove('hidden');
                    }
                    
                    document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
                });

                // Fechar sidebar ao clicar no overlay
                if (overlay) {
                    overlay.addEventListener('click', function() {
                        sidebar.classList.remove('show');
                        overlay.classList.add('hidden');
                        menuButton.classList.remove('hidden');
                        document.body.style.overflow = '';
                    });
                }

                // Fechar sidebar ao clicar no botão fechar
                if (closeSidebar) {
                    closeSidebar.addEventListener('click', function() {
                        sidebar.classList.remove('show');
                        overlay.classList.add('hidden');
                        menuButton.classList.remove('hidden');
                        document.body.style.overflow = '';
                    });
                }

                // Fechar sidebar ao clicar em um link
                const navLinks = sidebar.querySelectorAll('a');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.remove('show');
                            overlay.classList.add('hidden');
                            menuButton.classList.remove('hidden');
                            document.body.style.overflow = '';
                        }
                    });
                });

                // Fechar sidebar ao pressionar ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        overlay.classList.add('hidden');
                        menuButton.classList.remove('hidden');
                        document.body.style.overflow = '';
                    }
                });
                
                // Ajustar footer quando sidebar é aberta/fechada no mobile
                const footerContent = document.getElementById('footerContent');
                if (footerContent) {
                    const adjustFooter = () => {
                        if (window.innerWidth <= 768) {
                            if (sidebar.classList.contains('show')) {
                                footerContent.style.marginLeft = '0';
                            } else {
                                footerContent.style.marginLeft = '0';
                            }
                        } else {
                            footerContent.style.marginLeft = '16rem'; // 64 * 0.25rem = 16rem
                        }
                    };
                    
                    // Ajustar na inicialização
                    adjustFooter();
                    
                    // Ajustar quando a sidebar é aberta/fechada
                    menuButton.addEventListener('click', adjustFooter);
                    
                    // Ajustar quando a janela é redimensionada
                    window.addEventListener('resize', adjustFooter);
                }
            }

            // Back to top button visibility and functionality
            const backToTop = document.querySelector('.back-to-top');
            if (backToTop) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 300) {
                        backToTop.classList.add('visible');
                        backToTop.classList.remove('hidden');
                    } else {
                        backToTop.classList.remove('visible');
                        backToTop.classList.add('hidden');
                    }
                });
                
                // Funcionalidade do botão voltar ao topo
                backToTop.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            <?php if (isset($_SESSION['erro_solicitacao'])): ?>
                mostrarNotificacao('<?php echo addslashes($_SESSION['erro_solicitacao']); ?>', 'error');
                <?php unset($_SESSION['erro_solicitacao']); ?>
            <?php endif; ?>
            
            // Verificar se há barcode na URL e buscar produto automaticamente
            <?php if (isset($_GET['barcode']) && !empty($_GET['barcode'])): ?>
            const barcodeFromURL = '<?php echo htmlspecialchars($_GET['barcode']); ?>';
            if (barcodeFromURL) {
                // Mudar para opção de barcode
                mostrarOpcao('barcode');
                
                // Definir o valor no input
                const barcodeInput = document.getElementById('barcodeInput');
                if (barcodeInput) {
                    barcodeInput.value = barcodeFromURL;
                    
                    // Buscar produto automaticamente
                    setTimeout(() => {
                        buscarProdutoPorBarcode(barcodeFromURL).then(produto => {
                            if (produto) {
                                exibirProdutoInfo(produto);
                                // Mostrar notificação de sucesso
                                mostrarNotificacao(`Produto encontrado: ${produto.nome_produto}`, 'success');
                            } else {
                                mostrarNotificacao('Produto não encontrado para este código de barras', 'error');
                            }
                        });
                    }, 500);
                }
            }
            <?php endif; ?>

            const barcodeInput = document.getElementById('barcodeInput');
            if (barcodeInput) {
                let timeoutId;
                barcodeInput.addEventListener('input', function(e) {
                    clearTimeout(timeoutId);
                    const barcode = e.target.value.trim();
                    if (barcode.length >= 3) {
                        timeoutId = setTimeout(async () => {
                            const produto = await buscarProdutoPorBarcode(barcode);
                            if (produto) {
                                exibirProdutoInfo(produto);
                            } else {
                                document.getElementById('produtoInfo').classList.add('hidden');
                                produtoSelecionado = null;
                            }
                        }, 500);
                    } else {
                        document.getElementById('produtoInfo').classList.add('hidden');
                        produtoSelecionado = null;
                    }
                });

                barcodeInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const barcode = e.target.value.trim();
                        if (barcode) {
                            buscarProdutoPorBarcode(barcode).then(produto => {
                                if (produto) {
                                    exibirProdutoInfo(produto);
                                }
                            });
                        }
                    }
                });
            }

            const form = document.getElementById('solicitarForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const valido = validarFormulario();
                    console.log('Validação:', valido, 'Opção:', opcaoAtual, 'Produto:', document.getElementById('produto').value, 'Dados:', new FormData(form));
                    if (!valido) {
                        e.preventDefault();
                        let mensagem = 'Por favor, selecione um produto antes de continuar.';
                        if (opcaoAtual === 'barcode' && !produtoSelecionado) {
                            mensagem = 'Por favor, escaneie um código de barras válido antes de continuar.';
                        } else if (opcaoAtual === 'select' && document.getElementById('produto').value === '') {
                            mensagem = 'Por favor, selecione um produto da lista antes de continuar.';
                        }
                        mostrarNotificacao(mensagem, 'error');
                        return false;
                    }
                });
            }
        });
    </script>
</body>

</html>