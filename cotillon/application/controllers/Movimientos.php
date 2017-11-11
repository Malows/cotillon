<?php defined('BASEPATH') || exit('No direct script access allowed');

class Movimientos extends MY_Controller
{
  protected $config_validacion = [
      [
        'field' => 'monto',
        'label' => 'Monto',
        'rules' => 'required|numeric'
      ], [
        'field' => 'id_razon_movimiento',
        'label' => 'Descripcion',
        'rules' => 'required|is_natural_no_zero'
      ]
    ];

  protected $config_validacion_2 = [
      [
        'field' => 'multiplicador',
        'label' => 'Monto',
        'rules' => 'required|numeric'
      ], [
        'field' => 'descripcion',
        'label' => 'Descripcion',
        'rules' => 'required'
      ]
    ];

  public function __construct() {
    parent::__construct();
    $this->load->model('movimientos_model');
  }

	public function index () {
    $this->logged();
		$pagina = intval($this->input->get('pagina'));
		$pagina = $pagina === 0 ? 1 : $pagina;

		$data['movimientos'] = $this->movimientos_model->lista();
    $data['razones_movimientos'] = $this->movimientos_model->lista_razones();

		$this->render([['pages/movimientos/index', $data]]);
	}

  public function crear_razon () {
    $usuario = $this->logged();
    $this->form_validation->set_rules($this->config_validacion_2);
    $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio." );
    $this->form_validation->set_message('numeric', "<strong>%s</strong> debe ser un valor numérico." );

    if ($this->form_validation->run()) {
      $data = [
        'descripcion' => $this->input->post('descripcion'),
        'multiplicador' => $this->input->post('multiplicador')
      ];

      $id = $this->movimientos_model->crear_razon($data);
      $this->registrar($id, $usuario, 28, 'movimientos');
    }
    redirect('/movimientos', 'refresh');
  }

  public function crear () {
    $usuario = $this->logged();
    $this->form_validation->set_rules($this->config_validacion);
    $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio." );
    $this->form_validation->set_message('numeric', "<strong>%s</strong> debe ser un valor numérico." );
    $this->form_validation->set_message('is_natural_no_zero', "<strong>%s</strong> debe coincidir con un valor en la lista." );

    if ($this->form_validation->run()) {
      $data = [
        'id_razon_movimiento' => $this->input->post('id_razon_movimiento'),
        'monto' => $this->input->post('monto')
      ];
      $id = $this->movimientos_model->crear($data);
      $this->registrar($id, $usuario, 31, 'movimientos');
    }
    redirect(base_url('/movimientos'), 'refresh');
  }
}
