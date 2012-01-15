<?php

class MY_Controller extends Controller {

    function __construct() {
        parent::__construct();

        $user_id = $this->session->userdata('user_id');
        
    }

}