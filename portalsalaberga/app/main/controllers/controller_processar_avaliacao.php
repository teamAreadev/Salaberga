<?php

// Incluir arquivos necessários
require_once __DIR__ . '/../config/Database.php'; // Ajuste o caminho conforme necessário
require_once __DIR__ . '/../models/model_dados.php'; // Ajuste o caminho conforme necessário

// Verificar se a requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar e sanitizar dados do formulário
    $formData = [
        'equipe' => filter_input(INPUT_POST, 'equipe', FILTER_SANITIZE_STRING),
        
        // Sprint 1
        'sprint1_doc_entregue' => isset($_POST['sprint1_doc_entregue']),
        'sprint1_doc_prazo' => isset($_POST['sprint1_doc_prazo']),
        'sprint1_doc_notas' => filter_input(INPUT_POST, 'sprint1_doc_notas', FILTER_SANITIZE_STRING),
        'sprint1_reqs_entregue' => isset($_POST['sprint1_reqs_entregue']),
        'sprint1_reqs_prazo' => isset($_POST['sprint1_reqs_prazo']),
        'sprint1_reqs_notas' => filter_input(INPUT_POST, 'sprint1_reqs_notas', FILTER_SANITIZE_STRING),
        
        // Sprint 2
        'sprint2_caso_uso_entregue' => isset($_POST['sprint2_caso_uso_entregue']),
        'sprint2_caso_uso_prazo' => isset($_POST['sprint2_caso_uso_prazo']),
        'sprint2_caso_uso_notas' => filter_input(INPUT_POST, 'sprint2_caso_uso_notas', FILTER_SANITIZE_STRING),
        'sprint2_atividades_entregue' => isset($_POST['sprint2_atividades_entregue']),
        'sprint2_atividades_prazo' => isset($_POST['sprint2_atividades_prazo']),
        'sprint2_atividades_notas' => filter_input(INPUT_POST, 'sprint2_atividades_notas', FILTER_SANITIZE_STRING),
        
        // Sprint 3
        'sprint3_conceitual_entregue' => isset($_POST['sprint3_conceitual_entregue']),
        'sprint3_conceitual_prazo' => isset($_POST['sprint3_conceitual_prazo']),
        'sprint3_conceitual_notas' => filter_input(INPUT_POST, 'sprint3_conceitual_notas', FILTER_SANITIZE_STRING),
        'sprint3_logica_entregue' => isset($_POST['sprint3_logica_entregue']),
        'sprint3_logica_prazo' => isset($_POST['sprint3_logica_prazo']),
        'sprint3_logica_notas' => filter_input(INPUT_POST, 'sprint3_logica_notas', FILTER_SANITIZE_STRING),
        'sprint3_fisica_entregue' => isset($_POST['sprint3_fisica_entregue']),
        'sprint3_fisica_prazo' => isset($_POST['sprint3_fisica_prazo']),
        'sprint3_fisica_notas' => filter_input(INPUT_POST, 'sprint3_fisica_notas', FILTER_SANITIZE_STRING),
        
        // Sprint 4
        'sprint4_prototipo_entregue' => isset($_POST['sprint4_prototipo_entregue']),
        'sprint4_prototipo_prazo' => isset($_POST['sprint4_prototipo_prazo']),
        'sprint4_prototipo_notas' => filter_input(INPUT_POST, 'sprint4_prototipo_notas', FILTER_SANITIZE_STRING),
        'sprint4_storyboard_entregue' => isset($_POST['sprint4_storyboard_entregue']),
        'sprint4_storyboard_prazo' => isset($_POST['sprint4_storyboard_prazo']),
        'sprint4_storyboard_notas' => filter_input(INPUT_POST, 'sprint4_storyboard_notas', FILTER_SANITIZE_STRING),
        
        // Sprint 5
        'sprint5_doc_final_entregue' => isset($_POST['sprint5_doc_final_entregue']),
        'sprint5_doc_final_prazo' => isset($_POST['sprint5_doc_final_prazo']),
        'sprint5_doc_final_notas' => filter_input(INPUT_POST, 'sprint5_doc_final_notas', FILTER_SANITIZE_STRING),
        'sprint5_interface_entregue' => isset($_POST['sprint5_interface_entregue']),
        'sprint5_interface_prazo' => isset($_POST['sprint5_interface_prazo']),
        'sprint5_interface_notas' => filter_input(INPUT_POST, 'sprint5_interface_notas', FILTER_SANITIZE_STRING),
        'sprint5_relatorio_entregue' => isset($_POST['sprint5_relatorio_entregue']),
        'sprint5_relatorio_prazo' => isset($_POST['sprint5_relatorio_prazo']),
        'sprint5_relatorio_notas' => filter_input(INPUT_POST, 'sprint5_relatorio_notas', FILTER_SANITIZE_STRING),
        'sprint5_personalizada1_entregue' => isset($_POST['sprint5_personalizada1_entregue']),
        'sprint5_personalizada1_prazo' => isset($_POST['sprint5_personalizada1_prazo']),
        'sprint5_personalizada1_notas' => filter_input(INPUT_POST, 'sprint5_personalizada1_notas', FILTER_SANITIZE_STRING),
        'sprint5_personalizada2_entregue' => isset($_POST['sprint5_personalizada2_entregue']),
        'sprint5_personalizada2_prazo' => isset($_POST['sprint5_personalizada2_prazo']),
        'sprint5_personalizada2_notas' => filter_input(INPUT_POST, 'sprint5_personalizada2_notas', FILTER_SANITIZE_STRING),
        'sprint5_final_entregue' => isset($_POST['sprint5_final_entregue']),
        'sprint5_final_prazo' => isset($_POST['sprint5_final_prazo']),
        'sprint5_final_notas' => filter_input(INPUT_POST, 'sprint5_final_notas', FILTER_SANITIZE_STRING),

        // Ajustes
        'ajustes_areadev_entregue' => isset($_POST['ajustes_areadev_entregue']),
        'ajustes_areadev_prazo' => isset($_POST['ajustes_areadev_prazo']),
        'ajustes_areadev_notas' => filter_input(INPUT_POST, 'ajustes_areadev_notas', FILTER_SANITIZE_STRING),

        // Avaliação Final
        'avaliacao_final' => filter_input(INPUT_POST, 'avaliacao_final', FILTER_SANITIZE_STRING),
    ];

    // --- Adição da validação da equipe ---
    if (empty($formData['equipe'])) {
        // Se a equipe não foi selecionada, redireciona de volta com uma mensagem de erro específica
        header('Location: ../../views/form/form_parcial_dev.php?erro_equipe_vazia');
        exit();
    }
    // --- Fim da adição ---

    // Chamar a função do modelo para inserir os dados
    $insercaoBemSucedida = inserirAvaliacao($formData);

    // Lidar com o resultado
    if ($insercaoBemSucedida) {
        // Redirecionar para uma página de sucesso ou exibir mensagem
        header('Location: ../views/sucesso_avaliacao.php'); // Crie esta página de sucesso
        exit();
    } else {
        // Redirecionar de volta para o formulário com mensagem de erro ou exibir erro
        // Podemos adicionar um parâmetro de erro na URL ou usar sessão
        header('Location: ../views/form/form_parcial_dev.php?erro_salvar');
        exit();
    }

} else {
    // Se não for POST, redirecionar ou mostrar erro
    header('Location: ../views/form/form_parcial_dev.php'); // Redirecionar de volta para o formulário
    exit();
}

?> 