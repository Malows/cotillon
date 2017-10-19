<?php defined('BASEPATH') || exit('No direct script access allowed');

class Productos_model extends MY_Model {

	function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'productos';
		$this->clave_primaria = 'id_producto';
	}
	

	protected function sanitizar ( Array $data ) {
		$data['id_proveedor'] = intval( $data['id_proveedor'] );
		$data['nombre'] = htmlentities( $data['nombre'] );
		$data['precio'] = floatval( $data['precio'] );
		$data['id_categoria'] = intval( $data['id_categoria'] );
		$data['descripcion'] = htmlentities( $data['descripcion'] );
		$data['unidad'] = htmlentities( $data['unidad'] );
		$data['alerta'] = floatval( $data['alerta'] );
		$data['cantidad'] = abs(floatval( $data['cantidad'] ));
		return $data;
	}


	private function _filtradoCampo ($campo, $tabla) {
		$habilitados = $this->db->where("soft_delete", null)->select($campo)->get($tabla)->result_array();
		return array_map( function ($elem) use ($campo) {
			return intval($elem[$campo]);
		}, $habilitados);
	}


	public function lista_alertas() {
		$categoriasHabilitadas = $this->_filtradoCampo('id_categoria', 'categorias_producto');
		$proveedoresHabilitados = $this->_filtradoCampo('id_proveedor', 'proveedores');

		$this->db->where_in('productos.id_categoria', $categoriasHabilitadas);
		$this->db->where_in('productos.id_proveedor', $proveedoresHabilitados);

		$this->db->where('alerta >= cantidad');
		$this->db->where('soft_delete',null);
		return $this->get()->result();
	}


	public function lista( $trash = false ) {
		$categoriasHabilitadas = $this->_filtradoCampo('id_categoria', 'categorias_producto');
		$proveedoresHabilitados = $this->_filtradoCampo('id_proveedor', 'proveedores');

		$this->db->where_in('productos.id_categoria', $categoriasHabilitadas);
		$this->db->where_in('productos.id_proveedor', $proveedoresHabilitados);

		$this->db->join('proveedores', 'proveedores.id_proveedor = productos.id_proveedor');
		$this->db->join('categorias_producto', 'categorias_producto.id_categoria = productos.id_categoria');
		if (!$trash) $this->withTrashed();
		return $this->get()->result_array();
	}


	public function lista_limpia() {
		$categoriasHabilitadas = $this->_filtradoCampo('id_categoria', 'categorias_producto');
		$proveedoresHabilitados = $this->_filtradoCampo('id_proveedor', 'proveedores');

		$this->db->where_in('productos.id_categoria', $categoriasHabilitadas);
		$this->db->where_in('productos.id_proveedor', $proveedoresHabilitados);

		$this->db->where('soft_delete',null);
		$this->db->select('id_producto AS `id`, nombre, cantidad AS `stock`, precio');
		return $this->get()->result_array();
	}


	public function lista_limpia_proveedores() {
		$categoriasHabilitadas = $this->_filtradoCampo('id_categoria', 'categorias_producto');
		$proveedoresHabilitados = $this->_filtradoCampo('id_proveedor', 'proveedores');

		$this->db->where_in('productos.id_categoria', $categoriasHabilitadas);
		$this->db->where_in('productos.id_proveedor', $proveedoresHabilitados);

		$this->db->join('proveedores', 'proveedores.id_proveedor = productos.id_proveedor');
		$this->db->where('soft_delete',null);
		return $this->db
			->select('id_producto AS `id`, nombre, cantidad AS `stock`, precio, id_proveedor, proveedores.nombre_proveedor')
			->get('productos')->result_array();
	}


	public function leer( $id, $trash = false ) {
		if ($trash) $this->withTrashed();
		$this->db->join('proveedores', 'proveedores.id_proveedor = productos.id_proveedor');
		$this->db->join('categorias_producto', 'categorias_producto.id_categoria = productos.id_categoria');
		return $this->get( $id )->row_array();
	}


	public function incrementar( $id_producto, $cantidad ) {
		$aux = $this->get($id_producto)->row_array();
		$aux['cantidad'] += abs(floatval($cantidad));
		unset($aux['id_producto']);

		$this->update($id_producto, $aux);
		return $this->_return($id_producto);
	}


	public function reducir( $id_producto, $cantidad ) {
		$aux = $this->get($id_producto)->row_array();
		$cantidad = abs(floatval($cantidad));

		if ( $aux['cantidad'] >= $cantidad ) {
			$aux['cantidad'] -= $cantidad;
			unset( $aux['id_producto'] );

			$this->update($id_producto, $aux);
			return $this->_return($id_producto);
		} else return FALSE;
	}


	public function productos_de_proveedor($id) {
		$this->db->where('id_proveedor', intval($id));
		$this->db->where('soft_delete', null);
		return $this->db->get('productos')->result_array();
	}
}
