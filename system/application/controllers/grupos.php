<?php
class Grupos extends Controller {
	function __construct(){
		parent::Controller();
		$this->load->model('grupo');
		$this->erkana_auth->required();
	}
	
	function crear(){
		echo $this->grupo->guardar();
	}
	
	function admin(){
		$data['grupos'] = $this->grupo->get_all();
		$data['title'] = 'Grupos';
		$this->load->model('campeonato');
		$data['fases'] = $this->campeonato->get_activos_dropdown();
		$this->layout->view('grupos/admin_grupos_view',$data);
	}
	
	function nuevo(){
		$data['title'] = 'Nuevo Grupo';		
		$this->load->model('campeonato');
		$data['fases'] = $this->campeonato->get_activos_dropdown();	
		$this->layout->view('grupos/editar_grupo_view',$data);
	}
	
	function editar($id_grupo){
		$data['title'] = 'Editar Grupo';
		$data['grupo'] = $this->grupo->get($id_grupo);	
		$this->load->model('campeonato');
		$data['fases'] = $this->campeonato->get_activos_dropdown();
		$this->layout->view('grupos/editar_grupo_view',$data);
	}
	
	function guardar(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_grupo');
		$this->form_validation->set_rules('nombre','Nombre','required|trim|max_length[20]|xss_clean');
		$this->form_validation->set_rules('id_fase','Fase','required');
		$this->form_validation->set_error_delimiters('<span class="error">','</span>');
		
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Editar Grupo';			 
			$this->load->model('campeonato');
			$data['fases'] = $this->campeonato->get_activos_dropdown();
			$this->layout->view('grupos/editar_grupo_view',$data);
			//mensaje_error('Existen errores en el formulario');
		} else {
			mensaje_ok('Grupo guardado');
			$this->grupo->guardar();
			redirect('grupos/admin');
		}
		
	}
}