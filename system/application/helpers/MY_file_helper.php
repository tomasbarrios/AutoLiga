<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

function imagen_sponsor($id_sponsor, $tipo = '') {
	$CI =& get_instance();
	$ruta = 'imagenes/sponsors/';
    $url = $CI->config->item('base_url'); 
    $imagen = $ruta.$id_sponsor.$tipo.'.jpg';           
	if(file_exists($imagen)){		 
		$imagen = $url.$imagen;
	} else {
		$imagen = FALSE;
	}
	return $imagen;
}

function get_file($path, $archivo, $texto = 'Ver Archivo',$delete = FALSE){

                //$path = DOC_PATH.'/'.$tipo.'s'.'/'.$id.'/';
                //$dir = DOCROOT.$path;
                $result = read_file($path.$archivo);
                log_message('debug',print_r('archivo... : '.$path.$archivo.' EXISTE?: '.$result,true));
                if($result){
                    return anchor($path.$archivo,$texto);
                }else{
                    return false;
                }
        }
