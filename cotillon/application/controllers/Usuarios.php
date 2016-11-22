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
      $config = array(
        array(
          'field' => 'nombre',
          'label' => 'Nombre',
          'rules' => 'required|alpha'
        ),
        array(
          'field' => 'apellido',
          'label' => 'Apellido',
          'rules' => 'required|alpha'
        ),
        array(
          'field' => 'dni',
          'label' => 'DNI',
          'rules' => 'required|is_natural_no_zero|is_unique[usuarios.dni]'
        ),
        array(
          'field' => 'password',
          'label' => 'Constraseña',
          'rules' => 'required'
        ),
        array(
          'field' => 're-password',
          'label' => 'Contraseña',
          'rules' => 'required|matches[password]'
        ),
        array(
          'field' => 'email',
          'label' => 'Email',
          'rules' => 'required|valid_email|is_unique[usuarios.email]'
        ),
        array(
          'field' => 'es_admin',
          'label' => 'Permiso de Administración',
          'rules' => 'required'
        )
      );
      // cargo configuraciones de validaciones
      $this->form_validation->set_rules($config);

      //mensajes de validaciones
      $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio.");
      $this->form_validation->set_message('alpha', "<strong>%s</strong> solo admite caracteres alfabéticos.");
      $this->form_validation->set_message('is_natural_no_zero', "<strong>%s</strong> es un campo unicamente numérico.");
      $this->form_validation->set_message('is_unique', "<strong>%s</strong> coincide con otro usuario ya existente.");
      $this->form_validation->set_message('matches', "La <strong>Contraseña</strong> y su <strong>Confirmación</strong> no coinsiden.");
      $this->form_validation->set_message('valid_email', "Ingrese una dirección de <strong>%s</strong> válida.");

      //delimitadores de errores
      $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

      if ( $this->form_validation->run() === FALSE ) {
        // Llego por primera vez
        $this->load->view('includes/header');
				$this->load->view('pages/usuarios/crear');
				$this->load->view('includes/footer');
			} else {
        // Envié el formulario
        $this->usuarios_model->crear(
          $this->security->xss_clean( $this->input->post('nombre') ),
          $this->security->xss_clean( $this->input->post('apellido') ),
          $this->security->xss_clean( $this->input->post('email') ),
          $this->security->xss_clean( $this->input->post('dni') ),
          $this->input->post('password'),
          $this->security->xss_clean( $this->input->post('es_admin') )
        );

        $permiso = $this->security->xss_clean( $this->input->post('es_admin') ) == "1" ? "Administrador" : "No Administrador";

        $data = array(
          'exito' => TRUE,
          'usuario' => htmlentities($this->input->post('apellido').', '.$this->input->post('nombre') ),
					'permisos' => $permiso );

        $this->load->view('includes/header');
				$this->load->view('pages/usuarios/crear', $data);
				$this->load->view('includes/footer');

      }
    }
  }

  public function ver( $id =  0 ) {
    if ( ! $this->session->userdata('esta_logeado') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      //Logeado
      $this->load->view('includes/header');
      if ( $id == 0 ) {
        //No me paso un ID
        $data = array(
          'usuarios' =>  $this->usuarios_model->lista(),
          'mensaje' => "Esta acción requiere de un usuario válido.
          Seleccione uno por favor."
        );
        $this->load->view('pages/usuarios/id_no_valido', $data);
      } else {
        //Me paso el ID
        $aux = $this->usuarios_model->leer_por_id( $id );
        if ( $aux ) {
          $data = array( 'usuario' => $aux );
          $this->load->view('pages/usuarios/ver', $data);
        } else {
          //El usuario que se busca no es valido
          $data = array(
            'usuarios' =>  $this->usuarios_model->lista(),
            'mensaje' => "El usuario que solicitó no existe.
            Seleccione un usuario válido de la base de datos"
          );
          $this->load->view('pages/usuarios/id_no_valido', $data);
        }
      }
      $this->load->view('includes/footer');
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
}
