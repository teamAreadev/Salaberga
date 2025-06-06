-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 06/06/2025 às 14:13
-- Versão do servidor: 10.11.10-MariaDB
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `areadev`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `areas`
--

INSERT INTO `areas` (`id`, `nome`, `descricao`, `status`) VALUES
(1, 'Desenvolvimento', 'Área responsável pelo desenvolvimento de sistemas e aplicações', 'ativo'),
(2, 'Suporte', 'Área responsável pelo suporte técnico e manutenção', 'ativo'),
(3, 'Infraestrutura', 'Área responsável pela infraestrutura de TI', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `demandas`
--

CREATE TABLE `demandas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `prioridade` enum('baixa','media','alta') NOT NULL,
  `status` enum('pendente','em_andamento','concluida') NOT NULL DEFAULT 'pendente',
  `admin_id` int(11) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_conclusao` timestamp NULL DEFAULT NULL,
  `prazo` date DEFAULT NULL,
  `area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `demandas`
--

INSERT INTO `demandas` (`id`, `titulo`, `descricao`, `prioridade`, `status`, `admin_id`, `data_criacao`, `data_conclusao`, `prazo`, `area_id`) VALUES
(26, 'PDV Guarita', 'Máquina para receber o leitor de QrCode e registrar frequência de saida de estágio ', 'alta', 'pendente', 1, '2025-05-26 00:12:32', NULL, '2025-05-29', 1),
(28, 'Montar máquinas e organizar cabos ', 'Com a régua parafusada, organizar os cabos e ligar as máquinas. Use cabos de força bifurcados. Neste caso 4 máquinas e 8 monitores. Seriam necessários 12 cabos de força. Sendo estes bifurcados, ficam 6. No caso de não haver os 6 cabos bifurcados no mesmo padrão de entrada, coloque nos segundos monitores um cabo individual.', 'alta', 'pendente', 1, '2025-05-28 04:02:24', NULL, '2025-05-28', 3),
(30, 'Formulário de Avaliação da Equipe', 'Planejar e desenvolver este formulário de acordo com os critérios de avaliação parcial afixados em laboratório e entregues no grupo dos alunos', 'alta', 'em_andamento', 1, '2025-05-29 02:50:08', NULL, '2025-05-30', 1),
(31, 'Seleção Área Dev', 'Rever o edital estabelecer a avaliação e critérios. Colocar peso na indicação e na avaliação prática.', 'alta', 'pendente', 1, '2025-05-29 12:48:36', NULL, '2025-05-30', 1),
(32, 'Treinamento dos DEV\'s', 'Treinar os alunos que vão estagiar com perfil de desenvolvimento dentro dos padrões da Área Dev.', 'media', 'pendente', 1, '2025-05-29 12:50:32', NULL, '2025-06-01', 1),
(33, 'Alteração Interface Sistema de Demandas', 'Relatório de Estatísticas: Logo \"S\" de Salaberga. As tabela apresentadas devem acompanhar a largura da página. Em Estatísticas Gerais, trocar o nome da coluna \"Valor\" por \"Total\". Trocar a legenda da primeira linha de \"Total de Demandas\" por \"Demandas\" apenas. Trocar a legenda da última linha de \"Total de Usuários\" por \"Usuários\" apenas. ', 'baixa', 'em_andamento', 1, '2025-05-29 13:02:36', NULL, '2025-06-03', 1),
(34, 'Alterar metodologia de login da plataforma', 'Alterar de acordo com a modelagem previamente repassada, de modo a permitir uma única autenticação com as permissões devidas a aplicações que o usuário possui.', 'alta', 'em_andamento', 1, '2025-05-29 13:14:03', NULL, '2025-05-30', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `demanda_usuarios`
--

CREATE TABLE `demanda_usuarios` (
  `demanda_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `status` enum('pendente','aceito','recusado','em_andamento','concluido') DEFAULT 'pendente',
  `data_conclusao` datetime DEFAULT NULL,
  `data_aceitacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `demanda_usuarios`
--

INSERT INTO `demanda_usuarios` (`demanda_id`, `usuario_id`, `status`, `data_conclusao`, `data_aceitacao`) VALUES
(26, 2, 'pendente', NULL, NULL),
(28, 2, 'pendente', NULL, NULL),
(30, 2, 'pendente', NULL, NULL),
(31, 2, 'pendente', NULL, NULL),
(32, 2, 'pendente', NULL, NULL),
(33, 2, 'recusado', NULL, NULL),
(34, 2, 'em_andamento', NULL, '2025-05-29 15:08:32');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `demandas`
--
ALTER TABLE `demandas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `area_id` (`area_id`);

--
-- Índices de tabela `demanda_usuarios`
--
ALTER TABLE `demanda_usuarios`
  ADD PRIMARY KEY (`demanda_id`,`usuario_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `demandas`
--
ALTER TABLE `demandas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `demandas`
--
ALTER TABLE `demandas`
  ADD CONSTRAINT `demandas_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `salaberga`.`usuarios` (`id`),
  ADD CONSTRAINT `demandas_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);

--
-- Restrições para tabelas `demanda_usuarios`
--
ALTER TABLE `demanda_usuarios`
  ADD CONSTRAINT `demanda_usuarios_ibfk_1` FOREIGN KEY (`demanda_id`) REFERENCES `demandas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `demanda_usuarios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `salaberga`.`usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */; 