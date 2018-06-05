<?php
require_once 'fun_connect.php';
require_once 'JSON.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 0); 
 
$a_json = array();
$a_json_row = array();

$sql = "SELECT c.*, p.NUMBER_ FROM `CONTACTS` AS c JOIN `PHONES` AS p ON c.HOTELCODE=p.HOTELCODE WHERE c.HOTELCODE='".$_GET['hotelCode']."' AND p.PHONETYPE='phoneHotel'";
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)) {
	$a_json_row["hotelCode"]=$row[0]; 
	$a_json_row["hotelAddress"]=$row[1];
	$a_json_row["hotelPostalC"]=$row[2];
	$a_json_row["hotelCity"]=$row[3];
	$a_json_row["hotelCountryC"]=$row[4]; 
	$a_json_row["hotelEmail"]=$row[5]; 
	$a_json_row["hotelWeb"]=$row[6]; 
	$a_json_row["Phone"]=$row[7]; 
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>