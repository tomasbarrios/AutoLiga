<?php
class Copas extends Controller { 
	function __construct(){
		parent::__construct();
		$this->load->model('campeonato');
		$this->load->model('grupo');	
	}
	
	function generar_fixture($id_fase){
		$this->erkana_auth->required();
		$data['title'] = 'Generar Fixture';
	
			//no hay confirmacion aun para generar
			$this->load->model('equipo');
			$data['equipos'] = $this->equipo->get_all(true);
			$data['grupos'] = $this->grupo->get_grupos_dropdown();
			$data['fases'] = $this->campeonato->get_activos_dropdown();
			$data['id_fase'] = $id_fase;
			$this->layout->view('copas/generar_fixture',$data);		
	}
	
	function confirmar_generar_fixture(){
		$this->erkana_auth->required();
		$fixture = array();
		$this->load->model('equipo');
		
    	$this->load->library('form_validation');
   		$this->form_validation->set_rules('id_fase','Fase','required');
    	$this->form_validation->set_rules('fecha','Fecha Inicial','required|trim');
		$this->form_validation->set_rules('cantidad_canchas','Cantidad de Canchas','required');
		$this->form_validation->set_rules('hora','Hora de Inicio','required');
		
		$id_fase = $this->input->post('id_fase');
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Generar Fixture';
			$data['equipos'] = $this->equipo->get_all(true);
			$data['grupos'] = $this->grupo->get_grupos_dropdown();
			$data['fases'] = $this->campeonato->get_activos_dropdown();
			$data['id_fase'] = $id_fase;
			$this->layout->view('copas/generar_fixture',$data);
		} else {
		
			$grupos = $this->campeonato->get_grupos($id_fase);
			//generar fixture por cada grupo
	        foreach ($grupos as $grupo) {
				log_message('debug',__CLASS__.'::'.__FUNCTION__.':: '.print_r($grupo,TRUE));
				$equipos = $this->grupo->get_equipos($grupo->id_grupo);
	            // log_message('debug',__CLASS__.'::'.__FUNCTION__.':: '.print_r($equipos,TRUE));
				$cant_equipos = count($equipos);
            
	            if ($cant_equipos%2) {
	                $eq = new equipo;
	                $eq->nombre = 'libre';
	                $eq->id_equipo = 0;
	                array_push($equipos, $eq);            
	            }
            
	            $fechas = array();
	            $cant_fechas = count($equipos) - 1;            
	            $cant_partidos = count($equipos)/2;
	            log_message('debug',__CLASS__.'::'.__FUNCTION__.':: cant_partidos '.$cant_partidos);
	            for ($i = 0 ; $i < $cant_fechas ; $i += 1) {
		            log_message('debug',__CLASS__.'::'.__FUNCTION__.':: Fecha '.$i);
	                $partidos = array();
	                for ($j = 0; $j < $cant_partidos ; $j += 1)
	                {
						$partido = array ( $equipos[$j]->id_equipo, $equipos[$cant_fechas - $j]->id_equipo);
						log_message('debug',__CLASS__.'::'.__FUNCTION__.':: Partido: '.print_r($partido,true));
	                    $partidos[] = $partido;

	                }
                
	                $fechas[]=$partidos;
	                $last = array_pop($equipos);
	                $first = array_shift($equipos);
                
	                array_unshift($equipos, $first, $last );
	            }     
	       		if(!empty($fechas))
	            $fixture[$grupo->id_grupo]=$fechas;			
	        }
		
			//insertar en la BD
			$this->_guardar_fixture($fixture, $id_fase, $this->input->post('fecha').' '.$this->input->post('hora'), $this->input->post('cantidad_canchas'));
			mensaje_ok('Fixture generado correctamente');
			redirect('partidos/admin');	
		}
	}
	
	function _guardar_fixture($fixture, $id_fase, $fecha_inicial,$cantidad_canchas){
		log_message('debug','GUARDANDO FIXTURE... '.print_r($fixture,true));
		//log_message('debug','Fecha Inicial: '.$fecha_inicial);
		$fecha_inicial = $this->partido->dia_a_db($fecha_inicial);
		$this->load->model('fecha');
		$this->campeonato->eliminar_partidos($id_fase);
		$this->campeonato->eliminar_fechas($id_fase);
		$fecha = array();
		foreach($fixture as $id_grupo => $fechas){
			foreach($fechas as $i_fecha => $partidos){

				if(!$fecha[$i_fecha]) {
					//Insertar Fecha
					$fecha_obj = array();
					$fecha_actual = date("Y-m-d H:i",strtotime($fecha_inicial . " +".$i_fecha." week"));
					$fecha_obj['nombre'] = 'Fecha '.($i_fecha+1);
					$fecha_obj['id_campeonato'] = $id_fase; 
					$fecha_obj['dia'] = $fecha_actual;
					$fecha_obj['id'] = $this->fecha->guardar($fecha_obj);
					$fecha[$i_fecha] = $fecha_obj;
				}
				$cancha = 1;
				$fecha_actual = $fecha[$i_fecha]['dia'];
				foreach($partidos as $i_partido => $partido){
					
					$match = array();
					$match['fecha_libre'] = ($partido[0] == 0 OR $partido[1] == 0)? 1 : 0 ;
					if($match['fecha_libre'] AND $partido[0] == 0) { $partido[0]=$partido[1] ; $partido[1]=0;}
					$match['id_equipo_local'] = $partido[0];
					$match['id_equipo_visita'] = $partido[1];
					$match['id_fecha'] = $fecha[$i_fecha]['id'];
			        $match['id_grupo'] = $id_grupo;
			
					if($cancha > $cantidad_canchas AND $match['fecha_libre'] == 0) { $cancha = 1; $fecha_actual = date("Y-m-d H:i",strtotime($fecha_actual. " +1 hour"));}
					$match['fecha'] = $fecha_actual;
			        $match['cancha'] = $cancha;
			        //$partido['fecha'] = $this->dia_a_db($this->input->post('fecha'));
			        $match['id_campeonato'] = $id_fase;
					$this->partido->guardar($match);
					//log_message('debug', 'Guardando partido '.print_r($match,true));
					if($match['fecha_libre'] == 0){$cancha++;}
				}
			
			}
		}
		//TODO fix de horarios
	}
		
//	function ver(){
//            $id_campeonato = $this->uri->segment(3);
//            $this->load->model('partido');
//            $this->load->model('fecha');
//            $data['partidos'] = $this->partido->get_all($id_campeonato);
//            $data['fechas'] = $this->fecha->get_all();          
//            $data['title'] = 'Partidos';    
//            $this->layout->view('partidos/partidos_public_view', $data);
//	}
	
	function guardar(){
		$this->erkana_auth->required();
		$this->load->library('form_validation');
    	$this->form_validation->set_rules('id_campeonato');
		$this->form_validation->set_rules('nombre','Nombre','required|trim|xss_clean|max_length[45]');
    	$this->form_validation->set_rules('formato','Formato','required|trim|xss_clean');
    	$this->form_validation->set_error_delimiters('<span class="error">','</span>');
		
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Editar Fase';			
			$this->layout->view('copas/editar_copa_view',$data);
		} else {
			if($this->campeonato->guardar()){
				mensaje_ok('Los datos fueron guardados');
				redirect('copas/admin');	
			} else {			
				//error
				redirect('copas/admin');
			}
		}
				
	}
	
	function admin(){
		$this->erkana_auth->required();
		$data['copas'] = $this->campeonato->get_activos();
		$data['title'] = 'Fases';
		$this->layout->view('copas/admin_copa_view', $data);	
	}
	
	function editar(){
		$this->erkana_auth->required();
		$id_copa = $this->uri->segment(3);
		$data['copa'] = $this->campeonato->get($id_copa);
		$data['title'] = 'Editar Copa';		
		$this->layout->view('copas/editar_copa_view', $data);
	}
	
	function nuevo() {
		$this->erkana_auth->required();
		$data['title'] = 'Nueva Fase';
		$this->layout->view('copas/editar_copa_view', $data);
	}
}