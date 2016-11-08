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
		
		$this->db->insert('categorias_producto', array('categoria_nombre' => $nombre));
	}
	
	public function leer( $id ) {
		$this->db->where('id_categoria', intval($id) );
		return $this->db->get('categorias_producto')->row_array();
	}
	
	public function actualizar( $id, $nombre ) {
		$id = intval($id);
		$nombre = htmlentities($nombre);
		
		$this->db->where('id_categoria', $id);
		$this->db->update('categorias_producto', array('categoria_nombre' => $nombre));
		return boolval( $this->db->affected_rows() );
	}
	
	public function eliminar( $id ) {
		$id = intval($id);
		
		$this->db->delete('categorias_producto', array('id_categoria' => $id));
		return boolval( $this->db->affected_rows() );
	}
	
	public function buscar($param) {
		$param = htmlentities($param);
		
		$this->db->like('categoria_nombre', $param, 'both');
		// Produces: WHERE `categoria_nombre` LIKE '%$param%' ESCAPE '!'
		
		return $this->db->get('categorias_producto')->result_array();
	}
}