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
  
	 $xml='<PurchaseConfirmRQ echoToken="DummyEchoToken" version="2013/12" xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/PurchaseConfirmRQ.xsd">
			<Language>ENG</Language>
			<Credentials>
				<User>XXX</User>
				<Password>XXX</Password>
			</Credentials>
			<ConfirmationData purchaseToken="O4238847990">
				<Holder type="AD">
					<CustomerId>Hldr</CustomerId>
					<Name>Test</Name>
					<LastName>Test</LastName>
				</Holder>
				<AgencyReference>Test AgencyRef</AgencyReference>
				<ConfirmationServiceDataList>
					<ServiceData SPUI="102#O#1" xsi:type="ConfirmationServiceDataTicket">
						<CustomerList>
							<Customer type="AD">
								<CustomerId>1</CustomerId>
								<Name>Adult Name1</Name>
								<LastName>Adult LastName1</LastName>
							</Customer>
							<Customer type="AD">
								<CustomerId>2</CustomerId>
								<Name>Adult Name2</Name>
								<LastName>Adult LastName2</LastName>
							</Customer>
						</CustomerList>
						<ServiceDetailList>
							<ServiceDetail code="PHONENUMBER">
								<Name>Please indicate the mobile phone number of the client	(including international code) in order to contact them in case of emergency.
								</Name>
								<Description>+11234567890</Description>
							</ServiceDetail>
							<ServiceDetail code="HOTEL">
								<Name>Please tell us the name of the hotel where you are staying.</Name>
								<Description>Hotel Hilton</Description>
							</ServiceDetail>
						</ServiceDetailList>
					</ServiceData>
				</ConfirmationServiceDataList>
			</ConfirmationData>
			</PurchaseConfirmRQ>
';
  $xml_response_string = post_xml('http://testapi.interface-xml.com/appservices/http/FrontendService',  $xml);

    if(!$xml_response_string) 
        die('ERROR');
     
    $xml_response = simplexml_load_string($xml_response_string);
	//echo "<pre>".print_r($xml_response, true)."</pre>";
	$array1 = (array) $xml_response;
	if (($array1 != null) && (sizeof($array1) > 0)) { 
		$json = new Services_JSON();	
		$jsonOutput = $json->encode($array1);
	}
	echo $jsonOutput;
    ?>

