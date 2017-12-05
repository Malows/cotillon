<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('ventas_model');
    $this->load->model('detalles_venta_model');
  }

  private function dateInput ($input, $zero = true) {
    $argentina = new DateTimeZone('America/Argentina/Buenos_Aires');
    if ($input === '_') return false;

    if ($input === 'hoy' || $input === 'semana') $input = new DateTime('now', $argentina);

    if ($input === 'semana') $input->modify('-7days');

    if (is_string($input) && strpos($input, '-') !== false) $input = DateTime::createFromFormat('Y-m-d', $input, $argentina);

    if ($zero) $input->setTime(0, 0, 0);
    else $input->setTime(23, 59, 59);

    return $input;
  }

  private function hoy() {
    return [$this->dateInput('hoy'), $this->dateInput('hoy', false)];
  }

  private function semana() {
    return [$this->dateInput('semana'), $this->dateInput('hoy', false)];
  }

  private function desdeHasta ($desde, $hasta) {
    return [$this->dateInput($desde), $this->dateInput($hasta, false)];
  }

  public function index($desde = null, $hasta = null) {
    $this->logged();
    $data = [];
    $data['cantidadTotalDeVentas'] = $this->ventas_model->contar_total();
    $arr = [];

    if ($desde === 'hoy') $arr = $this->hoy();
    else if ($desde === 'ultima_semana' || !$desde || ($desde === '_' && $hasta === '_')) $arr = $this->semana();
    else $arr = $this->desdeHasta($desde, $hasta);
    $data['ventas'] = $this->ventas_model->hasta($arr[0], $arr[1]);

    $this->render([['pages/ventas/index', $data]]);
  }

  public function crear() {
    $this->logged();
    $this->load->model("productos_model");
    $this->load->model("clientes_model");
    $data = [
      'productos' => $this->productos_model->lista_limpia(),
      'clientes' => $this->clientes_model->lista_limpia()
    ];
    for ($i=0; $i < count( $data['productos'] ); $i++) {
      $data['productos'][$i]['nombre'] = html_entity_decode($data['productos'][$i]['nombre']);
    }
    $this->render(
      [['pages/ventas/crear', []], ['includes/footer_vue1',[]], ['pages/ventas/scripts_crear', $data]],
      [['includes/header_modal', []]],
      [['includes/footer_vue2', []]]
    );
  }

  public function api_emitir_venta($payload = null) {
    $usuario = $this->logged();
    $this->load->model('productos_model');
    $cliente = $this->input->get('cliente');
    $cliente['id'] = $cliente['id'] ? $cliente['id'] : 1;
    $productos = $this->input->get('productos');
    $total_de_venta = 0;

    // Inserto la venta con total 0 y el id del cliente
    // Inicio transacción
    $this->ventas_model->crear(['id_cliente' => $cliente['id'], 'total' => $total_de_venta]);

    // Obtengo el id de la ultima venta grabada en disco (total 0)
    $ultimo_id = $this->ventas_model->last_id();

    // Parseo el array para hacer un insert_batch
    $productos = array_map(function ($x) use ($ultimo_id) {
      $x['cantidad_venta'] = floatval( $x['cantidad'] );
      $x['precio_unitario'] = floatval( $x['precio'] );
      $x['id_producto'] = intval( $x['id'] );
      $x['id_venta'] = $ultimo_id;
      //elimino claves innecesarias
      unset($x['precio'], $x['nombre'], $x['id'], $x['stock'], $x['cantidad']);
      return $x;
    }, $productos);

    // actualizo stocks en productos
    // voy sumando el total de venta
    $total_de_venta = array_reduce($productos, function($c, $x) {
      $this->productos_model->reducir($x['id_producto'], $x['cantidad_venta']);
      return $c + ($x['cantidad_venta'] * $x['precio_unitario']);
    }, 0);

    // insercion en bloque de todas las lineas de la venta
    $this->detalles_venta_model->batch_insertion($productos);

    // actualizo la venta con el nuevo total de venta
    // Finalizo transacción
    $this->ventas_model->actualizar($ultimo_id, ['id_cliente' => $cliente['id'], 'total' => $total_de_venta]);
    $this->registrar($ultimo_id, $usuario, 1, 'ventas');
  }

  public function ver ($id) {
    $this->logged();
    $data = [
      'venta' => $this->ventas_model->leer($id),
      'detalles' => $this->detalles_venta_model->buscar_por_venta($id)
    ];
    $this->render([['pages/ventas/ver', $data]]);
  }

  public function pdf($id) {
    $this->logged();
    $this->load->library('pdf');

    $data['venta'] = $this->ventas_model->leer($id);
    $data['detalles'] = $this->detalles_venta_model->buscar_por_venta($id);

    $html = $this->load->view('includes/recibo', $data, true);
    $fecha = $data['venta']['fecha'];

		// Convert to PDF
		$this->pdf->pdf->WriteHtml($html);
		$this->pdf->pdf->Output("venta-$fecha.pdf", 'D');
  }
}
