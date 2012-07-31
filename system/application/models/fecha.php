<?php
class Fecha extends Model {
	
	function __construct(){
		parent::__construct();	
		$this->id_liga = $this->liga->get_id_actual();
		$this->id_temporada = $this->temporada->get_id_actual();	
	}
	
	function get_public(){
		$ultima = $this->get_siguiente_fecha();
		$this->db->where('id_liga',$this->liga->get_id_actual());    	
		$this->db->where('id_temporada',$this->id_temporada);    	
    if (!empty($ultima)) {
		  $this->db->where('dia <= ', $ultima->dia);
	  }
		else {
		  $this->db->where('dia <= ', 'now()', false);
		}
		$this->db->order_by('dia','DESC');
		$fechas = $this->db->get('fechas')->result();
		log_message('debug',$this->db->last_query());
		return $fechas;
	}
	
	function get_siguiente_fecha(){
		$this->db->where('id_liga',$this->id_liga);  
		$this->db->where('id_temporada', $this->id_temporada);  	
        $this->db->where('dia > ', 'now()', false);    
    	$this->db->select_min('dia');
		$query = $this->db->get('fechas',1)->row();
		$this->db->where('dia',$query->dia);
        $query = $this->db->get('fechas')->row();
        log_message('debug',$this->db->last_query());
		log_message('debug',print_r($query,true));
		return($query);
    }
    
	function get_ultima_fecha(){    	
		$this->db->where('id_liga',$this->id_liga);    
		$this->db->where('id_temporada', $this->id_temporada);
		$this->db->where('dia < ', 'now()', false);
		$this->db->select_max('dia');		
		$query = $this->db->get('fechas',1)->row();
		$this->db->where('dia',$query->dia);
		$query = $this->db->get('fechas')->row();
		log_message('debug',$this->db->last_query());
		return $query;        
	}
    
	function guardar($fecha=null){		
		$id_liga = $this->liga->get_id_actual();
        $id_temporada = $this->temporada->get_id_actual();

		if(empty($fecha)){
			$id_fecha = $this->input->post('id_fecha');
			$nombre = $this->input->post('nombre');
			$dia = $this->input->post('dia');
			$dia = $this->dia_a_db($dia);
			$id_campeonato = $this->input->post('id_campeonato');
			$fecha = array('nombre'=>$nombre,
	                    'dia'=>$dia,
						'id_campeonato'=>$id_campeonato);			
		}
		$fecha['id_liga'] = $id_liga; 
        $fecha['id_temporada'] = $id_temporada;	
		
		if(!empty($id_fecha)){	
			$this->db->where('id_fecha',$id_fecha);		
			$this->db->update('fechas', $fecha);
		} else {
			$this->db->insert('fechas', $fecha);
			$id_fecha = $this->db->insert_id();
		}
		
		log_message('debug',$this->db->last_query());
		if ($this->db->affected_rows()>0){
			return $id_fecha;
		} else {
			return FALSE;
		}		
	}
	
	function get($id_fecha){
		$this->db->where('id_fecha',$id_fecha);
		$query = $this->db->get('fechas')->row();		
		log_message('debug',$this->db->last_query());
		return($query);
	}
	
	function get_all(){		
		$this->db->where('id_temporada', $this->temporada->get_id_actual());
		$this->db->order_by('dia','desc');
		$query = $this->db->get('fechas')->result();		
		log_message('debug',$this->db->last_query());
		return($query);
	}
	
	function get_fechas_dropdown(){
		$fech = $this->get_all();
		$fechas[''] = "Seleccione";
		foreach ($fech as $f){
			$fechas[$f->id_fecha]=$f->nombre;
		}
		return $fechas;		 
	}
	
        /**
         *
         * @param string $fecha Formato chile 'dd/mm/YYYY'
         * @return string MySQL date  
         */
        function dia_a_db($fecha) {

            $split = explode(' ',$fecha);
            $fecha = $split[0];
            $hora = $split[1];

            $fecha = explode('/',$fecha);        
            return ($fecha[2].'-'.$fecha[1].'-'.$fecha[0].' '.$hora);
        }
}