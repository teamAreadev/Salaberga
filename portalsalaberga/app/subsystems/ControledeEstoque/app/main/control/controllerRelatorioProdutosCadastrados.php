<?php
require "../model/model.functions.php";

// Handle the request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data_inicio']) && isset($_GET['data_fim'])) {
    $data_inicio = $_GET['data_inicio'];
    $data_fim = $_GET['data_fim'];
    
    // Se for uma requisição para PDF (com parâmetro pdf=1)
    if (isset($_GET['pdf']) && $_GET['pdf'] == '1') {
        $relatorios = new relatorios();
        $relatorios->exportarRelatorioProdutosPorData($data_inicio, $data_fim);
    } else {
        // Redirecionar para a página de visualização
        header("Location: ../view/relatorio_produtos_cadastrados.php?data_inicio=" . urlencode($data_inicio) . "&data_fim=" . urlencode($data_fim));
        exit;
    }
} else {
    echo "Erro: Parâmetros de data não fornecidos.";
    exit;
}
?> 