<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller
{

  protected $config_validacion = null;

  function __construct()
  {
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

  public function index()
  {
    if ( ! $this->session->userdata('esta_logeado') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      $data = [
        'proveedores' => $this->proveedores_model->lista(),
        'es_admin_usuario_logueado' => $this->session->userdata('es_admin'),
      ];

      $this->load->view('includes/header');
      $this->load->view('pages/proveedores/index', $data);
      $this->load->view('includes/footer');
    }
  }

  public function crear()
  {
    if ( ! $this->session->userdata('esta_logeado') && $this->session->userdata('es_admin') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      $this->form_validation->set_rules($this->config_validacion);

      //mensajes de validaciones
      $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio.");
      $this->form_validation->set_message('alpha_numeric_spaces', "<strong>%s</strong> solo admite caracteres alfabéticos.");
      $this->form_validation->set_message('numeric', "<strong>%s</strong> es un campo unicamente numérico.");
      $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

      $this->load->model('localidades_model');
      $data = [
        'localidades' => $this->localidades_model->lista()
      ];

      if ( $this->form_validation->run() === FALSE ) {
        $this->load->view('includes/header');
        $this->load->view('pages/proveedores/crear', $data);
        $this->load->view('includes/footer');
      } else {

        $payload = [
          'nombre_proveedor' => $this->security->xss_clean( $this->input->post('nombre_proveedor')),
          'contacto' => $this->security->xss_clean( $this->input->post('contacto')),
          'id_localidad' => $this->security->xss_clean( $this->input->post('localidad'))
        ];

        $last_id = $this->proveedores_model->crear($payload);

        if ($last_id) $this->registro->registrar($this->session->userdata('id_usuario'), 5, 'proveedores', $last_id);

        $data['exito'] = TRUE;
        $data['proveedor'] = htmlentities($this->input->post('nombre_proveedor'));


        $this->load->view('includes/header');
				$this->load->view('pages/proveedores/crear', $data);
				$this->load->view('includes/footer');
      }

    }
  }

  public function ver( $id )
  {
    if ( ! $this->session->userdata('esta_logeado') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      $this->load->model('productos_model');
      $data = [
        'proveedor' => $this->proveedores_model->leer($id),
        'productos' => $this->productos_model->productos_de_proveedor($id)
      ];
        $this->load->view('includes/header');
        $this->load->view('pages/proveedores/ver', $data);
        $this->load->view('includes/footer');
    }
  }

  public function actualizar( $id )
  {
    if ( ! $this->session->userdata('esta_logeado') && $this->session->userdata('es_admin') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      $this->form_validation->set_rules($this->config_validacion);

      //mensajes de validaciones
      $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio.");
      $this->form_validation->set_message('alpha_numeric_spaces', "<strong>%s</strong> solo admite caracteres alfabéticos.");
      $this->form_validation->set_message('numeric', "<strong>%s</strong> es un campo unicamente numérico.");
      $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

      $this->load->model('localidades_model');
      $data = [
        'localidades' => $this->localidades_model->lista(),
        'proveedor' => $this->proveedores_model->leer($id)
      ];

      if ( $this->form_validation->run() === FALSE ) {
        $this->load->view('includes/header');
        $this->load->view('pages/proveedores/actualizar', $data);
        $this->load->view('includes/footer');
      } else {

        $data['proveedor']['id_proveedor'] = $this->security->xss_clean( $id );
        $data['proveedor']['nombre_proveedor'] = $this->security->xss_clean( $this->input->post('nombre_proveedor'));
        $data['proveedor']['contacto'] = $this->security->xss_clean( $this->input->post('contacto'));
        $data['proveedor']['id_localidad'] = $this->security->xss_clean( $this->input->post('localidad'));

        $data['exito'] = true;

        $payload=[
          'nombre_proveedor'=> $this->security->xss_clean( $this->input->post('nombre_proveedor')),
          'contacto'=> $this->security->xss_clean( $this->input->post('contacto')),
          'id_localidad'=> $this->security->xss_clean( $this->input->post('localidad'))
        ];

        $last_id = $this->proveedores_model->actualizar( $id, $payload );

        if ($last_id) $this->registro->registrar($this->session->userdata('id_usuario'), 6, 'proveedores', $last_id);

        $this->load->view('includes/header');
        $this->load->view('pages/proveedores/actualizar', $data);
        $this->load->view('includes/footer');
      }
    }
  }

  public function eliminar( $id = 0 )
  {
    if ( ! $this->session->userdata('esta_logeado') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      $this->proveedores_model->eliminar($id);
      if ($id) $this->registro->registrar($this->session->userdata('id_usuario'), 7, 'proveedores', $id);
      redirect('/proveedores', 'refresh');
    }
  }
}
