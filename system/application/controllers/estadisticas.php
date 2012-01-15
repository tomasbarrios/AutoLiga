<?php

class Estadisticas extends Controller {
       
    function __construct (){
        parent::Controller();       
    }
        
    function goleadores () {
    	$this->load->model('incidente');
        $data['goleadores'] = $this->incidente->get_tabla_incidentes('gol');
    	$this->layout->view('public/goleadores_view', $data);
        //id!=0
    }
    
    function tarjetas () {
    	$this->load->model('incidente');
        $data['amarillas'] = $this->incidente->get_tabla_incidentes('amarillas');
        $data['rojas'] = $this->incidente->get_tabla_incidentes('amarillas');
    	$this->layout->view('public/tarjetas_view', $data);
        //id!=0
    }
}