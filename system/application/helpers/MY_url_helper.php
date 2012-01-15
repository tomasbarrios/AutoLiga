<?php
	function clean_url($url){
		$url = prep_url(trim_slashes($url));
		$url = str_replace("http://", "", $url);
		$url = str_replace("www.", "", $url);
		return $url;
	}
?>