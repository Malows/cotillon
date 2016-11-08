<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function crear( $nombre, $contacto, $id_localidad, $tipo_cliente ) {
		// Sanitizar entrada de datos
		$nombre = htmlentities( $nombre );
		$contacto = htmlentities( $contacto );
		$id_localidad = intval( $id_localidad );
		$tipo_cliente = htmlentities( $tipo_cliente );

		// Arreglo de datos
		$data = array(
			'nombre_cliente' => $nombre,
			'contacto' => $contacto,
			'id_localidad' => $id_localidad,
			'tipo_cliente' => $tipo_cliente
		);

		// Ejecutar consulta
		$this->db->insert( 'clientes', $data );
	}

	public function leer( $id ) {
		// Sanitizar entrada de datos
		$id = intval( $id );
		$this->db->where('id_cliente', $id);
		return $this->db->get('clientes')->result_array();
	}

	public function actualizar( $id, $nombre, $contacto, $id_localidad, $tipo_cliente  ) {
		// Sanitizar entrada de datos
		$id = intval( $id );
		$nombre = htmlentities( $nombre );
		$contacto = htmlentities( $contacto );
		$id_localidad = intval( $id_localidad );
		$tipo_cliente = htmlentities( $tipo_cliente );

		// Arreglo de datos
		$data = array(
			'nombre_cliente' => $nombre,
			'contacto' => $contacto,
			'id_localidad' => $id_localidad,
			'tipo_cliente' => $tipo_cliente
		);

		// Ejecutar consulta
		$this->db->where( 'id_cliente', $id );
		$this->db->update( 'clientes', $data );
		return boolval( $this->db->affected_rows() );
	}

	public function eliminar( $id ) {
		// Sanitizar entrada de datos
		$id = intval( $id );

		$this->db->where('id_cliente', $id);
		$this->db->delete('clientes');

		return boolval( $this->db->affected_rows() );
	}

	public function lista() {
		return $this->db->get('clientes')->result_array();
	}
}
