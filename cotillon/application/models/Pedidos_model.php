<?php defined('BASEPATH') || exit('No direct script access allowed');

class Pedidos_model extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  public function lista($force = false) {
    $this->db->join('proveedores', 'proveedores.id_proveedor = pedidos.id_proveedor');
    if (!$force) $this->db->where('pedidos.soft_delete',null);
    return $this->db->get('pedidos')->result_array();
  }

  public function listalimpia() {
    $this->db->join('proveedores', 'proveedores.id_proveedor = pedidos.id_proveedor');
    return $this->db->get('pedidos')->result_array();
  }

  public function eliminar( $id ) {
    // Sanitizar datos
    $id = intval( $id );

    $this->db->where('id_pedidos', $id);
    $data['soft_delete'] = date('Y-m-d H:i:s');
    $this->db->update('pedidos', $data);
    return boolval( $this->db->affected_rows() );
  }


}
