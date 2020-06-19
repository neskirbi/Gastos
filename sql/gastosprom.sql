-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-06-2020 a las 14:56:32
-- Versión del servidor: 5.7.27
-- Versión de PHP: 5.6.31

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `gastosprom`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE IF NOT EXISTS `banco` (
  `id` int(11) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `clavebanco` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `banco`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE IF NOT EXISTS `bitacora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `fecha` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `bitacora`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category_expence`
--

CREATE TABLE IF NOT EXISTS `category_expence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `t_gasto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `category_expence`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category_income`
--

CREATE TABLE IF NOT EXISTS `category_income` (
  `id` int(2) NOT NULL,
  `name` varchar(300) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `category_income`
--

INSERT INTO `category_income` (`id`, `name`) VALUES
(1, 'HONORARIOS PERSONAS FISICAS'),
(2, 'HONORARIOS PERSONAS MORALES'),
(3, 'ARRENDAMIENTO PERSONAS FISICAS'),
(4, 'ARRENDAMIENTO PERSONAS MORALES'),
(5, 'MUEBLES Y ENSERES MENORES (MENORES A $2,000.00)'),
(6, 'HOSPEDAJE'),
(7, 'ALIMENTOS'),
(8, 'TRANSPORTE'),
(9, 'BOLETOS DE AUTOBUS'),
(10, 'BOLETOS DE AVION'),
(11, 'CARGOS POR SERVICIO'),
(12, 'CASETAS'),
(13, 'PROPINAS'),
(14, 'DERECHOS'),
(15, 'TENENCIA'),
(16, 'MANTENIMIENTO BODEGAS'),
(17, 'MANTENIMIENTO EQUIPO DE TRANSPORTE'),
(18, 'MANTENIMIENTO OFICINA'),
(19, 'MANTENIMIENTO EQUIPO DE COMPUTO'),
(20, 'PAPELERIA Y ARTICULOS DE OFICINA'),
(21, 'DESPENSA Y ARTICULOS DE LIMPIEZA'),
(22, 'RECLUTAMIENTO Y SELECCION DE PERSONAL'),
(23, 'SEGURIDAD Y VIGILANCIA'),
(24, 'GASTOS VARIOS'),
(25, 'COMBUSTIBLES Y LUBRICANTES'),
(26, 'TELEFONOS'),
(27, 'INTERNET'),
(28, 'ENERGIA ELECTRICA'),
(29, 'PRODUCTO PARA DEGUSTACION'),
(30, 'FLETES'),
(31, 'SERVICIO DE AGUA'),
(32, 'PAQUETERIA MENSAJERIA Y ENVIOS'),
(33, 'ESTACIONAMIENTO'),
(34, 'ASESORIA'),
(35, 'UNIFORMES Y EQUIPOS AL PERSONAL'),
(36, 'SOFTWARE Y PROGRAMACION'),
(37, 'PROPAGANDA Y PUBLICIDAD'),
(38, 'SUPERVISION Y MONITOREO DE PERSONAL'),
(39, 'PAGO DE DEDUCIBLE (SEGUROS'),
(40, 'EVENTOS ESPECIALES'),
(41, 'DONATIVOS'),
(42, 'ARRENDAMIENTO FINANCIERO'),
(43, 'RENTA DE EQUIPO'),
(44, 'SEGUROS Y FIANZAS'),
(45, 'NO DEDUCIBLES'),
(46, 'COMPRA ACTIVOS'),
(47, 'DEVOLUCION A LA CUENTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cheques`
--

CREATE TABLE IF NOT EXISTS `cheques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_cheque` int(11) NOT NULL,
  `programa` int(2) NOT NULL,
  `monto` float NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `fecha_confirm` varchar(10) NOT NULL,
  `solicitante` int(11) NOT NULL,
  `beneficiario` int(11) NOT NULL,
  `bennombre` varchar(150) NOT NULL,
  `concepto` varchar(500) NOT NULL,
  `t_cheque` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `clasificacion` int(11) NOT NULL,
  `a_iva` float NOT NULL,
  `pago` int(11) DEFAULT '0',
  `fecha_pago` date DEFAULT NULL,
  `periodo` int(11) NOT NULL,
  `semana` varchar(50) NOT NULL,
  `tipopago` int(11) NOT NULL,
  `cuenta` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1790 ;

--
-- Volcar la base de datos para la tabla `cheques`
--

INSERT INTO `cheques` (`id`, `no_cheque`, `programa`, `monto`, `fecha`, `fecha_confirm`, `solicitante`, `beneficiario`, `bennombre`, `concepto`, `t_cheque`, `status`, `clasificacion`, `a_iva`, `pago`, `fecha_pago`, `periodo`, `semana`, `tipopago`, `cuenta`) VALUES
(1, 45487, 1, 2000, '2018-03-06', '2018-03-06', 5, 15, '0', 'ASIGNACION FONDO FIJO CDMX', 2, 2, 15, 0, 0, NULL, 1, 'Semana 2', 1, '6907867767678'),
(1758, 0, 1, 0, '2019-12-23', '2019-12-23', 6, 6, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '', 0, ''),
(1759, 0, 2, 17113.5, '2019-12-24', '2019-12-24', 5, 7, '0', 'Reembolso de gastos', 3, 1, 22, 0, 0, NULL, 0, '', 2, '32453545645657'),
(1760, 0, 1, 0, '2019-12-26', '2019-12-26', 5, 5, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '', 0, ''),
(1761, 0, 1, 0, '2019-12-26', '2019-12-26', 5, 5, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '', 0, ''),
(1762, 0, 2, 0, '2019-12-26', '2019-12-26', 5, 8, '0', 'Reembolso de gastos', 3, 1, 22, 0, 0, NULL, 0, '', 0, ''),
(1763, 0, 1, 0, '2019-12-26', '2019-12-26', 5, 5, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '', 0, ''),
(1764, 0, 1, 0, '2019-12-26', '2019-12-26', 5, 5, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '', 0, ''),
(1765, 0, 1, 0, '2019-12-26', '2019-12-26', 5, 5, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '', 0, ''),
(1766, 0, 1, 0, '2019-12-26', '2019-12-26', 5, 5, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '', 0, ''),
(1767, 0, 1, 0, '2019-12-26', '2019-12-26', 5, 5, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '', 0, ''),
(1768, 0, 1, 0, '2019-12-26', '2019-12-26', 5, 5, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '', 0, ''),
(1769, 0, 1, 0, '2019-12-26', '2019-12-26', 5, 5, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '', 0, ''),
(1770, 6666, 2, 10270.8, '2020-01-22', '2020-01-25', 5, 5, 'Rigoberto Camacho Vanegas', 'Compra de Laptop', 2, 2, 16, 0, 0, NULL, 0, '', 0, ''),
(1771, 66776, 1, 5500, '2020-01-22', '2020-01-25', 5, 5, 'Rigoberto Camacho Vanegas', 'Compra de Computadoras', 2, 2, 13, 0, 0, NULL, 1, 'Enero', 2, '6081865263'),
(1772, 76898, 2, 10899, '2020-01-25', '2020-01-25', 5, 8, '0', 'Compra de Equipo', 2, 2, 19, 0, 0, NULL, 2, 'Febrero', 2, '8899789798789'),
(1773, 0, 2, 0, '2020-01-25', '2020-01-25', 8, 8, '0', 'Reembolso de gastos', 3, 1, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1774, 0, 2, 0, '2020-01-25', '2020-01-25', 8, 8, '0', 'Reembolso de gastos', 3, 1, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1775, 0, 2, 0, '2020-01-26', '2020-01-26', 8, 8, '0', 'Pago Directo', 3, 1, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1776, 0, 2, 0, '2020-01-26', '2020-01-26', 8, 8, '0', 'Pago Directo', 1, 1, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1777, 0, 2, 0, '2020-01-26', '2020-01-26', 8, 8, '0', 'Pago Directo', 1, 1, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1778, 0, 2, 0, '2020-01-26', '2020-01-26', 8, 8, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1779, 0, 2, 0, '2020-01-26', '2020-01-26', 8, 8, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1780, 0, 2, 0, '2020-01-26', '2020-01-26', 8, 8, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1781, 0, 2, 0, '2020-01-26', '2020-01-26', 8, 8, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1782, 0, 2, 0, '2020-01-26', '2020-01-26', 8, 8, '0', 'Pago Directo', 1, 1, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1783, 0, 2, 0, '2020-01-26', '2020-01-26', 8, 8, '0', 'Reembolso de gastos', 3, 1, 22, 0, 0, NULL, 0, '0', 0, ''),
(1784, 0, 1, 0, '2020-01-28', '2020-01-28', 47, 47, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '0', 0, ''),
(1785, 0, 1, 0, '2020-01-28', '2020-01-28', 47, 47, '0', 'Pago Directo', 1, 1, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1786, 0, 2, 0, '2020-01-28', '2020-01-28', 9, 9, '0', 'Pago Directo', 1, 1, 22, 0, 0, NULL, 0, '0', 0, '0'),
(1787, 0, 2, 129989, '2020-01-28', '2020-01-28', 5, 5, 'Autocenter', 'Mantenimiento', 2, 1, 19, 0, 0, NULL, 2, '2', 2, ''),
(1788, 0, 2, 0, '2020-01-28', '2020-01-28', 8, 8, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, '2020-06-17', 0, '0', 0, ''),
(1789, 0, 2, 0, '2020-06-17', '2020-06-17', 4, 4, '0', 'Reembolso de gastos', 3, 0, 22, 0, 0, NULL, 0, '0', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion`
--

CREATE TABLE IF NOT EXISTS `clasificacion` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `clasificacion`
--

INSERT INTO `clasificacion` (`id`, `name`) VALUES
(1, 'AGUA'),
(2, 'ALARMAS'),
(3, 'ANUNCIOS'),
(4, 'CAJA CHICA'),
(5, 'COPIAS'),
(6, 'FLETES'),
(7, 'FONDO FIJO'),
(8, 'FONDO REVOLVENTE'),
(9, 'FUMIGACION'),
(10, 'GASOLINAS'),
(11, 'HONORARIOS'),
(12, 'LUZ'),
(13, 'MANTENIMIENTO'),
(14, 'NOTAS DE VENTA'),
(15, 'OTROS'),
(16, 'PAPELERIA'),
(17, 'PASAJES'),
(18, 'PURIFICADOR'),
(19, 'RENTA'),
(20, 'TAXIS'),
(21, 'TELEFONOS'),
(22, 'VIATICOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `val` text,
  `cfg_id` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `configuration`
--

INSERT INTO `configuration` (`id`, `label`, `name`, `val`, `cfg_id`) VALUES
(1, 'Empresa', 'website', 'Gastos', 1),
(2, 'Moneda', 'coin', '$', 1),
(3, 'E-mail', 'email', 'info@obedalvarado.pw', 1),
(4, 'Logotipo', 'logo', '1520292438_promo_logo.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cortes`
--

CREATE TABLE IF NOT EXISTS `cortes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monto` float NOT NULL,
  `iva` float NOT NULL,
  `no_apro` float NOT NULL,
  `deducible` float NOT NULL,
  `no_deducible` float NOT NULL,
  `total` float NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `programa` int(11) NOT NULL,
  `fecha_corte` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `cortes`
--

INSERT INTO `cortes` (`id`, `monto`, `iva`, `no_apro`, `deducible`, `no_deducible`, `total`, `fecha`, `programa`, `fecha_corte`) VALUES
(1, 15461.7, 2403.77, 0, 17865.5, 140, 18005.5, 'Junio', 1, '2018-06-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desglose`
--

CREATE TABLE IF NOT EXISTS `desglose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(1000) NOT NULL,
  `amount` float NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `id_cheque` int(11) NOT NULL,
  `comprobante` varchar(300) NOT NULL DEFAULT '',
  `deducible` tinyint(1) NOT NULL,
  `iva` float NOT NULL,
  `quien_sup` int(11) NOT NULL DEFAULT '0',
  `com_sup` varchar(300) NOT NULL DEFAULT '',
  `ok_sup` tinyint(1) NOT NULL DEFAULT '0',
  `quien_cli` int(11) NOT NULL DEFAULT '0',
  `com_cli` varchar(300) NOT NULL DEFAULT '',
  `ok_cli` tinyint(1) NOT NULL DEFAULT '0',
  `quien_val` int(11) NOT NULL DEFAULT '0',
  `com_val` varchar(300) NOT NULL DEFAULT '',
  `o_impuestos` float NOT NULL DEFAULT '0',
  `ret_iva` float NOT NULL DEFAULT '0',
  `facturacion` int(11) NOT NULL DEFAULT '0',
  `ok_val` tinyint(1) NOT NULL DEFAULT '0',
  `si_aid` tinyint(4) DEFAULT '0',
  `fecha_ok_sup` varchar(15) NOT NULL DEFAULT '0',
  `fecha_ok_cli` varchar(15) NOT NULL DEFAULT '0',
  `date_fac` varchar(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5771 ;

--
-- Volcar la base de datos para la tabla `desglose`
--

INSERT INTO `desglose` (`id`, `description`, `amount`, `user_id`, `category_id`, `created_at`, `id_cheque`, `comprobante`, `deducible`, `iva`, `quien_sup`, `com_sup`, `ok_sup`, `quien_cli`, `com_cli`, `ok_cli`, `quien_val`, `com_val`, `o_impuestos`, `ret_iva`, `facturacion`, `ok_val`, `si_aid`, `fecha_ok_sup`, `fecha_ok_cli`, `date_fac`) VALUES
(1, 'viaticos', 2000, 5, 10, '2018-03-09', 10, '91c7229d-cbc9-4b4d-a2ca-dbb6eea95ecf1.pdf', 1, 320, 0, '', 0, 0, '', 0, 0, '', 0, 0, 0, 0, 0, '', '', '0'),
(5769, 'Renta Mensual Cuenta Maestra', 14957.5, 5, 27, '2019-12-06', 1759, '', 0, 0, 0, '', 0, 0, '', 0, 0, '', 0, 0, 0, 0, 0, '0', '0', '2019-12-06'),
(5770, 'Pago de agua', 2156, 5, 31, '2019-12-05', 1759, '', 0, 0, 0, '', 0, 0, '', 0, 0, '', 0, 0, 0, 0, 0, '0', '0', '2019-12-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `estado`) VALUES
(1, 'Aguascalientes'),
(2, 'Baja California'),
(3, 'Baja California Sur'),
(4, 'Campeche'),
(5, 'Coahuila de Zaragoza'),
(6, 'Colima'),
(7, 'Chiapas'),
(8, 'Chihuahua'),
(9, 'CDMX'),
(10, 'Durango'),
(11, 'Guanajuato'),
(12, 'Guerrero'),
(13, 'Hidalgo'),
(14, 'Jalisco'),
(15, 'Estado de México'),
(16, 'Michoacán de Ocampo'),
(17, 'Morelos'),
(18, 'Nayarit'),
(19, 'Nuevo León'),
(20, 'Oaxaca'),
(21, 'Puebla'),
(22, 'Querétaro'),
(23, 'Quintana Roo'),
(24, 'San Luis Potosí'),
(25, 'Sinaloa'),
(26, 'Sonora'),
(27, 'Tabasco'),
(28, 'Tamaulipas'),
(29, 'Tlaxcala'),
(30, 'Veracruz'),
(31, 'Yucatán'),
(32, 'Zacatecas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE IF NOT EXISTS `gastos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cheque` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_comp` date NOT NULL,
  `status` int(11) NOT NULL,
  `t_gasto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_cheque` (`id_cheque`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1787 ;

--
-- Volcar la base de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id`, `id_cheque`, `fecha`, `fecha_comp`, `status`, `t_gasto`) VALUES
(1, 1, '2018-03-06', '0000-00-00', 1, 0),
(1761, 1758, '2019-12-23', '0000-00-00', 1, 0),
(1762, 1759, '2019-12-24', '0000-00-00', 1, 0),
(1763, 1760, '2019-12-26', '0000-00-00', 1, 0),
(1764, 1761, '2019-12-26', '0000-00-00', 1, 0),
(1765, 1762, '2019-12-26', '0000-00-00', 1, 0),
(1766, 1763, '2019-12-26', '0000-00-00', 1, 0),
(1767, 1764, '2019-12-26', '0000-00-00', 1, 0),
(1768, 1765, '2019-12-26', '0000-00-00', 1, 0),
(1769, 1766, '2019-12-26', '0000-00-00', 1, 0),
(1770, 1767, '2019-12-26', '0000-00-00', 1, 0),
(1771, 1768, '2019-12-26', '0000-00-00', 1, 0),
(1772, 1769, '2019-12-26', '0000-00-00', 1, 0),
(1773, 1772, '2020-01-25', '0000-00-00', 1, 0),
(1774, 1773, '2020-01-25', '0000-00-00', 1, 0),
(1775, 1774, '2020-01-25', '0000-00-00', 1, 0),
(1776, 1771, '2020-01-25', '0000-00-00', 1, 0),
(1777, 1770, '2020-01-25', '0000-00-00', 1, 0),
(1778, 1775, '2020-01-26', '0000-00-00', 1, 0),
(1779, 1777, '2020-01-26', '0000-00-00', 1, 0),
(1780, 1782, '2020-01-26', '0000-00-00', 1, 0),
(1781, 1783, '2020-01-26', '0000-00-00', 1, 0),
(1782, 1784, '2020-01-28', '0000-00-00', 1, 0),
(1783, 1785, '2020-01-28', '0000-00-00', 1, 0),
(1784, 1786, '2020-01-28', '0000-00-00', 1, 0),
(1785, 1788, '2020-01-28', '0000-00-00', 1, 0),
(1786, 1789, '2020-06-17', '0000-00-00', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE IF NOT EXISTS `notificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asunto` varchar(45) DEFAULT NULL,
  `remitente` int(11) DEFAULT NULL,
  `destina` int(11) DEFAULT NULL,
  `mensaje` varchar(1500) DEFAULT NULL,
  `fecha` varchar(19) DEFAULT NULL,
  `visto` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `asunto`, `remitente`, `destina`, `mensaje`, `fecha`, `visto`) VALUES
(1, 'Prueba de redaccion', 177, 177, '<p>Esta es una prueba de redaccion de notificaciones</p>\n\n<table border="1" cellpadding="1" cellspacing="1" style="width:500px">\n	<tbody>\n		<tr>\n			<td>&nbsp;</td>\n			<td>&nbsp;</td>\n		</tr>\n		<tr>\n			<td>&nbsp;</td>\n			<td>&nbsp;</td>\n		</tr>\n		<tr>\n			<td>&nbsp;</td>\n			<td>&nbsp;</td>\n		</tr>\n	</tbody>\n</table>\n\n<p><img src="https://www.partesdel.com/wp-content/uploads/partes-de-una-grafica.png" /></p>\n\n<p>&nbsp;</p>\n', '2018-07-21 04:13:41', 0),
(2, 'Solicitud de cheque', 177, 177, '<p><img src="http://promotecnicas.mine.nu/gastos/images/cheque.jpg" style="width:400px" /></p>\n\n<table border="1" cellpadding="1" cellspacing="1" style="width:500px">\n	<tbody>\n		<tr>\n			<td>Asunto</td>\n			<td>Solicitud de cheque</td>\n		</tr>\n		<tr>\n			<td>Nombre</td>\n			<td>$nombre</td>\n		</tr>\n		<tr>\n			<td>Concepto</td>\n			<td>$concepto</td>\n		</tr>\n		<tr>\n			<td>Monto</td>\n			<td>$monto</td>\n		</tr>\n		<tr>\n			<td>Fecha</td>\n			<td>$fecha</td>\n		</tr>\n		<tr>\n			<td>Concepto</td>\n			<td>$concepto</td>\n		</tr>\n	</tbody>\n</table>\n', '2018-07-21 04:44:27', 0),
(3, 'Solicitud de cheque', 177, 177, '<p><img src="http://promotecnicas.mine.nu/gastos/images/cheque.jpg" style="width:400px" /></p>\n\n<table border="1" cellpadding="1" cellspacing="1" style="width:500px">\n	<tbody>\n		<tr>\n			<td>Asunto</td>\n			<td>Solicitud de cheque</td>\n		</tr>\n		<tr>\n			<td>Nombre</td>\n			<td>$nombre</td>\n		</tr>\n		<tr>\n			<td>Concepto</td>\n			<td>$concepto</td>\n		</tr>\n		<tr>\n			<td>Monto</td>\n			<td>$monto</td>\n		</tr>\n		<tr>\n			<td>Fecha</td>\n			<td>$fecha</td>\n		</tr>\n		<tr>\n			<td>Concepto</td>\n			<td>$concepto</td>\n		</tr>\n	</tbody>\n</table>\n', '2018-07-21 04:44:58', 0),
(4, 'Reembolso de gastos', 56, 56, 'Se ha solicitado el reembolso por parte de: raul martinez  por un monto de: 0', '2018-07-21 04:51:21', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `papelera_desglose`
--

CREATE TABLE IF NOT EXISTS `papelera_desglose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_desglose` int(11) DEFAULT NULL,
  `id_cheque` int(11) DEFAULT NULL,
  `fecha` varchar(11) DEFAULT NULL,
  `comentario` varchar(200) DEFAULT NULL,
  `restaurar` varchar(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `papelera_desglose`
--

INSERT INTO `papelera_desglose` (`id`, `id_desglose`, `id_cheque`, `fecha`, `comentario`, `restaurar`) VALUES
(1, 540, 350, '2018-07-12', 'es mucho', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE IF NOT EXISTS `programas` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `programas`
--

INSERT INTO `programas` (`id`, `name`) VALUES
(1, 'Administración'),
(2, 'MARS'),
(3, 'KUA'),
(4, 'JTI'),
(5, 'Alen Vd'),
(6, 'Alen RutaVerde'),
(7, 'Mercadeo'),
(8, 'CB&D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int(11) NOT NULL,
  `tipocuenta` varchar(20) NOT NULL,
  `cuenta` varchar(50) NOT NULL,
  `titular` varchar(200) NOT NULL,
  `clavebanco` varchar(10) NOT NULL,
  `plazabanco` varchar(10) NOT NULL,
  `tipo_cuenta` varchar(10) NOT NULL,
  `ap` varchar(100) NOT NULL,
  `am` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `fecha` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `proveedores`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE IF NOT EXISTS `puestos` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `puestos`
--

INSERT INTO `puestos` (`id`, `name`) VALUES
(1, 'Administrador'),
(2, 'Supervisro'),
(3, 'SD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_cheque`
--

CREATE TABLE IF NOT EXISTS `t_cheque` (
  `id` int(2) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `t_cheque`
--

INSERT INTO `t_cheque` (`id`, `name`) VALUES
(1, 'Pago directo'),
(2, 'Gastos a comprobar'),
(3, 'Reembolso de gastos'),
(4, 'No deducible'),
(5, 'Fondo Fijo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_pago`
--

CREATE TABLE IF NOT EXISTS `t_pago` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `t_pago`
--

INSERT INTO `t_pago` (`id`, `name`) VALUES
(1, 'Cheque'),
(2, 'Transferencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `t_user`
--

INSERT INTO `t_user` (`id`, `name`) VALUES
(1, 'Administracion'),
(2, 'SD'),
(3, 'Regional'),
(4, 'Operativo'),
(5, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `programa` int(11) NOT NULL,
  `profile_pic` varchar(60) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `tipo` int(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `ciudad` int(11) NOT NULL,
  `rutas` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=180 ;

--
-- Volcar la base de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `status`, `is_deleted`, `name`, `password`, `email`, `programa`, `profile_pic`, `is_admin`, `tipo`, `created_at`, `telefono`, `ciudad`, `rutas`) VALUES
(1, 1, 0, 'Sistemas Web', '123456', 'admin@admin.com', 1, 'iapp.png', 1, 0, '2018-01-02 11:09:20', '00000000', 0, ''),
(2, 1, 0, 'Tesoreria ', 'teso147', 'facturacion@promo-tecnicas.com', 1, 'iapp.png', 0, 1, '2018-01-29 10:53:33', '0000000', 9, '0'),
(3, 1, 0, 'Jose Luis Larracilla', 'ing147', 'jl@promo-tecnicas.com', 1, 'iapp.png', 1, 0, '2018-02-23 12:43:26', '00000000', 9, '0'),
(4, 1, 0, 'DDS Chalco', 'ddsc', 'chalco@promo.com', 2, 'iapp.png', 0, 5, '2018-01-30 17:00:06', '00000', 9, 'R1'),
(5, 1, 0, 'Operaciones', 'op', 'operaciones@promo-tecnicas.com', 2, 'iapp.png', 0, 4, '2018-01-22 11:00:58', '00000000', 9, 'R1,R2,R3'),
(6, 1, 0, 'DDS Chimalhuacan', 'ddsc', 'chimalhuaan@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 9, 'R1'),
(7, 1, 0, 'DDS Coacalco', 'ddsc', 'coacalco@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 9, 'R1'),
(8, 1, 0, 'DDS Nezahualcoyotl', 'ddsn', 'neza@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 9, 'R1'),
(9, 1, 0, 'CDT Guadalajara', 'cdtg', 'gdl@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 14, 'R1'),
(10, 1, 0, 'DDS Merida', 'ddsm', 'merida@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 31, 'R1'),
(11, 1, 0, 'CDT Monterrey', 'cdtm', 'mty@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 19, 'R1'),
(12, 1, 0, 'DDS Naucalpan', 'ddsn', 'naucalpan@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 9, 'R1'),
(13, 1, 0, 'DDS Puebla', 'ddsp', 'puebla@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 21, 'R1'),
(14, 1, 0, 'DDS Oaxaca', 'ddso', 'oaxaca@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 20, 'R1'),
(15, 1, 0, 'DDS San Luis Potosi', 'ddss', 'slp@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 24, 'R1'),
(16, 1, 0, 'DDS Tijuana', 'ddst', 'tijuana@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 1, 'R1'),
(17, 1, 0, 'DDS Tlalnepantla', 'ddst', 'tlane@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 9, 'R1'),
(18, 1, 0, 'DDS Toluca', 'ddst', 'toluca@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 15, 'R1'),
(20, 1, 0, 'DDS Tonala', 'ddst', 'tonala@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 14, 'R1'),
(21, 1, 0, 'DDS Torreon', 'ddst', 'torreon@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 5, 'R1'),
(23, 1, 0, 'DDS Tultitlan', 'ddst', 'tultitlan@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 9, 'R1'),
(24, 1, 0, 'DDS Veracruz', 'ddsv', 'veracruz@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 30, 'R1'),
(26, 1, 0, 'Autocenter', 'aut', 'auto@promo.com', 2, 'iapp.png', 0, 2, '2018-06-12 11:09:20', '00000', 9, 'R2'),
(47, 1, 0, 'MARS', 'Ir17', 'mars@mars.com', 1, 'iapp.png', 0, 5, '2018-01-02 11:09:20', '55748123', 1, 'R1,R2,R3,R4,R5,R6,R7,R8,R9,R10,R11,R12'),
(177, 1, 0, 'PruebasSD ', '123', 'pruebassd@pruebas.com', 5, 'iapp.png', 0, 2, '2018-07-18 11:36:28', '000', 9, 'R1'),
(178, 1, 0, 'Pruebasreg ', '123', 'pruebasreg@pruebas.com', 5, 'iapp.png', 0, 3, '2018-07-18 11:36:41', '000', 9, 'R1'),
(179, 1, 0, 'Pruebascli ', '123', 'pruebascli@pruebas.com', 5, 'iapp.png', 0, 5, '2018-07-18 11:36:57', '000', 9, 'R1');

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `category_expence`
--
ALTER TABLE `category_expence`
  ADD CONSTRAINT `category_expence_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `desglose`
--
ALTER TABLE `desglose`
  ADD CONSTRAINT `desglose_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `desglose_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category_income` (`id`);
