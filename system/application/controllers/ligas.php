<?php
class Ligas extends Controller{
	
	function __construct(){
		parent::Controller();
		
		$this->load->helper('form');
	} 
	
    function temporada($confirmacion = false){
        $this->erkana_auth->required();
        if($confirmacion){
            log_message('debug','Creando nueva temporada');
            $this->load->model('temporada');
            $this->temporada->desactivar_actual();
            $this->temporada->nueva();
            mensaje_ok('Los datos de la antigua Liga han sido ocultados, ya puedes comenzar a configurar esta nueva temporada.');
            redirect('admin');
        } else {
            $this->layout->view('liga/nueva_temporada');
        }
    }
    
    function ubicacion() {
    	$data['liga'] = $this->liga->get_actual();    	
        $this->layout->view('public/ubicacion_view', $data);        
    }
    
	function texto_home(){
    	$liga = $this->liga->get_actual();
    	$texto = $this->input->post('texto_home');
    	
    	if (!empty($texto)){
    		$this->liga->set_texto($texto);
    		$this->session->set_flashdata('ok','Texto guardado...');
    		redirect('admin');	
    	} else {	    	
	    	$data['texto'] = $liga;
	    	$this->layout->view('liga/editar_texto_view', $data);
    	}    	
    }
    
	function admin(){	
            $this->erkana_auth->required();
            $data['title'] = "Datos Liga";
            $data['liga'] = $this->liga->get_actual();
            log_message('debug',print_r($data['liga'],true));
            $this->layout->view('liga/liga_admin_view', $data);
	}
	
	function guardar(){
            $this->erkana_auth->required();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id_liga');
            $this->form_validation->set_rules('nombre','Nombre','required|trim|xss_clean|max_length[45]');
            $this->form_validation->set_rules('url','Pagina Web','required|trim|xss_clean|max_length[45]');
            $this->form_validation->set_rules('direccion','Direccion','required|trim|xss_clean|max_length[45]');
            $this->form_validation->set_rules('comuna','Direccion','required|trim|xss_clean|max_length[45]');
            $this->form_validation->set_rules('nombre_administrador','required|Direccion','trim|xss_clean|max_length[45]');
            $this->form_validation->set_rules('email_administrador','Email','required|trim|xss_clean|max_length[45]');
            $this->form_validation->set_rules('telefono_administrador','Telefono','required|trim|xss_clean|max_length[45]');
            $this->form_validation->set_rules('facebook_fan_page','required|Facebook Fan Page','trim|xss_clean|max_length[200]');
		
            if($this->form_validation->run() == FALSE){
                    $data['title'] = "Datos Liga";
                    $this->layout->view('liga/liga_admin_view', $data);
            } else {
			$this->firephp->info($_POST);
			$this->liga->guardar();
			$id_liga = $this->liga->get_id_actual();
			$this->_subir_imagen($id_liga, 'banner');
                        $this->_subir_bases();
			$this->session->unset_userdata('id_liga');
			$this->session->unset_userdata('liga');
                        $this->session->unset_userdata('url');
			mensaje_ok('Datos actualizados correctamente');
			redirect('admin');		
	    }
	}
	
	function _subir_imagen($id_archivo, $nombre_imagen){
		$this->load->library('upload');
		$this->erkana_auth->required('admin');
    	$this->firephp->info($_FILES);	
    	if ($_FILES[$nombre_imagen]['size']>0) {
            $partes = explode('.',$_FILES[$nombre_imagen]['name']);
            $ext = end($partes);
    		$config['upload_path'] = './imagenes/ligas/';
            $config['allowed_types'] = 'jpg|png|gif';
            $config['max_size'] = '1000';
            $config['overwrite'] = TRUE;
            
            
            $config['file_name'] = $id_archivo."_".$nombre_imagen.".jpg";
            $this->firephp->info($config);   
            
            $this->upload->initialize($config);
            if ( $this->upload->do_upload($nombre_imagen)== FALSE){                    
            	mensaje_error($this->upload->display_errors());            
				return FALSE;        
            }
            else {            
            	$result = $this->upload->data();
            	$this->resize_banner($id_archivo);            	
            	$this->firephp->info($result);                
                return TRUE;
            }    
        }	
	}
	
	function resize_banner($id_liga){
		$this->erkana_auth->required();
		$this->load->library('image_lib');
		$this->image_lib->clear();
		$img = './imagenes/ligas/'.$id_liga.'_banner.jpg';
		$this->firephp->info($img);
		$config['source_image']	= $img;		
		$config['new_image'] = './imagenes/ligas/'.$id_liga.'_banner.jpg';		
		$config['maintain_ratio'] = TRUE;
		$config['width']	 = '980';
		$config['height']	 = '100';
		$config['master_dim']	 = 'width';		
		
		$this->image_lib->initialize($config); 
			
		if ( !$this->image_lib->resize()){
		    mensaje_error($this->image_lib->display_errors());
		    return FALSE; 
		} else {
			return TRUE;
		}
	}
	
	function _subir_bases($nombre = 'bases') {		
    	//$this->erkana_auth->required('admin');
    	
    	if ($_FILES[$nombre]['size']>0) {
    		
            $config['upload_path'] = './docs/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = '1000';
            $config['overwrite'] = TRUE;
            
            $parts = explode('.',$_FILES[$nombre]['name']);
            
            $config['file_name'] = $this->session->userdata('url').'-bases.'.$parts[count($parts)-1];
            log_message('debug', 'nombre de ARCHIVO: .'.$config['file_name']);
            
            $this->upload->initialize($config);
            log_message('debug', 'config: '.print_r($config,true));
            if ( $this->upload->do_upload($nombre)== FALSE){                    
            	mensaje_error($this->upload->display_errors());            
                return FALSE;
            }
            else {    
            	$result = $this->upload->data();            	
            	log_message('debug', 'resultado del upload: '.print_r($result,true));
                return TRUE;
            }    
        }	
	}
	
}