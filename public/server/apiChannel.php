<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	function post_xml($url){
        $ch = curl_init();
		$headers = array();
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
	$url = $_GET['Burl'];
	$resp = post_xml($url);
	print_r($resp);
?>
