<?php define('BASEPATH') || exit('No direct script access allowed');

class Instalar extends CI_controller {
	public function __construct () {
		parent::__construct();
		$this->load->model('instalar_model');
	}

	public function index () {
		$cantidadDeUsuarios = $this->instalar_model->cantidad_de_usuarios();
		if ($cantidadDeUsuarios !== 0) redirect('/', 'refresh');

		if ($this->form_validation->run()) {

			$this->instalar_model->first_run();

			$superUser = $this->security->xss_clean( $this->input->post('superNombre') );
			$superApellido = $this->security->xss_clean( $this->input->post('superApellido') );
			$superEmail = $this->security->xss_clean( $this->input->post('superEmail') );
			$superDNI = $this->security->xss_clean( $this->input->post('superDni') );
			$superPassword = $this->security->xss_clean( $this->input->post('superPassword') );

			$user = $this->security->xss_clean( $this->input->post('nombre') );
			$apellido = $this->security->xss_clean( $this->input->post('apellido') );
			$email = $this->security->xss_clean( $this->input->post('email') );
			$DNI = $this->security->xss_clean( $this->input->post('dni') );
			$password = $this->security->xss_clean( $this->input->post('password') );

			$this->instalar_model->super_usuario([
				'nombre' => $superUser,
				'apellido' => $superApellido,
				'email' => $superEmail,
				'dni' => $superDNI,
				'password' => $superPassword
			]);

			$this->instalar_model->administrador([
				'nombre' => $user,
				'apellido' => $apellido,
				'email' => $email,
				'dni' => $DNI,
				'password' => $password
			]);

		} else {
			$this->load->view('includes/instalador');
		}
	}
}
