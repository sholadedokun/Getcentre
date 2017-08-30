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
    if($xml !=''){
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    }
    else{
        curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-type: application/x-www-form-urlencoded' );
    }
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
$xml_response_string='';
$search_id='';
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$flight_details=$request->f_det;

$child_dist=$request->c_dist;
$infant_dist=$request->i_dist;

$xml = new XMLWriter();
$xml->openMemory();
$xml->startDocument('1.0', 'UTF-8');
$xml->startElement('mds');
    $xml->startElement('auth');
        $xml->writeElement('login', 'NG.40038');
        $xml->writeElement('pass', 'GeX');
        $xml->writeElement('srcDomain', 'getcentre.com');
    $xml->endElement();
    $xml->startElement('request');
        $xml->writeElement('type', 'check_external_flight_wait');
        $xml->startElement('conditions');
            $xml->writeElement('par_adt',  $flight_details->Adult);
            $xml->writeElement('par_chd',  $flight_details->Child);
            $xml->writeElement('par_inf',  $flight_details->Infant);
            if( $flight_details->Child>0){
                $xml->writeElement('par_chdAge',  $child_dist);
            }
            if( $flight_details->Infant>0){
                $xml->writeElement('par_infAge',  $infant_dist);
            }


            $xml->writeElement('ofr_tourOp', 'XTVF,XSAB');
            $xml->writeElement('ofr_type', $flight_details->moduleType);
            // $xml->writeElement('adtFlightMarginInfo', 1);
            // check if it's a not multi destination.
            if($flight_details->moduleType !='MF'){
                $xml->writeElement('trp_depCode',  $flight_details->moduleCurrType->{0}->value->code);
                $xml->writeElement('trp_desCode',  $flight_details->moduleCurrType->{1}->value->code);
                if($flight_details->moduleType =='NF'){
                    $xml->writeElement('trp_depDate', $flight_details->moduleCurrType->{4}->value->short);
                    $xml->writeElement('trp_durationM',  $flight_details->moduleCurrType->{5}->value->fTravelDays);
                }
                else{
                    $xml->writeElement('trp_depDate', $flight_details->moduleCurrType->{2}->value->short);
                }
            }
            else{
                $xml->writeElement('ofr_routes', 'Multi');
                $xml->startElement('ofr_routes2');
                //start writing the other routes to xml
                foreach($flight_details->moduleCurrType->multCities as $otherRoute){
                    $xml->startElement('data');
                        $xml->writeElement('trp_depDate',  $otherRoute[2]->value->short);
                        $xml->writeElement('trp_depCode',  $otherRoute[0]->value->code);
                        $xml->writeElement('trp_desCode',  $otherRoute[1]->value->code);
                    $xml->endElement();
                }
                $xml->endElement();
            }
            if($flight_details->others[0]->value!='all'){
                $xml->writeElement('trp_flightClass', $flight_details->others[0]->value);
            }
             $xml->writeElement('extraData', 'adtFlightInfo');
        $xml->endElement();
    $xml->endElement();
$xml->endElement();
$xml->endDocument();
// echo "<pre>".var_dump($xml->outputMemory(true))."</pre>";
// die;
$xml_response_string = post_xml('http://mdswsng.merlinx.pl/dataV3/', $xml->outputMemory(true));
if(!$xml_response_string) {   die('ERROR'); }
else{
    $xml_response = simplexml_load_string($xml_response_string);
    $rester= $xml_response;
    fcontroller($xml_response);
// $re=turntojson($xml_response);
// echo($re);

}
function fcontroller($xml_response){
    $status=checkstatus($xml_response);
    // echo('here '.$status);

    if($status=="100,00DONE"){
        // echo('sas: '.$xml_response->external_search->search_id);
        getF($xml_response->external_search->search_id);
     }
    else{fcontroller($xml_response);}
}
function checkstatus($resp){
    $search_id=$resp->external_search->search_id;
    $url = 'http://mdswsng.merlinx.eu/backgroundstatuscheckV1/?id='.$search_id;
    $result = file_get_contents($url);
    $result =str_replace(array('(',')'),'',$result);
    $rett = json_decode($result);
    return $rett->progress.''.$rett->status;
}
function getF($search_id){
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $flight_details=$request->f_det;
    $child_dist=$request->c_dist;
    $infant_dist=$request->i_dist;
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
                $xml->writeElement('limit_count', '10');
                $xml->writeElement('calc_found', '1000');
                $xml->writeElement('par_adt',  $flight_details->Adult);
                $xml->writeElement('par_chd',  $flight_details->Child);
                $xml->writeElement('par_inf',  $flight_details->Infant);
                if( $flight_details->Child>0){
                    $xml->writeElement('par_chdAge',  $child_dist);
                }
                if( $flight_details->Infant>0){
                    $xml->writeElement('par_infAge',  $infant_dist);
                }

            //..    if( $flight_details->Infant>0){ $xml->writeElement('par_infAge',  $infant_dist);}

                $xml->writeElement('ofr_tourOp', 'XTVF,XSAB');

                $xml->writeElement('ofr_type', $flight_details->moduleType);

                if($flight_details->moduleType !='MF'){
                    if($flight_details->moduleType =='NF'){

                        $xml->writeElement('trp_depDate', $flight_details->moduleCurrType->{4}->value->short);
                        $xml->writeElement('trp_durationM',  $flight_details->moduleCurrType->{5}->value->fTravelDays);
                    }
                    else{
                        $xml->writeElement('trp_depDate', $flight_details->moduleCurrType->{2}->value->short);
                    }

                    $xml->writeElement('trp_depCode',  $flight_details->moduleCurrType->{0}->value->code);
                    $xml->writeElement('trp_desCode',  $flight_details->moduleCurrType->{1}->value->code);
                }
                else{
                    $xml->writeElement('ofr_routes', 'Multi');
                    $xml->startElement('ofr_routes2');
                    //start writing the other routes to xml
                    foreach($flight_details->moduleCurrType->multCities as $otherRoute){
                        $xml->startElement('data');
                            $xml->writeElement('trp_depDate',  $otherRoute[2]->value->short);
                            $xml->writeElement('trp_depCode',  $otherRoute[0]->value->code);
                            $xml->writeElement('trp_desCode',  $otherRoute[1]->value->code);
                        $xml->endElement();
                    }
                    $xml->endElement();
                }
                $xml->writeElement('adtFlightMarginInfo', 1);
                if($flight_details->others[0]->value!='all'){
                    $xml->writeElement('trp_flightClass', $flight_details->others[0]->value);
                }
                $xml->writeElement('extraData', 'adtFlightInfo');
            $xml->endElement();
        $xml->endElement();
    $xml->endElement();
    $xml->endDocument();
    //  echo "<pre>".var_dump($xml->outputMemory(true))."</pre>";
    //  die;
    $xml_response_string = post_xml('http://mdswsng.merlinx.pl/dataV3/', $xml->outputMemory(true));
    if(!$xml_response_string){   die('ERROR');   }
    $xml_response = simplexml_load_string($xml_response_string);
    // echo "<pre>".print_r($xml_response, true)."</pre>";
    $mark=getmark($flight_details->moduleCurrType->{0}->value->code, $flight_details->moduleCurrType->{1}->value->code);
    foreach ($xml_response as $eachflight) {
        // echo "<pre>".print_r($eachflight)."</pre>";
        $totalPrice=0;
         foreach($eachflight->extra->adtFlightInfo->persons as $persons ){
             foreach($persons as $person){
                 //only gives markup and down for aAdults
                 if($person->attributes()->type=='ADT'){
                    $marginPrice=compare($mark, $eachflight, $person, $flight_details->moduleType);
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
     $re=turntojson($xml_response, $search_id);
     echo($re);
}

function turntojson($xml_response, $s_id){
    $arrayData = (array)$xml_response;
    if (($arrayData != null)) {
        $arrayData = xmlToArray($xml_response, $s_id);
        	$arrayData['searchID']=(string)$s_id;
    }

    $jsonOutput=json_encode($arrayData);
    return $jsonOutput;
}

?>
