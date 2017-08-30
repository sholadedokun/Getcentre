    <?php
	header("Content-Type: text/xml");
	error_reporting(E_ALL);
	ini_set('display_errors', 0);

	require_once 'JSON.php';
    function post_xml($url, $xml){
        $ch = curl_init();
		$headers = array();
		$headers[] = 'Content-Type:application/xml';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST,   1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/xml'
                                            ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
  $t=time();

	 $xml='<HotelValuedAvailRQ echoToken="DummyEchoToken" sessionId="'.$t.'" xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/HotelValuedAvailRQ.xsd" version="2013/12">
	<Language>ENG</Language>
	<Credentials>
		<User>GETCENTRENG163996</User>
		<Password>GETCENTRENG163996</Password>
	</Credentials>
	<ExtraParamList>
		<ExtendedData type="EXT_ADDITIONAL_PARAM">
		<Name>PARAM_KEY_PRICE_BREAKDOWN</Name>
		<Value>Y</Value>
		</ExtendedData>
	</ExtraParamList>
	<PaginationData pageNumber="1" itemsPerPage="30"/>
	<CheckInDate date="'.$_GET["hcheckin"].'"/>
	<CheckOutDate date="'.$_GET["hcheckout"].'"/>';

	if(strpos($_GET["hdescode"],'_')>0){
		$zcods=explode('_',$_GET["hdescode"]);
		$xml.='<Destination code="'.$zcods[0].'" type="SIMPLE"><ZoneList> <Zone type="SIMPLE" code="'.$zcods[1].'"/></ZoneList></Destination> <OccupancyList>';
	}
	else{$xml.='<Destination code="'.$_GET["hdescode"].'" type="SIMPLE"/> <OccupancyList>';}
	$roombreak=json_decode($_GET["hRoomBreak"]);
	$xmladdchild="";
	for($i=0; $i<count($roombreak); $i++){//loop through the number of rooms
		if($roombreak[$i][1]>0){
		$roomCount=1;
			for($a=$i+1; $a<count($roombreak); $a++){
				if($roombreak[$i][1]==$roombreak[$a][1]){
					if((count($roombreak[$i][2]))==(count($roombreak[$a][2]))){
						$roomCount++;
						if(count($roombreak[$a][2])>0){//if there are children
							for($b=0; $b<count($roombreak[$a][2]); $b++){
								$xmladdchild.='<Customer type="CH"> <Age>'.$roombreak[$a][2][$b].'</Age> </Customer>';
							}
						}
						array_splice($roombreak, $a, 1);
					}
				}
			}
		 $xml.='<HotelOccupancy>
		 			<RoomCount>'.$roomCount.'</RoomCount>
					<Occupancy>
						<AdultCount>'.$roombreak[$i][1].'</AdultCount>
						<ChildCount>'.count($roombreak[$i][2]).'</ChildCount>';
			if(count($roombreak[$i][2])>0){//if there are children
				 $xml.='<GuestList> ';
				 for($b=0; $b<count($roombreak[$i][2]); $b++){
					$xml.='<Customer type="CH"> <Age>'.$roombreak[$i][2][$b].'</Age> </Customer>';
				}
				$xml.=$xmladdchild.' </GuestList> ';
			}
			$xml.='</Occupancy> </HotelOccupancy>';
		}
	}
	$xml.='
	</OccupancyList>
</HotelValuedAvailRQ>
';
//echo "<pre>".print_r($xml, true)."</pre>";
  $xml_response_string = post_xml('http://testapi.interface-xml.com/appservices/http/FrontendService',  $xml);

    if(!$xml_response_string)
        die('ERROR');


	//$string_response= "<pre>".print($xml_response)."</pre>";

	$file = 'hotel_avail_log.txt';
	// Open the file to get existing content
	//$current = file_get_contents($file);
	// Append a new person to the file
//	$current =  $string_response."\n";
	// Write the contents back to the file
	file_put_contents($file, $xml_response_string);
	$xml_response = simplexml_load_string($xml_response_string);

	$array1 = (array)$xml_response;
	if (($array1 != null)) {
		$arrayData = xmlToArray($xml_response);
		$jsonOutput=json_encode($arrayData);

	}
	echo $jsonOutput;
    ?>
