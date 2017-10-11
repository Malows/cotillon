<?php defined('BASEPATH') || exit('No direct script access allowed');

class Pedidos_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	public function lista($trash = false) {
		$this->db->join('proveedores', 'proveedores.id_proveedor = pedidos.id_proveedor');
		if (!$trash) $this->db->where('pedidos.soft_delete',null);
		return $this->get()->result_array();
	}

	public function lista_limpia() {
		$this->db->join('proveedores', 'proveedores.id_proveedor = pedidos.id_proveedor');
		return $this->get()->result_array();
	}

	public function eliminar( $id ) {
		$data['soft_delete'] = $this->now();

		$this->db->update($id, $data);
		return $this->_return($id);
	}
}
