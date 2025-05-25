<?php
require_once __DIR__ . '/../config/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();
    
    // Atualizar a senha do admin para bcrypt
    $senha = 'admin123';
    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
    
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
    $stmt->execute([$senhaHash, 'admin@sistema.com']);
    
    echo "Senha atualizada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao atualizar senha: " . $e->getMessage();
}
?> 