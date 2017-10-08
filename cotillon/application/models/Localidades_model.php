<?php defined('BASEPATH') || exit('No direct script access allowed');

class Localidades_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'localidades';
		$this->clave_primaria = 'id_localidad';
	}

	private function _sanitizar( $nombre, $barrio ) {
		return ['nombre_localidad' => htmlentities($nombre), 'barrio' => htmlentities($barrio)];
	}

	public function lista() {
		return $this->db->get()->result_array();
	}

	public function crear( $nombre, $barrio ) {
		$data = $this->_sanitizar( $nombre, $barrio );

		$retorno = $this->insert($data);
		return $this->_return();
	}

	public function leer( $id ) {
		return $this->db->get($id)->row_array();
	}

	public function actualizar( $id, $nombre, $barrio ) {
		$data = $this->_sanitizar( $nombre, $barrio );

		$this->update($id, $data);
		return $this->_return($id);
	}

	public function eliminar( $id ) {
		$id = intval($id);
		$this->db->delete('localidades', ['id_localidad' => $id]);
		return $this->_return($id);
	}

	public function buscar($param) {
		$param = htmlentities($param);

		$this->db->like('nombre_localidad', $param, 'both');
		// Produces: WHERE `nombre_localidad` LIKE '%$param%' ESCAPE '!'

		return $this->get()->result_array();
	}
}
