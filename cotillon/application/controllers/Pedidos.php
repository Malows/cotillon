<?php defined('BASEPATH') || exit('No direct script access allowed');

class Pedidos extends CI_Controller {

  public function __construct ()
  {
    parent::__construct();
    $this->load->model('Pedidos_model');
  }

  public function index () {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {

      $data = [
        'pedidos' => $this->Pedidos_model->lista(),
        'es_admin_usuario_logueado' => $this->session->userdata('es_admin')
      ];

      $this->load->view('includes/header');
      $this->load->view('pages/pedidos/index', $data);
      $this->load->view('includes/footer');
    }
  }

  public function eliminar ($id = 0) {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $this->Pedidos_model->eliminar($id);
      redirect('/pedidos', 'refresh');
    }
  }

  public function crear () {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $this->load->model('productos_model');
      $this->load->model('proveedores_model');

      $data = [
        'productos' => $this->productos_model->lista_limpia(),
        'proveedores' => $this->proveedores_model->lista_limpia()
      ];
      $this->load->view('includes/header_modal');
      $this->load->view('pages/pedidos/crear');
      $this->load->view('includes/footer_vue1');
      $this->load->view('pages/pedidos/scripts_crear', $data);
      $this->load->view('includes/footer_vue2');
    }
  }
}
