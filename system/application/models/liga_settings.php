<?php

class Liga_Settings extends MY_Model {
    function __construct(){
        parent::__construct();
        $this->primary_key = 'id_liga';
        $this->id_liga = $this->liga->get_id_actual();
        $settings = $this->get_by('id_liga',$this->id_liga);
        if(empty($settings))
                $this->crear();
    }
    
    function set($key, $value){
        $this->update_by('id_liga',$this->id_liga, array($key=>$value));
        log_message('debug',$this->db->last_query());
    }    
    
    function crear(){
        $this->insert(array('id_liga'=>$this->id_liga));
    }
    
    function get_settings(){
        $this->db->where('ligas.id_liga',$this->id_liga);
        $this->db->join('ligas','liga_settings.id_liga = ligas.id_liga');
        $settings = $this->db->get('liga_settings')->row();
        log_message('debug',$this->db->last_query()); 
        return $settings;
    }
    
}
?>
