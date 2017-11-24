<?php defined('BASEPATH') || exit('No direct script access allowed');

class Registros extends MY_Controller {
  public function __construct() {
    parent::__construct();
  }

  private function parseFecha($fecha) {
    return DateTime::createFromFormat('Y-m-d H:i:s', $fecha)->format('d/m/Y H:i:s');
  }

  private function parseOracion($datos) {
    if ($datos === '') return '';
    $retorno = $this->parseFecha($datos['fecha'])." - ";
    $retorno .= "El usuario ".$datos['usuario_emisor']." <ID:".$datos['id_usuario']."> ";
    $retorno .= $datos['nombre_evento']." <ID:".$datos['id_objetivo']."> ";
    switch ($datos['tabla']) {
      case "caja":
        $retorno .= "con un monto estimado de $".$datos['datos']['monto_cierre_estimado'];
        $retorno .= " y un monto real de $".$datos['datos']['monto_cierre_real'];
        break;
      case "categorias_producto":
        $retorno .= "de nombre ".$datos['datos']['nombre_categoria'];
        break;
      case "clientes":
        $retorno .= "de nombre ".$datos['datos']['nombre_cliente'];
        break;
      case "localidades":
        $retorno .= "de nombre ".$datos['datos']['nombre_localidad'];
        $retorno .= ', barrio '.$datos['datos']['barrio'];
        break;
      case "pedidos":
        $retorno .= "con un monto total de $".$datos['datos']['precio_total'];
        break;
      case "productos":
        $retorno .= "de nombre ".$datos['datos']['nombre'];
        break;
      case "proveedores":
        $retorno .= "de nombre ".$datos['datos']['nombre_proveedor'];
        break;
      case "usuarios":
        $retorno .= "de nombre ".$datos['datos']['apellido'].', '.$datos['datos']['nombre'];
        break;
      case "ventas":
        $retorno .= "con un monto total de $".$datos['datos']['total'];
        break;
      case "movimientos":
        $retorno .= "con un monto de $". $datos['datos']['multiplicador'] * $datos['datos']['monto'] ." en concepto de ". $datos['datos']['descripcion'];
      default:
        break;
    }
    return $retorno.'.';
  }

	public function index () {
    $this->loggedAndAdmin();
		$pagina = intval($this->input->get('pagina'));
		$pagina = $pagina === 0 ? 1 : $pagina;
    $idUsuarioFiltrado = intval($this->input->get('usuario'));
    $idUsuarioFiltrado = $idUsuarioFiltrado ? $idUsuarioFiltrado : null;

    $datos = $this->registro->lista($pagina, $idUsuarioFiltrado);

		$data['oraciones'] = array_map(function ($x){return $this->parseOracion($x);}, $datos);
		$data['pagina_actual'] = $pagina;
		$data['cantidad'] = $this->registro->cantidad_total();

		$this->render([['pages/registros/index', $data]]);
	}
}
