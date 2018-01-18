<?php
class OTA_UPDATEZONESERVICE{

    function OTA_UPDATEZONELIST() {
        $this->client = new SoapClient('http://xml2.bookingengine.es/webservice/JP_ZoneList.asmx?wsdl',
                       array( 'exceptions' => 0, 'trace' => 1, 'connection_timeout' => 1800, 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,'encoding' => 'ISO-8859-1' ));
        $this->client->JP_ZoneListService->xmlns = 'http://www.juniper.es/webservice/2007/';
        $JP_ZoneListService = $this->client->JP_ZoneListService;
        $JP_ZoneListService->JP_ZoneListRQ->PrimaryLangID = 'en';
        $JP_ZoneListService->JP_ZoneListRQ->POS->Source->AgentDutyCode = 'XML_GETCentre';
        $JP_ZoneListService->JP_ZoneListRQ->POS->Source->RequestorID->Type = "1";
        $JP_ZoneListService->JP_ZoneListRQ->POS->Source->RequestorID->MessagePassword = 'NdKT7Rs5t4';

        $tpa_extensions = '<ns1:TPA_Extensions><ShowHotels>1</ShowHotels></ns1:TPA_Extensions>';
        $obj = new SoapVar($tpa_extensions, XSD_ANYXML) ;
        $JP_ZoneListService->JP_ZoneListRQ->TPA_Extensions = $obj;
        $dataRQ = $JP_ZoneListService;
        try{ $rp = $this->client->__soapCall('JP_ZoneListService', array( 'JP_ZoneListRQ' => $dataRQ ));
        // echo count($rp);
           echo "<pre>".print_r($rp)."</pre>";

        }
        catch (SoapFault $exception){ echo $exception; }
    }
}
$obj = new OTA_UPDATEZONESERVICE();
$obj->OTA_UPDATEZONELIST();
?>
