<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

  protected $config_validacion;
  protected $mensajes_validacion;
  protected $error_delimiter;

  public function __construct() {
    parent::__construct();
    $this->load->model('clientes_model');
    $this->config_validacion = [
      [
        'field' => 'nombre_cliente',
        'label' => 'Nombre del cliente',
        'rules' => 'required|alpha_numeric_spaces'
      ], [
        'field' => 'contacto',
        'label' => 'Contacto del cliente',
        'rules' => ''
      ], [
        'field' => 'tipo_cliente',
        'label' => 'Tipo del cliente',
        'rules' => 'required|alpha_numeric_spaces'
      ], [
        'field' => 'id_localidad',
        'label' => 'Localidad',
        'rules' => 'required|is_natural_no_zero'
      ]
    ];


    $this->mensajes_validacion = [
      'required' => '<strong>%s</strong> es un campo obligatorio.',
      'alpha_numeric_spaces' => '<strong>%s</strong> solo admite caracteres alfabéticos.',
      'is_natural_no_zero' => '<strong>%s</strong> fue ingresada erroneamente'
    ];

    $this->error_delimiter = [
      '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      '</div>'
    ];
  }

  public function index()
  {
    if (! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $data = [
        'clientes' => $this->clientes_model->lista(),
        'es_admin_usuario_logueado' => $this->session->userdata('es_admin')
      ];
      $this->load->view('includes/header');
      $this->load->view('pages/clientes/index', $data);
      $this->load->view('includes/footer');
    }
  }

  public function crear()
  {
    if (! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $this->form_validation->set_rules($this->config_validacion);
      foreach ($this->mensajes_validacion as $key => $value)
        $this->form_validation->set_message($key, $value);
      $this->form_validation->set_error_delimiters($this->error_delimiter[0],$this->error_delimiter[1]);

      $this->load->model('localidades_model');

      $data = [ 'localidades' => $this->localidades_model->lista() ];

      if( $this->form_validation->run() ) {
        $data['cliente']['nombre_cliente'] = $this->security->xss_clean( $this->input->post('nombre_cliente') );
        $data['cliente']['contacto'] = $this->security->xss_clean( $this->input->post('contacto') );
        $data['cliente']['id_localidad'] = $this->security->xss_clean( $this->input->post('id_localidad') );
        $data['cliente']['tipo_cliente'] = $this->security->xss_clean( $this->input->post('tipo_cliente') );
        $this->clientes_model->crear(
          $data['cliente']['nombre_cliente'],
          $data['cliente']['contacto'],
          $data['cliente']['id_localidad'],
          $data['cliente']['tipo_cliente']
        );
        $data['exito'] = TRUE;
      } else {
        unset($data['exito'], $data['cliente']);
      }
      $this->load->view('includes/header');
      $this->load->view('pages/clientes/crear', $data);
      $this->load->view('includes/footer');
    }
  }

  public function actualizar( $id )
  {
    if (! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $this->form_validation->set_rules($this->config_validacion);
      foreach ($this->mensajes_validacion as $key => $value)
        $this->form_validation->set_message($key, $value);
      $this->form_validation->set_error_delimiters($this->error_delimiter[0],$this->error_delimiter[1]);

      $this->load->model('localidades_model');

      $data = [
        'localidades' => $this->localidades_model->lista(),
        'cliente' => $this->clientes_model->leer($id)
       ];

      if( $this->form_validation->run() ) {
        $data['cliente']['nombre_cliente'] = $this->security->xss_clean( $this->input->post('nombre_cliente') );
        $data['cliente']['contacto'] = $this->security->xss_clean( $this->input->post('contacto') );
        $data['cliente']['id_localidad'] = $this->security->xss_clean( $this->input->post('id_localidad') );
        $data['cliente']['tipo_cliente'] = $this->security->xss_clean( $this->input->post('tipo_cliente') );
        $this->clientes_model->actualizar(
          $id,
          $data['cliente']['nombre_cliente'],
          $data['cliente']['contacto'],
          $data['cliente']['id_localidad'],
          $data['cliente']['tipo_cliente']
        );
        $data['exito'] = TRUE;
      } else {
        unset($data['exito']);
      }
        $this->load->view('includes/header');
        $this->load->view('pages/clientes/actualizar', $data);
        $this->load->view('includes/footer');
    }
  }

  public function ver( $id )
  {
    if (! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {

    }
  }

  public function eliminar( $id )
  {
    if (! $this->session->userdata('esta_logeado') and $this->session->userdata('es_admin') ) {
      show_404();
    } else {

    }
  }
}
