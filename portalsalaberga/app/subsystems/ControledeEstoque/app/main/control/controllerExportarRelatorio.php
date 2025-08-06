<?php
require_once("../model/model.functions.php");

if (isset($_GET['data_inicio']) && isset($_GET['data_fim'])) {
    $data_inicio = $_GET['data_inicio'];
    $data_fim = $_GET['data_fim'];
    
    $gerenciamento = new gerenciamento();
    $gerenciamento->exportarRelatorioProdutosPorData($data_inicio, $data_fim);
} else {
    echo "Parâmetros de data não fornecidos";
}
?> 