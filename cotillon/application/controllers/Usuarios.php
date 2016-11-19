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
      $data = array(
        'usuarios' => $this->usuarios_model->lista(),
        'id_usuario_logueado' => $this->session->userdata('id_usuario'),
        'es_admin_usuario_logueado' => $this->session->userdata('es_admin')
      );
      //paso datos a vista
      $this->load->view('includes/header');
      $this->load->view('pages/usuarios/index', $data);
      $this->load->view('includes/footer');
    }
  }

  public function crear() {
    if ( ! $this->session->userdata('esta_logeado') && $this->session->userdata('es_admin') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      //Logeado

    }
  }

  public function ver( $id =  0 ) {
    if ( ! $this->session->userdata('esta_logeado') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      //Logeado
      if ( $id == 0 ) {
        //No me paso un ID

      } else {
        //Me paso el ID
        $aux = $this->usuarios_model->leer_por_id( $id );
        //paso datos a vista
        $this->load->view('includes/header');
        if ( $aux ) {
          $data = array( 'usuario' => $aux );
          $this->load->view('pages/usuarios/ver', $data);
        } else {
          //El usuario que se busca no es valido
          $this->load->view('pages/usuarios/usuario_no_encontrado');
        }
        $this->load->view('includes/footer');
      }
    }
  }

  public function actualizar( $id =  0 ) {
    if ( ! $this->session->userdata('esta_logeado') && $this->session->userdata('es_admin') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      //Logeado
      if ( $id == 0 ) {
        //No me paso un ID

      } else {
        //Me paso el ID
        $aux = $this->usuarios_model->leer_por_id( $id );
        //paso datos a vista
        $this->load->view('includes/header');
        if ( $aux ) {
          $data = array( 'usuario' => $aux );
          $this->load->view('pages/usuarios/actualizar', $data);
        } else {
          //El usuario que se busca no es valido
          $this->load->view('pages/usuarios/usuario_no_encontrado');
        }
        $this->load->view('includes/footer');
      }
    }
  }

  public function eliminar( $id =  0 ) {
    if ( ! $this->session->userdata('esta_logeado') && $this->session->userdata('es_admin') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      //Logeado
      if ( $id == 0 ) {
        //No me paso un ID
        
      } else {
        //Me paso el ID
        $aux = $this->usuarios_model->leer_por_id( $id );
        //paso datos a vista
        $this->load->view('includes/header');
        if ( $aux ) {
          $data = array( 'usuario' => $aux );
          $this->load->view('pages/usuarios/eliminar', $data);
        } else {
          //El usuario que se busca no es valido
          $this->load->view('pages/usuarios/usuario_no_encontrado');
        }
        $this->load->view('includes/footer');
      }
    }
  }
