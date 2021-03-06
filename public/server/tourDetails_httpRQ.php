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
  	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	 $xml='<TicketDetailRQ availToken="'.$request->availToken.'" echoToken="DummyEchoToken" version="2013/12" xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/TicketValuationRQ.xsd">
	<Language>ENG</Language>
	<Credentials>
		<User>GETCENTRENG163996</User>
		<Password>GETCENTRENG163996</Password>
	</Credentials>
	<TicketCode>'.$request->ticketCode.'</TicketCode>
	<Contract>
		<Name>'.$request->ticketContractName.'</Name>
		<IncomingOffice code="'.$request->ticketContractCode.'"/>
	</Contract>
</TicketDetailRQ>
';
//echo "<pre>".print_r($xml, true)."</pre>";
  // $xml_response_string = post_xml('http://testapi.interface-xml.com/appservices/http/FrontendService',  $xml);
  $xml_response_string = post_xml('http://api.interface-xml.com/appservices/http/FrontendService',  $xml);


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
