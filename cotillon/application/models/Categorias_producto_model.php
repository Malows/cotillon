<?php defined('BASEPATH') || exit('No direct script access allowed');

class Categorias_producto_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'categorias_producto';
		$this->clave_primaria = 'id_categoria';
	}

	protected function sanitizar( Array $data ) {
		return ['nombre_categoria' => htmlentities($data['nombre_categoria'])];
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
