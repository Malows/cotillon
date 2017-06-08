<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
  }

  public function index() {

  }

  public function crear() {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $this->load->model("productos_model");

      $data = ['productos' => $this->productos_model->lista_limpia()];
      for ($i=0; $i < count( $data['productos'] ); $i++) {
        $data['productos'][$i]['nombre'] = html_entity_decode($data['productos'][$i]['nombre']);
      }
      $this->load->view('includes/header');
      $this->load->view('pages/ventas/crear');
      $this->load->view('includes/footer_vue1');
      $this->load->view('pages/ventas/scripts_crear', $data);
      $this->load->view('includes/footer_vue2');
    }
  }


}
