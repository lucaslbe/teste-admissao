-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Jun-2021 às 06:40
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mysql`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `operacao`
--

CREATE TABLE `operacao` (
  `op_id` int(11) NOT NULL COMMENT 'sequencial de id de op',
  `op_pai` int(11) DEFAULT NULL COMMENT 'Operação pai da operação',
  `status_op` set('Aberta','Reservada','Concluída') DEFAULT NULL,
  `cli_cpf` varchar(17) NOT NULL COMMENT 'cpf do cliente que criou a op',
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `operacao`
--

INSERT INTO `operacao` (`op_id`, `op_pai`, `status_op`, `cli_cpf`, `valor`) VALUES
(112, NULL, 'Reservada', '123456789', 110),
(113, NULL, 'Reservada', '123456789', 5000),
(114, 113, 'Reservada', '123456789', 100),
(115, NULL, 'Reservada', '12345612322', 5000),
(116, 115, 'Reservada', '12345612322', 100);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacote`
--

CREATE TABLE `pacote` (
  `vlr_nota` int(11) NOT NULL COMMENT 'valor da nota',
  `op_id` int(11) NOT NULL COMMENT 'id da operação',
  `qtd` int(11) NOT NULL COMMENT 'quantidades de notas dessa face',
  `dt_aber` datetime NOT NULL COMMENT 'data de abertura do pacote',
  `dt_fim` datetime DEFAULT NULL COMMENT 'data de fechamento do pacote'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pacote`
--

INSERT INTO `pacote` (`vlr_nota`, `op_id`, `qtd`, `dt_aber`, `dt_fim`) VALUES
(10, 112, 1, '2021-05-17 16:48:56', NULL),
(50, 112, 2, '2021-05-17 16:48:56', NULL),
(50, 115, 100, '2021-05-17 18:30:57', NULL),
(50, 116, 2, '2021-05-17 18:30:57', NULL),
(100, 113, 50, '2021-05-17 16:50:27', NULL),
(100, 114, 1, '2021-05-17 16:50:27', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `nome` varchar(50) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `dt_nasc` datetime NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `dt_insert` datetime DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de usuários';

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`nome`, `endereco`, `dt_nasc`, `cpf`, `email`, `senha`, `dt_insert`, `tipo`) VALUES
('Lucas Barbosa Estevão', 'Avenida Nações Unidas 53 53', '1996-08-20 00:00:00', '12345612322', 'estevaolucas56@frente-tech.com', '123456', '2021-05-17 16:55:06', 'A'),
('Marcelo Bento', 'rua teste de bauru', '1995-11-27 00:00:00', '123456789', 'marcelo.bento@frente-tech.com', '123456', '2021-05-17 16:47:24', 'A');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `operacao`
--
ALTER TABLE `operacao`
  ADD PRIMARY KEY (`op_id`);

--
-- Índices para tabela `pacote`
--
ALTER TABLE `pacote`
  ADD PRIMARY KEY (`vlr_nota`,`op_id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `operacao`
--
ALTER TABLE `operacao`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'sequencial de id de op', AUTO_INCREMENT=117;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
