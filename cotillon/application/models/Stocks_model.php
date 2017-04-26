<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stocks_model extends CI_Model {
  public function __construct()
  {
    parent::__construct();
  }

  public function lista()
  {
    return $this->db->get('stock')->result_array();
  }

  public function leer( $id )
  {
    $id = intval( $id );
    $this->db->where('id_stock', $id);
    return $this->db->get('stock')->row_array();
  }

  public function crear( $id_producto, $cantidad )
  {
    $id_producto = intval( $id_producto );
    $cantidad = floatval( $cantidad );
    $cantidad = $cantidad ? $cantidad : 0.0;
    $this->db->insert('stock', ['id_producto' => $id_producto]);
    return boolval( $this->db->affected_rows() );
  }

  public function actualizar( $id_producto, $cantidad )
  {
    $id_producto = intval( $id_producto );
    $cantidad = floatval( $cantidad );
    $cantidad = $cantidad ? $cantidad : 0.0;
    $this->db->where('id_producto', $id_producto);
    $this->db->update('stock', ['id_producto' => $id_producto, 'cantidad' => $cantidad ]);
    return boolval( $this->db->affected_rows() );
  }

  public function incrementar( $id_producto, $cantidad ) {
    $id_producto = intval($id_producto);
    $cantidad = floatval($cantidad);
    $cantidad = $cantidad ? $cantidad : 0.0;
    $this->db->where('id_producto', $id_producto);
    $aux = $this->db->get('stock')->row();
    $cantidad += $aux->cantidad;
    return $this->actualizar($id_producto, $cantidad);
  }

  public function reducir( $id_producto, $cantidad ) {
    $id_producto = intval($id_producto);
    $cantidad = floatval($cantidad);
    $cantidad = $cantidad ? $cantidad : 0.0;
    $this->db->where('id_producto', $id_producto);
    $aux = $this->db->get('stock')->row();
    if ( $aux->cantidad >= $cantidad ) {
      $cantidad -= $aux->cantidad;
      return $this->actualizar($id_producto, $cantidad);
    } else return FALSE;
  }
}
