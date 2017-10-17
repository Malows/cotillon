<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('usuarios_model');
		$this->load->model('productos_model');
		$this->load->model('ventas_model');
		date_default_timezone_set ( 'America/Argentina/Buenos_Aires' );
		setlocale(LC_ALL, "es_AR");
	}

	protected function entreFechas ($fecha, $desde, $hasta) {
		return $fecha >= $desde && $fecha < $hasta;
	}

	protected function sumatoria (Array $input) {
		return array_reduce($input, function($car, $cur){return $car + $cur['total'];}, 0);
	}

	protected function treeShaking (Array $input) {
		$aux = [];
		for ($i=0, $j=1 ; $i < 12; $i++, $j++) {
			$push_array = [];
			$desde = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
			$hasta = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
			$desde->modify("-$j month");
			$desde->setDate( intval( $desde->format('Y') ), intval( $desde->format('m') ), 1 );
			$desde->setTime(0,0,0);

			$hasta->modify("-$i month");
			$hasta->setDate( intval( $hasta->format('Y') ), intval( $hasta->format('m') ), 1 );
			$hasta->setTime(0,0,0);

			foreach ($input as $key => $venta) {
				$fecha_venta =  DateTime::createFromFormat('Y-m-d H:i:s', $venta['fecha']);

				if ( $this->entreFechas($fecha_venta, $desde, $hasta) ) {
					$push_array[] = $venta;
					unset( $input[$key] );
				}
			}

			$aux[] = [
				'fecha' => $desde,
				'total' => $this->sumatoria($push_array)
			];
		}
		return $aux;
	}

	public function index() {
		if ( ! $this->session->userdata('esta_logeado') ) { // no estoy logeado

			$this->form_validation->set_rules( 'usuario', 'Usuario', 'required' );
			$this->form_validation->set_rules( 'contrasenia', 'Contrase&ntilde;a', 'required' );
			$this->form_validation->set_message( 'required', "El campo '%s' es obligatorio" );

			if ( $this->form_validation->run() === FALSE ) { //  llegue por primera vez
				$this->load->view('includes/header');
				$this->load->view('pages/inicio/login_view');
				$this->load->view('includes/footer');
			} else { // algo salio mal y me muestrar el error
				$usuario = $this->security->xss_clean( $this->input->post('usuario') );
				$pass = /*$this->security->xss_clean( */$this->input->post('contrasenia') /*)*/;


				$aux = $this->usuarios_model->cotejar($usuario, $pass);

				if ( $aux !== FALSE ) {
					//si coinciden, creo la sesion
					$data = array(
							"id_usuario" => $aux['id_usuario'],
							"usuario" => $aux['nombre'],
							"es_admin" => $aux['es_admin'],
							"esta_logeado" => TRUE
					);
					$this->session->set_userdata( $data );
					//redireccion
					$this->index();
				}
				if ( $aux === FALSE ) {
					$vw = array( 'error' => "La combinación de usuario y contraseña es incorrecta" );
					$this->load->view( 'includes/header.php' );
					//mandamos el error de no coincidencia
					$this->load->view( 'pages/inicio/login_view.php', $vw ); //$vw['error'] => $error
					$this->load->view( 'includes/footer');
				}
			}

		} else { // estoy registrado

			$unAnioAtras = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
      $unAnioAtras->modify('-1year');
			$unAnioAtras->setDate( intval( $unAnioAtras->format('Y') ), intval( $unAnioAtras->format('m') ), 1 );
			$unAnioAtras->setTime(0,0,0);
			$ventas = $this->treeShaking( $this->ventas_model->hasta($unAnioAtras) );

			$data = [
				'alertas' => $this->productos_model->lista_alertas(),
				'ventas' => array_reverse($ventas),
				'caja' => $this->caja->lista_cajas_abiertas()
			 ];
			$this->load->view('includes/header');
			$this->load->view('pages/inicio/index', $data);
			$this->load->view('includes/footer');
		}
	}

	public function salir() {
		$this->session->sess_destroy();
		$this->load->view('pages/inicio/logout_view');
	}
}
