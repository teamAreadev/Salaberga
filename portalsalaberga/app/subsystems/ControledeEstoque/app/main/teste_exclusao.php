<?php
require_once "model/model.functions.php";

echo "<h2>Teste de Exclusão de Produto</h2>";

try {
    $env = isset($_GET['env']) ? $_GET['env'] : 'local';
    $gerenciamento = new gerenciamento($env);
    
    // Buscar um produto para testar
    $produtos = $gerenciamento->getPdo()->query('SELECT * FROM produtos LIMIT 1')->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($produtos) > 0) {
        $produto = $produtos[0];
        
        echo "<h3>Produto encontrado:</h3>";
        echo "<p><strong>ID:</strong> " . $produto['id'] . "</p>";
        echo "<p><strong>Nome:</strong> " . $produto['nome_produto'] . "</p>";
        echo "<p><strong>Barcode:</strong> " . $produto['barcode'] . "</p>";
        echo "<p><strong>Quantidade:</strong> " . $produto['quantidade'] . "</p>";
        echo "<p><strong>Natureza:</strong> " . $produto['natureza'] . "</p>";
        
        // Verificar movimentações relacionadas
        $movimentacoes = $gerenciamento->getPdo()->query("SELECT COUNT(*) as total FROM movimentacao WHERE fk_produtos_id = " . $produto['id'])->fetch(PDO::FETCH_ASSOC);
        echo "<p><strong>Movimentações relacionadas:</strong> " . $movimentacoes['total'] . "</p>";
        
        echo "<h3>Testando exclusão...</h3>";
        
        // Testar exclusão
        $resultado = $gerenciamento->apagarProduto($produto['id']);
        
        if ($resultado) {
            echo "<p style='color: green;'><strong>✅ Produto excluído com sucesso!</strong></p>";
            
            // Verificar se foi realmente excluído
            $produtoVerificado = $gerenciamento->buscarProdutoPorId($produto['id']);
            
            if (!$produtoVerificado) {
                echo "<p style='color: green;'><strong>✅ Confirmação: Produto não encontrado após exclusão</strong></p>";
            } else {
                echo "<p style='color: red;'><strong>❌ ERRO: Produto ainda existe após exclusão</strong></p>";
            }
            
            // Verificar movimentações
            $movimentacoesApos = $gerenciamento->getPdo()->query("SELECT COUNT(*) as total FROM movimentacao WHERE fk_produtos_id = " . $produto['id'])->fetch(PDO::FETCH_ASSOC);
            echo "<p><strong>Movimentações após exclusão:</strong> " . $movimentacoesApos['total'] . "</p>";
            
        } else {
            echo "<p style='color: red;'><strong>❌ Erro na exclusão!</strong></p>";
        }
        
    } else {
        echo "<p style='color: red;'>Nenhum produto encontrado para testar</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
}
?> 