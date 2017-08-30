<?php
require_once 'JSON.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);

class OTA_HotelBookingRuleService{
	function OTA_HotelBookingRuleRQ()
	{
		$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

		//echo ("These are the values supplied: ".$_POST["s_num"]." Hotel COde: ".$_POST["hotel_code"]);
		$this->client = new	SoapClient('http://xml2.bookingengine.es/webservice/OTA_HotelBookingRule.asmx?wsdl',
										array(	'exceptions' => 0,	'trace' => 1,	'connection_timeout' => 1800));
		$this->client->OTA_HotelBookingRuleService->xmlns =	'http://www.juniper.es/webservice/2007/';
		$OTA_HotelBookingRuleService = $this->client->OTA_HotelBookingRuleService;
		$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->PrimaryLangID = "en";
		$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->SequenceNmbr = $request->sequence_num;
		$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->POS->Source->AgentDutyCode = "XML_techtuners";
		$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->POS->Source->RequestorID->Type = "1";
		$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->POS->Source->RequestorID->MessagePassword = "NdKT7Rs5t4";
		$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->RuleMessage->HotelCode = $request->hotel_code;
		for ($v=0; $v<count($request->selected_room); $v++){
			$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->RuleMessage->StatusApplication->RatePlanCode = $request->selected_room[$v]->HotelRoom->RateCode;
		}
		$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->RuleMessage->StatusApplication->End = $request->check_out;
		$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->RuleMessage->StatusApplication->Start = $request->check_in;
		$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->RuleMessage->TPA_Extensions->ShowSupplements ="1";
		/*$tpa_extensions = '<ns1:TPA_Extensions><ShowSupplements>1</ShowSupplements><IsGiataHotelCode>1</IsGiataHotelCode></ns1:TPA_Extensions>';
		$obj = new SoapVar($tpa_extensions, XSD_ANYXML);
		$OTA_HotelBookingRuleService->OTA_HotelBookingRuleRQ->RuleMessage->TPA_Extensions = $obj;*/
		$dataRQ = $OTA_HotelBookingRuleService;
		try{
			$rp = $this->client->__soapCall('OTA_HotelBookingRuleService', array('OTA_HotelBookingRuleRQ' => $dataRQ));
			//echo "<pre>".print_r($rp, true)."</pre>";
			$array1 = (array) $rp;
			$a_json = array();
			$a_json['booking_rule']=$array1['OTA_HotelBookingRuleRS']->RuleMessage->BookingRules->BookingRule->CancelPenalties->CancelPenalty->PenaltyDescription->Text->_;
			$a_json['absoluteCutoff']=$array1['OTA_HotelBookingRuleRS']->RuleMessage->BookingRules->BookingRule->AbsoluteCutoff;
			$a_json['cancelDescription']= $array1['OTA_HotelBookingRuleRS']->RuleMessage->BookingRules->BookingRule->Description->Text->_;
			if (($a_json != null) && (sizeof($a_json) > 0)) {
				//$json = new Services_JSON();
				$jsonOutput = json_encode($a_json);
				echo $jsonOutput;
				//$jsonOutput = $json->encode($array1);
			}
			/*$hotel_details= $rp->OTA_HotelDescriptiveInfoRS->HotelDescriptiveContents->HotelDescriptiveContent->HotelInfo;
			$hotel_rate= $hotel_details->CategoryCodes->HotelCategory->CodeDetail;
			$hotel_desc= $hotel_details->Descriptions->MultimediaDescriptions->MultimediaDescription;
			$hotel_images= $hotel_desc[0]->ImageItems->ImageItemsTypeImageItem;
			$hotel_desc_text= $hotel_desc[1]->TextItems->TextItemsTypeTextItem[1]->Description->_;
			$hotel_fac= $hotel_details->Services->Service;
			$hotel_cont= $rp->OTA_HotelDescriptiveInfoRS->HotelDescriptiveContents->HotelDescriptiveContent->ContactInfos->ContactInfo;
			$hotel_addr= $hotel_cont->Addresses->Address;
			$hotel_phone= $hotel_cont->Phones->Phone;
			$hotel_pos= $hotel_details->Position;
			$hotel_area_info= $rp->OTA_HotelDescriptiveInfoRS->HotelDescriptiveContents->HotelDescriptiveContent->AreaInfo->RefPoints->RefPoint;
			$hotel_name= $rp->OTA_HotelDescriptiveInfoRS->HotelDescriptiveContents->HotelName;*/
		}
	catch (SoapFault $exception){	$rp = $exception;}
}
	}
	$obj = new OTA_HotelBookingRuleService();
	$obj->OTA_HotelBookingRuleRQ();


?>
