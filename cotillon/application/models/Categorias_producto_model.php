<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_producto_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'categorias_producto';
		$this->clave_primaria = 'id_categoria';
	}

	private function _sanitizar( $nombre ) {
		return ['nombre_categoria' => htmlentities($nombre)];
	}

	public function lista($trash = false) {
		if (!$trash) $this->db->where('categorias_producto.soft_delete',null);
		return $this->get()->result_array();
	}

	public function crear( $nombre ) {
		$data = $this->_sanitizar( $nombre );

		$this->db->insert($data);
		return $this->_return();
	}

	public function leer( $id ) {
		return $this->get( $id )->row_array();
	}

	public function actualizar( $id, $nombre ) {
		$data = $this->_sanitizar( $nombre );
		$this->db->update($id, $data);
		return $this->_return($id);
	}

	public function eliminar( $id ) {
		$data['soft_delete'] = $this->now();
		$this->update($id, $data);
		return $this->_return($id);
	}

	public function buscar($param) {
		$param = htmlentities($param);

		$this->db->like('nombre_categoria', $param, 'both');
		// Produces: WHERE `nombre_categoria` LIKE '%$param%' ESCAPE '!'

		return $this->db->get('categorias_producto')->result_array();
	}

	public function productos_correspondientes( $id ) {
		$id = intval($id);

		$this->db->where('id_categoria', $id);
		$this->db->where('productos.soft_delete',null);
		return $this->db->get('productos')->result_array();
	}
}
