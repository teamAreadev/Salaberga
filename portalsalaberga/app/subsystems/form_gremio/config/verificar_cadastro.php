<?php
// Configurações para exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Função para testar o cadastro
function testarCadastro() {
    echo "<h1>Teste de Cadastro de Usuário</h1>";
    
    // Dados de teste para cadastro
    $testData = [
        'nome' => 'Usuário Teste ' . date('YmdHis'),
        'email' => 'teste' . time() . '@teste.com',
        'telefone' => '11999999999',
        'ano' => '2',
        'turma' => 'B'
    ];
    
    echo "<h2>Dados de teste:</h2>";
    echo "<pre>";
    print_r($testData);
    echo "</pre>";
    
    try {
        // Preparar o ambiente para o teste
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = $testData;
        $_POST['action'] = 'cadastrar';
        
        // Incluir o controlador de usuário aqui para evitar saídas iniciais
        require_once '../controllers/UsuarioController.php';
        
        // Criar o controlador e capturar qualquer saída não desejada
        ob_start();
        $controller = new UsuarioController();
        $inicializacao = ob_get_clean();
        
        // Exibir qualquer saída de inicialização que possa ter ocorrido
        if (!empty($inicializacao)) {
            echo "<h2>Saída da inicialização:</h2>";
            echo "<div style='background-color: #f5f5f5; padding: 10px; border: 1px solid #ddd; margin-bottom: 15px;'>";
            echo $inicializacao;
            echo "</div>";
        }
        
        // Agora capturar apenas a saída do método cadastrar
        ob_start();
        $controller->cadastrar();
        $result = ob_get_clean();
        
        // Tentar processar a resposta JSON
        echo "<h2>Resposta bruta:</h2>";
        echo "<pre style='background-color: #f8f8f8; padding: 10px; border: 1px solid #ddd; overflow: auto;'>";
        echo htmlspecialchars($result);
        echo "</pre>";
        
        // Exibir resultado formatado
        echo "<h2>Resultado do cadastro:</h2>";
        
        // Limpar qualquer saída que não seja JSON
        $jsonStart = strpos($result, '{');
        $jsonEnd = strrpos($result, '}');
        
        if ($jsonStart !== false && $jsonEnd !== false) {
            $jsonString = substr($result, $jsonStart, $jsonEnd - $jsonStart + 1);
            $jsonResult = json_decode($jsonString, true);
            
            echo "<pre>";
            if ($jsonResult) {
                print_r($jsonResult);
                
                if (isset($jsonResult['success']) && $jsonResult['success']) {
                    echo "</pre><p style='color:green;font-weight:bold;'>✓ Cadastro realizado com sucesso!</p>";
                } else {
                    echo "</pre><p style='color:red;font-weight:bold;'>✗ Falha no cadastro!</p>";
                }
            } else {
                echo "Falha ao decodificar JSON: " . json_last_error_msg();
                echo "\nJSON extraído: " . htmlspecialchars($jsonString);
                echo "</pre>";
            }
        } else {
            echo "<pre>Não foi possível encontrar um objeto JSON válido na resposta.</pre>";
        }
        
    } catch (Exception $e) {
        echo "<h2>Erro durante o teste:</h2>";
        echo "<p style='color:red;'>" . $e->getMessage() . "</p>";
        echo "<pre>";
        print_r($e);
        echo "</pre>";
    }
    
    echo "<p><a href='test_connection.php'>Voltar para Teste de Conexão</a></p>";
}

// Executar o teste
testarCadastro();
?> 