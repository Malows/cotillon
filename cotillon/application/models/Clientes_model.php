<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	private function _sanitizar( $nombre, $telefono, $email, $id_localidad, $direccion, $tipo_cliente ) {
		$data = [];
		$data['nombre'] = htmlentities( $nombre );
		$data['telefono'] = htmlentities( $telefono );
		$data['email'] = htmlentities( $email );
		$data['direccion'] = htmlentities( $direccion );
		$data['id_localidad'] = intval( $id_localidad );
		$data['tipo_cliente'] = htmlentities( $tipo_cliente );

		return $data;
	}

	public function crear( $nombre, $telefono, $email, $id_localidad, $direccion, $tipo_cliente ) {
		// Sanitizar entrada de datos
		$data = $this->_sanitizar( $nombre, $telefono, $email, $id_localidad, $direccion, $tipo_cliente );

		// Ejecutar consulta
		$retorno = $this->db->insert( 'clientes', $data );
		return $this->_return();
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
		$data = $this->_sanitizar( $nombre, $telefono, $email, $id_localidad, $direccion, $tipo_cliente );
		$id = intval( $id );

		// Ejecutar consulta
		$this->db->where( 'id_cliente', $id );
		$this->db->update( 'clientes', $data );
		return $this->_return( $id );
	}

	public function eliminar( $id ) {
		// Sanitizar entrada de datos
		$id = intval( $id );
		$data['soft_delete'] = $this->now();

		$this->db->where('id_cliente', $id);
		$this->db->update('clientes', $data);
		return $this->_return( $id );
	}

	public function lista($trash = false) {
		$this->db->join('localidades', 'localidades.id_localidad = clientes.id_localidad');
		if (!$trash) $this->db->where('soft_delete', null);
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

	public function lista_limpia() {
		$this->db->where('soft_delete',null);
		$this->db->select('id_cliente AS `id`, nombre_cliente AS `nombre`');
		return $this->db->get('clientes')->result_array();
	}
}
