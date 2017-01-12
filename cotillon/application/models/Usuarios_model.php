<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function crear( $nombre, $apellido, $email, $dni, $contrasenia, $es_admin ) {
		//sanitización de datos
		$nombre = htmlentities($nombre);
		$apellido = htmlentities($apellido);
		$email = htmlentities($email);
		$dni = intval($dni);
		$contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT); //https://secure.php.net/manual/es/function.password-hash.php
		$es_admin = boolval($es_admin);

		//carga de datos a array
		$data = array(
				'nombre' => $nombre,
				'apellido' => $apellido,
				'email' => $email,
				'dni' => $dni,
				'password' => $contrasenia,
				'es_admin' => $es_admin
		);

		// inserción de los datos
		$this->db->insert( 'usuarios', $data );
	}

	public function leer_por_id( $id ) {
		$id = intval($id);
		return $this->db->get_where('usuarios', array('id_usuario' => $id))->row_array();
	}

	public function leer_por_dni( $dni ) {
		$dni = intval($dni);
		return $this->db->get_where('usuarios', array('dni' => $dni))->row_array();
	}

	public function actualizar($id ,$nombre, $apellido, $email, $dni, $es_admin ) {
		//sanitizacion de datos
		$id = intval($id);
		$nombre = htmlentities($nombre);
		$apellido = htmlentities($apellido);
		$email = htmlentities($email);
		$dni = intval($dni);
		$es_admin = boolval($es_admin);

		//creo arreglo de datos
		$data = array(
				'nombre' => $nombre,
				'apellido' => $apellido,
				'email' => $email,
				'dni' => $dni,
				'es_admin' => $es_admin
		);

		//consultas
		$this->db->where('id_usuario', $id);
		$this->db->update('usuarios', $data);
		return boolval( $this->db->affected_rows() );
	}

	public function eliminar( $id ) {
		//sanitizacion de datos
		$id = intval($id);
		$fecha_de_despido = date("Y-m-d H:i:s");

		$this->db->where('id_usuario', $id);
		$this->db->update('usuarios', array('fecha_fin' => $fecha_de_despido));
	}

	public function lista() {
		return $this->db->get('usuarios')->result_array();
	}

	public function cotejar( $dni, $contrasenia ) {
		//sanitizar datos
		$dni = intval($dni);

		$this->db->where('dni', $dni);
		$query = $this->db->get('usuarios');

		if ( $query->num_rows() === 1 ) {
			//existe usuario
			$aux = $query->row_array();
			//contraseña
			$verificacion = password_verify($contrasenia, $aux['password']);

			if ( $verificacion ) {
				//habilitado
				if ( ! boolval( $aux['fecha_fin'] ) ) {

					return $aux;//usuario ok

				} else {
					return FALSE; //no esta habilitado
				}
			} else {
				return FALSE; //contraseña incorrecta
			}
		} else {
			return FALSE; //usuario no existe
		}
	}
}
