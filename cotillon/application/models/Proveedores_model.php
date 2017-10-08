<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	private function _santizar ( $nombre, $contacto, $id_locaidad ) {
		$data = [];
		$data['nombre_proveedor'] = htmlentities( $nombre );
		$data['contacto'] = htmlentities( $contacto );
		$data['id_localidad'] = intval( $id_localidad );

		return $data;
	}

	public function crear( $nombre, $contacto, $id_localidad ) {
		// Sanitizar entrada de datos
		$data = $this->_sanitizar( $nombre, $contacto, $id_localidad );

		// Ejecutar consulta
		$retorno = $this->db->insert( 'proveedores', $data );
		return $this->_return(); 
	}

	public function leer( $id ) {
		// Sanitizar entrada de datos
		$id = intval( $id );
		$this->db->join('localidades', 'localidades.id_localidad = proveedores.id_localidad');
		$this->db->where('id_proveedor', $id);
		return $this->db->get('proveedores')->row_array();
	}

	public function actualizar( $id, $nombre, $contacto, $id_localidad ) {
		// Sanitizar entrada de datos
		$data = $this->_sanitizar( $nombre, $contacto, $id_localidad );
		$id = intval( $id );

		// Ejecutar consulta
		$this->db->where( 'id_proveedor', $id );
		$this->db->update( 'proveedores', $data );
		return $this->_return($id);
	}

	public function eliminar( $id ) {
		// Sanitizar entrada de datos
		$id = intval( $id );
 		$data['soft_delete'] = $this->now();

		$this->db->where('id_proveedor', $id);
		$this->db->update('proveedores', $data);
		return $this->_return($id);
	}

	public function lista($trash = false) {
		$this->db->join('localidades', 'localidades.id_localidad = proveedores.id_localidad');
		if (!$trash) $this->db->where('soft_delete', null);
		return $this->db->get('proveedores')->result_array();
	}

	public function buscar( $campo, $valor ) {
		$campo = htmlentities($campo);
		$valor = intval($valor);
		if ( $campo === 'id_localidad' and $valor > 0 ) {
			$this->db->where($campo, $valor);
		}
		return $this->db->get('proveedores')->result_array();
	}
}
