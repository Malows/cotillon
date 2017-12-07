<?php defined('BASEPATH') || exit('No direct script access allowed');

class Registros extends MY_Controller {
  public function __construct() {
    parent::__construct();
  }

  private function parseFecha($fecha) {
    return DateTime::createFromFormat('Y-m-d H:i:s', $fecha)->format('Y/m/d H:i:s');
  }

  private function dateInput ($input, $zero = true) {
    $argentina = new DateTimeZone('America/Argentina/Buenos_Aires');
    if ($input === '_' || !$input) return false;

    if ($input === 'hoy' || $input === 'semana') $input = new DateTime('now', $argentina);

    if ($input === 'semana') $input->modify('-7days');

    if (is_string($input) && strpos($input, '-') !== false) $input = DateTime::createFromFormat('Y-m-d', $input, $argentina);

    if ($zero) $input->setTime(0, 0, 0);
    else $input->setTime(23, 59, 59);

    return $input;
  }

  private function desdeHasta ($desde, $hasta) {
    return [$this->dateInput($desde), $this->dateInput($hasta, false)];
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

	public function index ($desde = null, $hasta = null, $idUsuario = null) {
    $this->loggedAndAdmin();
    $this->load->model('usuarios_model');

    $idUsuario = intval($idUsuario);
    $arr = $this->desdeHasta($desde, $hasta);

    $datos = $desde === '_' && $hasta === '_'
    ? $this->registro->ultimos_50_elementos(intval($idUsuario))
    : $this->registro->desde_hasta($arr[0], $arr[1], intval($idUsuario));

    if ($idUsuario) $data['usuarioSeleccionado'] = $idUsuario;

		$data['oraciones'] = array_map(function ($x){return $this->parseOracion($x);}, $datos);
    $data['usuarios'] = $this->usuarios_model->lista(true);

		$this->render([['pages/registros/index', $data]]);
	}
}
