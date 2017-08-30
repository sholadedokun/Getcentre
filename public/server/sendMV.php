<?php
	require_once 'JSON.php';
	require_once 'fun_connect2.php';
	session_start();
	$user=$_SESSION['user'];
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	/*$sql="Select * FROM Registered_user WHERE userId='$user'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);*/
	$to='sholadedokun@yahoo.com';
	$subject = "GETCentre Visa Appointment Schedule";
	$message="<b>Visa Application Assistance Schedule, Please respond to this user as soon as possible</b><br><br>";
	$message.= '<b>User Full Name:</b> '.$_GET['title'].' '.$_GET['fname'].' '.$_GET['lname'].' <br><br>';
	$message.= '<b>User Email Address:</b> '.$_GET['email'].' <br><br>';
	$message.= '<b>User Phone Number:</b> '.$_GET['phone'].' <br><br>';
	$message.= '<b>User Resident Country:</b> '.$_GET['country'].' <br><br>';
	$message.= '<b>Scheduled Date:</b> '.$_GET['schDate'].' <br><br>';
	$message.= '<b>Scheduled Office:</b> '.$_GET['office'].' <br><br>';
	$message.= '<b>Traveling Purpose:</b> '.$_GET['purpose'].' <br><br>';
	$message.= '<b>Destiantion:</b> '.$_GET['destination'].' <br><br>';
	$message.= "Best Regards,<br> The GetCentre Team.<br>";
	$headers = "MIME-Version: 1.0"."\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= "From:Getcentre.com\r\n";
	//$message = nl2br($message);
	$a = mail($to, $subject, $message, $headers);
	if($a){
		$to=$_GET['email'];
		$subject = "GETCentre Visa Appointment Schedule";
		$message="<b>We've received your Visa Application Assistance Schedule, our representative will contact you shortly</b><br><br>";
		$message.= '<b>Your Full Name:</b> '.$_GET['title'].' '.$_GET['fname'].' '.$_GET['lname'].' <br><br>';
		$message.= '<b>Your Phone Number:</b> '.$_GET['phone'].' <br><br>';
		$message.= '<b>Your Resident Country:</b> '.$_GET['country'].' <br><br>';
		$message.= '<b>Your Scheduled Date:</b> '.$_GET['schDate'].' <br><br>';
		$message.= '<b>Your Scheduled Office:</b> '.$_GET['office'].' <br><br>';
		$message.= '<b>Your Traveling Purpose:</b> '.$_GET['purpose'].' <br><br>';
		$message.= '<b>Your Destiantion:</b> '.$_GET['destination'].' <br><br>';
		$message.= "Best Regards,<br> The GetCentre Team.<br>";
		// $message.='  <p>This email was intended for '.$to.'. If you think you receive this email by error and any of the content of this email  doesn\'t relate to any of your recent activity or association with www.getcentre.com <a style="color:#c00" href="http://www.getcentre.com/wrongadd.php"> please click here</a>.
        //     </p>' ;
		$headers = "MIME-Version: 1.0"."\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= "From:Getcentre.com\r\n";
		//$message = nl2br($message);
		$b = mail($to, $subject, $message, $headers);
		if($b){echo 'o';}
	}
?>
