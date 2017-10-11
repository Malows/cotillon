<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Localidades extends CI_Controller {
  protected  $config_validacion=null;

  public function __construct() {

    parent::__construct();
    //cargar modelo
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

    public function index() {
      if ( ! $this->session->userdata('esta_logeado') ) {
        // No esta logeado, mensaje de error
        show_404();
      } else {
        $data = [
          'localidades' => $this->localidades_model->lista(),
          'id_usuario_logueado' => $this->session->userdata('id_usuario'),
          'es_admin_usuario_logueado' => $this->session->userdata('es_admin')
        ];
        //paso datos a vista
        $this->load->view('includes/header');
        $this->load->view('pages/localidades/index', $data);
        $this->load->view('includes/footer');
      }
    }

    public function crear(){
      if ( ! $this->session->userdata('esta_logeado') ) {
        // No esta logeado, mensaje de error
        show_404();
      } else {// esta logeado

        $this->form_validation->set_rules($this->config_validacion);
        //mesajes de validaciones
        $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio. " );
        //delimitadores de errores
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> ', '</div>');

        $data=['localidades' => $this->localidades_model->lista()];

        if ( $this->form_validation->run() === FALSE ) {
          //llego por primera vez
          $this->load->view('includes/header');
          $this->load->view('pages/localidades/crear' , $data );
          $this->load->view('includes/footer');
        } else {
          // Envié el formulario
          $payload = [
            'nombre_localidad' => $this->security->xss_clean( $this->input->post('nombre_localidad') ),
            'barrio' => $this->security->xss_clean( $this->input->post('barrio') )
          ];
          $last_id = $this->localidades_model->crear( $payload );

          if ($last_id) $this->registro->registrar($this->session->userdata('id_usuario'), 17, 'localidades', $last_id);
          $data['exito']=TRUE;
          $data['localidad']['nombre_localidad']=htmlentities($this->input->post('nombre_localidad'));
          $data['localidad']['barrio']=htmlentities($this->input->post('barrio'));

          $this->load->view('includes/header');
          $this->load->view('pages/localidades/crear', $data);
          $this->load->view('includes/footer');
        }
      }
    }

    public function actualizar( $id ){
      if ( ! $this->session->userdata('esta_logeado') && $this->session->userdata('es_admin') ) {
        // No esta logeado, mensaje de error
        show_404();
      } else {// esta logeado

        $this->form_validation->set_rules($this->config_validacion);
        //mesajes de validaciones
        $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio. " );
        //delimitadores de errores
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> ', '</div>');

        $data=['localidad' => $this->localidades_model->leer( $id )];

        if ( $this->form_validation->run() === FALSE ) {
          //llego por primera vez
          $this->load->view('includes/header');
          $this->load->view('pages/localidades/actualizar' , $data );
          $this->load->view('includes/footer');
        } else {
          // Envié el formulario
          $data['exito']=TRUE;
          $data['localidad']['nombre_localidad']=htmlentities($this->input->post('nombre_localidad'));
          $data['localidad']['barrio']=htmlentities($this->input->post('barrio'));

          $payload = [
            'nombre_localidad' => $this->security->xss_clean( $this->input->post('nombre_localidad') ),
            'barrio' => $this->security->xss_clean( $this->input->post('barrio') )
          ];
          $last_id = $this->localidades_model->actualizar( $id, $payload );
          if ($last_id) $this->registro->registrar($this->session->userdata('id_usuario'), 18, 'localidades', $last_id);

          $this->load->view('includes/header');
          $this->load->view('pages/localidades/actualizar', $data);
          $this->load->view('includes/footer');
        }
      }
    }

  public function ver_clientes( $id = 0 ) {
    if ( ! $this->session->userdata('esta_logeado') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      $this->load->model('clientes_model');
      $data = [
        'localidad' => $this->localidades_model->leer($id),
        'clientes' => $this->clientes_model->buscar('id_localidad', $id),
      ];
      //paso datos a vista
      $this->load->view('includes/header');
      $this->load->view('pages/localidades/ver_clientes', $data);
      $this->load->view('includes/footer');
    }
  }

  public function ver_proveedores( $id = 0 ) {
    if ( ! $this->session->userdata('esta_logeado') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      $this->load->model('proveedores_model');
      $data = [
        'localidad' => $this->localidades_model->leer($id),
        'proveedores' => $this->proveedores_model->buscar('id_localidad', $id),
      ];
      //paso datos a vista
      $this->load->view('includes/header');
      $this->load->view('pages/localidades/ver_proveedores', $data);
      $this->load->view('includes/footer');
    }
  }
}
