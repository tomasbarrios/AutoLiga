<?php

class Accounts extends Controller {
    
    function Accounts (){
        parent::Controller();        
    }
    
    function index() {	
    	$url = 'admin';
    	if ($this->erkana_auth->validate_login('username')) {
            redirect($url);
        } else {
            $data['title'] = 'Login';  
            $this->layout->view('accounts/login', $data);
        }    
    }
    
    // Creates a user
    function create() {
    	$this->erkana_auth->required();
		if ($this->erkana_auth->create_account('username')) {
			redirect('accounts');
		}
		$data['title'] = 'Nuevo usuario';
		$this->layout->view('accounts/nuevo_usuario_view', $data);
	}
	
    function logout () {
		$this->session->unset_userdata('user_id');
		redirect('home');
    }
}
?>