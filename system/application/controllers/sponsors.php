<?php
class Sponsors extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model('sponsor');
		$this->load->helper('form');
		$this->load->helper('html');
	}
	
	function eliminar(){
		$this->erkana_auth->required();
		$id_sponsor = $this->uri->segment(3);
		$this->sponsor->eliminar($id_sponsor);
		redirect('sponsors/admin');
	}
	//AJAX
	function orden(){
		$this->erkana_auth->required();
		$filas = $this->input->post('filas');
		$this->firephp->info($_POST);

		foreach ($filas as $posicion => $id_sponsor){
			if(!empty($id_sponsor)){
				$this->sponsor->set_posicion($id_sponsor, $posicion);
			}
		}
	}
	
	function admin(){    
		$this->erkana_auth->required();	
    	$data['sponsors'] = $this->sponsor->get_all();
    	$data['title'] = 'Sponsors';
		$this->layout->view('sponsors/listar_sponsors_view',$data);	
	}
	
	function nuevo(){
		$this->erkana_auth->required();
		$data['title'] = 'Nuevo Sponsor';
		$this->layout->view('sponsors/editar_sponsor_view',$data);
	}
	
	function editar(){
		$this->erkana_auth->required();
		$id_sponsor = $this->uri->segment(3);
		$this->db->where('id_sponsor',$id_sponsor);
		$sponsor = $this->db->get('sponsors')->row();
		$data['title'] = $sponsor->nombre;
		$data['sponsor'] = $sponsor;
		$this->layout->view('sponsors/editar_sponsor_view',$data);
	}
	
	function guardar(){
		$this->erkana_auth->required();		
		$id_sponsor = $this->sponsor->guardar();		
		$this->guardar_imagen($id_sponsor);
		mensaje_ok( 'Datos guardados correctamente');
		redirect('sponsors/admin');
	}
	
	//devuelve el nombre.ext de la imagen guardada o FALSE
    function guardar_imagen($id_sponsor){
    	$this->erkana_auth->required();
    	$this->firephp->info($_FILES);
    	$config['file_name'] = $id_sponsor.'.jpg';
    	$config['upload_path'] = './imagenes/sponsors/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';
        $config['overwrite'] = TRUE;
            
    	$this->load->library('firephp');
    	$this->load->library('upload', $config);
    	
    	if ($_FILES['imagen']['size']>0) {
            
            if ( $this->upload->do_upload('imagen') == FALSE){                    
            	$this->firephp->info($this->upload->display_errors());
				return FALSE;        
            }
            else {            
            	$result = $this->upload->data();
            	$this->firephp->info($result);
            	$this->image_thumbs($id_sponsor);
                return TRUE;
            }    
        } else {
        	return FALSE;
        }
    }
    
    function image_thumbs($id_sponsor){
    	$this->erkana_auth->required();
    	
    	$config['source_image']	= './imagenes/sponsors/'.$id_sponsor.'.jpg';
		$config['new_image'] = './imagenes/sponsors/'.$id_sponsor.'_thumb.jpg';
		$config['maintain_ratio'] = TRUE;
		$config['width']	 = 100;
		$config['height']	 = 35;		
		$config['master_dim'] = 'width';		
		
		$this->load->library('image_lib', $config); 
		
		if ( ! $this->image_lib->resize()){
		    echo $this->image_lib->display_errors();		    
		} 
		
		$this->image_lib->clear();
		$config['source_image']	= './imagenes/sponsors/'.$id_sponsor.'.jpg';
		$config['new_image'] = './imagenes/sponsors/'.$id_sponsor.'_300.jpg';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']	 = 300;
		$config['height']	 = 1;		
		$config['master_dim'] = 'width';		
		
		$this->image_lib->initialize($config); 
		
		if ( ! $this->image_lib->resize()){
		    echo $this->image_lib->display_errors();		    
		} 
    }

}