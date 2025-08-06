<?php
require_once "model/model.functions.php";

try {
    $gerenciamento = new gerenciamento();
    $pdo = $gerenciamento->getPdo();
    
    echo "<h2>Verificando estrutura da tabela movimentacao</h2>";
    
    // Verificar se a tabela existe
    $consulta = "SHOW TABLES LIKE 'movimentacao'";
    $query = $pdo->prepare($consulta);
    $query->execute();
    $tabela = $query->fetch();
    
    if ($tabela) {
        echo "<p style='color: green;'>✅ Tabela movimentacao existe</p>";
        
        // Verificar estrutura da tabela
        $consulta = "DESCRIBE movimentacao";
        $query = $pdo->prepare($consulta);
        $query->execute();
        $colunas = $query->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Estrutura da tabela:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        
        foreach ($colunas as $coluna) {
            echo "<tr>";
            echo "<td>" . $coluna['Field'] . "</td>";
            echo "<td>" . $coluna['Type'] . "</td>";
            echo "<td>" . $coluna['Null'] . "</td>";
            echo "<td>" . $coluna['Key'] . "</td>";
            echo "<td>" . $coluna['Default'] . "</td>";
            echo "<td>" . $coluna['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Verificar se há registros
        $consulta = "SELECT COUNT(*) as total FROM movimentacao";
        $query = $pdo->prepare($consulta);
        $query->execute();
        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        
        echo "<p>Total de registros na tabela: <strong>" . $resultado['total'] . "</strong></p>";
        
        // Mostrar últimos registros
        if ($resultado['total'] > 0) {
            $consulta = "SELECT * FROM movimentacao ORDER BY datareg DESC LIMIT 5";
            $query = $pdo->prepare($consulta);
            $query->execute();
            $registros = $query->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<h3>Últimos 5 registros:</h3>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>Produto ID</th><th>Responsável ID</th><th>Barcode</th><th>Data</th><th>Quantidade</th></tr>";
            
            foreach ($registros as $registro) {
                echo "<tr>";
                echo "<td>" . $registro['id'] . "</td>";
                echo "<td>" . $registro['fk_produtos_id'] . "</td>";
                echo "<td>" . $registro['fk_responsaveis_id'] . "</td>";
                echo "<td>" . $registro['barcode_produto'] . "</td>";
                echo "<td>" . $registro['datareg'] . "</td>";
                echo "<td>" . $registro['quantidade_retirada'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ Tabela movimentacao NÃO existe</p>";
    }
    
    // Verificar tabela produtos
    echo "<h2>Verificando tabela produtos</h2>";
    $consulta = "SELECT COUNT(*) as total FROM produtos";
    $query = $pdo->prepare($consulta);
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Total de produtos: <strong>" . $resultado['total'] . "</strong></p>";
    
    // Verificar tabela responsaveis
    echo "<h2>Verificando tabela responsaveis</h2>";
    $consulta = "SELECT COUNT(*) as total FROM responsaveis";
    $query = $pdo->prepare($consulta);
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Total de responsáveis: <strong>" . $resultado['total'] . "</strong></p>";
    
    if ($resultado['total'] > 0) {
        $consulta = "SELECT id, nome FROM responsaveis LIMIT 5";
        $query = $pdo->prepare($consulta);
        $query->execute();
        $responsaveis = $query->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Responsáveis disponíveis:</h3>";
        echo "<ul>";
        foreach ($responsaveis as $responsavel) {
            echo "<li>ID: " . $responsavel['id'] . " - Nome: " . $responsavel['nome'] . "</li>";
        }
        echo "</ul>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
}
?> 