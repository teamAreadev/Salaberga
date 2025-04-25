<?php
require_once '../model/InscricaoModel.php';

class InscricaoController {
    private $model;

    public function __construct() {
        $this->model = new InscricaoModel();
    }

    public function processarInscricao() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            return;
        }

        $dados = $_POST;
        $resultado = $this->model->cadastrarInscricao($dados);
        
        echo json_encode($resultado);
    }
}

// Instancia e executa o controller
$controller = new InscricaoController();
$controller->processarInscricao();
?>