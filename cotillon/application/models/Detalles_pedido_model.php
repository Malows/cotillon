<?php defined('BASEPATH') || exit('No direct script access allowed');

class Detalles_pedido_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'detalles_pedido';
		$this->clave_primaria = '';
	}

	protected function sanitizar( Array $data ) {
		$datos = [];
		$datos['cantidad'] = floatval($data['cantidad']);
		$datos['precio_unitario'] = floatval($data['precio_unitario']);
		return $datos;
	}

	public function batch_insertion( $lineas ) {
		return $this->db->insert_batch($this->nombre_tabla, $lineas);
	}

	public function buscar_por_pedido( $id_pedido ) {
		$id_venta = intval( $id_pedido );
		$tabla = $this->nombre_tabla;
		$this->db->select("$tabla.id_producto, $tabla.id_pedido, $tabla.cantidad, $tabla.precio_unitario, productos.nombre");
		$this->db->join('productos', "productos.id_producto = $tabla.id_producto");
		return $this->get(['id_pedido' => $id_pedido])->result_array();
	}
}
