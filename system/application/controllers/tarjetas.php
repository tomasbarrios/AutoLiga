<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tarjetas
 *
 * @author tomi
 */
class Tarjetas extends Controller{

    public function  __construct() {
        parent::__construct();
        $this->load->model('incidente');
        $this->load->model('equipo');
        $this->load->model('jugador');
        $this->load->model('fecha');
    }

    public function amarillas(){
        $data['tarjetas'] = $this->incidente->get_incidentes('amarilla');
        $this->layout->view('tarjetas/index',$data);
    }

    public function rojas(){
        $data['tarjetas'] = $this->incidente->get_incidentes('roja');
        $this->layout->view('tarjetas/index',$data);
    }
}
?>
