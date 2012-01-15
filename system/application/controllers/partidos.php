<?php 

class Partidos extends Controller {

	function  __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('partido');
		$this->load->model('fecha');
		$this->load->model('grupo');
		$this->load->model('campeonato');
		$this->load->model('incidente');
	}

	//devuelve el html para los partidos de una fecha
	function get_partidos_ajax() {
		$id_fecha = $this->input->post('id_fecha');
		$data['partidos'] = $this->partido->get_many_by('id_fecha',$id_fecha);
		$this->firephp->info($this->db->last_query());
		$this->firephp->info($data['partidos']);
		$partial_partidos = $this->load->view('resultados/partial_partidos', $data, TRUE);
		$aPartials = array('partials'=>array('partidos'=>$partial_partidos));
		echo json_encode($aPartials);
	}

	function get_detalle_partido_ajax(){
		$id_partido = str_replace('partido_', '', $this->input->post('id_partido'));
		$data['partido'] = $this->partido->get_partido($id_partido);

		$this->firephp->info($this->db->last_query());
		$this->firephp->info($data['partido']);
		$partial_partidos = $this->load->view('resultados/partial_detalle_partido', $data, TRUE);
		echo $partial_partidos;
	}

	function update_definicion(){
		$definicion = $this->input->post('definicion');
		$id_partido = $this->input->post('id_partido');
		if($definicion == 'WalkOver') {
			$partido['goles_visita'] = 0;
			$partido['goles_local'] = 0;
			$this->incidente->delete_incidentes('gol',$id_partido);
			$this->incidente->delete_incidentes('amarilla',$id_partido);
			$this->incidente->delete_incidentes('roja',$id_partido);
			$this->incidente->delete_incidentes('penal',$id_partido);
		}
		$partido['definicion'] = $definicion;
		$this->partido->update_by('id_partido',$id_partido,$partido);
	}

	function index () {
		log_message('debug',__CLASS__.'::'.__FUNCTION__);
		$data['partidos'] = $this->partido->get_all();
		$data['fechas'] = $this->fecha->get_public();
		$data['campeonatos'] = $this->campeonato->get_activos();
		$data['penales'] = $this->incidente->get_incidentes_array('penal');
		$data['grupos'] = $this->grupo->get_grupos_dropdown();            
		$data['title'] = 'Partidos';   
		$this->layout->view('partidos/partidos_public_view', $data);
	}

	function admin() {
		log_message('debug',__CLASS__.'::'.__FUNCTION__);
		$this->erkana_auth->required();
		$data['partidos'] = $this->partido->get_all();
		$data['fechas'] = $this->fecha->get_all();
		$data['campeonatos'] = $this->campeonato->get_activos();
		$data['title'] = 'Partidos';
		$this->layout->view('partidos/partidos_view', $data);
	}

	function walkover(){
		$ganador = $this->input->post('ganador');
		$perdedor = $this->input->post('perdedor');
		$id_partido = $this->input->post('id_partido');
		//TODO goles visita = 0
		$this->partido->update_by('id_partido',$id_partido, array('ganador' =>$ganador,'goles_'.$ganador => 4));
		$this->partido->update_by('id_partido',$id_partido, array('goles_'.$perdedor => 0));
		$data['datos']['golesporwo'] = "4";
		$this->load->view('utils/json_encode',$data);
	}

	function resultados (){
		$this->erkana_auth->required();
		$data['partidos'] = $this->partido->get_all();
		$data['fechas'] = $this->fecha->get_all();
		$data['campeonatos'] = $this->campeonato->get_activos();
		$data['title'] = 'Partidos';  
		$this->layout->view('partidos/resultados_view', $data);
	}

	function editar($id_partido) {
		$this->erkana_auth->required();
		$this->load->model('equipo');
		$this->load->model('campeonato');

		$data['partido'] = $this->partido->get_partido($id_partido);
		$data['equipos'] = $this->equipo->get_equipos_dropdown();
		$data['campeonatos'] = $this->campeonato->get_activos_dropdown();
		$data['fechas'] = $this->fecha->get_fechas_dropdown();
		$data['grupos'] = $this->grupo->get_grupos_dropdown();   
		$data['title'] = 'Editar Partido';
		$this->layout->view('partidos/editar_partido_view', $data);	
	}

	function nuevo (){    
		$this->erkana_auth->required();
		$this->load->model('equipo');
		$this->load->model('campeonato');   
		$this->load->model('fecha');     
		$data['equipos'] = $this->equipo->get_equipos_dropdown();
		$data['campeonatos'] = $this->campeonato->get_activos_dropdown();
		$data['fechas'] = $this->fecha->get_fechas_dropdown();
		$data['grupos'] = $this->grupo->get_grupos_dropdown();   
		$data['title'] = 'Nuevo Partido';
		$this->layout->view('partidos/editar_partido_view', $data);
	}

	function guardar(){
		$this->erkana_auth->required();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_partido');
		$this->form_validation->set_rules('id_campeonato','Campeonato','required|trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('grupo','Grupo','trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('id_fecha','Fecha','required|trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('fecha','Dia','required|trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('cancha','Cancha','trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('id_campeonato','Campeonato','required|trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('libre','Libre','trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('local','Equipo Local','required|trim|xss_clean|max_length[45]');
		$this->form_validation->set_rules('visita','Equipo Visita','trim|xss_clean|max_length[45]');
		$libre = $this->input->post('libre');
		$this->firephp->info('libre:'.$libre);
		if(empty($libre)){
			$this->form_validation->set_rules('visita','Equipo Visita','required|trim|xss_clean|max_length[45]');
			$this->form_validation->set_rules('cancha','Cancha','required|trim|xss_clean|max_length[45]');
		} 

		//TODO validar
		if($this->form_validation->run() == FALSE){
			$this->load->model('equipo');
			$this->load->model('campeonato');

			$data['equipos'] = $this->equipo->get_equipos_dropdown();
			$data['campeonatos'] = $this->campeonato->get_activos_dropdown();
			$data['fechas'] = $this->fecha->get_fechas_dropdown();
			$data['grupos'] = $this->grupo->get_grupos_dropdown();   
			$data['title'] = 'Editar Partido';
			$this->layout->view('partidos/editar_partido_view', $data);	
		} else {
			if ($this->partido->guardar() == TRUE) {
				$this->admin();
			}
		}
	}

	//checkbox en resultados
	function status_jugado(){
		$this->erkana_auth->required();
		$this->load->model('incidente');

		$jugado = $this->input->post('jugado');    	
		$id_partido = $this->input->post('id_partido');
		$partido = $this->partido->get_partido($id_partido);    		
		if($partido->goles_local == null or $partido->goles_visita == null) {
			$match = array('goles_local' => 0, 'goles_visita'=> 0);
		}
		$match['jugado'] = $jugado;
		$this->db->where('id_partido',$id_partido);
		$this->db->update('partidos',$match);

		if ($jugado == '1') {

			$amarillas = $this->incidente->get_resumen_incidentes('amarilla');
			$rojas = $this->incidente->get_resumen_incidentes('roja');
			$penales = $this->incidente->get_resumen_incidentes('penal');
			//$amarillas = $this->partido->get_amarillas($id_partido);
			$data['datos']['definicion'] = empty($partido->definicion) ? 'Normal' : $partido->definicion;
			$data['datos']['ganador'] = empty($partido->ganador) ? '' : $partido->ganador;
			$data['datos']['goles_local'] = empty($partido->goles_local) ? 0 : $partido->goles_local;
			$data['datos']['goles_visita'] = empty($partido->goles_visita) ? 0 : $partido->goles_visita;
			$data['datos']['penales_local'] = empty($penales[$partido->id_partido][$partido->id_equipo_local]) ? 0 : $penales[$partido->id_partido][$partido->id_equipo_local];
			$data['datos']['penales_visita'] = empty($penales[$partido->id_partido][$partido->id_equipo_visita]) ? 0 : $penales[$partido->id_partido][$partido->id_equipo_visita];
			$data['datos']['amarillas_local'] = empty($amarillas[$partido->id_partido][$partido->id_equipo_local]) ? 0 : $amarillas[$partido->id_partido][$partido->id_equipo_local];
			$data['datos']['amarillas_visita'] = empty($amarillas[$partido->id_partido][$partido->id_equipo_visita]) ? 0 : $amarillas[$partido->id_partido][$partido->id_equipo_visita];
			$data['datos']['rojas_local'] = empty($rojas[$partido->id_partido][$partido->id_equipo_local]) ? 0 : $rojas[$partido->id_partido][$partido->id_equipo_local];
			$data['datos']['rojas_visita'] = empty($rojas[$partido->id_partido][$partido->id_equipo_visita]) ? 0 : $rojas[$partido->id_partido][$partido->id_equipo_visita];

		} else {
			$data['datos']['goles_local'] = '';
			$data['datos']['goles_visita'] = '';
		}    	
		$this->load->view('utils/json_encode',$data);    	
	}


	function guardar_fixture_generado () {
		$this->erkana_auth->required();
		$fechas = $this->input->post('fecha');
		foreach ($fechas as $grupo => $fecha)
		foreach ($fecha as $key => $partidos) {        

			$id_fecha = $this->db->insert_id('fechas',array('numero'=>$numero+1));
			foreach ( $partidos as $key2 => $p){
				$partido = array();
				$partido['id_equipo_local'] = $p['local'];
				$partido['id_equipo_visita']= $p['visita'];
				$partido['id_fecha'] = $key+1;

				$this->db->insert('partidos',$partido);                 
			}
		}
		echo 'wena, todo bem';
	}


	function generar_fixture ()
	{
		$this->erkana_auth->required();
		//rescatar los grupos del campeonato
		$this->db->select('grupo');
		$this->db->distinct('grupo');
		$grupos = $this->db->get('equipos')->result();        

		//generar fixture por cada grupo
		foreach ($grupos as $key => $grupo) {

			$this->load->model('Equipo');
			$equipos = $this->Equipo->buscar_equipos_del_grupo($grupo->grupo);
			$cant_equipos = count($equipos);

			if ($cant_equipos%2) {
				$eq = new Equipo;
				$eq->nombre = 'libre';
				$eq->id_equipo = 0;
				array_push($equipos, $eq);            
			}


			$fechas = array();
			$cant_fechas = count($equipos) - 1;            
			$cant_partidos = count($equipos)/2;

			for ($i = 0 ; $i < $cant_fechas ; $i += 1) {
				$partidos = array();
				for ($j = 0; $j < $cant_partidos ; $j += 1)
				{
					$partidos[] = array ( $equipos[$j], $equipos[$cant_fechas - $j]);
				}

				$fechas[]=$partidos;
				$last = array_pop($equipos);
				$first = array_shift($equipos);

				array_unshift($equipos, $first, $last );
			}

			$data['grupos'][$key]=$fechas;
		}
		$this->load->view('admin/generar', $data);
	}

}
?>