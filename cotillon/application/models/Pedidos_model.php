<?php defined('BASEPATH') || exit('No direct script access allowed');

class Pedidos_model extends MY_Model {


	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'pedidos';
		$this->clave_primaria = 'id_pedido';
	}


	protected function sanitizar ( Array $data ) {
			$datos = [];
			if (array_key_exists('id_proveedor', $data)) $datos['id_proveedor'] = intval($data['id_proveedor']);
			if (array_key_exists('fecha_creacion', $data)) $datos['fecha_creacion'] = htmlentities($data['fecha_creacion']);
			if (array_key_exists('fecha_recepcion', $data)) $datos['fecha_recepcion'] = htmlentities($data['fecha_recepcion']);
			if (array_key_exists('precio_total', $data)) $datos['precio_total'] = floatval($data['precio_total']);
			if (array_key_exists('precio_real', $data)) $datos['precio_real'] = floatval($data['precio_real']);
			return $datos;
	}


	public function lista($trash = false) {
		$this->db->join('proveedores', 'proveedores.id_proveedor = pedidos.id_proveedor');
		if (!$trash) $this->withTrashed();
		return $this->get()->result_array();
	}


	public function lista_limpia() {
		$this->db->join('proveedores', 'proveedores.id_proveedor = pedidos.id_proveedor');
		return $this->get()->result_array();
	}

	public function recibir_pedido($id, $payload, $usuario) {

		$payloadMotivo['id_razon_movimiento'] = 1;
		$payloadMotivo['monto'] = floatval($payload['precio_real']);

		$this->db->insert('movimientos', $payloadMotivo);
		$id_movimiento = $this->db->insert_id();
		$payloadRegistro['id_usuario'] = $usuario['id_usuario'];
		$payloadRegistro['id_evento'] = 28;
		$payloadRegistro['id_objetivo'] = $id_movimiento;
		$payloadRegistro['tabla'] = 'movimientos';

		$this->db->insert('registros', $payloadRegistro);

		$payload['fecha_recepcion'] = $this->now();
		return $this->actualizar($id, $payload);
	}

	public function listap ($id) {
  	$this->db->select('pedidos.id_pedido, proveedores.nombre_proveedor, productos.nombre');
		$this->db->select('detalles_pedido.cantidad, detalles_pedido.precio_unitario');
		$this->db->select('DATE_FORMAT(pedidos.fecha_creacion, "%d.%m.%Y  %H:%i:%s") AS fecha_creation');
    $this->db->select('DATE_FORMAT(pedidos.fecha_recepcion, "%d.%m.%Y  %H:%i:%s") AS fecha_reception');
    $this->db->select('pedidos.precio_total');

  	$this->db->join('detalles_pedido', 'detalles_pedido.id_pedido = pedidos.id_pedido');
    $this->db->join('productos', 'productos.id_producto = detalles_pedido.id_producto');
    $this->db->join('proveedores', 'proveedores.id_proveedor = pedidos.id_proveedor');

    $this->db->where('pedidos.id_pedido', $id);
    return $this->get()->result_array();
	}
}
