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
		curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/xml'));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
  	 $t=time();
	 $occupancy=json_decode($_GET["occupancy"]);
	 $xml='<TicketAvailRQ echoToken="DummyEchoToken" sessionId="'.$t.'" xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/TicketAvailRQ.xsd" version="2013/12">
	<Language>ENG</Language>
    <Credentials>
		<User>GETCENTRENG163996</User>
		<Password>GETCENTRENG163996</Password>
	</Credentials>
	<PaginationData pageNumber="1" itemsPerPage="30"/>
	<ServiceOccupancy>
		<AdultCount>'.$occupancy[0][0]->value.'</AdultCount>
		<ChildCount>'.$occupancy[0][1]->value.'</ChildCount>';
		if($occupancy[0][1]->value>0){//if there are children
				$xml.='<GuestList> ';
				for($b=0; $b<$occupancy[0][1]->value; $b++){
					$xml.='<Customer type="CH"> <Age>'.$occupancy[0][1]->ages[$b].'</Age> </Customer>';
				}
			$xml.='</GuestList> ';
		}
	$xml.='</ServiceOccupancy>
	<Destination code="'.$_GET["hDesCode"].'" type="SIMPLE"/>
	<DateFrom date="'.$_GET["hTourin"].'"/>
	<DateTo date="'.$_GET["hTourout"].'"/>
</TicketAvailRQ>';
//  echo($xml);
  $xml_response_string = post_xml('http://api.interface-xml.com/appservices/http/FrontendService',  $xml);
    if(!$xml_response_string)
        die('ERROR');
    $xml_response = simplexml_load_string($xml_response_string);
	$array1 = (array) $xml_response;
	if (($array1 != null) && (sizeof($array1) > 0)) {
		$arrayData = xmlToArray($xml_response);
		$jsonOutput=json_encode($arrayData);
	}
	echo $jsonOutput;
?>