<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function crear( $id_cliente, $total ) {
		// Sanitizar entrada de datos
		$id_cliente = intval( $id_cliente );
		$total = floatval($total);

		// Arreglo de datos
		$data = [
			'id_cliente' => $id_cliente,
			'total' => $total
		];

		// Ejecutar consulta
		return $this->db->insert( 'ventas', $data );
	}

	public function leer( $id ) {
		// Sanitizar entrada de datos
		$id = intval( $id );
		$this->db->where('id_venta', $id);
		return $this->db->get('ventas')->result_array();
	}

	public function actualizar( $id, $id_cliente, $total ) {
		// Sanitizar entrada de datos
		$id = intval( $id );
		$id_cliente = intval( $id_cliente );
		$total = floatval( $total );

		// Arreglo de datos
		$data = array(
      'id_cliente' => $id_cliente,
			'total' => $total
		);

		// Ejecutar consulta
		$this->db->where( 'id_venta', $id );
		$this->db->update( 'ventas', $data );
		return boolval( $this->db->affected_rows() );
	}

	public function eliminar( $id ) {
		// Sanitizar entrada de datos
		$id = intval( $id );

		$this->db->where('id_venta', $id);
		$this->db->delete('ventas');

		return boolval( $this->db->affected_rows() );
	}

	public function lista( $paginacion = 1 ) {

    $desde = ($paginacion - 1) * 100;
    // $hasta = $paginacion * 100; REDUNDANTE

    $this->db->order_by('fecha', 'DESC');
    $this->db->limit( 100, $desde ); // $hasta - $desde = 1*100 = 100 siempre
		return $this->db->get('ventas')->result_array();
	}

	public function last_id() {
		return intval( $this->db->query('SELECT LAST_INSERT_ID();')->row_array()['LAST_INSERT_ID()'] );
	}
}
