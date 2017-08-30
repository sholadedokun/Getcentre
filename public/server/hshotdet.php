<?php
// contains utility functions mb_stripos_all() and apply_highlight()
require_once 'fun_connect.php';
require_once 'JSON.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 0); 
 
$a_json = array();
$a_json_row = array();
$hotelcode= mysql_real_escape_string($_GET['hotel_code']);
$hotelcat= mysql_real_escape_string($_GET['cat_code']);
$sql = "SELECT a.HotelFacilities, b.CATEGORYNAME FROM HOTEL_DESCRIPTIONS as a, `CATEGORY_DESCRIPTIONS` as b WHERE a.HotelCode='".$hotelcode."'AND b.categorycode='".$hotelcat."' AND a.LanguageCode='ENG' AND b.LanguageCode='ENG' ";
//echo $sql;
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)) { $hdet->det=substr($row[0], 0,185).'...'; $hdet->cat=$row[1];} echo json_encode($hdet);

?>