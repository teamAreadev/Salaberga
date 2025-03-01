<?php


function cadastrar($nome, $cpf, $filme, $turma, $curso) {
    // Configurações do banco de dados
    require_once('../database/Database.php');         // Senha do banco (ajuste conforme necessário)

    try {
        // Conexão com o banco de dados usando PDO
        
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Validações básicas
        $nome = trim($nome);
        $cpf = preg_replace('/[^\d]/', '', $cpf); // Remove pontos e traços do CPF
        $filme = trim($filme);
        $turma = trim($turma);
        $curso = trim($curso);

        if (empty($nome) || empty($cpf) || empty($filme) || empty($turma) || empty($curso)) {
            return "Erro: Todos os campos são obrigatórios.";
        }

        if (strlen($cpf) !== 11 || !is_numeric($cpf)) {
            return "Erro: CPF inválido. Deve conter exatamente 11 dígitos numéricos.";
        }

        // Preparar a query de inserção
        $sql = "INSERT INTO usuarios (nome, cpf, filme, turma, curso) VALUES (:nome, :cpf, :filme, :turma, :curso)";
        $stmt = $conexao->prepare($sql);

        // Vincular os parâmetros
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':filme', $filme);
        $stmt->bindParam(':turma', $turma);
        $stmt->bindParam(':curso', $curso);

        // Executar a inserção
        $stmt->execute();

        header('Location: ../success.php');
        exit();
    } catch (PDOException $e) {
        // Tratar erros de conexão ou inserção
        return "Erro ao cadastrar: " . $e->getMessage();
    }
}




?>