<?php
// contains utility functions mb_stripos_all() and apply_highlight()
require_once 'fun_connect.php';
require_once 'JSON.php';
error_reporting(E_ALL);
ini_set('display_errors', 0);

$a_json = array();
$a_json_row = array();

 $hotelcode= mysql_real_escape_string($_GET['hotelCode']);

$sql = "SELECT a.HotelFacilities, b.IMAGEPATH, c.ADDRESS, c.POSTALCODE, c.CITY, c.COUNTRYCODE, c.EMAIL, c.WEB FROM HOTEL_DESCRIPTIONS AS a, HOTEL_IMAGES As b, CONTACTS AS c WHERE a.HotelCode='".$hotelcode."' AND b.HOTELCODE='".$hotelcode."' AND c.HOTELCODE='".$hotelcode."'";

$rs = mysql_query($sql);
if($rs === false) {
  $user_error = 'Wrong SQL: ' . $sql . 'Error: ' . mysql_errno . ' ' . mysql_error;
  trigger_error($user_error, E_USER_ERROR);
}

while($row = mysql_fetch_array($rs)) {
  /*
      $a_json_row["hotel_desc"] = $row[0];
      $a_json_row["img_path"] = $row[1];
      $a_json_row["Address"] = $row[2];
      $a_json_row["postal_code"] = $row[3];
      $a_json_row["city"] = $row[4];
      $a_json_row["counrty_code"] = $row[5];
      $a_json_row["email"] = $row[6];
      $a_json_row["web"] = $row[7];
      array_push($a_json, $a_json_row);
  */
  $a_json['details'][]=array('hotel_desc' => $row[0], 'img_path' => 'http://www.hotelbeds.com/giata/'.$row[1],'address' => $row[2], 'postcode' => $row[3], 'city' => $row[4], 'counrty_code' => $row[5],'email' => $row[6], 'web' => $row[7] );
}

if (($a_json != null) && (sizeof($a_json) > 0)) {
		//$arrayData = xmlToArray($a_json);
		$jsonOutput=json_encode($a_json);
	}
		echo $jsonOutput;

?>
