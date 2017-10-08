<?php defined('BASEPATH') || exit('No direct script access allowed');

class Detalles_venta_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	private function _sanitizar( $id_venta, $id_producto, $cantidad, $precio_unitario ) {
		$data = [];
		$data['id_venta'] = intval($id_venta);
		$data['id_producto'] = intval($id_producto);
		$data['cantidad_venta'] = floatval($cantidad);
		$data['precio_unitario'] = floatval($precio_unitario);

		return $data;
	}

	public function crear( $id_venta, $id_producto, $cantidad, $precio_unitario ) {
		// Sanitizar entrada de datos
		$data = $this->_sanitizar( $id_venta, $id_producto, $cantidad, $precio_unitario );

		// Ejecutar consulta
		$this->db->insert( 'detalles_venta', $data );
	}

	public function batch_insertion( $lineas ) {
		return $this->db->insert_batch('detalles_venta', $lineas);
	}

	public function leer( $id_venta, $id_producto ) {
		// Sanitizar entrada de datos
		$id_venta = intval( $id_venta );
		$id_producto = intval( $id_producto );

		$this->db->where('id_venta', $id_venta);
		$this->db->where('id_producto', $id_producto);
		return $this->db->get('detalles_venta')->result_array();
	}

	public function actualizar( $id_venta, $id_producto, $cantidad, $precio_unitario  ) {
		// Sanitizar entrada de datos
		$data = $this->_sanitizar( $id_venta, $id_producto, $cantidad, $precio_unitario );

		// Ejecutar consulta
		$this->db->where('id_venta', $data['id_venta']);
		$this->db->where('id_producto', $data['id_producto']);

		$this->db->update( 'detalles_venta', $data );
		return boolval( $this->db->affected_rows() );
	}

	public function eliminar( $id_venta, $id_producto ) {
		// Sanitizar entrada de datos
		$id_venta = intval( $id_venta );
		$id_producto = intval( $id_producto );

		$this->db->where('id_venta', $id_venta);
		$this->db->where('id_producto', $id_producto);
		$this->db->delete('detalles_venta');

		return boolval( $this->db->affected_rows() );
	}

	public function lista() {
		return $this->db->get('detalles_venta')->result_array();
	}

	public function buscar_por_venta( $id_venta ) {
		$id_venta = intval( $id_venta );
		$this->db->where('id_venta', $id_venta);
		$this->db->select('detalles_venta.id_producto, detalles_venta.id_venta, detalles_venta.cantidad_venta, detalles_venta.precio_unitario, productos.nombre');
		$this->db->join('productos', 'productos.id_producto = detalles_venta.id_producto');
		return $this->db->get('detalles_venta')->result_array();
	}
}
