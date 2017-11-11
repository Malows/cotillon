<?php defined('BASEPATH') || exit('No direct script access allowed');

class Registros_model extends MY_Model {

  function __construct() {
    parent::__construct();
    $this->nombre_tabla = 'registros';
    $this->clave_primaria = 'id_registro';
  }

protected function sanitizar( Array $data ) {
  $data['id_usuario'] = intval( $data['id_usuario'] );
  $data['id_evento'] = intval( $data['id_evento'] );
  $data['id_objetivo'] = intval( $data['id_objetivo'] );
  $data['tabla'] = htmlentities( $data['tabla'] );
  return $data;
}


private function tabla_punto_id ($tabla, $quitarPrefijo = false) {
  $prefix = $quitarPrefijo ? '' : "$tabla.";
  switch ($tabla) {
    case "caja":
      return "$prefix"."id_caja";
    case "categorias_producto":
      return "$prefix"."id_categoria";
    case "clientes":
      return "$prefix"."id_cliente";
    case "localidades":
      return "$prefix"."id_localidad";
    case "pedidos":
      return "$prefix"."id_pedido";
    case "productos":
      return "$prefix"."id_producto";
    case "proveedores":
      return "$prefix"."id_proveedor";
    case "usuarios":
      return "$prefix"."id_usuario";
    case "ventas":
      return "$prefix"."id_venta";
    default:
      return "$prefix"."id";
  }
}

private function tabla_punto_nombre ($tabla, $quitarPrefijo = false) {
  $prefix = $quitarPrefijo ? '' : "$tabla.";
  switch ($tabla) {
    case "categorias_producto":
      return "$prefix"."nombre_categoria";
    case "clientes":
      return "$prefix"."nombre_cliente";
    case "localidades":
      return "$prefix"."nombre_localidad";
    case "productos":
      return "$prefix"."nombre";
    case "proveedores":
      return "$prefix"."nombre_proveedor";
    default:
      return false;
  }
}

private function purge_tablas ( $datos ) {
  return array_reduce($datos, function ($carry, $elem) {
    if (!in_array($elem['tabla'], $carry)) $carry[] = $elem['tabla'];
    return $carry;
  }, []);
}

private function purge_id_tabla ( $datos, $tabla ) {
  return array_reduce($datos, function ($carry, $elem) use ($tabla) {
    if (!in_array($elem['id_objetivo'], $carry) && $elem['tabla'] === $tabla)
      $carry[] = intval($elem['id_objetivo']);
    return $carry;
  }, []);
}

private function sintetizar ($tabla, $ids) {
  return ['tabla' => $tabla, 'ids' => $ids];
}

public function registrar ($usuario, $evento, $tabla, $objetivo) {
  $data = [
      'id_usuario' => intval($usuario),
      'id_evento' => intval($evento),
      'id_objetivo' => intval($objetivo),
      'tabla' => htmlentities($tabla),
    ];
    $this->db->insert('registros', $data);
  }

public function lista ($pagina = 1) {
    $desde = ($pagina - 1) * 100;
    $this->db->join('usuarios', 'usuarios.id_usuario = registros.id_usuario');
    $this->db->join('eventos', 'eventos.id_evento = registros.id_evento');
    $this->db->order_by('fecha', 'DESC');
    $this->db->limit( 100, $desde );
    $this->db->select('usuarios.nombre as usuario_emisor, registros.id_usuario, eventos.descripcion as nombre_evento, id_objetivo, tabla, fecha');
		$respuestas = $this->db->get('registros')->result_array();

    $tablas = $this->purge_tablas($respuestas);

    $datosObjetivosOrdenados = array_map(function ($elem) use ($respuestas) {
      $idFiltrados = $this->purge_id_tabla($respuestas, $elem);
      return $this->sintetizar($elem, $idFiltrados);
    }, $tablas);

    $datosObjetivosOrdenados = array_map(function ($elem){
      $this->db->where_in($this->tabla_punto_id($elem['tabla']), $elem['ids']);
      $elem['datos'] = $this->db->get($elem['tabla'])->result_array();
      return $elem;
    }, $datosObjetivosOrdenados);

    return array_map(function ($elem) use ($datosObjetivosOrdenados) {
      $aux = array_filter($datosObjetivosOrdenados, function($x) use($elem) {
        return $x['tabla'] == $elem['tabla'];
      });

      $aux = array_values($aux)[0];

      $datoFiltrado = array_filter($aux['datos'], function($x) use($elem, $aux) {
        $nombre_id = $this->tabla_punto_id( $aux['tabla'], true);
        return $x[$nombre_id] == $elem['id_objetivo'];
      });

      $datoFiltrado = array_values($datoFiltrado);
      $datoFiltrado = $datoFiltrado[0];

      $nombreCatcheado = $this->tabla_punto_nombre($aux['tabla'], true);

      if ($nombreCatcheado) $elem['nombre'] = $datoFiltrado[$nombreCatcheado];
      $elem['datos'] = $datoFiltrado;

      return $elem;
    }, $respuestas);
  }


  public function cantidad_total () {
    return $this->db->count_all($this->nombre_tabla);
  }
}
