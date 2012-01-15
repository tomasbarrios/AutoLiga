<?php
function mensaje_ok($msg){
	$CI =& get_instance();
	$oks = $CI->session->flashdata('ok');
	$oks[] = strip_tags($msg);
	$CI->session->set_flashdata('ok',$oks);
}

function mensaje_error($msg){
	$CI =& get_instance();
	$errors = $CI->session->flashdata('error',$msg);
	$errors[] = strip_tags($msg);
	$CI->session->set_flashdata('error',$errors);
}