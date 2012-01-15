<?php
class Grupo extends MY_Model {
	
	function __construct(){
		parent::__construct();
		$this->id_temporada = $this->temporada->get_id_actual();
	}
	
	function get_equipos($id_grupo){
		$this->db->where('id_temporada', $this->id_temporada);
	    $this->db->where('grupo', $id_grupo);
	    $this->db->where('activo',1);
	    $equipos = $this->db->get('equipos')->result();
		log_message('debug',__CLASS__.'::'.__FUNCTION__.':: '.$this->db->last_query());
		return $equipos; 
	}
	
	function _guess_fase(){
		$this->db->where('id_temporada',$this->id_temporada);
		$fase =  $this->db->get('campeonatos')->row();
		log_message('debug',__CLASS__.'::'.__FUNCTION__.':: '.$this->db->last_query());
		return $fase;
	}
	
	function guardar(){		
		$id_grupo = $this->input->post('id_grupo');
		$nombre = $this->input->post('nombre');
		$id_fase = $this->input->post('id_fase');
		if(empty($id_fase))
			$id_fase = $this->_guess_fase()->id_campeonato;
		$id_liga = $this->liga->get_id_actual();
		
		$grupo = array('nombre'=>$nombre, 
						'id_liga'=>$id_liga, 
						'id_temporada'=>$this->id_temporada,
						'id_fase' => $id_fase);		
		
		if(!empty($id_grupo)){	
			$this->db->where('id_grupo',$id_grupo);		
			$this->db->update('grupos', $grupo);
		} else {
			$this->db->insert('grupos', $grupo);
			$id_grupo = $this->db->insert_id();
		}
		
		log_message('debug',__CLASS__.'::'.__FUNCTION__.':: '.$this->db->last_query());
		if ($this->db->affected_rows()>0){
			return $id_grupo;
		} else {
			return FALSE;
		}
		
	}
	
	function get($id_grupo){
		$this->db->where('id_grupo',$id_grupo);
		$query = $this->db->get('grupos')->row();		
		return($query);
	}
	
	function get_all(){	
		$this->db->where('id_temporada' ,$this->temporada->get_id_actual());
		$this->db->order_by('nombre','asc');
		$query = $this->db->get('grupos')->result();
		return($query);
	}
	
	function get_grupos_dropdown(){
		$fech = $this->get_all();
		$grupos = array('0'=>'Ninguno');
		foreach ($fech as $f){
			$grupos[$f->id_grupo]=$f->nombre;
		}
		return $grupos;		 
	}
}