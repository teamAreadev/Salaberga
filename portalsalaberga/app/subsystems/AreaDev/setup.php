<?php
require_once __DIR__ . '/config/database.php';

try {
    $database = Database::getInstance();
    $pdo_area_dev = $database->getAreadevConnection();
    $pdo_salaberga = $database->getSalabergaConnection(); // Necessário para verificar a existência da tabela usuarios

    // --- Corrigir a chave estrangeira da tabela demanda_usuarios ---
    // Verificar se a chave estrangeira existe antes de tentar excluí-la (opcional, mas evita erro se rodar várias vezes)
    $sql_check_fk = "SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'demanda_usuarios' AND CONSTRAINT_TYPE = 'FOREIGN KEY' AND CONSTRAINT_NAME = 'demanda_usuarios_ibfk_2'";
    $stmt_check_fk = $pdo_area_dev->query($sql_check_fk);
    
    if ($stmt_check_fk->fetch()) {
        // Excluir a chave estrangeira incorreta
        $sql_drop_fk = "ALTER TABLE demanda_usuarios DROP FOREIGN KEY demanda_usuarios_ibfk_2;";
        error_log("SETUP_LOG: Excluindo FK incorreta: " . $sql_drop_fk);
        $pdo_area_dev->exec($sql_drop_fk);
        error_log("SETUP_LOG: FK incorreta excluída.");
    } else {
         error_log("SETUP_LOG: FK demanda_usuarios_ibfk_2 não encontrada para exclusão ou já corrigida.");
    }

    // Adicionar a chave estrangeira correta referenciando a tabela usuarios no banco salaberga
    $sql_add_fk = "ALTER TABLE demanda_usuarios ADD CONSTRAINT demanda_usuarios_ibfk_2 FOREIGN KEY (usuario_id) REFERENCES u750204740_salaberga.usuarios(id) ON DELETE CASCADE;";
    error_log("SETUP_LOG: Adicionando FK correta: " . $sql_add_fk);
    $pdo_area_dev->exec($sql_add_fk);
    error_log("SETUP_LOG: FK correta adicionada.");
    // --- Fim da correção da chave estrangeira ---

    echo "Correção da chave estrangeira em demanda_usuarios aplicada com sucesso.<br>";

    // Criar tabela de áreas
    $sql_create_areas = "
    CREATE TABLE IF NOT EXISTS areas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descricao TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo_area_dev->exec($sql_create_areas);
    error_log("SETUP_LOG: Tabela areas criada ou já existente.");

    // Criar tabela de demandas
    $sql_create_demandas = "
    CREATE TABLE IF NOT EXISTS demandas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(255) NOT NULL,
        descricao TEXT,
        prioridade ENUM('baixa', 'media', 'alta') NOT NULL,
        status ENUM('pendente', 'em_andamento', 'concluida') NOT NULL DEFAULT 'pendente',
        admin_id INT NOT NULL,
        area_id INT NOT NULL,
        prazo DATE,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        data_atualizacao TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
        data_conclusao TIMESTAMP NULL,
        FOREIGN KEY (admin_id) REFERENCES u750204740_salaberga.usuarios(id),
        FOREIGN KEY (area_id) REFERENCES areas(id)
    )";
    $pdo_area_dev->exec($sql_create_demandas);
    error_log("SETUP_LOG: Tabela demandas criada ou já existente.");

    // Criar tabela de demanda_usuarios
    $sql_create_demanda_usuarios = "
    CREATE TABLE IF NOT EXISTS demanda_usuarios (
        demanda_id INT NOT NULL,
        usuario_id INT NOT NULL,
        status ENUM('pendente', 'inscrito', 'em_andamento', 'concluido') NOT NULL DEFAULT 'pendente',
        data_aceitacao TIMESTAMP NULL,
        data_atualizacao TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
        data_conclusao TIMESTAMP NULL,
        PRIMARY KEY (demanda_id, usuario_id),
        FOREIGN KEY (demanda_id) REFERENCES demandas(id) ON DELETE CASCADE,
        FOREIGN KEY (usuario_id) REFERENCES u750204740_salaberga.usuarios(id) ON DELETE CASCADE
    )";
    $pdo_area_dev->exec($sql_create_demanda_usuarios);
    error_log("SETUP_LOG: Tabela demanda_usuarios criada ou já existente.");

    // Inserir áreas padrão se não existirem
    $areas = [
        ['nome' => 'Desenvolvimento', 'descricao' => 'Área de desenvolvimento de software'],
        ['nome' => 'Suporte', 'descricao' => 'Área de suporte técnico'],
        ['nome' => 'Design', 'descricao' => 'Área de design gráfico']
    ];

    foreach ($areas as $area) {
        $stmt = $pdo_area_dev->prepare("INSERT IGNORE INTO areas (nome, descricao) VALUES (?, ?)");
        $stmt->execute([$area['nome'], $area['descricao']]);
    }
    error_log("SETUP_LOG: Áreas padrão verificadas/inseridas.");

    echo "Estrutura do banco de dados criada com sucesso.<br>";

} catch (PDOException $e) {
    error_log("SETUP_LOG: ERRO PDO ao aplicar setup: " . $e->getMessage());
    echo "Erro ao aplicar setup: " . $e->getMessage();
} catch (Exception $e) {
     error_log("SETUP_LOG: ERRO Geral ao aplicar setup: " . $e->getMessage());
     echo "Erro ao aplicar setup: " . $e->getMessage();
}

?> 