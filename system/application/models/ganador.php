<?php
class Ganador extends MY_Model{
	function __construct(){
		parent::__construct();
                $this->id_temporada = $this->temporada->get_id_actual();
				$this->table = 'ganadores_premios';
	}	
	
	function get_ganadores($id_premio){
		$this->db->select('ganadores_premios.*,jugadores.nombre as jugador,equipos.nombre as equipo,fechas.nombre as fecha');		
		$this->db->join('equipos', 'equipos.id_equipo = ganadores_premios.id_equipo','left');
		$this->db->join('jugadores', 'jugadores.id_jugador = ganadores_premios.id_jugador','left');
		$this->db->join('fechas', 'fechas.id_fecha = ganadores_premios.id_fecha','left');
		$this->db->join('premios', 'premios.id_premio = ganadores_premios.id_premio','left');
		$this->db->where('premios.id_temporada',$this->id_temporada);
		$this->db->where('ganadores_premios.id_premio',$id_premio);
		$query = $this->db->get('ganadores_premios')->result();
				
		$this->firephp->info($this->db->last_query());
		$this->firephp->info($query);		
		return($query);
	}
	
	function get($id_ganador){
		$this->db->select('ganadores_premios.*,jugadores.nombre as jugador,equipos.nombre as equipo,fechas.nombre as fecha');	
		$this->db->join('equipos', 'equipos.id_equipo = ganadores_premios.id_equipo','left');
		$this->db->join('jugadores', 'jugadores.id_jugador = ganadores_premios.id_jugador','left');
		$this->db->join('fechas', 'fechas.id_fecha = ganadores_premios.id_fecha','left');
		$this->db->join('premios', 'premios.id_premio = ganadores_premios.id_premio','left');
		$this->db->where('ganadores_premios.id_ganador_premio',$id_ganador);
		$this->db->where('premios.id_temporada',$this->id_temporada);
		$query = $this->db->get('ganadores_premios')->row();
				
		$this->firephp->info($this->db->last_query());
		$this->firephp->info($query);		
		return($query);
	}
	
	function eliminar($id_ganador_premio){
		$this->db->where('id_ganador',$id_ganador_premio);
		$this->db->delete('ganadores_premios');
	}

	
	function get_all(){
		$this->db->join('premios', 'premios.id_premio = ganadores_premios.id_premio');
		$this->db->where('premios.id_temporada',$this->temporada->get_id_actual());
		$ganadores_ganador_premios = $this->db->get('ganadores_premios')->result();
		$this->firephp->info($ganadores_ganador_premios);
		$this->firephp->info($this->db->last_query());
		return $ganadores_ganador_premios;
	}
	
	function guardar(){
		$id_ganador_premio = $this->input->post('id_ganador_premio');
		$ganador['id_premio'] = $this->input->post('id_premio');
		$ganador['id_fecha'] = $this->input->post('id_fecha');
		$ganador['id_equipo'] = $this->input->post('id_equipo');
		$ganador['id_jugador'] = $this->input->post('id_jugador');	
		
		if(!empty($id_ganador_premio)){	
			$this->db->where('id_ganador_premio',$id_ganador_premio);		
			$this->db->update('ganadores_premios', $ganador);
		} else {
			$this->db->insert('ganadores_premios', $ganador);
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