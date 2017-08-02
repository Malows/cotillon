-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jul 27, 2017 at 10:59 PM
-- Server version: 5.6.33
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cotillon`
--
DROP DATABASE IF EXISTS `cotillon`;
CREATE DATABASE IF NOT EXISTS `cotillon` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cotillon`;

-- --------------------------------------------------------

--
-- Table structure for table `categorias_producto`
--

CREATE TABLE `categorias_producto` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(45) DEFAULT NULL,
  `soft_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorias_producto`
--

INSERT INTO `categorias_producto` (`id_categoria`, `nombre_categoria`, `soft_delete`) VALUES
(1, 'Pasteleria', NULL),
(2, 'Descartables', NULL),
(3, 'Velas', NULL),
(4, 'Disfraces', NULL),
(5, 'Cotillon', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
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
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `telefono`, `email`, `direccion`, `id_localidad`, `tipo_cliente`, `soft_delete`) VALUES
(1, 'Betty Boobies', '', NULL, 'Avenida 321', 1, 'Minorista', NULL),
(2, 'Pechugas Larroo', '', NULL, 'Avenida 123', 1, 'Mayorista', NULL),
(3, 'Perez Algo', '(0342)-4550055', 'perez@algo.com', 'Direcci&oacute;n 789', 1, 'Minorista', NULL),
(4, 'Guadalupe Guadalupe', '(0342)-4555555', 'guadalupe@elnombre.com', 'Javier de la Rosa 650', 3, 'Minorista', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detalles_venta`
--

CREATE TABLE `detalles_venta` (
  `id_producto` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detalles_venta`
--

-- No cargo datos, pueden estar corruptos en development

-- INSERT INTO `detalles_venta` (`id_producto`, `id_venta`, `cantidad`, `precio_unitario`) VALUES
-- (1, 1, 1, 150),
-- (1, 2, 1, 150),
-- (1, 14, 1, 150),
-- (1, 15, 1, 150),
-- (1, 16, 1, 150),
-- (1, 18, 4, 150),
-- (1, 19, 10, 150),
-- (1, 20, 10, 150),
-- (3, 1, 1, 100),
-- (3, 2, 1, 100),
-- (3, 17, 10, 100),
-- (4, 1, 1, 120),
-- (4, 2, 1, 120),
-- (4, 17, 10, 120),
-- (5, 3, 1, 50),
-- (5, 17, 10, 50),
-- (5, 20, 5, 50),
-- (6, 3, 1, 20),
-- (6, 4, 1, 20),
-- (6, 17, 103, 20),
-- (6, 20, 2, 20),
-- (7, 4, 1, 256),
-- (7, 17, 13, 256);

-- --------------------------------------------------------

--
-- Table structure for table `localidades`
--

CREATE TABLE `localidades` (
  `id_localidad` int(11) NOT NULL,
  `nombre_localidad` varchar(45) DEFAULT NULL,
  `barrio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `localidades`
--

INSERT INTO `localidades` (`id_localidad`, `nombre_localidad`, `barrio`) VALUES
(2, 'Santa Fe', 'Centenario'),
(1, 'Santa Fe', 'Centro'),
(3, 'Santa Fe', 'Guadalupe'),
(11, 'Santa Fe', 'Maria Selva');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
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
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_producto`, `id_proveedor`, `nombre`, `precio`, `id_categoria`, `descripcion`, `cantidad`, `unidad`, `alerta`, `soft_delete`) VALUES
(1, 1, 'Manguera de nafta', 150, 4, '', 1, 'metro', 10, NULL),
(2, 1, 'Producto eliminable', 10000, 2, 'Se va a eliminar para no ser mostrado', NULL, NULL, 10, '2017-06-07 21:33:31'),
(3, 2, 'Torta de cumplea&ntilde;os CARA', 100, 1, '', 1, 'unidades', 5, NULL),
(4, 2, 'Bizcochos', 120, 1, 'Bizcochos recreativos', 1, 'kilogramos', 2.5, NULL),
(5, 1, 'Regadores', 50, 4, 'Es la que va para el pasto', 1, 'unidades', 5, NULL),
(6, 1, 'Guantes', 20, 2, 'Guantes, para golpear como caballero', 1, 'unidades', 4, NULL),
(7, 1, 'Enrollador de mangueras', 256, 5, 'La gilada que enrolla', 1, 'unidades', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(45) DEFAULT NULL,
  `id_localidad` int(11) NOT NULL,
  `contacto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `id_localidad`, `contacto`) VALUES
(1, 'La Goma Argentina', 1, 'Con verdadero olor a hule\r\ntel: 4555555'),
(2, 'panaderia la nueva estrella', 1, '168476');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf16 NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf16 NOT NULL,
  `dni` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf16 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf16 NOT NULL,
  `es_admin` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_inicio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_fin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `dni`, `email`, `password`, `es_admin`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 'Juan Manuel', 'Cruz', 35448975, 'juancho_1210@hotmail.com', '$2y$10$IzOBA5HxNUMdiX96FxLbv.TCUxCR7g8rUgl2Xw1rh37/tMENChMK6', 1, '2016-10-14 21:48:21', NULL),
(2, 'Milton', 'Wery', 34828118, 'milton_st@hotmail.com', '$2y$10$xwTAWv.MV/dBVM9MXewBiebBCnL6zI/4rDXRRSSnjrxSUffuNe.zu', 1, '2016-11-22 05:30:03', NULL),
(3, 'Random', 'Random', 123456789, 'random@mail.com', '$2y$10$IJEYN2bHkVKy2jg6xiCoJOTX6BMtxP6JXTOztNTHVYlv.ApWTSD/O', 0, '2017-01-12 04:47:04', '2017-01-12 01:17:56'),
(4, 'Ramdos', 'SeedTime', 23456789, 'otro_mail@mail.com', '$2y$10$bBniFrNPkWae1aQuyUoTXeaNHN6hviLMpkzV0P6TRZfqtwX9iagmK', 0, '2017-01-26 03:08:03', '2017-01-25 22:08:15'),
(5, 'user', 'user', 12345678, 'user@example.com', '$2y$10$sIOXUrWJYNrnycLzkyzte.9AGeSsKXA9jsl5APGuTkv3/ngY9ktD6', 0, '2017-05-09 01:15:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ventas`
--

-- No cargo datos, pueden estar corruptos en development

-- INSERT INTO `ventas` (`id_venta`, `id_cliente`, `fecha`, `total`) VALUES
-- (1, 4, '2017-06-27 04:42:41', 370),
-- (2, 4, '2017-06-27 04:44:07', 370),
-- (3, 1, '2017-06-27 04:46:25', 70),
-- (4, 2, '2017-06-27 04:47:16', 276),
-- (14, 1, '2017-07-05 02:57:03', 150),
-- (15, 1, '2017-07-05 02:58:52', 150),
-- (16, 1, '2017-07-05 03:00:17', 150),
-- (17, 1, '2017-07-05 03:02:15', 8088),
-- (18, 2, '2017-07-05 03:03:27', 600),
-- (19, 3, '2017-07-05 04:06:40', 1500),
-- (20, 3, '2017-07-13 04:40:00', 1790);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias_producto`
--
ALTER TABLE `categorias_producto`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `idlocalidad` (`id_localidad`);

--
-- Indexes for table `detalles_venta`
--
ALTER TABLE `detalles_venta`
  ADD PRIMARY KEY (`id_producto`,`id_venta`),
  ADD KEY `fk_detalles_ventas_ventas` (`id_venta`);

--
-- Indexes for table `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`id_localidad`),
  ADD UNIQUE KEY `nombre_localidad_2` (`nombre_localidad`,`barrio`),
  ADD KEY `nombre_localidad` (`nombre_localidad`,`barrio`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `idproveedor` (`id_proveedor`),
  ADD KEY `idcategoria` (`id_categoria`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD KEY `idlocalidad` (`id_localidad`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `idcliente` (`id_cliente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias_producto`
--
ALTER TABLE `categorias_producto`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `localidades`
--
ALTER TABLE `localidades`
  MODIFY `id_localidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_localidades` FOREIGN KEY (`id_localidad`) REFERENCES `localidades` (`id_localidad`);

--
-- Constraints for table `detalles_venta`
--
ALTER TABLE `detalles_venta`
  ADD CONSTRAINT `fk_detalles_ventas_ventas` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `fk_detalles_ventas_ventas_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_producto` (`id_categoria`),
  ADD CONSTRAINT `fk_producto_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Constraints for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_proveedores_localidades` FOREIGN KEY (`id_localidad`) REFERENCES `localidades` (`id_localidad`);

--
-- Constraints for table `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_clientes_ventas` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
