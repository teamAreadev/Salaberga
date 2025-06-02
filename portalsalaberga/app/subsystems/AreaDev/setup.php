<?php
require_once __DIR__ . '/config/database.php';

try {
    $pdo_area_dev = Database::getInstance()->getAreaDevConnection();
    $pdo_salaberga = Database::getInstance()->getSalabergaConnection();
    
    // Criar tabela areas
    $pdo_area_dev->exec("
        CREATE TABLE IF NOT EXISTS `areas` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nome` varchar(100) NOT NULL,
            `descricao` text DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    // Inserir áreas padrão
    $pdo_area_dev->exec("
        INSERT IGNORE INTO `areas` (`nome`, `descricao`) VALUES
        ('Desenvolvimento', 'Área de desenvolvimento de sistemas'),
        ('Design', 'Área de design'),
        ('Suporte', 'Área de suporte técnico');
    ");

    // Criar tabela demandas
    $pdo_area_dev->exec("
        CREATE TABLE IF NOT EXISTS `demandas` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `titulo` varchar(200) NOT NULL,
            `descricao` text NOT NULL,
            `prioridade` enum('baixa','media','alta') NOT NULL,
            `status` enum('pendente','em_andamento','concluida') NOT NULL DEFAULT 'pendente',
            `admin_id` int(11) NOT NULL,
            `area_id` int(11) NOT NULL,
            `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
            `data_conclusao` timestamp NULL DEFAULT NULL,
            `prazo` date DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `admin_id` (`admin_id`),
            KEY `area_id` (`area_id`),
            CONSTRAINT `demandas_area_fk` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
            CONSTRAINT `demandas_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `u750204740_salaberga`.`usuarios` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    // Criar tabela demanda_usuarios
    $pdo_area_dev->exec("
        CREATE TABLE IF NOT EXISTS `demanda_usuarios` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `demanda_id` int(11) NOT NULL,
            `usuario_id` int(11) NOT NULL,
            `status` enum('pendente','aceito','recusado','em_andamento','concluido') NOT NULL DEFAULT 'pendente',
            `data_aceitacao` timestamp NULL DEFAULT NULL,
            `data_conclusao` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `demanda_id` (`demanda_id`),
            KEY `usuario_id` (`usuario_id`),
            CONSTRAINT `demanda_usuarios_ibfk_1` FOREIGN KEY (`demanda_id`) REFERENCES `demandas` (`id`) ON DELETE CASCADE,
            CONSTRAINT `demanda_usuarios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `u750204740_salaberga`.`usuarios` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    // Inserir permissões para o sistema de demandas no banco salaberga
    $pdo_salaberga->exec("
        INSERT INTO permissoes (descricao) VALUES 
        ('usuario_area_dev'),
        ('usuario_area_design'),
        ('usuario_area_suporte'),
        ('adm_area_dev'),
        ('adm_area_design'),
        ('adm_area_suporte'),
        ('adm_geral')
        ON DUPLICATE KEY UPDATE descricao = VALUES(descricao);
    ");

    // Obter IDs das permissões do banco salaberga
    $stmt = $pdo_salaberga->query("SELECT id, descricao FROM permissoes WHERE descricao LIKE 'usuario_%' OR descricao LIKE 'adm_%'");
    $permissoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Inserir relacionamentos sistema-permissão no banco salaberga
    foreach ($permissoes as $permissao) {
        $pdo_salaberga->exec("
            INSERT INTO sist_perm (sistema_id, permissao_id)
            SELECT 3, {$permissao['id']}
            WHERE NOT EXISTS (
                SELECT 1 FROM sist_perm 
                WHERE sistema_id = 3 AND permissao_id = {$permissao['id']}
            );
        ");
    }

    echo "Tabelas criadas com sucesso!";
} catch (PDOException $e) {
    die("Erro ao criar tabelas: " . $e->getMessage());
}
?> 