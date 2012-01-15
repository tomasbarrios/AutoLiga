<?php
class Incidente extends MY_Model {

    function delete_incidentes($incidente,$id_partido){
        $this->delete_many_by(array('incidente'=>$incidente,'id_partido'=>$id_partido));
    }

    function __construct() {
        parent::__construct();
        $this->table = 'incidentes';
        $this->primary_key = 'id_incidente';
        $this->id_temporada = $this->temporada->get_id_actual();
    }
    
    function update_incidente() {
    	
        $id_incidente = $this->input->post('id_incidente');
        $id_jugador = $this->input->post('id_jugador');
        $in = array('id_jugador' => $id_jugador);
        $this->db->where('id_incidente' ,$id_incidente);
        $this->db->update('incidentes', $in);
        
        if ($this->db->affected_rows() == 1) {
            $this->liga->set_fecha_update_resultados();
        	return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function get_tabla_incidentes($incidente) {
    	$this->db->select('count(incidentes.id_jugador) as incidentes,jugadores.nombre as nombre, equipos.nombre as equipo, equipos.id_equipo');
    	$this->db->join('jugadores','incidentes.id_jugador=jugadores.id_jugador');
    	$this->db->join('equipos','jugadores.id_equipo=equipos.id_equipo');
    	$this->db->where('id_temporada' , $this->id_temporada);
    	$this->db->where('incidente', $incidente);
    	$this->db->group_by('nombre');
    	$this->db->order_by('incidentes', 'desc');
    
    	$tabla = $this->db->get('incidentes')->result();
    	if($this->db->affected_rows()>0) {
    		return $tabla;	
		} else {
			return FALSE;
		}
    }
    
    function get_resumen_incidentes($incidente){
        $this->db->select('count(incidente) as incidentes, partidos.id_partido, id_equipo');
        $this->db->group_by('id_equipo');
        $this->db->group_by('id_partido');
        $this->db->join('partidos','incidentes.id_partido = partidos.id_partido');
        $this->db->where('id_temporada', $this->id_temporada);
        $this->db->where('incidente', $incidente);
        $query = $this->db->get('incidentes');
        
	    if ($query->num_rows()>0) {
	    	$query = $query->result_array();
	        foreach ( $query as $gol ) {
	            $goles[$gol['id_partido']][$gol['id_equipo']] = $gol['incidentes'];
	        }
	        return $goles;
        } else {
        	return NULL;
        }
    }
    
    function get_incidentes($incidente){
        
        $id_partido = $this->input->post('id_partido');
        if ($id_partido) {
            $this->db->where(array('incidentes.id_partido' => $id_partido));
        }
        
        $id_equipo = $this->input->post('id_equipo');
        if ($id_equipo) {
            $this->db->where(array('incidentes.id_equipo' => $id_equipo));
        }
        
        $this->db->select('incidentes.*, fecha.nombre as fecha, jugador.nombre as jugador, equipo.nombre as equipo');
        $this->db->join('partidos','incidentes.id_partido = partidos.id_partido');
        $this->db->join('fechas as fecha','partidos.id_fecha = fecha.id_fecha','left');
        $this->db->join('jugadores as jugador','incidentes.id_jugador = jugador.id_jugador','left');
        $this->db->join('equipos as equipo','incidentes.id_equipo = equipo.id_equipo','left');
        $this->db->where('partidos.id_temporada',$this->id_temporada);
        $this->db->where('incidente', $incidente);
        $this->db->order_by('fecha.dia','desc');
        $this->db->order_by('equipo.nombre','asc');
        $query = $this->db->get('incidentes');        
        
        if ($query->num_rows() > 0){        	
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    function get_incidentes_array($incidente) {
		$incidentes = $this->get_incidentes($incidente);
		if ($incidentes == FALSE) {
			return array();
		} else {
	        foreach($incidentes as $ama) {
	            $incidentes_array[$ama->id_partido][$ama->id_equipo][] = array('id_incidente'=>$ama->id_incidente,'id_jugador'=>$ama->id_jugador);
	        }
	        return $incidentes_array;
        }
    }    
    
    function get_goles_pendientes(){
    	$this->db->join('partidos','incidentes.id_partido = partidos.id_partido');
        $this->db->where('id_temporada',$this->id_temporada);
        $this->db->where('incidente','gol');
        $this->db->where('id_jugador is ', 'NULL', false);
        $query = $this->db->get('incidentes');
        
        if ($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        }
    }
    
    function guardar_goles($id_partido = null, $id_equipo = null) {
        
        //eliminar
        $incidente = array('id_partido'=>$id_partido, 'id_equipo'=>$id_equipo, 'incidente' => 'gol');
        //$this->db->where($incidente);
        //$this->db->get('incidente')->delete();
        
        $jugadores = $this->input->post('gol');
        print_r($jugadores[$id_partido][$id_equipo]);
        $cantidad = count($jugadores[$id_partido][$id_equipo]);
        for ( $i=0; $i<$cantidad; $i+=1 ) {
            $incidente['id_jugador'] = $jugadores[$id_partido][$id_equipo][$i];
            $this->db->insert('incidentes', $incidente);
        }
        return TRUE;
    }    

}
?>