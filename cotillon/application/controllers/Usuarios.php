<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

  protected $config_validacion = null;

  public function __construct() {
    parent::__construct();
    //cargar modelo
    $this->load->model('usuarios_model');

    $this->config_validacion = array(
      array(
        'field' => 'nombre',
        'label' => 'Nombre',
        'rules' => 'required|alpha_numeric_spaces'
      ),
      array(
        'field' => 'apellido',
        'label' => 'Apellido',
        'rules' => 'required|alpha_numeric_spaces'
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
  }

  public function index() {
    if ( ! $this->session->userdata('esta_logeado') ) {
      // No esta logeado, mensaje de error
      show_404();
    } else {
      //obtenes datos
      $data = [
        'usuarios' => $this->usuarios_model->lista_activos(),
        'id_usuario_logueado' => $this->session->userdata('id_usuario'),
        'es_admin_usuario_logueado' => $this->session->userdata('es_admin')
      ];
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

      // cargo configuraciones de validaciones
      $this->form_validation->set_rules($this->config_validacion);

      //mensajes de validaciones
      $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio.");
      $this->form_validation->set_message('alpha_numeric_spaces', "<strong>%s</strong> solo admite caracteres alfabéticos.");
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
        $last_id = $this->usuarios_model->crear(
          $this->security->xss_clean( $this->input->post('nombre') ),
          $this->security->xss_clean( $this->input->post('apellido') ),
          $this->security->xss_clean( $this->input->post('email') ),
          $this->security->xss_clean( $this->input->post('dni') ),
          $this->input->post('password'),
          $this->security->xss_clean( $this->input->post('es_admin') )
        );

        $permiso = $this->security->xss_clean( $this->input->post('es_admin') ) == "1" ? "Administrador" : "No Administrador";

        if ($last_id) $this->registro->registrar($this->session->userdata('id_usuario'), 2, 'usuarios', $last_id);

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

      $data = [
        'accion' => 'ver',
        'usuarios' =>  $this->usuarios_model->lista_activos(),
        'mensaje' => "Esta acción requiere de un usuario válido.
        Seleccione uno por favor."
      ];

      if ( $id == 0 ) {
        //No me paso un ID
        $this->load->view('pages/usuarios/id_no_valido', $data);
      } else {
        //Me paso el ID
        $aux = $this->usuarios_model->leer_por_id( $id );
        if ( $aux ) {
          $data = [ 'usuario' => $aux ];
          $this->load->view('pages/usuarios/ver', $data);
        } else {
          //El usuario que se busca no es valido
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
      // cargo configuraciones de validaciones
      $nueva = $this->config_validacion;
      // DNI
      $nueva[2]['rules'] = 'required|is_natural_no_zero';
      // Email
      $nueva[5]['rules'] = 'required|valid_email';
      // Password y confirmacion
      unset( $nueva[3] );
      unset( $nueva[4] );
      // Reindexo claves faltantes
      $nueva = array_values($nueva);

      $this->form_validation->set_rules($nueva);

      //mensajes de validaciones
      $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio.");
      $this->form_validation->set_message('alpha_numeric_spaces', "<strong>%s</strong> solo admite caracteres alfabéticos.");
      $this->form_validation->set_message('is_natural_no_zero', "<strong>%s</strong> es un campo unicamente numérico.");
      $this->form_validation->set_message('is_unique', "<strong>%s</strong> coincide con otro usuario ya existente.");
      $this->form_validation->set_message('valid_email', "Ingrese una dirección de <strong>%s</strong> válida.");

      //delimitadores de errores
      $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

      $aux = $this->usuarios_model->leer_por_id( $id );

      if ( $this->form_validation->run() === FALSE ) {
        // Tengo el ID // No envió el formulario aún

        if ( $aux ) {
          $this->load->view('includes/header');
          $this->load->view('pages/usuarios/actualizar', ['usuario' => $aux]);
          $this->load->view('includes/footer');
        } else {
          //El usuario que se busca no es valido
          $data = [
            'accion' => 'actualizar',
            'usuarios' =>  $this->usuarios_model->lista_activos(),
            'mensaje' => "Esta acción requiere de un usuario válido. Seleccione uno por favor."
          ];

          $this->load->view('includes/header');
          $this->load->view('pages/usuarios/id_no_valido', $data);
          $this->load->view('includes/footer');
        }
      } else {
        // Tengo el ID // Me envió el formulario
        $aux['nombre'] = $this->security->xss_clean($this->input->post('nombre'));
        $aux['apellido'] = $this->security->xss_clean($this->input->post('apellido'));
        $aux['email'] = $this->security->xss_clean($this->input->post('email'));
        $aux['dni'] = $this->security->xss_clean($this->input->post('dni'));
        $aux['es_admin'] = $this->security->xss_clean($this->input->post('es_admin'));

        $this->usuarios_model->actualizar(
          $aux['id_usuario'],
          $aux['nombre'],
          $aux['apellido'],
          $aux['email'],
          $aux['dni'],
          $aux['es_admin']
        );

        if ($id) $this->registro->registrar($this->session->userdata('id_usuario'), 3, 'usuarios', $id);

        $data = [ 'exito' => TRUE, 'usuario' => $aux ];
        $this->load->view('includes/header');
        $this->load->view('pages/usuarios/actualizar', $data);
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
      $this->form_validation->set_rules('submit', 'Submit', 'required');
      $this->form_validation->set_message('required', 'Es necesario');
      $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

      $aux = $this->usuarios_model->leer_por_id( $id );

      if ( $this->form_validation->run() === FALSE ) {
        if ( $aux ) {
          // Tengo el ID
          $this->load->view('includes/header');
          $this->load->view('pages/usuarios/eliminar', ['usuario' => $aux ]);
          $this->load->view('includes/footer');
        } else {
          //El usuario que se busca no es valido
          $data = [
            'accion' => 'eliminar',
            'usuarios' =>  $this->usuarios_model->lista_activos(),
            'mensaje' => "Esta acción requiere de un usuario válido. Seleccione uno por favor."
          ];
          $this->load->view('includes/header');
          $this->load->view('pages/usuarios/id_no_valido', $data);
          $this->load->view('includes/footer');
        }

      } else {
        // Corrió el formulario
        $this->usuarios_model->eliminar( $aux['id_usuario'] );

        if ($aux['id_usuario']) $this->registro->registrar($this->session->userdata('id_usuario'), 4, 'usuarios', $aux['id_usuario']);

        $this->load->view('includes/header');
        $this->load->view('pages/usuarios/eliminar', ['exito' => TRUE, 'usuario' => $aux ]);
        $this->load->view('includes/footer');
      }
    }
  }
}
