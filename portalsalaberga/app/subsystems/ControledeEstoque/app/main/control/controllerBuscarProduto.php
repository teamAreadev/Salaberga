<?php
require_once('../model/functionsViews.php');

header('Content-Type: application/json');

try {
    $select = new select();
    
    // Verificar se foi passado um ID ou barcode
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Buscar por ID
        $produto = $select->buscarProdutoPorId($_GET['id']);
    } elseif (isset($_GET['barcode']) && !empty($_GET['barcode'])) {
        // Buscar por barcode
        $produto = $select->buscarProdutoPorBarcode($_GET['barcode']);
    } else {
        throw new Exception('ID ou barcode não fornecido');
    }
    
    if ($produto) {
        echo json_encode([
            'success' => true,
            'produto' => $produto
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Produto não encontrado'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 