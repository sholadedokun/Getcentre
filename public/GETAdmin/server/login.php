<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once '../../server/fun_connect2.php';
	// require_once 'JSON.php';

	// prevent direct access
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$email=$request->email;
	$password=$request->password;

	// $passer=md5($_GET['pass']);
	$a_json = array();
	$a_json_row = array();
	$sqlcheck = "SELECT * FROM admin_user WHERE email='".$email."' AND password='$password'";
	$rescheck=mysql_query($sqlcheck) or die ("Error : could not check values for $email " . mysql_error() );
	$count = mysql_num_rows($rescheck);
	if($count > 0){
		$row= mysql_fetch_array($rescheck);
		$a_json_row["info"] = 'Authenticated';
		$a_json_row["status"] = 'success';
		$a_json_row["userId"] = $row[0];
		$a_json_row["email"] = $row[1];
		$a_json_row["privelege"] = $row[3];
		$a_json_row["adminStatus"] = $row[4];
		$a_json_row["lastLogin"] = $row[5];
		$json = json_encode($a_json_row);
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
