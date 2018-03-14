<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once 'JSON.php';
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
	//$guest=json_decode($_GET["guest_details"], true);
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	// $f_details=json_decode($_GET["details"], true);

	$f_details=$request->details;
	// print_r($f_details);
	// echo "<pre>".print_r($f_details, true)."</pre>";

$xml='<?xml version="1.0" encoding="UTF-8"?>
<mds>
  <auth>
    <login>NG.40038</login>
    <pass>GeX</pass>
    <languagecode>EN</languagecode>
    <source>B2B</source>
    <AgencyNumber></AgencyNumber>
    <affiliate></affiliate>
    <srcDomain>getcentre.com</srcDomain>
  </auth>
  <request>
    <type>book</type>
    <conditions>
      <language>EN</language>
      <ofr_id>'.$f_details->fOfferCode.'</ofr_id>
      <ofr_tourOp>'.$f_details->tourOp.'</ofr_tourOp>
      <par_adt>'.$f_details->Adult.'</par_adt>
	  <par_chd>'.$f_details->Child.'</par_chd>
	  <par_inf>'.$f_details->Infant.'</par_inf>
      <number_reference/>
      <birthdates/>
    </conditions>
    <forminfo>';
	$all_pass=$f_details->Adult+$f_details->Child+$f_details->Infant;
	for($a=0; $a<$all_pass; $a++){


		if($a<($f_details->Adult)){
			$guest=$f_details->guest_details->adult[$a];
			$ptype='adult';
			$bdate=date('d.m.Y',strtotime($guest->dbirth));
			//echo $bdate;
		}
		else{
			$b=$a-$f_details->Adult;
			if($b<$f_details->Child){
				$guest=$f_details->guest_details->child[$b];
				$ptype='child';
				$bdate=$guest->dbirth;
			}
			else{
				$c=$b-$f_details->Child;
				if($c<$f_details->Infant){
					$guest=$f_details->guest_details->infant[$c];
					$ptype='infant';
					$bdate=$guest->dbirth;
				}
			}
			//echo $bdate;
		}
	$xml.='
      <Person  type="'.$ptype.'">';
       	if($a<($f_details->Adult)){$xml.=' <gender required="1">H</gender>';}
		else if($b<($f_details->Child)){ $xml.=' <gender required="1">K</gender>';}
		else{$xml.=' <gender required="1">IF</gender>';}
        $xml.='  <lastname required="1">'.$guest->lname.'</lastname>
        <name required="1">'.$guest->fname.'</name>
        <birthdate>'.$bdate.'</birthdate>
        <additional>
          <contact>
            <phone required="1">'.$guest->phone.'</phone>
            <email required="1">'.$guest->email.'</email>
          </contact>';
		  if($ptype !='infant'){
          $xml.='<flight>
            <seat/>
            <meal/>
            <ssr/>
            <frequentflyerlist1/>
            <frequentflyer1/>
          </flight>';
		  }
		  $xml.='
          <document>
            <doctype/>
            <country>NGN</country>
            <number/>
            <nationality>NGN</nationality>
            <expiry/>
          </document>
          <address>
            <country>NGN</country>
            <street/>
            <streetNr/>
            <city/>
            <zipcode/>
          </address>
        </additional>
		</Person>';}
		$xml.='

      <Client>
        <gender required="1">H</gender>
        <lastname required="1">'.$guest->lname.'</lastname>
        <name required="1">'.$guest->fname.'</name>
        <street required="1">GETCentre Limited</street>
        <streetNr required="1">1</streetNr>
        <zipcode required="1">234</zipcode>
        <city required="1">Lagos</city>
        <state required="1">Lagos</state>
        <country required="1">NG</country>
        <email required="1">'.$guest->email.'</email>
        <phone required="1">'.$guest->phone.'</phone>
      </Client>
      <BankTransfer>
        <transfer required="1"/>
      </BankTransfer>
      <LastTicketDate>
        <date required="1"/>
        <value>'.$f_details->lastTicketDate.'</value>
      </LastTicketDate>
      <CreditCard>
        <type required="1">MasterCard</type>
        <holderName required="1">Maciej</holderName>
        <holderSurname required="1">Domachowski</holderSurname>
        <number required="1">5555555555554444</number>
        <code required="1">654</code>
        <exp_month required="1">06</exp_month>
        <exp_year required="1">2017</exp_year>
      </CreditCard>
      <Markdown>
        <amount required="1">
          <type>float</type>
          <value>0.00</value>
        </amount>
        <currency>
          <type>text</type>
          <value>NGN</value>
        </currency>
      </Markdown>
      <Commision>
        <amount required="1">
          <type>float</type>
          <value>0.00</value>
        </amount>
        <currency>
          <type>text</type>
          <value>PERCENT</value>
        </currency>
      </Commision>
      <Margin>
        <amount required="1">0.00</amount>
        <currency>NGN</currency>
        <marginType required="1">
          <type>text</type>
          <value>perPerson</value>
        </marginType>
        <type required="1">amount</type>
      </Margin>
      <Expected_price>
		  <amount required="0">'.$f_details->soldPrice.'</amount>
		  <currency>NGN</currency>
      </Expected_price>
    </forminfo>
  </request>
</mds>';

// echo ($xml);
$xml_response_string = post_xml('http://mdswsng.merlinx.eu/onlineflightexternalV1/',  $xml);
    if(!$xml_response_string)
        die('ERROR');

    $xml_response = simplexml_load_string($xml_response_string);
	//echo "<pre>".print_r($xml_response, true)."</pre>";
	$file = 'hotel_avail_log.txt';
	file_put_contents($file, $xml_response_string);
	$xml_response = simplexml_load_string($xml_response_string);
	$array1 = (array)$xml_response;
	if (($array1 != null)) {
		$arrayData = xmlToArray($xml_response);
		$jsonOutput=json_encode($arrayData);
		echo $jsonOutput;
	}


    ?>
