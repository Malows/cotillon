<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('usuarios_model');
		$this->load->model('productos_model');
		$this->load->model('ventas_model');
		$this->load->model('categorias_producto_model');
		date_default_timezone_set ( 'America/Argentina/Buenos_Aires' );
		setlocale(LC_ALL, "es_AR");
	}

	private function parsearFecha( $ventas ) {
		return array_map(function ($x) {
			$año = $x['año'];
			$mes = strlen($x['mes']) == 2 ? $x['mes'] : '0'.$x['mes'];
			$x['fecha'] = "$año-$mes-01";
			$x['total'] = intval($x['total']);
	 		unset($x['año'], $x['mes']);
		 	return $x;
		}, $ventas);
	}

	private function pluck($array, $key, $value) {
		return array_reduce($array, function ($acc, $item) use ($key, $value) {
			$acc[ $item[$key] ] = $item[$value];
			return $acc;
		}, []);
	}

	public function index() {
		if (!$this->session->userdata('esta_logeado')) { // no estoy logeado

			$this->form_validation->set_rules( 'usuario', 'Usuario', 'required' );
			$this->form_validation->set_rules( 'contrasenia', 'Contrase&ntilde;a', 'required' );
			$this->form_validation->set_message( 'required', "El campo '%s' es obligatorio" );

			if (!$this->form_validation->run()) $this->render([['pages/inicio/login_view', []]]);
			else {
				$usuario = $this->security->xss_clean( $this->input->post('usuario') );
				$pass = $this->input->post('contrasenia');

				$aux = $this->usuarios_model->cotejar($usuario, $pass);

				if ($aux !== FALSE) {
					$data = [
							"user" => $aux,
							"id_usuario" => $aux['id_usuario'],
							"usuario" => $aux['nombre'],
							"es_admin" => $aux['id_tipo_usuario'] < 3,
							"esta_logeado" => TRUE
					];
					$this->session->set_userdata( $data );
					$this->index();
				} else {
					$vw = ['error' => "La combinación de usuario y contraseña es incorrecta"];
					$this->render([['pages/inicio/login_view', $vw]]);
				}
			}
		} else {
			$ventas = $this->ventas_model->ventas_por_mes();
			$ventas = $this->parsearFecha( $ventas );
			$ventas = $this->pluck($ventas, 'fecha', 'total');
			$topProductos = $this->productos_model->top_productos();
			$topProductos = $this->pluck($topProductos, 'nombre', 'total_venta');

			$data = [
				'alertas' => $this->productos_model->lista_alertas(),
				'ventas' => array_reverse($ventas),
				'caja' => $this->caja->lista_cajas_abiertas(),
				'datos_ventas_categorias' => $this->categorias_producto_model->cantidad_categoria(),
				'top_productos' => $topProductos
			 ];
			$this->render([['pages/inicio/index', $data]]);
		}
	}

	public function salir() {
		$this->session->sess_destroy();
		$this->load->view('pages/inicio/logout_view');
	}
}
