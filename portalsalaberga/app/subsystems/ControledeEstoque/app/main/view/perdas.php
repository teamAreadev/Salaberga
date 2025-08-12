<?php
        require_once('../model/sessions.php');
        require_once('../model/functionsViews.php');
        $select = new select();
        $session = new sessions();
        $session->autenticar_session();
        
    ?>
<?php
// Processar mensagens de URL
$mensagem = '';
$tipoMensagem = '';
$mostrarAlerta = false;

if (isset($_GET['success']) && $_GET['success'] == '1' && isset($_GET['message'])) {
    $mensagem = $_GET['message'];
    $tipoMensagem = 'success';
    $mostrarAlerta = true;
} elseif (isset($_GET['error']) && $_GET['error'] == '1' && isset($_GET['message'])) {
    $mensagem = $_GET['message'];
    $tipoMensagem = 'error';
    $mostrarAlerta = true;
} elseif (isset($_GET['mensagem'])) {
    $mensagem = $_GET['mensagem'];
    $tipoMensagem = 'success';
    $mostrarAlerta = true;
} elseif (isset($_GET['erro'])) {
    $mensagem = $_GET['erro'];
    $tipoMensagem = 'error';
    $mostrarAlerta = true;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Perdas - Estoque</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; background-color: #F8FAF9; }
        .gradient-bg { background: linear-gradient(135deg, #005A24 0%, #1A3C34 100%); }
        .page-title { position: relative; display: inline-block; }
        .page-title::after { content: ''; position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background-color: #FFA500; border-radius: 3px; }
        .header-nav-link { position: relative; transition: all 0.3s ease; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.5rem; }
        .header-nav-link:hover { background-color: rgba(255,255,255,0.1); }
        .header-nav-link::after { content: ''; position: absolute; bottom: -2px; left: 50%; width: 0; height: 2px; background-color: #FFA500; transition: all 0.3s ease; transform: translateX(-50%); }
        .header-nav-link:hover::after, .header-nav-link.active::after { width: 80%; }
        .header-nav-link.active { background-color: rgba(255,255,255,0.15); }
        .mobile-menu-button { display: none; }
        @media (max-width: 768px) {
            .header-nav { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, #005A24 0%, #1A3C34 100%); padding: 2rem 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); z-index: 50; flex-direction: column; justify-content: center; align-items: center; backdrop-filter: blur(10px); }
            .header-nav.show { display: flex; animation: slideIn 0.3s ease-out; }
            @keyframes slideIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
            .header-nav-link { padding: 1rem 1.5rem; text-align: center; margin: 0.5rem 0; font-size: 1.1rem; border-radius: 0.75rem; transition: all 0.3s ease; width: 100%; max-width: 300px; }
            .header-nav-link:hover { background-color: rgba(255,255,255,0.15); transform: translateX(5px); }
            .mobile-menu-button { display: flex; flex-direction: column; justify-content: space-between; width: 30px; height: 21px; background: transparent; border: none; cursor: pointer; padding: 0; z-index: 60; position: relative; }
            .mobile-menu-button span { width: 100%; height: 3px; background-color: white; border-radius: 10px; transition: all 0.3s ease; position: relative; transform-origin: center; }
            .mobile-menu-button span:first-child.active { transform: rotate(45deg) translate(6px, 6px); }
            .mobile-menu-button span:nth-child(2).active { opacity: 0; transform: scale(0); }
            .mobile-menu-button span:nth-child(3).active { transform: rotate(-45deg) translate(6px, -6px); }
            .header-nav::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: -1; }
        }
        .desktop-table { display: block; width: 100%; }
        .mobile-cards { display: none; }
        @media screen and (max-width: 768px) { .desktop-table { display: none; } .mobile-cards { display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1rem; padding: 0 0.5rem; width: 100%; } .card-item { margin-bottom: 0.75rem; } .categoria-header { margin-top: 1.5rem; margin-bottom: 0.75rem; } }
        .card-item { transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .card-item:hover { transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .max-w-5xl { max-width: 64rem; width: 100%; }
        .flex-1.w-full { max-width: 100%; }
    </style>
</head>
<body class="min-h-screen flex flex-col font-sans bg-light">
    <!-- Header -->
    <header class="sticky top-0 bg-gradient-to-r from-primary to-dark text-white py-4 shadow-lg z-50">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="../assets/imagens/logostgm.png" alt="Logo STGM" class="h-12 mr-3 transition-transform hover:scale-105">
                <span class="text-white font-heading text-xl font-semibold hidden md:inline">STGM Estoque</span>
            </div>
            <button class="mobile-menu-button focus:outline-none" aria-label="Menu" id="menuButton">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="header-nav md:flex items-center space-x-1" id="headerNav">
                <a href="paginainicial.php" class="header-nav-link flex items-center"><i class="fas fa-home mr-2"></i><span>Início</span></a>
                <a href="estoque.php" class="header-nav-link flex items-center"><i class="fas fa-boxes mr-2"></i><span>Estoque</span></a>
                <a href="adicionarproduto.php" class="header-nav-link flex items-center"><i class="fas fa-plus-circle mr-2"></i><span>Adicionar</span></a>
                <a href="solicitar.php" class="header-nav-link flex items-center cursor-pointer"><i class="fas fa-clipboard-list mr-2"></i><span>Solicitar</span></a>
              
                <a href="relatorios.php" class="header-nav-link flex items-center"><i class="fas fa-chart-bar mr-2"></i><span>Relatórios</span></a>
            </nav>
        </div>
    </header>
    <main class="container mx-auto px-4 py-8 md:py-12 flex-1">
        <div class="text-center mb-10">
            <h1 class="text-primary text-3xl md:text-4xl font-bold mb-8 md:mb-6 text-center page-title tracking-tight font-heading inline-block mx-auto">GERENCIAR PERDAS</h1>
        </div>
        
        <!-- Formulário para registrar perda -->
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-4xl w-full border-2 border-primary mx-auto mb-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-primary mb-2">Registrar Nova Perda</h2>
                <p class="text-gray-600">Preencha os dados abaixo para registrar uma perda no estoque</p>
            </div>
            
            <form action="../control/controller_main.php" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="produto_id" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-box text-primary mr-2"></i>
                            Produto
                        </label>
                        <select class="js-example-basic-single" name="id_produto">
                            <option value="">Selecione o produto</option>
                            <?php
                            $dados = $select->selectProdutosTotal();
                            foreach($dados as $dado){
                            ?>
                            <option value="<?= htmlspecialchars($dado['id']) ?>"><?= htmlspecialchars($dado['nome_produto']) ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="quantidade_perdida" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-sort-numeric-down text-primary mr-2"></i>
                            Quantidade Perdida
                        </label>
                        <input type="number" id="quantidade_perdida" name="quantidade_perdida" min="1" required 
                               class="w-full px-4 py-3 border-2 border-primary/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-all duration-200 hover:border-primary/50 bg-white shadow-sm"
                               placeholder="Ex: 5">
                    </div>
                </div>
                
                <!-- Segunda linha: Tipo de Perda e Data -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="tipo_perda" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-tag text-primary mr-2"></i>
                            Tipo de Perda
                        </label>
                        <select id="tipo_perda" name="tipo_perda" required 
                                class="w-full px-4 py-3 border-2 border-primary/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-all duration-200 hover:border-primary/50 bg-white shadow-sm">
                            <option value="">Selecione o tipo de perda</option>
                            <option value="Dano Físico" class="py-2">🚨 Dano Físico</option>
                            <option value="Vencimento" class="py-2">⏰ Vencimento</option>
                            <option value="Desaparecimento" class="py-2">🔍 Desaparecimento</option>
                            <option value="Má conservacao" class="py-2">🌡️ Má Conservação</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="data_perda" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-calendar-alt text-primary mr-2"></i>
                            Data da Perda
                        </label>
                        <input type="date" id="data_perda" name="data_perda" required 
                               class="w-full px-4 py-3 border-2 border-primary/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-all duration-200 hover:border-primary/50 bg-white shadow-sm">
                    </div>
                </div>
                
               
                
                <!-- Botão de envio -->
                <div class="pt-4 flex justify-center">
                    <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 text-white font-bold py-3 px-8 rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        Registrar Perda
                    </button>
                </div>
            </form>
        </div>
        

        
        <!-- Botões de ação -->
        <div class="mt-12 flex justify-center w-full gap-6">
            <a href="estoque.php" class="group">
                <button class="bg-gradient-to-r from-primary to-primary/90 text-white font-bold py-4 px-8 rounded-xl hover:from-primary/90 hover:to-primary transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center">
                    <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform duration-300"></i>
                    Voltar ao Estoque
                </button>
            </a>
           
        </div>
        
        <!-- Alerta de mensagem -->
        <div id="alertaMensagem" class="fixed bottom-4 right-4 p-4 rounded-lg shadow-lg max-w-md hidden animate-fade-in z-50">
            <div class="flex items-center">
                <svg id="alertaIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"></svg>
                <span id="mensagemTexto">Operação realizada com sucesso!</span>
            </div>
        </div>
    </main>
    <footer class="bg-gradient-to-r from-primary to-dark text-white py-6 mt-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="font-heading text-lg font-semibold mb-3 flex items-center"><i class="fas fa-school mr-2 text-sm"></i>EEEP STGM</h3>
                    <p class="text-xs leading-relaxed"><i class="fas fa-map-marker-alt mr-1 text-xs"></i> AV. Marta Maria Carvalho Nojoza, SN<br>Maranguape - CE</p>
                </div>
                <div>
                    <h3 class="font-heading text-lg font-semibold mb-3 flex items-center"><i class="fas fa-address-book mr-2 text-sm"></i>Contato</h3>
                    <div class="text-xs leading-relaxed space-y-1">
                        <p class="flex items-start"><i class="fas fa-phone-alt mr-1 mt-0.5 text-xs"></i>(85) 3341-3990</p>
                        <p class="flex items-start"><i class="fas fa-envelope mr-1 mt-0.5 text-xs"></i>eeepsantariamata@gmail.com</p>
                    </div>
                </div>
                <div>
                    <h3 class="font-heading text-lg font-semibold mb-3 flex items-center"><i class="fas fa-code mr-2 text-sm"></i>Dev Team</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="https://www.instagram.com/dudu.limasx/" target="_blank" class="text-xs flex items-center hover:text-secondary transition-colors"><i class="fab fa-instagram mr-1 text-xs"></i>Carlos E.</a>
                        <a href="https://www.instagram.com/millenafreires_/" target="_blank" class="text-xs flex items-center hover:text-secondary transition-colors"><i class="fab fa-instagram mr-1 text-xs"></i>Millena F.</a>
                        <a href="https://www.instagram.com/matheusz.mf/" target="_blank" class="text-xs flex items-center hover:text-secondary transition-colors"><i class="fab fa-instagram mr-1 text-xs"></i>Matheus M.</a>
                        <a href="https://www.instagram.com/yanlucas10__/" target="_blank" class="text-xs flex items-center hover:text-secondary transition-colors"><i class="fab fa-instagram mr-1 text-xs"></i>Ian Lucas</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/20 pt-4 mt-4 text-center">
                <p class="text-xs">© 2024 STGM v1.2.0 | Desenvolvido por alunos EEEP STGM</p>
            </div>
        </div>
    </footer>
    <script>
        $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
    document.addEventListener('DOMContentLoaded', function() {
        // Menu mobile toggle
        const menuButton = document.getElementById('menuButton');
        const headerNav = document.getElementById('headerNav');
        if (menuButton && headerNav) {
            menuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                headerNav.classList.toggle('show');
                const spans = menuButton.querySelectorAll('span');
                spans.forEach(span => { span.classList.toggle('active'); });
                document.body.style.overflow = headerNav.classList.contains('show') ? 'hidden' : '';
            });
            // Fechar menu ao clicar em um link
            const navLinks = headerNav.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    headerNav.classList.remove('show');
                    const spans = menuButton.querySelectorAll('span');
                    spans.forEach(span => { span.classList.remove('active'); });
                    document.body.style.overflow = '';
                });
            });
            // Fechar menu ao clicar fora
            document.addEventListener('click', function(e) {
                if (!headerNav.contains(e.target) && !menuButton.contains(e.target)) {
                    headerNav.classList.remove('show');
                    const spans = menuButton.querySelectorAll('span');
                    spans.forEach(span => { span.classList.remove('active'); });
                    document.body.style.overflow = '';
                }
            });
            // Fechar menu ao pressionar ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && headerNav.classList.contains('show')) {
                    headerNav.classList.remove('show');
                    const spans = menuButton.querySelectorAll('span');
                    spans.forEach(span => { span.classList.remove('active'); });
                    document.body.style.overflow = '';
                }
            });
        }

        // Definir data atual no campo de data
        const dataPerdaInput = document.getElementById('data_perda');
        if (dataPerdaInput) {
            const hoje = new Date().toISOString().split('T')[0];
            dataPerdaInput.value = hoje;
        }

        // Mostrar alerta se houver mensagem
        <?php if ($mostrarAlerta): ?>
        try {
            mostrarAlerta('<?php echo addslashes($mensagem); ?>', '<?php echo $tipoMensagem; ?>');
        } catch (error) {
            console.error('Erro ao inicializar alerta:', error);
        }
        <?php endif; ?>
    });

    // Função para mostrar alertas
    window.mostrarAlerta = function(mensagem, tipo) {
        const alerta = document.getElementById('alertaMensagem');
        const mensagemTexto = document.getElementById('mensagemTexto');
        const alertaIcon = document.getElementById('alertaIcon');
        
        if (!alerta || !mensagemTexto || !alertaIcon) {
            return;
        }
        
        mensagemTexto.textContent = mensagem;
        
        if (tipo === 'success') {
            alerta.className = 'fixed bottom-4 right-4 p-4 rounded-lg shadow-lg max-w-md z-50 bg-green-500 text-white';
            alertaIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
        } else if (tipo === 'error') {
            alerta.className = 'fixed bottom-4 right-4 p-4 rounded-lg shadow-lg max-w-md z-50 bg-red-500 text-white';
            alertaIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />';
        }
        
        alerta.classList.remove('hidden');
        
        // Auto-hide após 5 segundos
        setTimeout(() => {
            alerta.classList.add('hidden');
        }, 5000);
    };
    </script>
</body>
</html>
