<?php

class equipos extends Controller {
	
	function equipos () {
		parent::Controller();
		$this->load->helper('form');
		$this->load->model('equipo');
		$this->load->model('jugador');
		$this->load->model('grupo');
	}

	function activar($id_equipo){
		$this->equipo->activo($id_equipo, 1);
		redirect('equipos/admin');
	}
	
	function desactivar($id_equipo){
		$this->equipo->activo($id_equipo, 0);
		redirect('equipos/admin');
	}
	
        function eliminar($id_equipo){
            $this->load->model('incidente');
            $this->load->model('ganador');

            $errors = array();

            $partidos = $this->partido->get_by_team($id_equipo);
            if(!empty($partidos))
                $errors[] = 'partidos';
            $incidentes = $this->incidente->get_by('id_equipo',$id_equipo);
            if(!empty($incidentes))
                $errors[] = 'goles o tarjetas';
            $premios = $this->ganador->get_by('id_equipo',$id_equipo);
            if(!empty($premios))
                $errors[] = 'premios';
            
            if(empty($errors)){
                $this->equipo->delete_by('id_equipo',$id_equipo);
                $this->jugador->delete_many_by('id_equipo',$id_equipo);
                mensaje_ok('Equipo Eliminado');
            } else {
                foreach($errors as $error){
                    mensaje_error('No se pudo eliminar el equipo por que existen '.$error.' asociados');
                }
            }
            redirect('equipos/admin');
        }

	//ajax para el partido
	function update_dropdown_equipos(){		
		$id_grupo = $this->input->post('id_grupo');
		$equipos = $this->equipo->get_by_grupo_dropdown($id_grupo);		
		$data['datos']['equipos'] = $equipos;
		$this->load->view('utils/json_encode',$data);
	}
	
	//ajax para dropdown
	function get_jugadores(){		
		$jugadores = $this->jugador->get_jugadores_dropdown();
		
		$this->firephp->info($jugadores);
		
		$data['datos'] = $jugadores;
		$this->load->view('utils/json_encode',$data);
	}
        
        function nuevo() {
		$this->erkana_auth->required();
		$this->load->model('grupo');    
        $data['grupos'] = $this->grupo->get_grupos_dropdown();
        $this->layout->view('equipos/editar_equipo', $data);       
	}
	
	function ver ($id_equipo = null) {
	    if ($id_equipo != null){
		$data['equipo'] = $this->equipo->get($id_equipo);
                $data['jugadores'] = $this->jugador->get_jugadores($id_equipo);
		$data['goles'] = $this->jugador->get_jugadores_incidentes('gol');
		$data['amarillas'] = $this->jugador->get_jugadores_incidentes('amarilla');
		$data['rojas'] = $this->jugador->get_jugadores_incidentes('roja');
		
		$this->layout->view('equipos/ver_equipo_view', $data);
	    }	    
	}
	
	function index() {
		$data['grupos'] = $this->grupo->get_grupos_dropdown();
		$data['equipos'] = $this->equipo->get_all();
		$this->layout->view('equipos/equipos_view', $data);
	}
	
    function admin (){
    	$this->erkana_auth->required();
    	$data['grupos'] = $this->grupo->get_grupos_dropdown();
        $data['equipos'] = $this->equipo->get_all(true);
		$capitanes = array();
		foreach($data['equipos'] as $equipo) { 
			$capitanes[$equipo->id_equipo] = $this->jugador->get($equipo->id_capitan); 
			log_message('debug', 'Capitan: '.$this->db->last_query());
		}
		log_message('debug', 'Capitanes: '.print_r($capitanes,true));
		$data['capitanes'] = $capitanes;
        $this->layout->view('equipos/equipos_admin_view',$data);
    }
    
    function editar ($id_equipo = null) {
    	$this->erkana_auth->required();
        $data['equipo'] = $this->equipo->get($id_equipo); 
        $this->load->model('grupo');    
        $data['grupos'] = $this->grupo->get_grupos_dropdown();   
        $data['jugadores'] = $this->jugador->get_jugadores($id_equipo);
		$data['capitan'] = $this->jugador->get($data['equipo']->id_capitan);
        $this->layout->view('equipos/editar_equipo', $data);        
    }
    
    function guardar(){
        log_message('debug', __CLASS__.'::'.__FUNCTION__.':: Guardando Cambios a Equipo: '.print_r($_POST,true));
    	$this->erkana_auth->required();     

		$this->load->library('form_validation');
    	$this->form_validation->set_rules('id_partido');
		$this->form_validation->set_rules('nombre','Nombre Equipo','required|trim|xss_clean|max_length[45]');  			    					
		$this->form_validation->set_error_delimiters('<span class="error">','</span>');
		
		if($this->form_validation->run() == FALSE){
	        $this->load->model('grupo');    
	        $data['grupos'] = $this->grupo->get_grupos_dropdown();   
			$this->layout->view('equipos/editar_equipo', $data);
		} else {
			$id_equipo = $this->equipo->guardar();	
			$jugadores = $this->input->post('jugador');
	        $nuevos_jugadores = $this->input->post('nuevo_jugador');

	        $this->_guardar_foto($id_equipo);

	        if(!empty($jugadores)){
	           foreach ($jugadores as $id => $jugador) {
	           	    if ($jugador != ''){     
	                    $jugador = array('id_jugador'=>$id, 'nombre' => $jugador, 'id_equipo' => $id_equipo);
	                    $this->jugador->guardar($jugador);
	                }
	            }
	        }
	        if(!empty($nuevos_jugadores)){
		        foreach ($nuevos_jugadores as $jugador) {
		            if ($jugador != '') {
		                $jugador = array('nombre' => $jugador, 'id_equipo' => $id_equipo);
		                $this->jugador->guardar($jugador);
		            }
		        }
	        }
			mensaje_ok('Datos del equipo guardados correctamente');
	        redirect('equipos/admin');
		}
    }
    
    function eliminar_jugador(){
    	$this->erkana_auth->required();
    	echo $this->jugador->eliminar();
    }

    function _guardar_foto($id_equipo){
    	if ($_FILES['foto']['size']>0) {
            $config['upload_path'] = './imagenes/equipos/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2000';
            $config['overwrite'] = TRUE;
            $partes = explode('.',$_FILES['foto']['name']);
            $config['file_name'] = $id_equipo.'.jpg';
            log_message('debug', __CLASS__.'::'.__FUNCTION__.':: Subiendo Imagen: '.$config['file_name']);
            $this->load->library('upload', $config);
            if ( $this->upload->do_upload('foto') == FALSE){                    
            	mensaje_error($this->upload->display_errors());
                return FALSE;
            }
            else {            
            	$result = $this->upload->data();
            	log_message('debug','Upload OK!... '.print_r($result, TRUE));
                $this->db->where('id_equipo',$result['raw_name']);
                $this->db->update('equipos', array('foto'=>$result['file_name']));
                $this->_resize($id_equipo);
                return TRUE;
            }    
        }
    }
    
    function update_imagenes(){
		$this->erkana_auth->required();
		$this->load->library('image_lib');
		$equipos = $this->equipo->get_all();
		$ok = 0;
		foreach ($equipos as $equipo) { 
			$this->image_lib->clear();
			$img = './imagenes/equipos/'.$equipo->foto;
			$this->firephp->info($img);
			$config['source_image']	= $img;		
			$config['new_image'] = './imagenes/equipos/'.$equipo->id_equipo.'_width_500.jpg';		
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = '500';
			$config['height']	 = '350';
			$config['master_dim'] = 'width';		
			
			
			$this->image_lib->initialize($config); 
				
			if ( !$this->image_lib->resize()){
			    $this->firephp->error($this->image_lib->display_errors());
			    //echo $this->image_lib->display_errors();
			} else {
				$ok++;
			}			
		}
		echo "ok: ".$ok;
	}
	
	function _resize($id_equipo){
		log_message('debug', __CLASS__.'::'.__FUNCTION__.':: Intentando resize de foto...');
		$this->load->library('image_lib');
		$this->image_lib->clear();
		$img = './imagenes/equipos/'.$id_equipo.'.jpg';
		$config['source_image']	= $img;		
		$config['new_image'] = './imagenes/equipos/'.$id_equipo.'_width_500.jpg';		
		$config['maintain_ratio'] = TRUE;
		$config['width']	 = '500';
		$config['height']	 = '500';
		$config['master_dim']	 = 'width';		
		
		$this->image_lib->initialize($config); 
			
		if ( !$this->image_lib->resize()){
		    log_message(print_r($this->image_lib->display_errors(), TRUE));
		    return FALSE; 
		} else {
			return TRUE;
		}
	}

}

?>