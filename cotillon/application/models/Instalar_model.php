<?php ('BASEPATH') || exit('');

class Instalar_model extends CI_Model {
	public function __construct () {
		parent::__construct();
		$this->load->dbutil();
		$this->load->dbforge();
	}

	public function cantidad_de_usuarios () {
		return $this->db->get('usuarios')->num_rows();
	}

	public function super_usuario ($data) {
		$this->create_user(1, $data);
	}

	public function administrador ($data) {
		$this->create_user(2, $data);
	}

	private function create_user($privilege, $data) {
		$data['id_tipo_usuario'] = intval($privilege);
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		$cantidad = $this->db->get_where('usuarios', ['id_tipo_usuario' => intval($privilege)])->num_rows();
		if ($cantidad === 0) $this->db->insert('usuarios', $data);
	}

	public function first_run() {
		$this->database_creation();
		$this->create_structures();
		$this->add_primary_keys();
		$this->add_foreign_keys();
		$this->create_views();
		$this->seed_database();
	}

	private function database_creation () {
		if ($this->dbutil->database_exists('cotillon'))	$this->dbforge->drop_database('cotillon');
		$this->dbforge->create_database('cotillon');
	}

	private function seed_database () {
		$this->seed_tipos_usuarios();
		$this->seed_eventos();
	}

	private function create_structures () {
		$this->db->query("
		CREATE TABLE `caja` (`id_caja` int(11) NOT NULL, `fecha_apertura` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, `monto_apertura` float DEFAULT NULL, `fecha_cierre` datetime DEFAULT NULL, `monto_estimado_cierre` float DEFAULT NULL, `monto_real_cierre` float DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `categorias_producto` (`id_categoria` int(11) NOT NULL, `nombre_categoria` varchar(45) DEFAULT NULL, `soft_delete` datetime DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `clientes` (`id_cliente` int(11) NOT NULL, `nombre_cliente` varchar(45) DEFAULT NULL, `telefono` varchar(255) DEFAULT NULL, `email` varchar(255) DEFAULT NULL, `direccion` varchar(255) DEFAULT NULL, `id_localidad` int(11) DEFAULT NULL, `tipo_cliente` varchar(45) DEFAULT NULL, `soft_delete` datetime DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `detalles_pedido` (`id_pedido` int(11) NOT NULL, `id_producto` int(11) NOT NULL, `cantidad` float NOT NULL, `precio_unitario` float NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `detalles_venta` (`id_producto` int(11) NOT NULL, `id_venta` int(11) NOT NULL, `cantidad_venta` int(11) NOT NULL, `precio_unitario` float NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `eventos` (`id_evento` int(11) NOT NULL, `descripcion` varchar(64) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `localidades` (`id_localidad` int(11) NOT NULL, `nombre_localidad` varchar(45) DEFAULT NULL, `barrio` varchar(255) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `movimientos` (`id_movimiento` int(11) NOT NULL, `monto` float NOT NULL, `id_razon_movimiento` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `pedidos` (`id_pedido` int(11) NOT NULL, `id_proveedor` int(11) NOT NULL, `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, `fecha_recepcion` datetime DEFAULT NULL, `precio_total` float NOT NULL, `soft_delete` datetime DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `productos` (`id_producto` int(11) NOT NULL, `id_proveedor` int(11) NOT NULL, `nombre` varchar(45) DEFAULT NULL, `precio` float NOT NULL, `id_categoria` int(11) NOT NULL, `descripcion` varchar(255) DEFAULT NULL, `cantidad` float DEFAULT NULL, `unidad` varchar(45) DEFAULT NULL, `alerta` float NOT NULL DEFAULT '0', `soft_delete` datetime DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `proveedores` (`id_proveedor` int(11) NOT NULL, `nombre_proveedor` varchar(45) DEFAULT NULL, `id_localidad` int(11) NOT NULL, `contacto` varchar(255) DEFAULT NULL, `soft_delete` datetime DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `razones_movimientos` (`id_razon_movimiento` int(11) NOT NULL, `descripcion` varchar(255) NOT NULL, `multiplicador` smallint(6) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `registros` (`id_registro` int(11) NOT NULL, `id_usuario` int(11) NOT NULL, `id_evento` int(11) NOT NULL, `id_objetivo` int(11) NOT NULL, `tabla` char(24) NOT NULL COMMENT 'campo polimorfico de tablas', `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `tipos_usuarios` (`id_tipo_usuario` int(11) NOT NULL, `nombre` varchar(45) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `usuarios` (`id_usuario` int(11) NOT NULL, `nombre` varchar(50) CHARACTER SET utf8 NOT NULL, `apellido` varchar(50) CHARACTER SET utf8 NOT NULL, `dni` int(11) NOT NULL, `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL, `password` varchar(255) CHARACTER SET utf8 NOT NULL, `id_tipo_usuario` int(11) NOT NULL, `fecha_inicio` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `fecha_fin` timestamp NULL DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		CREATE TABLE `ventas` (`id_venta` int(11) NOT NULL, `id_cliente` int(11) NOT NULL, `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP, `total` float NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
	}

	private function add_primary_keys() {
		$this->db->query("
		ALTER TABLE `caja` ADD PRIMARY KEY (`id_caja`), MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `categorias_producto` ADD PRIMARY KEY (`id_categoria`), MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `clientes` ADD PRIMARY KEY (`id_cliente`), ADD KEY `idlocalidad` (`id_localidad`), MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `detalles_pedido` ADD PRIMARY KEY (`id_pedido`,`id_producto`);
		ALTER TABLE `detalles_venta` ADD PRIMARY KEY (`id_producto`,`id_venta`), ADD KEY `fk_detalles_ventas_ventas` (`id_venta`);
		ALTER TABLE `eventos` ADD PRIMARY KEY (`id_evento`), MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `localidades` ADD PRIMARY KEY (`id_localidad`), ADD UNIQUE KEY `nombre_localidad_2` (`nombre_localidad`,`barrio`), ADD KEY `nombre_localidad` (`nombre_localidad`,`barrio`), MODIFY `id_localidad` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `movimientos` ADD PRIMARY KEY (`id_movimiento`), ADD KEY `id_razon_movimiento` (`id_razon_movimiento`), MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `pedidos` ADD PRIMARY KEY (`id_pedido`), MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `productos` ADD PRIMARY KEY (`id_producto`), ADD KEY `idproveedor` (`id_proveedor`), ADD KEY `idcategoria` (`id_categoria`), MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `proveedores` ADD PRIMARY KEY (`id_proveedor`), ADD KEY `idlocalidad` (`id_localidad`), MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `razones_movimientos` ADD PRIMARY KEY (`id_razon_movimiento`), MODIFY `id_razon_movimiento` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `registros` ADD PRIMARY KEY (`id_registro`), ADD KEY `id_usuario` (`id_usuario`), ADD KEY `id_evento` (`id_evento`), MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `tipos_usuarios` ADD PRIMARY KEY (`id_tipo_usuario`), MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `usuarios` ADD PRIMARY KEY (`id_usuario`), ADD KEY `id_tipo_usuario` (`id_tipo_usuario`), MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;
		ALTER TABLE `ventas` ADD PRIMARY KEY (`id_venta`), ADD KEY `idcliente` (`id_cliente`), MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;
		");
	}

	private function add_foreign_keys() {
		$this->db->query("
		ALTER TABLE `clientes` ADD CONSTRAINT `fk_clientes_localidades` FOREIGN KEY (`id_localidad`) REFERENCES `localidades` (`id_localidad`);
		ALTER TABLE `detalles_venta` ADD CONSTRAINT `fk_detalles_ventas_ventas` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`), ADD CONSTRAINT `fk_detalles_ventas_ventas_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
		ALTER TABLE `movimientos` ADD CONSTRAINT `fk_movimientos_razon_movimientos` FOREIGN KEY (`id_razon_movimiento`) REFERENCES `razones_movimientos` (`id_razon_movimiento`);
		ALTER TABLE `productos` ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_producto` (`id_categoria`), ADD CONSTRAINT `fk_producto_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);
		ALTER TABLE `proveedores` ADD CONSTRAINT `fk_proveedores_localidades` FOREIGN KEY (`id_localidad`) REFERENCES `localidades` (`id_localidad`);
		ALTER TABLE `registros` ADD CONSTRAINT `fk_id_evento` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`), ADD CONSTRAINT `fk_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
		ALTER TABLE `usuarios` ADD CONSTRAINT `fk_usuarios_tipos_usuarios` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuarios` (`id_tipo_usuario`);
		ALTER TABLE `ventas` ADD CONSTRAINT `fk_clientes_ventas` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
		");
	}


	private function create_views () {
		$this->db->query("
		CREATE  VIEW `digest_categorias_ventas`  AS  select `productos`.`id_producto` AS `id_producto`,`productos`.`nombre` AS `nombre`,sum(`detalles_venta`.`cantidad_venta`) AS `cantidad_vendida`,`categorias_producto`.`id_categoria` AS `id_categoria`,`categorias_producto`.`nombre_categoria` AS `nombre_categoria` from ((`detalles_venta` join `productos` on((`productos`.`id_producto` = `detalles_venta`.`id_producto`))) join `categorias_producto` on((`productos`.`id_categoria` = `categorias_producto`.`id_categoria`))) group by `productos`.`id_producto` ;
		CREATE  VIEW `digest_top_venta_productos`  AS  select `productos`.`id_producto` AS `id_producto`,`productos`.`nombre` AS `nombre`,sum(`detalles_venta`.`cantidad_venta`) AS `total_venta` from (`productos` join `detalles_venta` on((`productos`.`id_producto` = `detalles_venta`.`id_producto`))) group by `productos`.`id_producto` order by `total_venta` desc ;
		CREATE  VIEW `digest_ventas_mes`  AS  select year(`ventas`.`fecha`) AS `año`,month(`ventas`.`fecha`) AS `mes`,sum(`ventas`.`total`) AS `total` from `ventas` group by `año`,`mes` order by `año` desc,`mes` desc ;
		");
	}

	private function seed_eventos () {
		$this->db->insert_batch('eventos',[
			['id_evento' => 1,	'descripcion' => 'emitió una venta'],
			['id_evento' => 2,	'descripcion' => 'creó un usuario'],
			['id_evento' => 3,	'descripcion' => 'modificó un usuario'],
			['id_evento' => 4,	'descripcion' => 'deshabilitó un usuario'],
			['id_evento' => 5,	'descripcion' => 'creó un proveedor'],
			['id_evento' => 6,	'descripcion' => 'modificó un proveedor'],
			['id_evento' => 7,	'descripcion' => 'deshabilitó un proveedor'],
			['id_evento' => 8,	'descripcion' => 'creó una categoría'],
			['id_evento' => 9,	'descripcion' => 'modificó una categoría'],
			['id_evento' => 10,	'descripcion' => 'deshabilitó una categoría'],
			['id_evento' => 11,	'descripcion' => 'creó un producto'],
			['id_evento' => 12,	'descripcion' => 'modificó un producto'],
			['id_evento' => 13,	'descripcion' => 'deshabilitó un producto'],
			['id_evento' => 14,	'descripcion' => 'creó un cliente'],
			['id_evento' => 15,	'descripcion' => 'modificó un cliente'],
			['id_evento' => 16,	'descripcion' => 'deshabilitó un cliente'],
			['id_evento' => 17,	'descripcion' => 'creó una localidad'],
			['id_evento' => 18,	'descripcion' => 'modificó una localidad'],
			['id_evento' => 19,	'descripcion' => 'deshabilitó una localidad'],
			['id_evento' => 20,	'descripcion' => 'agregó stock'],
			['id_evento' => 21,	'descripcion' => 'redujo stock'],
			['id_evento' => 22,	'descripcion' => 'creó un pedido'],
			['id_evento' => 23,	'descripcion' => 'modificó un pedido'],
			['id_evento' => 24,	'descripcion' => 'deshabilitó un pedido'],
			['id_evento' => 25,	'descripcion' => 'recibió un pedido'],
			['id_evento' => 26, 'descripcion' => 'abrió la caja'],
			['id_evento' => 27, 'descripcion' => 'cerró la caja'],
			['id_evento' => 28, 'descripcion' => 'creó una razón de movimiento'],
			['id_evento' => 29, 'descripcion' => 'modificó una razón de movimiento'],
			['id_evento' => 30, 'descripcion' => 'deshabilitó una razón de movimiento'],
			['id_evento' => 31, 'descripcion' => 'creó un movimiento'],
			['id_evento' => 32, 'descripcion' => 'modificó un movimiento'],
			['id_evento' => 33, 'descripcion' => 'deshabilitó un movimiento'],
			['id_evento' => 34, 'descripcion' => 'creó un tipo de usuario'],
			['id_evento' => 35, 'descripcion' => 'modificó un tipo de usuario'],
			['id_evento' => 36, 'descripcion' => 'deshabilitó un tipo de usuario']
		]);
	}

	private function seed_tipos_usuarios () {
		$this->db->insert_batch('tipos_usuarios',[
			['id_tipo_usuario' => 1, 'nombre' => 'super usuario'],
			['id_tipo_usuario' => 2, 'nombre' => 'administrador'],
			['id_tipo_usuario' => 3, 'nombre' => 'empleado']
		]);
	}
}
