<?php
class Campeonato extends Model {
	
	function __construct(){
		parent::Model();
                $this->id_temporada = $this->temporada->get_id_actual();
	}
	
	function eliminar_partidos($id_fase){
		$this->db->where('id_campeonato',$id_fase);
		$this->db->delete('partidos');
		log_message('DEBUG',__CLASS__.'::'.__FUNCTION__.$this->db->last_query());
	}
	
	function eliminar_fechas($id_fase){
		$this->db->where('id_campeonato',$id_fase);
		$this->db->delete('fechas');
		log_message('DEBUG',__CLASS__.'::'.__FUNCTION__.$this->db->last_query());
	}
	
	function get_grupos($id_fase){
		$this->db->where('id_fase',$id_fase);
		$grupos = $this->db->get('grupos')->result();
		return $grupos;
	}
	
	function guardar(){		
		$this->firephp->info($_POST);
		$id_campeonato = $this->input->post('id_campeonato');
		$campeonato['nombre'] = $this->input->post('nombre'); 
		$campeonato['formato'] = $this->input->post('formato');		
		if(!empty($id_campeonato)){	
			$this->db->where('id_campeonato',$id_campeonato);		
			$this->db->update('campeonatos', $campeonato);
		} else {			
			$campeonato['activo']=1;
			$campeonato['id_liga']=$this->liga->get_id_actual();
                        $campeonato['id_temporada'] = $this->id_temporada;
			$this->db->insert('campeonatos', $campeonato);
                        $id_campeonato = $this->db->insert_id();
		}
		if ($this->db->affected_rows()>0){
			return TRUE;
		} else {
			return FALSE;
		}
		
	}
	
	function get_equipos($id_fase)
    {        
		$this->db->select('equipos.*, grupos.nombre as grupo');
		$this->db->where('id_campeonato',$id_fase);
        $this->db->where('equipos.id_temporada', $this->id_temporada);
        $this->db->join('grupos','grupos.id_grupo = equipos.grupo');
        $this->db->order_by('grupos.nombre','desc');
		$equipos = $this->db->get('equipos')->result();  
        log_message('DEBUG',__CLASS__.'::'.__FUNCTION__.'Equipos del campeonato '.$id_fase.' : '.print_r($equipos,TRUE));
		return $equipos;  
    }
	
	function get($id_campeonato){
		
		$this->db->where('id_campeonato',$id_campeonato);
		$query = $this->db->get('campeonatos')->row();		
		
		$this->firephp->info($this->db->last_query());
		$this->firephp->info($query);
		
		return($query);
	}
	
	function get_activos($id_campeonato = null){
		if(!empty($id_campeonato))
				$this->db->where('id_campeonato',$id_campeonato);
		$this->db->where('id_temporada', $this->id_temporada);
		$this->db->where('activo','1');
		$query = $this->db->get('campeonatos')->result();
		return($query);
	}
	
	function get_activos_dropdown($id_campeonato = null){
		$camp = $this->get_activos($id_campeonato);
		$campeonatos = array(''=>'Seleccione');
		foreach ($camp as $c){
			$campeonatos[$c->id_campeonato]=$c->nombre;
		}
		return $campeonatos;		 
	}
}