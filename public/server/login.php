<?php
	require_once 'fun_connect2.php';
	require_once 'JSON.php';
	// prevent direct access

	$passer=md5($_GET['pass']);
	$a_json = array();
	$a_json_row = array();
	$sqlcheck = "SELECT * FROM Registered_user WHERE userEmail='".mysql_real_escape_string($_GET['email'])."' AND userPassword='$passer'";
	$rescheck=mysql_query($sqlcheck) or die ("Error : could not check values for $email " . mysql_error() );
	$count = mysql_num_rows($rescheck);
	if($count > 0){
		$row= mysql_fetch_array($rescheck);
		if($row[17]=="Activated"){
			$a_json_row["info"] = 'Authenticated';
			$a_json_row["userId"] = $row[0];
			$a_json_row["title"] = $row[1];
			$a_json_row["lname"] = $row[2];
			$a_json_row["fname"] = $row[3];
			$a_json_row["email"] = $row[4];
			$a_json_row["phone"] = $row[5];
			$a_json_row["dob"] = $row[6];
			$a_json_row["utype"] = $row[7];
			$a_json_row["address"] = $row[10];
			$a_json_row["city"] = $row[11];
			$a_json_row["state"] = $row[12];
			$a_json_row["country"] = $row[13];
			$a_json_row["rank"] = $row[15];
			$a_json_row["joined"] = $row[16];
			$a_json_row["hotelDiscount"] = $row[19];
			$a_json_row["flightDiscount"] = $row[18];
			$a_json_row["tourDiscount"] = $row[20];
			$a_json_row["transferDiscount"] = $row[21];
		}
		else{
				$a_json_row["info"] = 'Your account is not active... Please contact info@getcentre.com';
		}

		  array_push($a_json, $a_json_row);
		  //$re=turntojson($a_json);
		  //echo($re);

		   $json = json_encode($a_json);
		   echo $json;
	}
	else{
		$a_json_row["info"] = 'error';
		$a_json_row["error_message"] = 'Wrong Username or Password. Please, try again';
		array_push($a_json, $a_json_row);
		//$re=turntojson($a_json);
		//echo($re);
		$json = json_encode($a_json);
		echo $json;
	}

?>
