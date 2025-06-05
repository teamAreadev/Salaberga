<?php

// Inclui o arquivo de modelo que contém a função inserirAlunoAreaDev()
require_once(__DIR__ . '/../models/model_dados.php');

// Verifica se os dados foram enviados via POST e se contêm os campos necessários
if(isset($_POST['funcao']) && isset($_POST['nome']) && !empty($_POST['nome']) && !empty($_POST['funcao'])) {
    $nome = $_POST['nome'];
    $funcao = $_POST['funcao'];

    // Chamada correta da função do modelo para inserir no banco
    $insercao_sucesso = inserirAlunoAreaDev($nome, $funcao);

    if($insercao_sucesso){
        // Redireciona em caso de sucesso
        error_log("Debug Controller AreaDev: Inserção bem sucedida para Nome: " . $nome);
        header('Location: ../views/form/success_areadev.php');
        exit();
    } else {
        // Redireciona em caso de falha na inserção
        // É uma boa prática logar o erro real aqui para depuração
        error_log("Debug Controller AreaDev: Falha na inserção de dados no banco para o nome: " . $nome . ", funcao: " . $funcao);
        header('Location: ../../views/form/form_areaDev.php?status=erro'); // Redireciona para o form com status de erro genérico
        exit();
    }
} else {
    // Redireciona se os dados postados estiverem faltando ou vazios
    error_log("Debug Controller AreaDev: Dados do formulário incompletos ou vazios recebidos.");
    header('Location: ../../views/form/form_areaDev.php?status=erro_dados'); // Redireciona para o form com status de dados incompletos
    exit();
}

?>