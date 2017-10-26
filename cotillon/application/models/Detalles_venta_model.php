<?php defined('BASEPATH') || exit('No direct script access allowed');

class Detalles_venta_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'detalles_venta';
		$this->clave_primaria = '';
	}

	protected function sanitizar( Array $data ) {
		$datos = [];
		$datos['cantidad_venta'] = floatval($data['cantidad_venta']);
		$datos['precio_unitario'] = floatval($data['precio_unitario']);
		return $datos;
	}

	public function batch_insertion( $lineas ) {
		return $this->db->insert_batch('detalles_venta', $lineas);
	}

	public function buscar_por_venta( $id_venta ) {
		$id_venta = intval( $id_venta );
		$tabla = $this->nombre_tabla;
		$this->db->select("$tabla.id_producto, $tabla.id_venta, $tabla.cantidad_venta, $tabla.precio_unitario, productos.nombre");
		$this->db->join('productos', 'productos.id_producto = detalles_venta.id_producto');
		return $this->get(['id_venta' => $id_venta])->result_array();
	}
}
