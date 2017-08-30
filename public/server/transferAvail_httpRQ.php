    <?php
	header("Content-Type: text/xml");
	//error_reporting(E_ALL);
	//ini_set('display_errors', 0);

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
	 $transferbreak=json_decode($_GET["transferBreakDown"]);

	 $xml='<TransferValuedAvailRQ xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/TransferValuedAvailRQ.xsd" sessionId="asdasdasd" version="2013/12">
	<Language>ENG</Language>
	<Credentials>
		<User>GETCENTRENG163996</User>
		<Password>GETCENTRENG163996</Password>
	</Credentials>
	<ExtraParamList/>
	<AvailData type="IN">
		<ServiceDate date="'.$_GET["htransferin"].'" time="'.$_GET["ttransferin"].'"/>
		<Occupancy>
			<AdultCount>'.$transferbreak[0][1].'</AdultCount>
		<ChildCount>'.count($transferbreak[0][2]).'</ChildCount>';
		if(count($transferbreak[0][2])>0){//if there are children
				 $xml.='<GuestList> ';
				 for($b=0; $b<count($transferbreak[0][2]); $b++){
					$xml.='<Customer type="CH"> <Age>'.$transferbreak[0][2][$b].'</Age> </Customer>';
				}
				$xml.='</GuestList> ';
			}

		$xml.='</Occupancy>
		<PickupLocation xsi:type="ProductTransfer'.$_GET["hDesType"].'">
			<Code>'.$_GET["hDesCode"].'</Code>';
			if($_GET["hDesType"]=='Terminal'){$xml.='<DateTime date="'.$_GET["htransferin"].'" time="'.$_GET["ttransferin"].'"/>';}
		$xml.='</PickupLocation>
		<DestinationLocation xsi:type="ProductTransfer'.$_GET["hReturnType"].'">
			<Code>'.$_GET["hReturnCode"].'</Code>';
			if($_GET["hReturnType"]=='Terminal'){$xml.='<DateTime date="'.$_GET["htransferin"].'" time="'.$_GET["ttransferout"].'"/>';}
			$xml.='
		</DestinationLocation>
	</AvailData>
	<ReturnContents>'.$_GET["hReturnOption"].'</ReturnContents>
	</TransferValuedAvailRQ>';
	//echo "<pre>".print_r($xml, true)."</pre>";
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
