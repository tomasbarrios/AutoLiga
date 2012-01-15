<?php

Class Inscripcion extends Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('equipo');
        $this->load->model('jugador');
        $this->load->model('liga_settings');
    }
    
    function index(){
        $data['title'] = 'Inscripción Equipo';
        //TODO verificar inscripcion esta abierta (definir en liga settings)
        
        //corroborar validacion del form
        log_message('debug', __CLASS__.'::'.__FUNCTION__.':: Intentando guardar inscripcion: '.$_POST);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    	$this->form_validation->set_rules('nombre_equipo','Nombre Equipo','required|trim|xss_clean|min_length[5]|max_length[45]');
        $this->form_validation->set_rules('nombre_capitan','Nombre Capitan','required|trim|xss_clean|min_length[10]|max_length[45]');
        $this->form_validation->set_rules('email_capitan','Email Capitan','required|trim|xss_clean|valid_email|max_length[45]');
        $this->form_validation->set_rules('telefono_capitan','Teléfono Capitan','required|trim|xss_clean|min_length[7]|max_length[20]');
        
        if($this->form_validation->run() == FALSE){
            $this->layout->view('inscripcion/inscripcion_view', $data);	
        } else {
                //guardar equipo (para obtener id)
                $id_equipo = $this->equipo->guardar(array(
                    'nombre'=>$this->input->post('nombre_equipo'),
                    'id_liga'=>$this->liga->get_id_actual(),
                    'id_temporada'=>$this->temporada->get_id_actual(),
                    'activo'=>0));
                if($id_equipo) {
                log_message('debug','Equipo guardado con id: '.$id_equipo);
                //inscribir capitan
                $jugador['nombre']      = $this->input->post('nombre_capitan');
                $jugador['email']       = $this->input->post('email_capitan');
                $jugador['telefono']    = $this->input->post('telefono_capitan');
                $jugador['id_equipo']   = $id_equipo;
                $id_jugador = $this->jugador->guardar($jugador);
                log_message('debug','Capitan guardado con id: '.$id_jugador);
                //asignar capitan a equipo
                $equipo = $this->equipo->get($id_equipo);
                $equipo->id_capitan = $id_jugador;
                $this->equipo->update($equipo->id_equipo,$equipo);
                //TODO dynamic name for liga
                $liga = 'Liga El Gol';         
                //fijar en sesion id_equipo para continuar inscripcion
                $this->session->set_userdata('id_equipo_inscripcion', $id_equipo);
                mensaje_ok('Felicitaciones, tu equipo ya esta INSCRITO!');
                redirect('inscripcion/jugadores');
            } else {
                mensaje_error('Hubo un error al guardar los datos, por favor contactanos para que arreglemos esto');
                $this->layout->view('inscripcion/inscripcion_view', $data);	
            }
        } 
        
        
    }
    
    function jugadores(){
        //datos para la vista
        $data['title'] = 'Inscripcion de Jugadores';
        $id_equipo = $this->session->userdata('id_equipo_inscripcion');
        if(empty($id_equipo)){
            redirect('inscripcion');
        } else {
            $data['equipo'] = $this->equipo->get($id_equipo);
            $data['capitan'] = $this->equipo->get_capitan($id_equipo);
            log_message('debug', print_r($data,true));
        }
        
        //corroborar validacion del form
        log_message('debug', __CLASS__.'::'.__FUNCTION__.':: Intentando guardar jugadores para inscripcion: '.print_r($_POST,true));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if(!empty($_POST)){            
            //validacion condicional. si no esta vacio, validar.
            $jugadores = $this->input->post('nuevo_jugador');
            for ( $i=0; $i<20; $i++ ) {
                if(!empty($jugadores[$i])){
                    $this->form_validation->set_rules('nuevo_jugador['.$i.']','Nombre Jugador '.($i+1),'trim|xss_clean|min_length[8]|max_length[45]');
                }
            }             
        } 
        
        if($this->form_validation->run() == FALSE){
            //errores
            log_message('debug','Volviendo al formulario, fallo la validacion');
            $this->layout->view('inscripcion/inscripcion_jugadores_view', $data);	
        } else {
            //inscribir            
            log_message('debug','Guardando jugadores preinscritos para equipo: '.$id_equipo);
            if(!empty($id_equipo)){
                log_message('debug','Guardando jugadores preinscritos');
                $jugadores = $this->input->post('nuevo_jugador');
                if(!empty($jugadores)){
                    foreach ($jugadores as $jugador) {
                        if(!empty($jugador)){
                            $jugador = array('nombre' => $jugador, 'id_equipo' => $id_equipo);
                            $this->jugador->guardar($jugador);
                        }
                    }
                }
                redirect('inscripcion/finalizar');
            } else {
                show_error('Error, intente nuevamente.');
                redirect();
            }
        }     
    }
    
    function finalizar(){
        log_message('debug', __CLASS__.'::'.__FUNCTION__.':: Intentando finalizar inscripcion');
        $id_equipo = $this->session->userdata('id_equipo_inscripcion');
        if(empty($id_equipo)) {
            mensaje_error('Al parecer ha ocurrido un error, porfavor llena nuevamente el formulario');
            redirect('inscripcion');            
        } else {
            $liga = $this->liga->get_actual();
            $this->session->unset_userdata('id_equipo_inscripcion');
            mensaje_ok('Tu equipo ya esta PRE-INSCRITO en '.$liga->nombre.'!, recuerda asegurar tu inscripcion pagando la primera cuota. Nos contactaremos mediante el email inscrito para mantenerte informado sobre todo lo necesario, Saludos!');
        }
        redirect();
    }
    
    function abrir(){
        $this->erkana_auth->required();
        $this->liga_settings->set('inscripciones_abiertas',1);
        mensaje_ok('Inscripciones Abiertas, en el home del sitio podrás ver un link que permite a tus clientes inscribir sus equipos');
        redirect($this->agent->referrer());
    }
    
    function cerrar(){
        $this->erkana_auth->required();
        $this->liga_settings->set('inscripciones_abiertas',0);
        mensaje_ok('Inscripciones desactivadas');
        redirect($this->agent->referrer());
    }
    
}
?>
