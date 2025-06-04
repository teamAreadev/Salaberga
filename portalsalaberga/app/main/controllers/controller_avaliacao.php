<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session if it hasn't been started yet (needed for session messages or redirection)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../models/model_dados.php'); // Inclui o arquivo do modelo

// --- Novo código: Verificar status do voto do usuário --- //
$id_usuario_logado = $_SESSION['id_usuario'] ?? null;

if ($id_usuario_logado !== null) {
    try {
        $conexao = new PDO("mysql:host=localhost;dbname=login_parcial", "root", "");
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $queryCheckVoto = "SELECT voto FROM usuarios WHERE id = :usuario_id";
        $stmtCheckVoto = $conexao->prepare($queryCheckVoto);
        $stmtCheckVoto->bindParam(':usuario_id', $id_usuario_logado);
        $stmtCheckVoto->execute();
        $usuario = $stmtCheckVoto->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $usuario['voto'] == 1) {
            // Usuário já votou, redirecionar
            header('Location: ../views/form/already_voted.php');
            exit();
        }

    } catch (PDOException $e) {
        error_log("Erro ao verificar voto do usuário: " . $e->getMessage());
        // Continuar mesmo com erro no check para não bloquear tudo, mas logar
    }
}
// --- Fim Novo código --- //

// Verifica se os dados foram enviados via POST e se contêm as avaliações dos alunos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alunos']) && is_array($_POST['alunos'])) {
    
    $avaliacoes = $_POST['alunos'];
    $id_equipe = $_POST['id_equipe'] ?? null; // Captura o ID da equipe

    $sucesso = true; // Flag para verificar se todas as atualizações foram bem sucedidas

    try {
        // Conexão direta com o banco de dados login_parcial
        $conexao = new PDO("mysql:host=localhost;dbname=login_parcial", "root", "");
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
                     // Decide how to handle mismatch - skip or set $sucesso = false;
                     continue; // Skip this entry for now
                 }

                // Bind e executa a consulta UPDATE para cada aluno
                $stmtUpdateNota->bindParam(':nota', $nota_atribuida);
                $stmtUpdateNota->bindParam(':aluno_id', $aluno_id);

                if (!$stmtUpdateNota->execute()) {
                    $sucesso = false;
                    error_log("Erro ao atualizar nota para o aluno ID " . $aluno_id . ": " . print_r($stmtUpdateNota->errorInfo(), true));
                    // Opcional: interromper o processo ou continuar e registrar outros erros
                }
            } else {
                $sucesso = false;
                error_log("Debug: Dados de avaliação incompletos para o aluno ID " . $aluno_id);
            }
        }

        // Confirma as mudanças no banco de dados se tudo ocorreu bem
        // Note: Com PDO e modo de erro ERSMODE_EXCEPTION, uma falha em execute() lançaria uma exceção.
        // A flag $sucesso é mais útil se você remover ERSMODE_EXCEPTION ou adicionar outras verificações.

        // --- Novo código: Atualizar voto do usuário para 1 --- //
        if ($sucesso && $id_usuario_logado !== null) {
             try {
                // Reutiliza a conexão ou cria uma nova se necessário (aqui reutiliza)
                $queryUpdateVoto = "UPDATE usuarios SET voto = 1 WHERE id = :usuario_id";
                $stmtUpdateVoto = $conexao->prepare($queryUpdateVoto);
                $stmtUpdateVoto->bindParam(':usuario_id', $id_usuario_logado);
                 if (!$stmtUpdateVoto->execute()) {
                    error_log("Erro ao atualizar voto do usuário ID " . $id_usuario_logado . ": " . print_r($stmtUpdateVoto->errorInfo(), true));
                    // Decide how to handle this failure - maybe set $sucesso = false;
                 }
             } catch (PDOException $e) {
                 error_log("Erro no banco de dados ao atualizar voto: " . $e->getMessage());
                 // Decide how to handle this failure - maybe set $sucesso = false;
             }
        }
        // --- Fim Novo código --- //

    } catch (PDOException $e) {
        $sucesso = false;
        error_log("Erro no banco de dados durante a avaliação: " . $e->getMessage());
        // Opcional: definir uma mensagem de erro na sessão para exibir ao usuário
        $_SESSION['avaliacao_erro'] = 'Erro ao salvar avaliação: ' . $e->getMessage();
    }

    // Redireciona com base no sucesso ou falha
    if ($sucesso) {
        // Opcional: definir uma mensagem de sucesso na sessão
        $_SESSION['avaliacao_sucesso'] = 'Avaliação salva com sucesso!';
        // Redirecionar de volta para o formulário ou uma página de sucesso
        header('Location: ../views/form/form_parcial.php?status=success');
        exit();
    } else {
        // Redirecionar de volta para o formulário com uma mensagem de erro
        // A mensagem de erro já foi definida na sessão
        header('Location: ../views/form/form_parcial.php?status=error');
        exit();
    }

} else {
    // Se a requisição não for POST ou não contiver os dados esperados
    error_log("Debug: Tentativa de acesso direto ou dados de avaliação ausentes.");
    header('Location: ../views/form/form_parcial.php?status=invalid'); // Ou redirecionar para outra página
    exit();
}

?> 