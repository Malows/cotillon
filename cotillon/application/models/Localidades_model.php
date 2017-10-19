<?php defined('BASEPATH') || exit('No direct script access allowed');

class Localidades_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'localidades';
		$this->clave_primaria = 'id_localidad';
	}

	protected function sanitizar( Array $data ) {
		$data['nombre_localidad'] = htmlentities($data['nombre_localidad']);
		$data['barrio'] = htmlentities($data['barrio']);
		return $data;
	}

	protected function withTrashed() {} // No tengo soft_delete
}
