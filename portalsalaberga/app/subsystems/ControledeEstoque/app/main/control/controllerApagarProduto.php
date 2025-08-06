<?php
require_once("../model/model.functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $gerenciamento = new gerenciamento();
        $resultado = $gerenciamento->apagarProduto($id);
        
        if ($resultado) {
            // Sucesso - redirecionar com mensagem de sucesso
            header("Location: ../view/estoque.php?success=1&message=Produto excluído com sucesso!");
            exit;
        } else {
            // Erro - redirecionar com mensagem de erro
            header("Location: ../view/estoque.php?error=1&message=Erro ao excluir produto!");
            exit;
        }
    } catch (Exception $e) {
        // Exceção - redirecionar com mensagem de erro
        header("Location: ../view/estoque.php?error=1&message=Erro: " . $e->getMessage());
        exit;
    }
} else {
    // Parâmetros inválidos
    header("Location: ../view/estoque.php?error=1&message=Parâmetros inválidos!");
    exit;
}
?>