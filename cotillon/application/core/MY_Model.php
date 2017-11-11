<?php
class MY_Model extends CI_Model {

	protected $nombre_tabla;
	protected $clave_primaria;
	protected $soft_delete = 'soft_delete';

	public function __contruct() {
		parent::__contruct();
	}

	protected function sanitizar (Array $data) {
		// si no sobrescribo el metodo, va a lanzar un error la base de datos
		// para mantenerme al tanto de que no llegó ningun dato.
		return [];
	}

	protected function _return ( $id = null ) {
		if ( $id === null ) return $this->db->insert_id();
		else if ( boolval( ( $this->db->affected_rows() ) ) ) return $id;
		else return false;
	}

	protected function now () {
		return (new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');
	}

	protected function withTrashed () {
		$nombre = $this->nombre_tabla. '.' .$this->soft_delete;
		$this->where([$nombre => null]);
	}

	protected function get($key = null) {
		if ($key) $this->where($key);
		return $this->db->get( $this->nombre_tabla );
	}

	protected function update($key, $data) {
		$this->where( $key );
		$data = $this->sanitizar( $data );
		return $this->db->update( $this->nombre_tabla, $data );
	}

	protected function delete ( $key ) {
		$data[$this->soft_delete] = $this->now();
		$this->where($key);
		return $this->db->update($this->nombre_tabla, $data);
	}

	protected function destroy( $key ) {
		$this->where($key);
		$this->db->delete($this->nombre_tabla);
	}

	protected function insert( $data ) {
		$data = $this->sanitizar($data);
		return $this->db->insert( $this->nombre_tabla, $data );
	}

	protected function where( $key ) {
		if (is_array($key))
			foreach ($key as $clave => $valor) {
				$this->db->where( htmlentities($clave), $valor );
			}
		else
			$this->db->where( $this->clave_primaria, intval($key) );
	}

	public function crear ( Array $data ) {
		$this->insert($data);
		return $this->_return();
	}

	public function actualizar ( $id, Array $data ) {
		$this->update($id, $data);
		return $this->_return();
	}

	public function eliminar ( $key, $erase = false ) {
		if ($erase) $this->destroy($key);
		else $this->delete($key);
		return $this->_return();
	}

	public function leer ( $id, $trash = false ) {
		if (!$trash) $this->withTrashed();
		return $this->get($id)->row_array();
	}

	public function lista ( $trash = false ) {
		if (!$trash) $this->withTrashed();
		return $this->get()->result_array();
	}
}
