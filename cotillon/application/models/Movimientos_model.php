<?php defined('BASEPATH') || exit('No direct script access allowed');

class Movimientos_model extends MY_Model {

  public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'movimientos';
		$this->clave_primaria = 'id_movimiento';
	}

  protected function withTrashed(){}

	protected function sanitizar( Array $data ) {
		$data['monto'] = floatval(abs($data['monto']));
		$data['id_razon_movimiento'] = intval($data['id_razon_movimiento']);
		return $data;
	}

  protected function sanitizar_razon( Array $data ) {
		$data['multiplicador'] = intval($data['multiplicador']);
		$data['descripcion'] = htmlentities($data['descripcion']);
		return $data;
	}

  public function crear_razon( $data ) {
    $data = $this->sanitizar_razon($data);
    $this->db->insert('razones_movimientos', $data);
    return $this->_return();
  }

  public function lista($trash = false) {
    $this->db->select('id_movimiento, descripcion, (multiplicador * monto) AS monto');
    $this->db->join('razones_movimientos', 'razones_movimientos.id_razon_movimiento = movimientos.id_razon_movimiento');
    return $this->db->get('movimientos')->result_array();
  }

  public function lista_razones() {
    return $this->db->get('razones_movimientos')->result_array();
  }

  public function actualizar($id, Array $data) {
    $multiplicador = $data['monto'] > 0 ? 1 : $data['monto'] < 0 ? -1 : 0;
    $this->db->where('id_razon_movimiento', $data['id_razon_movimiento']);
    $this->db->update('razones_movimientos', ['multiplicador' => $multiplicador]);
    $this->update($id, $data);
    return $this->_return($id);
  }

  public function actualizar_razon($id, $data) {
    $data = $this->sanitizar_razon($data);
    $this->db->where('id_razon_movimiento', intval($id));
    $this->db->update('razones_movimientos', $data);
    return $this->_return($id);
  }
}
