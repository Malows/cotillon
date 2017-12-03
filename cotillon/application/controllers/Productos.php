<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends MY_Controller {

  protected $config_validacion;
  protected $mensajes_validacion;

  public function __construct () {
      parent::__construct();
      $this->load->model('productos_model');
      $this->config_validacion = [
        [
          'field' => 'id_proveedor',
          'label' => 'Proveedor',
          'rules' => 'required|is_natural_no_zero'
        ], [
          'field' => 'nombre',
          'label' => 'Nombre del producto',
          'rules' => 'required'
        ], [
          'field' => 'precio',
          'label' => 'Precio',
          'rules' => 'required|numeric'
        ], [
          'field' => 'id_categoria',
          'label' => 'Categoría',
          'rules' => 'required|is_natural_no_zero'
        ], [
          'field' => 'descripcion',
          'label' => 'Descripción',
          'rules' => ''
        ], [
          'field' => 'unidad',
          'label' => 'Unidades',
          'rules' => 'required|alpha'
        ]
      ];

      $this->mensajes_validacion = [
        'required' => "<strong>%s</strong> es un campo obligatorio.",
        'is_natural_no_zero' => "<strong>%s</strong> no puede ser procesado correctamente.",
        'numeric' => "<strong>%s</strong> es un campo unicamente numérico.",
        'alpha' => '<strong>%s</strong> error de validación'
      ];
  }

  public function index () {
    $usuario = $this->logged();
    $modoRestore = boolval($usuario['modo_restore']);
    $data = [
      'productos' => $this->productos_model->lista($modoRestore),
      'alertas' => $this->productos_model->lista_alertas(),
      'es_admin_usuario_logueado' => $this->session->userdata('es_admin')];

    $this->render([[$modoRestore ? 'pages/productos/index_restore' : 'pages/productos/index', $data]]);
  }

  public function crear() {
    $usuario = $this->loggedAndAdmin();
    $this->form_validation->set_rules($this->config_validacion);
    foreach ($this->mensajes_validacion as $key => $value) {
      $this->form_validation->set_message($key, $value);
    }

    $this->load->model('proveedores_model');
    $this->load->model('categorias_producto_model');
    $data = [
      'proveedores' => $this->proveedores_model->lista(),
      'categorias' => $this->categorias_producto_model->lista() ];

    if ( $this->form_validation->run()) {
      $payload = [
        'id_proveedor' => $this->security->xss_clean( $this->input->post('id_proveedor')),
        'nombre' => $this->security->xss_clean( $this->input->post('nombre')),
        'precio' => $this->security->xss_clean( $this->input->post('precio')),
        'id_categoria' => $this->security->xss_clean( $this->input->post('id_categoria')),
        'descripcion' => $this->security->xss_clean( $this->input->post('descripcion')),
        'alerta' => $this->security->xss_clean( $this->input->post('alerta')),
        'unidad' => $this->security->xss_clean( $this->input->post('unidad')),
        'cantidad' => $this->security->xss_clean( $this->input->post('cantidad')) ];

      $last_id = $this->productos_model->crear($payload);
      $this->registrar($last_id, $usuario, 11, 'productos');

      $data['exito'] = TRUE;
      $data['producto'] = htmlentities( $this->input->post('nombre'));
    }
    $this->render([['pages/productos/crear', $data]]);
  }

  public function actualizar( $id ) {
    $usuario = $this->loggedAndAdmin();
    $this->form_validation->set_rules($this->config_validacion);
    foreach ($this->mensajes_validacion as $key => $value) {
      $this->form_validation->set_message($key,$value);
    }

    $this->load->model('proveedores_model');
    $this->load->model('categorias_producto_model');
    $data = [
      'proveedores' => $this->proveedores_model->lista(),
      'categorias' => $this->categorias_producto_model->lista(),
      'producto' => $this->productos_model->leer($id) ];
    if ( $this->form_validation->run()) {
      $payload = [
        'id_proveedor' => $this->security->xss_clean( $this->input->post('id_proveedor')),
        'nombre' => $this->security->xss_clean( $this->input->post('nombre')),
        'precio' => $this->security->xss_clean( $this->input->post('precio')),
        'id_categoria' => $this->security->xss_clean( $this->input->post('id_categoria')),
        'descripcion' => $this->security->xss_clean( $this->input->post('descripcion')),
        'alerta' => $this->security->xss_clean( $this->input->post('alerta')),
        'unidad' => $this->security->xss_clean( $this->input->post('unidad')),
        'cantidad' => $this->security->xss_clean( $this->input->post('cantidad'))
      ];
      $last_id = $this->productos_model->actualizar($id, $payload);
      $this->registrar($last_id, $usuario, 12, 'productos');

      $data['exito'] = TRUE;
      $data['producto']['nombre'] = htmlentities( $this->input->post('nombre'));
      $data['producto']['precio'] = floatval( $this->input->post('precio'));
      $data['producto']['id_proveedor'] = intval( $this->input->post('id_proveedor'));
      $data['producto']['id_categoria'] = intval( $this->input->post('id_categoria'));
      $data['producto']['descripcion'] = htmlentities( $this->input->post('descripcion'));
      $data['producto']['alerta'] = floatval( $this->input->post('alerta'));
      $data['producto']['cantidad'] = floatval( $this->input->post('cantidad'));
      $data['producto']['unidad'] = htmlentities( $this->input->post('unidad'));


    }
    $this->render([['pages/productos/actualizar', $data]]);
  }

  public function ver( $id ) {
    $this->logged();
    $data['producto'] = $this->productos_model->leer($id);
    $this->render([['pages/productos/ver', $data]]);
  }

  public function eliminar ($id = 0) {
    $usuario = $this->loggedAndAdmin();
    $this->productos_model->eliminar($id);
    $this->registrar($id, $usuario, 13, 'productos');
    redirect('/productos', 'refresh');
  }

  public function stock ($id = 0) {
    $usuario = $this->loggedAndAdmin();
    $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|numeric');
    $this->form_validation->set_rules('opcion', 'Opción', 'required|in_list[incrementar,reducir]');
    $this->form_validation->set_message('required', '<strong>%s</strong> es un campo obligatio');
    $this->form_validation->set_message('numeric', '<strong>%s</strong> ingresado incorrectamente');
    $this->form_validation->set_message('in_list', '<strong>%s</strong> ingresado incorrectamente');

    if ($this->form_validation->run()) {
      if( $this->input->post('opcion') == 'reducir' ) {
        $this->productos_model->reducir( $id, $this->input->post('cantidad') );
        $this->registrar($id, $usuario, 21, 'productos');
      } else {
        if( $this->input->post('opcion') == 'incrementar' ) {
          $this->productos_model->incrementar( $id, $this->input->post('cantidad') );
          $this->registrar($id, $usuario, 20, 'productos');
        }
      }
    }
    redirect( base_url("/productos"), 'refresh' );
  }

  public function restaurar( $id ) {
    $usuario = $this->loggedAndAdmin();
    $this->productos_model->restaurar($id);
    redirect(base_url('/productos'), 'refresh');
  }
}
