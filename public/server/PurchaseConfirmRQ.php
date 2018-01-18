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
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	$data=json_decode($request->details);
	$lead=$request->lead;

		if($data->product=='HotelBed'){
	$xml='
	<PurchaseConfirmRQ xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/PurchaseConfirmRQ.xsd" version="2013/12">
		<Language>ENG</Language>
		<Credentials>
			<User>GETCENTRENG163996</User>
			<Password>GETCENTRENG163996</Password>
		</Credentials>
		<ConfirmationData purchaseToken="'.$data->purchaseToken.'">
			<Holder type="AD">';
			//$lead=explode("|",$data[1][2]);
			$xml.='
				<Age>45</Age>
				<Name>'.$lead->fname.'</Name>
				<LastName>'.$lead->lname.'</LastName>
			</Holder>';
			$xml.='
			<AgencyReference>Test AgencyRef</AgencyReference>
			<ConfirmationServiceDataList>';
			//for($z=0; $z<count($data); $z++){
				if(($data->productType=='Tour')&&($data->product=='HotelBed')){$service='ServiceDataTicket';}
				elseif(($data->productType=='Transfer')&&($data->product=='HotelBed')){$service='ServiceDataTransfer';}
				elseif(($data->productType=='Hotel')&&($data->product=='HotelBed')){$service='ServiceDataHotel';}
			$xml.='
				<ServiceData SPUI="'.$data->Spui.'" xsi:type="Confirmation'.$service.'">
					<CustomerList>';
						$guests=$data->guestBreak;
						for($p=0; $p<count($guests); $p++){
							$guest_det=$guests[$p]->guest_details->guest;
							$cust_det=$guests[$p]->cust_det;
							for($k=0; $k<count($guest_det); $k++){
								$cfname=$guest_det[$k]->fname;
								$clname=$guest_det[$k]->lname;
								if($cfname==''){if($p==0){$cfname=$lead->fname;}else{$cfname='GuestFirstname';}}
								if($clname==''){if($p==0){$clname=$lead->lname;}else{$clname='GuestLastname';}}
								$xml.='<Customer type="'.$cust_det[$k]->cust_type.'">
								<CustomerId>'.$cust_det[$k]->cust_id.'</CustomerId>
								<Age>'.$cust_det[$k]->cust_age.'</Age>
								<Name>'.$cfname.'</Name>
								<LastName>'.$clname.'</LastName>
								</Customer>';
							}
						}

					$xml.='</CustomerList>';

					if($data->productType=='Hotel'){
						$guests=$data->guestBreak;
								$xml.='<CommentList>';

						for($a=0; $a<count($guests[$a]); $a++){
							if($guests[$a]->guest_details->comment !=''){
									$xml.='<Comment type="INCOMING">'.$guests[$a]->guest_details->comment.'</Comment>';
							}
							else{
								$xml.='<Comment type="INCOMING">No Comment</Comment>';
							}
						}
						$xml.='</CommentList></ServiceData>';
					}
					if($data->productType=='Transfer'){
						//echo "<pre>".print_r($data[3], true)."</pre>";
						$xml.='<ArrivalTravelInfo>
						<ArrivalInfo xsi:type="'.$data->pickup->{'@xsi:type'}.'">';
							if(isset($data->pickup->Code)){
								$xml.='<Code>'.$data->pickup->Code.'</Code>';
							}
							if(isset($data->pickup->DateTime)){
								$xml.='<DateTime date="'.$data->pickup->DateTime->{'@date'}.'" time="'.$data->pickup->DateTime->{'@time'}.'"/>';
							}
						$xml.='</ArrivalInfo>';
						$xml.='<DepartInfo xsi:type="'.$data->dropOff->{'@xsi:type'}.'">';
							if(isset($data->dropOff->Code)){
								$xml.='<Code>'.$data->dropOff->Code.'</Code>';
							}
							if(isset($data->dropOff->DateTime)){
								$xml.='<DateTime date="'.$data->dropOff->DateTime->{'@date'}.'" time="'.$data->dropOff->DateTime->{'@time'}.'"/>';
							}
						$xml.='</DepartInfo></ArrivalTravelInfo>';
					}
					if($data->productType!='Hotel'){$xml.='</ServiceData>';}
		//	}
	$xml.='</ConfirmationServiceDataList></ConfirmationData></PurchaseConfirmRQ>';
	// echo "<pre>".print_r($xml, true)."</pre>";

    $xml_response_string = post_xml('http://api.interface-xml.com/appservices/http/FrontendService',  $xml);
	// $xml_response_string = post_xml('http://testapi.interface-xml.com/appservices/http/FrontendService',  $xml);
	//}

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
		}
    ?>
