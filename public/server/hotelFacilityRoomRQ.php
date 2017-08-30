<?php
require_once 'fun_connect.php';
require_once 'JSON.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 0); 
 
$a_json = array();
$a_json_row = array();
//$hotelcode=json_decode($_GET['hotelCodes']);
$sql = "SELECT b.NAME, a.LOGIC, a.FEE FROM `FACILITIES` AS a JOIN `FACILITY_DESCRIPTIONS` AS b ON (a.CODE=b.CODE AND a.GROUP_=b.GROUP_) WHERE a.HOTELCODE='".$_GET['hotelCode']."' AND a.GROUP_='60' AND b.LANGUAGECODE='ENG'";
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)) {
	$a_json_row["name"]=$row[0];
	$a_json_row["logic"]=$row[1];
	$a_json_row["fee"]=$row[2]; 
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>