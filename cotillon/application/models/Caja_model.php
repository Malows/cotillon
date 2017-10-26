<?php defined('BASEPATH') || exit('No direct script access allowed');

class Caja_model extends MY_Model {
	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'caja';
		$this->clave_primaria = 'id_caja';
	}

	protected function sanitizar ( Array $data ) {
		$datos = [];
		$datos['fecha_apertura'] = htmlentities( $data['fecha_apertura'] );
		$datos['monto_apertura'] = floatval( $data['monto_apertura'] );
		$datos['fecha_cierre'] = array_key_exists('fecha_cierre', $data) ? htmlentities( $data['fecha_cierre'] ) : null;
		$datos['monto_estimado_cierre'] = array_key_exists('monto_estimado_cierre', $data) ? htmlentities( $data['monto_estimado_cierre'] ) : null;
		$datos['monto_real_cierre'] = array_key_exists('monto_real_cierre', $data) ? htmlentities( $data['monto_real_cierre'] ) : null;
		return $datos;
	}

	private function ventasEntreFechas ($desde, $hasta) {
		$this->db->where("fecha >=", $desde);
		$this->db->where("fecha <=", $hasta);
		return $this->db->get('ventas')->result_array();
	}

	public function lista ($pagina = 1) {
		$desde = ($pagina - 1) * 100;
		$this->db->order_by('fecha_apertura', 'DESC');
		$this->db->limit( 100, $desde );
		return $this->get()->result_array();
	}

	public function contar_total () {
		return $this->db->count_all('caja');
	}

	public function lista_cajas_abiertas() {
		$this->where(['fecha_cierre' => null]);
		return $this->get()->result_array();
	}

	public function abrir_caja ($monto) {
		$cajas = $this->lista_cajas_abiertas();
		if (count($cajas)) return false;
		$this->db->insert($this->nombre_tabla, ['monto_apertura' => floatval($monto)]);
		return $this->db->insert_id();
	}

	public function estimar_caja () {
		$cajas = $this->lista_cajas_abiertas();
		if (count($cajas) != 1) {
			return false;
		} else {
			$cajas = $cajas[0];
		}

		$ventas = $this->ventasEntreFechas( $cajas['fecha_apertura'], $this->now() );

		$totalDeVenta = array_reduce($ventas, function ($carry, $element) {
			return $carry + $element['total'];
		}, $cajas['monto_apertura']);

		$cajas['monto_estimado_cierre'] = $totalDeVenta;

		$this->db->where('id_caja', $cajas['id_caja']);
		$this->db->update('caja', $cajas);
		return $cajas;
	}

	public function cerrar_caja ($monto) {
		$caja = $this->lista_cajas_abiertas();

		if (count($caja) != 1) {
			return false;
		} else {
			$caja = $caja[0];
		}

		$caja['monto_real_cierre'] = floatval($monto);
		$caja['fecha_cierre'] = $this->now();

		$this->update($caja['id_caja'], $caja);
		return $caja;
	}

}
