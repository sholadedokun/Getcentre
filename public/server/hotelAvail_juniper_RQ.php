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
					$sql="SELECT zone_code from `juniper_zonelist`  WHERE zone_IATA='".$zone."' AND zone_type='CTY'";
					// echo $sql;
					$rs=mysql_query($sql);
					$row_zone = mysql_fetch_array($rs);
					// echo $row_zone[0];
					return	$row_zone[0];
				}
			}
			function getRooms($hotel, $roomRate){

			}
			function getHotel($hotel, $sequence, $roombreak){
				$a_json_row['S_num']= $sequence;
				$a_json_row['position']= array();
				$a_json_row['availToken']='not_available';
				$a_json_row['availRoom']=array();
				$a_json_row['currency']=$hotel->Total->CurrencyCode;
				if (is_array($hotel->RoomRates->RoomRate)){
					// print_r($hotel->RoomRates->RoomRate);
					$ratecount= count($hotel->RoomRates->RoomRate); //multiple rates found in this found
				}
				else{
					$ratecount=1; // just one rate found in this Hotel;
				}
				// print_r($roombreak);
				for($b=0; $b<$ratecount; $b++){
					if($ratecount==1){$rate=$hotel->RoomRates->RoomRate;}
					else{$rate=$hotel->RoomRates->RoomRate[$b];}

					if(is_array($rate->Rates->Rate)){
						$allRooms=$rate->Rates->Rate;
						$totalPrice=0;
						for($c=0; $c<count($allRooms); $c++){
							$index= count($a_json_row['availRoom']);
							$roomNum=explode(",",$allRooms[$c]->RateSource);
							for($a=0; $a<count($roomNum); $a++){
								$a_json_row['availRoom'][$index]->HotelOccupancy->Occupancy->AdultCount = $roombreak[($roomNum[$a]-1)][0]->value;
								$a_json_row['availRoom'][$index]->HotelOccupancy->Occupancy->ChildCount = $roombreak[($roomNum[$a]-1)][1]->value;;
								$a_json_row['availRoom'][$index]->HotelOccupancy->RoomCount=$allRooms[$c]->NumberOfUnits;
								$a_json_row['availRoom'][$index]->HotelRoom->RateCode=$rate->RatePlanCode;
								$a_json_row['availRoom'][$index]->HotelRoom->Board->{'$'}=$rate->RatePlanCategory;
								$a_json_row['availRoom'][$index]->HotelRoom->Price->Amount=$allRooms[$c]->Total->AmountAfterTax;
								$a_json_row['availRoom'][$index]->HotelRoom->RoomType->{'$'}=$allRooms[$c]->RateDescription->Text->_;
							}							
							// $totalPrice+=$allRooms[$c]->Total->AmountAfterTax;
						}
						// $a_json_row['availRoom'][$b]->totalPrice=$totalPrice;
					}
					else{
						$a_json_row['availRoom'][$b]->HotelOccupancy->Occupancy->AdultCount = $room_adult;
						$a_json_row['availRoom'][$b]->HotelOccupancy->Occupancy->ChildCount = $room_child;
						$a_json_row['availRoom'][$b]->HotelOccupancy->RoomCount=$rate->Rates->Rate->NumberOfUnits;
						$a_json_row['availRoom'][$b]->HotelRoom->RateCode=$rate->RatePlanCode;
						$a_json_row['availRoom'][$b]->HotelRoom->Board->{'$'}=$rate->RatePlanCategory;
						$a_json_row['availRoom'][$b]->HotelRoom->Price->Amount=$rate->Total->AmountAfterTax;
						$a_json_row['availRoom'][$b]->HotelRoom->RoomType->{'$'}=$rate->Rates->Rate->RateDescription->Text->_;
					}
					
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
			$OTA_HotelAvailService->OTA_HotelAvailRQ->POS->Source->AgentDutyCode = 'XML_GETCentre';
			$OTA_HotelAvailService->OTA_HotelAvailRQ->POS->Source->RequestorID->Type = "1";
			$OTA_HotelAvailService->OTA_HotelAvailRQ->POS->Source->RequestorID->MessagePassword = 'NdKT7Rs5t4';
			$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->StayDateRange->Start =substr($_GET["hcheckin"],0,4).'-'.substr($_GET["hcheckin"],4,2).'-'.substr($_GET["hcheckin"],-2);
			$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->StayDateRange->End = substr($_GET["hcheckout"],0,4).'-'.substr($_GET["hcheckout"],4,2).'-'.substr($_GET["hcheckout"],-2);
			
			$roombreak=json_decode($_GET["hRoomBreak"]);
			for($i=0; $i<count($roombreak); $i++){
				$room_adult = $roombreak[$i][0]->value;
				if($room_adult>0){	//if there are Adult occupant in the room array.
					$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->RoomStayCandidates->RoomStayCandidate[$i]->Quantity = '1';
					$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->RoomStayCandidates->RoomStayCandidate[$i]->GuestCounts->GuestCount[0]->Count = $room_adult;
					$room_child=$roombreak[$i][1]->value;
					for($c=1; $c<=$room_child; $c++){
						$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->RoomStayCandidates->RoomStayCandidate[$i]->GuestCounts->GuestCount[$c]->Age = $roombreak[$i][1]->ages[$c-1]->valueYear;
						$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->RoomStayCandidates->RoomStayCandidate[$i]->GuestCounts->GuestCount[$c]->Count = 1;
					}
				}
			}				
			
			if(strpos($_GET["hdescode"],'_')>0){
				$zcods=explode('_',$_GET["hdescode"]);
				// $zonecode='13826';
				$zonecode=getcityCode($zcods[0], $zcods[1]);
				$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->HotelSearchCriteria->Criterion->HotelRef->HotelCityCode = $zonecode;
			}
			else{
				// $zonecode='13826';
				$zonecode=getcityCode($_GET["hdescode"], null);
				$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->HotelSearchCriteria->Criterion->HotelRef->HotelCityCode =$zonecode;
			}
			//retrieve on 4 star hotels
			// $OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->HotelSearchCriteria->Criterion->HotelRef->SegmentCategoryCode ='4';
			$tpa_extensions = '<ns1:TPA_Extensions><ShowBasicInfo>1</ShowBasicInfo><ShowCatalogueData>1</ShowCatalogueData><IsGiataHotelCode>1</IsGiataHotelCode><Debug>1</Debug></ns1:TPA_Extensions>';
			$obj = new SoapVar($tpa_extensions, XSD_ANYXML) ;
			$OTA_HotelAvailService->OTA_HotelAvailRQ->AvailRequestSegments->AvailRequestSegment->HotelSearchCriteria->Criterion->TPA_Extensions = $obj;
			
			// print_r($OTA_HotelAvailService);
			// die;
			$dataRQ = $OTA_HotelAvailService;
			$file = 'juniper_hotelAvailRQ.txt';
			file_put_contents($file, serialize($dataRQ));
			try{ $rp = $this->client->__soapCall('OTA_HotelAvailService', array( 'OTA_HotelAvailRQ' => $dataRQ ));

				$array1 = (array) $rp;
				// print_r($array1['OTA_HotelAvailRS']->RoomStays->RoomStay);
				$file = 'juniper_hotelAvailRS.txt';
            	file_put_contents($file, serialize($rp));
				$a_json = array();
				$a_json_row = array();
				$a_json['total']=count($array1['OTA_HotelAvailRS']->RoomStays->RoomStay);
				$a_json['hotelList']=array();
				$sequence=$array1['OTA_HotelAvailRS']->SequenceNmbr;
				if($a_json['total']>0){
					$hotel=$array1['OTA_HotelAvailRS']->RoomStays->RoomStay;
					if($a_json['total']==1){
						//just one hotel found
						$a_json['currency']=$array1['OTA_HotelAvailRS']->RoomStays->RoomStay->Total->CurrencyCode;
						array_push($a_json['hotelList'],getHotel($hotel, $sequence, $roombreak));
					}
					else{
						//multiple hotels found
						$a_json['currency']=$array1['OTA_HotelAvailRS']->RoomStays->RoomStay[0]->Total->CurrencyCode;
						for ($i=0; $i<$a_json['total']; $i++){
							$hotel=$array1['OTA_HotelAvailRS']->RoomStays->RoomStay[$i];
							array_push($a_json['hotelList'],getHotel($hotel, $sequence, $roombreak));
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
