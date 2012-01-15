<?php
class Fechas extends Controller { 
	function __construct(){
		parent::Controller();
		$this->load->model('fecha');
		$this->load->helper('form');
	}
	
	function get_dia(){
		$id_fecha = $this->input->post('id_fecha');
		$fecha = $this->fecha->get($id_fecha);
		$fecha = date('d/m/Y H:i',strtotime($fecha->dia));
		$this->firephp->info($fecha);
		echo $fecha;
	}
	
	function guardar(){
		$this->erkana_auth->required();
		$this->load->library('form_validation');
    	$this->form_validation->set_rules('id_fecha');
		$this->form_validation->set_rules('nombre','Nombre','required|trim|xss_clean|max_length[45]');
    	$this->form_validation->set_rules('id_campeonato','Campeonato','required|trim|xss_clean|max_length[45]');
    	$this->form_validation->set_rules('dia','Dia','required|trim|xss_clean|max_length[45]');
    	$this->form_validation->set_error_delimiters('<span class="error">','</span>');
    	
    	if ($this->form_validation->run() == FALSE) {
    		$data['title'] = 'Editar Fecha';
    		$this->load->model('campeonato');
    		$data['campeonatos'] = $this->campeonato->get_activos_dropdown();
			$this->layout->view('fechas/editar_fecha_view',$data);
		} else {
			if($this->fecha->guardar()){
				mensaje_ok('Los datos fueron guardados');
				redirect('fechas/admin');	
			} else {			
				//error
				redirect('fechas/admin');
			}	
		}	
	}
	
	function admin(){
		$this->erkana_auth->required();
		$data['fechas'] = $this->fecha->get_all();
		$data['title'] = 'Fechas';
		$this->load->model('campeonato');
		$data['campeonatos'] = $this->campeonato->get_activos_dropdown();
		$this->layout->view('fechas/lista_fechas_view', $data);	
	}
	
	function editar(){
		$this->erkana_auth->required();
		$this->load->model('campeonato');
		$id_fecha = $this->uri->segment(3);
		$data['fecha'] = $this->fecha->get($id_fecha);
		$data['title'] = 'Editar Fecha';		
		$data['campeonatos'] = $this->campeonato->get_activos_dropdown();
		$this->layout->view('fechas/editar_fecha_view', $data);
	}
	
	function nuevo() {
		$this->erkana_auth->required();
		$this->load->model('campeonato');
		$data['title'] = 'Nueva Fecha';
		$data['campeonatos'] = $this->campeonato->get_activos_dropdown();
		$this->layout->view('fechas/editar_fecha_view', $data);
	}
}