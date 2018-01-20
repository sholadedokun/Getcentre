    <?php
	//header("Content-Type: text/xml");
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

	 $xml='<HotelValuedAvailRQ echoToken="DummyEchoToken" sessionId="'.$_GET["sessionId"].'" xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/HotelValuedAvailRQ.xsd" version="2013/12">
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
	<PaginationData pageNumber="1" itemsPerPage="999" />
	<CheckInDate date="'.$_GET["hcheckin"].'"/>
	<CheckOutDate date="'.$_GET["hcheckout"].'"/>';

	if(strpos($_GET["hdescode"],'_')>0){
		$zcods=explode('_',$_GET["hdescode"]);
		$xml.='<Destination code="'.$zcods[0].'" type="SIMPLE"><ZoneList> <Zone type="SIMPLE" code="'.$zcods[1].'"/></ZoneList></Destination> <OccupancyList>';
	}
	else{$xml.='<Destination code="'.$_GET["hdescode"].'" type="SIMPLE"/> <OccupancyList>';}
	$roombreak=json_decode(stripslashes($_GET["hRoomBreak"]));
     // echo "<pre>".print_r($roombreak, true)."</pre>";
	$xmladdchild="";
	for($i=0; $i<count($roombreak); $i++){//loop through the number of rooms
		if($roombreak[$i][0]->value >0){
		$roomCount=1;
		$xmladdchild=''; //to reset additional child
			for($a=$i+1; $a<count($roombreak); $a++){
				if($roombreak[$i][0]->value==$roombreak[$a][0]->value){
					if($roombreak[$i][1]->value==$roombreak[$a][1]->value){
						$roomCount++;
						if($roombreak[$a][1]->value>0){//if there are children
							for($b=0; $b<$roombreak[$a][1]->value; $b++){
								$xmladdchild.='<Customer type="CH"> <Age>'.$roombreak[$a][1]->ages[$b]->valueYear.'</Age> </Customer>';
							}
						}
						array_splice($roombreak, $a, 1);
					}
				}
			}
		 $xml.='<HotelOccupancy>
		 			<RoomCount>'.$roomCount.'</RoomCount>
					<Occupancy>
						<AdultCount>'.$roombreak[$i][0]->value.'</AdultCount>
						<ChildCount>'.$roombreak[$i][1]->value.'</ChildCount>';
			if($roombreak[$i][1]->value>0){//if there are children
				 $xml.='<GuestList> ';
                 // print_r($roombreak[$i][1]->value);
				 for($b=0; $b<$roombreak[$i][1]->value; $b++){
					$xml.='<Customer type="CH"> <Age>'.$roombreak[$i][1]->ages[$b]->valueYear.'</Age> </Customer>';
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
 // echo "<pre>".print_r($xml, true)."</pre>";
 $xml_response_string = post_xml('http://api.interface-xml.com/appservices/http/FrontendService',  $xml);
  // $xml_response_string = post_xml('http://testapi.interface-xml.com/appservices/http/FrontendService',  $xml);
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
	// echo '<pre>'.print_r($array1).'</pre>';
	if (($array1 != null)) {
		$arrayData = xmlToArray($xml_response);
		$a_json = array();
		$a_json_row = array();

		$a_json['total']=$arrayData[HotelValuedAvailRS]['@totalItems'];
		$a_json['currency']=$arrayData[HotelValuedAvailRS][ServiceHotel][0][Currency]['@code'];
		$a_json['hotelList']=array();
		for ($i=0; $i<count($arrayData[HotelValuedAvailRS][ServiceHotel]); $i++){
			$a_json_row['availToken']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i]['@availToken'];
			$a_json_row['availRoom']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i][AvailableRoom];
			$a_json_row['dateFrom']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i][DateFrom]['@date'];
			$a_json_row['dateTo']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i][DateTo]['@date'];
			$a_json_row['contractName']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i][ContractList][Contract][Name];
			$a_json_row['contractCode']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i][ContractList][Contract][IncomingOffice]['@code'];
			$a_json_row['hotelName']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i][HotelInfo][Name];
			$a_json_row['hotelImages']=array();
			for($m=0; $m<count($arrayData[HotelValuedAvailRS][ServiceHotel][$i][HotelInfo][ImageList][Image]); $m++){
				try{array_push($a_json_row['hotelImages'], $arrayData[HotelValuedAvailRS][ServiceHotel][$i][HotelInfo][ImageList][Image][$m][Url]);}
				catch(Exception $e){
					array_push($a_json_row['hotelImages'], $arrayData[HotelValuedAvailRS][ServiceHotel][$i][HotelInfo][ImageList][Image][Url]);
				}
			}
			$a_json_row['hotelCat']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i][HotelInfo][Category];
			$a_json_row['hotelCode']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i][HotelInfo][Code];
			$a_json_row['destination']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i][HotelInfo][Destination];
			$a_json_row['position']=$arrayData[HotelValuedAvailRS][ServiceHotel][$i][HotelInfo][Position];
			$a_json_row['tag']='HotelBed';
			array_push($a_json['hotelList'],$a_json_row);
		}
	}
	echo json_encode($a_json);
    ?>
