<?php

class Posiciones extends Controller {
    
    function Posiciones () {
        parent::Controller();
        $this->load->model('equipo');
        $this->load->model('partido');
        $this->load->model('campeonato');
        $this->load->model('grupo');
        
    }

    function index () {
        $this->actualizar_posiciones();
    	$grupos = $this->grupo->get_all();
        $data['grupos'] = $grupos;
   	       		
        	$data['equipos'] = $this->equipo->get_all();        	             
        
        $this->layout->view('public/posiciones_view', $data);
    }
    
    function actualizar_posiciones(){
    	
    	$liga = $this->liga->get_actual($this->config->item('base_url'));
    	//if ($liga->update_resultados > $liga->update_posiciones){
			$this->firephp->info('actualizar tabla de posiciones');
			
			$equipos = $this->equipo->get_all();        	
        	foreach ($equipos as $e) {
	            $this->equipo->update_stats_equipo($e->id_equipo);
    	        $ok = true;
        	}	   		  
 	
    }
    /*
    function update_goles() {
        $this->load->library('firephp');
        $partidos = $this->partido->get_partidos_fase_regular_jugados();
        foreach ($partidos as $partido) {
            $this->db->where('id_partido', $partido->id_partido);
            $this->db->where('id_equipo', $partido->id_equipo_local);
            $this->db->where('incidente', 'gol');
            $goles_local = $this->db->get('incidentes')->num_rows();
            $this->db->where('id_partido', $partido->id_partido);
            $this->db->where('id_equipo', $partido->id_equipo_visita);
            $this->db->where('incidente', 'gol');
            $goles_visita = $this->db->get('incidentes')->num_rows();
            
            $this->db->where('id_partido', $partido->id_partido);
                        
            $this->db->update('partidos', array('goles_local' => $goles_local, 'goles_visita' =>$goles_visita));
        }        
    }*/
    
          
    
    
   
}
?>