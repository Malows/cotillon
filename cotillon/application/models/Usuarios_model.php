<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'usuarios';
		$this->clave_primaria = 'id_usuario';
	}

	private function _sanitizar( $nombre, $apellido, $email, $dni, $es_admin ) {
		$data = [];
		$data['nombre'] = htmlentities($nombre);
		$data['apellido'] = htmlentities($apellido);
		$data['email'] = htmlentities($email);
		$data['dni'] = intval($dni);
		$data['es_admin'] = boolval($es_admin);

		return $data;
	}

	public function crear( $nombre, $apellido, $email, $dni, $contrasenia, $es_admin ) {
		$data = $this->_sanitizar( $nombre, $apellido, $email, $dni, $es_admin );
		$data['contrasenia'] = password_hash($contrasenia, PASSWORD_DEFAULT); //https://secure.php.net/manual/es/function.password-hash.php

		$retorno =$this->insert( 'usuarios', $data );
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

	public function actualizar($id ,$nombre, $apellido, $email, $dni, $es_admin ) {
		$data = $this->_sanitizar( $nombre, $apellido, $email, $dni, $es_admin );

		$this->update($id, $data);
		return $this->_resume($id);
	}

	public function eliminar( $id ) {
		$data['fecha_fin'] = $this->now();

		$this->update($id, $data);
		return $this->_return($id);
	}

	public function lista($trash = false) {
		if (!$trash) $this->db->where('fecha_fin', null);
		return $this->get()->result_array();
	}

	public function lista_activos()
	{
		$this->db->where('fecha_fin', null);
		return $this->get()->result_array();
	}

	public function cotejar( $dni, $contrasenia ) {
		$user = $this->leer_por_dni($dni);

		if (!boolval($user)) return FALSE; // usuario no existe

		//contraseña
		$verificacion = password_verify($contrasenia, $user['password']);

		if ( !$verificacion ) return FALSE; // contraseña incorrecta
		if ( !boolval($user['fecha_fin']) ) return FALSE; // usuario no habilitado

		return $aux;//usuario ok
	}
}
