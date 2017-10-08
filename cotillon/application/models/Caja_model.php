<?php defined('BASEPATH') || exit('No direct script access allowed');

class Caja_model extends MY_Model {
	public function __construct() {
		parent::__construct();
		$this->nombre_tabla = 'caja';
		$this->clave_primaria = 'id_caja';
	}

	private function ventasEntreFechas ($desde, $hasta) {
		$this->db->where_in('fecha', [ $desde, $hasta ]);
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
		$this->db->where('fecha_cierre', null);
		return $this->db->get('caja')->result_array();
	}

	public function abrir_caja ($monto) {
		$cajas = $this->lista_cajas_abiertas();
		if (count($cajas)) return false;
		$this->insert(['monto_apertura' => floatval($monto)]);
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
