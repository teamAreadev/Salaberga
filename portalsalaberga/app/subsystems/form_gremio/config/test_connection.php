<?php
// Desativar saída de buffer para ver os erros em tempo real
ini_set('output_buffering', 'off');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir arquivo de configuração do banco de dados
require_once 'database.php';

// Função para testar a conexão
function testConnection() {
    echo "<h1>Teste de Conexão com o Banco de Dados</h1>";
    echo "<h2>Configurações:</h2>";
    
    try {
        $db = new Database();
        $conn = $db->getConnection();
        
        echo "<p style='color:green;'>✓ Conexão com o banco de dados estabelecida com sucesso!</p>";
        
        // Verificar tabelas
        $tables = [
            'alunos' => "SHOW TABLES LIKE 'alunos'",
            'inscricoes' => "SHOW TABLES LIKE 'inscricoes'"
        ];
        
        echo "<h2>Verificação de tabelas:</h2>";
        
        foreach ($tables as $name => $query) {
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                echo "<p style='color:green;'>✓ Tabela '{$name}' existe</p>";
                
                // Mostrar estrutura da tabela
                $stmt = $conn->prepare("DESCRIBE {$name}");
                $stmt->execute();
                $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<table border='1' cellpadding='5' style='border-collapse: collapse; margin-bottom: 20px;'>";
                echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Chave</th><th>Padrão</th><th>Extra</th></tr>";
                
                foreach ($fields as $field) {
                    echo "<tr>";
                    foreach ($field as $key => $value) {
                        echo "<td>" . ($value ?? "NULL") . "</td>";
                    }
                    echo "</tr>";
                }
                
                echo "</table>";
                
                // Contar registros
                $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM {$name}");
                $stmt->execute();
                $count = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<p>Total de registros: {$count['total']}</p>";
                
            } else {
                echo "<p style='color:red;'>✗ Tabela '{$name}' não existe!</p>";
            }
        }
        
    } catch (Exception $e) {
        echo "<p style='color:red;'>✗ Erro ao conectar: " . $e->getMessage() . "</p>";
        echo "<p>Detalhes: </p>";
        echo "<pre>";
        print_r($e);
        echo "</pre>";
    }
}

// Executar o teste
testConnection();
?> 