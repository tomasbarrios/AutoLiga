<?php

Class Admin extends Controller {

    function __construct ()
    {
        parent::Controller();
        $this->load->model('equipo');
        $this->load->model('partido');
        $this->erkana_auth->required();
    }
    
    function index() {
        $this->load->model('incidente');
        $goles_pendientes = $this->incidente->get_goles_pendientes();
        
        if (count($goles_pendientes) > 0) { $data['goles_pendientes']= $goles_pendientes; }
        $this->layout->view('admin/home', $data);        
    }
   
    /*function goles() {
        $this->load->model('incidente');
        $partidos = $this->partido->get_partidos_jugados();
        $data['fechas'] = $this->partido->get_fechas_jugadas();
        $data['grupos'] = $this->partido->get_grupos();
        $data['partidos'] = $this->partido->get_partidos_jugados();
        $data['goles'] = $this->incidente->get_goles();
        $data['jugadores'] = $this->equipo->get_equipos_con_jugadores();
        $this->layout->view('admin/editar_goles', $data);
    }
    
    function guardar_goles() {
        $this->load->model('incidente');
        $goles = $this->input->post('gol');
        foreach ($goles as $id_incidente => $id_jugador) {
            if ($id_jugador != 0){
                $this->incidente->guardar_gol($id_incidente, $id_jugador);
            }
        }
        redirect('admin');
    }
    
function resultados () {
        
        $this->load->library('firephp');
        //partidos
        $this->db->select('id_fecha, fecha, id_partido, id_equipo_local, id_equipo_visita, jugado');
        $this->db->where('cancha != 0'); 
        
        $this->db->order_by('partidos.fecha' ,'asc');
        $this->db->order_by('partidos.id_fecha' ,'desc');
        $this->db->select('local.nombre as local');
        $this->db->select('local.grupo');
        $this->db->select('visita.nombre as visita');
        $this->db->join('equipos as local', 'local.id_equipo=id_equipo_local');
        $this->db->join('equipos as visita', 'visita.id_equipo=id_equipo_visita');
        $partidos = $this->db->get('partidos')->result();        
        $data['partidos'] = $partidos;
        $this->firephp->log($this->db->last_query());
        
        //Goles (resumen)

        
        $this->layout->view('admin/editar_resultados', $data);
    }
    */
    
    
    /*
    function resultados () {
        
        $this->load->library('firephp');
        //partidos
        $this->db->select('id_fecha, fecha, id_partido, id_equipo_local, id_equipo_visita, jugado');
        $this->db->where('cancha != 0'); 
        
        $this->db->order_by('partidos.fecha' ,'asc');
        $this->db->order_by('partidos.id_fecha' ,'desc');
        $this->db->select('local.nombre as local');
        $this->db->select('local.grupo');
        $this->db->select('visita.nombre as visita');
        $this->db->join('equipos as local', 'local.id_equipo=id_equipo_local');
        $this->db->join('equipos as visita', 'visita.id_equipo=id_equipo_visita');
        $partidos = $this->db->get('partidos')->result();        
        $data['partidos'] = $partidos;
        $this->firephp->log($this->db->last_query());
        
        //Goles (resumen)
        
        $this->load->model('incidente');
        $data['resumen_goles'] = $this->partido->get_resumen_goles();
        $data['goles'] = $this->incidente->get_incidentes_array('gol');
        $data['resumen_amarillas'] = $this->incidente->get_resumen_incidentes('amarilla');
        $data['amarillas'] = $this->incidente->get_incidentes_array('amarilla');
        $data['resumen_rojas'] = $this->incidente->get_resumen_incidentes('roja');
        $data['rojas'] = $this->incidente->get_incidentes_array('roja');
        $data['jugadores'] = $this->equipo->get_equipos_con_jugadores();
        $data['fechas'] = $this->partido->get_fechas();
        $data['grupos'] = $this->partido->get_grupos();   
        
        $this->layout->view('admin/editar_resultados', $data);
    }
*/
    function guardar_resultados(){
    
        //TODO validacion
                
        //Comparar cambios de goles
        $partidos = $this->input->post('partido');
        $this->load->model('incidente');
        foreach ($partidos as $key => $partido) {
            foreach ($partido as $key2 => $equipo) {
                //print_r('')
                $this->incidente->guardar_goles($key, $key2);                
            }
        }

        redirect('campeonato/resultados');
    }
    
    function task() {
        echo "Hello World";
    }
    
    
    

}

?>
