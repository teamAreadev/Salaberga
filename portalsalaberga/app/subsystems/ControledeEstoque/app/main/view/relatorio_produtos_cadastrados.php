<?php
require_once("../model/model.functions.php");

$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';
$produtos = [];
$error_message = '';

try {
    if (!empty($data_inicio) && !empty($data_fim)) {
        $relatorios = new relatorios();
        $produtos = $relatorios->buscarProdutosPorData($data_inicio, $data_fim);
    }
} catch (Exception $e) {
    $error_message = "Erro: " . $e->getMessage();
    error_log("Erro na página relatorio_produtos_cadastrados.php: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Produtos Cadastrados - STGM Estoque</title>
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
        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Erro:</strong> <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <div class="text-center mb-8">
            <h1 class="text-primary text-3xl md:text-4xl font-bold mb-4 page-title">RELATÓRIO DE PRODUTOS CADASTRADOS</h1>
            <p class="text-gray-600">Produtos adicionados ao estoque por período específico</p>
        </div>

        <!-- Informações do Período -->
        <?php if (!empty($data_inicio) && !empty($data_fim)): ?>
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-primary">Período</h3>
                        <p class="text-gray-600"><?php echo date('d/m/Y', strtotime($data_inicio)); ?> a <?php echo date('d/m/Y', strtotime($data_fim)); ?></p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-primary">Total de Produtos</h3>
                        <p class="text-gray-600"><?php echo count($produtos); ?></p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-primary">Ações</h3>
                        <button onclick="exportarPDF()" class="bg-secondary text-white font-bold py-2 px-4 rounded-lg hover:bg-opacity-90 transition-colors">
                            <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Resultados -->
        <?php if (!empty($data_inicio) && !empty($data_fim)): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">Barcode</th>
                                <th class="py-3 px-4 text-left">Nome do Produto</th>
                                <th class="py-3 px-4 text-left">Quantidade</th>
                                <th class="py-3 px-4 text-left">Categoria</th>
                                <th class="py-3 px-4 text-left">Data de Cadastro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($produtos) > 0): ?>
                                <?php foreach ($produtos as $produto): ?>
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
        <?php endif; ?>
    </main>

    <script>
        function exportarPDF() {
            const dataInicio = '<?php echo $data_inicio; ?>';
            const dataFim = '<?php echo $data_fim; ?>';
            window.open(`../control/controllerRelatorioProdutosCadastrados.php?data_inicio=${dataInicio}&data_fim=${dataFim}&pdf=1`, '_blank');
        }
    </script>
</body>

</html> 