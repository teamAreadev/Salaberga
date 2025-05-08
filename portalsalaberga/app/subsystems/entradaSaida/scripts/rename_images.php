<?php
// Diretório onde estão os arquivos PNG
$diretorio = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "main" . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "imgAlunos" . DIRECTORY_SEPARATOR . "img3A" . DIRECTORY_SEPARATOR;

// Debug: exibir o caminho
echo "Caminho do diretório: $diretorio\n";

// Mapeamento de nomes atuais para nomes dos alunos
$mapeamento = [
    "1.png" => "nome.png",
    
    // Todos os arquivos ja nomeados //
];

// Verifica se o diretório existe
if (is_dir($diretorio)) {
    // Escaneia o diretório
    $arquivos = scandir($diretorio);
    echo "Arquivos encontrados: " . implode(", ", $arquivos) . "\n";
    
    foreach ($arquivos as $arquivo) {
        // Verifica se é um arquivo PNG e está no mapeamento
        if (strtolower(pathinfo($arquivo, PATHINFO_EXTENSION)) === 'png' && isset($mapeamento[$arquivo])) {
            // Caminho completo do arquivo antigo
            $caminho_antigo = $diretorio . $arquivo;
            // Novo nome do arquivo
            $novo_nome = $mapeamento[$arquivo];
            // Caminho completo do novo arquivo
            $caminho_novo = $diretorio . $novo_nome;
            
            // Verifica se o arquivo existe
            if (file_exists($caminho_antigo)) {
                // Renomeia o arquivo
                if (rename($caminho_antigo, $caminho_novo)) {
                    echo "Renomeado: $arquivo -> $novo_nome\n";
                } else {
                    echo "Erro ao renomear: $arquivo - " . error_get_last()['message'] . "\n";
                }
            } else {
                echo "Arquivo não encontrado: $caminho_antigo\n";
            }
        }
    }
} else {
    echo "Diretório inválido: $diretorio\n";
}
?>
?>





