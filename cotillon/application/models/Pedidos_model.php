<?php defined('BASEPATH') || exit('No direct script access allowed');

class Pedidos_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	public function lista($trash = false) {
		$this->db->join('proveedores', 'proveedores.id_proveedor = pedidos.id_proveedor');
		if (!$trash) $this->db->where('pedidos.soft_delete',null);
		return $this->db->get('pedidos')->result_array();
	}

	public function lista_limpia() {
		$this->db->join('proveedores', 'proveedores.id_proveedor = pedidos.id_proveedor');
		return $this->db->get('pedidos')->result_array();
	}

	public function eliminar( $id ) {
		// Sanitizar datos
		$id = intval( $id );
		$data['soft_delete'] = date('Y-m-d H:i:s');
    
		$this->db->where('id_pedidos', $id);
		$this->db->update('pedidos', $data);
		return $this->_return($id);
	}
}
