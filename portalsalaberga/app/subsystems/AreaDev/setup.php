<?php
require_once __DIR__ . '/config/database.php';

try {
    // Obtém a conexão com o banco de dados
    $db = Database::getInstance();
    $pdo = $db->getAreaDevConnection();

    // Cria a tabela areas
    $pdo->exec("CREATE TABLE IF NOT EXISTS `areas` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nome` varchar(100) NOT NULL,
        `descricao` text DEFAULT NULL,
        `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    // Verifica se já existem áreas cadastradas
    $stmt = $pdo->query("SELECT COUNT(*) FROM areas");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Insere dados iniciais na tabela areas apenas se estiver vazia
        $pdo->exec("INSERT INTO `areas` (`id`, `nome`, `descricao`, `status`) VALUES
            (1, 'Desenvolvimento', 'Área responsável pelo desenvolvimento de sistemas e aplicações', 'ativo'),
            (2, 'Suporte', 'Área responsável pelo suporte técnico e manutenção', 'ativo'),
            (3, 'Infraestrutura', 'Área responsável pela infraestrutura de TI', 'ativo')
        ");
    }

    // Cria a tabela demandas
    $pdo->exec("CREATE TABLE IF NOT EXISTS `demandas` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `titulo` varchar(200) NOT NULL,
        `descricao` text NOT NULL,
        `prioridade` enum('baixa','media','alta') NOT NULL,
        `status` enum('pendente','em_andamento','concluida') NOT NULL DEFAULT 'pendente',
        `admin_id` int(11) NOT NULL,
        `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
        `data_conclusao` timestamp NULL DEFAULT NULL,
        `prazo` date DEFAULT NULL,
        `area_id` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `admin_id` (`admin_id`),
        KEY `area_id` (`area_id`),
        CONSTRAINT `demandas_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `salaberga`.`usuarios` (`id`),
        CONSTRAINT `demandas_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    // Verifica se já existem demandas cadastradas
    $stmt = $pdo->query("SELECT COUNT(*) FROM demandas");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Insere dados iniciais na tabela demandas apenas se estiver vazia
        $pdo->exec("INSERT INTO `demandas` (`id`, `titulo`, `descricao`, `prioridade`, `status`, `admin_id`, `data_criacao`, `data_conclusao`, `prazo`, `area_id`) VALUES
            (26, 'PDV Guarita', 'Máquina para receber o leitor de QrCode e registrar frequência de saida de estágio ', 'alta', 'pendente', 1, '2025-05-26 00:12:32', NULL, '2025-05-29', 1),
            (28, 'Montar máquinas e organizar cabos ', 'Com a régua parafusada, organizar os cabos e ligar as máquinas. Use cabos de força bifurcados. Neste caso 4 máquinas e 8 monitores. Seriam necessários 12 cabos de força. Sendo estes bifurcados, ficam 6. No caso de não haver os 6 cabos bifurcados no mesmo padrão de entrada, coloque nos segundos monitores um cabo individual.', 'alta', 'pendente', 1, '2025-05-28 04:02:24', NULL, '2025-05-28', 3),
            (30, 'Formulário de Avaliação da Equipe', 'Planejar e desenvolver este formulário de acordo com os critérios de avaliação parcial afixados em laboratório e entregues no grupo dos alunos', 'alta', 'em_andamento', 1, '2025-05-29 02:50:08', NULL, '2025-05-30', 1),
            (31, 'Seleção Área Dev', 'Rever o edital estabelecer a avaliação e critérios. Colocar peso na indicação e na avaliação prática.', 'alta', 'pendente', 1, '2025-05-29 12:48:36', NULL, '2025-05-30', 1),
            (32, 'Treinamento dos DEV\'s', 'Treinar os alunos que vão estagiar com perfil de desenvolvimento dentro dos padrões da Área Dev.', 'media', 'pendente', 1, '2025-05-29 12:50:32', NULL, '2025-06-01', 1),
            (33, 'Alteração Interface Sistema de Demandas', 'Relatório de Estatísticas: Logo \"S\" de Salaberga. As tabela apresentadas devem acompanhar a largura da página. Em Estatísticas Gerais, trocar o nome da coluna \"Valor\" por \"Total\". Trocar a legenda da primeira linha de \"Total de Demandas\" por \"Demandas\" apenas. Trocar a legenda da última linha de \"Total de Usuários\" por \"Usuários\" apenas. ', 'baixa', 'em_andamento', 1, '2025-05-29 13:02:36', NULL, '2025-06-03', 1),
            (34, 'Alterar metodologia de login da plataforma', 'Alterar de acordo com a modelagem previamente repassada, de modo a permitir uma única autenticação com as permissões devidas a aplicações que o usuário possui.', 'alta', 'em_andamento', 1, '2025-05-29 13:14:03', NULL, '2025-05-30', 1)
        ");
    }

    // Cria a tabela demanda_usuarios
    $pdo->exec("CREATE TABLE IF NOT EXISTS `demanda_usuarios` (
        `demanda_id` int(11) NOT NULL,
        `usuario_id` int(11) NOT NULL,
        `status` enum('pendente','aceito','recusado','em_andamento','concluido') DEFAULT 'pendente',
        `data_conclusao` datetime DEFAULT NULL,
        `data_aceitacao` datetime DEFAULT NULL,
        PRIMARY KEY (`demanda_id`,`usuario_id`),
        KEY `usuario_id` (`usuario_id`),
        CONSTRAINT `demanda_usuarios_ibfk_1` FOREIGN KEY (`demanda_id`) REFERENCES `demandas` (`id`) ON DELETE CASCADE,
        CONSTRAINT `demanda_usuarios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `salaberga`.`usuarios` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    // Verifica se já existem registros em demanda_usuarios
    $stmt = $pdo->query("SELECT COUNT(*) FROM demanda_usuarios");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Insere dados iniciais na tabela demanda_usuarios apenas se estiver vazia
        $pdo->exec("INSERT INTO `demanda_usuarios` (`demanda_id`, `usuario_id`, `status`, `data_conclusao`, `data_aceitacao`) VALUES
            (26, 2, 'pendente', NULL, NULL),
            (28, 2, 'pendente', NULL, NULL),
            (30, 2, 'pendente', NULL, NULL),
            (31, 2, 'pendente', NULL, NULL),
            (32, 2, 'pendente', NULL, NULL),
            (33, 2, 'recusado', NULL, NULL),
            (34, 2, 'em_andamento', NULL, '2025-05-29 15:08:32')
        ");
    }

    echo "Tabelas criadas com sucesso!\n";
    echo "Dados iniciais inseridos com sucesso!\n";

} catch (PDOException $e) {
    die("Erro ao criar as tabelas: " . $e->getMessage() . "\n");
} 