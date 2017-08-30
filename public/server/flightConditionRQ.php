    <?php
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
    $postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
    $flight_details=$request->f_det;
    $search_id=$request->f_det->searchId;
    // print_r($flight_details);


    $xml = new XMLWriter();
    $xml->openMemory();
    $xml->startDocument('1.0', 'UTF-8');

    $xml->startElement('mds');
        $xml->writeElement('external_search_id', $search_id);
        $xml->startElement('auth');
            $xml->writeElement('login', 'NG.40038');
            $xml->writeElement('pass', 'GeX');
			$xml->writeElement('languagecode',  'EN');
			$xml->writeElement('srcDomain', 'getcentre.com');
        $xml->endElement();
        $xml->startElement('request');
            $xml->writeElement('type', 'gettariffs');
            $xml->startElement('conditions');

				$xml->writeElement('ofr_id', $flight_details->fOfferCode);
				$xml->writeElement('ofr_tourOp', $flight_details->tourOp);
            //    if(isset($flight_details->fPassBreak))
				$xml->writeElement('par_adt',$flight_details->Adult);
			//	if(isset($flight_details->Child) && $flight_details->Child>0){$xml->writeElement('par_chdAge',  $child_dist);}
				$xml->writeElement('par_chd',  $flight_details->Child);
				//$xml->writeElement('par_chd',  $_GET[Child);
				$xml->writeElement('par_inf',  $flight_details->Infant);
                $xml->writeElement('language', 'EN');
				// $xml->writeElement('birthdates');
            $xml->endElement();
        $xml->endElement();
    $xml->endElement();
    $xml->endDocument();
    //   echo "<pre>".var_dump($xml->outputMemory(true))."</pre>";
    $xml_response_string = post_xml('http://mdswsng.merlinx.eu/onlineflightexternalV1/', $xml->outputMemory(true));
    if(!$xml_response_string)  die('ERROR');
    $xml_response = simplexml_load_string($xml_response_string);
    // print_r($xml_response) ;
    // echo "<pre>".var_dump($xml_response)."</pre>";
    // $jsonOutput;
	$array1 = (array)$xml_response;
	if (($array1 != null)) {
		$arrayData = xmlToArray($xml_response);
		$jsonOutput=json_encode($arrayData);
	}
	echo $jsonOutput;
    ?>
