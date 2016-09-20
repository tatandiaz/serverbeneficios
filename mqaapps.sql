-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-05-2016 a las 16:11:57
-- Versión del servidor: 5.7.11-log
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mqaapps`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriacliente`
--

CREATE TABLE `categoriacliente` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `mesa` varchar(128) NOT NULL,
  `proceso` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriaestrategia`
--

CREATE TABLE `categoriaestrategia` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `mesa` varchar(200) NOT NULL,
  `proceso` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(11) NOT NULL,
  `talleres_id` bigint(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `color` varchar(7) NOT NULL,
  `dependencia` bigint(11) NOT NULL,
  `tiposcategoria_id` bigint(11) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `talleres_id`, `nombre`, `color`, `dependencia`, `tiposcategoria_id`, `orden`) VALUES
(0, 0, '', '', 0, 1, 0),
(1, 1, 'Nuevo', '#2980B9', 0, 3, 1),
(2, 1, 'Satisfactorio', '#5fbb46', 0, 1, 0),
(3, 1, 'A Mejorar', '#f4d03f', 0, 1, 2),
(4, 1, 'A Redisenar', '#e74c3c', 0, 1, 4),
(5, 1, 'Propuestas a Corto Plazo', '#f4d03f', 3, 2, 5),
(6, 1, 'Propuestas a Largo Plazo', '#E74C3C', 4, 2, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compromiso`
--

CREATE TABLE `compromiso` (
  `id` int(16) NOT NULL,
  `compromiso` varchar(2500) NOT NULL,
  `responsable` varchar(64) NOT NULL,
  `cargo` varchar(32) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creacliente`
--

CREATE TABLE `creacliente` (
  `id` int(128) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creaestrategia`
--

CREATE TABLE `creaestrategia` (
  `id` int(128) NOT NULL,
  `nombre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrevistas`
--

CREATE TABLE `entrevistas` (
  `id` int(16) NOT NULL,
  `entrevista` varchar(20000) NOT NULL,
  `entrevistado` varchar(64) NOT NULL,
  `entrevistador` varchar(64) NOT NULL,
  `mesa` varchar(64) NOT NULL,
  `fecha` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impacto`
--

CREATE TABLE `impacto` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `mesa` varchar(128) NOT NULL,
  `proceso` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `visiblesugerencias` tinyint(1) NOT NULL DEFAULT '0',
  `talleres_id` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `nombre`, `visiblesugerencias`, `talleres_id`) VALUES
(1, 'MM', 0, 1),
(2, 'CO', 0, 1),
(3, 'HCM', 0, 1),
(4, 'SD', 0, 1),
(5, 'FI', 0, 1),
(6, 'PM-CS', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridad`
--

CREATE TABLE `prioridad` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `mesa` varchar(128) NOT NULL,
  `proceso` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesos`
--

CREATE TABLE `procesos` (
  `id` bigint(11) NOT NULL,
  `proceso` text NOT NULL,
  `sugerencia` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mesas_id` bigint(11) NOT NULL,
  `categorias_id` bigint(11) NOT NULL,
  `talleres_id` bigint(11) NOT NULL,
  `responsables_id` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `procesos`
--

INSERT INTO `procesos` (`id`, `proceso`, `sugerencia`, `fecha`, `mesas_id`, `categorias_id`, `talleres_id`, `responsables_id`) VALUES
(1, 'Oferta de Aprovisionamiento', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(2, 'Gestión de Contratos', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(3, 'Compras Nacionales', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(4, 'Compras en Consignación', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(5, 'Compras en Leasing, Renting', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(6, 'Compras por importación', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(7, 'Compras para prestación de un servicio', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(8, 'Devolución de Mercancía a Proveedores', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(9, 'Fabricación de Productos', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(10, 'Planificación de necesidades de compra', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(11, 'Evaluación de Proveedores', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(12, 'Traslados entre centros', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(13, 'Estrategías de Liberación', ' ', '2016-05-10 09:03:59', 1, 0, 1, 0),
(14, 'Planificación de ventas parques funerarios', ' ', '2016-05-10 09:04:14', 2, 0, 1, 0),
(15, 'Anulación parques funerarios', ' ', '2016-05-10 09:04:14', 2, 0, 1, 0),
(16, 'Costos parques funerarios', ' ', '2016-05-10 09:04:14', 2, 0, 1, 0),
(17, 'Gastos parques funerarios', ' ', '2016-05-10 09:04:14', 2, 0, 1, 0),
(18, 'Provisión futuro parques y funerarias', ' ', '2016-05-10 09:04:14', 2, 0, 1, 0),
(19, 'Traslado de gastos parques y funerarias', ' ', '2016-05-10 09:04:14', 2, 0, 1, 0),
(20, 'Planificación Ventas Recordar', ' ', '2016-05-10 09:04:14', 2, 0, 1, 0),
(21, 'Planificación Costos Recordar', ' ', '2016-05-10 09:04:14', 2, 0, 1, 0),
(22, 'Planificación Gastos Recordar', ' ', '2016-05-10 09:04:14', 2, 0, 1, 0),
(23, 'OM-Estructura Organizacional', ' ', '2016-05-10 09:04:30', 3, 0, 1, 0),
(24, 'PT- Gestión de tiempos', ' ', '2016-05-10 09:04:30', 3, 0, 1, 0),
(25, 'PA-Administración de Personal', ' ', '2016-05-10 09:04:30', 3, 0, 1, 0),
(26, 'PY-Nomina', ' ', '2016-05-10 09:04:30', 3, 0, 1, 0),
(27, 'PE-Gestión de Eventos', ' ', '2016-05-10 09:04:30', 3, 0, 1, 0),
(28, 'PD-Desarrollo de Personal', ' ', '2016-05-10 09:04:30', 3, 0, 1, 0),
(29, 'HSE-Salud Ocupacional', ' ', '2016-05-10 09:04:30', 3, 0, 1, 0),
(30, 'Business Parther', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(31, 'Gestión de Relaciones', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(32, 'Maestro de Materiales', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(33, 'Maestro de Condiciones', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(34, 'Gestión de Precios, descuentos, Recargos e impuestos', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(35, 'Integración CO-PA', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(36, 'Determinación Contable', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(37, 'Ventas en Parques y Funerarios', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(38, 'Consignación', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(39, 'Cotización', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(40, 'Ventas comerciales Parques', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(41, 'Ventas Operativas', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(42, 'Ventas Convenios', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(43, 'Ventas a Terceros', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(44, 'Ventas POS', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(45, 'Devoliciones', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(46, 'Ventas Recordar', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(47, 'Ventas comerciales Recordar Corporativo', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(48, 'Ventas comerciales uno a uno', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(49, 'Ventas comerciales Continuidad', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(50, 'Ventas Terceros', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(51, 'Ventas No operacionales', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(52, 'Ventas entre compañias', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(53, 'Notas Crédito y Débito comerciales', ' ', '2016-05-10 09:04:47', 4, 0, 1, 0),
(54, 'Activos Fijos', ' ', '2016-05-10 09:05:06', 5, 0, 1, 0),
(55, 'Deudores', ' ', '2016-05-10 09:05:06', 5, 0, 1, 0),
(56, 'Acreedores', ' ', '2016-05-10 09:05:06', 5, 0, 1, 0),
(57, 'Contabilidad General', ' ', '2016-05-10 09:05:06', 5, 0, 1, 0),
(58, 'Tesorería', ' ', '2016-05-10 09:05:06', 5, 0, 1, 0),
(59, 'Cartera', ' ', '2016-05-10 09:05:06', 5, 0, 1, 0),
(60, 'Mantenimiento Preventivo', ' ', '2016-05-10 09:05:21', 6, 0, 1, 0),
(61, 'Mantenimiento Correctivo', ' ', '2016-05-10 09:05:21', 6, 0, 1, 0),
(62, 'Servicio', ' ', '2016-05-10 09:05:21', 6, 0, 1, 0),
(63, 'Generación de PQRS', ' ', '2016-05-10 09:05:21', 6, 0, 1, 0),
(64, 'Gestión de atención y prestación de servicios', ' ', '2016-05-10 09:05:21', 6, 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

CREATE TABLE `responsables` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `mesa` varchar(128) NOT NULL,
  `proceso` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleres`
--

CREATE TABLE `talleres` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `titulo` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `talleres`
--

INSERT INTO `talleres` (`id`, `nombre`, `fecha`, `titulo`) VALUES
(0, 'init', '2015-11-02 19:51:39', '-'),
(1, 'Taller', '2015-12-10 04:15:45', 'Taller de procesos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposcategoria`
--

CREATE TABLE `tiposcategoria` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tiposcategoria`
--

INSERT INTO `tiposcategoria` (`id`, `nombre`) VALUES
(1, 'principal'),
(2, 'sugerencia'),
(3, 'admin'),
(4, 'init');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vindicadores`
--
CREATE TABLE `vindicadores` (
`proceso` text
,`nombre` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vwpregxmesa`
--
CREATE TABLE `vwpregxmesa` (
`mesas_id` bigint(11)
,`nombre` varchar(45)
,`total` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vwvotados`
--
CREATE TABLE `vwvotados` (
`categorias_id` bigint(11)
,`votados` bigint(21)
,`mesas_id` bigint(11)
,`nombre` varchar(64)
,`dependencia` bigint(11)
,`color` varchar(7)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vindicadores`
--
DROP TABLE IF EXISTS `vindicadores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vindicadores`  AS  select `procesos`.`proceso` AS `proceso`,`mesas`.`nombre` AS `nombre` from (`procesos` join `mesas` on((`mesas`.`id` = `procesos`.`mesas_id`))) order by `procesos`.`proceso` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vwpregxmesa`
--
DROP TABLE IF EXISTS `vwpregxmesa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwpregxmesa`  AS  select `p`.`mesas_id` AS `mesas_id`,`m`.`nombre` AS `nombre`,count(`p`.`mesas_id`) AS `total` from (`procesos` `p` left join `mesas` `m` on((`m`.`id` = `p`.`mesas_id`))) group by `p`.`mesas_id` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vwvotados`
--
DROP TABLE IF EXISTS `vwvotados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwvotados`  AS  select `p`.`categorias_id` AS `categorias_id`,count(`p`.`categorias_id`) AS `votados`,`p`.`mesas_id` AS `mesas_id`,`cat`.`nombre` AS `nombre`,`cat`.`dependencia` AS `dependencia`,`cat`.`color` AS `color` from (`procesos` `p` left join `categorias` `cat` on((`cat`.`id` = `p`.`categorias_id`))) group by `p`.`categorias_id`,`p`.`mesas_id` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoriacliente`
--
ALTER TABLE `categoriacliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoriaestrategia`
--
ALTER TABLE `categoriaestrategia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria_talleres_idx` (`talleres_id`),
  ADD KEY `fk_categorias_tiposcategoria1_idx` (`tiposcategoria_id`);

--
-- Indices de la tabla `compromiso`
--
ALTER TABLE `compromiso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `creacliente`
--
ALTER TABLE `creacliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `creaestrategia`
--
ALTER TABLE `creaestrategia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entrevistas`
--
ALTER TABLE `entrevistas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `impacto`
--
ALTER TABLE `impacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mesas_talleres1_idx` (`talleres_id`);

--
-- Indices de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `procesos`
--
ALTER TABLE `procesos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_procesos_talleres1_idx` (`talleres_id`),
  ADD KEY `fk_procesos_categorias1_idx` (`categorias_id`),
  ADD KEY `fk_procesos_mesas1_idx` (`mesas_id`);

--
-- Indices de la tabla `responsables`
--
ALTER TABLE `responsables`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `talleres`
--
ALTER TABLE `talleres`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposcategoria`
--
ALTER TABLE `tiposcategoria`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoriacliente`
--
ALTER TABLE `categoriacliente`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `categoriaestrategia`
--
ALTER TABLE `categoriaestrategia`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `compromiso`
--
ALTER TABLE `compromiso`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `creacliente`
--
ALTER TABLE `creacliente`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `creaestrategia`
--
ALTER TABLE `creaestrategia`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `entrevistas`
--
ALTER TABLE `entrevistas`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `impacto`
--
ALTER TABLE `impacto`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `procesos`
--
ALTER TABLE `procesos`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT de la tabla `responsables`
--
ALTER TABLE `responsables`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT de la tabla `talleres`
--
ALTER TABLE `talleres`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tiposcategoria`
--
ALTER TABLE `tiposcategoria`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `fk_categoria_talleres` FOREIGN KEY (`talleres_id`) REFERENCES `talleres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_categorias_tiposcategoria1` FOREIGN KEY (`tiposcategoria_id`) REFERENCES `tiposcategoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `fk_mesas_talleres1` FOREIGN KEY (`talleres_id`) REFERENCES `talleres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `procesos`
--
ALTER TABLE `procesos`
  ADD CONSTRAINT `fk_procesos_categorias1` FOREIGN KEY (`categorias_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_procesos_mesas1` FOREIGN KEY (`mesas_id`) REFERENCES `mesas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_procesos_talleres1` FOREIGN KEY (`talleres_id`) REFERENCES `talleres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
