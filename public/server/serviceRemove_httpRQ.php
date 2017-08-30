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
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(  'Content-Type: application/xml'  ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
	//echo "<pre>".print_r($guests, true)."</pre>";
	//echo "<pre>".print_r($rooms, true)."</pre>";
	$xml='<ServiceRemoveRQ SPUI="'.$_GET["spui"].'" purchaseToken="'.$_GET["pToken"].'" xmlns="http://www.hotelbeds.com/schemas/2005/06/messages" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.hotelbeds.com/schemas/2005/06/messages/xsd/ServiceRemoveRQ.xsd" version="2013/12">
	<Language>ENG</Language>
	<Credentials>
		<User>GETCENTRENG163996</User>
		<Password>GETCENTRENG163996</Password>
	</Credentials>
</ServiceRemoveRQ>';

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
