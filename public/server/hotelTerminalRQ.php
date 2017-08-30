<?php
require_once 'fun_connect.php';
require_once 'JSON.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 0); 
 
$a_json = array();
$a_json_row = array();
//$hotelcode=json_decode($_GET['hotelCodes']);
$sql = "SELECT a.DISTKM, a.DISTMIN, b.TERMINALNAME FROM `HOTEL_TERMINALS` AS a JOIN `TERMINALS` AS b ON a.TERMINALCODE=b.TERMINALCODE  WHERE a.HOTELCODE='".$_GET['hotelCode']."'";
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)) {
	$a_json_row["tname"]=$row[2]; 
	$a_json_row["TdistKM"]=$row[0]; 
	$a_json_row["TdistMin"]=$row[1]; 
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>