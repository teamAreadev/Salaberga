<?php
// Configurações para exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Funções auxiliares
function checkSuccess($condition, $message, $errorDetails = "") {
    if ($condition) {
        echo "<p style='color:green;'><strong>✓</strong> $message</p>";
        return true;
    } else {
        echo "<p style='color:red;'><strong>✗</strong> $message</p>";
        if (!empty($errorDetails)) {
            echo "<p style='color:#666; margin-left: 20px;'>$errorDetails</p>";
        }
        return false;
    }
}

echo "<html>
<head>
    <title>Diagnóstico do Sistema de Cadastro</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; }
        h1, h2 { color: #333; }
        .section { background: #f5f5f5; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        pre { background: #eee; padding: 10px; border-radius: 3px; overflow: auto; }
        .actions { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; }
        button, .button { padding: 8px 16px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 10px; }
        button:hover, .button:hover { background: #45a049; }
        table { border-collapse: collapse; width: 100%; }
        th, td { text-align: left; padding: 8px; border: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Diagnóstico do Sistema de Cadastro</h1>";

// 1. Verificar configurações do PHP
echo "<div class='section'>
    <h2>1. Configurações do PHP</h2>";

echo "<p>Versão do PHP: " . phpversion() . "</p>";
checkSuccess(version_compare(phpversion(), '7.0.0', '>='), "Versão do PHP é compatível", "Recomendada versão 7.0 ou superior");

$requiredExtensions = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'session'];
foreach ($requiredExtensions as $ext) {
    checkSuccess(extension_loaded($ext), "Extensão $ext carregada");
}

$uploadMax = ini_get('upload_max_filesize');
$postMax = ini_get('post_max_size');
$memoryLimit = ini_get('memory_limit');

echo "<p>Limites do PHP:</p>
    <ul>
        <li>upload_max_filesize: $uploadMax</li>
        <li>post_max_size: $postMax</li>
        <li>memory_limit: $memoryLimit</li>
    </ul>";

echo "</div>";

// 2. Verificar estrutura de diretórios e arquivos críticos
echo "<div class='section'>
    <h2>2. Estrutura de Arquivos</h2>";

$requiredFiles = [
    '../controllers/UsuarioController.php',
    '../model/UsuarioModel.php',
    'database.php',
    'init_db.php',
    '../index.php'
];

foreach ($requiredFiles as $file) {
    $filePath = __DIR__ . '/' . $file;
    checkSuccess(file_exists($filePath), "Arquivo $file existe", "Caminho esperado: $filePath");
}

echo "</div>";

// 3. Verificar conexão com o banco de dados
echo "<div class='section'>
    <h2>3. Conexão com o Banco de Dados</h2>";

try {
    require_once 'database.php';
    $database = new Database();
    $conn = $database->getConnection();
    
    checkSuccess($conn !== null, "Conexão com o banco de dados estabelecida");
    
    // Obter informações do banco de dados
    $stmt = $conn->query("SELECT version() as version");
    $version = $stmt->fetch(PDO::FETCH_ASSOC)['version'];
    echo "<p>Versão do MySQL: $version</p>";
    
    // Verificar configurações do banco de dados
    $reflection = new ReflectionClass('Database');
    $hostProperty = $reflection->getProperty('host');
    $hostProperty->setAccessible(true);
    $dbNameProperty = $reflection->getProperty('db_name');
    $dbNameProperty->setAccessible(true);
    $usernameProperty = $reflection->getProperty('username');
    $usernameProperty->setAccessible(true);
    
    $host = $hostProperty->getValue($database);
    $dbName = $dbNameProperty->getValue($database);
    $username = $usernameProperty->getValue($database);
    
    echo "<p>Configurações de conexão:</p>
        <ul>
            <li>Host: $host</li>
            <li>Banco de dados: $dbName</li>
            <li>Usuário: $username</li>
        </ul>";
    
} catch (Exception $e) {
    checkSuccess(false, "Conexão com o banco de dados", "Erro: " . $e->getMessage());
}

echo "</div>";

// 4. Verificar estrutura de tabelas
echo "<div class='section'>
    <h2>4. Estrutura de Tabelas</h2>";

try {
    if (isset($conn)) {
        // Verificar tabelas
        $tables = ['alunos', 'inscricoes'];
        
        foreach ($tables as $table) {
            $stmt = $conn->prepare("SHOW TABLES LIKE ?");
            $stmt->execute([$table]);
            $tableExists = $stmt->rowCount() > 0;
            
            if (checkSuccess($tableExists, "Tabela '$table' existe")) {
                // Mostrar estrutura da tabela
                $stmt = $conn->prepare("DESCRIBE $table");
                $stmt->execute();
                $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<table>";
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
                $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM $table");
                $stmt->execute();
                $count = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<p>Total de registros: {$count['total']}</p>";
            }
        }
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>Erro ao verificar estrutura de tabelas: " . $e->getMessage() . "</p>";
}

echo "</div>";

// 5. Verificar permissões de escrita nos diretórios críticos
echo "<div class='section'>
    <h2>5. Permissões de Arquivos</h2>";

$writableDirs = [
    '../config',
    '../model',
    '../controllers'
];

foreach ($writableDirs as $dir) {
    $dirPath = __DIR__ . '/' . $dir;
    $isWritable = is_writable($dirPath);
    checkSuccess($isWritable, "Diretório $dir tem permissão de escrita", "Caminho: $dirPath");
}

echo "</div>";

// 6. Links de teste e ações
echo "<div class='section actions'>
    <h2>6. Ações e Testes</h2>
    <p>
        <a href='test_connection.php' class='button'>Testar Conexão com o Banco</a>
        <a href='verificar_cadastro.php' class='button'>Testar Cadastro</a>
        <a href='init_db.php' class='button'>Inicializar Banco de Dados</a>
        <a href='../index.php' class='button'>Ir para o Formulário</a>
    </p>
</div>";

echo "<div class='section'>
    <h2>7. Erros Recentes</h2>";

// Tentar ler o arquivo de log de erros do PHP (se disponível)
$logFiles = [
    'C:\xampp\php\logs\php_error_log',
    '/var/log/apache2/error.log',
    '/var/log/httpd/error_log'
];

$logFound = false;
foreach ($logFiles as $logFile) {
    if (file_exists($logFile) && is_readable($logFile)) {
        $logFound = true;
        echo "<p>Últimas linhas do log de erros ($logFile):</p>";
        
        // Obter as últimas 20 linhas do arquivo de log
        $lines = [];
        $fp = fopen($logFile, 'r');
        if ($fp) {
            $position = -1;
            $found = 0;
            $max_lines = 20;

            while ($found < $max_lines && -1 !== fseek($fp, $position, SEEK_END)) {
                $char = fgetc($fp);
                if (PHP_EOL == $char) {
                    $found++;
                }
                $position--;
            }
            
            while (!feof($fp)) {
                $lines[] = fgets($fp);
            }
            fclose($fp);
        }
        
        if (!empty($lines)) {
            echo "<pre style='max-height: 300px; overflow-y: auto;'>";
            foreach ($lines as $line) {
                if (strpos($line, '[CADASTRO]') !== false || 
                    strpos($line, 'ERRO') !== false || 
                    strpos($line, 'ERROR') !== false) {
                    echo "<span style='color: red;'>" . htmlspecialchars($line) . "</span>";
                } else {
                    echo htmlspecialchars($line);
                }
            }
            echo "</pre>";
        } else {
            echo "<p>Não foi possível ler o arquivo de log.</p>";
        }
        
        break;
    }
}

if (!$logFound) {
    echo "<p>Não foi possível localizar ou ler o arquivo de log do PHP.</p>";
}

echo "</div>
</body>
</html>";
?> 