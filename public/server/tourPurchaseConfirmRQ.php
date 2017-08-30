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
	$boarding=$_GET["boardName"]; $board_code="";
	$roomtype=$_GET["roomType"]; $room_code=""; $character_c="";


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
				<Age>45</Age>
				<Name>Added Customer1</Name>
				<LastName>Added Customer1</LastName>
			</Holder>
			<AgencyReference>Test AgencyRef</AgencyReference>
			<ConfirmationServiceDataList>
				<ServiceData SPUI="'.$_GET["SerSpui"].'" xsi:type="ConfirmationServiceDataHotel">
					<CustomerList>
						<Customer type="AD">
							<CustomerId>1</CustomerId>
							<Age>45</Age>
							<Name>Added Customer1</Name>
							<LastName>Added Customer1</LastName>
						</Customer>
						<Customer type="CH">
							<CustomerId>2</CustomerId>
							<Age>2</Age>
							<Name>Added Customer1</Name>
							<LastName>Added Customer1</LastName>
						</Customer>
						<Customer type="CH">
							<CustomerId>3</CustomerId>
							<Age>3</Age>
							<Name>ChildCustomer2</Name>
							<LastName>Child Customer2</LastName>
						</Customer>
					</CustomerList>

				</ServiceData>
			</ConfirmationServiceDataList>
		</ConfirmationData>
	</PurchaseConfirmRQ>';

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
