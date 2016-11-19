<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function __construct() {
		parent::__construct();
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

				$this->load->model('usuarios_model');
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
					$vw = array( 'error' => "La combinación de usaurio y contraseña es incorrecta" );
					$this->load->view( 'includes/header.php' );
					//mandamos el error de no coincidencia
					$this->load->view( 'pages/inicio/login_view.php', $vw ); //$vw['error'] => $error
					$this->load->view( 'includes/footer');
				}
			}

		} else { // estoy registrado
			$this->load->view('includes/header');
			$this->load->view('pages/inicio/prueba');
			$this->load->view('includes/footer');
		}
	}

	public function salir() {
		$this->session->sess_destroy();
		$this->load->view('pages/inicio/logout_view');
	}
}
