<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {
  protected  $config_validacion = null;

  public function __construct() {

    parent::__construct();
    //cargar modelo
    $this->load->model('Categorias_producto_model');

    $this->config_validacion = [
      [
        'field' => 'nombre_categoria',
        'label' => 'Nombre de categoría',
        'rules' => 'required|alpha_numeric_spaces']
      ];

    }

    public function index() {
      if ( ! $this->session->userdata('esta_logeado') ) {
        // No esta logeado, mensaje de error
        show_404();
      } else {
        $data = [
          'categorias' => $this->Categorias_producto_model->lista(),
          'id_usuario_logueado' => $this->session->userdata('id_usuario'),
          'es_admin_usuario_logueado' => $this->session->userdata('es_admin')
        ];

        //paso datos a vista
        $this->load->view('includes/header');
        $this->load->view('pages/categorias/index', $data);
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

        $data = [ 'categorias' => $this->Categorias_producto_model->lista() ];

        if ( $this->form_validation->run() === FALSE ) {
          //llego por primera vez
          $this->load->view('includes/header');
          $this->load->view('pages/categorias/crear', $data );
          $this->load->view('includes/footer');
        } else {
          // Envié el formulario
          $this->Categorias_producto_model->crear(
            $this->security->xss_clean( $this->input->post('nombre_categoria') )
          );

          $data['exito'] = TRUE;
          $data['categoria'] = htmlentities( $this->input->post('nombre_categoria') );

          $this->load->view('includes/header');
          $this->load->view('pages/categorias/crear', $data);
          $this->load->view('includes/footer');
        }
      }
    }

    public function actualizar( $id ) {
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

        $data = [ 'categoria' => $this->Categorias_producto_model->leer( $id ) ];

        if ( $this->form_validation->run() === FALSE ) {

          $this->load->view('includes/header');
          $this->load->view('pages/categorias/actualizar', $data );
          $this->load->view('includes/footer');

        } else {

          $data['exito'] = TRUE;
          $data['categoria']['nombre_categoria'] = htmlentities( $this->input->post('nombre_categoria') );

          $this->Categorias_producto_model->actualizar(
            $id,
            $this->security->xss_clean( $this->input->post('nombre_categoria') )
          );

          $this->load->view('includes/header');
          $this->load->view('pages/categorias/actualizar', $data);
          $this->load->view('includes/footer');
        }
      }
    }

    public function ver_productos( $id ) {
      if ( ! $this->session->userdata('esta_logeado') ) {
        // No esta logeado, mensaje de error
        show_404();
      } else {
        $data = [
          'categoria' => $this->Categorias_producto_model->leer($id),
          'productos' => $this->Categorias_producto_model->productos_correspondientes($id)
        ];

        //paso datos a vista
        $this->load->view('includes/header');
        $this->load->view('pages/categorias/ver_productos', $data);
        $this->load->view('includes/footer');
      }
    }
  }
