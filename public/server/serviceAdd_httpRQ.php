    <?php
	//header("Content-Type: text/xml");
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
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	//$Arooms=json_decode($bookData);

	// echo "<pre>".print_r($postdata, true)."</pre>";
	$xml='<ServiceAddRQ';
	if($request->pToken!='none'){$xml.=' purchaseToken="'.$request->pToken.'"';}
	$xml.=' xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/ServiceAddRQ.xsd" version="2013/12">
	<Language>ENG</Language>
	<Credentials>
		<User>GETCENTRENG163996</User>
		<Password>GETCENTRENG163996</Password>
	</Credentials>
	<Service availToken="'.$request->Availtoken.'" xsi:type="'.$request->ServiceType.'"'; if(isset($request->TransferType)){$xml.=' transferType="'.$request->TransferType.'"';}$xml.='>
		<ContractList>
			<Contract>
				<Name>'.$request->contractName.'</Name>
				<IncomingOffice code="'.$request->contractCode.'"/>
			</Contract>
		</ContractList>
		<DateFrom date="'.$request->DateFrom.'"'; if(isset($request->DateFTime)){$xml.=' time="'.$request->DateFTime.'"';} $xml.='/>';
		if(isset($request->DateTo)){$xml.=' <DateTo date="'.$request->DateTo.'"/>';}
		if($request->ServiceType=='ServiceHotel'){
			$xml.=' <HotelInfo xsi:type="ProductHotel">
			<Code>'.$request->hotelcode.'</Code>
			<Destination code="'.$request->destcode.'" type="SIMPLE"/>
			</HotelInfo>';
			$Guest=json_decode(json_encode($request->Guest));
			$bookData=json_decode(json_encode($request->bookData));

			for($i=0; $i<count($bookData); $i++){
				$rCount=$bookData[$i]->HotelOccupancy->RoomCount;
				$xml.='<AvailableRoom>
					<HotelOccupancy>
						<RoomCount>'.$rCount.'</RoomCount>
						<Occupancy>
						<AdultCount>'.$Guest[$i][0]->value.'</AdultCount>
						<ChildCount>'.$Guest[$i][1]->value.'</ChildCount>
						<GuestList>';
				$aguest=$Guest[$i][0]->value*$rCount;
                $achild=$Guest[$i][1]->value*$rCount;
				for($a=0; $a<$aguest; $a++){
					$xml.='<Customer type="AD"><Age>45</Age><Name>GuestAdultFname'.($a+1).'</Name><LastName>GuestAdultLname'.($a+1).'</LastName></Customer>';
				}
                // print_r($Guest);
				if($rCount>1 && $achild>0){
					for($z=0+$i; $z<$rCount; $z++){
						for($b=0; $b<$Guest[$z][1]->value; $b++){
							$xml.='<Customer type="CH"> <Age>'.$Guest[$z][1]->ages[$b]->valueYear.'</Age> </Customer>';
						}
					}
					//array_splice($request->Guest, $a, 1);
				}
				elseif($achild>0){
					for($a=0; $a<$achild; $a++){
						$xml.='<Customer type="CH"><Age>'.$Guest[$i][1]->ages[$a]->valueYear.'</Age><Name>GuestChildFname'.($a+1).'</Name><LastName>GuestAdultFname'.($a+1).''.$g[1].'</LastName></Customer>';
					}
				}
				$xml.='</GuestList>	</Occupancy></HotelOccupancy>';

				//echo "<pre>".print_r($bookData[0]->HotelRoom->{'@SHRUI'}, true)."</pre>";

				if($rCount>1 && isset($bookData[1]->HotelRoom->{'@SHRUI'}) ){
					for($z=0+$i; $z<$rCount; $z++){
						if(($bookData[$z+1]->HotelRoom->Board->{'@code'}==$bookData[$z]->HotelRoom->Board->{'@code'})&&($bookData[$z+1]->HotelRoom->RoomType->{'@code'}==$bookData[$z]->HotelRoom->RoomType->{'@code'})){
				$xml.='<HotelRoom SHRUI="'.$bookData[$z]->HotelRoom->{'@SHRUI'}.'">
						<Board code="'.$bookData[$z]->HotelRoom->Board->{'@code'}.'" type="'.$bookData[$z]->HotelRoom->Board->{'@type'}.'"/>
						<RoomType characteristic="'.$bookData[$z]->HotelRoom->RoomType->{'@characteristic'}.'"  code="'.$bookData[$z]->HotelRoom->RoomType->{'@code'}.'" type="SIMPLE"/>
					</HotelRoom>'; $z++;
						}
						else{
							$xml.='<HotelRoom SHRUI="'.$bookData[$z]->HotelRoom->{'@SHRUI'}.'">
						<Board code="'.$bookData[$z]->HotelRoom->Board->{'@code'}.'" type="'.$bookData[$z]->HotelRoom->Board->{'@type'}.'"/>
						<RoomType characteristic="'.$bookData[$z]->HotelRoom->RoomType->{'@characteristic'}.'"  code="'.$bookData[$z]->HotelRoom->RoomType->{'@code'}.'" type="SIMPLE"/>
					</HotelRoom>';
						}
					}
					$xml.='</AvailableRoom>';
					$i++;
				}
				else{

						$xml.='<HotelRoom SHRUI="'.$bookData[$i]->HotelRoom->{'@SHRUI'}.'">
							<Board code="'.$bookData[$i]->HotelRoom->Board->{'@code'}.'" type="'.$bookData[$i]->HotelRoom->Board->{'@type'}.'"/>
							<RoomType characteristic="'.$bookData[$i]->HotelRoom->RoomType->{'@characteristic'}.'"  code="'.$bookData[$i]->HotelRoom->RoomType->{'@code'}.'" type="SIMPLE"/>
						</HotelRoom></AvailableRoom>';

				}
			}
		}

		if($request->ServiceType=='ServiceTicket'){
			$xml.='<Currency code="'.$request->currency.'"/>
			<TicketInfo xsi:type="ProductTicket">
    			<Code>'.$request->ticketcode.'</Code>
    			<Destination code="'.$request->destcode.'" type="SIMPLE"/>
    		</TicketInfo>
    		<AvailableModality code="'.$request->availcode.'">
    			<Name>'.$request->availName.'</Name>
    			<Contract>
    				<Name>'.$request->availContactName.'</Name>
    				<IncomingOffice code="'.$request->availContactcode.'"/>
    			</Contract>
    		</AvailableModality>';

		}
		if($request->ServiceType=='ServiceTransfer'){
			$xml.='
    		<TransferInfo xsi:type="ProductTransfer">
    			<Code>'.$request->code.'</Code>
    			<Type code="'.$request->codeType.'"/>
    			<VehicleType code="'.$request->VType.'"/>
    		</TransferInfo>';
		}
		if($request->ServiceType!='ServiceHotel'){
			$guest=json_decode($request->Guest);


			$tourbreak=json_decode($request->tourBreakDown);
			$xml.='<Paxes>
			<AdultCount>'.$request->tourAdult.'</AdultCount>
			<ChildCount>'.$request->tourChild.'</ChildCount>';
			$xml.='<GuestList> ';
			for($b=0; $b<$tourbreak[0]->value; $b++){
				$xml.='<Customer type="AD"> <Age>30</Age> <Name>Adult</Name><LastName>Tourist'.($b+1).'</LastName></Customer>';
			}
			for($b=0; $b<count($tourbreak[1]->Ages); $b++){
				$xml.='<Customer type="CH"> <Age>'.$tourbreak[0][1]->Ages[$b].'</Age><Name>Child</Name><LastName>Tourist'.($b+1).'</LastName></Customer>';
			}
			$xml.='</GuestList> ';
		    $xml.='</Paxes>';
		}
		if($request->ServiceType=='ServiceTransfer'){
			$xml.='<PickupLocation xsi:type="ProductTransfer'.$request->picType.'">
			<Code>'.$request->pickLoc.'</Code>';
			if($request->picType=='Terminal'){$xml.='<DateTime date="'.$request->DateFrom.'" time="'.$request->DateFTime.'"/>';}
		$xml.='</PickupLocation>
		<DestinationLocation xsi:type="ProductTransfer'.$request->DesType.'">
			<Code>'.$request->destLoc.'</Code>';
			if($request->DesType=='Terminal'){$xml.='<DateTime date="'.$request->DateFrom.'" time="'.$request->DateFTime.'"/>';}
			$xml.='
		</DestinationLocation>';
		}


		$xml.='</Service></ServiceAddRQ>';
		// echo($xml);
        // die;
	// echo "<pre>".print_r($xml, true)."</pre>";
    $xml_response_string = post_xml('http://api.interface-xml.com/appservices/http/FrontendService',  $xml);
  // $xml_response_string = post_xml('http://testapi.interface-xml.com/appservices/http/FrontendService',  $xml);

    if(!$xml_response_string) die('ERROR');
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
