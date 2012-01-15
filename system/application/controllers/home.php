<?php

class Home extends Controller {
    
    function __construct ()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('partido');
        $this->load->model('liga');
        $this->load->model('fecha');         
    }
    
    function result(){
    	$data['template']['title'] = 'Liga';
        $data['fechas'] = $this->fecha->get_all();
        $data['partidos'] = $this->partido->get_all_as_array();
        log_message('debug', print_r($data['partidos'],true));
        $this->load->view('resultados/resultados',$data);
    }

    function original(){
        $this->load->view('resultados/resultados_backup');
    }
    
    function index ()
    {  
    	$this->load->model('campeonato');
    	$this->load->model('grupo');  
        $data['partidos'] = $this->partido->get_all();
        $data['siguiente_fecha'] = $this->fecha->get_siguiente_fecha();           
        $data['ultima_fecha'] = $this->fecha->get_ultima_fecha();
        $data['campeonatos'] = $this->campeonato->get_activos(); 
        $data['grupos'] = $this->grupo->get_grupos_dropdown(); 
        $data['liga'] = $this->liga->get_actual($this->config->item('base_url'));     
        log_message('debug', print_r($data['siguiente_fecha'], true));
        $this->layout->view('public/home_view', $data);         
    }
    
    function contacto() {
        $this->layout->view('public/contacto_view');        
    }
    
}

?>