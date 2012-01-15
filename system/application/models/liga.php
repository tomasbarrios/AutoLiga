<?php
class Liga extends Model {
	
	function __construct(){
		parent::Model();
	}
	
	function clean_url($url){
		$url = prep_url(trim_slashes($url));
		$url = str_replace("http://", "", $url);
		$url = str_replace("www.", "", $url);
		return $url;
	}
	
	function guardar(){
		$nombre = $this->input->post('nombre');
		$url = $this->input->post('url');
		$url = $this->clean_url($url);
		$ffp = $this->input->post('facebook_fan_page');
		$ffp = $this->clean_url($ffp);
		$direccion = $this->input->post('direccion');
		$comuna = $this->input->post('comuna');
		$nombre_administrador = $this->input->post('nombre_administrador');
		$email_administrador = $this->input->post('email_administrador');
		$telefono_administrador = $this->input->post('telefono_administrador');
		$liga = array(	'nombre'=>$nombre,'url'=>$url,
						'direccion'=>$direccion,'comuna'=>$comuna,
						'nombre_administrador'=>$nombre_administrador,
						'email_administrador'=>$email_administrador,
						'telefono_administrador'=>$telefono_administrador,
						'facebook_fan_page'=>$ffp);
		
		
		$this->firephp->info($liga);
		$this->db->where('id_liga', $this->get_id_actual());
		$this->db->update('ligas',$liga);
	}
	
	function get_actual(){
            log_message('debug',__CLASS__.'::'.__FUNCTION__);
            $id_liga = $this->session->userdata('id_liga');
            if(empty($id_liga))
                $id_liga = $this->_cargar_liga ();
            $this->db->where('id_liga',$id_liga);
            $liga = $this->db->get('ligas')->row();
            //log_message('debug','Consulta: '.$this->db->last_query());
            return $liga;
	}
	
	function get_id_actual(){
            log_message('debug',__CLASS__.'::'.__FUNCTION__);
            $id_liga = $this->session->userdata('id_liga');	
            if(isset($id_liga))
                $id_liga = $this->_cargar_liga();
            //log_message('debug',__CLASS__.'::'.__FUNCTION__.' Result id liga: '.$id_liga);
            return $id_liga;
	}
	
	function set_texto($texto){
		$this->db->where('id_liga', $this->get_id_actual());
		$this->db->set('texto_home', $texto);
		$this->db->update('ligas');
	}
	
	function set_fecha_update_posiciones(){
		$this->db->where('id_liga', $this->get_id_actual());
		$this->db->set('update_posiciones','now()', false);
		$this->db->update('ligas');
	}
	
	function set_fecha_update_resultados(){
		$this->db->where('id_liga', $this->get_id_actual());
		$this->db->set('update_resultados','now()', false);
		$this->db->update('ligas');
	}
        
        function get_settings(){
            $this->load->model('liga_settings');
            //NO FUNCIONA, llama a otro modelo... se puede?
            return $this->liga_settings->get_settings();
        }
        
        function _cargar_liga(){
            log_message('debug',__CLASS__.'::'.__FUNCTION__);
            $url_session = $this->session->userdata('url');   
            $url = $this->config->item('base_url');
            log_message('debug','Cleaning this url...: '.$url);
            // get host name from URL
            preg_match('@^(?:http://)?([^/]+)@i',$url, $matches);
            $host = $matches[1];
            // get last two segments of host name
            preg_match('/[^.]+\.[^.]+$/', $host, $matches);
            $url = $matches[0];

            if($url != $url_session){
                    log_message('debug','Loading league in session for url: '.$url.', currently in session: '.$url_session);
            } else {
                    log_message('debug','League found in session: '.$url);
            }
            $this->db->like('url',$url);    		
            $this->db->select('id_liga,nombre,url,telefono_administrador,facebook_fan_page');
            $liga = $this->db->get('ligas')->row_array();
            
            $this->session->set_userdata('liga',$liga);
            $this->session->set_userdata('url',$liga['url']);
            $this->session->set_userdata('id_liga',$liga['id_liga']);
            return $liga['id_liga'];            
        }
}
?>