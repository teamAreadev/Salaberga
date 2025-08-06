

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Estoque</title>
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
        .quantidade-critica { color: #FF0000; font-weight: bold; }
        .max-w-5xl { max-width: 64rem; width: 100%; }
        .flex-1.w-full { max-width: 100%; }
        #exportarBtn { margin-top: 1.5rem; }
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
                <a href="estoque.php" class="header-nav-link active flex items-center"><i class="fas fa-boxes mr-2"></i><span>Estoque</span></a>
                <a href="adicionarproduto.php" class="header-nav-link flex items-center"><i class="fas fa-plus-circle mr-2"></i><span>Adicionar</span></a>
                <a href="solicitar.php" class="header-nav-link flex items-center cursor-pointer"><i class="fas fa-clipboard-list mr-2"></i><span>Solicitar</span></a>
                <a href="relatorios.php" class="header-nav-link flex items-center"><i class="fas fa-chart-bar mr-2"></i><span>Relatórios</span></a>
            </nav>
        </div>
    </header>
    <main class="container mx-auto px-4 py-8 md:py-12 flex-1">
        <div class="text-center mb-10">
            <h1 class="text-primary text-3xl md:text-4xl font-bold mb-8 md:mb-6 text-center page-title tracking-tight font-heading inline-block mx-auto">VISUALIZAR ESTOQUE</h1>
        </div>
        <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4 max-w-5xl mx-auto">
            <div class="flex-1 w-full">
                <input type="text" id="pesquisar" placeholder="Pesquisar produto..." class="w-full px-4 py-3 border-2 border-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
            </div>
            <div class="flex gap-2 flex-wrap justify-center">
                <select id="filtroCategoria" class="px-4 py-3 border-2 border-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                    <option value="">Todas as categorias</option>
                    <option value="limpeza">Limpeza</option>
                    <option value="expedientes">Expedientes</option>
                    <option value="manutencao">Manutenção</option>
                    <option value="eletrico">Elétrico</option>
                    <option value="hidraulico">Hidráulico</option>
                    <option value="educacao_fisica">Educação Física</option>
                    <option value="epi">EPI</option>
                    <option value="copa_e_cozinha">Copa e Cozinha</option>
                    <option value="informatica">Informática</option>
                    <option value="ferramentas">Ferramentas</option>
                </select>
                <button id="filtrarBtn" class="bg-secondary text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-colors">
                    Filtrar
                </button>
                <a href="relatorio_por_data.php" class="bg-primary text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-colors flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Relatório por Data
                </a>
            </div>
        </div>
        <!-- Tabela para desktop -->
        <div class="desktop-table bg-white rounded-xl shadow-lg overflow-hidden border-2 border-primary max-w-5xl mx-auto">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">Barcode</th>
                            <th class="py-3 px-4 text-left">Nome</th>
                            <th class="py-3 px-4 text-left">Quantidade</th>
                            <th class="py-3 px-4 text-left">Categoria</th>
                            <th class="py-3 px-4 text-left">Data</th>
                            <th class="py-3 px-4 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaEstoque">
                        <?php
                        if (isset($_GET['resultado'])) {
                            $resultado = json_decode($_GET['resultado'], true);
                            if (is_array($resultado) && count($resultado) > 0) {
                                foreach ($resultado as $produto) {
                                    $quantidadeClass = $produto['quantidade'] <= 5 ? 'text-red-600 font-bold' : 'text-gray-700';
                        ?>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-4"><?php echo htmlspecialchars($produto['barcode']); ?></td>
                                        <td class="py-3 px-4"><?php echo htmlspecialchars($produto['nome_produto']); ?></td>
                                        <td class="py-3 px-4 <?php echo $quantidadeClass; ?>"><?php echo htmlspecialchars($produto['quantidade']); ?></td>
                                        <td class="py-3 px-4"><?php echo htmlspecialchars($produto['natureza']); ?></td>
                                        <td class="py-3 px-4">
                                            <?php echo isset($produto['data']) ? date('d/m/Y H:i', strtotime($produto['data'])) : 'N/A'; ?>
                                        </td>
                                        <td class="py-3 px-4 flex space-x-2">
                                            <button class="text-primary hover:text-secondary mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <button class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                        <?php
                                }
                            } else {
                                echo '<tr><td colspan="6" class="py-4 px-4 text-center text-gray-500">Nenhum produto encontrado</td></tr>';
                            }
                        } else {
                            echo '<tr><td colspan="6" class="py-4 px-4 text-center text-gray-500">Carregando produtos...</td></tr>';
                        }
                        ?>
                        <!-- Exemplos estáticos para visualização -->
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4">001</td>
                            <td class="py-3 px-4">Papel A4</td>
                            <td class="py-3 px-4">100</td>
                            <td class="py-3 px-4">Expedientes</td>
                            <td class="py-3 px-4">01/08/2024 10:30</td>
                            <td class="py-3 px-4">
                                <button class="text-primary hover:text-secondary mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <button class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4">002</td>
                            <td class="py-3 px-4">Detergente</td>
                            <td class="py-3 px-4">50</td>
                            <td class="py-3 px-4">Limpeza</td>
                            <td class="py-3 px-4">02/08/2024 14:15</td>
                            <td class="py-3 px-4">
                                <button class="text-primary hover:text-secondary mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <button class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Cards para mobile -->
        <div class="mobile-cards mt-6 max-w-5xl mx-auto">
            <?php
            if ($produtos && count($produtos) > 0) {
                $categoriaAtual = '';
                foreach ($produtos as $produto) {
                    if ($categoriaAtual != $produto['natureza']) {
                        $categoriaAtual = $produto['natureza'];
                        echo '<div class="bg-primary text-white font-bold py-2 px-4 rounded-lg mt-6 mb-3 categoria-header"><h3 class="text-sm uppercase tracking-wider">' . htmlspecialchars(ucfirst($produto['natureza'])) . '</h3></div>';
                    }
                    $quantidadeClass = $produto['quantidade'] <= 5 ? 'quantidade-critica' : '';
                    echo '<div class="card-item bg-white shadow rounded-lg border-l-4 border-primary p-4 mb-3">';
                    echo '<div class="flex justify-between items-start w-full">';
                    echo '<div class="flex-1">';
                    echo '<h3 class="font-bold text-lg text-primary mb-1">' . htmlspecialchars($produto['nome_produto']) . '</h3>';
                    echo '<div class="flex flex-col space-y-1">';
                    echo '<p class="text-sm text-gray-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" /></svg><span>' . htmlspecialchars($produto['barcode']) . '</span></p>';
                    echo '<p class="text-sm flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg><span class="' . $quantidadeClass . '">Quantidade: ' . htmlspecialchars($produto['quantidade']) . '</span></p>';
                    echo '</div></div>';
                    echo '<div class="flex space-x-1">';
                    echo '<button onclick="abrirModalEditar(' . $produto['id'] . ')" class="text-primary hover:text-secondary p-1 rounded-full bg-gray-50" title="Editar">';
                    echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>';
                    echo '</button>';
                    echo '<button onclick="abrirModalExcluir(' . $produto['id'] . ', \' ' . htmlspecialchars(addslashes($produto['nome_produto'])) . '\')" class="text-red-500 hover:text-red-700 p-1 rounded-full bg-gray-50" title="Excluir">';
                    echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>';
                    echo '</button>';
                    echo '</div></div></div>';
                }
            } else {
                echo '<div class="text-center py-8 text-gray-500"><i class="fas fa-box-open text-4xl mb-2"></i><p>Nenhum produto encontrado</p></div>';
            }
            ?>
        </div>
        <div class="mt-8 flex justify-center w-full">
            <a href="relatorios.php">
                <button id="exportarBtn" class="bg-primary text-white font-bold py-3 px-8 rounded-lg hover:bg-opacity-90 transition-colors flex items-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    Exportar para PDF
                </button>
            </a>
        </div>
        <!-- Modal de Edição -->
        <div id="modalEditar" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
                <button onclick="fecharModalEditar()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <h2 class="text-2xl font-bold text-primary mb-4">Editar Produto</h2>
                <form id="formEditar" action="../control/controllerEditarProduto.php" method="POST" class="space-y-4">
                    <input type="hidden" id="editar_id" name="editar_id">
                    <div>
                        <label for="editar_barcode" class="block text-sm font-medium text-gray-700 mb-1">Código de Barras</label>
                        <input type="text" id="editar_barcode" name="editar_barcode" required class="w-full px-4 py-2 border-2 border-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                    <div>
                        <label for="editar_nome" class="block text-sm font-medium text-gray-700 mb-1">Nome do Produto</label>
                        <input type="text" id="editar_nome" name="editar_nome" required class="w-full px-4 py-2 border-2 border-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                    <div>
                        <label for="editar_quantidade" class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
                        <input type="number" id="editar_quantidade" name="editar_quantidade" min="0" required class="w-full px-4 py-2 border-2 border-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                    <div>
                        <label for="editar_natureza" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                        <select id="editar_natureza" name="editar_natureza" required class="w-full px-4 py-2 border-2 border-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                            <option value="">Selecione a categoria</option>
                            <option value="limpeza">Limpeza</option>
                            <option value="expedientes">Expedientes</option>
                            <option value="manutencao">Manutenção</option>
                            <option value="eletrico">Elétrico</option>
                            <option value="hidraulico">Hidráulico</option>
                            <option value="educacao_fisica">Educação Física</option>
                            <option value="epi">EPI</option>
                            <option value="copa_e_cozinha">Copa e Cozinha</option>
                            <option value="informatica">Informática</option>
                            <option value="ferramentas">Ferramentas</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="fecharModalEditar()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90 transition-colors">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal de Exclusão -->
        <div id="modalExcluir" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
                <button onclick="fecharModalExcluir()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Tem certeza?</h2>
                    <p class="text-gray-600 mb-6">Você está prestes a excluir <span id="nomeProdutoExcluir" class="font-semibold"></span>. Esta ação não pode ser desfeita.</p>
                </div>
                <div class="flex justify-center space-x-3">
                    <button onclick="fecharModalExcluir()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Cancelar</button>
                    <a id="linkExcluir" href="#" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Sim, excluir</a>
                </div>
            </div>
        </div>
        <!-- Alerta de mensagem -->
        <div id="alertaMensagem" class="fixed bottom-4 right-4 p-4 rounded-lg shadow-lg max-w-md hidden animate-fade-in z-50 bg-green-500 text-white">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
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
    // JS para menu mobile, modais, filtro, alerta, etc. (igual ao model.functions.php)
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
        // Filtro de produtos (desktop e mobile)
        const pesquisarInput = document.getElementById('pesquisar');
        const filtroCategoria = document.getElementById('filtroCategoria');
        const tabelaEstoque = document.getElementById('tabelaEstoque');
        if (pesquisarInput && filtroCategoria && tabelaEstoque) {
            pesquisarInput.addEventListener('input', filtrarProdutos);
            filtroCategoria.addEventListener('change', filtrarProdutos);
            function filtrarProdutos() {
                const termo = pesquisarInput.value.toLowerCase();
                const categoria = filtroCategoria.value.toLowerCase();
                // Filtrar linhas da tabela
                const linhas = tabelaEstoque.querySelectorAll('tr');
                linhas.forEach(linha => {
                    const colunas = linha.querySelectorAll('td');
                    if (colunas.length > 0) {
                        const nome = colunas[1].textContent.toLowerCase();
                        const cat = colunas[3].textContent.toLowerCase();
                        const matchTermo = nome.includes(termo);
                        const matchCategoria = categoria === '' || cat === categoria;
                        linha.style.display = matchTermo && matchCategoria ? '' : 'none';
                    }
                });
            }
        }
        // Modais de edição/exclusão
        window.abrirModalEditar = function(id) {
            // Aqui você pode buscar os dados do produto via AJAX ou preencher manualmente se já tiver os dados
            // Exemplo: preencher campos do modal com os dados do produto
            // document.getElementById('editar_id').value = id;
            // ...
            document.getElementById('modalEditar').classList.remove('hidden');
        };
        window.fecharModalEditar = function() {
            document.getElementById('modalEditar').classList.add('hidden');
        };
        window.abrirModalExcluir = function(id, nome) {
            document.getElementById('nomeProdutoExcluir').textContent = nome;
            document.getElementById('linkExcluir').href = '../control/controllerExcluirProduto.php?id=' + id;
            document.getElementById('modalExcluir').classList.remove('hidden');
        };
        window.fecharModalExcluir = function() {
            document.getElementById('modalExcluir').classList.add('hidden');
        };
    });
    </script>
</body>
</html>