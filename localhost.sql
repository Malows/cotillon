-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 14-11-2017 a las 10:12:57
-- Versión del servidor: 5.6.33
-- Versión de PHP: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cotillon`
--
CREATE DATABASE IF NOT EXISTS `cotillon` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cotillon`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_caja` int(11) NOT NULL,
  `fecha_apertura` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `monto_apertura` float DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `monto_estimado_cierre` float DEFAULT NULL,
  `monto_real_cierre` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id_caja`, `fecha_apertura`, `monto_apertura`, `fecha_cierre`, `monto_estimado_cierre`, `monto_real_cierre`) VALUES
(1, '2017-10-17 01:26:50', 200, '2017-10-17 01:43:33', 200, 200),
(2, '2017-10-19 23:02:20', 200, '2017-10-19 23:02:30', 200, 300),
(3, '2017-10-19 23:02:47', 100, '2017-10-19 23:02:55', 100, 50),
(4, '2017-10-26 00:09:13', 100, '2017-10-26 00:36:16', 220, 220);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_producto`
--

CREATE TABLE `categorias_producto` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(45) DEFAULT NULL,
  `soft_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias_producto`
--

INSERT INTO `categorias_producto` (`id_categoria`, `nombre_categoria`, `soft_delete`) VALUES
(1, 'Pasteleria', NULL),
(2, 'Descartables', NULL),
(3, 'Velas', NULL),
(4, 'Disfraces', NULL),
(5, 'Cotillon', NULL),
(6, 'Pirotecnia', NULL),
(7, 'eliminable', '2017-10-25 23:51:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(45) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_localidad` int(11) DEFAULT NULL,
  `tipo_cliente` varchar(45) DEFAULT NULL,
  `soft_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `telefono`, `email`, `direccion`, `id_localidad`, `tipo_cliente`, `soft_delete`) VALUES
(1, 'Consumidor final', '', NULL, 'Avenida 321', 1, 'Minorista', NULL),
(2, 'Pechugas Larroo', '', NULL, 'Avenida 123', 1, 'Mayorista', NULL),
(3, 'Betty Boobies', '(0342)-4550055', 'perez@algo.com', 'Direcci&oacute;n 789', 1, 'Minorista', NULL),
(4, 'Guadalupe Guadalupe', '(0342)-4555555', 'guadalupe@elnombre.com', 'Javier de la Rosa 650', 3, 'Minorista', NULL),
(5, 'Cliente de Prueba', '(0342)-4550055', 'prueba_cliente@prueba.com', 'Siempre viva 225', 1, 'Minorista', NULL),
(6, 'Swag Dealer', '(0342)-4550055', 'swag@dealer.com', 'swag 1337', 12, 'Minorista', '2017-10-25 23:53:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedido`
--

CREATE TABLE `detalles_pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `precio_unitario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalles_pedido`
--

INSERT INTO `detalles_pedido` (`id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_venta`
--

CREATE TABLE `detalles_venta` (
  `id_producto` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `cantidad_venta` int(11) NOT NULL,
  `precio_unitario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalles_venta`
--

INSERT INTO `detalles_venta` (`id_producto`, `id_venta`, `cantidad_venta`, `precio_unitario`) VALUES
(1, 1, 1, 150),
(1, 2, 1, 150),
(1, 14, 1, 150),
(1, 15, 1, 150),
(1, 16, 1, 150),
(1, 18, 4, 150),
(1, 19, 10, 150),
(1, 20, 10, 150),
(1, 23, 1, 150),
(3, 1, 1, 100),
(3, 2, 1, 100),
(3, 17, 10, 100),
(3, 30, 1, 100),
(4, 1, 1, 120),
(4, 2, 1, 120),
(4, 17, 10, 120),
(4, 27, 1, 120),
(4, 28, 1, 120),
(4, 31, 1, 120),
(5, 3, 1, 50),
(5, 17, 10, 50),
(5, 20, 5, 50),
(5, 23, 1, 50),
(6, 3, 1, 20),
(6, 4, 1, 20),
(6, 17, 103, 20),
(6, 20, 2, 20),
(7, 4, 1, 256),
(7, 17, 13, 256);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `digest_categorias_ventas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `digest_categorias_ventas` (
`id_producto` int(11)
,`nombre` varchar(45)
,`cantidad_vendida` decimal(32,0)
,`id_categoria` int(11)
,`nombre_categoria` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `digest_top_venta_productos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `digest_top_venta_productos` (
`id_producto` int(11)
,`nombre` varchar(45)
,`total_venta` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `digest_ventas_mes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `digest_ventas_mes` (
`año` int(4)
,`mes` int(2)
,`total` double
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `descripcion` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_evento`, `descripcion`) VALUES
(1, 'emitió una venta'),
(2, 'creó un usuario'),
(3, 'modificó un usuario'),
(4, 'deshabilitó un usuario'),
(5, 'creó un proveedor'),
(6, 'modificó un proveedor'),
(7, 'deshabilitó un proveedor'),
(8, 'creó una categoría'),
(9, 'modificó una categoría'),
(10, 'deshabilitó una categoría'),
(11, 'creó un producto'),
(12, 'modificó un producto'),
(13, 'deshabilitó un producto'),
(14, 'creó un cliente'),
(15, 'modificó un cliente'),
(16, 'deshabilitó un cliente'),
(17, 'creó una localidad'),
(18, 'modificó una localidad'),
(19, 'deshabilitó una localidad'),
(20, 'agregó stock'),
(21, 'redujo stock'),
(22, 'creó un pedido'),
(23, 'modificó un pedido'),
(24, 'deshabilitó un pedido'),
(25, 'recibió un pedido'),
(26, 'abrió la caja'),
(27, 'cerró la caja'),
(28, 'creó una razón de movimiento'),
(29, 'modificó una razón de movimiento'),
(30, 'deshabilitó una razón de movimiento'),
(31, 'creó un movimiento'),
(32, 'modificó un movimiento'),
(33, 'deshabilitó un movimiento'),
(34, 'creó un tipo de usuario'),
(35, 'modificó un tipo de usuario'),
(36, 'deshabilitó un tipo de usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidades`
--

CREATE TABLE `localidades` (
  `id_localidad` int(11) NOT NULL,
  `nombre_localidad` varchar(45) DEFAULT NULL,
  `barrio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `localidades`
--

INSERT INTO `localidades` (`id_localidad`, `nombre_localidad`, `barrio`) VALUES
(2, 'Santa Fe', 'Centenario'),
(1, 'Santa Fe', 'Centro'),
(3, 'Santa Fe', 'Guadalupe'),
(11, 'Santa Fe', 'Maria Selva'),
(12, 'Venado Tuerto', 'Barrio Tuerto'),
(13, 'Venado Tuerto', 'Mar Chiquita');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id_movimiento` int(11) NOT NULL,
  `monto` float NOT NULL,
  `id_razon_movimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id_movimiento`, `monto`, `id_razon_movimiento`) VALUES
(1, 10, 1),
(2, 12, 3),
(3, 20, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_recepcion` datetime DEFAULT NULL,
  `precio_total` float NOT NULL,
  `soft_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_proveedor`, `fecha_creacion`, `fecha_recepcion`, `precio_total`, `soft_delete`) VALUES
(1, 1, '2017-10-26 03:10:59', NULL, 100, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `precio` float NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `cantidad` float DEFAULT NULL,
  `unidad` varchar(45) DEFAULT NULL,
  `alerta` float NOT NULL DEFAULT '0',
  `soft_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_proveedor`, `nombre`, `precio`, `id_categoria`, `descripcion`, `cantidad`, `unidad`, `alerta`, `soft_delete`) VALUES
(1, 1, 'Manguera de nafta', 150, 4, '', 0, 'metro', 10, NULL),
(2, 1, 'Producto eliminable', 10000, 2, 'Se va a eliminar para no ser mostrado', NULL, NULL, 0, '2017-10-25 23:57:40'),
(3, 2, 'Torta de cumplea&ntilde;os CARA', 100, 1, '', 0, 'unidades', 5, NULL),
(4, 2, 'Bizcochos', 120, 1, 'Bizcochos recreativos', 3, 'kilogramos', 2.5, NULL),
(5, 1, 'Regadores', 50, 4, 'Es la que va para el pasto', 0, 'unidades', 0, NULL),
(6, 1, 'Guantes', 20, 2, 'Guantes, para golpear como caballero', 1, 'unidades', 0, NULL),
(7, 1, 'Enrollador de mangueras', 256, 5, 'La gilada que enrolla', 1, 'unidades', 0, NULL),
(8, 2, 'Chocolate de tortas', 20, 1, '', 1, 'unidades', 0, NULL),
(10, 2, 'Churros', 8, 1, 'Churros', 10, 'unidades', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(45) DEFAULT NULL,
  `id_localidad` int(11) NOT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `soft_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `id_localidad`, `contacto`, `soft_delete`) VALUES
(1, 'La Goma Argentina', 1, 'Con verdadero olor a hule\r\ntel: 4555555', NULL),
(2, 'panaderia la nueva estrella', 1, '168476', NULL),
(3, 'Cientifuegos', 1, '123123123454545', NULL),
(4, 'Eliminable', 2, '46847897878456123123', '2017-10-25 23:55:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razones_movimientos`
--

CREATE TABLE `razones_movimientos` (
  `id_razon_movimiento` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `multiplicador` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `razones_movimientos`
--

INSERT INTO `razones_movimientos` (`id_razon_movimiento`, `descripcion`, `multiplicador`) VALUES
(1, 'pago a proveedores', -1),
(2, 'pago impuesto inmoviliario', -1),
(3, 'cobro de deuda', 1),
(4, 'pago de sueldos', -1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id_registro` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `id_objetivo` int(11) NOT NULL,
  `tabla` char(24) NOT NULL COMMENT 'campo polimorfico de tablas',
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_usuarios`
--

CREATE TABLE `tipos_usuarios` (
  `id_tipo_usuario` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipos_usuarios`
--

INSERT INTO `tipos_usuarios` (`id_tipo_usuario`, `nombre`) VALUES
(1, 'super usuario'),
(2, 'administrador'),
(3, 'empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf16 NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf16 NOT NULL,
  `dni` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf16 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf16 NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  `fecha_inicio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_fin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `dni`, `email`, `password`, `id_tipo_usuario`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 'Juan Manuel', 'Cruz', 35448975, 'juancho_1210@hotmail.com', '$2y$10$IzOBA5HxNUMdiX96FxLbv.TCUxCR7g8rUgl2Xw1rh37/tMENChMK6', 1, '2016-10-14 21:48:21', NULL),
(2, 'Milton', 'Wery', 34828118, 'milton_st@hotmail.com', '$2y$10$xwTAWv.MV/dBVM9MXewBiebBCnL6zI/4rDXRRSSnjrxSUffuNe.zu', 1, '2016-11-22 05:30:03', NULL),
(3, 'Random', 'Random', 123456789, 'random@mail.com', '$2y$10$IJEYN2bHkVKy2jg6xiCoJOTX6BMtxP6JXTOztNTHVYlv.ApWTSD/O', 3, '2017-01-12 04:47:04', '2017-10-26 02:49:57'),
(4, 'Ramdos', 'SeedTime', 23456789, 'otro_mail@mail.com', '$2y$10$bBniFrNPkWae1aQuyUoTXeaNHN6hviLMpkzV0P6TRZfqtwX9iagmK', 3, '2017-01-26 03:08:03', '2017-10-26 02:49:51'),
(5, 'user', 'user', 12345678, 'user@example.com', '$2y$10$sIOXUrWJYNrnycLzkyzte.9AGeSsKXA9jsl5APGuTkv3/ngY9ktD6', 3, '2017-05-09 01:15:57', NULL),
(6, 'Administrador', 'Administrador', 111222333, 'administrador@mail.com', '$2y$10$dE2h1/GKOj7oh0fmrjX5oOVNnwCrs1mny7OkF7DSxjZh040GOSQEW', 2, '2017-09-26 04:43:13', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_cliente`, `fecha`, `total`) VALUES
(1, 4, '2017-06-27 04:42:41', 370),
(2, 4, '2017-06-27 04:44:07', 370),
(3, 1, '2017-06-27 04:46:25', 70),
(4, 2, '2017-06-27 04:47:16', 276),
(14, 1, '2017-07-05 02:57:03', 150),
(15, 1, '2017-07-05 02:58:52', 150),
(16, 1, '2017-07-05 03:00:17', 150),
(17, 1, '2017-07-05 03:02:15', 8088),
(18, 2, '2017-07-05 03:03:27', 600),
(19, 3, '2017-07-05 04:06:40', 1500),
(20, 3, '2017-07-13 04:40:00', 1790),
(23, 4, '2017-09-20 03:54:48', 200),
(27, 1, '2017-09-20 04:48:55', 120),
(28, 1, '2017-09-20 04:51:55', 120),
(30, 3, '2017-10-24 03:43:21', 100),
(31, 1, '2017-10-26 03:18:49', 120);

-- --------------------------------------------------------

--
-- Estructura para la vista `digest_categorias_ventas`
--
DROP TABLE IF EXISTS `digest_categorias_ventas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`juan`@`localhost` SQL SECURITY DEFINER VIEW `digest_categorias_ventas`  AS  select `productos`.`id_producto` AS `id_producto`,`productos`.`nombre` AS `nombre`,sum(`detalles_venta`.`cantidad_venta`) AS `cantidad_vendida`,`categorias_producto`.`id_categoria` AS `id_categoria`,`categorias_producto`.`nombre_categoria` AS `nombre_categoria` from ((`detalles_venta` join `productos` on((`productos`.`id_producto` = `detalles_venta`.`id_producto`))) join `categorias_producto` on((`productos`.`id_categoria` = `categorias_producto`.`id_categoria`))) group by `productos`.`id_producto` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `digest_top_venta_productos`
--
DROP TABLE IF EXISTS `digest_top_venta_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`juan`@`localhost` SQL SECURITY DEFINER VIEW `digest_top_venta_productos`  AS  select `productos`.`id_producto` AS `id_producto`,`productos`.`nombre` AS `nombre`,sum(`detalles_venta`.`cantidad_venta`) AS `total_venta` from (`productos` join `detalles_venta` on((`productos`.`id_producto` = `detalles_venta`.`id_producto`))) group by `productos`.`id_producto` order by `total_venta` desc ;

-- --------------------------------------------------------

--
-- Estructura para la vista `digest_ventas_mes`
--
DROP TABLE IF EXISTS `digest_ventas_mes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`juan`@`localhost` SQL SECURITY DEFINER VIEW `digest_ventas_mes`  AS  select year(`ventas`.`fecha`) AS `año`,month(`ventas`.`fecha`) AS `mes`,sum(`ventas`.`total`) AS `total` from `ventas` group by `año`,`mes` order by `año` desc,`mes` desc ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `categorias_producto`
--
ALTER TABLE `categorias_producto`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `idlocalidad` (`id_localidad`);

--
-- Indices de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD PRIMARY KEY (`id_pedido`,`id_producto`);

--
-- Indices de la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
  ADD PRIMARY KEY (`id_producto`,`id_venta`),
  ADD KEY `fk_detalles_ventas_ventas` (`id_venta`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`);

--
-- Indices de la tabla `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`id_localidad`),
  ADD UNIQUE KEY `nombre_localidad_2` (`nombre_localidad`,`barrio`),
  ADD KEY `nombre_localidad` (`nombre_localidad`,`barrio`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `id_razon_movimiento` (`id_razon_movimiento`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `idproveedor` (`id_proveedor`),
  ADD KEY `idcategoria` (`id_categoria`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD KEY `idlocalidad` (`id_localidad`);

--
-- Indices de la tabla `razones_movimientos`
--
ALTER TABLE `razones_movimientos`
  ADD PRIMARY KEY (`id_razon_movimiento`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_evento` (`id_evento`);

--
-- Indices de la tabla `tipos_usuarios`
--
ALTER TABLE `tipos_usuarios`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_tipo_usuario` (`id_tipo_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `idcliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `categorias_producto`
--
ALTER TABLE `categorias_producto`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT de la tabla `localidades`
--
ALTER TABLE `localidades`
  MODIFY `id_localidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `razones_movimientos`
--
ALTER TABLE `razones_movimientos`
  MODIFY `id_razon_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipos_usuarios`
--
ALTER TABLE `tipos_usuarios`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_localidades` FOREIGN KEY (`id_localidad`) REFERENCES `localidades` (`id_localidad`);

--
-- Filtros para la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
  ADD CONSTRAINT `fk_detalles_ventas_ventas` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `fk_detalles_ventas_ventas_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `fk_movimientos_razon_movimientos` FOREIGN KEY (`id_razon_movimiento`) REFERENCES `razones_movimientos` (`id_razon_movimiento`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_producto` (`id_categoria`),
  ADD CONSTRAINT `fk_producto_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_proveedores_localidades` FOREIGN KEY (`id_localidad`) REFERENCES `localidades` (`id_localidad`);

--
-- Filtros para la tabla `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `fk_id_evento` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`),
  ADD CONSTRAINT `fk_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_tipos_usuarios` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuarios` (`id_tipo_usuario`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_clientes_ventas` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
