
<?php
	require_once 'JSON.php';
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	$phpver = phpversion();
	$phpver = explode(".", $phpver);
	$phpver = "$phpver[0]$phpver[1]";
	if ($phpver != 41) {
		$PHP_SELF = $_SERVER['PHP_SELF'];
	}
	if (!ini_get("register_globals")){
		extract($_REQUEST, EXTR_PREFIX_ALL|EXTR_REFS, 'REQ');
	}
		class HotelValuedAvailService{
			function HotelValuedAvailRQ() {
			$this->client = new SoapClient('http://testapi.interface-xml.com/appservices/ws/FrontendService?WSDL', array( 'exceptions' => 0, 'trace' => 1, 'connection_timeout' => 1800, 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,'encoding' => 'ISO-8859-1', 'Content-Type'=> 'application/xml' ));
			$this->client->xml_request->HotelValuedAvailRQ->echoToken="DummyEchoToken";
			$this->client->xml_request->HotelValuedAvailRQ->sessionId="DummySessionId";
			$this->client->xml_request->HotelValuedAvailRQ->xmlns='http://www.hotelbeds.com/schemas/2005/06/messages/';
			$this->client->xml_request->HotelValuedAvailRQ->version='2013/12';
			$HotelValuedAvailService = $this->client->HotelValuedAvailRQ;
			$HotelValuedAvailService->Language = 'ENG';
			$HotelValuedAvailService->Credentials->User = 'GETCENTRENG163996';
			$HotelValuedAvailService->Credentials->Password = 'GETCENTRENG163996';
			$HotelValuedAvailService->PaginationData->pageNumber = '1';
			$HotelValuedAvailService->PaginationData->itemsPerPage ='999';
			$HotelValuedAvailService->CheckInDate->date='20150206';
			$HotelValuedAvailService->CheckOutDate->date='20150208';
			$HotelValuedAvailService->Destination->code="PMI";
			$HotelValuedAvailService->Destination->type="SIMPLE";
			$HotelValuedAvailService->OccupancyList->HotelOccupancy->RooomCount="1";
			$HotelValuedAvailService->OccupancyList->HotelOccupancy->Occupancy->AdultCount="1";
			/*for($x=0; $x<$_POST["c_rooms"]; $x++){
				$HotelValuedAvailService->OccupancyList->HotelOccupancy->RooomCount="1";
				$room_adult= $_POST["room_b"][$x][1];
				$HotelValuedAvailService->OccupancyList->HotelOccupancy[$x]->Occupancy->AdultCount= $room_adult;
				$room_c=$_POST["room_b"][$x][2];
				if($room_c!=0){
					$HotelValuedAvailService->OccupancyList->HotelOccupancy[$x]->Occupancy->ChildCount= $room_c;
				}
			}*/
			$dataRQ = $HotelValuedAvailService;
			echo "<pre>".print_r($dataRQ, true)."</pre>";
			try{ $rp = $this->client->__soapCall('HotelValuedAvailRQ', array( 'HotelValuedAvailRQ' => $dataRQ ));
				echo "<pre>".print_r($rp, true)."</pre>";
				/*$array1 = (array) $rp;
				if (($array1 != null) && (sizeof($array1) > 0)) {
				$json = new Services_JSON();
				$jsonOutput = $json->encode($array1);}
				echo $jsonOutput;*/
			}
			catch (SoapFault $exception){ $rp = $exception; }
			}
		}
	$obj = new HotelValuedAvailService();
	$obj-> HotelValuedAvailRQ();
	?>
