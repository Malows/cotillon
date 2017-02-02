<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_producto_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function lista() {
		return $this->db->get('categorias_producto')->result_array();
	}

	public function crear( $nombre ) {
		$nombre = htmlentities($nombre);

		$this->db->insert('categorias_producto', ['nombre_categoria' => $nombre]);
	}

	public function leer( $id ) {
		$this->db->where('id_categoria', intval($id) );
		return $this->db->get('categorias_producto')->row_array();
	}

	public function actualizar( $id, $nombre ) {
		$id = intval($id);
		$nombre = htmlentities($nombre);

		$this->db->where('id_categoria', $id);
		$this->db->update('categorias_producto', ['nombre_categoria' => $nombre]);
		return boolval( $this->db->affected_rows() );
	}

	public function eliminar( $id ) {
		$id = intval($id);

		$this->db->delete('categorias_producto', ['id_categoria' => $id]);
		return boolval( $this->db->affected_rows() );
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
		return $this->db->get('productos')->result_array();
	}
}
