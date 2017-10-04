<?php defined('BASEPATH') || exit('No direct script access allowed');

class Productos_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  private function _filtradoCampo ($campo, $tabla) {
    $habilitados = $this->db->where("soft_delete", null)->select($campo)->get($tabla)->result_array();
    return array_map( function ($elem) use ($campo) { return intval($elem[$campo]); },$habilitados);
  }

  public function lista_alertas()
  {
    $categoriasHabilitadas = $this->_filtradoCampo('id_categoria', 'categorias_producto');
    $proveedoresHabilitados = $this->_filtradoCampo('id_proveedor', 'proveedores');

    $this->db->where_in('productos.id_categoria', $categoriasHabilitadas);
    $this->db->where_in('productos.id_proveedor', $proveedoresHabilitados);

    $this->db->where('alerta >= cantidad');
    $this->db->where('soft_delete',null);
    return $this->db->get('productos')->result();
  }

  public function lista() {

    $categoriasHabilitadas = $this->_filtradoCampo('id_categoria', 'categorias_producto');
    $proveedoresHabilitados = $this->_filtradoCampo('id_proveedor', 'proveedores');

    $this->db->where_in('productos.id_categoria', $categoriasHabilitadas);
    $this->db->where_in('productos.id_proveedor', $proveedoresHabilitados);

    $this->db->join('proveedores', 'proveedores.id_proveedor = productos.id_proveedor');
    $this->db->join('categorias_producto', 'categorias_producto.id_categoria = productos.id_categoria');
    $this->db->where('productos.soft_delete', null);
    return $this->db->get('productos')->result_array();
  }

  public function lista_limpia()
  {
    $categoriasHabilitadas = $this->_filtradoCampo('id_categoria', 'categorias_producto');
    $proveedoresHabilitados = $this->_filtradoCampo('id_proveedor', 'proveedores');

    $this->db->where_in('productos.id_categoria', $categoriasHabilitadas);
    $this->db->where_in('productos.id_proveedor', $proveedoresHabilitados);

    $this->db->where('soft_delete',null);
    return $this->db
      ->select('id_producto AS `id`, nombre, cantidad AS `stock`, precio')
      ->get('productos')->result_array();
  }

  public function lista_limpia_proveedores()
  {
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

  public function crear( $id_proveedor, $nombre, $precio, $id_categoria, $descripcion, $unidad ) {
    // Sanitizar datos
    $id_proveedor = intval( $id_proveedor );
    $nombre = htmlentities( $nombre );
    $precio = floatval( $precio );
    $id_categoria = intval( $id_categoria );
    $descripcion = htmlentities( $descripcion );
    $unidad = htmlentities( $unidad );
    $data = [
      'id_proveedor' => $id_proveedor,
      'nombre' => $nombre,
      'precio' => $precio,
      'id_categoria' => $id_categoria,
      'descripcion' => $descripcion,
      'unidad' => $unidad
    ];
    $retorno = $this->db->insert('productos', $data);
    return $retorno ? $this->db->insert_id() : false;
  }

  public function leer( $id ) {
    // Sanitizar datos
    $id = intval( $id );
    $this->db->join('proveedores', 'proveedores.id_proveedor = productos.id_proveedor');
    $this->db->join('categorias_producto', 'categorias_producto.id_categoria = productos.id_categoria');
    $this->db->where('id_producto', $id);
    return $this->db->get('productos')->row_array();
  }

  public function actualizar( $id, $id_proveedor, $nombre, $precio, $id_categoria, $descripcion, $unidad ) {
    // Sanitizar datos
    $id = intval( $id );
    $id_proveedor = intval( $id_proveedor );
    $nombre = htmlentities( $nombre );
    $precio = floatval( $precio );
    $id_categoria = intval( $id_categoria );
    $descripcion = htmlentities( $descripcion );
    $unidad = htmlentities( $unidad );

    $data = [
      'id_proveedor' => $id_proveedor,
      'nombre' => $nombre,
      'precio' => $precio,
      'id_categoria' => $id_categoria,
      'descripcion' => $descripcion,
      'unidad' => $unidad
    ];

    // Ejecutar consulta
		$this->db->where( 'id_producto', $id );
		$this->db->update( 'productos', $data );
		return boolval( $this->db->affected_rows() );
  }

  public function eliminar( $id ) {
    // Sanitizar datos
    $id = intval( $id );

    $this->db->where('id_producto', $id);
    $data = [];
    $data['soft_delete'] = date('Y-m-d H:i:s');
    $this->db->update('productos', $data);
		// $this->db->delete('productos');
		return boolval( $this->db->affected_rows() );
  }


  public function incrementar( $id_producto, $cantidad ) {
    $id_producto = intval($id_producto);
    $this->db->where('id_producto', $id_producto);
    $aux = $this->db->get('productos')->row_array();
    $aux['cantidad'] += abs(floatval($cantidad)) ;
    unset($aux['id_producto']);

    $this->db->where('id_producto', $id_producto);
    return $this->db->update('productos',$aux);
  }

  public function reducir( $id_producto, $cantidad ) {
    $id_producto = intval($id_producto);
    $this->db->where('id_producto', $id_producto);
    $aux = $this->db->get('productos')->row_array();

    $cantidad = abs(floatval($cantidad));

    if ( $aux['cantidad'] >= $cantidad ) {
      $aux['cantidad'] -= $cantidad;
      unset( $aux['id_producto'] );

      $this->db->where('id_producto', $id_producto);
      return $this->db->update('productos',$aux);
    } else return FALSE;
  }

  public function productos_de_proveedor($id)
  {
    $this->db->where('id_proveedor', intval($id));
    $this->db->where('soft_delete', null);
    return $this->db->get('productos')->result_array();
  }
}
