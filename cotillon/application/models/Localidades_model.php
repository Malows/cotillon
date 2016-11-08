<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Localidades_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function lista() {
		return $this->db->get('localidades')->result_array();
	}
	
	public function crear( $nombre ) {
		$nombre = htmlentities($nombre);
		
		$this->db->insert('localidades', array('nombre_localidad' => $nombre));
	}
	
	public function leer( $id ) {
		$this->db->where('id_localidad', intval($id) );
		return $this->db->get('localidades')->row_array();
	}
	
	public function actualizar( $id, $nombre ) {
		$id = intval($id);
		$nombre = htmlentities($nombre);
		
		$this->db->where('id_localidad', $id);
		$this->db->update('localidades', array('nombre_localidad' => $nombre));
		return boolval( $this->db->affected_rows() );
	}
	
	public function eliminar( $id ) {
		$id = intval($id);
		
		$this->db->delete('localidades', array('id_localidad' => $id));
		return boolval( $this->db->affected_rows() );
	}
	
	public function buscar($param) {
		$param = htmlentities($param);
		
		$this->db->like('nombre_localidad', $param, 'both');
		// Produces: WHERE `nombre_localidad` LIKE '%$param%' ESCAPE '!'
		
		return $this->db->get('localidades')->result_array();
	}
}