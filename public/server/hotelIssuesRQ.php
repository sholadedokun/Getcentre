<?php
require_once 'fun_connect.php';
require_once 'JSON.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 0); 
 
$a_json = array();
$a_json_row = array();
//$hotelcode=json_decode($_GET['hotelCodes']);
$sql = "SELECT INCIDENT, DATEFROM, DATETO FROM `HOTEL_ISSUES` WHERE HOTELCODE='".$_GET['hotelCode']."'";
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)) {
	$a_json_row["incident"]=$row[0]; 
	$a_json_row["datefrom"]=$row[1]; 
	$a_json_row["dateto"]=$row[2]; 
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>