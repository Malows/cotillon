<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detalles_venta_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function crear( $id_venta, $id_producto, $cantidad, $precio_unitario ) {
		// Sanitizar entrada de datos
		$id_venta = intval( $id_venta );
		$id_producto = intval( $id_producto );
		$cantidad = intval( $cantidad );
		$precio_unitario = floatval( $precio_unitario );

    // Consulta de precio del producto
    // $this->db->where('id_producto', $id_producto);
    // $aux_producto = $this->db->get('productos')->row_array();
		// Paso yo los datos

    // Array de datos
		$data = [
			'id_venta' => $id_venta,
			'id_producto' => $id_producto,
			'cantidad' => $cantidad,
			'precio_unitario' => $precio_unitario
		];

		// Ejecutar consulta
		$this->db->insert( 'detalles_venta', $data );
	}

	public function batch_insertion( $lineas )
	{
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
    $id_venta = intval( $id_venta );
		$id_producto = intval( $id_producto );
		$cantidad = intval( $cantidad );
    $precio_unitario = floatval( $precio_unitario );

		// Arreglo de datos
    $data = array(
			'id_venta' => $id_venta,
			'id_producto' => $id_producto,
			'cantidad' => $cantidad,
			'precio_unitario' => $precio_unitario
		);

		// Ejecutar consulta
    $this->db->where('id_venta', $id_venta);
    $this->db->where('id_producto', $id_producto);
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
		$this->db->join('productos', 'productos.id_producto = detalles_venta.id_producto');
		return $this->db->get('detalles_venta')->result_array();
	}
}
