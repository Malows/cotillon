<?php defined('BASEPATH') || exit('No direct script access allowed');

class Pedidos_model extends MY_Model {


	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'pedidos';
		$this->clave_primaria = 'id_pedido';
	}


	protected function sanitizar ( Array $data ) {
			$datos = [];
			$datos['id_proveedor'] = intval($data['id_proveedor']);
			$datos['fecha_creacion'] = htmlentities($data['fecha_creacion']);
			$datos['fecha_recepcion'] = htmlentities($data['fecha_recepcion']);
			$datos['precio_total'] = floatval($data['precio_total']);
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
}
