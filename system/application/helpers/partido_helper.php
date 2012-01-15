<?php

function get_penales($id_partido, $id_equipo){
    $CI =& get_instance();
    $CI->load->model('incidente');
    $CI->incidente
            ->where('incidente','penal')
            ->where('id_partido',$id_partido)
            ->where('id_equipo', $id_equipo)->get();

}

?>
