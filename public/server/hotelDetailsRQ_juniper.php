<?php
require_once 'fun_connect.php';
require_once 'JSON.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
class OTA_HotelDescriptiveInfoService{
	function OTA_HotelDescriptiveInfoRQ()
	{

		$star="";
		$this->client = new	SoapClient('http://xml2.bookingengine.es/webservice/OTA_HotelDescriptiveInfo.asmx?wsdl', array(	'exceptions' => 0,	'trace' => 1,	'connection_timeout' => 1800));
		$this->client->OTA_HotelDescriptiveInfoService->xmlns =	'http://www.juniper.es/webservice/2007/';
		$OTA_HotelDescriptiveInfoService = $this->client->OTA_HotelDescriptiveInfoService;
		$OTA_HotelDescriptiveInfoService->OTA_HotelDescriptiveInfoRQ->PrimaryLangID = "en";
		$OTA_HotelDescriptiveInfoService->OTA_HotelDescriptiveInfoRQ->POS->Source->AgentDutyCode = "XML_techtuners";
		$OTA_HotelDescriptiveInfoService->OTA_HotelDescriptiveInfoRQ->POS->Source->RequestorID->Type = "1";
		$OTA_HotelDescriptiveInfoService->OTA_HotelDescriptiveInfoRQ->POS->Source->RequestorID->MessagePassword = "NdKT7Rs5t4";
		$OTA_HotelDescriptiveInfoService->OTA_HotelDescriptiveInfoRQ->HotelDescriptiveInfos->HotelDescriptiveInfo->HotelCode = $_GET['hotelCode'];
		$dataRQ = $OTA_HotelDescriptiveInfoService;
		try { $rp = $this->client->__soapCall('OTA_HotelDescriptiveInfoService', array('OTA_HotelDescriptiveInfoRQ' => $dataRQ));
			// echo "<pre>".print_r($rp, true)."</pre>";
			$hotel_details= $rp->OTA_HotelDescriptiveInfoRS->HotelDescriptiveContents->HotelDescriptiveContent->HotelInfo;
			$hotel_Info= $hotel_details->Descriptions->MultimediaDescriptions->MultimediaDescription;
			if(is_array($hotel_Info)){
				try{
					$hotel_images= $hotel_Info[0]->ImageItems->ImageItemsTypeImageItem;
					$hotel_desc_text= $hotel_Info[1]->TextItems->TextItemsTypeTextItem;
				}
				catch(SoapFault $exception){$hotel_images=NULL;}
			}
			else{
				try{
					$hotel_images= $hotel_Info->ImageItems->ImageItemsTypeImageItem;
					$hotel_desc_text= $hotel_Info->TextItems->TextItemsTypeTextItem;
				}
				catch(SoapFault $exception){$hotel_images=NULL;}
			}
			$hotel_rate= $hotel_details->CategoryCodes->HotelCategory->CodeDetail;

			if(is_array($hotel_desc_text)){
				$hotel_desc_text=$hotel_desc_text[1]->Description->_;
			}
			else{
				$hotel_desc_text=$hotel_desc_text->Description->_;
			}
			$hotel_desc_text=str_ireplace('</b>', ': ',html_entity_decode($hotel_desc_text));
			$hotel_desc_text=strip_tags($hotel_desc_text);

			$hotel_fac= $hotel_details->Services->Service;
			$hotel_cont= $rp->OTA_HotelDescriptiveInfoRS->HotelDescriptiveContents->HotelDescriptiveContent->ContactInfos->ContactInfo;
			$hotel_addr= $hotel_cont->Addresses->Address;
			$hotel_phone= $hotel_cont->Phones->Phone;
			$hotel_pos= $hotel_details->Position;
			$hotel_area_info= $rp->OTA_HotelDescriptiveInfoRS->HotelDescriptiveContents->HotelDescriptiveContent->AreaInfo->RefPoints->RefPoint;
			$hotel_name= $rp->OTA_HotelDescriptiveInfoRS->HotelDescriptiveContents->HotelName;
			$h_zone=$hotel_addr->AddressLine;

			$images_Array=array();
			foreach ($hotel_images as $key) {
				array_push($images_Array, $key->ImageFormat->FileName);
			}

			$a_json['details'][]=array(
				'hotel_desc' => $hotel_desc_text,
				'img_path' => $images_Array,
				'hotel_rate'=>$hotel_rate,
				// 'img_path' => 'http://www.hotelbeds.com/giata/'.$row[1],
				'hotel_fac'=>$hotel_fac,
				'hotel_cont'=>$hotel_cont,
				'address' => $hotel_addr->AddressLine,
				'city'=>$hotel_addr->CityName,
				'country'=>$hotel_addr->Country,
				'phone' => $hotel_phone,
				'hotel_pos' => $hotel_pos,
				'area_info' => $hotel_area_info,
				'name' => $hotel_name,
				'zone' => $h_zone
			);
			echo json_encode($a_json);
		}
		catch (SoapFault $exception){
			$rp = $exception;
		}
	}
	}
	//lets check if we have the hotel in our database, else we request the details from juniper
	$sql="Select HOTELCODE, LATITUDE, LONGITUDE from `HOTELS` where name='".$_GET['hname']."'";
	$res= mysql_query($sql);
	while($info= mysql_fetch_array($res)){

		//if we found a match on the database, let us that one
		echo('herhe');
		if((round($info[1])==round($_GET['lat']))&&(round($info[2])==round($_GET['long']))){
			$sql2 = "SELECT a.HotelFacilities, b.IMAGEPATH, c.ADDRESS, c.POSTALCODE, c.CITY, c.COUNTRYCODE, c.EMAIL, c.WEB FROM HOTEL_DESCRIPTIONS AS a, HOTEL_IMAGES As b, CONTACTS AS c WHERE a.HotelCode='".$info[0]."' AND b.HOTELCODE='".$info[0]."' AND c.HOTELCODE='".$info[0]."'";
		$rs = mysql_query($sql2);

		//triggering error cause we couldn't find the appropiate details
		if($rs === false) {
		  $user_error = 'Wrong SQL: ' . $sql . 'Error: ' . mysql_errno . ' ' . mysql_error;
		  trigger_error($user_error, E_USER_ERROR);
		}

		while($row = mysql_fetch_array($rs)) {
		  $a_json['details'][]=array('hotel_desc' => $row[0],
		  'img_path' => 'http://www.hotelbeds.com/giata/'.$row[1],
		  'address' => $row[2], 'postcode' => $row[3],
		  'city' => $row[4], 'counrty_code' => $row[5],
		  'email' => $row[6], 'web' => $row[7], 'hotelCode'=>$info[0] );

		}
		if (($a_json != null) && (sizeof($a_json) > 0)) {	$jsonOutput=json_encode($a_json);	}
		echo $jsonOutput;
		break;
		}
		//okay we didn't find the details on the database, so we are getting the details from juniper.
		else{
			echo ('not available');
			$obj = new OTA_HotelDescriptiveInfoService();
			$obj->OTA_HotelDescriptiveInfoRQ();
			break;
		}
	}
	$obj = new OTA_HotelDescriptiveInfoService();
	$obj->OTA_HotelDescriptiveInfoRQ();
?>
