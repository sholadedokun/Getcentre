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
	$to='info@getcentre.com';
	$subject = "GETCentre Contact Page(".$_GET['subject'].")";
	$message="<b>Your have the following Message from GETCentre.com contact Page, Please respond to this user as soon as possible</b><br><br>";
	$message.= '<b>User Name:</b> '.$_GET['fname'].' <br><br>';	
	$message.= '<b>User Email Address:</b> '.$_GET['email'].' <br><br>';	
	$message.= '<b>Message Subject:</b> '.$_GET['subject'].' <br><br>';	
	$message.= '<b>Message:</b> '.$_GET['message'].' <br><br>';	
	$message.= "Best Regards,<br> The GETCentre Team.<br>";    
	$headers = "MIME-Version: 1.0"."\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= "From:Getcentre.com\r\n";
	//$message = nl2br($message);
	$a = mail($to, $subject, $message, $headers);
	if($a){echo 'o';}
?>