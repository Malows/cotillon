<?php
class MY_Controller extends CI_Controller {
  protected $error_delimiters = [
    '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> ',
    '</div>'
  ];

  public function __construct ()
  {
    parent::__construct();
    $this->form_validation->set_error_delimiters($this->error_delimiters[0], $this->error_delimiters[1]);
  }

  protected function render ($vistas, $header = null, $footer = null)
  {
    if ($header === null) $header = [['includes/header', []]];
    if ($footer === null) $footer = [['includes/footer', []]];

    if (is_string($header)) $header = [[$header, []]];
    if (is_string($vistas)) $vistas = [[$vistas, []]];
    if (is_string($footer)) $footer = [[$footer, []]];

    $toRender = array_merge($header, $vistas, $footer);
    foreach ($toRender as $elem) {
      $this->load->view($elem[0], $elem[1]);
    }
  }

  protected function logged ()
  {
    $usuario = $this->session->userdata('user');
    if (!$this->session->userdata('esta_logeado')) show_404();
    return $usuario;
  }

  protected function loggedAndAdmin ()
  {
    $usuario = $this->session->userdata('user');
    if (!$this->session->userdata('esta_logeado') && $usuario['id_tipo_usuario'] <= 2) show_404();
    return $usuario;
  }

  protected function registrar($last_id, $usuario, $id_registro, $tabla)
  {
    if ($last_id)
      $this->registro->registrar($usuario['id_usuario'], $id_registro, $tabla, $last_id);
  }
}
