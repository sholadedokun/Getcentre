<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
  $url = $_GET['url'];
 $request = curl_init(); 
 $timeOut = 0; 
 curl_setopt ($request, CURLOPT_URL, $url); 
 curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1); 
 curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); 
 curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut); 
 $response = curl_exec($request); 
 curl_close($request);
 $a_json = array();
 $a_json_row = array();
  $regularExpression     = '#\<span class=bld\>(.+?)\<\/span\>#s';
    preg_match($regularExpression, $response, $finalData);
	$pattern = '/[> ]/';
	$res=preg_split( $pattern, $finalData[0]);
	$a_json_row['rate']=$res[2];
	$a_json_row['index']= $_GET['index'];
	array_push($a_json, $a_json_row);
	//$res= explode('>', $finalData[0]);
	print_r(json_encode($a_json)); 
 ?>