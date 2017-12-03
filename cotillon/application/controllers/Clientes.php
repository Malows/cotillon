<?php defined('BASEPATH') || exit('No direct script access allowed');

class Clientes extends MY_Controller {

  protected $config_validacion;
  protected $mensajes_validacion;

  public function __construct() {
    parent::__construct();
    $this->load->model('clientes_model');
    $this->config_validacion = [
      [
        'field' => 'nombre_cliente',
        'label' => 'Nombre del cliente',
        'rules' => 'required|alpha_numeric_spaces'
      ], [
        'field' => 'telefono',
        'label' => 'Teléfono del cliente',
        'rules' => ''
      ], [
        'field' => 'tipo_cliente',
        'label' => 'Tipo del cliente',
        'rules' => 'required|alpha_numeric_spaces'
      ], [
        'field' => 'id_localidad',
        'label' => 'Localidad',
        'rules' => 'required|is_natural_no_zero'
      ], [
        'field' => 'direccion',
        'label' => 'Dirección',
        'rules' => ''
      ], [
        'field' => 'email',
        'label' => 'Correo Electrónico',
        'rules' => 'valid_email'
      ]
    ];


    $this->mensajes_validacion = [
      'required' => '<strong>%s</strong> es un campo obligatorio.',
      'alpha_numeric_spaces' => '<strong>%s</strong> solo admite caracteres alfabéticos.',
      'is_natural_no_zero' => '<strong>%s</strong> fue ingresada erroneamente',
      'valid_email' => '<strong>%s</strong> es inválido.'
    ];
  }

  public function index() {
    $usuario = $this->logged();
    $modoRestore = boolval($usuario['modo_restore']);
    $data = [
      'clientes' => $this->clientes_model->lista($modoRestore),
      'id_usuario_logueado' => $usuario['id_usuario'],
      'es_admin_usuario_logueado' => $usuario['id_tipo_usuario'] < 3
    ];

    $this->render([[$modoRestore ? 'pages/clientes/index_restore' : 'pages/clientes/index', $data]]);
  }

  public function crear() {
    $usuario = $this->logged();
    $this->form_validation->set_rules($this->config_validacion);
    foreach ($this->mensajes_validacion as $key => $value)
      $this->form_validation->set_message($key, $value);

    $this->load->model('localidades_model');
    $data = ['localidades' => $this->localidades_model->lista()];

    if ($this->form_validation->run())
    {
      $data['cliente']['nombre_cliente'] = $this->security->xss_clean( $this->input->post('nombre_cliente') );
      $data['cliente']['telefono'] = $this->security->xss_clean( $this->input->post('telefono') );
      $data['cliente']['email'] = $this->security->xss_clean( $this->input->post('email') );
      $data['cliente']['direccion'] = $this->security->xss_clean( $this->input->post('direccion') );
      $data['cliente']['id_localidad'] = $this->security->xss_clean( $this->input->post('id_localidad') );
      $data['cliente']['tipo_cliente'] = $this->security->xss_clean( $this->input->post('tipo_cliente') );

      $last_id = $this->clientes_model->crear( $data['cliente'] );
      $data['exito'] = TRUE;
      $this->registro($last_id, $usuario, 14, 'clientes');
    } else {
      unset($data['exito'], $data['cliente']);
    }
    $this->render([['pages/clientes/crear', $data]]);
  }

  public function actualizar( $id ) {
    $usuario = $this->logged();
    $this->form_validation->set_rules($this->config_validacion);
    foreach ($this->mensajes_validacion as $key => $value)
      $this->form_validation->set_message($key, $value);

    $this->load->model('localidades_model');

    $data = [
      'localidades' => $this->localidades_model->lista(),
      'cliente' => $this->clientes_model->leer($id)
     ];

    if( $this->form_validation->run() ) {
      $data['cliente']['nombre_cliente'] = $this->security->xss_clean( $this->input->post('nombre_cliente') );
      $data['cliente']['telefono'] = $this->security->xss_clean( $this->input->post('telefono') );
      $data['cliente']['email'] = $this->security->xss_clean( $this->input->post('email') );
      $data['cliente']['direccion'] = $this->security->xss_clean( $this->input->post('direccion') );
      $data['cliente']['id_localidad'] = $this->security->xss_clean( $this->input->post('id_localidad') );
      $data['cliente']['tipo_cliente'] = $this->security->xss_clean( $this->input->post('tipo_cliente') );

      $last_id = $this->clientes_model->actualizar( $id, $data['cliente'] );
      $data['exito'] = TRUE;
      $this->registro($last_id, $usuario, 15, 'clientes');
    } else {
      unset($data['exito']);
    }
    $this->render([['pages/clientes/actualizar', $data]]);
  }

  public function ver( $id ) {
    $this->logged();
    $data = [
      'cliente' => $this->clientes_model->leer($id),
      'ops' => ['to', 'do', 'this', 'foo', ' bar'] // TODO
    ];
    $this->render([['pages/clientes/ver', $data]]);
  }

  public function eliminar( $id = 0 ) {
    $usuario = $this->loggedAndAdmin();
    $this->clientes_model->eliminar($id);
    $this->registro($id, $usuario, 15, 'clientes');
    redirect( base_url('/clientes'), 'refresh' );
  }

  public function restaurar( $id ) {
    $usuario = $this->loggedAndAdmin();
    $this->clientes_model->restaurar($id);
    redirect(base_url('/clientes'), 'refresh');
  }
}
