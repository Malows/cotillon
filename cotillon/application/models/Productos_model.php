<?php defined('BASEPATH') || exit('No direct script access allowed');

class Productos_model extends MY_Model {

	function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'productos';
		$this->clave_primaria = 'id_producto';
	}


	protected function sanitizar ( Array $data ) {
		$datos = [];

		if (array_key_exists('id_proveedor', $data))
			$datos['id_proveedor'] = intval( $data['id_proveedor'] );

		if (array_key_exists('nombre', $data))
			$datos['nombre'] = htmlentities( $data['nombre'] );

		if (array_key_exists('precio', $data))
			$datos['precio'] = floatval( $data['precio'] );

		if (array_key_exists('id_categoria', $data))
			$datos['id_categoria'] = intval( $data['id_categoria'] );

		if (array_key_exists('descripcion', $data))
			$datos['descripcion'] = htmlentities( $data['descripcion'] );

		if (array_key_exists('unidad', $data))
			$datos['unidad'] = htmlentities( $data['unidad'] );

		if (array_key_exists('alerta', $data))
			$datos['alerta'] = floatval( $data['alerta'] );

		if (array_key_exists('cantidad', $data))
			$datos['cantidad'] = abs(floatval( $data['cantidad'] ));

		return $datos;
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

		if (!$trash) $this->withTrashed();
		else $this->db->select('productos.id_producto, productos.id_proveedor,
			productos.nombre, productos.precio, productos.id_categoria,
			productos.descripcion, productos.cantidad, productos.unidad,
			productos.alerta, productos.soft_delete,
			nombre_proveedor, nombre_categoria, contacto, id_localidad
		');
		$this->db->join('proveedores', 'proveedores.id_proveedor = productos.id_proveedor');
		$this->db->join('categorias_producto', 'categorias_producto.id_categoria = productos.id_categoria');
		return $this->get()->result_array();
	}


	public function lista_limpia() {
		$categoriasHabilitadas = $this->_filtradoCampo('id_categoria', 'categorias_producto');
		$proveedoresHabilitados = $this->_filtradoCampo('id_proveedor', 'proveedores');

		$this->db->where_in('productos.id_categoria', $categoriasHabilitadas);
		$this->db->where_in('productos.id_proveedor', $proveedoresHabilitados);

		$this->db->where('soft_delete', null);
		$this->db->select('id_producto AS `id`, nombre, cantidad AS `stock`, precio');
		return $this->get()->result_array();
	}


	public function lista_limpia_pedido() {
		$categoriasHabilitadas = $this->_filtradoCampo('id_categoria', 'categorias_producto');
		$proveedoresHabilitados = $this->_filtradoCampo('id_proveedor', 'proveedores');

		$this->db->where_in('productos.id_categoria', $categoriasHabilitadas);
		$this->db->where_in('productos.id_proveedor', $proveedoresHabilitados);

		$this->db->where('soft_delete',null);
		$this->db->select('id_producto AS `id`, nombre, id_proveedor');
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
		if (!$trash) {
			$this->withTrashed();
			$this->db->select('productos.id_producto, productos.id_proveedor,
			productos.nombre, productos.precio, productos.id_categoria,
			productos.descripcion, productos.cantidad, productos.unidad,
			productos.alerta, productos.soft_delete,
			nombre_proveedor, nombre_categoria, contacto');
		}
		$this->db->join('proveedores', 'proveedores.id_proveedor = productos.id_proveedor');
		$this->db->join('categorias_producto', 'categorias_producto.id_categoria = productos.id_categoria');

		return $this->get( $id )->row_array();
	}


	public function incrementar( $id_producto, $cantidad ) {
		$aux = $this->get($id_producto)->row_array();
		$aux['cantidad'] += abs(floatval($cantidad));

		$data['cantidad'] = $aux['cantidad'];
		$this->update($id_producto, $data);
		return $this->_return($id_producto);
	}


	public function reducir( $id_producto, $cantidad ) {
		$aux = $this->get($id_producto)->row_array();
		$cantidad = abs(floatval($cantidad));

		if ( $aux['cantidad'] >= $cantidad ) {
			$aux['cantidad'] -= $cantidad;

			$data['cantidad'] = $aux['cantidad'];
			$this->update($id_producto, $data);
			return $this->_return($id_producto);
		} else return FALSE;
	}


	public function productos_de_proveedor($id) {
		$this->db->where('id_proveedor', intval($id));
		$this->db->where('soft_delete', null);
		return $this->db->get('productos')->result_array();
	}

	public function top_productos() {
	// CREATE VIEW digest_top_venta_productos AS
	// SELECT productos.id_producto, productos.nombre, SUM(detalles_venta.cantidad_venta) AS total_venta
  // FROM productos JOIN detalles_venta ON productos.id_producto = detalles_venta.id_producto
  // GROUP BY productos.id_producto ORDER BY total_venta DESC;
	$this->db->limit(5,0);
	return $this->db->get('digest_top_venta_productos')->result_array();
	}

	public function rankingc($id){
		$this->db->select('clientes.nombre_cliente');
		$this->db->select_sum('detalles_venta.cantidad_venta');

		$this->db->from('clientes');
		$this->db->join('ventas', 'ventas.id_cliente = clientes.id_cliente');
		$this->db->join('detalles_venta', 'detalles_venta.id_venta = ventas.id_venta');

		$this->db->where('detalles_venta.id_producto', $id);

		$this->db->group_by("clientes.nombre_cliente");
		$this->db->order_by("detalles_venta.cantidad_venta", "DESC");
		$query = $this->db->get();
		return $query->result_array();
	}

	public function rankingp($id){
		$this->db->select('proveedores.nombre_proveedor');
		$this->db->select_sum('detalles_pedido.cantidad');

		$this->db->from('proveedores');
		$this->db->join('pedidos', 'pedidos.id_proveedor = proveedores.id_proveedor');
		$this->db->join('detalles_pedido', 'detalles_pedido.id_pedido = pedidos.id_pedido');

		$this->db->where('detalles_pedido.id_producto', $id);

		$this->db->group_by('proveedores.nombre_proveedor');
		$this->db->order_by('detalles_pedido.cantidad', 'DESC');
		$query = $this->db->get();
		return $query->result_array();

	}
}
