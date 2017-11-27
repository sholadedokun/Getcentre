    <?php
    error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once 'JSON.php';
    require_once 'fun_connect2.php';
    require_once 'markup_down.php';
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
        $flight=$request->f_det;
        $flight_details=$flight->moduleCurrType;

        $search_id=$flight->searchId;
		$xml = new XMLWriter();
		$xml->openMemory();
		$xml->startDocument('1.0', 'UTF-8');
		$xml->startElement('mds');
            $xml->writeElement('external_search_id', $search_id);
			$xml->startElement('auth');
				$xml->writeElement('login', 'NG.40038');
				$xml->writeElement('pass', 'GeX');
				$xml->writeElement('srcDomain', 'getcentre.com');
			$xml->endElement();
			$xml->startElement('request');
				$xml->writeElement('type', 'offers');
				$xml->startElement('conditions');
                if($flight->moduleType !='MF'){
                    $xml->writeElement('ofr_tourOp', 'XTVF,XSAB');
                    if (isset( $flight->module)){
                        $xml->writeElement('trp_depDate', $flight_details->{3}->value->short);
    					$xml->writeElement('limit_count', '10');
    					$xml->writeElement('limit_from', $flight->limit_count);
    					$xml->writeElement('trp_depCode', $flight_details->{0}->value->code);
    					$xml->writeElement('trp_desCode',  $flight_details->{1}->value->code);
    					$xml->writeElement('par_adt',  $flight->Adult);
                        $xml->writeElement('par_chd',  $flight->Child);
                        $xml->writeElement('par_inf',  $flight->Infant);
                        if( $flight->Child>0){
                            $xml->writeElement('par_chdAge',  $flight->Child_ageDist);
                        }
                        if( $flight->Infant>0){
                            $xml->writeElement('par_infAge',  $flight->Infant_ageDist);
                        }
    					$xml->writeElement('trp_durationM',   $flight_details->{4}->value->fTravelDays);
                        //$xml->writeElement('adtFlightMarginInfo', 1);
    					$xml->writeElement('ofr_type', $flight->moduleType);
    					if($flight->others[0]->value!='all'){
                            $xml->writeElement('trp_flightClass', $flight->others[0]->value);
                        }
    				}
                }
                else{
                    $xml->writeElement('par_adt',  $flight->Adult);
                    $xml->writeElement('par_chd',  $flight->Child);
                    $xml->writeElement('par_inf',  $flight->Infant);
                    if( $flight->Child>0){
                        $xml->writeElement('par_chdAge', $flight->Child_ageDist);
                    }
                    if( $flight->Infant>0){
                        $xml->writeElement('par_infAge',  $flight->Infant_ageDist);
                    }
                    $xml->writeElement('limit_count', '10');
                    $xml->writeElement('limit_from',$flight->limit_count);
                    $xml->writeElement('ofr_type',  $flight->moduleType);
                    if($flight->others[0]->value!='all'){
                        $xml->writeElement('trp_flightClass', $flight->others[0]->value);
                    }
                    $xml->writeElement('ofr_routes', 'Multi');
                    $xml->startElement('ofr_routes2');
                    //start writing the other routes to xml
                    foreach($flight_details->multCities as $otherRoute){
                        $xml->startElement('data');
                            $xml->writeElement('trp_depDate',  $otherRoute[2]->value->short);
                            $xml->writeElement('trp_depCode',  $otherRoute[0]->value->code);
                            $xml->writeElement('trp_desCode',  $otherRoute[1]->value->code);
                        $xml->endElement();
                    }
                    $xml->endElement();
                }
                //attempting to add grouping to the xml
                $xml->writeElement('trp_depCodeIsGroup', 1);
                $xml->writeElement('trp_desCodeIsGroup', 1);

                //attempting to add other variables I don't know
                $xml->writeElement('useMerlinMargin', 1);
                $xml->writeElement('flightAdvancedSearch', 1);
                $xml->writeElement('rule_checker', 1);
                $xml->writeElement('language', 'EN');
                $xml->writeElement('calcPrecision', 2);
                $xml->writeElement('flightmixed', 0);
                $xml->writeElement('order_by', "ofr_price");


				$xml->writeElement('extraData', 'adtFlightInfo,extMarginFlights');
				$xml->endElement();
			$xml->endElement();
		$xml->endElement();
		$xml->endDocument();
        // echo "<pre>".var_dump($xml->outputMemory(true))."</pre>";
        // die;
        $xml_response_string = post_xml('https://mws.merlinx.pl/dataV4/', $xml->outputMemory(true));
		if(!$xml_response_string){   die('ERROR');   }
		$xml_response = simplexml_load_string($xml_response_string);

        $mark=getmark($flight->moduleCurrType->{0}->value->code, $flight->moduleCurrType->{1}->value->code);
        foreach ($xml_response as $eachflight) {
            // echo "<pre>".print_r($eachflight)."</pre>";
            $totalPrice=0;
             foreach($eachflight->extra->adtFlightInfo->persons as $persons ){
                 foreach($persons as $person){
                     //only gives markup and down for aAdults
                     if($person->attributes()->type=='ADT'){
                        $marginPrice=compare($mark, $eachflight, $person, $flight->moduleType);
                        if($marginPrice>0){
                            $totalPrice+=$marginPrice;
                        }
                     }
                    // echo "<pre>".print_r($per->attributes()->type, true)."</pre>";
                }
             }
             if($totalPrice > 0){
                 $eachflight['operPrice']=$totalPrice;
             }
        }

		$re=turntojson($xml_response);
		echo($re);

	function turntojson($xml_response){
		$array1 = (array)$xml_response;
		if (($array1 != null)) {
			$arrayData = xmlToArray($xml_response);
			$jsonOutput=json_encode($arrayData);
		}
		return $jsonOutput;
	}
?>
