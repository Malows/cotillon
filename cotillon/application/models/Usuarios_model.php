<?php defined('BASEPATH') || exit('No direct script access allowed');

class Usuarios_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'usuarios';
		$this->clave_primaria = 'id_usuario';
		$this->soft_delete = 'fecha_fin';
	}

	protected function sanitizar( Array $data ) {
		if (array_key_exists('nombre', $data)) $data['nombre'] = htmlentities($data['nombre']);
		if (array_key_exists('apellido', $data)) $data['apellido'] = htmlentities($data['apellido']);
		if (array_key_exists('email', $data)) $data['email'] = htmlentities($data['email']);
		if (array_key_exists('dni', $data)) $data['dni'] = intval($data['dni']);
		if (array_key_exists('id_tipo_usuario', $data)) $data['id_tipo_usuario'] = intval($data['id_tipo_usuario']);
		if (array_key_exists('modo_restore', $data)) $data['modo_restore'] = boolval($data['modo_restore']);
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

		$user['modo_restore'] = false;
		$this->where($user['id_usuario']);
		$this->db->update($this->nombre_tabla, $user);
		
		return $user; // usuario ok
	}
}
