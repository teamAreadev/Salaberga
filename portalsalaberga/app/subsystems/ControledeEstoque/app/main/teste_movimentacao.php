<?php
require_once "model/model.functions.php";

try {
    $relatorios = new relatorios();
    
    // Definir período de hoje
    $data_inicio = date('Y-m-d');
    $data_fim = date('Y-m-d');
    
    echo "<h2>Teste de Movimentações</h2>";
    echo "<p>Período: $data_inicio a $data_fim</p>";
    
    // Buscar movimentações
    $movimentacoes = $relatorios->buscarMovimentacoesPorData($data_inicio, $data_fim);
    
    echo "<p>Total de movimentações encontradas: <strong>" . count($movimentacoes) . "</strong></p>";
    
    if (count($movimentacoes) > 0) {
        echo "<h3>Movimentações:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Produto ID</th><th>Responsável ID</th><th>Barcode</th><th>Data</th><th>Quantidade</th></tr>";
        
        foreach ($movimentacoes as $mov) {
            echo "<tr>";
            echo "<td>" . $mov['id'] . "</td>";
            echo "<td>" . $mov['fk_produtos_id'] . "</td>";
            echo "<td>" . $mov['fk_responsaveis_id'] . "</td>";
            echo "<td>" . $mov['barcode_produto'] . "</td>";
            echo "<td>" . $mov['datareg'] . "</td>";
            echo "<td>" . $mov['quantidade_retirada'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>Nenhuma movimentação encontrada!</p>";
    }
    
    // Verificar todas as movimentações da tabela
    echo "<h2>Todas as Movimentações na Tabela</h2>";
    
    $gerenciamento = new gerenciamento();
    $pdo = $gerenciamento->getPdo();
    
    $consulta = "SELECT * FROM movimentacao ORDER BY datareg DESC LIMIT 10";
    $query = $pdo->prepare($consulta);
    $query->execute();
    $todas = $query->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Total de movimentações na tabela: <strong>" . count($todas) . "</strong></p>";
    
    if (count($todas) > 0) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Produto ID</th><th>Responsável ID</th><th>Barcode</th><th>Data</th><th>Quantidade</th></tr>";
        
        foreach ($todas as $mov) {
            echo "<tr>";
            echo "<td>" . $mov['id'] . "</td>";
            echo "<td>" . $mov['fk_produtos_id'] . "</td>";
            echo "<td>" . $mov['fk_responsaveis_id'] . "</td>";
            echo "<td>" . $mov['barcode_produto'] . "</td>";
            echo "<td>" . $mov['datareg'] . "</td>";
            echo "<td>" . $mov['quantidade_retirada'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
}
?> 