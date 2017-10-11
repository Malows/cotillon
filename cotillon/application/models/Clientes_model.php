<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'clientes';
		$this->clave_primaria = 'id_cliente';
	}

	protected function sanitizar( Array $data ) {
		$datos = [];
		$datos['nombre_cliente'] = htmlentities( $data['nombre_cliente'] );
		$datos['telefono'] = htmlentities( $data['telefono'] );
		$datos['email'] = htmlentities( $data['email'] );
		$datos['direccion'] = htmlentities( $data['direccion'] );
		$datos['id_localidad'] = intval( $data['id_localidad'] );
		$datos['tipo_cliente'] = htmlentities( $data['tipo_cliente'] );

		return $datos;
	}

	public function leer( $id, $trash = false ) {
		if (!$trash) $this->withTrashed();
		$this->db->join('localidades', 'localidades.id_localidad = clientes.id_localidad');
		return $this->get( $id )->row_array();
	}


	public function lista($trash = false) {
		$this->db->join('localidades', 'localidades.id_localidad = clientes.id_localidad');
		if (!$trash) $this->db->where('soft_delete', null);
		return $this->get()->result_array();
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
		return $this->get()->result_array();
	}
}
