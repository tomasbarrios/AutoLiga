<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio {
    
    function cargar_liga() {
//    	$CI =& get_instance();
//    	$url_session = $CI->session->userdata('url');   
//    	 	
//        $url = $CI->config->item('base_url');
//        log_message('debug','Clean url: '.$url);
//        // get host name from URL
//		preg_match('@^(?:http://)?([^/]+)@i',$url, $matches);
//		$host = $matches[1];
//		// get last two segments of host name
//		preg_match('/[^.]+\.[^.]+$/', $host, $matches);
//		$url = $matches[0];
//			
//    	if($url != $url_session){    		
//			
//    		log_message('debug','Loading league in session for url: '.$matches[0]);
//    		
//    		$CI->db->like('url',$url);    		
//    		$CI->db->select('id_liga,nombre,url,telefono_administrador,facebook_fan_page');
//    		$liga = $CI->db->get('ligas')->row_array();
//
//    		$CI->session->set_userdata('liga',$liga);
//    		$CI->session->set_userdata('url',$liga['url']);
//    		$CI->session->set_userdata('id_liga',$liga['id_liga']);
//    	} else {
//    		log_message('debug','League found in session: '.$matches[0]);
//    	}
        
    }
    
}
?>