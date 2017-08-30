<?php
require_once 'fun_connect.php';
require_once 'JSON.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 0); 
 
$a_json = array(array('hcode'=>'All', 'hchainname'=>'All'));
$a_json_row = array();
$hotelcode=json_decode($_GET['hotelCodes']);
$sql = "SELECT a.HOTELCODE,b.CHAINNAME  FROM `HOTELS` as a JOIN `CHAINS` as b on a.CHAINCODE=b.CHAINCODE WHERE ( ";
for($i = 0; $i < count($hotelcode); $i++) {
	if($i != 0){$sql .= " OR  a.HOTELCODE='".$hotelcode[$i]."'";}
	else{	  $sql .= " a.HOTELCODE='".$hotelcode[$i]."' ";  }
}
$sql .=")";
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)) {
	$a_json_row["hcode"]=$row[0]; 
	$a_json_row["hchainname"]=$row[1]; 
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>