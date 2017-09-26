<?php defined('BASEPATH') || exit('No direct script access allowed');

class Registros_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function registrar ($usuario, $evento, $tabla, $objetivo) {
    $data = [
      'id_usuario' => intval($usuario),
      'id_evento' => intval($evento),
      'id_objetivo' => intval($objetivo),
      'tabla' => htmlentities($tabla),
    ];

    $this->db->insert('registros', $data);
  }

}
