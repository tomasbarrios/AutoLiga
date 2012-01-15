<?php
class Premio extends Model{
	function __construct(){
		parent::__construct();
                $this->table = 'premios';
                $this->primary_key = 'id_premio';
	}
	
	function get_dropdown(){
		$prem = $this->get_all();
		$premios[''] = "Seleccione";
		foreach ($prem as $p){
			$premios[$p->id_premio]=$p->nombre;
		}
		return $premios;		 
	}
	
	function get_ganadores($id_premio){
		$this->db->select('premios.*','jugadores.*','equipos.*','fechas.*');
		$this->db->join('premios', 'premios.id_premio = ganadores_premios.id_premio');
		$this->db->join('equipos', 'equipos.id_equipo = ganadores_premios.id_equipo');
		$this->db->join('jugadores', 'jugadores.id_jugador = ganadores_premios.id_jugador');
		$this->db->join('fechas', 'fechas.id_fecha = ganadores_premios.id_fecha');
		$this->db->where('ganadores_premios.id_premio',$id_premio);
                $this->db->where('premios.id_temporada',$id_temporada);
		$query = $this->db->get('ganadores_premios')->result();
				
		$this->firephp->info($this->db->last_query());
		$this->firephp->info($query);		
		return($query);
	}
	
	function get_ganador($id_ganador){
		$this->db->select('premios.*','jugadores.*','equipos.*','fechas.*');
		$this->db->join('premios', 'premios.id_premio = ganadores_premios.id_premio');
		$this->db->join('equipos', 'equipos.id_equipo = ganadores_premios.id_equipo');
		$this->db->join('jugadores', 'jugadores.id_jugador = ganadores_premios.id_jugador');
		$this->db->join('fechas', 'fechas.id_fecha = ganadores_premios.id_fecha');
		$this->db->where('ganadores_premios.id_ganador_premio',$id_ganador);
                $this->db->where('premios.id_temporada',$id_temporada);
		$query = $this->db->get('ganadores_premios')->row();
				
		$this->firephp->info($this->db->last_query());
		$this->firephp->info($query);		
		return($query);
	}
	
	function eliminar($id_premio){
		$this->db->where('id_premio',$id_premio);
		$this->db->delete('premios');
	}
	
	function get($id_premio){
		$this->db->where('id_premio',$id_premio);
		$query = $this->db->get('premios')->row();		
		
		$this->firephp->info($this->db->last_query());
		$this->firephp->info($query);
		
		return($query);
	}
	
	function get_all(){
		$this->db->where('id_temporada',$id_temporada);
		$premios = $this->db->get('premios')->result();
		log_message($this->db->last_query());
		return $premios;
	}
	
	function guardar(){
		$id_premio = $this->input->post('id_premio');
		$nombre = $this->input->post('nombre');
		$descripcion = $this->input->post('descripcion');
		$id_sponsor = $this->input->post('id_sponsor');
		$frecuencia = $this->input->post('frecuencia');
		$tipo = $this->input->post('tipo');		
		$id_liga = $this->liga->get_id_actual();
                $id_temporada = $this->temporada->get_id_actual();
		$premio = array(
                    'nombre'=>$nombre,
                    'id_liga'=>$id_liga,
                    //'id_temporada'=>$id_temporada,
                    'descripcion'=>$descripcion,
                    'id_sponsor'=>$id_sponsor,
                    'frecuencia'=>$frecuencia,
                    'tipo'=>$tipo);
		
		if(!empty($id_premio)){	
			$this->db->where('id_premio',$id_premio);		
			$this->db->update('premios', $premio);
		} else {
			$this->db->insert('premios', $premio);
		}
		
		$this->firephp->info($this->db->last_query());
		$this->firephp->info($this->db->affected_rows());
		if ($this->db->affected_rows()>0){
			return TRUE;
		} else {
			return FALSE;
		}
		
	}
}