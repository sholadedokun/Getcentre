<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once 'fun_connect2.php';
	session_start();
	$user="Regular";
	$activation="Activated";
	$a_json = array();
	if(isset($_GET['agent'])){$user="Agent"; $activation="deactivated";} $t=time();
	$title=$_GET['title'];$fname=$_GET['fname'];$lname=$_GET['lname'];$email=$_GET['email'];
	$pass=md5($_GET['pass']);$phone=$_GET['phone'];$dob=$_GET['date_birth'];
	$con_Add=$_GET['con_add'];$city=$_GET['city'];$state=$_GET['state'];$postal_c=$_GET['postal_c'];
	$country=$_GET['country'];$national=$_GET['national'];
	$sqlcheck = "SELECT * FROM Registered_user WHERE userEmail='".mysql_real_escape_string($email)."'";
	$rescheck=mysql_query($sqlcheck) or die ("Error : could not check values for $email " . mysql_error() );
	$count = mysql_num_rows($rescheck);
	if($count > 0){
		 $a_json['status'] = "User already exist";
		 echo json_encode($a_json);
	}
	else{
		$sql="INSERT INTO Registered_user VALUES (NULL,
														'".mysql_real_escape_string($title)."',
														'".mysql_real_escape_string($fname)."',
														'".mysql_real_escape_string($lname)."',
														'".mysql_real_escape_string($email)."',
														'".mysql_real_escape_string($phone)."',
														'".mysql_real_escape_string($dob)."',
														'$user',
														'".mysql_real_escape_string($pass)."',
														'".mysql_real_escape_string($postal_c)."',
														'".mysql_real_escape_string($con_Add)."',
														'".mysql_real_escape_string($city)."',
														'".mysql_real_escape_string($state)."',
														'".mysql_real_escape_string($country)."',
														'".mysql_real_escape_string($national)."',
														'New Agent',
														$t,
														'$activation',
														0,
														0,
														0,
														0

		)";
		$res=mysql_query($sql)or die ("Error : could not insert values" . mysql_error());
		$user_id = mysql_insert_id();
		/*$ne= mysql_next_result($res);
		$de=mysql_fetch($res); */
		// store session data
		$_SESSION['user']=$user_id;
		if($res){
			$to=$_GET['email'];
			$subject = "Getcentre Registration";
			$message="Dear ".$_GET['title']." ".$_GET['fname']." ".$_GET['lname'].",<br><br>";
			$message.= 'Thanks for Registering at Getcentre.com<br><br>';
			$message.= "Best Regards,<br> The GetCentre Team.<br>";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= "From:Getcentre.com\r\n";
				//$message = nl2br($message);
				$a = mail($to, $subject, $message, $headers);
				if($a){
					 $a_json['status'] = "success";
					 echo json_encode($a_json);
					 if($user=='Agent'){
						 $to="adewole@getcentre.com";
						 $subject = "Getcentre Agent Registration Notification";
			 			 $message="Dear Admin,<br><br>";
						 $message.= "Please Find the Agent Details below<br><br>";
						 $message.= '<strong>Full Name: </strong>'.$_GET['title']." ".$_GET['fname']." ".$_GET['lname']."<br>";
						 $message.= '<strong>Email Address: </strong>'.$_GET['email'].",<br>";
						 $message.= '<strong>Phone Number: </strong>'.$phone.",<br><br>";
			 			 $message.= "Best Regards,<br> The GetCentre Team.<br>";
			 			 $headers = "MIME-Version: 1.0" . "\r\n";
			 			 $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			 			 $headers .= "From:Getcentre.com\r\n";
						 $sendToAdmin = mail($to, $subject, $message, $headers);
					 }
				}
		}
		else{echo '1';}
	}
?>
