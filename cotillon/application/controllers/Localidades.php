<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Localidades extends MY_Controller {
  protected  $config_validacion = null;

  public function __construct() {
    parent::__construct();
    $this->load->model('localidades_model');
    $this->config_validacion = [
        [
          'field' => 'nombre_localidad',
          'label' => 'nombre_localidad',
          'rules' => 'required'
        ], [
          'field' => 'barrio',
          'label' => 'Barrio',
          'rules' => 'required'
        ]
      ];
  }

  public function index () {
    $usuario = $this->logged();
    $data = [
      'localidades' => $this->localidades_model->lista(),
      'id_usuario_logueado' => $usuario['id_usuario'],
      'es_admin_usuario_logueado' => $usuario['id_tipo_usuario'] < 3
    ];
    $this->render([['pages/localidades/index', $data]]);
  }

  public function crear () {
    $usuario = $this->logged();
    $this->form_validation->set_rules($this->config_validacion);
    $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio. " );

    $data = ['localidades' => $this->localidades_model->lista()];

    if ($this->form_validation->run()) {
      // Envié el formulario
      $payload = [
        'nombre_localidad' => $this->security->xss_clean( $this->input->post('nombre_localidad') ),
        'barrio' => $this->security->xss_clean( $this->input->post('barrio') )
      ];
      $last_id = $this->localidades_model->crear( $payload );
      $this->registrar($last_id, $usuario, 17, 'localidades');
      $data['exito'] = TRUE;
      $data['localidad']['nombre_localidad'] = htmlentities($this->input->post('nombre_localidad'));
      $data['localidad']['barrio'] = htmlentities($this->input->post('barrio'));
    }
    $this->render([['pages/localidades/crear', $data]]);
  }

  public function actualizar ($id) {
    $usuario = $this->loggedAndAdmin();

    $this->form_validation->set_rules($this->config_validacion);
    $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio. " );

    $data = ['localidad' => $this->localidades_model->leer( $id )];

    if ($this->form_validation->run()) {
      $data['exito'] = TRUE;
      $data['localidad']['nombre_localidad'] = htmlentities($this->input->post('nombre_localidad'));
      $data['localidad']['barrio'] = htmlentities($this->input->post('barrio'));

      $payload = [
        'nombre_localidad' => $this->security->xss_clean( $this->input->post('nombre_localidad') ),
        'barrio' => $this->security->xss_clean( $this->input->post('barrio') )
      ];
      $last_id = $this->localidades_model->actualizar( $id, $payload );
      $this->registrar($last_id, $usuario, 18, 'localidades');
    }
    $this->render([['pages/localidades/actualizar', $data]]);
  }

  public function ver_clientes ($id = 0) {
    $this->logged();
    $this->load->model('clientes_model');
    $data = [
      'localidad' => $this->localidades_model->leer($id),
      'clientes' => $this->clientes_model->buscar('id_localidad', $id),
    ];
    $this->render([['pages/localidades/ver_clientes', $data]]);
  }

  public function ver_proveedores ($id = 0) {
    $this->logged();
    $this->load->model('proveedores_model');
    $data = [
      'localidad' => $this->localidades_model->leer($id),
      'proveedores' => $this->proveedores_model->buscar('id_localidad', $id),
    ];
    $this->render([['pages/localidades/ver_proveedores', $data]]);
  }
}
