<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'][] = array(
                                             'class'    => 'Inicio',
                                             'function' => 'cargar_liga',
                                             'filename' => 'inicio.php',
                                             'filepath' => 'hooks'
                                             );
/*
$hook['post_controller_constructor'][] = array(
                                             'class'    => 'Estado',
                                             'function' => 'cargar_liga',
                                             'filename' => 'estado.php',
                                             'filepath' => 'hooks'
                                             );

$hook['post_controller_constructor'][] = array(
                                             'class'    => 'Estado',
                                             'function' => 'cargar_campeonato',
                                             'filename' => 'estado.php',
                                             'filepath' => 'hooks'
                                             );

$hook['post_controller_constructor']=array(
                    'class' => 'Inicio',
                    'function' => 'cargar_campeonato',
                    'filename' => 'inicio.php',
                    'filepath' => 'hooks'
                    );
*/


/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */