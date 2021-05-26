-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 21-Dez-2019 às 14:01
-- Versão do servidor: 5.5.64-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flux_29`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `area_id` int(11) NOT NULL,
  `area_title` varchar(200) DEFAULT NULL,
  `area_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `area`
--

INSERT INTO `area` (`area_id`, `area_title`, `area_url`) VALUES
(1, 'Institucional', 'institucional'),
(2, 'Nossas Dicas', 'nossas-dicas'),
(4, 'Tire suas Dúvidas', 'tire-suas-duvidas'),
(5, 'Serviços', 'servicos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `atributo`
--

CREATE TABLE IF NOT EXISTS `atributo` (
  `atributo_id` int(11) NOT NULL,
  `atributo_nome` varchar(100) DEFAULT NULL,
  `atributo_item` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `atributo`
--

INSERT INTO `atributo` (`atributo_id`, `atributo_nome`, `atributo_item`) VALUES
(1, 'Cores', NULL),
(2, 'Tamanho', NULL),
(3, 'Voltagem', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

CREATE TABLE IF NOT EXISTS `avaliacao` (
  `avaliacao_id` int(11) NOT NULL,
  `avaliacao_nota` int(11) DEFAULT NULL,
  `avaliacao_produto` int(11) DEFAULT NULL,
  `avaliacao_comentario` text,
  `avaliacao_usuario` int(11) DEFAULT NULL,
  `avaliacao_data` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `avaliacao_aprovado` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `categoria_id` int(11) NOT NULL,
  `categoria_title` varchar(200) DEFAULT NULL,
  `categoria_url` varchar(200) DEFAULT NULL,
  `categoria_pos` int(11) DEFAULT '0',
  `categoria_icon` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `categoria_title`, `categoria_url`, `categoria_pos`, `categoria_icon`) VALUES
(1, 'Telefonia', 'telefonia', 1, 'celphone.png'),
(2, 'Eletrônicos', 'eletronicos', 2, 'eletronico.png'),
(3, 'Utilidades Domésticas', 'utilidades-domesticas', 3, 'domestico.png'),
(4, 'Casa e Jardim', 'casa-e-jardim', 0, 'casa.png'),
(5, 'Escritório', 'escritorio', 0, 'escritorio.png'),
(6, 'Automotivo', 'automotivo', 0, 'car.png'),
(8, 'Informática', 'informatica', 0, 'notebook.png'),
(9, 'TV', 'tv', 0, 'tv.png'),
(10, 'Eletrodomésticos', 'eletrodomesticos', 0, '2eletro.png'),
(11, 'Roupas e Acessórios', 'roupas-e-acessorios', 0, 'jacket.png'),
(12, 'Bebê', 'bebe', 0, 'bebe2.png'),
(13, 'Beleza e Saúde', 'beleza-e-saude', 0, 'beleza.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `cliente_id` int(11) NOT NULL,
  `cliente_nome` varchar(200) DEFAULT NULL,
  `cliente_datan` varchar(20) DEFAULT NULL,
  `cliente_email` varchar(200) DEFAULT NULL,
  `cliente_telefone` varchar(20) DEFAULT NULL,
  `cliente_password` varchar(100) DEFAULT NULL,
  `cliente_sexo` int(11) DEFAULT '1' COMMENT '1 = masc\r\n2 = fem',
  `cliente_celular` varchar(20) DEFAULT NULL,
  `cliente_datacad` varchar(20) DEFAULT NULL,
  `cliente_sobrenome` varchar(200) DEFAULT NULL,
  `cliente_ie` varchar(200) DEFAULT NULL,
  `cliente_cnpj` varchar(200) DEFAULT NULL,
  `cliente_contato` varchar(200) DEFAULT NULL,
  `cliente_cpf` varchar(25) DEFAULT NULL,
  `cliente_tipo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`cliente_id`, `cliente_nome`, `cliente_datan`, `cliente_email`, `cliente_telefone`, `cliente_password`, `cliente_sexo`, `cliente_celular`, `cliente_datacad`, `cliente_sobrenome`, `cliente_ie`, `cliente_cnpj`, `cliente_contato`, `cliente_cpf`, `cliente_tipo`) VALUES
(1, 'PHP', '19/05/1982', 'teste@teste.com', '(13) 5555-5555', '698dc19d489c4e4db73e28a713eab07b', 1, '', '09/11/2017 10:39', 'STAFF', NULL, '', '', '001.105.898-66', 'Pessoa Física');

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `config_id` int(11) NOT NULL,
  `config_site_title` varchar(500) DEFAULT NULL,
  `config_site_description` text,
  `config_site_keywords` text,
  `config_site_menu` int(11) DEFAULT '0' COMMENT '1 = sim',
  `config_site_social` text,
  `config_site_fone1` varchar(40) DEFAULT NULL,
  `config_site_fone2` varchar(40) DEFAULT NULL,
  `config_site_email` varchar(200) DEFAULT NULL,
  `config_site_cep` varchar(20) DEFAULT NULL,
  `config_site_rua` varchar(200) DEFAULT NULL,
  `config_site_num` varchar(20) DEFAULT NULL,
  `config_site_bairro` varchar(200) DEFAULT NULL,
  `config_site_cidade` varchar(200) DEFAULT NULL,
  `config_site_uf` varchar(20) DEFAULT NULL,
  `config_site_complemento` varchar(200) DEFAULT NULL,
  `config_site_cnpj` text,
  `config_site_informacao` varchar(800) DEFAULT NULL,
  `config_site_horario` varchar(400) NOT NULL,
  `config_chat` text,
  `config_color_bd` varchar(20) DEFAULT NULL,
  `config_color_bh` varchar(20) DEFAULT NULL,
  `config_color_cd` varchar(20) DEFAULT NULL,
  `config_color_ch` varchar(20) DEFAULT NULL,
  `config_color_bk` varchar(20) DEFAULT NULL,
  `config_color_top` varchar(20) DEFAULT 'fafafa',
  `config_modo` int(1) NOT NULL DEFAULT '1',
  `config_site_prodhome` int(11) DEFAULT '0',
  `config_site_full` varchar(20) NOT NULL DEFAULT '-fluid',
  `config_site_depoimento` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`config_id`, `config_site_title`, `config_site_description`, `config_site_keywords`, `config_site_menu`, `config_site_social`, `config_site_fone1`, `config_site_fone2`, `config_site_email`, `config_site_cep`, `config_site_rua`, `config_site_num`, `config_site_bairro`, `config_site_cidade`, `config_site_uf`, `config_site_complemento`, `config_site_cnpj`, `config_site_informacao`, `config_site_horario`, `config_chat`, `config_color_bd`, `config_color_bh`, `config_color_cd`, `config_color_ch`, `config_color_bk`, `config_color_top`, `config_modo`, `config_site_prodhome`, `config_site_full`, `config_site_depoimento`) VALUES
(1, 'FluxShop V3', 'Mercado Pago Integrado', 'fluxshop, mercadopago, loja virtual,php, phpstaff', 0, '<div class="shareaholic-canvas" data-app="share_buttons" data-app-id="5390245"></div> <script type="text/javascript"> var shr = document.createElement("script"); shr.setAttribute("data-cfasync", "false"); shr.src = "//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js"; shr.type = "text/javascript"; shr.async = "true"; shr.onload = shr.onreadystatechange = function() { var rs = this.readyState; if (rs && rs != "complete" && rs != "loaded") return; var site_id = "39e07923cec488add2e8c7d4263934e0"; try { Shareaholic.init(site_id); } catch (e) {console.log(e)} }; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(shr, s); </script>', '11 8888-9999', '11 8888-9999', 'falecom@fluxshop.com.br', '11701-380', 'Avenida São Paulo', '500', 'Boqueirão', 'Praia Grande', 'SP', '', '09.876.543/0001-99', 'A Plataforma FluxShop foi desenvolvida por PHP STAFF <br><br>\r\nTodos os preços e condições comerciais estão sujeitos a alteração sem aviso prévio. Ofertas válidas enquanto durarem nossos estoques.<br/>As imagens dos produtos são meramente ilustrativas.<br/>', 'De segunda a sexta das 8:30 as 17:00', '', '252929', '64a5de', 'ffffff', 'ffffff', '000000', 'fafafa', 1, 1, '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cupom`
--

CREATE TABLE IF NOT EXISTS `cupom` (
  `cupom_id` int(11) NOT NULL,
  `cupom_alfa` varchar(12) DEFAULT NULL,
  `cupom_status` int(11) DEFAULT '0' COMMENT '1 = ativado',
  `cupom_update` varchar(20) DEFAULT NULL,
  `cupom_lote` int(11) DEFAULT '1',
  `cupom_desconto` int(11) DEFAULT NULL,
  `cupom_pedido` int(11) DEFAULT NULL,
  `cupom_tipo` int(11) DEFAULT '1' COMMENT '1 = desconto do total\r\n2 = desconta frete',
  `cupom_min` int(11) DEFAULT '10',
  `cupom_validade` datetime DEFAULT NULL,
  `cupom_limite` int(11) DEFAULT '1' COMMENT '2 nao',
  `cupom_real` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cupom`
--

INSERT INTO `cupom` (`cupom_id`, `cupom_alfa`, `cupom_status`, `cupom_update`, `cupom_lote`, `cupom_desconto`, `cupom_pedido`, `cupom_tipo`, `cupom_min`, `cupom_validade`, `cupom_limite`, `cupom_real`) VALUES
(7, 'BLACK', 0, NULL, 1, 0, NULL, 1, 10, '2017-11-30 00:00:00', 2, '16.10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `depoimento`
--

CREATE TABLE IF NOT EXISTS `depoimento` (
  `depoimento_id` int(11) NOT NULL,
  `depoimento_nome` varchar(200) DEFAULT NULL,
  `depoimento_foto` varchar(200) DEFAULT NULL,
  `depoimento_msg` text,
  `depoimento_status` int(11) DEFAULT NULL,
  `depoimento_data` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `depoimento`
--

INSERT INTO `depoimento` (`depoimento_id`, `depoimento_nome`, `depoimento_foto`, `depoimento_msg`, `depoimento_status`, `depoimento_data`) VALUES
(1, 'Fulano', '1.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !', NULL, '10-03-2016'),
(2, 'Ciclano', '2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !', NULL, '10-03-2016'),
(3, 'Beltrano', '3.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !', NULL, '10-03-2016');

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE IF NOT EXISTS `endereco` (
  `endereco_id` int(11) NOT NULL,
  `endereco_cliente` int(11) DEFAULT NULL,
  `endereco_rua` varchar(300) DEFAULT NULL,
  `endereco_uf` varchar(2) DEFAULT NULL,
  `endereco_num` varchar(20) DEFAULT NULL,
  `endereco_complemento` varchar(2000) DEFAULT NULL,
  `endereco_cidade` varchar(200) DEFAULT NULL,
  `endereco_bairro` varchar(200) DEFAULT NULL,
  `endereco_tipo` int(11) DEFAULT '1' COMMENT '1 = cobranca',
  `endereco_title` varchar(200) DEFAULT NULL,
  `endereco_cep` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`endereco_id`, `endereco_cliente`, `endereco_rua`, `endereco_uf`, `endereco_num`, `endereco_complemento`, `endereco_cidade`, `endereco_bairro`, `endereco_tipo`, `endereco_title`, `endereco_cep`) VALUES
(1, 1, 'Avenida São Paulo', 'SP', '400', '', 'Praia Grande', 'Boqueirão', 1, 'Endereço de Correspondência', '11701-380');

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrega`
--

CREATE TABLE IF NOT EXISTS `entrega` (
  `entrega_id` int(11) NOT NULL,
  `entrega_valor` varchar(20) DEFAULT NULL,
  `entrega_bairro` varchar(200) DEFAULT NULL,
  `entrega_cidade` varchar(200) DEFAULT NULL,
  `entrega_uf` varchar(10) DEFAULT NULL,
  `entrega_cep` varchar(20) DEFAULT NULL,
  `entrega_tipo` int(11) DEFAULT '1' COMMENT '1 - uf\r\n2 - cidade\r\n3 - bairro',
  `entrega_prazo` varchar(200) DEFAULT '7',
  `entrega_desc` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `faixacep`
--

CREATE TABLE IF NOT EXISTS `faixacep` (
  `faixacep_id` int(11) NOT NULL,
  `faixacep_cep_inicio` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `faixacep_cep_final` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `faixacep_desc` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `faixacep_peso_de` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `faixacep_peso_ate` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `faixacep_valor` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `faixacep_prazo` varchar(255) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `faixacep`
--

INSERT INTO `faixacep` (`faixacep_id`, `faixacep_cep_inicio`, `faixacep_cep_final`, `faixacep_desc`, `faixacep_peso_de`, `faixacep_peso_ate`, `faixacep_valor`, `faixacep_prazo`) VALUES
(2, '11701000', '11701999', 'Frete Especial', '0,00', '5,00', '0,00', '1 a 2 dia(s)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `foto`
--

CREATE TABLE IF NOT EXISTS `foto` (
  `foto_id` int(11) NOT NULL,
  `foto_title` varchar(200) DEFAULT NULL,
  `foto_url` varchar(200) DEFAULT NULL,
  `foto_pos` int(11) DEFAULT '0',
  `foto_item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `frete`
--

CREATE TABLE IF NOT EXISTS `frete` (
  `frete_id` int(11) NOT NULL,
  `frete_cep_origem` varchar(20) DEFAULT NULL,
  `frete_taxa` double DEFAULT NULL,
  `frete_pac` int(11) DEFAULT '1' COMMENT '1 = ativo',
  `frete_sedex` int(11) DEFAULT '1' COMMENT '1 = ativo',
  `frete_sedexac` int(11) DEFAULT '1' COMMENT '1 = ativo',
  `frete_sedex10` int(11) DEFAULT '1' COMMENT '1 = ativo',
  `frete_prazo` int(11) DEFAULT '9',
  `frete_show_free` int(11) DEFAULT '1' COMMENT '2 = nao',
  `frete_opcoes` int(11) DEFAULT '1' COMMENT '1 = todos\r\n2 = somente entrega\r\n3 = somente retirada',
  `frete_apt` double(10,0) NOT NULL,
  `frete_sul` double(10,0) DEFAULT NULL,
  `frete_nome` varchar(200) DEFAULT NULL,
  `frete_perc_sul` double(10,0) DEFAULT NULL,
  `frete_perc_apt` double(10,0) DEFAULT NULL,
  `frete_perc_prazo_sul` varchar(100) DEFAULT NULL,
  `frete_perc_prazo_outros` varchar(100) DEFAULT NULL,
  `frete_braspress` varchar(30) NOT NULL DEFAULT '0000000000',
  `frete_braspress_nome` varchar(200) NOT NULL DEFAULT 'TRANSPORTADORA Braspress',
  `frete_braspress_ativo` int(11) DEFAULT '0',
  `frete_jadlog_nome` varchar(255) DEFAULT 'TRANSPORTADORA JADLOG',
  `frete_jadlog_senha` varchar(200) DEFAULT NULL,
  `frete_jadlog_ativo` int(11) DEFAULT '0',
  `frete_jadlog_cnpj` varchar(200) DEFAULT NULL,
  `frete_jamef_nome` varchar(200) DEFAULT 'TRANSPORTADORA JAMEF',
  `frete_jamef_user` varchar(200) DEFAULT NULL,
  `frete_jamef_cnpj` varchar(200) DEFAULT NULL,
  `frete_jamef_filial` varchar(200) DEFAULT NULL,
  `frete_jamef_ativo` int(1) DEFAULT '0',
  `frete_redecargo_nome` varchar(200) DEFAULT 'TRANSPORTADORA REDECARGO',
  `frete_redecargo_chave` varchar(200) DEFAULT NULL,
  `frete_dlog_nome` varchar(200) DEFAULT 'TRANSPORTADORA DLOG',
  `frete_dlog_login` varchar(200) DEFAULT NULL,
  `frete_dlog_token` varchar(200) DEFAULT NULL,
  `frete_dlog_ativo` int(1) DEFAULT '0',
  `frete_tnt_nome` varchar(200) DEFAULT 'TRANSPORTADORA TNT',
  `frete_tnt_login` varchar(200) DEFAULT NULL,
  `frete_tnt_remid` varchar(200) DEFAULT NULL,
  `frete_tnt_ie` varchar(200) DEFAULT NULL,
  `frete_tnt_tipo` varchar(200) DEFAULT 'RNC',
  `frete_tnt_ativo` int(1) DEFAULT '0',
  `frete_redecargo_ativo` int(1) DEFAULT '0',
  `frete_tnt_tipo_frete` varchar(200) DEFAULT 'C',
  `frete_tnt_tributaria` varchar(200) DEFAULT 'CO',
  `frete_tnt_divisao` varchar(200) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `frete`
--

INSERT INTO `frete` (`frete_id`, `frete_cep_origem`, `frete_taxa`, `frete_pac`, `frete_sedex`, `frete_sedexac`, `frete_sedex10`, `frete_prazo`, `frete_show_free`, `frete_opcoes`, `frete_apt`, `frete_sul`, `frete_nome`, `frete_perc_sul`, `frete_perc_apt`, `frete_perc_prazo_sul`, `frete_perc_prazo_outros`, `frete_braspress`, `frete_braspress_nome`, `frete_braspress_ativo`, `frete_jadlog_nome`, `frete_jadlog_senha`, `frete_jadlog_ativo`, `frete_jadlog_cnpj`, `frete_jamef_nome`, `frete_jamef_user`, `frete_jamef_cnpj`, `frete_jamef_filial`, `frete_jamef_ativo`, `frete_redecargo_nome`, `frete_redecargo_chave`, `frete_dlog_nome`, `frete_dlog_login`, `frete_dlog_token`, `frete_dlog_ativo`, `frete_tnt_nome`, `frete_tnt_login`, `frete_tnt_remid`, `frete_tnt_ie`, `frete_tnt_tipo`, `frete_tnt_ativo`, `frete_redecargo_ativo`) VALUES
(1, '11701380', 0, 1, 1, 0, 0, 7, 2, 2, 0, 0, NULL, 10, 20, '3 à 7 dias úteis', '7 à 15 dias úteis', '', 'Braspress', 0, 'TRANSPORTADORA JADLOG', '', 0, '', 'TRANSPORTADORA JAMEF', '', '', '', 0, 'TRANSPORTADORA REDECARGO', '', 'TRANSPORTADORA DLOG', '', '', 0, 'TRANSPORTADORA TNT', '', '', '', 'RNC', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `iattr`
--

CREATE TABLE IF NOT EXISTS `iattr` (
  `iattr_id` int(11) NOT NULL,
  `iattr_atributo` int(11) DEFAULT NULL,
  `iattr_nome` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `iattr`
--

INSERT INTO `iattr` (`iattr_id`, `iattr_atributo`, `iattr_nome`) VALUES
(2, 1, 'Azul Royal'),
(5, 2, 'Pequeno'),
(6, 2, 'M'),
(7, 2, 'G'),
(8, 2, 'GG'),
(9, 1, 'Vermelho'),
(10, 1, 'Branco'),
(11, 1, 'Verde'),
(12, 1, 'Preto'),
(13, 3, '110 V'),
(14, 3, '220 V'),
(15, 1, 'Avelã'),
(16, 1, 'Pink'),
(17, 1, 'Lilás'),
(18, 1, 'Azul Marinho'),
(19, 1, 'Palha'),
(20, 1, 'Cenoura'),
(21, 1, 'Telha'),
(22, 1, 'Mostarda'),
(23, 1, 'Vinho'),
(24, 1, 'Estampado'),
(25, 1, 'Rosa'),
(26, 1, 'Azul Turquesa'),
(27, 1, 'Verde Oliva'),
(28, 1, 'Verde Pistache'),
(29, 1, 'Azul'),
(30, 1, 'Chocolate'),
(31, 1, 'Tabaco'),
(32, 1, 'Roxo'),
(33, 1, 'Rosê'),
(34, 1, 'Goiaba'),
(35, 1, 'Zebra'),
(36, 1, 'Onça'),
(37, 1, 'Verde/Tabaco'),
(38, 1, 'Tabaco/Avelã'),
(39, 1, 'Roxo/Lilás'),
(40, 1, 'Vermelho/Avelã');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL,
  `item_title` varchar(200) DEFAULT NULL,
  `item_desc` text,
  `item_sub` int(11) DEFAULT NULL,
  `item_preco` double DEFAULT NULL,
  `item_keywords` varchar(2000) DEFAULT NULL,
  `item_url` varchar(300) DEFAULT NULL,
  `item_show` int(11) DEFAULT '0' COMMENT '1 = sim',
  `item_oferta` int(11) DEFAULT '0' COMMENT '1 = sim',
  `item_views` int(11) DEFAULT '0',
  `item_categoria` int(11) DEFAULT NULL,
  `item_largura` varchar(20) DEFAULT '12',
  `item_altura` varchar(20) DEFAULT '4',
  `item_comprimento` varchar(20) DEFAULT '16',
  `item_tamanho` varchar(255) DEFAULT NULL,
  `item_peso` varchar(20) DEFAULT '0.5',
  `item_parc` int(11) DEFAULT '1',
  `item_desconto` double DEFAULT '0',
  `item_calcula_frete` int(11) DEFAULT '2' COMMENT '2 = sim',
  `item_slide` int(11) DEFAULT '0' COMMENT '1 = sim',
  `item_zoom` int(11) DEFAULT '1' COMMENT '0 = nao',
  `item_estoque` int(11) DEFAULT '5',
  `item_min_estoque` int(5) NOT NULL DEFAULT '5',
  `item_destaque` int(11) DEFAULT '1' COMMENT '0 = nao',
  `item_ref` varchar(30) DEFAULT NULL,
  `item_marca` int(5) NOT NULL,
  `item_disp` varchar(2000) NOT NULL DEFAULT 'Postagem em até 15 dias úteis após a confirmação de pagamento.',
  `item_pos` int(5) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`item_id`, `item_title`, `item_desc`, `item_sub`, `item_preco`, `item_keywords`, `item_url`, `item_show`, `item_oferta`, `item_views`, `item_categoria`, `item_largura`, `item_altura`, `item_comprimento`, `item_tamanho`, `item_peso`, `item_parc`, `item_desconto`, `item_calcula_frete`, `item_slide`, `item_zoom`, `item_estoque`, `item_min_estoque`, `item_destaque`, `item_ref`, `item_marca`, `item_disp`, `item_pos`) VALUES
(5, 'Ipad Air, Tela 9”, 1GB, Allwinner A13 1.5GHz, Android 4.0, Wi-Fi, Bluetooth e Câmeras Frontal e Traseira', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 10, 100, 'ipad, tablet, ios', 'ipad-air-tela-9-1gb-allwinner-a13-1-5ghz-android-4-0-wi-fi-bluetooth-e-cameras-frontal-e-traseira', 1, 0, 512, 8, '44,00', '21,00', '26,00', NULL, '3', 6, 0, 2, 1, 1, 72, 5, 1, '', 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(7, 'Notebook Acer Intel® Inside® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition', '<p>Dimensões Aproximadas do Produto: Produto Fictício &nbsp;® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p>\r\n\r\nAltura: 3,00 cm<br>\r\n\r\nLargura: 38,00 cm<br>\r\n\r\nProfundidade: 25,00 cm<br>\r\n\r\nPeso: 2,60 kg<br>\r\n\r\n<br>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;">\r\n\r\n<tbody style=" outline-style: none; margin: 0px; padding: 0px;">\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n</tbody>\r\n\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n<span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br>\r\n</span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 9, 2500, 'notebook, acer, intel', 'notebook-acer-intel-inside-b820-e1-531-2606-2gb-hd-320gb-15-6-webcam-wireless-hdmi-windows-7-starter-edition', 1, 0, 1314, 8, '12', '4', '16', NULL, '0.5', 10, 150, 2, 1, 1, 54, 5, 1, NULL, 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(12, 'Regatinha PitsBaby', '<p>Dimensões Aproximadas do Produto: Produto Fictício &nbsp;® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p>\r\n\r\nAltura: 3,00 cm<br>\r\n\r\nLargura: 38,00 cm<br>\r\n\r\nProfundidade: 25,00 cm<br>\r\n\r\nPeso: 2,60 kg<br>\r\n\r\n<br>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;">\r\n\r\n<tbody style=" outline-style: none; margin: 0px; padding: 0px;">\r\n\r\n  <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n</tbody>\r\n\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n<span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br>\r\n</span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 15, 50, 'baby', 'regatinha-pitsbaby', 1, 0, 78, 11, '12', '4', '16', NULL, '0.5', 1, 0, 2, 0, 0, -14, 5, 1, NULL, 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(16, 'Mamadeira Magia Silicone 120ml Dragão Azul Lillo', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p>\r\nAltura: 3,00 cm<br>\r\nLargura: 38,00 cm<br>\r\nProfundidade: 25,00 cm<br>\r\nPeso: 2,60 kg<br>\r\n<br>\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;">\r\n<tbody style=" outline-style: none; margin: 0px; padding: 0px;">\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th>\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td>\r\n  </tr>\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th>\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td>\r\n </tr>\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th>\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td>\r\n  </tr>\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th>\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td>\r\n </tr>\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th>\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td>\r\n  </tr>\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th>\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td>\r\n </tr>\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th>\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td>\r\n  </tr>\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th>\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n  </tr>\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th>\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td>\r\n  </tr>\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th>\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td>\r\n </tr>\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th>\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n<span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br>\r\n</span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 19, 48, '', 'mamadeira-magia-silicone-120ml-dragao-azul-lillo', 1, 0, 43, 12, '12', '4', '16', NULL, '0.5', 1, 2, 2, 0, 0, 42, 5, 1, '', 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(22, 'Depurador de Ar Electrolux DE60B - 60 cm', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 25, 645, '', 'depurador-de-ar-electrolux-de60b-60-cm', 1, 1, 133, 10, '12', '4', '16', NULL, '0.5', 1, 0, 2, 0, 0, 56, 5, 1, '', 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(24, 'Secador Taiff Titanium Colors 2.100 W - Preto/Verde', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 27, 0, 'Taiff, turbo, infravermelho', 'secador-taiff-titanium-colors-2-100-w-preto-verde', 1, 0, 181, 13, '12', '4', '16', NULL, '0.5', 1, 0, 2, 0, 0, 100, 5, 0, '0024BS-S', 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(27, 'Telefone Digital sem Fio Retro Fashion Sixty Sagemcom Laranja com Secretária Eletrônica, Identificador de Chamadas e Viva Voz', '<p>Dimensões Aproximadas do Produto: Produto Fictício &nbsp;® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p>\r\n\r\nAltura: 3,00 cm<br>\r\n\r\nLargura: 38,00 cm<br>\r\n\r\nProfundidade: 25,00 cm<br>\r\n\r\nPeso: 2,60 kg<br>\r\n\r\n<br>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;">\r\n\r\n<tbody style=" outline-style: none; margin: 0px; padding: 0px;">\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n</tbody>\r\n\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n<span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br>\r\n</span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 30, 798, 'telefone sem fio, telefone sem fio secretária eletrônica, telefone colorido', 'telefone-digital-sem-fio-retro-fashion-sixty-sagemcom-laranja-com-secretaria-eletronica-identificador-de-chamadas-e-viva-voz', 1, 1, 222, 1, '12', '4', '16', NULL, '0.5', 1, 10, 2, 0, 0, 88, 5, 0, NULL, 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0);
INSERT INTO `item` (`item_id`, `item_title`, `item_desc`, `item_sub`, `item_preco`, `item_keywords`, `item_url`, `item_show`, `item_oferta`, `item_views`, `item_categoria`, `item_largura`, `item_altura`, `item_comprimento`, `item_tamanho`, `item_peso`, `item_parc`, `item_desconto`, `item_calcula_frete`, `item_slide`, `item_zoom`, `item_estoque`, `item_min_estoque`, `item_destaque`, `item_ref`, `item_marca`, `item_disp`, `item_pos`) VALUES
(28, 'Celular Desbloqueado Nokia Asha 305 Grafite com Câmera 2MP, Dual Chip, Touch Screen, Rádio FM, MP3, Bluetooth, Fone de Ouvido e Cartão 2GB', '<p>Dimensões Aproximadas do Produto: Produto Fictício &nbsp;® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p>\r\n\r\nAltura: 3,00 cm<br>\r\n\r\nLargura: 38,00 cm<br>\r\n\r\nProfundidade: 25,00 cm<br>\r\n\r\nPeso: 2,60 kg<br>\r\n\r\n<br>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;">\r\n\r\n<tbody style=" outline-style: none; margin: 0px; padding: 0px;">\r\n\r\n  <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n</tbody>\r\n\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n<span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br>\r\n</span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 31, 480, 'Celular Nokia, Celular, Nokia, Nokia Asha', 'celular-desbloqueado-nokia-asha-305-grafite-com-camera-2mp-dual-chip-touch-screen-radio-fm-mp3-bluetooth-fone-de-ouvido-e-cartao-2gb', 1, 1, 77, 1, '12', '4', '16', NULL, '0.5', 1, 0, 2, 0, 0, 96, 5, 0, NULL, 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(33, 'Smart TV Slim LED 32&#034; Full HD Samsung 32F5500 com Função Futebol, 120Hz Clear Motion Rate, Wi-Fi e Conversor Digital com Sistema Ginga', '<p>Dimensões Aproximadas do Produto: Produto Fictício &nbsp;® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p>\r\n\r\nAltura: 3,00 cm<br>\r\n\r\nLargura: 38,00 cm<br>\r\n\r\nProfundidade: 25,00 cm<br>\r\n\r\nPeso: 2,60 kg<br>\r\n\r\n<br>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;">\r\n\r\n<tbody style=" outline-style: none; margin: 0px; padding: 0px;">\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n</tbody>\r\n\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n<span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br>\r\n</span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 36, 2600, 'Smart Tv, Smart Tv 32, Tv led', 'smart-tv-slim-led-32-full-hd-samsung-32f5500-com-funcao-futebol-120hz-clear-motion-rate-wi-fi-e-conversor-digital-com-sistema-ginga', 1, 0, 12, 9, '12', '4', '16', NULL, '0.5', 1, 15, 2, 0, 0, 100, 5, 0, NULL, 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(34, 'TV Plasma 60” Full HD LG 60PN6500 com Conversor Digital e Entradas HDMI e USB', '<p>Dimensões Aproximadas do Produto: Produto Fictício &nbsp;® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p>\r\n\r\nAltura: 3,00 cm<br>\r\n\r\nLargura: 38,00 cm<br>\r\n\r\nProfundidade: 25,00 cm<br>\r\n\r\nPeso: 2,60 kg<br>\r\n\r\n<br>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;">\r\n\r\n<tbody style=" outline-style: none; margin: 0px; padding: 0px;">\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n</tbody>\r\n\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n<span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br>\r\n</span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 37, 6000, 'Tv 60 Polegadas, Tv 60, Tv Plasma, Tv Plasma 60', 'tv-plasma-60-full-hd-lg-60pn6500-com-conversor-digital-e-entradas-hdmi-e-usb', 1, 1, 10, 9, '12', '4', '16', NULL, '0.5', 1, 0, 2, 0, 0, 95, 5, 0, NULL, 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(37, 'Ultrabook Touch Acer Aspire M5-481PT-6_BR868 com Intel® Core™ i3-3227U, 4GB, 500GB, 20GB SSD, Gravador de DVD, HDMI, Bluetooth, LED 14" e Windows 8', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 40, 3000, 'Ultrabook, Ultrabook Com Gravador De Dvd, Ultrabook Acer, Acer', 'ultrabook-touch-acer-aspire-m5-481pt-6-br868-com-intel-core-i3-3227u-4gb-500gb-20gb-ssd-gravador-de-dvd-hdmi-bluetooth-led-14-e-windows-8', 1, 0, 32, 8, '12', '4', '16', NULL, '0.5', 1, 15, 2, 0, 0, 100, 5, 1, '', 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(43, 'Carrinho Classic Azul até 15kg Ayoba''s', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition''s</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 17, 1575, 'passeio, carrinho, ar livre', 'carrinho-classic-azul-ate-15kg-ayoba-s', 1, 0, 127, 12, '12', '4', '16', NULL, '1.5', 1, 0, 1, 0, 0, 98, 5, 0, 'REF001', 1, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(53, 'Lenço Umedecido Recém Nascido 48un Huggies Turma da Mônica', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 20, 43, '', 'lenco-umedecido-recem-nascido-48un-huggies-turma-da-monica', 1, 0, 4, 12, '12', '4', '16', NULL, '0.5', 1, 0, 2, 0, 0, 100, 5, 1, '', 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(56, 'Mochila de Segurança Morcego Urban', '<p>Dimensões Aproximadas do Produto: Produto Fictício &nbsp;® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p>\r\n\r\nAltura: 3,00 cm<br>\r\n\r\nLargura: 38,00 cm<br>\r\n\r\nProfundidade: 25,00 cm<br>\r\n\r\nPeso: 2,60 kg<br>\r\n\r\n<br>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;">\r\n\r\n<tbody style=" outline-style: none; margin: 0px; padding: 0px;">\r\n\r\n  <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n</tbody>\r\n\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n<span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br>\r\n</span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 21, 83, 'segurança, passeio, crianças', 'mochila-de-seguranca-morcego-urban', 1, 0, 8, 12, '12', '4', '16', NULL, '0.5', 1, 0, 2, 0, 0, 100, 5, 0, NULL, 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0);
INSERT INTO `item` (`item_id`, `item_title`, `item_desc`, `item_sub`, `item_preco`, `item_keywords`, `item_url`, `item_show`, `item_oferta`, `item_views`, `item_categoria`, `item_largura`, `item_altura`, `item_comprimento`, `item_tamanho`, `item_peso`, `item_parc`, `item_desconto`, `item_calcula_frete`, `item_slide`, `item_zoom`, `item_estoque`, `item_min_estoque`, `item_destaque`, `item_ref`, `item_marca`, `item_disp`, `item_pos`) VALUES
(57, 'Grade de Segurança Múltipla Função Branca Safety', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 21, 545, 'grade de segurança, proteção', 'grade-de-segurana-a-ma-ltipla-funa-a-o-branca-safety', 1, 0, 5, 12, '12', '4', '16', NULL, '0.5', 1, 0, 2, 0, 0, 100, 5, 0, '', 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(58, 'Protetor de Fogão', '<p>Dimensões Aproximadas do Produto: Produto Fictício ?® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 21, 300, 'protetor,fogão, crianças', 'protetor-de-foga-o', 1, 0, 27, 12, '12', '4', '16', NULL, '0.5', 1, 0, 2, 0, 0, 100, 5, 0, '', 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(62, 'Tigela Dip-it Rosa The First Years', '<p>Dimensões Aproximadas do Produto: Produto Fictício &nbsp;® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p>\r\n\r\nAltura: 3,00 cm<br>\r\n\r\nLargura: 38,00 cm<br>\r\n\r\nProfundidade: 25,00 cm<br>\r\n\r\nPeso: 2,60 kg<br>\r\n\r\n<br>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;">\r\n\r\n<tbody style=" outline-style: none; margin: 0px; padding: 0px;">\r\n\r\n  <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td>\r\n\r\n  </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th>\r\n\r\n\r\n    <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td>\r\n\r\n </tr>\r\n\r\n\r\n <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;">\r\n\r\n<th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th>\r\n\r\n\r\n   <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td>\r\n\r\n  </tr>\r\n\r\n</tbody>\r\n\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n\r\n<table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;">\r\n</table>\r\n\r\n<span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br>\r\n</span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 19, 48, 'alimentação, tigela, papinha', 'tigela-dip-it-rosa-the-first-years', 1, 0, 30, 12, '12', '4', '16', NULL, '0.5', 1, 10, 2, 0, 0, 99, 5, 0, NULL, 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(64, 'Tapete Gymini Sunny Day Tiny Love', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 16, 379, 'tapete recreativo, diversão, crianças', 'tapete-gymini-sunny-day-tiny-love', 1, 0, 52, 12, '12', '4', '16', NULL, '0.5', 10, 0, 2, 0, 0, 100, 5, 1, '', 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(65, 'Playset Toy Story 3 Tri-Country Imaginext Fisher Price', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 16, 800, 'cenário recreativo, toy story', 'playset-toy-story-3-tri-country-imaginext-fisher-price', 1, 0, 181, 12, '12', '4', '16', NULL, '0.5', 10, 0, 2, 0, 0, 87, 5, 1, '', 1, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(67, 'Jogo Lince Alfabeto Grow', '<p>Dimensões Aproximadas do Produto: Produto Fictício  ® B820, E1-531-2606, 2GB, HD 320GB, 15,6”, Webcam, Wireless, HDMI - Windows®7 Starter Edition</p> Altura: 3,00 cm<br> Largura: 38,00 cm<br> Profundidade: 25,00 cm<br> Peso: 2,60 kg<br> <br> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 100%;"> <tbody style=" outline-style: none; margin: 0px; padding: 0px;"> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">15,6"</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Resolução da Tela</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">1366 x 768</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Peso</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2,6kg</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Sistema Operacional</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Windows® 7 Starter Edition</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Processador</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Intel® Inside® B820</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Memória</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2GB DDR3</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Tamanho do HD</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">320GB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Web Cam Embutida</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Cache L2</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">2MB</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Quantas RPM</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">5400</td> </tr> <tr style=" outline-style: none; margin: 0px; padding: 0px; background-color: rgb(241, 241, 241); width: 990px;"> <th style="text-align: left; outline-style: none; margin: 0px; padding: 0px 10px; color: rgb(51, 51, 51); width: 330px;">Microfone Embutido</th> <td style=" outline-style: none; margin: 0px; padding: 9px 0px; vertical-align: top; color: rgb(51, 51, 51);">Sim</td> </tr> </tbody> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <table cellspacing="0" style=" outline-style: none; margin: 0px; padding: 0px; border-spacing: 0px; width: 990px;"> </table> <span id="maisCaracteristicas" style="outline-style: none; margin: 0px 0px 10px; padding: 0px; cursor: pointer; display: block;"><br> </span><h3><span style="outline-style: none; margin: 0px 0px 10px; padding: 0px; display: block;"><b>Este site é um sistema demonstrativo, não efetue compras nele.</b></span></h3>', 16, 0.99, 'jogo, alfabeto, turma da mônica', 'jogo-lince-alfabeto-grow', 1, 0, 84, 12, '12', '4', '16', NULL, '0.5', 1, 0, 1, 0, 0, 99, 5, 0, '', 0, 'Postagem em até 15 dias úteis após a confirmação de pagamento.', 0),
(68, 'Guia do Mochileiro Das Galáxias', '', 39, 900, 'guia', 'guia-do-mochileiro-das-gal-xias', 1, 0, 7, 8, '12', '4', '16', NULL, '0.6', 1, 0, 2, 0, 0, 150, 5, 0, 'PANIC', 0, '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lista`
--

CREATE TABLE IF NOT EXISTS `lista` (
  `lista_id` int(11) NOT NULL,
  `lista_item` int(11) DEFAULT NULL,
  `lista_preco` varchar(100) DEFAULT NULL,
  `lista_title` varchar(200) DEFAULT NULL,
  `lista_pedido` int(11) DEFAULT NULL,
  `lista_qtde` int(11) DEFAULT NULL,
  `lista_foto` varchar(200) DEFAULT NULL,
  `lista_atributos` varchar(2000) DEFAULT '0',
  `lista_atributo_ped` varchar(2000) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `lista`
--

INSERT INTO `lista` (`lista_id`, `lista_item`, `lista_preco`, `lista_title`, `lista_pedido`, `lista_qtde`, `lista_foto`, `lista_atributos`, `lista_atributo_ped`) VALUES
(105, 5, '100.00', 'Ipad Air, Tela 9”, 1GB, Allwinner A13 1.5GHz, Android 4.0, Wi-Fi, Bluetooth e Câmeras Frontal e Traseira', 31, 1, 'nopic.jpg', '', ''),
(106, 5, '100.00', 'Ipad Air, Tela 9”, 1GB, Allwinner A13 1.5GHz, Android 4.0, Wi-Fi, Bluetooth e Câmeras Frontal e Traseira', 32, 1, 'nopic.jpg', '', ''),
(107, 5, '100.00', 'Ipad Air, Tela 9”, 1GB, Allwinner A13 1.5GHz, Android 4.0, Wi-Fi, Bluetooth e Câmeras Frontal e Traseira', 33, 1, 'nopic.jpg', '', ''),
(108, 5, '100.00', 'Ipad Air, Tela 9”, 1GB, Allwinner A13 1.5GHz, Android 4.0, Wi-Fi, Bluetooth e Câmeras Frontal e Traseira', 34, 1, 'nopic.jpg', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lote`
--

CREATE TABLE IF NOT EXISTS `lote` (
  `lote_id` int(11) NOT NULL,
  `lote_num` int(11) DEFAULT '1',
  `lote_size` int(11) DEFAULT '100',
  `lote_nome` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `lote`
--

INSERT INTO `lote` (`lote_id`, `lote_num`, `lote_size`, `lote_nome`) VALUES
(2, 1, 1, 'BLACK');

-- --------------------------------------------------------

--
-- Estrutura da tabela `marca`
--

CREATE TABLE IF NOT EXISTS `marca` (
  `marca_id` int(11) NOT NULL,
  `marca_nome` varchar(200) NOT NULL,
  `marca_logo` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `marca`
--

INSERT INTO `marca` (`marca_id`, `marca_nome`, `marca_logo`) VALUES
(1, 'Mormaii', '123.jpg'),
(2, 'Gussaci', '345.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL,
  `news_nome` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `news_email` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `news_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(200) DEFAULT NULL,
  `page_content` text,
  `page_area` int(11) DEFAULT NULL,
  `page_url` varchar(300) DEFAULT NULL,
  `page_show` int(11) DEFAULT '1' COMMENT '2 = nao'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `page`
--

INSERT INTO `page` (`page_id`, `page_title`, `page_content`, `page_area`, `page_url`, `page_show`) VALUES
(3, 'Política de Privacidade', '<p style="text-align: justify;">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus eLorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<span rel="pastemarkerend" id="pastemarkerend76450"></span><br>\r\n\r\n</p>', 1, 'politica-de-privacidade', 1),
(4, 'Termos de Uso e Condições', '<p style="text-align: justify;">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<span rel="pastemarkerend" id="pastemarkerend23153"></span><br>\r\n\r\n</p>', 1, 'termos-de-uso-e-condicoes', 1),
(6, 'Formas de Pagamento', '<p><span style="line-height: 1.5em;">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span></p>\r\n\r\n\r\n<span rel="pastemarkerend" id="pastemarkerend91668"></span>', 4, 'formas-de-pagamento', 1),
(9, 'Cupom de Desconto', '<h2 style="margin: 0px 0px 0.57692em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; zoom: 1; color: rgb(85, 85, 85);">Cupons de Desconto</h2>\r\n\r\n<p style="margin: 0px 0px 1.2em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; color: rgb(153, 153, 153);">Os cupons de desconto da Baby podem ser usados por mamães e papais que buscam qualidade e economia nas compras para o bebê! Em nossa loja, existem dois tipos de cupons de desconto:</p>\r\n\r\n<h3 style="margin: 0px 0px 1.78571em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; text-transform: uppercase; color: rgb(85, 85, 85);">CUPOM COM DESCONTO PERCENTUAL</h3>\r\n\r\n<p style="margin: 0px 0px 1.2em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; color: rgb(153, 153, 153);">Este tipo de cupom garante um desconto proporcional ao valor de sua compra.</p>\r\n\r\n<p style="margin: 0px 0px 1.2em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; color: rgb(153, 153, 153);"><strong style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Exemplo:</strong>&nbsp;Caso você use um cupom com 15% de desconto, em uma compra de R$ 100, você pagará somente R$ 85 ao fechar seu pedido.</p>\r\n\r\n<h3 style="margin: 0px 0px 1.78571em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; text-transform: uppercase; color: rgb(85, 85, 85);">CUPOM COM DESCONTO ABSOLUTO</h3>\r\n\r\n<p style="margin: 0px 0px 1.2em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; color: rgb(153, 153, 153);">Este tipo de desconto simplesmente subtrai um valor fixo, em R$, do valor da sua compra.</p>\r\n\r\n<p style="margin: 0px 0px 1.2em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; color: rgb(153, 153, 153);"><strong style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Exemplo:</strong>&nbsp;Caso você use um cupom com R$ 30 de desconto, em uma compra de R$ 100, você pagará somente R$ 70 ao fechar o pedido.</p>\r\n\r\n<h3 style="margin: 0px 0px 1.78571em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; text-transform: uppercase; color: rgb(85, 85, 85);">UTILIZAR SEU CUPOM DE DESCONTO É MUITO FÁCIL</h3>\r\n\r\n\r\n<ol style="margin: 0px 0px 1.2em; padding: 0px 0px 0px 3.21429em; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; list-style-position: initial; list-style-image: initial; color: rgb(153, 153, 153);">\r\n\r\n <li style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Tenha em mãos o código do cupom de desconto que lhe foi concedido.</li>\r\n\r\n  <li style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Após adicionar todos os seus produtos no carrinho, siga para o caixa.</li>\r\n\r\n <li style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Lá, preencha seus dados e clique no link "Tenho cupom". Agora você só precisa inserir o código do desconto. Os valores serão atualizados automaticamente.</li>\r\n\r\n <li style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Confira se está tudo certo. Depois disso, é só finalizar a compra e esperar seus produtos chegarem! =)</li></ol>\r\n\r\n<h3 style="margin: 0px 0px 1.78571em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; text-transform: uppercase; color: rgb(85, 85, 85);">VALE LEMBRAR...</h3>\r\n\r\n<p style="margin: 0px 0px 1.2em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; color: rgb(153, 153, 153);">O desconto será aplicado somente no valor dos produtos, e não no valor do frete.</p>\r\n\r\n<h3 style="margin: 0px 0px 1.78571em; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent; text-transform: uppercase; color: rgb(85, 85, 85);">DÚVIDAS?<span rel="pastemarkerend" id="pastemarkerend27759"></span></h3>', 4, 'cupom-de-desconto', 1),
(10, 'Entregas e frete', '<p style="text-align: justify;"><b>Entenda as Regras para o Frete Grátis</b></p> <p style="text-align: justify;"><b><span style="line-height: 1.5em;">Sul e Sudeste (SP, MG, RJ, PR)<br> </span><span style="line-height: 1.5em;">Somente para pedidos acima de R$ 249,00</span></b></p> <p style="text-align: justify;"><b><span style="line-height: 1.5em;">Outros estados (ES, RS, SC, DF,ES,GO,MS,TO,AL,BA,CE,PB,PE,MA,MT,SE)<br> </span><span style="line-height: 1.5em;">Somente para pedidos acima de R$ 599,00</span></b></p> <p style="text-align: justify;"><span rel="pastemarkerend" id="pastemarkerend14763"></span><br> </p> <p style="text-align: justify;"><br> </p> <p style="text-align: justify;">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<span rel="pastemarkerend" id="pastemarkerend16496"></span><br> </p>', 4, 'entregas-e-frete', 1),
(11, 'Trocas e Devoluções', '<p style="text-align: justify;">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<span rel="pastemarkerend" id="pastemarkerend30107"></span><br>\r\n\r\n</p>', 4, 'trocas-e-devolucoes', 1),
(15, 'Pagamento Seguro', '<p style="text-align: justify;">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<span rel="pastemarkerend" id="pastemarkerend33392"></span><br>\r\n\r\n</p>', 2, 'pagamento-seguro', 1),
(16, 'Como aproveitar as promoções', '<p style="text-align: justify;">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<span rel="pastemarkerend" id="pastemarkerend1763"></span><br>\r\n</p>', 2, 'como-aproveitar-as-promocoes', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pay`
--

CREATE TABLE IF NOT EXISTS `pay` (
  `pay_id` int(11) NOT NULL,
  `pay_name` varchar(100) DEFAULT NULL,
  `pay_key` varchar(100) DEFAULT NULL,
  `pay_user` varchar(100) DEFAULT NULL,
  `pay_pass` varchar(100) DEFAULT NULL,
  `pay_retorno` varchar(200) DEFAULT NULL,
  `pay_status` int(11) DEFAULT '1' COMMENT '2=desativado',
  `pay_url_redir` varchar(600) DEFAULT NULL,
  `pay_fator_juros` varchar(1000) DEFAULT '1.00000, 0.52255, 0.35347, 0.26898, 0.21830, 0.18453, 0.16044, 0.14240, 0.12838, 0.11717, 0.10802, 0.10040 ',
  `pay_texto` text,
  `pay_c1` varchar(200) DEFAULT NULL,
  `pay_c2` varchar(200) DEFAULT NULL,
  `pay_c3` varchar(200) DEFAULT NULL,
  `pay_c4` varchar(200) DEFAULT NULL,
  `pay_c5` varchar(200) DEFAULT NULL,
  `pay_c6` varchar(200) DEFAULT NULL,
  `pay_c7` varchar(200) DEFAULT NULL,
  `pay_c8` varchar(400) DEFAULT NULL,
  `pay_c9` varchar(200) DEFAULT NULL,
  `pay_d1` varchar(200) DEFAULT NULL,
  `pay_d2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pay`
--

INSERT INTO `pay` (`pay_id`, `pay_name`, `pay_key`, `pay_user`, `pay_pass`, `pay_retorno`, `pay_status`, `pay_url_redir`, `pay_fator_juros`, `pay_texto`, `pay_c1`, `pay_c2`, `pay_c3`, `pay_c4`, `pay_c5`, `pay_c6`, `pay_c7`, `pay_c8`, `pay_c9`, `pay_d1`, `pay_d2`) VALUES
(1, 'PagSeguro', 'pagseguro', 'suporte@lojamodelo.com.br', NULL, '', 1, NULL, '20', NULL, '2', '0', '1', '2', 'SANDBOX', '12', NULL, NULL, NULL, NULL, NULL),
(3, 'Cielo', '25fbb99741c739dd84d7b06ec78c9bac718838630f30b112d033ce2e621b34f3', '1006993069', '2', 'http://localhost/projetos/fluxshop-2.8-dev/notificacao/', 1, '12', '5', 'Cartão de Crédito', '6', '0', '10', 'visa,mastercard,elo,amex,diners', '20.00', '2', NULL, NULL, NULL, NULL, NULL),
(4, 'Deposito', '6253', 'Itaú, Caixa', '33300.6', 'http://[baseUri]/notificacao/', 1, '', 'Rafael Clares Diniz', 'Banco Itaú\r\nAgência: 7589\r\nConta Corrente: 12457-6\r\nTitular: PHP STAFF LTDA.', '4', '0', '18', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Boleto', 'PHP STAFF LTDA.', 'Bradesco', '001.002.003-44', '', 0, NULL, '0', 'Boleto Bradesco', '1234', '5', '9876', '5', '107', '09.876.543/0001-99', 'Av. Paulista, 300', '11701-380', 'São Paulo', 'SP', '5'),
(6, 'Config', 'mercadoPago', 'pagseguro', NULL, '', 1, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'MercadoPago', 'TEST-2f376ef4-f982-475d-a2fb-5fcfbcd059a0', 'TEST-1743720828309551-090114-bdb4cce3abd508ac23b3e3bd6f13ad70__LD_LA__-183410571', NULL, 'http://localhost/projetos/fluxshop-mp/notificacao/mercadopago/', 1, NULL, '7', NULL, NULL, NULL, '1', NULL, 'PRODUCAO', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `pedido_id` int(11) NOT NULL,
  `pedido_data` varchar(20) DEFAULT NULL,
  `pedido_cliente` int(11) DEFAULT NULL,
  `pedido_status` int(11) DEFAULT '2' COMMENT '1 = pendente2 = andamento3 = finalizado',
  `pedido_total_frete` double DEFAULT NULL,
  `pedido_frete` double(10,2) DEFAULT NULL,
  `pedido_prazo` varchar(200) DEFAULT NULL,
  `pedido_tipo_frete` int(11) DEFAULT '1' COMMENT '1 = pac\r\n2 = sedex\r\n3 = sedex10',
  `pedido_pay_code` varchar(200) DEFAULT NULL,
  `pedido_pay_situacao` int(11) DEFAULT '1' COMMENT '1 pendente\r\n2 andamento\r\n3 finalizado\r\n4 cancelado',
  `pedido_pay_url` varchar(500) DEFAULT NULL,
  `pedido_endereco` int(11) DEFAULT NULL,
  `pedido_entrega` int(11) DEFAULT '1' COMMENT '1 = entrega\r\n2 = retirada\r\n',
  `pedido_pay_gw` int(11) DEFAULT '1' COMMENT '1 pagseguro\r\n2 paypal\r\n3 paybrass\r\n4 moip\r\n5 pagtodigital',
  `pedido_pay_meio` varchar(200) DEFAULT NULL,
  `pedido_pay_obs` text,
  `pedido_cupom_alfa` varchar(20) DEFAULT NULL,
  `pedido_cupom_desconto` double DEFAULT '0',
  `pedido_info` text,
  `pedido_obs` text,
  `pedido_cupom_info` varchar(300) DEFAULT NULL,
  `pedido_total_produto` double(10,2) DEFAULT NULL,
  `pedido_codigo_rastreio` varchar(30) DEFAULT NULL,
  `pedido_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pedido_comprovante` varchar(200) DEFAULT NULL,
  `pedido_total_parcelado` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`pedido_id`, `pedido_data`, `pedido_cliente`, `pedido_status`, `pedido_total_frete`, `pedido_frete`, `pedido_prazo`, `pedido_tipo_frete`, `pedido_pay_code`, `pedido_pay_situacao`, `pedido_pay_url`, `pedido_endereco`, `pedido_entrega`, `pedido_pay_gw`, `pedido_pay_meio`, `pedido_pay_obs`, `pedido_cupom_alfa`, `pedido_cupom_desconto`, `pedido_info`, `pedido_obs`, `pedido_cupom_info`, `pedido_total_produto`, `pedido_codigo_rastreio`, `pedido_update`, `pedido_comprovante`, `pedido_total_parcelado`) VALUES
(31, '21/12/2019 10:54', 1, 7, 0, 0.00, ' (Frete Especial)  ', 1, NULL, 1, '', 1, 1, 5, NULL, NULL, '', 20, NULL, NULL, 'Boleto: -20,00', 100.00, NULL, '2019-12-21 13:54:36', NULL, NULL),
(32, '21/12/2019 10:55', 1, 7, 0, 0.00, ' (Frete Especial)  ', 1, NULL, 1, '', 1, 1, 5, NULL, NULL, '', 20, NULL, NULL, 'Boleto: -20,00', 100.00, NULL, '2019-12-21 13:55:14', NULL, NULL),
(33, '21/12/2019 10:58', 1, 7, 0, 0.00, ' (Frete Especial)  ', 1, NULL, 1, '', 1, 1, 5, NULL, NULL, '', 20, NULL, NULL, 'Boleto: -20,00', 100.00, NULL, '2019-12-21 13:58:01', NULL, NULL),
(34, '21/12/2019 10:59', 1, 7, 0, 0.00, ' (Frete Especial)  ', 1, NULL, 1, '', 1, 1, 5, NULL, NULL, '', 20, NULL, NULL, 'Boleto: -20,00', 100.00, NULL, '2019-12-21 13:59:05', NULL, NULL),
(35, '21/12/2019 10:59', 1, 7, 0, 0.00, ' (Frete Especial)  ', 1, NULL, 1, '', 0, 0, 5, NULL, NULL, '', 0, NULL, NULL, 'Boleto: -0,00', 0.00, NULL, '2019-12-21 13:59:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `relacionado`
--

CREATE TABLE IF NOT EXISTS `relacionado` (
  `relacionadoid` int(11) NOT NULL,
  `produto_relacionado` int(11) NOT NULL,
  `produto_pai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatrr`
--

CREATE TABLE IF NOT EXISTS `relatrr` (
  `relatrr_id` int(11) NOT NULL,
  `relatrr_item` int(11) DEFAULT NULL,
  `relatrr_atributo` int(11) DEFAULT NULL,
  `relatrr_iattr` int(11) DEFAULT NULL,
  `relatrr_qtde` int(11) DEFAULT NULL,
  `relatrr_preco` varchar(30) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `relatrr`
--

INSERT INTO `relatrr` (`relatrr_id`, `relatrr_item`, `relatrr_atributo`, `relatrr_iattr`, `relatrr_qtde`, `relatrr_preco`) VALUES
(8, 43, 1, 2, -14, '0'),
(14, 227, 1, 10, 20, ''),
(15, 227, 1, 19, 20, ''),
(16, 225, 1, NULL, NULL, ''),
(17, 225, 1, 10, 20, ''),
(18, 225, 1, 19, 20, ''),
(19, 224, 1, NULL, NULL, ''),
(20, 224, 1, 10, 20, ''),
(21, 224, 1, 19, 20, ''),
(22, 239, 1, NULL, NULL, ''),
(23, 239, 1, 17, 20, ''),
(24, 239, 1, 9, 20, ''),
(25, 239, 1, 15, 20, ''),
(26, 237, 1, NULL, NULL, ''),
(27, 237, 1, 15, 20, ''),
(28, 237, 1, 9, 20, ''),
(29, 237, 1, 17, 20, ''),
(31, 243, 1, 9, 20, ''),
(32, 243, 1, 32, 20, ''),
(33, 243, 1, 31, 20, ''),
(34, 247, 1, NULL, NULL, ''),
(35, 247, 1, 10, 20, ''),
(36, 247, 1, 19, 20, ''),
(37, 247, 1, 17, 20, ''),
(38, 247, 1, 33, 20, ''),
(39, 247, 1, 11, 20, ''),
(41, 246, 1, 10, 20, ''),
(42, 246, 1, 17, 20, ''),
(43, 246, 1, 19, 20, ''),
(44, 246, 1, 33, 20, ''),
(45, 246, 1, 11, 20, ''),
(46, 248, 1, NULL, NULL, ''),
(47, 248, 1, 10, 20, ''),
(48, 248, 1, 17, 20, ''),
(49, 248, 1, 33, 20, ''),
(50, 248, 1, 11, 20, ''),
(51, 248, 1, 19, 20, ''),
(53, 266, 1, 15, 20, ''),
(54, 266, 1, 19, 20, ''),
(55, 266, 1, 10, 20, ''),
(56, 266, 1, 31, 20, ''),
(57, 266, 1, 34, 20, ''),
(59, 389, 1, 15, 17, ''),
(60, 389, 1, 31, 20, ''),
(61, 389, 1, 11, 20, ''),
(62, 389, 1, 9, 20, ''),
(63, 389, 1, 29, 14, ''),
(64, 389, 1, 16, 19, ''),
(65, 389, 1, 25, 20, ''),
(66, 389, 1, 17, 20, ''),
(67, 389, 1, 12, 20, ''),
(68, 272, 1, NULL, NULL, ''),
(69, 272, 1, 35, 20, ''),
(70, 272, 1, 36, 20, ''),
(71, 290, 1, NULL, NULL, ''),
(72, 290, 1, 29, 20, ''),
(73, 290, 1, 17, 20, ''),
(74, 290, 1, 11, 20, ''),
(75, 291, 1, NULL, NULL, ''),
(76, 291, 1, 29, 20, ''),
(77, 291, 1, 25, 20, ''),
(78, 291, 1, 11, 20, ''),
(79, 291, 1, 17, 20, ''),
(80, 290, 1, 25, 20, ''),
(82, 293, 1, 29, 20, ''),
(83, 293, 1, 25, 20, ''),
(84, 293, 1, 11, 20, ''),
(85, 293, 1, 17, 20, ''),
(87, 251, 1, NULL, NULL, ''),
(88, 251, 1, 10, 19, ''),
(89, 251, 1, 19, 20, ''),
(90, 98, 1, NULL, NULL, ''),
(91, 98, 1, 39, 20, ''),
(92, 98, 1, 37, 20, ''),
(93, 98, 1, 38, 20, ''),
(94, 98, 1, 40, 20, ''),
(95, 126, 1, NULL, NULL, ''),
(96, 126, 1, 9, 20, ''),
(97, 126, 1, 11, 20, ''),
(98, 126, 1, 22, 20, ''),
(99, 126, 1, 31, 20, ''),
(100, 126, 1, 17, 20, ''),
(107, 151, 1, NULL, NULL, ''),
(108, 151, 1, 10, 20, ''),
(109, 151, 1, 19, 20, ''),
(110, 153, 1, NULL, NULL, ''),
(111, 153, 1, 10, 20, ''),
(112, 153, 1, 19, 20, ''),
(114, 154, 1, 10, 20, ''),
(115, 154, 1, 19, 20, ''),
(116, 131, 1, NULL, NULL, ''),
(117, 131, 1, 20, 20, ''),
(118, 131, 1, 18, 20, ''),
(119, 131, 1, 22, 20, ''),
(120, 131, 1, 28, 20, ''),
(121, 131, 1, 9, 20, ''),
(122, 137, 1, NULL, NULL, ''),
(123, 137, 1, 18, 20, ''),
(124, 137, 1, 20, 20, ''),
(125, 137, 1, 22, 20, ''),
(126, 137, 1, 11, 20, ''),
(127, 137, 1, 9, 20, ''),
(128, 159, 1, NULL, NULL, ''),
(129, 159, 1, 17, 20, ''),
(130, 159, 1, 11, 20, ''),
(131, 159, 1, 22, 20, ''),
(132, 159, 1, 31, 20, ''),
(133, 159, 1, 9, 20, ''),
(134, 165, 1, NULL, NULL, ''),
(135, 165, 1, 17, 20, ''),
(136, 165, 1, 11, 20, ''),
(137, 165, 1, 9, 20, ''),
(138, 165, 1, 31, 20, ''),
(139, 165, 1, 22, 20, ''),
(140, 86, 1, NULL, NULL, ''),
(141, 86, 1, 22, 20, ''),
(142, 86, 1, 9, 20, ''),
(143, 86, 1, 18, 20, ''),
(144, 86, 1, 11, 20, ''),
(145, 86, 1, 17, 20, ''),
(146, 86, 1, 31, 20, ''),
(147, 150, 1, NULL, NULL, ''),
(148, 150, 1, 10, 20, ''),
(149, 150, 1, 19, 20, ''),
(150, 149, 1, NULL, NULL, ''),
(151, 149, 1, 10, 20, ''),
(152, 149, 1, 19, 20, ''),
(153, 147, 1, NULL, NULL, ''),
(154, 147, 1, 10, 20, ''),
(155, 147, 1, 19, 20, ''),
(156, 252, 1, NULL, NULL, ''),
(157, 252, 1, 15, 20, ''),
(158, 252, 1, 9, 20, ''),
(159, 252, 1, 31, 20, ''),
(161, 354, 2, 7, 9, '10.00'),
(162, 354, 2, 5, 9, '0'),
(163, 354, 2, 6, 9, '0'),
(167, 354, 2, 8, 9, '16.00'),
(169, 354, 3, 13, 8, '0'),
(171, 354, 3, 14, 10, '10.00'),
(172, 385, 1, NULL, NULL, ''),
(173, 385, 1, 15, 9, '0'),
(174, 385, 1, 29, 10, '1.00'),
(175, 385, 3, NULL, NULL, ''),
(176, 385, 3, 13, 9, ''),
(177, 385, 3, 14, 10, ''),
(178, 43, 1, 29, 1, '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `retirada`
--

CREATE TABLE IF NOT EXISTS `retirada` (
  `retirada_id` int(11) NOT NULL,
  `retirada_local` varchar(200) DEFAULT NULL,
  `retirada_horario` varchar(200) DEFAULT NULL,
  `retirada_rua` varchar(200) DEFAULT NULL,
  `retirada_num` varchar(20) DEFAULT NULL,
  `retirada_complemento` varchar(200) DEFAULT NULL,
  `retirada_bairro` varchar(200) DEFAULT NULL,
  `retirada_cidade` varchar(200) DEFAULT NULL,
  `retirada_uf` varchar(10) DEFAULT NULL,
  `retirada_cep` varchar(20) DEFAULT NULL,
  `retirada_telefone` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `retirada`
--

INSERT INTO `retirada` (`retirada_id`, `retirada_local`, `retirada_horario`, `retirada_rua`, `retirada_num`, `retirada_complemento`, `retirada_bairro`, `retirada_cidade`, `retirada_uf`, `retirada_cep`, `retirada_telefone`) VALUES
(1, 'Loja Boqueirão', 'Seg. a Sex. das 08: as 18:00', 'Avenida Brasil', '500', 'Piso 2', 'Boqueirão', 'Praia Grande', 'SP', '11701-090', '(13) 5555-4444 | (13) 3333-4444'),
(3, 'Loja Suzano', 'Seg. a Sex. das 08: as 18:00', 'Rua Biotônico', '700', 'Térreo', 'Vila Urupês', 'Suzano', 'SP', '08615-000', '(11) 4747-6565 | (11) 4747-8888');

-- --------------------------------------------------------

--
-- Estrutura da tabela `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `slide_id` int(11) NOT NULL,
  `slide_url` varchar(100) DEFAULT '0',
  `slide_link` varchar(500) DEFAULT NULL,
  `slide_title` varchar(50) DEFAULT NULL,
  `slide_desc` varchar(200) DEFAULT NULL,
  `slide_local` int(11) DEFAULT '1' COMMENT '1= slideshow\r\n2= footer\r\n3= side',
  `slide_target` int(1) DEFAULT '0',
  `slide_pos` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `slide`
--

INSERT INTO `slide` (`slide_id`, `slide_url`, `slide_link`, `slide_title`, `slide_desc`, `slide_local`, `slide_target`, `slide_pos`) VALUES
(46, '5b4eef9363022d0818e893a6cf96c9bf.png', '0', '', '', 2, 0, 1),
(50, '77d3153d4c0818139214371cb93dac2f.jpg', '0', '', '', 4, 0, 2),
(51, 'c9386c8738282faac62de46cfc70bf87.jpg', '0', '', '', 4, 0, 1),
(52, 'de02ba603397d92e4e187928d35356cd.jpg', '0', '', '', 4, 0, 3),
(53, 'ade1e0761e9d9dba5202ee97bd38c823.png', '0', '', '', 5, 0, 0),
(56, '512cd36368b0f91f2dfb676c7ebc3398.png', '0', '', '', 1, 0, 1),
(58, '028fff863c4906216604dcc40c631202.png', '0', '', '', 1, 0, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `smtp`
--

CREATE TABLE IF NOT EXISTS `smtp` (
  `smtp_id` int(11) NOT NULL,
  `smtp_host` varchar(200) DEFAULT NULL,
  `smtp_username` varchar(100) DEFAULT NULL,
  `smtp_password` varchar(100) DEFAULT NULL,
  `smtp_fromname` varchar(200) DEFAULT NULL,
  `smtp_bcc` varchar(100) DEFAULT NULL,
  `smtp_replyto` varchar(100) DEFAULT NULL,
  `smtp_port` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `smtp`
--

INSERT INTO `smtp` (`smtp_id`, `smtp_host`, `smtp_username`, `smtp_password`, `smtp_fromname`, `smtp_bcc`, `smtp_replyto`, `smtp_port`) VALUES
(1, 'mail.seusite.com.br', 'abuse@seusite.com.br', '000000', 'FluxShop', 'copiapara@gmail.com', 'NULL', 587);

-- --------------------------------------------------------

--
-- Estrutura da tabela `social`
--

CREATE TABLE IF NOT EXISTS `social` (
  `social_id` int(11) NOT NULL,
  `social_fb` text,
  `social_tw` text,
  `social_in` text,
  `social_gp` text,
  `social_f4` text,
  `social_yt` text,
  `social_face` text
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `social`
--

INSERT INTO `social` (`social_id`, `social_fb`, `social_tw`, `social_in`, `social_gp`, `social_f4`, `social_yt`, `social_face`) VALUES
(1, 'https://www.facebook.com/clares.lab', 'http://twitter.com/', '#correndonapraia', '', '', 'http://youtube.com/', 'http://facebook.com.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sub`
--

CREATE TABLE IF NOT EXISTS `sub` (
  `sub_id` int(11) NOT NULL,
  `sub_title` varchar(200) DEFAULT NULL,
  `sub_url` varchar(200) DEFAULT NULL,
  `sub_pos` int(11) DEFAULT '0',
  `sub_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sub`
--

INSERT INTO `sub` (`sub_id`, `sub_title`, `sub_url`, `sub_pos`, `sub_categoria`) VALUES
(1, 'Smartphones', 'smartphones', 1, 1),
(2, 'Roda Aro 30', 'roda-aro-30', 0, 6),
(5, 'DVD', 'dvd', 0, 6),
(6, 'Tunning', 'tunning', 0, 6),
(7, 'Vasos', 'vasos', 0, 4),
(8, 'Cadeiras', 'cadeiras', 0, 5),
(9, 'Notebooks', 'notebooks', 0, 8),
(10, 'Tablets', 'tablets', 0, 8),
(12, 'LED LCD', 'led-lcd', 0, 9),
(13, 'Acessórios de cozinha', 'acessorios-de-cozinha', 0, 3),
(14, 'Lavadoras de Roupas', 'lavadoras-de-roupas', 0, 10),
(15, 'Regata', 'regata', 0, 11),
(16, 'Brinquedos', 'brinquedos', 0, 12),
(17, 'Carrinho de Bebê', 'carrinho-de-bebe', 0, 12),
(18, 'Berços', 'bercos', 0, 12),
(19, 'Alimentação', 'alimentacao', 0, 12),
(20, 'Higiene', 'higiene', 0, 12),
(21, 'Segurança', 'seguranca', 0, 12),
(22, 'Vestidos', 'vestidos', 0, 11),
(23, 'Bodies', 'bodies', 0, 11),
(24, 'Refrigeradores', 'refrigeradores', 0, 10),
(25, 'Depuradores de Ar', 'depuradores-de-ar', 0, 10),
(26, 'Cooktops', 'cooktops', 0, 10),
(27, 'Secadores', 'secadores', 0, 13),
(28, 'Barbeadores', 'barbeadores', 0, 13),
(29, 'Balanças', 'balancas', 0, 13),
(30, 'Telefone sem fio', 'telefone-sem-fio', 0, 1),
(31, 'Celulares Desbloqueados', 'celulares-desbloqueados', 0, 1),
(32, 'Aspiradores de Pó', 'aspiradores-de-po', 0, 3),
(33, 'Bebedouros', 'bebedouros', 0, 3),
(34, 'Aparadores de Grama', 'aparadores-de-grama', 0, 4),
(35, 'Churrasqueiras', 'churrasqueiras', 0, 4),
(36, 'Smart TV', 'smart-tv', 0, 9),
(37, 'Tv Plasma', 'tv-plasma', 0, 9),
(38, 'TV 3D', 'tv-3d', 0, 9),
(39, 'Multifuncionais', 'multifuncionais', 0, 8),
(40, 'Ultrabooks', 'ultrabooks', 0, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL,
  `user_login` varchar(20) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `user_level` int(11) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`user_id`, `user_login`, `user_password`, `user_email`, `user_name`, `user_level`) VALUES
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'user@seusite.com.br', 'admin', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `versao`
--

CREATE TABLE IF NOT EXISTS `versao` (
  `versao_num` int(5) DEFAULT NULL,
  `versao_data` varchar(20) DEFAULT NULL,
  `versao_update` varchar(20) DEFAULT NULL,
  `id` int(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `versao`
--

INSERT INTO `versao` (`versao_num`, `versao_data`, `versao_update`, `id`) VALUES
(300, '04-12-2019', '3.0', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `atributo`
--
ALTER TABLE `atributo`
  ADD PRIMARY KEY (`atributo_id`);

--
-- Indexes for table `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`avaliacao_id`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`config_id`);

--
-- Indexes for table `cupom`
--
ALTER TABLE `cupom`
  ADD PRIMARY KEY (`cupom_id`),
  ADD KEY `fk_cupom_lote` (`cupom_lote`);

--
-- Indexes for table `depoimento`
--
ALTER TABLE `depoimento`
  ADD PRIMARY KEY (`depoimento_id`);

--
-- Indexes for table `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`endereco_id`),
  ADD KEY `fk_end_cliente` (`endereco_cliente`);

--
-- Indexes for table `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`entrega_id`);

--
-- Indexes for table `faixacep`
--
ALTER TABLE `faixacep`
  ADD PRIMARY KEY (`faixacep_id`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`foto_id`),
  ADD KEY `fk_foto_item` (`foto_item`);

--
-- Indexes for table `iattr`
--
ALTER TABLE `iattr`
  ADD PRIMARY KEY (`iattr_id`),
  ADD KEY `fk_attr_atrib` (`iattr_atributo`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_item_sub` (`item_sub`);

--
-- Indexes for table `lista`
--
ALTER TABLE `lista`
  ADD PRIMARY KEY (`lista_id`),
  ADD KEY `fk_list_ped` (`lista_pedido`);

--
-- Indexes for table `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`lote_id`);

--
-- Indexes for table `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`marca_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `fk_page_area` (`page_area`);

--
-- Indexes for table `pay`
--
ALTER TABLE `pay`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `fk_ped_cli` (`pedido_cliente`);

--
-- Indexes for table `relacionado`
--
ALTER TABLE `relacionado`
  ADD PRIMARY KEY (`relacionadoid`);

--
-- Indexes for table `relatrr`
--
ALTER TABLE `relatrr`
  ADD PRIMARY KEY (`relatrr_id`),
  ADD KEY `fk_rel_attr` (`relatrr_atributo`),
  ADD KEY `fk_attr_item` (`relatrr_item`);

--
-- Indexes for table `retirada`
--
ALTER TABLE `retirada`
  ADD PRIMARY KEY (`retirada_id`);

--
-- Indexes for table `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`slide_id`);

--
-- Indexes for table `smtp`
--
ALTER TABLE `smtp`
  ADD PRIMARY KEY (`smtp_id`);

--
-- Indexes for table `social`
--
ALTER TABLE `social`
  ADD PRIMARY KEY (`social_id`);

--
-- Indexes for table `sub`
--
ALTER TABLE `sub`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `fk_sub_categoria` (`sub_categoria`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `versao`
--
ALTER TABLE `versao`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `atributo`
--
ALTER TABLE `atributo`
  MODIFY `atributo_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `avaliacao_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cupom`
--
ALTER TABLE `cupom`
  MODIFY `cupom_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `depoimento`
--
ALTER TABLE `depoimento`
  MODIFY `depoimento_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `endereco`
--
ALTER TABLE `endereco`
  MODIFY `endereco_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `entrega`
--
ALTER TABLE `entrega`
  MODIFY `entrega_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faixacep`
--
ALTER TABLE `faixacep`
  MODIFY `faixacep_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `foto_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `iattr`
--
ALTER TABLE `iattr`
  MODIFY `iattr_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `lista`
--
ALTER TABLE `lista`
  MODIFY `lista_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT for table `lote`
--
ALTER TABLE `lote`
  MODIFY `lote_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `marca_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `relacionado`
--
ALTER TABLE `relacionado`
  MODIFY `relacionadoid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `relatrr`
--
ALTER TABLE `relatrr`
  MODIFY `relatrr_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=179;
--
-- AUTO_INCREMENT for table `retirada`
--
ALTER TABLE `retirada`
  MODIFY `retirada_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `slide`
--
ALTER TABLE `slide`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `smtp`
--
ALTER TABLE `smtp`
  MODIFY `smtp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `social`
--
ALTER TABLE `social`
  MODIFY `social_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sub`
--
ALTER TABLE `sub`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `versao`
--
ALTER TABLE `versao`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `fk_item_sub` FOREIGN KEY (`item_sub`) REFERENCES `sub` (`sub_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
