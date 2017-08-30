<?php
    header('Access-Control-Allow-Origin: *');
    error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once 'JSON.php';
    function post_xml($url, $xml){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST,   1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    $xml = new XMLWriter();
    $xml->openMemory();
    $xml->startDocument('1.0', 'UTF-8');
    $xml->startElement('mds');
        $xml->startElement('auth');
            $xml->writeElement('login', 'NG.40038');
            $xml->writeElement('pass', 'GeX');
			$xml->writeElement('languagecode',  'EN');
			$xml->writeElement('srcDomain', 'getcentre.com');
        $xml->endElement();
        $xml->startElement('request');
            $xml->writeElement('type', 'checkavail');
            $xml->startElement('conditions');
                $xml->writeElement('language',  'EN');
                if(isset($_GET["fOfferCode"])){
                    $xml->writeElement('ofr_id', $_GET["fOfferCode"]);
    				$xml->writeElement('ofr_tourOp', $_GET["tourop"]);
    				$xml->writeElement('par_adt', $_GET["Adult"]);
    				$xml->writeElement('par_chd', $_GET["Child"]);
    				$xml->writeElement('par_inf', $_GET["Infant"]);
    				$xml->startElement('birthdates');
    				for($ad=0; $ad<$_GET["Adult"]; $ad++){
    					$xml->writeElement('adta', '19861106');
    				}
    				for($ad=0; $ad<$_GET["Child"]; $ad++){
    					$xml->writeElement('chda', '20111106');
    				}
    				for($ad=0; $ad<$_GET["Infant"]; $ad++){
    					$xml->writeElement('infa', '20151106');
    				}
                }
                else{
                    $flight_details=json_decode($_GET["f_det"]);
                    $xml->writeElement('ofr_id', $flight_details->fOfferCode);
    				$xml->writeElement('ofr_tourOp', $flight_details->fTourOp);
    				$xml->writeElement('par_adt', $flight_details->Adult);
    				$xml->writeElement('par_chd', $flight_details->Child);
    				$xml->writeElement('par_inf', $flight_details->Infant);
    				$xml->startElement('birthdates');
    				for($ad=0; $ad<$flight_details->Adult; $ad++){
    					$xml->writeElement('adta', '19861106');
    				}
    				for($ad=0; $ad<$flight_details->Child; $ad++){
    					$xml->writeElement('chda', '20111106');
    				}
    				for($ad=0; $ad<$flight_details->Infant; $ad++){
    					$xml->writeElement('infa', '20151106');
    				}
                }
				$xml->endElement();
            $xml->endElement();
        $xml->endElement();
    $xml->endElement();
    $xml->endDocument();
    $xml_response_string = post_xml('http://mdswsng.merlinx.eu/onlineflightexternalV1/', $xml->outputMemory(true));
    if(!$xml_response_string)  die('ERROR');
    $xml_response = simplexml_load_string($xml_response_string);
	$array1 = (array)$xml_response;
	if (($array1 != null)) {
		$arrayData = xmlToArray($xml_response);
		$jsonOutput=json_encode($arrayData);
	}
	echo $jsonOutput;
?>
