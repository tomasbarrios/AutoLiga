<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    
    var $obj;
    var $layout;
    
    function Layout($layout = "layout_main")
    {
        $this->obj =& get_instance();
        $this->layout = $layout;
    }

    function setLayout($layout)
    {
      $this->layout = $layout;
    }
    
    function view($view, $data=null, $return=false)
    {
        $loadedData = array();
        
        //id liga
        $id_liga = $this->obj->session->userdata('id_liga');
        //sponsors
        $this->obj->db->order_by('posicion');
        $this->obj->db->where('id_liga',$id_liga);
       	$data['sponsors_banner'] = $this->obj->db->get('sponsors')->result();       	
       	//premios
       	$this->obj->db->where('id_liga',$id_liga);
       	$data['menu_premios'] = $this->obj->db->get('premios')->result();
       	//liga
       	$data['liga_session'] = $this->obj->session->userdata('liga');
        //liga Settings
        $data['league_settings']= $this->obj->liga_settings->get_settings();
        
        $loadedData['content_for_layout'] = $this->obj->load->view($view,$data,true);
        
        if($return)
        {
            
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        }
        else
        {
            log_message('debug','not return!');
            $this->obj->load->view($this->layout, $loadedData, false);
        }
    }
  
}
?>