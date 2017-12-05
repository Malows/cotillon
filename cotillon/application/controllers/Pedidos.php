<?php defined('BASEPATH') || exit('No direct script access allowed');

class Pedidos extends MY_Controller {

  public function __construct () {
    parent::__construct();
    $this->load->model('pedidos_model');
    $this->load->model('detalles_pedido_model');
  }

  public function index () {
    $this->logged();
    $data = [
      'pedidos' => $this->pedidos_model->lista(),
      'es_admin_usuario_logueado' => $this->session->userdata('es_admin') ];

    $this->render([['pages/pedidos/index', $data]]);
  }

  public function eliminar ($id = 0) {
    $usuario = $this->logged();
    $this->pedidos_model->eliminar($id);
    // TODO: el registro
    redirect('/pedidos', 'refresh');
  }

  public function crear () {
    $this->logged();
    $this->load->model('productos_model');
    $this->load->model('proveedores_model');

    $data = [
      'productos' => $this->productos_model->lista_limpia_pedido(),
      'proveedores' => $this->proveedores_model->lista_limpia()
    ];

    $this->render([['pages/pedidos/crear', []], ['includes/footer_vue1', []], ['pages/pedidos/scripts_crear', $data]],
      [['includes/header_modal', []]],
      [['includes/footer_vue2', []]]
    );
  }

  public function api_emitir_pedidos($payload = null) {
    $usuario = $this->logged();
    $proveedor = $this->input->get('proveedor');
    $productos = $this->input->get('productos');
    $total = $this->input->get('total');

    $last_id = $this->pedidos_model->crear(['id_proveedor' => $proveedor['id'], 'precio_total' => $total]);

    $productos = array_map(function ($x) use ($last_id) {
      $x['cantidad'] = floatval( $x['cantidad'] );
      $x['precio_unitario'] = floatval( $x['precio'] );
      $x['id_producto'] = intval( $x['id'] );
      $x['id_pedido'] = $last_id;
      unset( $x['precio'], $x['nombre'], $x['id'], $x['id_proveedor'] );
      return $x;
    }, $productos);

    $this->detalles_pedido_model->batch_insertion($productos);

    $this->registrar($last_id, $usuario, 22, 'pedidos');
  }

  public function recibir($id) {
    $usuario = $this->logged();

    $payload['precio_real'] = $this->input->post('precio_real');
    var_dump('antes del modelo', $payload);
    $last_id = $this->pedidos_model->recibir_pedido($id, $payload, $usuario);

    $this->registrar($last_id, $usuario, 25, 'pedidos');
  }

  public function ver ($id) {
    $this->logged();
    $data['consulta'] = $this->pedidos_model->listap($id);
    $this->render([['pages/pedidos/ver', $data]]);
  }

  public function restaurar ($id) {
    $usuario = $this->loggedAndAdmin();
    $this->pedidos_model->restaurar($id);
    redirect(base_url('/pedidos'), 'refresh');
  }

  public function pdf ($id) {
    $this->logged();
    $this->load->library('pdf');

    $data['pedido'] = $this->pedidos_model->listap($id);
    $html = $this->load->view('includes/pedido', $data, true);
    $fecha = $data['pedido'][0]['fecha_creation'];

		// Convert to PDF
		$this->pdf->pdf->WriteHtml($html);
		$this->pdf->pdf->Output("pedido-$fecha.pdf", 'D');
  }
}
