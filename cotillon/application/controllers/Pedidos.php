<?php defined('BASEPATH') || exit('No direct script access allowed');

class Pedidos extends CI_Controller {

  public function __construct ()
  {
    parent::__construct();
    $this->load->model('Pedidos_model');
  }

  public function index ()
  {
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

  public function eliminar ($id = 0)
  {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $this->Pedidos_model->eliminar($id);
      redirect('/pedidos', 'refresh');
    }
  }

  public function crear ()
  {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $this->load->view('includes/header');
      $this->load->view('pages/pedidos/crear');
      $this->load->view('includes/footer');
    }
  }
}
