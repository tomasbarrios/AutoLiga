<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

class Erkana_auth {

	var $CI;
	
	var $errors					= array();
	var $accounts_controller	= 'accounts';
	
	function Erkana_auth() {
		$this->CI =& get_instance();
		$this->CI->lang->load('erkana_auth', 'english');
		$this->CI->load->helper('erkana_auth');
	}

	// required()
	// Enforces authentication on a controller method
	function required() {
		if (!$this->is_logged_in()) {
			if (!function_exists('redirect')) {
				$this->CI->load->helper('url');
			}
			
			redirect($this->accounts_controller);
		}
	}
	
	
	// accounts_controller()
	// Sets the accounts_controller variable
	function accounts_controller($controller) {
		$this->accounts_controller = $controller;
	}
	
	
	// is_logged_in()
	// Checks the session for required data then validates 
	// that data against the database
	function is_logged_in() {
		log_message('debug', 'checking logged in user');
		log_message('debug','id usuario en session: '.$this->CI->session->userdata('user_id') );
		log_message('debug','token de usuario: '.$this->CI->session->userdata('user_token') );
		
		if (!class_exists('CI_Session')) {
			$this->CI->load->library('session');
		}
		
		// Check if there is any session data we can use
		
		if ($this->CI->session->userdata('user_id') && $this->CI->session->userdata('user_token')) {
			if (!class_exists('Account')) {
				$this->CI->load->model('account');
			}
			
			log_message('debug', 'Hay informacion de sesion, buscando usuario');
			// Get a user account via the Account model
			$account = $this->CI->account->get($this->CI->session->userdata('user_id'));
			if ($account !== FALSE) {
				if (!function_exists('dohash')) {
					$this->CI->load->helper('security');
				}
				log_message('debug', 'Verifying credentials');
				// Ensure user_token is still equivalent to the SHA1 of the user_id and password_hash
				if (dohash($this->CI->session->userdata('user_id') . $account->password_hash) === $this->CI->session->userdata('user_token')) {
					log_message('debug', 'Valid!');
					return TRUE;
				} else {
					log_message('debug', 'Invalid! pass_hash:');
				}
			} else {
				log_message('debug', 'Couldnt find user with id...');
			}
		}
		log_message('debug', 'logging failed');
		return FALSE;
	}
	
	
	// validate_login()
	// Attempts to validate a login attempt
	function validate_login($identifier = 'email') {
		if ($this->CI->input->post($identifier)) {
			if (!class_exists('Account')) {
				$this->CI->load->model('account');
			}
			
			$account = $this->CI->account->get_by(array($identifier => $this->CI->input->post($identifier)));
			if ($account !== NULL) {
				if (!function_exists('dohash')) {
					$this->CI->load->helper('security');
				}
				
				if (($account->$identifier === $this->CI->input->post($identifier)) && (dohash($account->salt . $this->CI->input->post('password')) === $account->password_hash)) {
					$this->_establish_session($account);
					return TRUE;
				}
			}
			
			$this->errors[] = $this->CI->lang->line('erkana_auth_invalid_login');
		}
		
		return FALSE;
	}
	
	
	// create_account()
	// Attempts to create an account for the authentication system
	function create_account($identifier = 'email') {
		if (!class_exists('CI_Form_validation')) {
			$this->CI->load->library('form_validation');
		}
		
		if ($identifier == 'username') {
			$this->CI->form_validation->set_rules('username', 'username', 'required|min_length[4]|max_length[20]|trim');
		} else {
			$this->CI->form_validation->set_rules('email', 'email', 'required|max_length[120]|valid_email|trim');
		}
		$this->CI->form_validation->set_rules('password', 'password', 'required|matches[passwordconf]');
		$this->CI->form_validation->set_rules('passwordconf', 'password confirmation', 'required');
	
	
		if ($this->CI->form_validation->run()) {
			if (!class_exists('Account')) {
				$this->CI->load->model('account');
			}
			
			$account = $this->CI->account->get_by(array($identifier => $this->CI->input->post($identifier)));
			if ($account === NULL) {
				$salt = $this->_generate_salt();
				
				if (!function_exists('dohash')) {
					$this->CI->load->helper('security');
				}
				
				$account = array(
					$identifier		=> $this->CI->input->post($identifier),
					'salt'			=> $salt,
					'password_hash'	=> dohash($salt . $this->CI->input->post('password')));
				
				return $this->CI->account->create($account);
			}
			
			$this->errors[] = $this->CI->lang->line('erkana_auth_account_exists');
		}
		
		foreach ($this->CI->form_validation->_error_array as $error) {
			$this->errors[] = $error;
		}
		
		return FALSE;
	}
	
	
	// _establish_session()
	// Will set the appropriate session variables
	function _establish_session($account) {
		$this->CI->session->set_userdata(array(
			'user_id'	=> $account->id,
			'user_token'=> dohash($account->id . $account->password_hash)));
	}
	
	
	// _generate_salt()
	// Will generate a random string to use as a salt
	function _generate_salt() {
		if (!function_exists('random_string')) {
			$this->CI->load->helper('string');
		}
		
		return random_string('alnum', 7);
	}

}