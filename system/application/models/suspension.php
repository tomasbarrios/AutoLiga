<?php
class Suspension extends Model {

	function __construct(){
		parent::__construct();
		$this->id_temporada = $this->temporada->get_id_actual();
	}

	function update(){
		log_message('debug',__CLASS__.'::'.__FUNCTION__);
		$id_suspension = $this->input->post('id_suspension');
		$activada = $this->input->post('activada');
		$cant_fechas = $this->input->post('cant_fechas');

		$this->firephp->info('set_activada: '.$activada);
		$this->db->set('activada',$activada, false);
		$this->db->set('cant_fechas',$cant_fechas);
		$this->db->where('id_suspension',$id_suspension);
		$this->db->update('suspensiones', $suspension);
		$this->firephp->info($this->db->last_query());
	}

	function get($id_suspension){
		log_message('debug',__CLASS__.'::'.__FUNCTION__);
		$this->db->where('id_suspension',$id_suspension);
		$suspension = $this->db->get('suspensiones');
		return $suspension;		
	}

	function get_all(){
		log_message('debug',__CLASS__.'::'.__FUNCTION__);
		$this->db->where('campeonatos.id_temporada',$this->id_temporada);
		$this->db->select('activada, jugadores.nombre as jugador, id_suspension, fecha_suspension, fechas.nombre as fecha_nombre, cant_fechas, equipos.nombre as equipo, equipos.id_equipo, campeonatos.nombre as campeonato');
		$this->db->join('jugadores','jugadores.id_jugador = suspensiones.id_jugador');
		$this->db->join('equipos','jugadores.id_equipo = equipos.id_equipo');
		$this->db->join('fechas','fechas.id_fecha = suspensiones.fecha_suspension');
		$this->db->join('campeonatos','campeonatos.id_campeonato = suspensiones.id_campeonato');
		$this->db->order_by('fecha_suspension','desc');
		$suspensiones = $this->db->get('suspensiones')->result();

		log_message('debug',$this->db->last_query());

		return $suspensiones;
	}

	function get_public_all(){
		log_message('debug',__CLASS__.'::'.__FUNCTION__);	
		$this->db->where('campeonatos.id_temporada',$this->id_temporada);
		$this->db->select('activada, jugadores.nombre as jugador, fecha_suspension, fechas.nombre as fecha_nombre, cant_fechas, equipos.nombre as equipo, equipos.id_equipo, campeonatos.nombre as campeonato');
		$this->db->join('jugadores','jugadores.id_jugador = suspensiones.id_jugador');
		$this->db->join('equipos','jugadores.id_equipo = equipos.id_equipo');
		$this->db->join('fechas','fechas.id_fecha = suspensiones.fecha_suspension');
		$this->db->join('campeonatos','campeonatos.id_campeonato = suspensiones.id_campeonato');
		$this->db->order_by('fecha_suspension','desc');
		$this->db->where('activada',1);
		$suspensiones_db = $this->db->get('suspensiones')->result();
		$suspensiones = array();
		foreach ($suspensiones_db as $s){
			$this->firephp->info('jugador: '.$s->jugador.' cant: '.$s->cant_fechas);			
			for($i=0; $i<$s->cant_fechas; $i+=1){				
				$suspensiones[$s->fecha_suspension+$i][]= array(
					'jugador'=>$s->jugador,
					'equipo'=>$s->equipo,
					'fecha_suspension'=>$s->fecha_nombre,
					'fecha_actual'=>$i+1,
					'cant_fechas'=>$s->cant_fechas,
					'id_equipo'=>$s->id_equipo,
					'campeonato'=>$s->campeonato);				
			}
		}		
		$this->firephp->info($this->db->last_query());
		$this->firephp->info($suspensiones);
		return $suspensiones;
	}

	//tarjetas que no tienen asociada una suspension
	function get_suspensiones_pendientes($id_campeonato){
		log_message('debug',__CLASS__.'::'.__FUNCTION__);
		//amarillas
		$this->procesar_tarjetas($id_campeonato,0);
		//rojas
		$this->procesar_tarjetas($id_campeonato,1);
	}


	function procesar_tarjetas($id_campeonato,$tipo){
		log_message('debug',__CLASS__.'::'.__FUNCTION__);
		$tarjetas = $this->get_tarjetas_pendientes($id_campeonato, $tipo);
		log_message('debug','tarjetas pendientes para campeonato: '.$id_campeonato.' -> '.count($tarjetas));
		
		if ($tipo == 0){
			$acumuladas = AMARILLAS_PARA_SUSPENSION;
		} else {
			$acumuladas = ROJAS_PARA_SUSPENSION;
		}		
		
		if (!empty($tarjetas)){
			foreach ($tarjetas as $t){
				$existen = TRUE;
				//mientras existan suspensiones pendientes
				do {
					$actual = $this->get_tarjetas_pendientes($id_campeonato, $tipo,$t->id_jugador);
					
					if(!empty($actual))
					{
						//nueva suspension encontrado...
						$suspension = array(	'tipo'=>$tipo,
							'fecha_suspension'=>$this->_get_next_fecha( $actual[$acumuladas-1]->id_fecha ),									
								// $actual[$acumuladas-1]->id_fecha)+1,									
							'cant_fechas' => 1,
							'id_jugador' => $actual[0]->id_jugador,
							'id_campeonato'=>$id_campeonato,
							'activada'=>1);
						$id_suspension=0;
						$this->db->insert('suspensiones',$suspension);
						$id_suspension = $this->db->insert_id();

						log_message('debug','nueva suspension encontrada...'.print_r($suspension,true));

						//insertar en suspensiones_has_incidentes
							for ($i=0; $i<$acumuladas; $i+=1)
						{						
							$suspension_incidente = array('id_suspension'=>$id_suspension,'id_incidente'=>$actual[$i]->id_incidente);
							$this->db->insert('suspensiones_has_incidentes',$suspension_incidente);	
						}	

					} else {
						$existen = FALSE;
					}
				} while ($existen); 				
			}
		}
	}

	//devuelve los jugadores que tienen una suspension sin anotar
	function get_tarjetas_pendientes($id_campeonato, $tipo, $id_jugador = null){
		log_message('debug',__CLASS__.'::'.__FUNCTION__);

		//tarjetas necesarias para una suspension
		if ($tipo == 0){
			$acumuladas = AMARILLAS_PARA_SUSPENSION;
			$tarjeta = "amarilla";
		} else {
			$acumuladas = ROJAS_PARA_SUSPENSION;
			$tarjeta = "roja";
		}

		//Obtenemos todas las suspensiones ya registradas
		if(!empty($id_jugador)){
			$this->db->where('id_jugador',$id_jugador);
		}
		$this->db->select('si.id_incidente');
		$this->db->where('incidente',$tarjeta);
		$this->db->join('incidentes','incidentes.id_incidente = si.id_incidente');
		$this->db->join('partidos','incidentes.id_partido = partidos.id_partido');
		$this->db->where('id_temporada',$this->id_temporada);
		$this->db->group_by('id_incidente');
		$suspensiones = $this->db->get('suspensiones_has_incidentes as si')->result();

		if(!empty($suspensiones)){
			foreach ($suspensiones as $susp){
				$no_pendientes[] = $susp->id_incidente ;				
			}
			$this->db->where_not_in('id_incidente',$no_pendientes);
		}

		//Obtenemos todas los incidentes que no estan asociadas a una suspension
		$this->db->select('incidentes.*, count(id_jugador), id_fecha');
		$this->db->where('incidente',$tarjeta);
		$this->db->where('id_campeonato',$id_campeonato);
		$this->db->where('id_temporada',$this->id_temporada);
		$this->db->join('partidos','partidos.id_partido = incidentes.id_partido');


		if(!empty($id_jugador)){
			$this->db->where('id_jugador',$id_jugador);
			$this->db->group_by('id_incidente');
			$this->db->order_by('id_fecha');
			$result = $this->db->get('incidentes',$acumuladas)->result();	
		} else {
			$this->db->group_by('id_jugador');
			$this->db->having('count(id_jugador) >=', $acumuladas);					
			$result = $this->db->get('incidentes')->result();
		}

		log_message('debug',$this->db->last_query());
		log_message('debug',$result);
		return $result;
	}

	function _get_next_fecha($id_fecha){
		$this->db->where('id_temporada', $this->temporada->get_id_actual());
		$this->db->order_by('dia','asc');
		$fechas = $this->db->get('fechas')->result();
		log_message('debug', print_r($fechas,true));
		$next = null;
		foreach($fechas as $key => $fecha){
			if ($fecha->id_fecha == $id_fecha) {
				$next = $fechas[$key+1]->id_fecha;
			}
		}
		return $next;
	}
}