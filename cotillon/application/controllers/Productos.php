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
          'rules' => 'required'
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
          'rules' => ''
        ]
      ];

      $this->mensajes_validacion = [
        'required' => "<strong>%s</strong> es un campo obligatorio.",
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

  public function crear() {
    if ( ! $this->session->userdata('esta_logeado') and $this->session->userdata('es_admin') ) {
      show_404();
    } else {
      $this->form_validation->set_rules($this->config_validacion);
      foreach ($this->mensajes_validacion as $key => $value) {
        $this->form_validation->set_message($key, $value);
      }
      $this->form_validation->set_error_delimiters($this->error_delimiter[0],$this->error_delimiter[1]);

      $this->load->model('proveedores_model');
      $this->load->model('categorias_producto_model');
      $data = [
        'proveedores' => $this->proveedores_model->lista(),
        'categorias' => $this->categorias_producto_model->lista()
      ];

      if ( $this->form_validation->run() === FALSE ) {
        $this->load->view('includes/header');
        $this->load->view('pages/productos/crear', $data);
        $this->load->view('includes/footer');
      } else {
        $this->productos_model->crear(
          $this->security->xss_clean( $this->input->post('id_proveedor')),
          $this->security->xss_clean( $this->input->post('nombre')),
          $this->security->xss_clean( $this->input->post('precio')),
          $this->security->xss_clean( $this->input->post('id_categoria')),
          $this->security->xss_clean( $this->input->post('descripcion'))
        );

        $data['exito'] = TRUE;
        $data['producto'] = htmlentities( $this->input->post('nombre'));

        $this->load->view('includes/header');
        $this->load->view('pages/productos/crear', $data);
        $this->load->view('includes/footer');
      }
    }
  }

  public function actualizar( $id ) {
    if ( ! $this->session->userdata('esta_logeado') and $this->session->userdata('es_admin') ) {
      show_404();
    } else {
      $this->form_validation->set_rules($this->config_validacion);
      foreach ($this->mensajes_validacion as $key => $value) {
        $this->form_validation->set_message($key,$value);
      }
      $this->form_validation->set_error_delimiters($this->error_delimiter[0],$this->error_delimiter[1]);

      $this->load->model('proveedores_model');
      $this->load->model('categorias_producto_model');
      $data = [
        'proveedores' => $this->proveedores_model->lista(),
        'categorias' => $this->categorias_producto_model->lista(),
        'producto' => $this->productos_model->leer($id)
      ];

      if ( $this->form_validation->run() === FALSE ) {
        $this->load->view('includes/header');
        $this->load->view('pages/productos/actualizar', $data);
        $this->load->view('includes/footer');
      } else {
        $this->productos_model->actualizar(
          $id,
          $this->security->xss_clean( $this->input->post('id_proveedor')),
          $this->security->xss_clean( $this->input->post('nombre')),
          $this->security->xss_clean( $this->input->post('precio')),
          $this->security->xss_clean( $this->input->post('id_categoria')),
          $this->security->xss_clean( $this->input->post('descripcion'))
        );

        $data['exito'] = TRUE;
        $data['producto']['nombre'] = htmlentities( $this->input->post('nombre'));
        $data['producto']['precio'] = floatval( $this->input->post('precio'));
        $data['producto']['id_proveedor'] = intval( $this->input->post('id_proveedor'));
        $data['producto']['id_categoria'] = intval( $this->input->post('id_categoria'));
        $data['producto']['descripcion'] = htmlentities( $this->input->post('descripcion'));

        $this->load->view('includes/header');
        $this->load->view('pages/productos/actualizar', $data);
        $this->load->view('includes/footer');
      }
    }
  }

  public function ver( $id ) {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $data = [
        'producto' => $this->productos_model->leer($id)
      ];
      $this->load->view('includes/header');
      $this->load->view('pages/productos/actualizar', $data);
      $this->load->view('includes/footer');
    }
  }

  public function eliminar( $id = 0 )
  {
    if ( ! $this->session->userdata('esta_logeado') and $this->session->userdata('es_admin') ) {
      show_404();
    } else {
      redirect('/productos', 'refresh');
    }
  }
}
