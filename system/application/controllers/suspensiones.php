<?php
class Suspensiones extends Controller{
	
	function __construct(){
		parent::Controller();
		$this->load->model('suspension');
	}
	
	//AJAX actualizar en admin
	function update(){
		$this->erkana_auth->required();
		$this->suspension->update();	
	}
	
	function index(){
		
		$this->load->model('fecha');		
		$fechas = $this->fecha->get_all();
		$data['fechas'] = $fechas;			
		$this->actualizar();	
		$data['suspensiones'] = $this->suspension->get_public_all();					 
		$this->layout->view('suspensiones/suspendidos_view',$data);
	}
	
	function actualizar(){
		$this->load->model('campeonato');
		$campeonatos = $this->campeonato->get_activos();
		foreach ($campeonatos as $c){
			$this->suspension->get_suspensiones_pendientes($c->id_campeonato);
		}
	}
	
	function admin(){
		$this->erkana_auth->required();
		$this->load->helper('form');		
		$data['title'] = "Suspensiones";
		$data['suspensiones'] = $this->suspension->get_all();		
		$this->layout->view('suspensiones/suspensiones_admin_view', $data);
	}
}
?>