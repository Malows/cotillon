<?php 
class MY_Model extends CI_Model {

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
}


