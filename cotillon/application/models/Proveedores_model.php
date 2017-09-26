<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function crear( $nombre, $contacto, $id_localidad ) {
		// Sanitizar entrada de datos
		$nombre = htmlentities( $nombre );
		$contacto = htmlentities( $contacto );
		$id_localidad = intval( $id_localidad );

		// Arreglo de datos
		$data = array(
			'nombre_proveedor' => $nombre,
			'contacto' => $contacto,
			'id_localidad' => $id_localidad
		);

		// Ejecutar consulta
		$retorno = $this->db->insert( 'proveedores', $data );
		return $retorno ? $this->db->insert_id() : false;
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
		$id = intval( $id );
		$nombre = htmlentities( $nombre );
		$contacto = htmlentities( $contacto );
		$id_localidad = intval( $id_localidad );

		// Arreglo de datos
		$data = [
			'nombre_proveedor' => $nombre,
			'contacto' => $contacto,
			'id_localidad' => $id_localidad
		];

		// Ejecutar consulta
		$this->db->where( 'id_proveedor', $id );
		$this->db->update( 'proveedores', $data );
		return boolval( $this->db->affected_rows() );
	}

	public function eliminar( $id ) {
		// Sanitizar entrada de datos
		$id = intval( $id );

		$this->db->where('id_proveedor', $id);
		$data = [];
    $data['soft_delete'] = date('Y-m-d H:i:s');
    $this->db->update('proveedores', $data);
		return boolval( $this->db->affected_rows() );
	}

	public function lista() {
		$this->db->join('localidades', 'localidades.id_localidad = proveedores.id_localidad');
		$this->db->where('soft_delete', null);
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
