<?php
require_once 'fun_connect.php';
require_once 'JSON.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 0); 
 
$a_json = array();
$a_json_row = array();
//$hotelcode=json_decode($_GET['hotelCodes']);
$sql = "SELECT `CONCEPT`, `DISTANCE`  FROM `FACILITIES` WHERE `HOTELCODE`='".$_GET['hotelCode']."' AND `GROUP_`='100' ";
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)) {
	$a_json_row["place"]=$row[0]; 
	$a_json_row["distance"]=$row[1]; 
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>