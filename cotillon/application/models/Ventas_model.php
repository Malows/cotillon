<?php defined('BASEPATH') || exit('No direct script access allowed');

class Ventas_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'ventas';
		$this->clave_primaria = 'id_venta';
	}

	protected function sanitizar ( Array $data ) {
		$data['id_cliente'] = intval( $data['id_cliente'] );
		$data['total'] = floatval( $data['total'] );
		return $data;
	}

	public function leer( $id, $trash = false ) {
		if ($trash) $this->withTrashed();
		$this->db->join('clientes', 'clientes.id_cliente = ventas.id_cliente');
		return $this->get($id)->row_array();
	}

	public function crear( Array $data ) {
		$this->db->trans_start();
		$this->insert( $data );
		return $this->_return();
	}

	public function actualizar( $id, Array $data ) {
		$this->update( $id, $data );
		$this->db->trans_complete();
		return $this->_return($id);
	}

	public function eliminar( $id ) {
		$this->where($id);
		$this->db->delete('ventas');
		return $this->_return( $id );
	}

	public function lista( $paginacion = 1 ) {

    $desde = ($paginacion - 1) * 100;
    // $hasta = $paginacion * 100; REDUNDANTE

    $this->db->order_by('fecha', 'DESC');
		$this->db->join('clientes', 'clientes.id_cliente = ventas.id_cliente');
    $this->db->limit( 100, $desde ); // $hasta - $desde = 1*100 = 100 siempre
		return $this->db->get('ventas')->result_array();
	}

	public function hasta($fecha = '') {
		if ( $fecha ) {
			$this->db->order_by('fecha', 'DESC');
			$this->db->join('clientes', 'clientes.id_cliente = ventas.id_cliente');
			$this->db->where( 'fecha >=', $fecha->format('Y-m-d H:i:S') ); // $hasta - $desde = 1*100 = 100 siempre
			return $this->db->get('ventas')->result_array();
		} else return $this->lista();
	}

	public function last_id() {
		return intval( $this->db->query('SELECT LAST_INSERT_ID();')->row_array()['LAST_INSERT_ID()'] );
	}

	public function contar_total()
	{
		return $this->db->count_all('ventas');
	}
}
