SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `cotillon` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cotillon`;

CREATE TABLE IF NOT EXISTS `categorias_producto` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `categorias_producto` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Pasteleria'),
(2, 'Descartables'),
(3, 'Velas'),
(4, 'Disfraces'),
(5, 'Cotillon');

CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(45) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `id_localidad` int(11) DEFAULT NULL,
  `tipo_cliente` varchar(45) DEFAULT NULL,
  `soft_delete` datetime DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `idlocalidad` (`id_localidad`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `clientes` (`id_cliente`, `nombre_cliente`, `contacto`, `id_localidad`, `tipo_cliente`, `soft_delete`) VALUES
(1, 'Betty Boobies', 'Avenida 321', 1, 'Minorista', NULL),
(2, 'Pechugas Larroo', 'Avenida 123', 1, 'Mayorista', NULL);

CREATE TABLE IF NOT EXISTS `detalles_venta` (
  `id_producto` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  PRIMARY KEY (`id_producto`,`id_venta`),
  KEY `fk_detalles_ventas_ventas` (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `localidades` (
  `id_localidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_localidad` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_localidad`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `localidades` (`id_localidad`, `nombre_localidad`) VALUES
(1, 'Santa Fe');

CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `precio` float NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `cantidad` float DEFAULT NULL,
  `unidad` varchar(45) DEFAULT NULL,
  `soft_delete` datetime DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `idproveedor` (`id_proveedor`),
  KEY `idcategoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `productos` (`id_producto`, `id_proveedor`, `nombre`, `precio`, `id_categoria`, `descripcion`, `cantidad`, `unidad`, `soft_delete`) VALUES
(1, 1, 'Manguera de nafta', 150, 4, '', 0, 'metro', NULL),
(2, 1, 'Producto eliminable', 10000, 2, 'Se va a eliminar para no ser mostrado', NULL, NULL, '2017-04-12 00:00:00'),
(3, 2, 'Torta de cumplea&ntilde;os CARA', 100, 1, '', NULL, NULL, NULL),
(4, 2, 'Bizcochos', 120, 1, 'Bizcochos recreativos', NULL, 'kilogramos', NULL),
(5, 1, 'Regadores', 50, 4, 'Es la que va para el pasto', NULL, 'unidades', NULL),
(6, 1, 'Guantes', 20, 2, 'Guantes, para golpear como caballero', NULL, 'unidades', NULL),
(7, 1, 'Enrollador de mangueras', 256, 5, 'La gilada que enrolla', NULL, 'unidades', NULL);

CREATE TABLE IF NOT EXISTS `proveedores` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_proveedor` varchar(45) DEFAULT NULL,
  `id_localidad` int(11) NOT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`),
  KEY `idlocalidad` (`id_localidad`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `id_localidad`, `contacto`) VALUES
(1, 'La Goma Argentina', 1, 'Con verdadero olor a hule\r\ntel: 4555555'),
(2, 'panaderia la nueva estrella', 1, '168476');

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf16 NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf16 NOT NULL,
  `dni` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf16 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf16 NOT NULL,
  `es_admin` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_inicio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_fin` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `dni`, `email`, `password`, `es_admin`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 'Juan Manuel', 'Cruz', 35448975, 'juancho_1210@hotmail.com', '$2y$10$IzOBA5HxNUMdiX96FxLbv.TCUxCR7g8rUgl2Xw1rh37/tMENChMK6', 1, '2016-10-14 21:48:21', NULL),
(2, 'Milton', 'Wery', 34828118, 'milton_st@hotmail.com', '$2y$10$xwTAWv.MV/dBVM9MXewBiebBCnL6zI/4rDXRRSSnjrxSUffuNe.zu', 1, '2016-11-22 05:30:03', NULL),
(3, 'Random', 'Random', 123456789, 'random@mail.com', '$2y$10$IJEYN2bHkVKy2jg6xiCoJOTX6BMtxP6JXTOztNTHVYlv.ApWTSD/O', 0, '2017-01-12 04:47:04', '2017-01-12 01:17:56'),
(4, 'Ramdos', 'SeedTime', 23456789, 'otro_mail@mail.com', '$2y$10$bBniFrNPkWae1aQuyUoTXeaNHN6hviLMpkzV0P6TRZfqtwX9iagmK', 0, '2017-01-26 03:08:03', '2017-01-25 22:08:15'),
(5, 'user', 'user', 12345678, 'user@example.com', '$2y$10$sIOXUrWJYNrnycLzkyzte.9AGeSsKXA9jsl5APGuTkv3/ngY9ktD6', 0, '2017-05-09 01:15:57', NULL);

CREATE TABLE IF NOT EXISTS `ventas` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `total` float NOT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `idcliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_localidades` FOREIGN KEY (`id_localidad`) REFERENCES `localidades` (`id_localidad`);

ALTER TABLE `detalles_venta`
  ADD CONSTRAINT `fk_detalles_ventas_ventas` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `fk_detalles_ventas_ventas_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_producto` (`id_categoria`),
  ADD CONSTRAINT `fk_producto_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_proveedores_localidades` FOREIGN KEY (`id_localidad`) REFERENCES `localidades` (`id_localidad`);

ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_clientes_ventas` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
