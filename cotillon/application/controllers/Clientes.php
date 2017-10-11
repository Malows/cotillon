<?php defined('BASEPATH') || exit('No direct script access allowed');

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
        'field' => 'telefono',
        'label' => 'Teléfono del cliente',
        'rules' => ''
      ], [
        'field' => 'tipo_cliente',
        'label' => 'Tipo del cliente',
        'rules' => 'required|alpha_numeric_spaces'
      ], [
        'field' => 'id_localidad',
        'label' => 'Localidad',
        'rules' => 'required|is_natural_no_zero'
      ], [
        'field' => 'direccion',
        'label' => 'Dirección',
        'rules' => ''
      ], [
        'field' => 'email',
        'label' => 'Correo Electrónico',
        'rules' => 'valid_email'
      ]
    ];


    $this->mensajes_validacion = [
      'required' => '<strong>%s</strong> es un campo obligatorio.',
      'alpha_numeric_spaces' => '<strong>%s</strong> solo admite caracteres alfabéticos.',
      'is_natural_no_zero' => '<strong>%s</strong> fue ingresada erroneamente',
      'valid_email' => '<strong>%s</strong> es inválido.'
    ];

    $this->error_delimiter = [
      '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span></button>',
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
        $data['cliente']['telefono'] = $this->security->xss_clean( $this->input->post('telefono') );
        $data['cliente']['email'] = $this->security->xss_clean( $this->input->post('email') );
        $data['cliente']['direccion'] = $this->security->xss_clean( $this->input->post('direccion') );
        $data['cliente']['id_localidad'] = $this->security->xss_clean( $this->input->post('id_localidad') );
        $data['cliente']['tipo_cliente'] = $this->security->xss_clean( $this->input->post('tipo_cliente') );

        $last_id = $this->clientes_model->crear( $data['cliente'] );
        $data['exito'] = TRUE;
        if ($last_id) $this->registro->registrar($this->session->userdata('id_usuario'), 14, 'clientes', $last_id);
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
        $data['cliente']['telefono'] = $this->security->xss_clean( $this->input->post('telefono') );
        $data['cliente']['email'] = $this->security->xss_clean( $this->input->post('email') );
        $data['cliente']['direccion'] = $this->security->xss_clean( $this->input->post('direccion') );
        $data['cliente']['id_localidad'] = $this->security->xss_clean( $this->input->post('id_localidad') );
        $data['cliente']['tipo_cliente'] = $this->security->xss_clean( $this->input->post('tipo_cliente') );

        $last_id = $this->clientes_model->actualizar( $id, $data['cliente'] );
        $data['exito'] = TRUE;
        if ($last_id) $this->registro->registrar($this->session->userdata('id_usuario'), 15, 'clientes', $last_id);
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
      $data = [
        'cliente' => $this->clientes_model->leer($id),
        'ops' => ['to', 'do', 'this', 'foo', ' bar'] // TODO
      ];
      $this->load->view('includes/header');
      $this->load->view('pages/clientes/ver', $data);
      $this->load->view('includes/footer');
    }
  }

  public function eliminar( $id = 0 )
  {
    if (! $this->session->userdata('esta_logeado') and $this->session->userdata('es_admin') ) {
      show_404();
    } else {
      $this->clientes_model->eliminar($id);
      if ($id) $this->registro->registrar($this->session->userdata('id_usuario'), 16, 'clientes', $id);
      redirect( base_url('/clientes'), 'refresh' );
    }
  }
}
