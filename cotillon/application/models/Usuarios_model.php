<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'usuarios';
		$this->clave_primaria = 'id_usuario';
	}

	protected function sanitizar( Array $data ) {
		$data['nombre'] = htmlentities($data['nombre']);
		$data['apellido'] = htmlentities($data['apellido']);
		$data['email'] = htmlentities($data['email']);
		$data['dni'] = intval($data['dni']);
		$data['es_admin'] = boolval($data['es_admin']);

		return $data;
	}

	protected function withTrashed () {
		$this->where(['fecha_fin' => null]);
	}

	public function crear( Array $data ) {
		$data['contrasenia'] = password_hash($data['contrasenia'], PASSWORD_DEFAULT);
		$this->insert($data);
		return $this->_return();
	}

	public function leer_por_id( $id ) {
		$id = intval($id);
		return $this->db->get_where('usuarios', ['id_usuario' => $id])->row_array();
	}

	public function leer_por_dni( $dni ) {
		$dni = intval($dni);
		return $this->db->get_where('usuarios', ['dni' => $dni])->row_array();
	}
	
	public function lista_activos() {
		$usuarios = $this->lista();
		echo "<br><br><br>\n\n\n";
		var_dump($this->db->last_query());
		return $usuarios;
	}

	public function cotejar( $dni, $contrasenia ) {
		$user = $this->get(['dni' => $dni]);
		$verificacion = password_verify($contrasenia, $user['password']);

		if ( !boolval($user) ) return FALSE; // usuario no existe
		if ( !$verificacion ) return FALSE; // contraseña incorrecta
		if ( $user['fecha_fin'] ) return FALSE; // usuario no habilitado

		return $user; // usuario ok
	}
}
