<?php
require_once 'fun_connect.php';
require_once 'JSON.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 0);  
$a_json = array(array('hcode'=>'All', 'pofinterest'=>'All')); 
$a_json_row = array();
$hotelcode=json_decode($_GET['hotelCodes']);
$sql = "SELECT `HOTELCODE`,`CONCEPT`  FROM `FACILITIES` WHERE ( ";
for($i = 0; $i < count($hotelcode); $i++) {
	if($i != 0){$sql .= " OR  `HOTELCODE`='".$hotelcode[$i]."'";}
	else{	  $sql .= " `HOTELCODE`='".$hotelcode[$i]."' ";  }
}
$sql .=") AND `GROUP_`='20' ";
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)) {
	$a_json_row["hcode"]=$row[0]; 
	$a_json_row["pofinterest"]=$row[1]; 
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>