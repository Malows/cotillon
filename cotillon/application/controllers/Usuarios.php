<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller {

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
    $usuario = $this->logged();
    //obtenes datos
    $modoRestore = boolval($usuario['modo_restore']);
    $data = [
      'usuarios' => $this->usuarios_model->lista($modoRestore),
      'id_usuario_logueado' => $usuario['id_usuario'],
      'es_admin_usuario_logueado' => $usuario['id_tipo_usuario'] < 3
    ];
    $this->render([[$modoRestore ? 'pages/usuarios/index_restore' : 'pages/usuarios/index', $data]]);
  }

  public function crear() {
    $usuario = $this->loggedAndAdmin();
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

    $data = [];

    if ($this->form_validation->run()) {
      $payload = [
        'nombre' => $this->security->xss_clean( $this->input->post('nombre') ),
        'apellido' => $this->security->xss_clean( $this->input->post('apellido') ),
        'email' => $this->security->xss_clean( $this->input->post('email') ),
        'dni' => $this->security->xss_clean( $this->input->post('dni') ),
        'password' => $this->input->post('password'),
        'es_admin' => $this->security->xss_clean( $this->input->post('es_admin') ) ];

      $last_id = $this->usuarios_model->crear($payload);
      $this->registrar($last_id, $usuario, 2, 'usuarios');

      $permiso = $this->security->xss_clean( $this->input->post('es_admin') ) == "1" ? "Administrador" : "No Administrador";
      $data['exito'] = TRUE;
      $data['usuario'] = htmlentities($this->input->post('apellido').', '.$this->input->post('nombre') );
      $data['permisos'] = $permiso;
    }
    $this->render([['pages/usuarios/crear', $data]]);
  }

  public function ver( $id =  0 ) {
    $this->logged();
    $data['accion'] = 'ver';
    $data['mensaje'] = "Esta acción requiere de un usuario válido. Seleccione uno por favor.";

    $data['usuario'] = $this->usuarios_model->leer_por_id( $id );
    if ( $data['usuario'] ) {
      $this->render([['pages/usuarios/ver', $data]]);
    } else {
      $data['usuarios'] =  $this->usuarios_model->lista();
      $this->render([['pages/usuarios/id_no_valido', $data]]);
    }
  }

  public function actualizar( $id =  0 ) {
    $usuario = $this->loggedAndAdmin();
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

    $aux = $this->usuarios_model->leer($id);

    if ( $this->form_validation->run() === FALSE ) {
      if ( $aux ) $this->render([['pages/usuarios/actualizar', ['usuario' => $aux]]]);
      else {
        $data = [
          'accion' => 'actualizar',
          'usuarios' =>  $this->usuarios_model->lista(),
          'mensaje' => "Esta acción requiere de un usuario válido. Seleccione uno por favor." ];

        $this->render([['pages/usuarios/id_no_valido', $data]]);
      }
    } else {
      // Tengo el ID // Me envió el formulario
      $aux['nombre'] = $this->security->xss_clean($this->input->post('nombre'));
      $aux['apellido'] = $this->security->xss_clean($this->input->post('apellido'));
      $aux['email'] = $this->security->xss_clean($this->input->post('email'));
      $aux['dni'] = $this->security->xss_clean($this->input->post('dni'));
      $aux['es_admin'] = $this->security->xss_clean($this->input->post('es_admin'));

      $payload = $aux;
      unset($payload['id_usuario']);

      $this->usuarios_model->actualizar($id, $payload);
      $this->registrar($id, $usuario, 3, 'usuarios');

      $data = [ 'exito' => TRUE, 'usuario' => $aux ];
      $this->render([['pages/usuarios/actualizar', $data]]);
    }
  }

  public function eliminar( $id =  0 ) {
    $usuario = $this->loggedAndAdmin();

    $this->form_validation->set_rules('submit', 'Submit', 'required');
    $this->form_validation->set_message('required', 'Es necesario');

    $data['usuario'] = $this->usuarios_model->leer_por_id( $id );

    if ( $this->form_validation->run() === FALSE ) {
      if ( $data['usuario'] ) {
        $this->render([['pages/usuarios/eliminar', $data]]);
      } else {
        $data = [
          'accion' => 'eliminar',
          'usuarios' =>  $this->usuarios_model->lista(),
          'mensaje' => "Esta acción requiere de un usuario válido. Seleccione uno por favor." ];

        $this->render([['pages/usuarios/id_no_valido', $data]]);
      }
    } else {
      $last_id = $this->usuarios_model->eliminar( $aux['id_usuario'] );
      $this->registrar($last_id, $usuario, 4, 'usuarios');
      $data['exito'] = true;

      $this->render([['pages/usuarios/eliminar', $data]]);
    }
  }

  public function restaurar( $id ) {
    $usuario = $this->loggedAndAdmin();
    $this->usuarios_model->restaurar($id);
    redirect(base_url('/usuarios'), 'refresh');
  }

  public function configuraciones() {
    $data['usuario'] = $this->loggedAndAdmin();

    $this->form_validation->set_rules('submit', 'Submit', 'required');
    $this->form_validation->set_message('required', 'Es necesario');

    if ($this->form_validation->run()) {
      // manejar las configuraciones
      $data['usuario']['modo_restore'] = $this->input->post('modo-restore') == 1 ? true : false;
      $this->usuarios_model->actualizar($data['usuario']['id_usuario'], $data['usuario']);
      $_SESSION['user'] = $data['usuario'];
    }
    $this->render([['pages/usuarios/configuraciones', $data]]);
  }
}
