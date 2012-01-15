<?php

class Jugador extends MY_Model {
	function __construct(){
		parent::__construct();
                $this->table = 'jugadores';
                $this->primary_key = 'id_jugador';
	}
	
	
    function get_jugadores($id_equipo){
        $this->db->where('id_equipo',$id_equipo);
        $this->db->order_by('nombre');
        $query = $this->db->get('jugadores');
        
        if ($query->num_rows()>0) {
            return $query->result();
        } else {
            return null;
        }
    }
    
    function get_jugadores_dropdown($id_equipo = null) {
    	if(empty($id_equipo)){
    		$id_equipo = $this->input->post('id_equipo');    	
    	}
    	$jugadores = $this->get_jugadores($id_equipo);
        $dropdown[''] = 'Seleccione';
	    if(!empty($jugadores)){
	        foreach ($jugadores as $jugador) {
	            $dropdown[$jugador->id_jugador] = $jugador->nombre;
	        }
	    }
        return $dropdown;
    }
    
	function get_jugadores_incidentes($incidente){
		$id_equipo = $this->uri->segment(3);
		$this->db->select('count(id_jugador) as cantidad, id_jugador');
		$this->db->where('incidente',$incidente);
		$this->db->where('id_equipo',$id_equipo);
		$this->db->where('id_jugador is not ', 'null', false);
		$this->db->group_by('id_jugador');
		$this->db->order_by('cantidad','desc');
		$result = $this->db->get('incidentes')->result();
		$jugadores = array();
		foreach ($result as $jugador) {
			$jugadores[$jugador->id_jugador] = $jugador->cantidad;
		}
		return $jugadores;
	}
	
    function guardar($jugador = null) {
    	
        if (isset($jugador['id_jugador'])) {
            
            $id_jugador = $jugador['id_jugador'];
            $this->db->where('id_equipo', $jugador['id_equipo']);
            $this->db->where('id_jugador', $jugador['id_jugador']);
            unset($jugador['id_jugador']);
            $this->db->update('jugadores', $jugador);
        } else {
            $this->db->where('id_equipo', $jugador['id_equipo']);
            $this->db->insert('jugadores',$jugador);
            $id_jugador = $this->db->insert_id();            
        }        
        log_message('debug',$this->db->last_query());
        return $id_jugador;
    }
    
    function eliminar($id_jugador = null){
    	if ($id_jugador == null){
    		$id_jugador = $this->input->post('id_jugador');
    	}
    	$this->db->where('id_jugador',$id_jugador);
    	$this->db->get('incidentes');
    	if($this->db->affected_rows()>0){
    		return FALSE;
    	} else {
    		$this->db->where('id_jugador',$id_jugador);
    		$this->db->delete('jugadores');
    		return TRUE;
    	}    	
    }
}