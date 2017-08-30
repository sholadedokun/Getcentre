<?php
	require_once 'JSON_.php';
	require_once 'fun_connect.php';
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	class OTA_HotelAvailService{

		function OTA_HotelAvailRQ() {
			$room_adult=0;
			$room_child=0;
			function getcityCode($zone, $subzone){
				$host = "localhost";
				$username = "getcentr_grand";
				$password = "Autonimrod1@";
				if($subzone != null){
					$database = "getcentr_newhotelbeds";
					@ mysql_pconnect($host,$username,$password);
					$connection=mysql_select_db($database);
				}
				else{
					$database = "getcentr_getcentre";
					@ mysql_pconnect($host,$username,$password);
					$connection=mysql_select_db($database);
					$sql="SELECT zone_code from `juniper_zonelist`  WHERE zone_IATA='".$zone."' AND zone_type=''";
					//echo $sql;
					$rs=mysql_query($sql);
					$row_zone = mysql_fetch_array($rs);
					return	$row_zone[0];
				}
			}
			function getHotel($hotel, $sequence, $room_adult, $room_child){
				$a_json_row['S_num']= $sequence;
				$a_json_row['position']= array();
				$a_json_row['availToken']='not_available';
				$a_json_row['availRoom']=array();
				$a_json_row['currency']=$hotel->Total->CurrencyCode;
				if (is_array($hotel->RoomRates->RoomRate)){
					$ratecount= count($hotel->RoomRates->RoomRate);
				}
				else{
					$ratecount=1;
				}
				for($b=0; $b<$ratecount; $b++){
					if($ratecount==1){$rate=$hotel->RoomRates->RoomRate;}
					else{$rate=$hotel->RoomRates->RoomRate[$b];}
					$a_json_row['availRoom'][$b]->HotelOccupancy->Occupancy->AdultCount = $room_adult;
					$a_json_row['availRoom'][$b]->HotelOccupancy->Occupancy->ChildCount = $room_child;
					$a_json_row['availRoom'][$b]->HotelOccupancy->RoomCount=$rate->Rates->Rate->NumberOfUnits;

					//$a_json['tag']='Juniper';
					$a_json_row['availRoom'][$b]->HotelRoom->RateCode=$rate->RatePlanCode;
					$a_json_row['availRoom'][$b]->HotelRoom->Board->{'$'}=$rate->RatePlanCategory;
					$a_json_row['availRoom'][$b]->HotelRoom->Price->Amount=$rate->Total->AmountAfterTax;
					$a_json_row['availRoom'][$b]->HotelRoom->RoomType->{'$'}=$rate->Rates->Rate->RateDescription->Text->_;
					//array_push($a_json_row['availRoom'],$hotel->RoomRates[$b]);
				}
				$a_json_row['dateFrom']=$hotel->TimeSpan->Start;
				$a_json_row['dateTo']=$hotel->TimeSpan->End;;
				$a_json_row['hotelName']=$hotel->BasicPropertyInfo->HotelName;
				$a_json_row['hotelCode']=$hotel->BasicPropertyInfo->HotelCode;
				$a_json_row['tag']='Juniper';
				$any=$hotel->TPA_Extensions->any;
				$descrip=simplexml_load_string($any, 'SimpleXMLElement', LIBXML_NOCDATA);
				//print_r($descrip);
				$a_json_row['hotelCat']= $descrip->Category;
				$a_json_row['hotelImages']= $descrip->Thumb;
				$a_json_row['description']= $descrip->Description;
				$a_json_row['destination']= $descrip->Address;
				$a_json_row['position'][0]= $descrip->Latitude;
				$a_json_row['position'][1]= $descrip->Longitude;
				return $a_json_row;
			}
			function getCDATA($tag, $content){
				$matchpat='/<'.$tag.'><!\-\-\[CDATA\[(.*)\]\]\-\-\>\<\/'.$tag.'>/';

				try{preg_match($matchpat, $content, $matcher); return $matcher[1];} catch(Exception $e){ return;}
			}
			 $this->client = new SoapClient('http://xml2.bookingengine.es/webservice/OTA_HotelAvail.asmx?wsdl',
			 				array( 'exceptions' => 0, 'trace' => 1, 'connection_timeout' => 1800, 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,'encoding' => 'ISO-8859-1' ));
			$this->client->OTA_HotelAvailService->xmlns = 'http://www.juniper.es/webservice/2007/';
			$this->client->OTA_HotelAvailService->echoToken = 'getcentretester';
			$this->client->OTA_HotelAvailService->sessionId = 'getcentretester';
			$OTA_HotelAvailService = $this->client->OTA_HotelAvailService;
			$OTA_HotelAvailService->OTA_HotelAvailRQ->PrimaryLangID = 'en';
			$OTA_HotelAvailService->OTA_HotelAvailRQ->POS->Source->AgentDutyCode = 'XML_techtuners';
			$OTA_HotelAvailService->OTA_HotelAvailRQ->POS->Source->RequestorID->Type = "1";
			$OTA_HotelAvailService->OTA_HotelAvailRQ->POS->Source->RequestorID->MessagePassword = 'NdKT7Rs5t4';
			$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->StayDateRange->Start =substr($_GET["hcheckin"],0,4).'-'.substr($_GET["hcheckin"],4,2).'-'.substr($_GET["hcheckin"],-2);
			$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->StayDateRange->End = substr($_GET["hcheckout"],0,4).'-'.substr($_GET["hcheckout"],4,2).'-'.substr($_GET["hcheckout"],-2);
			for($x=0; $x<count($_GET["hRoomBreak"]); $x++){
				$roombreak=json_decode($_GET["hRoomBreak"]);
				$room_adult = $roombreak[$x][0]->value;
				if($room_adult>0){	//if there are Adult occupant in the room array.
					$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->RoomStayCandidates->RoomStayCandidate[$x]->Quantity = '1';
					$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->RoomStayCandidates->RoomStayCandidate[$x]->GuestCounts->GuestCount[0]->Count = $room_adult;
					$room_child=$roombreak[$x][1]->value;
					if($room_child!=0){
						$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->RoomStayCandidates->RoomStayCandidate[$x]->GuestCounts->GuestCount[1]->Age = '11';
						$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->RoomStayCandidates->RoomStayCandidate[$x]->GuestCounts->GuestCount[1]->Count = $room_child;

					}
				}
			}
			if(strpos($_GET["hdescode"],'_')>0){
				$zcods=explode('_',$_GET["hdescode"]);
				$zonecode='13826';
				// $zonecode=getcityCode($zcods[0], $zcods[1]);
				$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->HotelSearchCriteria->Criterion->HotelRef->HotelCityCode = $zonecode;
			}
			else{
				$zonecode='13826';
				// $zonecode=getcityCode($_GET["hdescode"], null);
				$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->HotelSearchCriteria->Criterion->HotelRef->HotelCityCode =$zonecode;
			}
			//retrieve on 4 star hotels
			// $OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->HotelSearchCriteria->Criterion->HotelRef->SegmentCategoryCode ='4';
			$tpa_extensions = '<ns1:TPA_Extensions><ShowBasicInfo>1</ShowBasicInfo><ShowCatalogueData>1</ShowCatalogueData><IsGiataHotelCode>1</IsGiataHotelCode><Debug>1</Debug></ns1:TPA_Extensions>';
			$obj = new SoapVar($tpa_extensions, XSD_ANYXML) ;
			$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->HotelSearchCriteria->Criterion->TPA_Extensions = $obj;
			$dataRQ = $OTA_HotelAvailService;
			// echo "<pre>".print_r($dataRQ, true)."</pre>";
			try{ $rp = $this->client->__soapCall('OTA_HotelAvailService', array( 'OTA_HotelAvailRQ' => $dataRQ ));

				$array1 = (array) $rp;
				// echo "<pre>".print_r($rp)."</pre>";
				$a_json = array();
				$a_json_row = array();
				$a_json['total']=count($array1['OTA_HotelAvailRS']->RoomStays->RoomStay);
				$a_json['hotelList']=array();
				$sequence=$array1['OTA_HotelAvailRS']->SequenceNmbr;
				if($a_json['total']>0){
					$hotel=$array1['OTA_HotelAvailRS']->RoomStays->RoomStay;
					if($a_json['total']==1){
						$a_json['currency']=$array1['OTA_HotelAvailRS']->RoomStays->RoomStay->Total->CurrencyCode;
						array_push($a_json['hotelList'],getHotel($hotel, $sequence, $room_adult, $room_child));
					}
					else{
						$a_json['currency']=$array1['OTA_HotelAvailRS']->RoomStays->RoomStay[0]->Total->CurrencyCode;
						for ($i=0; $i<$a_json['total']; $i++){
							$hotel=$array1['OTA_HotelAvailRS']->RoomStays->RoomStay[$i];
							array_push($a_json['hotelList'],getHotel($hotel, $sequence, $room_adult, $room_child));
						}
					}

				}
				if (($a_json != null) && (sizeof($a_json) > 0)) {
				//$json = new Services_JSON();
				$jsonOutput = json_encode($a_json);}
				echo $jsonOutput;
			}
			catch (SoapFault $exception){ echo $exception; }


		}

	}
	$obj = new OTA_HotelAvailService();
	$obj->OTA_HotelAvailRQ();
?>
