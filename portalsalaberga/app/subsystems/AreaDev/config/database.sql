-- Criação da tabela areas
CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserindo áreas padrão (apenas se não existirem)
INSERT IGNORE INTO `areas` (`nome`, `descricao`) VALUES
('Desenvolvimento', 'Área de desenvolvimento de software'),
('Suporte', 'Área de suporte técnico'),
('Design', 'Área de design e UX/UI');

-- Criando tabela de usuários local
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Criando tabela de relacionamento entre usuários e áreas
CREATE TABLE IF NOT EXISTS `usuario_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `data_vinculo` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_area_unique` (`usuario_id`, `area_id`),
  KEY `area_id` (`area_id`),
  CONSTRAINT `usuario_areas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `usuario_areas_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Criando tabela de sincronização com o banco principal
CREATE TABLE IF NOT EXISTS `sincronizacao_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id_local` int(11) NOT NULL,
  `usuario_id_principal` int(11) NOT NULL,
  `ultima_sincronizacao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_id_principal` (`usuario_id_principal`),
  CONSTRAINT `sincronizacao_usuarios_ibfk_1` FOREIGN KEY (`usuario_id_local`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 