<?php defined('BASEPATH') || exit('No direct script access allowed');

class Movimientos extends CI_Controller
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
  protected $error_delimiter = ['<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> ', '</div>'];

  public function __construct() {
    parent::__construct();
    $this->load->model('movimientos_model');
  }

	public function index () {
		if ( ! $this->session->userdata('esta_logeado')) {
			show_404();
		} else {
			$pagina = intval($this->input->get('pagina'));
			$pagina = $pagina === 0 ? 1 : $pagina;

			$data['movimientos'] = $this->movimientos_model->lista();
      $data['razones_movimientos'] = $this->movimientos_model->lista_razones();

			$this->load->view('includes/header');
			$this->load->view('pages/movimientos/index', $data);
			$this->load->view('includes/footer');
		}
	}

  public function crear_razon () {
    $this->form_validation->set_rules($this->config_validacion_2);
    $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio." );
    $this->form_validation->set_message('numeric', "<strong>%s</strong> debe ser un valor numérico." );
    $this->form_validation->set_error_delimiters($this->error_delimiter[0], $this->error_delimiter[1]);

    if ($this->session->userdata('esta_logeado')) {
      if ($this->form_validation->run()) {
        $data = [
          'descripcion' => $this->input->post('descripcion'),
          'multiplicador' => $this->input->post('multiplicador')
        ];

        $id = $this->movimientos_model->crear_razon($data);
        // $this->registro->
      }
      redirect('/movimientos', 'refresh');
    } else {
      show_404();
    }
  }

  public function crear () {
    $this->form_validation->set_rules($this->config_validacion);
    $this->form_validation->set_message('required', "<strong>%s</strong> es un campo obligatorio." );
    $this->form_validation->set_message('numeric', "<strong>%s</strong> debe ser un valor numérico." );
    $this->form_validation->set_message('is_natural_no_zero', "<strong>%s</strong> debe coincidir con un valor en la lista." );
    $this->form_validation->set_error_delimiters($this->error_delimiter[0], $this->error_delimiter[1]);

    if ($this->session->userdata('esta_logeado') && $this->form_validation->run()) {
      if ($this->form_validation) {
        $data = [
          'id_razon_movimiento' => $this->input->post('id_razon_movimiento'),
          'monto' => $this->input->post('monto')
        ];
        $id = $this->movimientos_model->crear($data);
        // $this->registro->
      }
      redirect('/movimientos', 'refresh');
		} else {
      show_404();
    }
  }
}
