<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function crear( $nombre, $telefono, $email, $id_localidad, $direccion, $tipo_cliente ) {
		// Sanitizar entrada de datos
		$nombre = htmlentities( $nombre );
		$telefono = htmlentities( $telefono );
		$email = htmlentities( $email );
		$direccion = htmlentities( $direccion );
		$id_localidad = intval( $id_localidad );
		$tipo_cliente = htmlentities( $tipo_cliente );

		// Arreglo de datos
		$data = [
			'nombre_cliente' => $nombre,
			'telefono' => $telefono,
			'direccion' => $direccion,
			'email' => $email,
			'id_localidad' => $id_localidad,
			'tipo_cliente' => $tipo_cliente
		];

		// Ejecutar consulta
		$this->db->insert( 'clientes', $data );
	}

	public function leer( $id ) {
		// Sanitizar entrada de datos
		$id = intval( $id );
		$this->db->where('id_cliente', $id);
		$this->db->join('localidades', 'localidades.id_localidad = clientes.id_localidad');
		return $this->db->get('clientes')->row_array();
	}

	public function actualizar( $id, $nombre, $telefono, $email, $id_localidad, $direccion, $tipo_cliente  ) {
		// Sanitizar entrada de datos
		$id = intval( $id );
		$nombre = htmlentities( $nombre );
		$telefono = htmlentities( $telefono );
		$email = htmlentities( $email );
		$direccion = htmlentities( $direccion );
		$id_localidad = intval( $id_localidad );
		$tipo_cliente = htmlentities( $tipo_cliente );

		// Arreglo de datos
		$data = [
			'nombre_cliente' => $nombre,
			'telefono' => $telefono,
			'direccion' => $direccion,
			'email' => $email,
			'id_localidad' => $id_localidad,
			'tipo_cliente' => $tipo_cliente
		];

		// Ejecutar consulta
		$this->db->where( 'id_cliente', $id );
		$this->db->update( 'clientes', $data );
		return boolval( $this->db->affected_rows() );
	}

	public function eliminar( $id ) {
		// Sanitizar entrada de datos
		$id = intval( $id );

		$this->db->where('id_cliente', $id);
		$data = [];
    $data['soft_delete'] = date('Y-m-d H:i:s');
		$this->db->update('clientes', $data);
		return boolval( $this->db->affected_rows() );
	}

	public function lista() {
		$this->db->join('localidades', 'localidades.id_localidad = clientes.id_localidad');
		$this->db->where('soft_delete', null);
		return $this->db->get('clientes')->result_array();
	}

	public function buscar( $campo, $valor ) {
		// 'id_localidad' // 1

		// www.example.com/localidades/ver_clientes/1
		// www.example.com/clientes?id_localidad=1 (index de cliente)

		// www.../clientes?tipo_cliente=1 (index de cliente)
		$campo = htmlentities($campo);
		$valor = intval($valor);
		if ( $campo === 'id_localidad' or $campo === 'tipo_cliente' and $valor > 0 ) {
			$this->db->where($campo, $valor);
		}
		return $this->db->get('clientes')->result_array();
	}
}
