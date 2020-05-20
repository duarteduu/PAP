-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Fev-2020 às 21:00
-- Versão do servidor: 10.4.8-MariaDB
-- versão do PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `plataforma`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `concelhos`
--

CREATE TABLE `concelhos` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_distrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `concelhos`
--

INSERT INTO `concelhos` (`codigo`, `nome`, `codigo_distrito`) VALUES
(1, 'Arcos de Valdevez', 16),
(2, 'Caminha', 16),
(3, 'Melgaço', 16),
(4, 'Monção', 16),
(5, 'Paredes de Coura', 16),
(6, 'Ponte da Barca', 16),
(7, 'Ponte de Lima', 16),
(8, 'Valença do Minho', 16),
(9, 'Viana do Castelo', 16),
(10, 'Vila Nova de Cerveira', 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `crms`
--

CREATE TABLE `crms` (
  `id` int(11) NOT NULL,
  `nome_cliente` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivos` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto_primeiro_nome` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto_ultimo_nome` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto_numero` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacoes` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `situacao` int(11) NOT NULL,
  `data_registo` int(11) NOT NULL DEFAULT unix_timestamp(),
  `concluida` tinyint(1) NOT NULL DEFAULT 0,
  `registador_id` int(11) NOT NULL,
  `contacto_distrito_id` int(11) DEFAULT NULL,
  `contacto_concelho_id` int(11) DEFAULT NULL,
  `contacto_freguesia_id` int(11) DEFAULT NULL,
  `contacto_codigo_postal` smallint(5) UNSIGNED DEFAULT NULL,
  `contacto_codigo_postal_extensao` smallint(5) UNSIGNED DEFAULT NULL,
  `contacto_morada` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dias_semana`
--

CREATE TABLE `dias_semana` (
  `abv` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `dias_semana`
--

INSERT INTO `dias_semana` (`abv`, `dia`) VALUES
('Dom', 'Domingo'),
('Qua', 'Quarta-feira'),
('Qui', 'Quinta-feira'),
('Sab', 'Sábado'),
('Seg', 'Segunda-feira'),
('Sex', 'Sexta-feira'),
('Ter', 'Terça-feira');

-- --------------------------------------------------------

--
-- Estrutura da tabela `distritos`
--

CREATE TABLE `distritos` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `distritos`
--

INSERT INTO `distritos` (`codigo`, `nome`) VALUES
(40, 'Açores'),
(1, 'Aveiro'),
(2, 'Beja'),
(3, 'Braga'),
(4, 'Bragança'),
(5, 'Castelo Branco'),
(6, 'Coimbra'),
(7, 'Évora'),
(8, 'Faro'),
(9, 'Guarda'),
(10, 'Leiria'),
(11, 'Lisboa'),
(30, 'Madeira'),
(12, 'Portalegre'),
(13, 'Porto'),
(14, 'Santarém'),
(15, 'Setúbal'),
(16, 'Viana do Castelo'),
(17, 'Vila Real'),
(18, 'Viseu');

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `id` int(11) NOT NULL,
  `primeiro_nome_cliente` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ultimo_nome_cliente` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacao` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantidade` int(10) UNSIGNED NOT NULL,
  `data_pedido_cliente` int(11) NOT NULL DEFAULT unix_timestamp(),
  `concluida` tinyint(1) NOT NULL DEFAULT 0,
  `fornecedor_id` int(11) DEFAULT NULL,
  `registador_id` int(11) DEFAULT NULL,
  `loja_id` int(11) NOT NULL,
  `data_pedido_fornecedor` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `encomendas`
--

INSERT INTO `encomendas` (`id`, `primeiro_nome_cliente`, `ultimo_nome_cliente`, `titulo`, `descricao`, `observacao`, `quantidade`, `data_pedido_cliente`, `concluida`, `fornecedor_id`, `registador_id`, `loja_id`, `data_pedido_fornecedor`) VALUES
(60, 'Cotton', 'House', 'Tinteiro hp 45 original', '', '', 2, 1562317000, 1, 182, 38, 2, '2019-07-05'),
(61, 'UGT', 'Viana do Catelo', 'Tinteiro HP 935XL Preto', '', '', 2, 1562582579, 1, NULL, NULL, 1, NULL),
(62, 'RECTO MOTOR', 'RECTO MOTOR', 'TONER COMPATIVEL SAMSUNG D1052L', '', '', 1, 1562666683, 1, 226, NULL, 1, '2019-07-09'),
(63, 'ORDEM', 'PROVAVEL', 'TONER COMPATIVEL LEXMARK MX317 2.5K', '', 'PEDIDO PELO BRUNO', 2, 1562669895, 1, NULL, NULL, 1, NULL),
(64, 'FERNANDO MIMOSO', 'RODRIGUES LOPES', 'TONER BROTHER TN-2220 COMPATIVEL', '', '', 1, 1562690039, 1, NULL, NULL, 2, NULL),
(65, 'CALDAS &', 'MARTINS', 'TONER BROTHER TN-3170 ORIGINAL', '', '', 1, 1562690094, 1, NULL, NULL, 2, NULL),
(66, 'JORGE', 'SOUSA', 'BATERIA ORIGINAL ASUS X55L', '', '', 1, 1562864168, 1, NULL, NULL, 1, NULL),
(67, 'ZÉ', 'MARIA', 'TINTEIRO Nº15 HP ORGINAL PRETO', '', '', 1, 1563210468, 1, NULL, NULL, 3, NULL),
(68, 'ZÉ', 'MARIA', 'TINTEIRO Nº78 HP CORES/ORIGINAL', '', '', 1, 1563210526, 1, NULL, NULL, 3, NULL),
(70, 'ZÉ', 'MARIA', 'TINTEIRO 920XL PRETO / ORIGINAL', '', '', 1, 1563210600, 1, NULL, NULL, 3, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id`, `nome`) VALUES
(235, 'Teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `freguesias`
--

CREATE TABLE `freguesias` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_concelho` int(11) NOT NULL,
  `codigo_distrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `freguesias`
--

INSERT INTO `freguesias` (`codigo`, `nome`, `codigo_concelho`, `codigo_distrito`) VALUES
(1, 'Aboim das Choças', 1, 16),
(1, 'Âncora', 2, 16),
(1, 'Alvaredo', 3, 16),
(1, 'Abedim', 4, 16),
(1, 'Agualonga', 5, 16),
(1, 'Azias', 6, 16),
(1, 'Anais', 7, 16),
(1, 'Boivão', 8, 16),
(1, 'Afife', 9, 16),
(1, 'Campos e Vila Meã', 10, 16),
(2, 'Aguiã', 1, 16),
(2, 'Arga (Baixo, Cima e São João)', 2, 16),
(2, 'Castro Laboreiro e Lamas de Mouro', 3, 16),
(2, 'Anhões e Luzio', 4, 16),
(2, 'Bico e Cristelo', 5, 16),
(2, 'Boivães', 6, 16),
(2, 'Arca e Ponte de Lima', 7, 16),
(2, 'Cerdal', 8, 16),
(2, 'Alvarães', 9, 16),
(2, 'Candemil e Gondar', 10, 16),
(3, 'Álvora e Loureda', 1, 16),
(3, 'Argela', 2, 16),
(3, 'Chaviães e Paços', 3, 16),
(3, 'Barbeita', 4, 16),
(3, 'Castanheira', 5, 16),
(3, 'Bravães', 6, 16),
(3, 'Arcozelo', 7, 16),
(3, 'Fontoura', 8, 16),
(3, 'Amonde', 9, 16),
(3, 'Cornes', 10, 16),
(4, 'Arcos de Valdevez (São Paio) e Giela', 1, 16),
(4, 'Caminha (Matriz) e Vilarelho', 2, 16),
(4, 'Cousso', 3, 16),
(4, 'Barroças e Taias', 4, 16),
(4, 'Cossourado e Linhares', 5, 16),
(4, 'Britelo', 6, 16),
(4, 'Ardegão, Freixo e Mato', 7, 16),
(4, 'Friestas', 8, 16),
(4, 'Anha', 9, 16),
(4, 'Covas', 10, 16),
(5, 'Arcos de Valdevez (Salvador), Vila Fonche e Parada', 1, 16),
(5, 'Dem', 2, 16),
(5, 'Cristóval', 3, 16),
(5, 'Bela', 4, 16),
(5, 'Coura', 5, 16),
(5, 'Crasto, Ruivos e Grovelas', 6, 16),
(5, 'Bárrio e Cepões', 7, 16),
(5, 'Gandra e Taião', 8, 16),
(5, 'Areosa', 9, 16),
(5, 'Gondarém', 10, 16),
(6, 'Ázere', 1, 16),
(6, 'Gondar e Orbacém', 2, 16),
(6, 'Fiães', 3, 16),
(6, 'Cambeses', 4, 16),
(6, 'Cunha', 5, 16),
(6, 'Cuide de Vila Verde', 6, 16),
(6, 'Beiral do Lima', 7, 16),
(6, 'União das Freguesias de Valença, Cristelo Covo e Arão', 8, 16),
(6, 'Barroselas e Carvoeiro', 9, 16),
(6, 'Loivo', 10, 16),
(7, 'Cabana Maior', 1, 16),
(7, 'Lanhelas', 2, 16),
(7, 'Gave', 3, 16),
(7, 'Ceivães e Badim', 4, 16),
(7, 'Formariz e Ferreira', 5, 16),
(7, 'Entre Ambos-os-Rios, Ermida e Germil', 6, 16),
(7, 'Bertiandos', 7, 16),
(7, 'Ganfei', 8, 16),
(7, 'Cardielos e Serreleis', 9, 16),
(7, 'Mentrestido', 10, 16),
(8, 'Cabreiro', 1, 16),
(8, 'Moledo e Cristelo', 2, 16),
(8, 'Paderne', 3, 16),
(8, 'Lara', 4, 16),
(8, 'Infesta', 5, 16),
(8, 'Lavradas', 6, 16),
(8, 'Boalhosa', 7, 16),
(8, 'Gondomil e Sanfins', 8, 16),
(8, 'Carreço', 9, 16),
(8, 'Reboreda e Nogueira', 10, 16),
(9, 'Cendufe', 1, 16),
(9, 'Riba de Âncora', 2, 16),
(9, 'Parada do Monte e Cubalhão', 3, 16),
(9, 'Longos Vales', 4, 16),
(9, 'Insalde e Porreiras', 5, 16),
(9, 'Lindoso', 6, 16),
(9, 'Brandara', 7, 16),
(9, 'São Julião e Silva', 8, 16),
(9, 'Castelo do Neiva', 9, 16),
(9, 'Sapardos', 10, 16),
(10, 'Couto', 1, 16),
(10, 'Seixas', 2, 16),
(10, 'Penso', 3, 16),
(10, 'Mazedo e Cortes', 4, 16),
(10, 'Mozelos', 5, 16),
(10, 'Nogueira', 6, 16),
(10, 'Cabaços e Fojo Lobal', 7, 16),
(10, 'São Pedro da Torre', 8, 16),
(10, 'Chafé', 9, 16),
(10, 'Sopo', 10, 16),
(11, 'Eiras e Mei', 1, 16),
(11, 'Venade e Azevedo', 2, 16),
(11, 'Prado e Remoães', 3, 16),
(11, 'Merufe', 4, 16),
(11, 'Padornelo', 5, 16),
(11, 'Oleiros', 6, 16),
(11, 'Cabração e Moreira do Lima', 7, 16),
(11, 'Verdoejo', 8, 16),
(11, 'Darque', 9, 16),
(11, 'Vila Nova de Cerveira e Lovelhe', 10, 16),
(12, 'Gavieira', 1, 16),
(12, 'Vila Praia de Âncora', 2, 16),
(12, 'São Paio', 3, 16),
(12, 'Messegães, Valadares e Sá', 4, 16),
(12, 'Parada', 5, 16),
(12, 'Ponte da Barca, Vila Nova de Muía e Paço Vedro de Magalhães', 6, 16),
(12, 'Calheiros', 7, 16),
(12, 'Freixieiro de Soutelo', 9, 16),
(13, 'Gondoriz', 1, 16),
(13, 'Vilar de Mouros', 2, 16),
(13, 'Vila e Roussas', 3, 16),
(13, 'Monção e Troviscoso', 4, 16),
(13, 'Paredes de Coura e Resende', 5, 16),
(13, 'Sampriz', 6, 16),
(13, 'Calvelo', 7, 16),
(13, 'Geraz do Lima (Santa Maria, Santa Leocádia e Moreira) e Deão', 9, 16),
(14, 'Grade e Carralcova', 1, 16),
(14, 'Vile', 2, 16),
(14, 'Moreira', 4, 16),
(14, 'Romarigães', 5, 16),
(14, 'Touvedo (São Lourenço e Salvador)', 6, 16),
(14, 'Correlhã ', 7, 16),
(14, 'Lanheses ', 9, 16),
(15, 'Guilhadeses e Santar', 1, 16),
(15, 'Pias', 4, 16),
(15, 'Rubiães', 5, 16),
(15, 'São Pedro de Vade', 6, 16),
(15, 'Estorãos', 7, 16),
(15, 'Mazarefes e Vila Fria', 9, 16),
(16, 'Jolda (Madalena) e Rio Cabrão', 1, 16),
(16, 'Pinheiros', 4, 16),
(16, 'Vascões', 5, 16),
(16, 'São Tomé de Vade', 6, 16),
(16, 'Facha', 7, 16),
(16, 'Montaria', 9, 16),
(17, 'Miranda', 1, 16),
(17, 'Podame', 4, 16),
(17, 'Vila Chã (São João Baptista e Santiago)', 6, 16),
(17, 'Feitosa', 7, 16),
(17, 'Mujães', 9, 16),
(18, 'Monte Redondo', 1, 16),
(18, 'Portela', 4, 16),
(18, 'Fontão', 7, 16),
(18, 'Nogueira, Meixedo e Vilar de Murteda', 9, 16),
(19, 'Oliveira', 1, 16),
(19, 'Riba de Mouro', 4, 16),
(19, 'Fornelos e Queijada', 7, 16),
(19, 'Outeiro', 9, 16),
(20, 'Paçô', 1, 16),
(20, 'Sago, Lordelo e Parada', 4, 16),
(20, 'Friastelas', 7, 16),
(20, 'Perre', 9, 16),
(21, 'Padreiro (Salvador e Santa Cristina)', 1, 16),
(21, 'Segude', 4, 16),
(21, 'Gandra', 7, 16),
(21, 'Santa Marta de Portuzelo', 9, 16),
(22, 'Padroso', 1, 16),
(22, 'Tangil', 4, 16),
(22, 'Gemieira', 7, 16),
(22, 'São Romão de Neiva', 9, 16),
(23, 'Portela e Extremo', 1, 16),
(23, 'Troporiz e Lapela', 4, 16),
(23, 'Gondufe', 7, 16),
(23, 'Subportela, Deocriste e Portela Susã', 9, 16),
(24, 'Prozelo', 1, 16),
(24, 'Trute', 4, 16),
(24, 'Labruja', 7, 16),
(24, 'Torre e Vila Mou', 9, 16),
(25, 'Rio de Moinhos', 1, 16),
(25, 'Labrujó, Rendufe e Vilar do Monte', 7, 16),
(25, 'Viana do Castelo (Santa Maria Maior e Monserrate) e Meadela', 9, 16),
(26, 'Rio Frio', 1, 16),
(26, 'Navió e Vitorino dos Piães', 7, 16),
(26, 'Vila de Punhe', 9, 16),
(27, 'Sabadim', 1, 16),
(27, 'Poiares', 7, 16),
(27, 'Vila Franca', 9, 16),
(28, 'São Jorge e Ermelo', 1, 16),
(28, 'Refoios do Lima', 7, 16),
(29, 'São Paio de Jolda', 1, 16),
(29, 'Ribeira', 7, 16),
(30, 'Senharei', 1, 16),
(30, 'Sá', 7, 16),
(31, 'Sistelo', 1, 16),
(31, 'Santa Comba', 7, 16),
(32, 'Soajo', 1, 16),
(32, 'Santa Cruz do Lima', 7, 16),
(33, 'Souto e Tabaçô', 1, 16),
(33, 'Santa Maria de Rebordões', 7, 16),
(34, 'Távora (Santa Maria e São Vicente)', 1, 16),
(34, 'São Pedro d\'Arcos', 7, 16),
(35, 'Vale', 1, 16),
(35, 'Souto de Rebordões', 7, 16),
(36, 'Vilela, São Cosme e São Damião e Sá', 1, 16),
(36, 'Seara', 7, 16),
(37, 'Serdedelo', 7, 16),
(38, 'Vale do Neiva', 7, 16),
(39, 'Vitorino das Donas', 7, 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `utilizador` int(11) NOT NULL,
  `dia_semana` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entrada` time NOT NULL,
  `saida` time NOT NULL,
  `registador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `horarios`
--

INSERT INTO `horarios` (`id`, `utilizador`, `dia_semana`, `entrada`, `saida`, `registador`) VALUES
(1, 1, 'Dom', '12:10:00', '13:45:00', 1),
(2, 1, 'Dom', '09:00:00', '12:00:00', 1),
(4, 47, 'Dom', '12:30:00', '17:40:00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lojas`
--

CREATE TABLE `lojas` (
  `id` int(11) NOT NULL,
  `localidade` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `lojas`
--

INSERT INTO `lojas` (`id`, `localidade`, `ip`) VALUES
(1, 'Viana do Castelo', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `encomenda_id` int(11) NOT NULL,
  `quantidade` int(10) UNSIGNED NOT NULL,
  `nome` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fornecedor_id` int(11) DEFAULT NULL,
  `data_pedido_fornecedor` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `seguimentos`
--

CREATE TABLE `seguimentos` (
  `situacao` int(11) NOT NULL,
  `descricao` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `seguimentos`
--

INSERT INTO `seguimentos` (`situacao`, `descricao`) VALUES
(1, 'ABERTO'),
(2, 'SEM SEGUIMENTO'),
(3, 'AGUARDA MATERIAL'),
(4, 'AGUARDA ADJUDICAÇÃO'),
(5, 'EM GARANTIA NA MARCA'),
(6, 'CONCLUIDO'),
(7, 'NÃO ACEITE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` char(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `data_criacao` int(11) NOT NULL DEFAULT unix_timestamp(),
  `desconectar` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id`, `username`, `password`, `admin`, `data_criacao`, `desconectar`) VALUES
(1, 'admin', '$2y$10$Hp3rXSlFFMiidMft7gMdsOaSdr6QzMyfX8QZkpKTG2akXgBGrVJBS', 1, 1562169867, 0),
(47, 'user', '$2y$10$ubPBqVc2XDOe6LCurhTD/eaZ8f7Cd6i.Z57IT1RV/aa6Lg0zsRuoS', 0, 1569493976, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `concelhos`
--
ALTER TABLE `concelhos`
  ADD PRIMARY KEY (`codigo`,`codigo_distrito`),
  ADD KEY `concelhos` (`codigo_distrito`);

--
-- Índices para tabela `crms`
--
ALTER TABLE `crms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seguimento` (`situacao`),
  ADD KEY `registador_id` (`registador_id`),
  ADD KEY `contacto_distrito_id` (`contacto_distrito_id`),
  ADD KEY `contacto_concelho_id` (`contacto_concelho_id`),
  ADD KEY `contacto_freguesia_id` (`contacto_freguesia_id`);

--
-- Índices para tabela `dias_semana`
--
ALTER TABLE `dias_semana`
  ADD PRIMARY KEY (`abv`);

--
-- Índices para tabela `distritos`
--
ALTER TABLE `distritos`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registador_id` (`registador_id`),
  ADD KEY `loja_id` (`loja_id`),
  ADD KEY `fornecedor_id` (`fornecedor_id`);

--
-- Índices para tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD UNIQUE KEY `nome_2` (`nome`);

--
-- Índices para tabela `freguesias`
--
ALTER TABLE `freguesias`
  ADD PRIMARY KEY (`codigo`,`codigo_concelho`,`codigo_distrito`),
  ADD KEY `codigo_concelho` (`codigo_concelho`),
  ADD KEY `codigo_distrito` (`codigo_distrito`);

--
-- Índices para tabela `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilizador` (`utilizador`),
  ADD KEY `registador` (`registador`),
  ADD KEY `dia_semana` (`dia_semana`);

--
-- Índices para tabela `lojas`
--
ALTER TABLE `lojas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `encomenda_id` (`encomenda_id`),
  ADD KEY `fornecedor_id` (`fornecedor_id`);

--
-- Índices para tabela `seguimentos`
--
ALTER TABLE `seguimentos`
  ADD PRIMARY KEY (`situacao`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `crms`
--
ALTER TABLE `crms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT de tabela `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `concelhos`
--
ALTER TABLE `concelhos`
  ADD CONSTRAINT `concelhos` FOREIGN KEY (`codigo_distrito`) REFERENCES `distritos` (`codigo`);

--
-- Limitadores para a tabela `crms`
--
ALTER TABLE `crms`
  ADD CONSTRAINT `crms_ibfk_1` FOREIGN KEY (`situacao`) REFERENCES `seguimentos` (`situacao`),
  ADD CONSTRAINT `crms_ibfk_2` FOREIGN KEY (`registador_id`) REFERENCES `utilizadores` (`id`),
  ADD CONSTRAINT `crms_ibfk_3` FOREIGN KEY (`contacto_distrito_id`) REFERENCES `distritos` (`codigo`),
  ADD CONSTRAINT `crms_ibfk_4` FOREIGN KEY (`contacto_concelho_id`) REFERENCES `concelhos` (`codigo`),
  ADD CONSTRAINT `crms_ibfk_5` FOREIGN KEY (`contacto_freguesia_id`) REFERENCES `freguesias` (`codigo`);

--
-- Limitadores para a tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD CONSTRAINT `encomendas_ibfk_1` FOREIGN KEY (`registador_id`) REFERENCES `utilizadores` (`id`),
  ADD CONSTRAINT `encomendas_ibfk_2` FOREIGN KEY (`loja_id`) REFERENCES `lojas` (`id`),
  ADD CONSTRAINT `encomendas_ibfk_3` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`);

--
-- Limitadores para a tabela `freguesias`
--
ALTER TABLE `freguesias`
  ADD CONSTRAINT `freguesias_ibfk_1` FOREIGN KEY (`codigo_concelho`) REFERENCES `concelhos` (`codigo`),
  ADD CONSTRAINT `freguesias_ibfk_2` FOREIGN KEY (`codigo_distrito`) REFERENCES `distritos` (`codigo`);

--
-- Limitadores para a tabela `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`utilizador`) REFERENCES `utilizadores` (`id`),
  ADD CONSTRAINT `horarios_ibfk_2` FOREIGN KEY (`registador`) REFERENCES `utilizadores` (`id`),
  ADD CONSTRAINT `horarios_ibfk_3` FOREIGN KEY (`dia_semana`) REFERENCES `dias_semana` (`abv`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`encomenda_id`) REFERENCES `encomendas` (`id`),
  ADD CONSTRAINT `produtos_ibfk_2` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
