<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Instalar extends MY_controller {

	protected $config_validacion = [
		[
			'field' => 'superNombre',
			'label' => 'Nombre del super usuario',
			'rules' => 'required'
		], [
			'field' => 'superApellido',
			'label' => 'Apellido del super usuario',
			'rules' => 'required'
		], [
			'field' => 'superDni',
			'label' => 'DNI del super usuario',
			'rules' => 'required|is_natural_no_zero'
		], [
			'field' => 'superPassword',
			'label' => 'Constraseña del super usuario',
			'rules' => 'required'
		], [
			'field' => 'super-re-password',
			'label' => 'Contraseña del super usuario',
			'rules' => 'required|matches[superPassword]'
		], [
			'field' => 'superEmail',
			'label' => 'Email del super usuario',
			'rules' => 'required|valid_email'
		], [
			'field' => 'nombre',
			'label' => 'Nombre del administrador',
			'rules' => 'required'
		], [
			'field' => 'apellido',
			'label' => 'Apellido del administrador',
			'rules' => 'required'
		], [
			'field' => 'dni',
			'label' => 'DNI del administrador',
			'rules' => 'required|is_natural_no_zero'
		], [
			'field' => 'password',
			'label' => 'Constraseña del administrador',
			'rules' => 'required'
		], [
			'field' => 're-password',
			'label' => 'Contraseña del administrador',
			'rules' => 'required|matches[password]'
		], [
			'field' => 'email',
			'label' => 'Email del administrador',
			'rules' => 'required|valid_email'
		]
	];

	protected $config_validacion_messages = [
		'required' => '<strong>%s</strong> es un campo obligatorio.',
		'is_natural_no_zero' => '<strong>%s</strong> es un campo unicamente numérico.',
		'valid_email' => 'Ingrese una dirección de <strong>%s</strong> válida.',
		'matches' => 'La <strong>Contraseña</strong> y su <strong>Confirmación</strong> no coinsiden.'
	];

	public function __construct () {
		parent::__construct();
		$this->load->model('instalar_model');
		$this->form_validation->set_rules($this->config_validacion);
		foreach ($this->config_validacion_messages as $key => $value) {
			$this->form_validation->set_message($key, $value);
		}
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
			redirect(base_url('/'), 'refresh');
		} else {
			$this->load->view('includes/instalador');
		}
	}
}
