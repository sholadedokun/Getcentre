    <?php
	header("Content-Type: text/xml");
	error_reporting(E_ALL);
	ini_set('display_errors', 0);

	require_once 'JSON.php';
	require_once 'fun_connect.php';
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
	$guests=json_decode($_GET["Guest"], true);

	$xml='
	<PurchaseConfirmRQ xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/PurchaseConfirmRQ.xsd" version="2013/12">
		<Language>ENG</Language>
		<Credentials>
			<User>GETCENTRENG163996</User>
			<Password>GETCENTRENG163996</Password>
		</Credentials>
		<ConfirmationData purchaseToken="'.$_GET["ptoken"].'">
			<Holder type="AD">
				<CustomerId>Hldr</CustomerId>
				<Age>45</Age>';
				$g=explode(' ', $_GET["leadHolder"]);
				$xml.='
				<Name>'.$g[0].'</Name>
				<LastName>'.$g[1].'</LastName>
			</Holder>
			<AgencyReference>Test AgencyRef</AgencyReference>
			<ConfirmationServiceDataList>
				<ServiceData SPUI="'.$_GET["SerSpui"].'" xsi:type="ConfirmationServiceDataHotel">
					<CustomerList>';
					$b=1;
				for($i=0; $i<count($guests); $i++){
					for($a=0; $a<count($guests[$i][0]); $a++){
						$g=explode(" ",$guests[$i][0][$a][0]);
						$xml.='<Customer type="AD"><CustomerId>'.$b.'</CustomerId>
						<Age>45</Age>
						<Name>'.$g[0].'</Name>
						<LastName>'.$g[1].'</LastName>
						</Customer>';
						$b++;
					}
					if(count($guests[$i][1])>0){
						for($a=0; $a<count($guests[$i][1]); $a++){
							$g=explode(" ",$guests[$i][1][$a][0]);
							$xml.='<Customer type="CH"><CustomerId>'.$b.'</CustomerId>
							<Age>12</Age><Name>'.$g[0].'</Name><LastName>'.$g[1].'</LastName></Customer>';
							$b++;
						}
					}
				}
					$xml.='</CustomerList>
								<CommentList>';

					for($a=0; $a<count($guests[$a]); $a++){
						if($guests[$a][2] !=''){
								$xml.='<Comment type="INCOMING">'.$guests[$a][2].'</Comment>';
						}
						else{
							$xml.='<Comment type="INCOMING">No Comment</Comment>';
						}
					}
		$xml.='</CommentList></ServiceData></ConfirmationServiceDataList></ConfirmationData></PurchaseConfirmRQ>';
	/*<CheckInDate date="'.$_GET["hcheckin"].'"/>
	<CheckOutDate date="'.$_GET["hcheckout"].'"/>
	<Destination code="'.$_GET["hDesCode"].'" type="SIMPLE"/>
	<OccupancyList>';
	$roombreak=$_GET["hRoomBreakDown"];
	for($i=0; $i<6; $i++){//loop through the number of rooms

		if($roombreak[$i][3]>0){
		 $xml.='<HotelOccupancy>
		 			<RoomCount>1</RoomCount>
					<Occupancy>
						<AdultCount>'.$roombreak[$i][3].'</AdultCount>
						<ChildCount>'.$roombreak[$i][5].'</ChildCount>';
			if($roombreak[$i][5]>0){//if there are children
				 $xml.='<GuestList>
							<Customer type="CH">
							<Age>12</Age>
							</Customer>
						</GuestList> ';
				}
			$xml.='	</Occupancy>
				</HotelOccupancy>';
		}
	}
	$xml.='
	</OccupancyList>
</ServiceAddRQ>
';*/
  $xml_response_string = post_xml('http://testapi.interface-xml.com/appservices/http/FrontendService',  $xml);

    if(!$xml_response_string)
        die('ERROR');

    $xml_response = simplexml_load_string($xml_response_string);
	//echo "<pre>".print_r($xml_response, true)."</pre>";
	$string_response= "<pre>".print_r($xml_response, true)."</pre>";

	$file = 'serviceAdd_log.txt';
	// Open the file to get existing content
	$current = file_get_contents($file);
	// Append a new person to the file
	$current .=  $string_response."\n";
	// Write the contents back to the file
	file_put_contents($file, $current);
	$array1 = (array) $xml_response;
	if (($array1 != null) && (sizeof($array1) > 0)) {
		$arrayData = xmlToArray($xml_response);
		$jsonOutput=json_encode($arrayData);
	}
	echo $jsonOutput;
    ?>
