<?php
class Mail extends Controller {
	function __construct(){
		parent::Controller();
		$this->load->library('email');
		$this->load->model('liga');
	}
	
	function contacto() {		
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|xss_clean|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email|required');
        $this->form_validation->set_rules('telefono', 'Telefono', 'trim|xss_clean|numeric|required');
        $this->form_validation->set_rules('mensaje', 'Mensaje', 'trim|xss_clean|required');
        
        if ($this->form_validation->run() == FALSE ) {
            $this->layout->view('public/contacto_view');
        } else {   
            $subject = 'Formulario Contacto '; 
            $message = 'Nombre: '.$this->input->post('nombre').
                                  '\nEmail: '.$this->input->post('email').
                                  '\nTelefono: '.$this->input->post('telefono').
                                  '\nMensaje: '.$this->input->post('mensaje');	
            
            $this->send($subject, $message);
            $this->session->set_flashdata('ok','Gracias, te responderemos a la brevedad');
            redirect('');
        }
        
        
	}
	
	function send($subject,$message) {		
		$liga = $this->liga->get_actual();
		$subject = $liga->nombre.' > '.$subject;
		$config['charset'] = 'utf-8';
		$config['newline'] = '\n';
		$config['protocol'] = 'mail';
		$this->email->initialize($config);
		
		$this->email->from('web-liga', $liga->nombre);
		 
		$this->email->to($liga->email_administrador); 
		//$this->email->cc('tomasbarrios@gmail.com'); 
		
		$this->email->bcc('tomasbarrios@gmail.com');
		$this->email->subject($subject);	
		$this->email->message($message);
		
		if( $this->email->send() ) {
			return TRUE;
		} else {
			return FALSE;
		}		
		
		//echo $this->email->print_debugger();
	}
}
?>