<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('ventas_model');
    $this->load->model('detalles_venta_model');
  }

  public function index() {

  }

  public function crear() {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {
      $this->load->model("productos_model");
      $this->load->model("clientes_model");
      $data = [
        'productos' => $this->productos_model->lista_limpia(),
        'clientes' => $this->clientes_model->lista_limpia()
      ];
      for ($i=0; $i < count( $data['productos'] ); $i++) {
        $data['productos'][$i]['nombre'] = html_entity_decode($data['productos'][$i]['nombre']);
      }
      $this->load->view('includes/header');
      $this->load->view('pages/ventas/crear');
      $this->load->view('includes/footer_vue1');
      $this->load->view('pages/ventas/scripts_crear', $data);
      $this->load->view('includes/footer_vue2');
    }
  }

  public function api_emitir_venta($payload = null) {
    if ( ! $this->session->userdata('esta_logeado') ) {
      show_404();
    } else {

      $cliente = $this->input->get('cliente');
      $productos = $this->input->get('productos');
      $total_de_venta = 0;

      // Inserto la venta con total 0 y el id del cliente
      $this->ventas_model->crear($cliente['id'], $total_de_venta);

      // Obtengo el id de la ultima venta grabada en disco (total 0)
      $ultimo_id = $this->ventas_model->last_id();

      // Parseo el array para hacer un insert_batch
      for($i= 0; $i < count($productos); $i++) {
        $productos[$i]['cantidad'] = floatval( $productos[$i]['cantidad'] );
        $productos[$i]['precio_unitario'] = floatval( $productos[$i]['precio'] );
        $productos[$i]['id_producto'] = intval( $productos[$i]['id'] );
        $productos[$i]['id_venta'] = $ultimo_id;
        //voy sumando el total de venta
        $total_de_venta += $productos[$i]['cantidad'] * $productos[$i]['precio_unitario'];
        //elimino claves innecesarias
        unset(
          $productos[$i]['precio'],
          $productos[$i]['nombre'],
          $productos[$i]['id'],
          $productos[$i]['stock'] );
      }
      // var_dump($productos);
      // insercion en bloque de todas las lineas de la venta
      $aux = $this->detalles_venta_model->batch_insertion($productos);
      // var_dump($aux);
      // actualizo la venta con el nuevo total de venta
      $this->ventas_model->actualizar($ultimo_id, $cliente['id'], $total_de_venta);


      log_message('info', 'Se vendió al cliente '.$cliente['nombre']."<ID:".$cliente['id']."> los productos listados en la venta <ID:$ultimo_id> por un total de $$total_de_venta");
    }
  }


}