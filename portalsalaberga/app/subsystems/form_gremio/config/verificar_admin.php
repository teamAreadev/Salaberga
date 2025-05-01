<?php
require_once 'database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Verificar se a tabela admin existe
    $tabelas = $db->query("SHOW TABLES LIKE 'admins'")->fetchAll();
    if (count($tabelas) == 0) {
        echo "A tabela 'admins' não existe no banco de dados.<br>";
        echo "Execute o script 'importar_sql.php' para criar as tabelas necessárias.<br>";
        exit;
    }
    
    // Verificar se existe pelo menos um admin
    $query = "SELECT COUNT(*) as total FROM admins";
    $stmt = $db->query($query);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado['total'] == 0) {
        echo "Não há administradores cadastrados. Criando admin padrão...<br>";
        
        // Criar admin padrão
        $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT);
        $query = "INSERT INTO admins (nome, usuario, senha) VALUES ('Administrador', 'admin', :senha)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':senha', $hashedPassword);
        
        if ($stmt->execute()) {
            echo "Administrador padrão criado com sucesso!<br>";
            echo "Usuário: admin<br>";
            echo "Senha: admin123<br>";
        } else {
            echo "Erro ao criar administrador padrão.<br>";
        }
    } else {
        // Verificar se o admin 'admin' existe
        $query = "SELECT id, senha FROM admins WHERE usuario = 'admin'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            echo "Administrador 'admin' encontrado no banco de dados.<br>";
            
            // Atualizar a senha para garantir que está correta
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT);
            
            $query = "UPDATE admins SET senha = :senha WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':senha', $hashedPassword);
            $stmt->bindParam(':id', $admin['id']);
            
            if ($stmt->execute()) {
                echo "Senha do administrador padrão atualizada para 'admin123'.<br>";
            } else {
                echo "Erro ao atualizar senha do administrador.<br>";
            }
        } else {
            echo "Administrador 'admin' não encontrado. Criando...<br>";
            
            // Criar admin padrão
            $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT);
            $query = "INSERT INTO admins (nome, usuario, senha) VALUES ('Administrador', 'admin', :senha)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':senha', $hashedPassword);
            
            if ($stmt->execute()) {
                echo "Administrador padrão criado com sucesso!<br>";
                echo "Usuário: admin<br>";
                echo "Senha: admin123<br>";
            } else {
                echo "Erro ao criar administrador padrão.<br>";
            }
        }
    }
    
    echo "<br><a href='../admin/login.php'>Ir para a página de login</a>";
    
} catch (PDOException $e) {
    echo "Erro ao verificar administrador: " . $e->getMessage();
}
?> 