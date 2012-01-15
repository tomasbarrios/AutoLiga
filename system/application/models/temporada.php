<?php

class Temporada extends MY_Model {
    function __construct() {
        parent::__construct();   
        $this->id_liga = $this->liga->get_id_actual();
    }
    
    function nueva(){      
        log_message('debug',__CLASS__.'::'.__FUNCTION__);
        $temporada['id_liga'] = $this->id_liga;
        $temporada['activa'] = 1;
        $id_temporada = $this->insert($temporada);
        log_message('debug',$this->db->last_query());
        return $id_temporada;       
    }
    
    function desactivar_actual(){
        log_message('debug',__CLASS__.'::'.__FUNCTION__);
        $this->update_by('id_liga', $this->id_liga, array('activa'=>0));
        log_message('debug',$this->db->last_query());
    }
    
    function get_id_actual(){
        log_message('debug',__CLASS__.'::'.__FUNCTION__);
        //log_message('debug','Liga: '.$this->id_liga);
        $this->db->where('id_liga',$this->id_liga);
        $this->db->where('activa',1);
        $temporada = $this->db->get('temporadas')->row();
//        log_message('debug',$this->db->last_query());
//        log_message('debug',print_r($temporada,true));
        return $temporada->id;
    }
    
    
}