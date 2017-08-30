<?php
// contains utility functions mb_stripos_all() and apply_highlight()
require_once 'local_utils.php';
require_once 'fun_connect.php';

//error_reporting(E_ALL);
//ini_set('display_errors', 0); 
 
// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
  $user_error = 'Access denied - not an AJAX request...';
  trigger_error($user_error, E_USER_ERROR);
}
 
// get what user typed in autocomplete input
$term = trim($_GET['term']);
 
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
 
/**
 * Create SQL
 */
$sql = "SELECT `zone_code`, `zone_full_name` FROM `juniper_zonelist` WHERE `zone_continent`!= 'Country'";
for($i = 0; $i < $p; $i++) {
  $sql .= ' AND `zone_full_name` LIKE ' . "'%" . mysql_real_escape_string($parts[$i]) . "%'";
}
 
$rs = mysql_query($sql);
if($rs === false) {
  $user_error = 'Wrong SQL: ' . $sql . 'Error: ' . mysql_errno . ' ' . mysql_error;
  trigger_error($user_error, E_USER_ERROR);
}
 
while($row = mysql_fetch_array($rs)) {
  $a_json_row["id"] = $row['zone_code'];
  $a_json_row["value"] = $row['zone_full_name'];
  $a_json_row["label"] = $row['zone_full_name'];
  array_push($a_json, $a_json_row);
}
 
// highlight search results
$a_json = apply_highlight($a_json, $parts);
 
$json = json_encode($a_json);
print $json;
?>