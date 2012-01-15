<?php
class Premios extends Controller {
	function __construct(){
		parent::Controller();
		$this->load->model('premio');
		$this->load->helper('form');
	}
	
	function editar(){
		$id_premio=$this->uri->segment(3);
		$this->load->model('sponsor');
		$data['sponsors'] = $this->sponsor->get_dropdown();
		$data['title'] = 'Editar';
		$data['premio'] =$this->premio->get($id_premio);
		$this->layout->view('premios/editar_premio_view', $data);
	}
	
	function admin(){
		$this->load->model('sponsor');
		
		$premios = $this->premio->get_all();
		$data['title'] = 'Premios';
		$data['premios'] = $premios;
		$data['sponsors'] = $this->sponsor->get_dropdown();
		$this->layout->view('premios/premios_admin_view', $data);
	}
	
	function ver(){
		$this->load->model('ganador');
		$id_premio = $this->uri->segment(3);
		$data['premio'] = $this->premio->get($id_premio);
		$data['title'] = "Ganadores ".$data['premio']->nombre;
		$data['ganadores'] = $this->ganador->get_ganadores($id_premio);
		$this->layout->view('premios/ganadores_public_view', $data);
	}
	
	function guardar(){
		$this->erkana_auth->required();
    	$this->load->library('form_validation');
    	$this->form_validation->set_rules('id_premio');
		$this->form_validation->set_rules('id_sponsor','Sponsor','required|trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('nombre','Nombre','required|trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('descripcion','Descripción','required|trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('frecuencia','Frecuencia','required|trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('tipo','Destino','required|trim|xss_clean|max_length[45]');

        //TODO validar
        if($this->form_validation->run() == FALSE){
        	$this->load->model('sponsor');
                $data['title'] = 'Editar Premio';
                $data['sponsors'] = $this->sponsor->get_dropdown();
        	$this->layout->view('premios/editar_premio_view', $data);	
        } else {        	
			$this->premio->guardar();
			redirect('premios/admin');
        }
		
	}
	
	function nuevo(){
		$data['title'] = 'Nuevo Premio';
		$this->load->model('sponsor');
		$data['sponsors'] = $this->sponsor->get_dropdown();
		$this->layout->view('premios/editar_premio_view', $data);		
	}

	function eliminar(){
		$this->erkana_auth->required();
		$id_premio = $this->uri->segment(3);
		$this->premio->eliminar($id_premio);
		redirect('premios/admin');
	}
}