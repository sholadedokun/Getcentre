<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once '../../server/fun_connect2.php';
	// $amount=$amount+$transaction[0]->Price;
    $a_json = array();
	$a_json_row = array();
	$sql="SELECT * from Registered_user";
	$res=mysql_query($sql)or die ("Error : could not retrieve values" . mysql_error());
    while ($row=mysql_fetch_array($res)) {
        $a_json_row["id"] = $row[0];
        $a_json_row["name"] = $row[1].' '.$row[2].' '.$row[3];
        $a_json_row["email"] = $row[4];
        $a_json_row["userType"] = $row[7];
        $a_json_row["registered"] = $row[16];
        $a_json_row["status"] = $row[17];
		$a_json_row["hotelDiscount"] = $row[19];
		$a_json_row["flightDiscount"] = $row[18];
		$a_json_row["tourDiscount"] = $row[20];
		$a_json_row["transferDiscount"] = $row[21];
        array_push($a_json, $a_json_row);
    }
    echo  json_encode($a_json);
?>
