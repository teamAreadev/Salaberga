<?php
require_once "model/model.functions.php";

echo "<h2>Teste de Edição de Produto</h2>";

try {
    $gerenciamento = new gerenciamento();
    
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
        
        // Testar edição
        $novoNome = $produto['nome_produto'] . " (TESTE)";
        $novaQuantidade = $produto['quantidade'] + 1;
        
        echo "<h3>Testando edição...</h3>";
        echo "<p>Novo nome: " . $novoNome . "</p>";
        echo "<p>Nova quantidade: " . $novaQuantidade . "</p>";
        
        $resultado = $gerenciamento->editarProduto(
            $produto['id'],
            $novoNome,
            $produto['barcode'],
            $novaQuantidade,
            $produto['natureza']
        );
        
        if ($resultado) {
            echo "<p style='color: green;'><strong>✅ Edição realizada com sucesso!</strong></p>";
            
            // Verificar se foi realmente alterado
            $produtoAtualizado = $gerenciamento->buscarProdutoPorId($produto['id']);
            
            echo "<h3>Produto após edição:</h3>";
            echo "<p><strong>Nome:</strong> " . $produtoAtualizado['nome_produto'] . "</p>";
            echo "<p><strong>Quantidade:</strong> " . $produtoAtualizado['quantidade'] . "</p>";
            
            // Reverter alteração
            $gerenciamento->editarProduto(
                $produto['id'],
                $produto['nome_produto'],
                $produto['barcode'],
                $produto['quantidade'],
                $produto['natureza']
            );
            
            echo "<p style='color: blue;'><strong>🔄 Alteração revertida para o estado original</strong></p>";
            
        } else {
            echo "<p style='color: red;'><strong>❌ Erro na edição!</strong></p>";
        }
        
    } else {
        echo "<p style='color: red;'>Nenhum produto encontrado para testar</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
}
?> 