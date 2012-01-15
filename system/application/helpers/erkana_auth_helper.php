<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

function authentication_errors() {
	$CI =& get_instance();
	
	if (class_exists('Erkana_auth')) {
		if (count($CI->erkana_auth->errors) > 0) {
			return implode('<br />', $CI->erkana_auth->errors);
		}
	}
	
	return NULL;
}