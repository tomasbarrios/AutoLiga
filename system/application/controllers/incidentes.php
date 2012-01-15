<?php
class Incidentes extends Controller {
    
    function __construct() {
        parent::Controller();
        $this->load->model('incidente');
        $this->load->helper('form');
    }
    
    //update de que jugador esta involucrado en el incidente
    function guardar_incidente() {
    	$this->erkana_auth->required();
        $this->incidente->update_incidente();
    }  

    //guardar valor del input de goles/amarillas/incidentes
	function guardar_incidentes() {
		
        $this->erkana_auth->required();
        //no solo goles, sino amarillas y rojas.
        $this->load->library('firephp');
        $this->load->model('equipo');
        $this->load->model('jugador');
        $this->load->model('partido');
        $incidente = $this->input->post('incidente');
        $id_partido = $this->input->post('id_partido');
        $id_equipo = $this->input->post('id_equipo');
        $goles = $this->input->post('cant_incidentes');
        $gol = array('id_partido' => $id_partido, 'id_equipo' => $id_equipo, 'incidente' => $incidente);
        
        //update_partido
        if ($incidente == 'gol') {        	
        	$this->partido->update_goles($goles);
        }
        //goles ya registrados
        $goles_db = $this->incidente->get_incidentes($incidente);
        
        if ($goles_db == FALSE) {            
            $goles_db = 0;
        } else {
            $goles_db = count($goles_db);            
        }
        
        //insertamos goles faltantes
        $dif = $goles-$goles_db;       

        if ($dif > 0) {
            for ($i=0; $i<$dif; $i+=1) {
                $this->db->insert('incidentes', $gol);            
            }
        } elseif ($dif < 0) {
            for ($i=0; $i<abs($dif); $i+=1) {
                $this->db->limit(1);
                $this->db->delete('incidentes', $gol);            
            }
        }
        $this->load->model('liga');
        $this->liga->set_fecha_update_resultados();
         //if the validation was a success
        if (IS_AJAX) {
            $data['jugadores'] = $this->jugador->get_jugadores_dropdown($id_equipo);
            $data['incidentes'] = $this->incidente->get_incidentes($incidente);
            $this->load->view('partidos/td_jugadores', $data);
        }       
        //if validation failed
        else {
            echo "error";
        }
    }
    
    function get_incidentes(){
    	$this->load->model('jugador');        
    	$incidente = $this->input->post('incidente');        
        $id_equipo = $this->input->post('id_equipo');
    	$data['jugadores'] = $this->jugador->get_jugadores_dropdown($id_equipo);
        $data['incidentes'] = $this->incidente->get_incidentes($incidente);
    	$this->load->view('partidos/td_jugadores', $data);
    }
}
?>