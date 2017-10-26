<?php defined('BASEPATH') || exit('No direct script access allowed');

class Usuarios_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'usuarios';
		$this->clave_primaria = 'id_usuario';
		$this->soft_delete = 'fecha_fin';
	}

	protected function sanitizar( Array $data ) {
		$data['nombre'] = htmlentities($data['nombre']);
		$data['apellido'] = htmlentities($data['apellido']);
		$data['email'] = htmlentities($data['email']);
		$data['dni'] = intval($data['dni']);
		$data['es_admin'] = boolval($data['es_admin']);
		return $data;
	}


	public function crear( Array $data ) {
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		$this->insert($data);
		return $this->_return();
	}


	public function leer_por_id( $id ) {
		return $this->get(['id_usuario' => intval($id)])->row_array();
	}


	public function leer_por_dni( $dni ) {
		return $this->get(['dni' => intval($dni)])->row_array();
	}


	public function cotejar( $dni, $password ) {
		$user = $this->get(['dni' => $dni])->row_array();
		$verificacion = password_verify($password, $user['password']);

		if ( !boolval($user) ) return FALSE; // usuario no existe
		if ( !$verificacion ) return FALSE; // contraseña incorrecta
		if ( $user['fecha_fin'] ) return FALSE; // usuario no habilitado

		return $user; // usuario ok
	}
}
