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
		var_dump('payload motivo', $payloadMotivo);

		$this->db->insert('movimientos', $payloadMotivo);
		$id_movimiento = $this->db->insert_id();
		$payloadRegistro['id_usuario'] = $usuario['id_usuario'];
		$payloadRegistro['id_evento'] = 28;
		$payloadRegistro['id_objetivo'] = $id_movimiento;
		$payloadRegistro['tabla'] = 'movimientos';

		var_dump('payload registro', $payloadRegistro);
		$this->db->insert('registros', $payloadRegistro);

		var_dump('payload pedido', $payload);
		$payload['fecha_recepcion'] = $this->now();
		return $this->actualizar($id, $payload);
	}
}
