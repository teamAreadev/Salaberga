<?php
require "../model/model.functions.php";

// Handle the request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data_inicio']) && isset($_GET['data_fim'])) {
    $data_inicio = $_GET['data_inicio'];
    $data_fim = $_GET['data_fim'];
    $x = new relatorios();
    $x->relatorioEstoquePorData($data_inicio, $data_fim);
} else {
    echo "Erro: Parâmetros de data não fornecidos.";
    exit;
}
?>