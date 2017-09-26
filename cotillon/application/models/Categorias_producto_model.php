<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_producto_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function lista() {
		$this->db->where('categorias_producto.soft_delete',null);
		return $this->db->get('categorias_producto')->result_array();
	}

	public function crear( $nombre ) {
		$nombre = htmlentities($nombre);

		$retorno = $this->db->insert('categorias_producto', ['nombre_categoria' => $nombre]);
		return $retorno ? $this->db->insert_id() : false;
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
		$this->db->where('id_categoria',$id);
		$data['soft_delete'] = date('Y-m-d H:i:s');
		$this->db->update('categorias_producto', $data);
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
		$this->db->where('productos.soft_delete',null);
		return $this->db->get('productos')->result_array();
	}
}
