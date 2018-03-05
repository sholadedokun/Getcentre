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
	$occupancy=json_decode($_GET["occupancy"]);
	 $xml='<ServiceAddRQ echoToken="DummyEchoToken" version="2013/12" xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/ServiceAddRQ.xsd">
	<Language>ENG</Language>
	<Credentials>
		<User>GETCENTRENG163996</User>
		<Password>GETCENTRENG163996</Password>
	</Credentials>
	<Service availToken="'.$_GET["Availtoken"].'" xsi:type="ServiceTicket">
		<ContractList>
			<Contract>
				<Name>'.$_GET["contractName"].'</Name>
				<IncomingOffice code="'.$_GET["contractCode"].'"/>
			</Contract>
		</ContractList>
		<DateFrom date="'.$_GET["date"].'"/>
		<DateTo date="'.$_GET["date"].'"/>
		<Currency code="'.$_GET["currency"].'"/>
		<TicketInfo xsi:type="ProductTicket">
			<Code>'.$_GET["ticketcode"].'</Code>
			<Destination code="'.$_GET["destcode"].'" type="SIMPLE"/>
		</TicketInfo>
		<AvailableModality code="'.$_GET["availcode"].'">
			<Name>'.$_GET["availName"].'</Name>
			<Contract>
				<Name>'.$_GET["availContactName"].'</Name>
				<IncomingOffice code="'.$_GET["availContactcode"].'"/>
			</Contract>
		</AvailableModality>
		<Paxes>';			
		$xml.='<AdultCount>'.$occupancy[0][0]->value.'</AdultCount>
		<ChildCount>'.$occupancy[0][1]->value.'</ChildCount>';
		if($occupancy[0][1]->value>0){//if there are children
				 $xml.='<GuestList> ';
				 for($b=0; $b<$occupancy[0][1]->value; $b++){
					$xml.='<Customer type="CH"> <Age>'.$occupancy[0][1]->ages[$b].'</Age> </Customer>';
				}
				$xml.='</GuestList> ';
			};
		$xml='
		</Paxes>
	</Service>
</ServiceAddRQ>
';
echo $xml;
die;
  $xml_response_string = post_xml('http://testapi.interface-xml.com/appservices/http/FrontendService',  $xml);

    if(!$xml_response_string)
        die('ERROR');

    $xml_response = simplexml_load_string($xml_response_string);
	//echo "<pre>".print_r($xml_response, true)."</pre>";
	$array1 = (array) $xml_response;
	if (($array1 != null) && (sizeof($array1) > 0)) {
		$arrayData = xmlToArray($xml_response);
		$jsonOutput=json_encode($arrayData);
	}
	echo $jsonOutput;
    ?>
