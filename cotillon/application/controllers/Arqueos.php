<?php defined('BASEPATH') || exit('No direct script access allowed');

class Arqueos extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index () {
    $this->logged();
    $pagina = intval( $this->input->get('pagina') );
    $pagina = $pagina !== 0 ? $pagina : 1;
    $data = [
      'cantidadTotalDeArqueos' => $this->caja->contar_total(),
      'paginaActual' => $pagina,
      'arqueos' => $pagina ? $this->caja->lista($pagina) : $this->caja->lista()
    ];

    $this->render([['pages/arqueos/index', $data]], null, [['pages/arqueos/index_script', []]]);
  }

  public function estimar_caja () {
    if (count($this->caja->lista_cajas_abiertas()) != 1)
      echo json_encode(['success' => false, 'message' => 'No existen cajas abiertas.']);
    echo json_encode(['success' => true, 'caja' => $this->caja->estimar_caja()]);
  }

  public function cerrar_caja () {
    $real = floatval( $this->input->post('real') );
    if (count($this->caja->lista_cajas_abiertas()) != 1)
      echo json_encode(['success' => false, 'message' => 'No existen cajas abiertas.']);
    echo json_encode(['success' => true, 'caja' => $this->caja->cerrar_caja($real)]);
  }

  public function abrir_caja () {
    $monto = floatval( $this->input->post('monto') );
    if (count($this->caja->lista_cajas_abiertas()) != 0)
      echo json_encode(['success' => false, 'message' => 'Existen cajas abiertas.']);
    echo json_encode(['success' => true, 'caja' => $this->caja->abrir_caja($monto)]);
  }
}
