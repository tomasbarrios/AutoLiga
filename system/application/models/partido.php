<?php
class Partido extends MY_Model{
        
	function  __construct() {
        	parent::__construct();
                $this->table = 'partidos';
                $this->primary_key = 'id_partido';
                $this->id_temporada = $this->temporada->get_id_actual();
				$this->id_liga = $this->liga->get_id_actual();
	}

        function get_by_team($id_equipo){
            $this->db->or_where(array('id_equipo_local'=>$id_equipo, 'id_equipo_visita'=>$id_equipo));
            $partidos = $this->db->get('partidos')->result();
            $this->firephp->info($partidos);
            return $partidos;
        }

        function get_all_as_array($id_campeonato = null){
            $partidos = $this->get_all($id_campeonato);
            $array = array();
            foreach ($partidos as $p){
                $array[$p->id_fecha][$p->id_partido] = $p;
            }
            return $array;
        }

        function get_all($id_campeonato = null) {
            $this->db->select('partidos.*');
            $this->db->select('grupo.nombre as grupo');
            $this->db->select('local.nombre as local');
            $this->db->select('visita.nombre as visita');            
            $this->db->where('partidos.id_temporada', $this->id_temporada);
            $this->db->join('equipos as local', 'local.id_equipo=id_equipo_local', 'left');
            $this->db->join('equipos as visita', 'visita.id_equipo=id_equipo_visita', 'left');
            $this->db->join('grupos as grupo', 'grupo.id_grupo=partidos.id_grupo', 'left');
            $this->db->order_by('grupo.id_grupo', 'asc');
            $this->db->order_by('partidos.fecha', 'asc');

            if (!empty($id_campeonato)) {
                $this->db->where('partidos.id_campeonato', $id_campeonato);
            }
            $query = $this->db->get('partidos')->result();
            return $query;
        }

	function get_partidos_grupo($id_grupo){
            $this->db->where('partidos.id_liga',$this->liga->get_id_actual());
            $this->db->select('partidos.*');
            $this->db->select('grupo.nombre as grupo');
            $this->db->select('local.nombre as local');
            $this->db->select('visita.nombre as visita');
            $this->db->join('equipos as local', 'local.id_equipo=id_equipo_local', 'left');
            $this->db->join('equipos as visita', 'visita.id_equipo=id_equipo_visita', 'left');
            $this->db->join('grupos as grupo', 'grupo.id_grupo=partidos.id_grupo', 'left');
            $this->db->join('campeonatos as campeonato', 'campeonato.id_campeonato=partidos.id_campeonato', 'left');
            $this->db->where('campeonato.formato','regular');
            $this->db->order_by('grupo.id_grupo' ,'asc');
            $this->db->order_by('partidos.fecha' ,'asc');

            if(!empty($id_grupo)){
                    $this->db->where('partidos.id_grupo',$id_grupo);
            }
            $query = $this->db->get('partidos')->result();
            return $query;
	}
	
	function get_partido($id_partido) {
                $this->db->select('partidos.*');
                $this->db->where('id_partido',$id_partido);
		$query = $this->db->get('partidos');
		
		if ($query->num_rows==1){
			return $query->row();
		} else {
			return FALSE;
		}		
	}

    function guardar($partido = null, $libre = FALSE) {
    	
		if(empty($partido)) {
      	  	$id_partido = $this->input->post('id_partido');  
	    	$partido['id_equipo_local'] = $this->input->post('local');
	        $partido['id_equipo_visita'] = $this->input->post('visita');
	        $partido['id_fecha'] = $this->input->post('id_fecha');
	        $partido['id_grupo'] = $this->input->post('grupo');
	        if (empty($partido['id_grupo'])){
	        	$partido['id_grupo']=null;
	        }
	        $partido['cancha'] = $this->input->post('cancha');
	        $partido['fecha'] = $this->dia_a_db($this->input->post('fecha'));
	        $partido['id_campeonato'] = $this->input->post('id_campeonato');
	    	$partido['fecha_libre'] = $this->input->post('libre');
		}
		
 		$partido['id_liga'] = $this->liga->get_id_actual(); 
        $partido['id_temporada'] = $this->temporada->get_id_actual();

		if ($partido['fecha_libre']){
			$partido['id_equipo_visita'] = null;
			$partido['cancha'] = 0;
        } else {
        	$partido['fecha_libre'] = 0;
        }    
        
        if (!empty($id_partido)) {
        	$this->db->where('id_partido', $id_partido);
        	$this->db->update('partidos',$partido);
        } else {
        	$this->db->insert('partidos',$partido);	
        }   
  
        if ($this->db->affected_rows() == '1'){
            return TRUE;
        } else {       
        	return FALSE;
        }
    }
    
    function get_resumen_goles(){
        $this->db->select('id_partido, goles_local, goles_visita, id_equipo_local, id_equipo_visita');        
        $this->db->where('jugado', 1);
        $query = $this->db->get('partidos')->result_array();
        foreach ( $query as $gol ) {
            $goles[$gol['id_partido']][$gol['id_equipo_local']] = empty($gol['goles_local'])? '' : $gol['goles_local'];
            $goles[$gol['id_partido']][$gol['id_equipo_visita']] = empty($gol['goles_visita'])? '' : $gol['goles_visita'];
        }
        return $goles;
    }
    
    function update_goles($cant) {
    	$id_equipo = $this->input->post('id_equipo');
    	$id_partido = $this->input->post('id_partido');
    	$partido = $this->get_partido($id_partido);
    	if ($partido->id_equipo_local == $id_equipo){
    		$partido->goles_local = $cant;
    	} elseif ($partido->id_equipo_visita == $id_equipo){
			$partido->goles_visita = $cant;
    	}
    	$this->db->where('id_partido',$id_partido);
    	$this->db->update('partidos',$partido);
    	if ($this->db->affected_rows() == '1'){
            return TRUE;
        }        
        return FALSE;
    }
    
    function dia_a_db($fecha, $libre = FALSE) {
    	$libre = $this->input->post('libre');
   	
        $split = explode(' ',$fecha);
        $fecha = $split[0];
        $hora = $split[1];
        if ($libre == TRUE){
        	//para que aparezca al final de las listas
        	$hora = '23:59';
        }
        $fecha = explode('/',$fecha);        
        return ($fecha[2].'-'.$fecha[1].'-'.$fecha[0].' '.$hora);
    }
}
?>