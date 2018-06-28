<?php
require_once 'JSON.php';
require_once 'fun_connect.php';
//error_reporting(E_ALL);
ini_set('display_errors', 0);

class OTA_HotelResV2Service{
	function OTA_HotelResRQ()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$client = new	SoapClient('http://xml2.bookingengine.es/webservice/OTA_HotelRes.asmx?wsdl',
										array(	'exceptions' => 0,	'trace' => true,	'connection_timeout' => 1800));
		$client->OTA_HotelResV2Service->xmlns =	'http://www.juniper.es/webservice/2007/';
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->PrimaryLangID = "en";
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->SequenceNmbr = $request->details->Snum;
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->POS->Source->AgentDutyCode = "XML_GETCentre";
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->POS->Source->RequestorID->Type = "1";
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->POS->Source->RequestorID->MessagePassword = "NdKT7Rs5t4";
		$guest=$request->details->guestBreak;
		$rooms=$request->details->hRoom;
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->RoomStays->RoomStay->RatePlans->RatePlan->RatePlanCode= $request->details->guestBreak[0]->ratePlan;
		for($y=0; $y<$rooms; $y++){			
			$tpa_extensions = '<ns1:TPA_Extensions><Guests>';
			$allguest=$guest[$y]->guest_details->guest;	
			$age=$request->details->hroomdist[$y];		
			for($h=0; $h<count($allguest); $h++){
				//$name = explode(" ", $guest[$y][0][$h]);
				if($allguest[$h]->title!='Child'){
					$tpa_extensions=$tpa_extensions."<Guest Name='".$allguest[$h]->fname."' Surname='".$allguest[$h]->lname."' Age='40'/>";
				}
				else{
					$childAge=$age[1]->ages[$h-$age[0]->value]->valueYear;
					$tpa_extensions=$tpa_extensions."<Guest Name='".$allguest[$h]->fname."' Surname='".$allguest[$h]->lname."' Age='".$childAge."'/>";
				}
			}
			// print_r($allguest);
			$tpa_extensions=$tpa_extensions."</Guests></ns1:TPA_Extensions>";

			//echo $tpa_extensions;
			$obj = new SoapVar($tpa_extensions, XSD_ANYXML);
			$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->RoomStays->RoomStay->RoomTypes->RoomType[$y]->TPA_Extensions = $obj;
		}

		/*for($y=0; $y< count($guest); $y++){
			$name = explode(" ", $guest[$y]);
			$tpa_extensions = '<ns1:TPA_Extensions><Guests>';
			$tpa_extensions=$tpa_extensions."<Guest Name='$name[0]' Surname='$name[1]'/>";
			$tpa_extensions=$tpa_extensions."</Guests></ns1:TPA_Extensions>";
			//echo $tpa_extensions;
			$obj = new SoapVar($tpa_extensions, XSD_ANYXML);
			$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->RoomStays->RoomStay->RoomTypes->RoomType->TPA_Extensions = $obj;
		}*/
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->RoomStays->RoomStay->TimeSpan->Start = $request->details->hcheckin;
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->RoomStays->RoomStay->TimeSpan->End = $request->details->hcheckout;
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->RoomStays->RoomStay->BasicPropertyInfo->HotelCode = $request->details->hcode;
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->RoomStays->RoomStay->Total->CurrencyCode = $request->details->currency;
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->RoomStays->RoomStay->Total->AmountAfterTax = floor($request->details->Price);
		$tpa_extensions1="<ns1:TPA_Extensions><ExpectedPriceRange min='0' max='".floor((float)$request->details->Price)."' /></ns1:TPA_Extensions>";
		$obj1 = new SoapVar($tpa_extensions1, XSD_ANYXML);
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->RoomStays->RoomStay->TPA_Extensions=$obj1;
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->RoomStays->RoomStay->Comments->Comment=$request->details->guestBreak[0]->guest_details->comment;
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->ProfileType='1';
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->PersonName->GivenName=$request->lead->fname;
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->PersonName->Surname=$request->lead->lname;
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->Telephone->PhoneNumber='08056666969';
		/*$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->Document->DocID='';*/
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->Email='sholadedokun@yahoo.com';
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->Address->AddressLine='Lagos Nigeria';
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->PostalCode='234';
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->CityName='Lagos';
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->StateProv->StateCode='Lagos';
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->CountryName->Code="NG";
		$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->ResGuests->ResGuest->Profiles->ProfileInfo->Profile->Customer->CountryName='Nigeria';
		$tpa_extensions2='<ns1:TPA_Extensions><MsgUser>1</MsgUser><VoucherUser>1</VoucherUser><Agent>Online_Web_App</Agent><AcceptOnly>OK</AcceptOnly>
		<Supplements>';
			//for($x=0; $x<3; $x++){	$tpa_extensions2=$tpa_extensions2."<Supplement id='TourC' type='M' option='TourC#2' />";}
			$tpa_extensions2=$tpa_extensions2."</Supplements></ns1:TPA_Extensions>";
			$obj2 = new SoapVar($tpa_extensions2, XSD_ANYXML);
			$client->OTA_HotelResV2Service->OTA_HotelResRQ->HotelReservations->HotelReservation->TPA_Extensions = $obj2;
			
		$dataRQ = $client->OTA_HotelResV2Service;
		// $sample=array('OTA_HotelResRQ' => $dataRQ);
		
		
		
		try{
			$rp = $client->__soapCall('OTA_HotelResV2Service', array('OTA_HotelResRQ' => $dataRQ));
			// echo $client->__getLastRequest();

				$fileRQ = 'juniper_hotelBookRQ.txt';
				file_put_contents($fileRQ,  serialize($client->__getLastRequest()));
				$fileRS = 'juniper_hotelBookRS.txt';
				file_put_contents($fileRS, serialize($client->__getLastResponse()));
			$hotel_succ= $rp->OTA_HotelResRS->Success;
			if(isset($hotel_succ)){
				$array1 = (array) $rp;
				$a_json = array();
				$a_json['UniqueId']=$array1['OTA_HotelResRS']->HotelReservations->HotelReservation->UniqueID->ID;
				$a_json['IntCode']=$array1['OTA_HotelResRS']->HotelReservations->IntCode;
				$a_json['BookingCode']=$array1['OTA_HotelResRS']->HotelReservations->HotelReservation->ResGlobalInfo->HotelReservationIDs->HotelReservationID;
				$a_json['TotalExpected']=$array1['OTA_HotelResRS']->HotelReservations->HotelReservation->ResGlobalInfo->Total;
				if (($a_json != null) && (sizeof($a_json) > 0)) {
					//$json = new Services_JSON();
					$jsonOutput = json_encode($a_json);
					echo $jsonOutput;
				}
				//echo "<pre>".print_r($rp, true)."</pre>";

			}
			else{echo('Error Occured: '. $rp->OTA_HotelResRS->Errors->ErrorType->ShortText);}
		}
	catch (SoapFault $exception){	$rp = $exception;}
}
	}
	$obj = new OTA_HotelResV2Service();
	$obj->OTA_HotelResRQ();
?>
