<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

  protected $config_validacion;
  protected $mensajes_validacion;
  protected $error_delimiter;

  public function __construct()
  {
      parent::__construct();
      $this->load->model('productos_model');
      $this->config_validacion = [
        [
          'field' => 'id_proveedor',
          'label' => 'Proveedor',
          'rules' => 'required|is_natural_no_zero'
        ], [
          'field' => 'nombre',
          'label' => 'Nombre del producto',
          'rules' => 'required|alpha_numeric_spaces'
        ], [
          'field' => 'precio',
          'label' => 'Precio',
          'rules' => 'required|numeric'
        ], [
          'field' => 'id_categoria',
          'label' => 'Categoría',
          'rules' => 'required|is_natural_no_zero'
        ], [
          'field' => 'descripcion',
          'label' => 'Descripción',
          'rules' => 'required|alpha_numeric_spaces'
        ]
      ];

      $this->mensajes_validacion = [
        'required' => "<strong>%s</strong> es un campo obligatorio.",
        'alpha_numeric_spaces' => "<strong>%s</strong> solo admite caracteres alfabéticos.",
        'is_natural_no_zero' => "<strong>%s</strong> no puede ser procesado correctamente.",
        'numeric' => "<strong>%s</strong> es un campo unicamente numérico."
      ];

      $this->error_delimiter = [
        '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
        '</div>'
      ];
  }

  public function index()
  {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $data = [
        'productos' => $this->productos_model->lista(),
        'es_admin_usuario_logueado' => $this->session->userdata('es_admin')
      ];

      $this->load->view('includes/header');
      $this->load->view('pages/productos/index', $data);
      $this->load->view('includes/footer');
    }
  }

  public function crear()
  {
    if ( ! $this->session->userdata('esta_logeado') and $this->session->userdata('es_admin') ) {
      show_404();
    } else {
      $this->form_validation->set_rules($this->config_validacion);
      foreach ($this->mensajes_validacion as $key => $value) {
        $this->form_validation->set_message($key, $value);
      }
      $this->form_validation->set_error_delimiters($this->error_delimiter[0],$this->error_delimiter[1]);

    }
  }

  public function actualizar( $id )
  {
    if ( ! $this->session->userdata('esta_logeado') and $this->session->userdata('es_admin') ) {
      show_404();
    } else {
      $this->form_validation->set_rules($this->config_validacion);
      foreach ($this->mensajes_validacion as $key => $value) {
        $this->form_validation->set_message($key,$value);
      }
      $this->form_validation->set_error_delimiters($this->error_delimiter[0],$this->error_delimiter[1]);

    }
  }

  public function ver( $id )
  {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {

    }
  }

  public function eliminar( $id )
  {
    if ( ! $this->session->userdata('esta_logeado') and $this->session->userdata('es_admin') ) {
      show_404();
    } else {

    }
  }
}
