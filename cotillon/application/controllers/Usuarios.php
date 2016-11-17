<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

  public function __construct() {
    parent::__construct();
    //cargar modelo
    $this->load->model('usuarios_model');
  }

  public function index() {
    if ( ! $this->session->userdata('esta_logeado') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      //obtenes datos
      $data = array('usuarios' => $this->usuarios_model->lista() );
      //paso datos a vista
      $this->load->view('includes/header');
      $this->load->view('pages/usuarios/index', $data);
      $this->load->view('includes/footer');
    }
  }

  public function crear() {

  }

  public function ver( $id =  0 ) {

  }

  public function actualizar( $id =  0 ) {

  }

  public function eliminar( $id =  0 ) {

  }
}
