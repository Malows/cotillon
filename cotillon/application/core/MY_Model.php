<?php
class MY_Model extends CI_Model {

	protected $nombre_tabla;
	protected $clave_primaria;

	public function __contruct() {
		parent::__contruct();
	}

	protected function _return ( $id = null ) {
		if ( $id === null ) return $this->db->insert_id();
		else if ( boolval( ( $this->db->affected_rows() ) ) ) return $id;
		else return false;
	}

	protected function now () {
		return (new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');
	}

	protected function get($key = null) {
		if ($key) $this->where($key);
		return $this->db->get( $this->nombre_tabla );
	}

	protected function update($key, $data) {
		$this->where( $key );
		return $this->db->update( $this->nombre_tabla, $data );
	}

	protected function insert( $data ) {
		return $this->db->insert( $this->nombre_tabla, $data );
	}

	protected function where( $key ) {
		if (is_array($key))
			foreach ($key as $clave => $valor) {
				$this->db->where( htmlentities($clave), intval($valor) );
			}
		$this->db->where( $this->clave_primaria, intval($key) );
	}
}
