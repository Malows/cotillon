<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends MY_Controller
{

  protected $config_validacion = null;

  function __construct() {
    parent::__construct();
    $this->load->model('proveedores_model');

    $this->config_validacion = [
      [
        'field' => 'nombre_proveedor',
        'label' => 'Nombre del proveedor',
        'rules' => 'required|alpha_numeric_spaces'
      ], [
        'field' => 'localidad',
        'label' => 'Localidad',
        'rules' => 'required|numeric'
      ], [
        'field' => 'contacto',
        'label' => 'Contacto',
        'rules' => 'required'
      ]
    ];
  }

  public function index () {
    $usuario = $this->logged();
    $modoRestore = boolval($usuario['modo_restore']);
    $data = [
      'proveedores' => $this->proveedores_model->lista($modoRestore),
      'es_admin_usuario_logueado' => $this->session->userdata('es_admin') ];

    $this->render([[$modoRestore ? 'pages/proveedores/index_restore' : 'pages/proveedores/index', $data]]);
  }

  public function crear () {
    $usuario = $this->loggedAndAdmin();
    $this->form_validation->set_rules($this->config_validacion);

    //mensajes de validaciones
    $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio.");
    $this->form_validation->set_message('alpha_numeric_spaces', "<strong>%s</strong> solo admite caracteres alfabéticos.");
    $this->form_validation->set_message('numeric', "<strong>%s</strong> es un campo unicamente numérico.");

    $this->load->model('localidades_model');
    $data['localidades'] = $this->localidades_model->lista();

    if ($this->form_validation->run()) {

      $payload = [
        'nombre_proveedor' => $this->security->xss_clean( $this->input->post('nombre_proveedor')),
        'contacto' => $this->security->xss_clean( $this->input->post('contacto')),
        'id_localidad' => $this->security->xss_clean( $this->input->post('localidad')) ];

      $last_id = $this->proveedores_model->crear($payload);
      $this->registrar($last_id, $usuario, 5, 'proveedores');

      $data['exito'] = TRUE;
      $data['proveedor'] = htmlentities($this->input->post('nombre_proveedor'));
    }
    $this->render([['pages/proveedores/crear', $data]]);
  }

  public function ver ($id) {
    $this->logged();
    $this->load->model('productos_model');
    $data = [
      'proveedor' => $this->proveedores_model->leer($id),
      'productos' => $this->productos_model->productos_de_proveedor($id) ];
    $this->render([['pages/proveedores/ver', $data]]);
  }

  public function actualizar ($id) {
    $usuario = $this->loggedAndAdmin();
    $this->form_validation->set_rules($this->config_validacion);

    //mensajes de validaciones
    $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio.");
    $this->form_validation->set_message('alpha_numeric_spaces', "<strong>%s</strong> solo admite caracteres alfabéticos.");
    $this->form_validation->set_message('numeric', "<strong>%s</strong> es un campo unicamente numérico.");

    $this->load->model('localidades_model');
    $data = [
      'localidades' => $this->localidades_model->lista(),
      'proveedor' => $this->proveedores_model->leer($id) ];

    if ($this->form_validation->run()) {
      $data['proveedor']['id_proveedor'] = $this->security->xss_clean( $id );
      $data['proveedor']['nombre_proveedor'] = $this->security->xss_clean( $this->input->post('nombre_proveedor'));
      $data['proveedor']['contacto'] = $this->security->xss_clean( $this->input->post('contacto'));
      $data['proveedor']['id_localidad'] = $this->security->xss_clean( $this->input->post('localidad'));
      $data['exito'] = true;

      $payload=[
        'nombre_proveedor'=> $this->security->xss_clean( $this->input->post('nombre_proveedor')),
        'contacto'=> $this->security->xss_clean( $this->input->post('contacto')),
        'id_localidad'=> $this->security->xss_clean( $this->input->post('localidad')) ];

      $last_id = $this->proveedores_model->actualizar( $id, $payload );
      $this->registrar($last_id, $usuario, 6, 'proveedores');
    }
    $this->render([['pages/proveedores/actualizar', $data]]);
  }

  public function eliminar ($id = 0) {
    $usuario = $this->loggedAndAdmin();
    $this->proveedores_model->eliminar($id);
    $this->registrar($id, $usuario, 7, 'proveedores');
    redirect('/proveedores', 'refresh');
  }

  public function restaurar( $id ) {
    $usuario = $this->loggedAndAdmin();
    $this->proveedores_model->restaurar($id);
    redirect(base_url('/proveedores'), 'refresh');
  }
}
