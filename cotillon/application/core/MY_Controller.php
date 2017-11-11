<?php
class MY_Controller extends CI_Controller {
  public function __construct ()
  {
    parent::__construct();
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
}
