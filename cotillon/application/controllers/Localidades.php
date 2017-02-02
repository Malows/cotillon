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
        'rules' => 'required|alpha_numeric_spaces']
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
      if ( ! $this->session->userdata('esta_logeado') && $this->session->userdata('es_admin') ) {
        // No esta logeado, mensaje de error
        show_404();
      } else {// esta logeado

        $this->form_validation->set_rules($this->config_validacion);
        //mesajes de validaciones
        $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio. " );
        $this->form_validation->set_message('alpha_numeric_spaces', "<strong>%s</strong> solo se admite caracteres alfabéticos." );
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
          $this->localidades_model->crear(
            $this->security->xss_clean( $this->input->post('nombre_localidad') )
        );

        $data['exito']=TRUE;
        $data['localidad']=htmlentities($this->input->post('nombre_localidad'));

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
      $this->form_validation->set_message('alpha_numeric_spaces', "<strong>%s</strong> solo se admite caracteres alfabéticos." );
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
        $data['localidad']['nombre_localidad'] = htmlentities($this->input->post('nombre_localidad'));

        $this->localidades_model->actualizar(
          $id,
          $this->security->xss_clean( $this->input->post('nombre_localidad') )
      );

      $this->load->view('includes/header');
      $this->load->view('pages/localidades/actualizar', $data);
      $this->load->view('includes/footer');
    }
  }
}
}
