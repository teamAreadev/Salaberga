<?php
require_once "model/model.functions.php";

// Teste para verificar as datas dos produtos
echo "<h2>Teste de Datas dos Produtos</h2>";

try {
    $relatorios = new relatorios();
    
    // Verificar todos os produtos e suas datas
    $consulta = "SELECT id, barcode, nome_produto, data FROM produtos ORDER BY data DESC";
    $query = $relatorios->getPdo()->prepare($consulta);
    $query->execute();
    $produtos = $query->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Produtos no banco:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Barcode</th><th>Nome</th><th>Data Original</th><th>Data Formatada</th></tr>";
    
    foreach ($produtos as $produto) {
        echo "<tr>";
        echo "<td>" . $produto['id'] . "</td>";
        echo "<td>" . $produto['barcode'] . "</td>";
        echo "<td>" . $produto['nome_produto'] . "</td>";
        echo "<td>" . $produto['data'] . "</td>";
        echo "<td>" . date('d/m/Y H:i:s', strtotime($produto['data'])) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Teste da função buscarProdutosPorData
    echo "<h3>Teste da função buscarProdutosPorData:</h3>";
    
    $data_inicio = '2024-01-01';
    $data_fim = '2025-12-31';
    
    $produtos_periodo = $relatorios->buscarProdutosPorData($data_inicio, $data_fim);
    
    echo "<p>Produtos encontrados no período $data_inicio a $data_fim: " . count($produtos_periodo) . "</p>";
    
    if (count($produtos_periodo) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Barcode</th><th>Nome</th><th>Data</th></tr>";
        
        foreach ($produtos_periodo as $produto) {
            echo "<tr>";
            echo "<td>" . $produto['id'] . "</td>";
            echo "<td>" . $produto['barcode'] . "</td>";
            echo "<td>" . $produto['nome_produto'] . "</td>";
            echo "<td>" . $produto['data'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
}
?> 