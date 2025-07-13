-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/07/2025 às 06:04
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `financas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'Ex: Nubank, Carteira, XP Investimentos',
  `type` enum('checking','savings','investment','cash','other') NOT NULL,
  `initial_balance` decimal(12,2) DEFAULT 0.00,
  `current_balance` decimal(12,2) DEFAULT 0.00,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contas bancárias ou carteiras para transferências';

-- --------------------------------------------------------

--
-- Estrutura para tabela `budgets`
--

CREATE TABLE `budgets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL COMMENT 'Valor planejado',
  `period` enum('monthly','weekly','quarterly','yearly') DEFAULT 'monthly',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL COMMENT 'Opcional para orçamentos temporários',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Orçamentos por categoria com controle de período';

-- --------------------------------------------------------

--
-- Estrutura para tabela `budget_monitoring`
--

CREATE TABLE `budget_monitoring` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `month_year` date NOT NULL COMMENT 'Formato YYYY-MM-01 para agrupamento',
  `spent_amount` decimal(12,2) DEFAULT 0.00,
  `remaining_amount` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Monitoramento mensal de orçamentos';

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `color` varchar(7) DEFAULT '#2E86AB'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Categorias para classificação de transações';

-- --------------------------------------------------------

--
-- Estrutura para tabela `credit_cards`
--

CREATE TABLE `credit_cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `limit_value` decimal(12,2) NOT NULL,
  `closing_day` tinyint(4) NOT NULL COMMENT 'Dia do fechamento (1-31)',
  `due_day` tinyint(4) NOT NULL COMMENT 'Dia do vencimento (1-31)',
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Dados dos cartões de crédito';

-- --------------------------------------------------------

--
-- Estrutura para tabela `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `goals`
--

CREATE TABLE `goals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `target_value` decimal(12,2) NOT NULL,
  `current_value` decimal(12,2) DEFAULT 0.00,
  `target_date` date DEFAULT NULL,
  `is_achieved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Metas de economia/investimento';

-- --------------------------------------------------------

--
-- Estrutura para tabela `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `ticker` varchar(10) DEFAULT NULL COMMENT 'Código de negociação (ex: PETR4)',
  `current_value` decimal(12,2) NOT NULL,
  `target_allocation` decimal(5,2) DEFAULT NULL COMMENT '% ideal na carteira',
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Ativos de investimento do usuário';

-- --------------------------------------------------------

--
-- Estrutura para tabela `investment_income`
--

CREATE TABLE `investment_income` (
  `id` int(11) NOT NULL,
  `investment_id` int(11) NOT NULL,
  `type` enum('dividend','jcp','interest','rent','other') NOT NULL,
  `amount` decimal(12,2) NOT NULL COMMENT 'Valor líquido recebido',
  `payment_date` date NOT NULL,
  `record_date` date DEFAULT NULL COMMENT 'Data de registro (para FIIs)',
  `shares_owned` int(11) DEFAULT NULL COMMENT 'Quantidade de cotas/ações no momento',
  `rate` decimal(10,4) DEFAULT NULL COMMENT 'Valor por cota (ex: R$ 0,50 por ação)',
  `description` varchar(255) DEFAULT NULL,
  `destination_account_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Registro de proventos recebidos de investimentos';

-- --------------------------------------------------------

--
-- Estrutura para tabela `investment_transactions`
--

CREATE TABLE `investment_transactions` (
  `id` int(11) NOT NULL,
  `investment_id` int(11) NOT NULL,
  `type` enum('buy','sell') NOT NULL,
  `date` date NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `fees` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Histórico de compras/vendas de ativos';

-- --------------------------------------------------------

--
-- Estrutura para tabela `investment_types`
--

CREATE TABLE `investment_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'Ex: Ações, FIIs, Tesouro Direto',
  `recommended_allocation` decimal(5,2) DEFAULT NULL COMMENT '% sugerido para balanceamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Categorias de investimentos';

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('income','expense','transfer') NOT NULL,
  `value` decimal(12,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_credit` tinyint(1) DEFAULT 0 COMMENT 'Se foi compra no cartão',
  `installment_number` int(11) DEFAULT NULL COMMENT 'Ex: 1/3',
  `total_installments` int(11) DEFAULT NULL COMMENT 'Total de parcelas',
  `credit_card_id` int(11) DEFAULT NULL,
  `destination_account_id` int(11) DEFAULT NULL COMMENT 'Para transfers: conta/carteira destino',
  `is_recurring` tinyint(1) DEFAULT 0,
  `recurrence_frequency` enum('daily','weekly','monthly','yearly') DEFAULT NULL,
  `recurrence_end_date` date DEFAULT NULL COMMENT 'Data final da recorrência (opcional)',
  `parent_id` int(11) DEFAULT NULL COMMENT 'Transação original que gerou a recorrência'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Transações financeiras com suporte a: crédito, transferências e recorrências';

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Armazena dados dos usuários do sistema';

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`,`category_id`,`period`,`start_date`) COMMENT 'Evita duplicatas',
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`,`start_date`);

--
-- Índices de tabela `budget_monitoring`
--
ALTER TABLE `budget_monitoring`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `budget_id` (`budget_id`,`month_year`);

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`name`,`type`);

--
-- Índices de tabela `credit_cards`
--
ALTER TABLE `credit_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Índices de tabela `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `token` (`token`);

--
-- Índices de tabela `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `ticker` (`ticker`);

--
-- Índices de tabela `investment_income`
--
ALTER TABLE `investment_income`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investment_id` (`investment_id`),
  ADD KEY `destination_account_id` (`destination_account_id`),
  ADD KEY `payment_date` (`payment_date`),
  ADD KEY `type` (`type`);

--
-- Índices de tabela `investment_transactions`
--
ALTER TABLE `investment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investment_id` (`investment_id`),
  ADD KEY `date` (`date`);

--
-- Índices de tabela `investment_types`
--
ALTER TABLE `investment_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `token` (`token`);

--
-- Índices de tabela `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `credit_card_id` (`credit_card_id`),
  ADD KEY `destination_account_id` (`destination_account_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `date` (`date`),
  ADD KEY `type` (`type`),
  ADD KEY `is_recurring` (`is_recurring`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `budget_monitoring`
--
ALTER TABLE `budget_monitoring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `credit_cards`
--
ALTER TABLE `credit_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `goals`
--
ALTER TABLE `goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `investment_income`
--
ALTER TABLE `investment_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `investment_transactions`
--
ALTER TABLE `investment_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `investment_types`
--
ALTER TABLE `investment_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budgets_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `budget_monitoring`
--
ALTER TABLE `budget_monitoring`
  ADD CONSTRAINT `budget_monitoring_ibfk_1` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `credit_cards`
--
ALTER TABLE `credit_cards`
  ADD CONSTRAINT `credit_cards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `credit_cards_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD CONSTRAINT `email_verifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `goals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `investments`
--
ALTER TABLE `investments`
  ADD CONSTRAINT `investments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `investments_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `investment_types` (`id`);

--
-- Restrições para tabelas `investment_income`
--
ALTER TABLE `investment_income`
  ADD CONSTRAINT `investment_income_ibfk_1` FOREIGN KEY (`investment_id`) REFERENCES `investments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `investment_income_ibfk_2` FOREIGN KEY (`destination_account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `investment_transactions`
--
ALTER TABLE `investment_transactions`
  ADD CONSTRAINT `investment_transactions_ibfk_1` FOREIGN KEY (`investment_id`) REFERENCES `investments` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`credit_card_id`) REFERENCES `credit_cards` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_ibfk_4` FOREIGN KEY (`destination_account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_ibfk_5` FOREIGN KEY (`parent_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
