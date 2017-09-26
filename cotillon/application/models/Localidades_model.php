<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Localidades_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function lista() {
		return $this->db->get('localidades')->result_array();
	}

	public function crear( $nombre, $barrio ) {
		$nombre = htmlentities($nombre);
		$barrio = htmlentities($barrio);

		$data = ['nombre_localidad' => $nombre, 'barrio' => $barrio];

		$retorno = $this->db->insert('localidades', $data);
		return $retorno ? $this->db->insert_id() : false;
	}

	public function leer( $id ) {
		$this->db->where('id_localidad', intval($id) );
		return $this->db->get('localidades')->row_array();
	}

	public function actualizar( $id, $nombre, $barrio ) {
		$id = intval($id);
		$nombre = htmlentities($nombre);
		$barrio = htmlentities($barrio);

		$data = ['nombre_localidad' => $nombre, 'barrio' => $barrio];

		$this->db->where('id_localidad', $id);
		$this->db->update('localidades', $data);
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
