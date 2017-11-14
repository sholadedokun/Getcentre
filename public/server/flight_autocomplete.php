    <?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once 'local_utils.php';

	// get what user typed in autocomplete input
	$term = trim($_GET['term']);

	$a_json = array();
	$a_json_row = array();

	$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
	$json_invalid = json_encode($a_json_invalid);
	// replace multiple spaces with one
	$term=str_replace(",", " ", $term);
	$term = preg_replace('/\s+/', ' ', $term);
	// SECURITY HOLE ***************************************************************
	// allow space, any unicode letter and digit, underscore and dash
	if(preg_match("/[^\040\pL\pN_-]/u", $term)) {
	  print $json_invalid;
	  exit;
	}
	$parts = explode(' ', $term);
	$p = count($parts);

	$term = trim($_GET['term']);
    function post_xml($url, $xml){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST,   1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

	$a_json = array();
	$a_json_row = array();

    $xml = new XMLWriter();
    $xml->openMemory();
    $xml->startDocument('1.0', 'UTF-8');

    $xml->startElement('mds');

        $xml->startElement('auth');
            $xml->writeElement('login', '40002');
            $xml->writeElement('pass', 'travel');
			$xml->writeElement('srcDomain', 'my.test.sabreng.com');
        $xml->endElement();

        $xml->startElement('request');
            $xml->writeElement('type', 'airportSearchByName');
            $xml->startElement('conditions');
                $xml->writeElement('name', $term);
            $xml->endElement();
        $xml->endElement();
    $xml->endElement();
    $xml->endDocument();
    $xml_response_string = post_xml('http://mdswshtl.merlinx.pl/autosuggestV2/', $xml->outputMemory(true));

    if(!$xml_response_string)
        die('ERROR');
    $xml_response = simplexml_load_string($xml_response_string);
	$res=$xml_response->item;
	foreach($res as $airp){


        $airPrefix = $airp['IATAcode'];

        if($airPrefix=='' || $airPrefix ==Null){
            $airPrefix= $airp['IATAgroup'];
        }
        $a_json_row["id"] =$airPrefix;
		if( $airp['airportName']!=''){
            $a_json_row["label"]= '('.$airPrefix.')'.$airp['airportName'].', ';
            $a_json_row["wcode"]= $airp['airportName'].', ';

        }
        if( $airp['airportCity']!=''){
            	$a_json_row["label"] .=$airp['airportCity'].', ';
                $a_json_row["wcode"] .=$airp['airportCity'].', ';
        }
		$a_json_row["label"] .= $airp['countryName'];
        $a_json_row["wcode"] .= $airp['countryName'];
		$a_json_row["value"] =$a_json_row["label"];

        // always bring lagos up in the search...
        if($airPrefix=='LOS' && count($a_json)>0){
            array_unshift($a_json, $a_json_row);
        }
		else{
            array_push($a_json, $a_json_row);
        }

		$a_json_row["label"] ='';
	}

	// highlight search results
	$a_json = apply_highlight($a_json, $parts);


	$json = json_encode($a_json);
	echo $json;

    ?>
