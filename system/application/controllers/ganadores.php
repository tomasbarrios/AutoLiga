<?php
class Ganadores extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model('premio');
		$this->load->model('ganador');
	}
	
	function ver(){
		$this->erkana_auth->required();
		$id_premio = $this->uri->segment(3);
		$data['premio'] = $this->premio->get($id_premio);
		$data['title'] = "Ganadores";
		$data['ganadores'] = $this->ganador->get_ganadores($id_premio);
		$this->layout->view('premios/ganadores_admin_view', $data);
	}
	
	function nuevo(){
		$this->erkana_auth->required();
		$id_premio = $this->uri->segment(3);
		$this->load->model('fecha');
		$this->load->model('equipo');
		$data['equipos'] = $this->equipo->get_equipos_dropdown();
		$data['fechas'] = $this->fecha->get_fechas_dropdown();
		$data['jugadores'] = array();
		$data['id_premio'] = $id_premio;		
		$data['premio'] = $this->premio->get($id_premio);
		$data['title'] = 'Nuevo Ganador';
		$this->layout->view('premios/asignar_premio_view', $data);
	}
	
	function editar(){
		$this->erkana_auth->required();
		$id_ganador = $this->uri->segment(3);
		$this->load->model('fecha');
		$this->load->model('equipo');
		$this->load->model('jugador');
		$data['ganador'] = $this->ganador->get($id_ganador);
		$data['equipos'] = $this->equipo->get_equipos_dropdown();
		$data['fechas'] = $this->fecha->get_fechas_dropdown();
		$data['jugadores'] = $this->jugador->get_jugadores_dropdown($data['ganador']->id_equipo);
		$data['id_premio'] = $data['ganador']->id_premio;		
		$data['premio'] = $this->premio->get($data['id_premio']);		
		$data['title'] = 'Editar Ganador';
		$this->layout->view('premios/asignar_premio_view', $data);
	}
	
	function ganadores(){
		$id_premio = $this->uri->segment(3);
		$data['premio'] = $this->premio->get($id_premio);		
		$data['ganadores'] = $this->premio->get_ganadores($id_premio);
		$data['title'] = $data['premio']->nombre;
		$this->layout->view('premios/ganadores_premio_view', $data);
	}
	
	function guardar(){
		$this->firephp->info($_POST);
		$this->erkana_auth->required();
    	$this->load->library('form_validation');
    	$this->form_validation->set_rules('id_ganador_premio');
		$this->form_validation->set_rules('id_premio','Premio','required|trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('id_fecha','Fecha','trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('id_jugador','Jugador','trim|xss_clean|max_length[45]');
		$id_premio = $this->input->post('id_premio');
		$premio = $this->premio->get($id_premio);
		if (!empty($premio)){
			if($premio->frecuencia == 'semanal'){
				$this->form_validation->set_rules('id_fecha','Fecha','required|trim|xss_clean|max_length[45]');
			}
			if($premio->tipo == 'jugador') {
				$this->form_validation->set_rules('id_jugador','Jugador','required|trim|xss_clean|max_length[45]');
			}	
		}
		$this->form_validation->set_rules('id_equipo','Equipo','required|trim|xss_clean|max_length[45]');
				

        //TODO validar
        if($this->form_validation->run() == FALSE){        	
			
			$this->load->model('fecha');
			$this->load->model('jugador');
			$this->load->model('equipo');
			$data['id_premio'] = $id_premio;
			$data['premio'] = $this->premio->get($id_premio);	
			$data['equipos'] = $this->equipo->get_equipos_dropdown();
			$data['fechas'] = $this->fecha->get_fechas_dropdown();
			$data['jugadores'] = $this->jugador->get_jugadores_dropdown();			
			$data['title'] = 'Editar Ganador	';
			$this->layout->view('premios/asignar_premio_view', $data);
        } else {        	
			$this->ganador->guardar();
			redirect('ganadores/ver/'.$this->input->post('id_premio'));
        }
	}
}