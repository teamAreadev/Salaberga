<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session if it hasn't been started yet (needed for session messages or redirection)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../models/model_dados.php'); // Inclui o arquivo do modelo
require_once(__DIR__ . '/../config/connect.php'); // Inclui o arquivo de conexão

// --- Novo código: Verificar status do voto do usuário --- //



// --- Fim Novo código --- //

// Verifica se os dados foram enviados via POST e se contêm as avaliações dos alunos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alunos']) && is_array($_POST['alunos'])) {

    $avaliacoes = $_POST['alunos'];
    $id_equipe = $_POST['id_equipe'] ?? null; // Captura o ID da equipe

    $sucesso = true; // Flag para verificar se todas as atualizações foram bem sucedidas

    try {
        // Obtém a conexão usando o novo sistema
        $conexao = getConnection();

        // Prepara a consulta UPDATE fora do loop para otimizar
        $queryUpdateNota = "UPDATE aluno SET nota = :nota WHERE id = :aluno_id";
        $stmtUpdateNota = $conexao->prepare($queryUpdateNota);

        // Itera sobre as avaliações recebidas
        foreach ($avaliacoes as $aluno_id => $dados_avaliacao) {
            // Verifica se o ID do aluno e a nota estão presentes nos dados
            if (isset($dados_avaliacao['id']) && isset($dados_avaliacao['ponto'])) {
                $aluno_id_post = $dados_avaliacao['id'];
                $nota_atribuida = $dados_avaliacao['ponto'];

                // Garante que o ID do aluno do array corresponde à chave (segurança)
                if ((int)$aluno_id_post !== (int)$aluno_id) {
                    error_log("Debug: Mismatching student ID in POST data. Expected " . $aluno_id . ", got " . $aluno_id_post);
                    continue; // Skip this entry for now
                }

                // Bind e executa a consulta UPDATE para cada aluno
                $stmtUpdateNota->bindParam(':nota', $nota_atribuida);
                $stmtUpdateNota->bindParam(':aluno_id', $aluno_id);

                if (!$stmtUpdateNota->execute()) {
                    $sucesso = false;
                    error_log("Erro ao atualizar nota para o aluno ID " . $aluno_id . ": " . print_r($stmtUpdateNota->errorInfo(), true));
                }
            } else {
                $sucesso = false;
                error_log("Debug: Dados de avaliação incompletos para o aluno ID " . $aluno_id);
            }
        }

        // Atualiza o voto do usuário apenas se todas as notas foram atualizadas com sucesso
        if ($sucesso && isset($_SESSION['user_id'])) {
            try {
                $queryUpdateVoto = "UPDATE usuarios SET voto = 1 WHERE id = :usuario_id";
                $stmtUpdateVoto = $conexao->prepare($queryUpdateVoto);
                $stmtUpdateVoto->bindParam(':usuario_id', $_SESSION['user_id']);
                
                if (!$stmtUpdateVoto->execute()) {
                    error_log("Erro ao atualizar voto do usuário ID " . $_SESSION['user_id'] . ": " . print_r($stmtUpdateVoto->errorInfo(), true));
                    $sucesso = false;
                }
            } catch (PDOException $e) {
                error_log("Erro no banco de dados ao atualizar voto: " . $e->getMessage());
                $sucesso = false;
            }
        }

    } catch (Exception $e) {
        $sucesso = false;
        error_log("Erro no banco de dados durante a avaliação: " . $e->getMessage());
        $_SESSION['avaliacao_erro'] = 'Erro ao salvar avaliação: ' . $e->getMessage();
    }

    // Redireciona com base no sucesso ou falha
    if ($sucesso) {
        $_SESSION['avaliacao_sucesso'] = 'Avaliação salva com sucesso!';
        header('Location: ../views/form/success_form_parcial.php');
        exit();
    } else {
        header('Location: ../views/form/form_parcial.php?status=error');
        exit();
    }
} else {
    error_log("Debug: Tentativa de acesso direto ou dados de avaliação ausentes.");
    header('Location: ../views/form/form_parcial.php?status=invalid');
    exit();
}
