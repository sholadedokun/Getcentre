<?php
 	error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('memory_limit','5000M');
    ini_set('max_execution_time', 300);
    require_once 'fun_connect2.php';

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
        $string_response;
        $rp;
        try{ $rp = $this->client->__soapCall('JP_ZoneListService', array( 'JP_ZoneListRQ' => $dataRQ ));
            $allZonelist=$rp->JP_ZoneListRS->Zone;
            $allZoneJson;
            // echo(count($allZonelist));
            $sql="SELECT * FROM `juniper_zonelist`";
            $res=mysql_query($sql) or die("Error : Could not fetch database".mysql_error);
            if($res){
                $currentIndex = mysql_num_rows($res);
                $remainingZones = array_splice($allZonelist, $currentIndex);
                for($i=0; $i<count($remainingZones); $i++){
                    $sql="INSERT INTO `juniper_zonelist` VALUES (
                        NULL,'".mysql_real_escape_string($remainingZones[$i]->Code)."',
                        '".mysql_real_escape_string($remainingZones[$i]->JPDCode)."',
                        '".mysql_real_escape_string($remainingZones[$i]->Name)."',
                        '".mysql_real_escape_string($remainingZones[$i]->Parent)."',
                        '".mysql_real_escape_string($remainingZones[$i]->IATA)."',
                        '".mysql_real_escape_string($remainingZones[$i]->Type)."',
                        '".mysql_real_escape_string($remainingZones[$i]->ClientType)."',
                        '".mysql_real_escape_string($remainingZones[$i]->Name)."',
                        '".mysql_real_escape_string($remainingZones[$i]->Hotels)."',
                        '".mysql_real_escape_string($remainingZones[$i]->Searchable)."'
                        )";
                    // echo $sql;
                    $res=mysql_query($sql)or die ("Error : could not insert values" . mysql_error());
                }
            }
            // $file = 'new_zoneList.txt';
            // file_put_contents($file, $allZoneJson);
        }
        catch (SoapFault $exception){ echo $exception; }
         
               
    }
}
$obj = new OTA_UPDATEZONESERVICE();
$obj->OTA_UPDATEZONELIST();
?>
