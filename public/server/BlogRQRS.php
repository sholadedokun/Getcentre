<?php
	//error_reporting(E_ALL);
	//ini_set('display_errors', 0);
	require_once 'JSON.php';
	function post_xml($url){
        $ch = curl_init();
		$headers = array();
		//$headers[] = 'Content-Type:application/xml';

        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          //                                  'Content-Type: application/xml'
      //                                      ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
	//$headers = array();
	//$headers[] =  'Hash:'+$hasher;
	//echo $headers;
	//curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
	// Send the request & save response to $resp
	$url = $_GET['Burl'];
	$resp = post_xml($url);
	$a_json = array(); $a_json_row = array();
	$a_json_row['blog']=$resp;
	array_push($a_json, $a_json_row);
	//$res= explode('>', $finalData[0]);
	print_r($resp);
	//echo($resp);
	//echo($resp);
	//if(!$resp)  die('ERROR');
   /* $xml_response = simplexml_load_string($resp);
	$array1 = (array)$xml_response;
	if (($array1 != null)) {
		$arrayData = xmlToArray($xml_response);
		$jsonOutput=json_encode($arrayData);
	}
	echo $jsonOutput;*/
?>

<?php
/*
	//error_reporting(E_ALL);
	//ini_set('display_errors', 0);
	require_once 'JSON.php';
	$url = $_GET['Burl'];
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_URL => $url,
		//CURLOPT_HEADER=> true, // set to true if you want headers in the output
		//CURLOPT_NOBODY=> true, // set to true if you do not want the body
		CURLOPT_CONNECTTIMEOUT=> 30,
		CURLOPT_RETURNTRANSFER=> false,
		CURLOPT_SSL_VERIFYPEER=> false,
		CURLOPT_FOLLOWLOCATION=> true, // set to false if you want to see what redirect header was sent
		//CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; MS Web Services Client Protocol 4.0.30319.239)'
	));
	//$headers = array();
	//$headers[] =  'Hash:'+$hasher;
	//echo $headers;
	//curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	curl_close($curl);
	echo "<pre>".print_r(json_decode($resp), true)."</pre>";
	//echo(json_decode($resp));
	if(!$resp)  die('ERROR');
    $xml_response = simplexml_load_string($resp);
	$array1 = (array)$xml_response;
	if (($array1 != null)) {
		$arrayData = xmlToArray($xml_response);
		$jsonOutput=json_encode($arrayData);
	}
	echo $jsonOutput;*/
?>
