<?php

class Equipo extends MY_Model {

	function __construct(){
		parent::__construct();
                $this->primary_key = 'id_equipo';
		$this->load->model('grupo');
		$this->load->model('partido');     
                $this->id_temporada = $this->temporada->get_id_actual();
        }

		function activo($id_equipo, $value){
			$this->db->where('id_equipo',$id_equipo);
			$this->db->set('activo',$value);
			$this->db->update('equipos');
			log_message('debug',$this->db->last_query());
		}
        
        function get_capitan($id_equipo){
            $this->db->select('jugadores.*');
            $this->db->where('equipos.id_equipo',$id_equipo);
            $this->db->join('equipos','equipos.id_capitan = jugadores.id_jugador');
            $capitan = $this->db->get('jugadores')->row();
            log_message('debug',$this->db->last_query());
            return $capitan;
        }
	
	function get_by_grupo($id_grupo){
		$this->db->where('id_temporada', $this->id_temporada);
		if(!empty($id_grupo)){
			$this->db->where('grupo',$id_grupo);
                        $this->db->where('activo',1);
		}
		$equipos = $this->db->get('equipos')->result();
		log_message('debug',$this->db->last_query());
		return $equipos;
	}
	
	function get_by_grupo_dropdown($id_grupo){
		$equipos['']='Seleccione';
		$e = $this->get_by_grupo($id_grupo);
		$this->firephp->info($e);
		foreach ($e as $equipo){
			$equipos[$equipo->id_equipo] = $equipo->nombre;
		}
		return $equipos;
	}
	
	function update_stats_equipo ( $id_equipo ) {
        $eq = $this->get($id_equipo);   		
        $partidos = $this->partido->get_partidos_grupo($eq->grupo);
   		
        $pg = 0;    //Ganados
        $pe = 0;    //Empatados
        $pp = 0;    //Perdidos
        $gf = 0;    //goles a favor
        $gc = 0;    //goles en contra
        $pwo = 0;   //WalkOver Perdidos (Ganados cuentan como ganados)
        $puntos = 0;
        
        foreach ( $partidos as $key => $partido ) {
        	$this->firephp->info('partido n: '.$key);
            
            if ($partido->fecha_libre==0
                    && $partido->jugado==1
                    && ($partido->id_equipo_local == $id_equipo || $partido->id_equipo_visita == $id_equipo)){

            	$result=$partido->goles_local - $partido->goles_visita;
            	log_message('debug','analizando resultado! diferencia de goles: '.$result);
                
                if ($result == 0) { //empate
                    $pe ++;
                }
                else if ($partido->id_equipo_local == $id_equipo) { //si jugo de local?:
                    if($partido->definicion == 'WalkOver' && $result < 0){
                        //si perdio en WalkOver
                        $pwo ++;
                    }
                    $gf += $partido->goles_local;
                    $gc += $partido->goles_visita;
                    if ( $result > 0 ) { $pg ++ ;}
                    if ( $result < 0 ) { $pp ++ ;}
                } else {
                    if($partido->definicion == 'WalkOver' && $result > 0){
                        //si perdio en WalkOver
                        $pwo ++;
                    }
                    $gf += $partido->goles_visita;
                    $gc += $partido->goles_local;
                    if ( $result < 0 ) { $pg ++ ;}
                    if ( $result > 0 ) { $pp ++ ;}
                }
            }          
        }                

        $equipo['pg'] = $pg;
        $equipo['pe'] = $pe;
        $equipo['pp'] = $pp;
        $equipo['gf'] = $gf;
        $equipo['gc'] = $gc;
        $equipo['puntos'] = $pg*3 + $pe - $pwo;
        $equipo['dg'] = $gf-$gc;
        $equipo['pwo'] = $pwo;
        $this->db->where('id_equipo',$id_equipo);
        $this->db->update('equipos', $equipo);	  
    }
	
    function get_all($really_all = false) {
		$this->db->where('id_temporada', $this->id_temporada);
        if(!$really_all)
            $this->db->where('activo',1);
    	$this->db->order_by('puntos','desc');
        $this->db->order_by('gf','desc');
    	$equipos = $this->db->get('equipos')->result();
		log_message('DEBUG',__CLASS__.'::'.__FUNCTION__.'Equipos Query: '.$this->db->last_query());
		log_message('DEBUG',__CLASS__.'::'.__FUNCTION__.'Equipos: '.print_r($equipos,TRUE));
    	return $equipos;
    }
    
    function get($id_equipo){
        $this->db->where('id_equipo',$id_equipo);
        $query = $this->db->get('equipos');
        $this->firephp->info($this->db->last_query());
        if ($query->num_rows()>0) {
            return $query->row();
        } else {
            return null;
        }        
    }
    
    function get_equipos_con_jugadores() {
        $query = $this->buscar_equipos_del_campeonato();
        $equipos = array();
        foreach ($query as $e) {
            $jugadores = $this->get_jugadores($e->id_equipo);
            $equipos[$e->id_equipo][0]='';
            foreach ($jugadores as $jugador){
                $equipos[$e->id_equipo][$jugador->id_jugador]=$jugador->nombre;
            }            
        }
        return $equipos;
    }

    function equipos_del_campeonato($id_fase)
    {        
		$this->db->select('equipos.*, grupos.nombre as grupo');
		$this->db->where('id_campeonato',$id_fase);
        $this->db->where('equipos.id_temporada', $this->id_temporada);
        $this->db->join('grupos','grupos.id_grupo = equipos.grupo');
        $this->db->order_by('grupos.nombre','desc');
        return $this->db->get('equipos')->result();        
    }
    
    function get_equipos_dropdown(){
    	$e = $this->get_all();
    	$equipos['']='Seleccione';
    	foreach ($e as $equipo){
    		$equipos[$equipo->id_equipo] = $equipo->nombre; 
    	}
    	return $equipos;
    }
    
    function buscar_equipos_del_grupo($grupo){
    	$this->db->where('id_temporada', $this->id_temporada);
        $this->db->where('grupo', $grupo);
        $this->db->where('activo',1);
        $this->db->from('equipos');
        $this->db->order_by('puntos','desc');
        $this->db->order_by('dg','desc');
        $this->db->order_by('gf','desc');
        $this->db->order_by('gc','desc');
        return $this->db->get()->result();
    }
   
    function guardar($equipo = null)
    {
        if(empty($equipo)){
            //from form
            log_message('debug',$_POST);
            $nombre = $this->input->post('nombre');
            $grupo = $this->input->post('grupo');
            $id_equipo = $this->input->post('id_equipo');
            $id_liga = $this->liga->get_id_actual();
            $id_temporada = $this->temporada->get_id_actual();
            $equipo = array(
                'nombre'=>$nombre, 
                'id_liga' => $id_liga,
                'id_temporada'=>$id_temporada,
                'grupo'=> $grupo);
        } 
        
		log_message('debug', __CLASS__.'::'.__FUNCTION__.' Validation Passed, saving team with: '.print_r($equipo,true));
        if (!empty($id_equipo)) {                 
            $this->db->where('id_equipo' , $id_equipo);
            $this->db->update('equipos', $equipo);   
        } else {
            //create
            $this->db->insert('equipos', $equipo);
            $id_equipo = $this->db->insert_id();
        }

        log_message('debug',$this->db->last_query());
        return $id_equipo;
    }

}

?>