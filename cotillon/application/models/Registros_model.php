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
    case "movimientos":
      return "$prefix"."id_movimiento";
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
    case "movimientos":
      return "$prefix"."descripcion";
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

  protected function hidratar ($respuestas) {
    // ['ventas', 'usuarios', ...]
    $tablas = $this->purge_tablas($respuestas);

    $datosObjetivosOrdenados = array_map(function ($elem) use ($respuestas) {
      $idFiltrados = $this->purge_id_tabla($respuestas, $elem);
      return $this->sintetizar($elem, $idFiltrados);
    }, $tablas);

    $datosObjetivosOrdenados = array_map(function ($elem){
      $this->db->where_in($this->tabla_punto_id($elem['tabla']), $elem['ids']);
      if ($elem['tabla'] === 'movimientos') $this->db->join('razones_movimientos', 'movimientos.id_razon_movimiento = razones_movimientos.id_razon_movimiento ');
      $elem['datos'] = $this->db->get($elem['tabla'])->result_array();
      return $elem;
    }, $datosObjetivosOrdenados);

    return array_map(function ($elem) use ($datosObjetivosOrdenados) {
      $aux = array_filter($datosObjetivosOrdenados, function($x) use($elem) {
        return $x['tabla'] == $elem['tabla'];
      });

      $aux = array_values($aux);
      $aux = $aux[0];

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

  public function ultimos_50_elementos ($id_usuario) {
    $id_usuario = intval($id_usuario);
    $this->db->join('usuarios', 'usuarios.id_usuario = registros.id_usuario');
    $this->db->join('eventos', 'eventos.id_evento = registros.id_evento');
    $this->db->order_by('fecha', 'DESC');
    if ($id_usuario) $this->db->where('registros.id_usuario', $id_usuario);
    $this->db->limit(50, 0);
    $this->db->select("concat(usuarios.nombre, ' ', usuarios.apellido) as usuario_emisor");
    $this->db->select("registros.id_usuario, eventos.descripcion as nombre_evento, id_objetivo, tabla, fecha");
    $respuestas = $this->db->get('registros')->result_array();
    return $this->hidratar($respuestas);
  }

  public function desde_hasta ($desde, $hasta, $id_usuario) {
    $id_usuario = intval($id_usuario);
    $this->db->join('usuarios', 'usuarios.id_usuario = registros.id_usuario');
    $this->db->join('eventos', 'eventos.id_evento = registros.id_evento');
    $this->db->order_by('fecha', 'DESC');
    if ($id_usuario) $this->db->where('registros.id_usuario', $id_usuario);
    if ($desde)
      $this->db->where('registros.fecha >=', $desde->format('Y-m-d H:i:s'));
    if ($hasta)
      $this->db->where('registros.fecha <=', $hasta->format('Y-m-d H:i:s'));
    $this->db->select("concat(usuarios.nombre, ' ', usuarios.apellido) as usuario_emisor");
    $this->db->select("registros.id_usuario, eventos.descripcion as nombre_evento, id_objetivo, tabla, fecha");
    $respuestas = $this->db->get('registros')->result_array();
    return $this->hidratar($respuestas);
  }
}
