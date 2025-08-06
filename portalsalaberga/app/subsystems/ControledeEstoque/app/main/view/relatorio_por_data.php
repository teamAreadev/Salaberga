<?php
require_once("../model/model.functions.php");
$gerenciamento = new gerenciamento();

// Processar filtros se enviados
$data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : '';
$data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : '';
$produtos_filtrados = [];

if (!empty($data_inicio) && !empty($data_fim)) {
    $produtos_filtrados = $gerenciamento->buscarProdutosPorData($data_inicio, $data_fim);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório por Data - STGM Estoque</title>
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
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAF9;
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
    </style>
</head>

<body class="min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-primary to-dark text-white py-4 shadow-lg">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="../assets/imagens/logostgm.png" alt="Logo STGM" class="h-12 mr-3">
                <span class="text-white font-heading text-xl font-semibold">STGM Estoque</span>
            </div>
            <nav class="flex items-center space-x-4">
                <a href="estoque.php" class="hover:text-secondary transition-colors">
                    <i class="fas fa-boxes mr-2"></i>Estoque
                </a>
                <a href="adicionarproduto.php" class="hover:text-secondary transition-colors">
                    <i class="fas fa-plus-circle mr-2"></i>Adicionar
                </a>
                <a href="relatorios.php" class="hover:text-secondary transition-colors">
                    <i class="fas fa-chart-bar mr-2"></i>Relatórios
                </a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-primary text-3xl md:text-4xl font-bold mb-4 page-title">RELATÓRIO POR PERÍODO</h1>
            <p class="text-gray-600">Filtre produtos adicionados em um período específico</p>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-primary font-semibold mb-2">Data Início</label>
                    <input type="date" name="data_inicio" value="<?php echo htmlspecialchars($data_inicio); ?>" 
                           class="w-full px-4 py-3 border-2 border-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary" required>
                </div>
                <div>
                    <label class="block text-primary font-semibold mb-2">Data Fim</label>
                    <input type="date" name="data_fim" value="<?php echo htmlspecialchars($data_fim); ?>" 
                           class="w-full px-4 py-3 border-2 border-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary" required>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-secondary text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-colors">
                        <i class="fas fa-search mr-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Resultados -->
        <?php if (!empty($data_inicio) && !empty($data_fim)): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-primary">
                        Produtos adicionados entre <?php echo date('d/m/Y', strtotime($data_inicio)); ?> e <?php echo date('d/m/Y', strtotime($data_fim)); ?>
                    </h2>
                    <p class="text-gray-600 mt-2">Total encontrado: <?php echo count($produtos_filtrados); ?> produtos</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">Barcode</th>
                                <th class="py-3 px-4 text-left">Nome</th>
                                <th class="py-3 px-4 text-left">Quantidade</th>
                                <th class="py-3 px-4 text-left">Categoria</th>
                                <th class="py-3 px-4 text-left">Data Cadastro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($produtos_filtrados) > 0): ?>
                                <?php foreach ($produtos_filtrados as $produto): ?>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-4"><?php echo htmlspecialchars($produto['barcode']); ?></td>
                                        <td class="py-3 px-4"><?php echo htmlspecialchars($produto['nome_produto']); ?></td>
                                        <td class="py-3 px-4"><?php echo htmlspecialchars($produto['quantidade']); ?></td>
                                        <td class="py-3 px-4"><?php echo htmlspecialchars($produto['natureza']); ?></td>
                                        <td class="py-3 px-4"><?php echo date('d/m/Y H:i', strtotime($produto['data'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="py-8 px-4 text-center text-gray-500">
                                        Nenhum produto encontrado para o período selecionado
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Botão Exportar -->
            <?php if (count($produtos_filtrados) > 0): ?>
                <div class="mt-6 text-center">
                    <button onclick="exportarPDF()" class="bg-primary text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-colors">
                        <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
                    </button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <script>
        function exportarPDF() {
            const dataInicio = '<?php echo $data_inicio; ?>';
            const dataFim = '<?php echo $data_fim; ?>';
            window.open(`../control/controllerExportarRelatorio.php?data_inicio=${dataInicio}&data_fim=${dataFim}`, '_blank');
        }
    </script>
</body>

</html> 