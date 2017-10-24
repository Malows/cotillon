<?php defined('BASEPATH') || exit('No direct script access allowed');

class Proveedores_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'proveedores';
		$this->clave_primaria = 'id_proveedor';
	}


	protected function sanitizar ( Array $data ) {
		$data['nombre_proveedor'] = htmlentities( $data['nombre_proveedor'] );
		$data['contacto'] = htmlentities( $data['contacto'] );
		$data['id_localidad'] = intval( $data['id_localidad'] );
		return $data;
	}


	public function leer( $id, $trash = false ) {
		$this->db->join('localidades', 'localidades.id_localidad = proveedores.id_localidad');
		return $this->get($id)->row_array();
	}


	public function lista($trash = false) {
		$this->db->join('localidades', 'localidades.id_localidad = proveedores.id_localidad');
		if (!$trash) $this->db->where('soft_delete', null);
		return $this->get()->result_array();
	}


	public function lista_limpia() {
		$this->db->select('nombre_proveedor, id_proveedor');
		$this->get()->result_array();
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
