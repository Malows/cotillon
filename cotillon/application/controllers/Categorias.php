<?php defined('BASEPATH') || exit('No direct script access allowed');

class Categorias extends MY_Controller {
  protected  $config_validacion = null;

  public function __construct() {
    parent::__construct();
    $this->load->model('categorias_producto_model');
    $this->config_validacion = [
      [
        'field' => 'nombre_categoria',
        'label' => 'Nombre de categoría',
        'rules' => 'required']
      ];
    $this->form_validation->set_rules($this->config_validacion);
    $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio. " );
  }

    public function index() {
      $usuario = $this->logged();
      $modoRestore = boolval($usuario['modo_restore']);
      $data = [
        'categorias' => $this->categorias_producto_model->lista($modoRestore),
        'id_usuario_logueado' => $usuario['id_usuario'],
        'es_admin_usuario_logueado' => $usuario['id_tipo_usuario'] < 3
      ];

      $this->render([[$modoRestore ? 'pages/categorias/index_restore' : 'pages/categorias/index', $data]]);
    }

  public function crear(){
    $usuario = $this->loggedAndAdmin();

    $data['categorias'] = $this->categorias_producto_model->lista();

    if ($this->form_validation->run())
    {
      $payload['nombre_categoria'] = $this->security->xss_clean( $this->input->post('nombre_categoria') );
      $last_id = $this->categorias_producto_model->crear( $payload );

      $this->registrar($last_id, $usuario, 8, 'categorias_producto');

      $data['exito'] = TRUE;
      $data['categoria'] = $this->input->post('nombre_categoria');
    }
    $this->render([['pages/categorias/crear', $data]]);
  }

  public function actualizar( $id ) {
    $usuario = $this->loggedAndAdmin();

    $data = ['categoria' => $this->categorias_producto_model->leer( $id )];

    if ($this->form_validation->run())
    {
      $data['exito'] = TRUE;
      $data['categoria']['nombre_categoria'] = htmlentities( $this->input->post('nombre_categoria') );

      $payload['nombre_categoria'] = $this->security->xss_clean( $this->input->post('nombre_categoria') );
      $this->Categorias_producto_model->actualizar( $id, $payload );

      $this->registrar($id, $usuario, 9, 'categorias_producto');
    }
    $this->render([['pages/categorias/actualizar', $data]]);
  }

  public function eliminar( $id = 0 ) {
    $usuario = $this->loggedAndAdmin();
    if ( $id !== 0 ) {
      $this->categorias_producto_model->eliminar( $id );
      $this->registrar($id, $usuario, 10, 'categorias_producto');
    }
    redirect(base_url('/categorias'), 'refresh');
  }

  public function ver_productos( $id ) {
    $this->logged();
    $data = [
      'categoria' => $this->categorias_producto_model->leer($id),
      'productos' => $this->categorias_producto_model->productos_correspondientes($id)
    ];
    $this->render([['pages/categorias/ver_productos', $data]]);
  }

  public function restaurar( $id ) {
    $usuario = $this->loggedAndAdmin();
    $this->categorias_producto_model->restaurar($id);
    redirect(base_url('/categorias'), 'refresh');
  }
}
