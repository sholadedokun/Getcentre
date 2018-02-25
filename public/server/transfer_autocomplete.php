<?php
// contains utility functions mb_stripos_all() and apply_highlight()
require_once 'local_utils.php';
require_once 'fun_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
  $user_error = 'Access denied - not an AJAX request...';
  trigger_error($user_error, E_USER_ERROR);
}
 
// get what user typed in autocomplete input
$term = trim($_GET['term']);
$type=$_GET['type'];
$dcode=$_GET['dest_code'];

$a_json = array();
$a_json_row = array();

$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
$json_invalid = json_encode($a_json_invalid);

// replace multiple spaces with one
$term=str_replace(",", " ", $term);
$term = preg_replace('/\s+/', ' ', $term);

// SECURITY HOLE ***************************************************************
// allow space, any unicode letter and digit, underscore and dash
if(preg_match("/[^\040\pL\pN_-]/u", $term)) {
  print $json_invalid;
  exit;
}
// *****************************************************************************

$parts = explode(' ', $term);
$p = count($parts);
if($type=='Terminal'){
$sql="SELECT TERMINALCODE, TERMINALNAME FROM `TERMINALS` WHERE (";
	for($i = 0; $i < $p; $i++) {
	  $sql .= "TERMINALNAME LIKE '%".mysql_real_escape_string($parts[$i])."%' OR TERMINALCODE LIKE '%".mysql_real_escape_string($parts[$i])."%')";
	}
}
else{
$sql="SELECT DISTINCT b.NAME, b.HOTELCODE, d.NAME FROM `HOTELS` AS b JOIN `DESTINATIONS` AS c ON b.DESTINATIONCODE=c.DESTINATIONCODE JOIN `DESTINATION_IDS` As d ON c.DESTINATIONCODE=d.DESTINATIONCODE WHERE (";
	for($i = 0; $i < $p; $i++) {
	  $sql .= "b.Name LIKE '%" . mysql_real_escape_string($parts[$i]) . "%'";
	   $sql .= " )AND d.DESTINATIONCODE='".$dcode."' AND d.languagecode='ENG'";
	}
}
//echo $sql;
$rs = mysql_query($sql);

while($row = mysql_fetch_array($rs)) {
  if($type=='Terminal'){
  	$a_json_row["id"] = $row[0];
  	$a_json_row["value"] = $row[1];
  	$a_json_row["label"] = $row[1];

  }
  else{
  	$a_json_row["id"] = $row[1];
	$a_json_row["value"] = $row[0].' '.$row[2];
  	$a_json_row["label"] = $row[0].' '.$row[2];

  }
  array_push($a_json, $a_json_row);
}

// highlight search results
$a_json = apply_highlight($a_json, $parts);

$json = json_encode($a_json);
print $json;
?>
