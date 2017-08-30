<?php 
	require_once 'JSON.php';
	require_once 'fun_connect2.php';
	session_start();
	$user=json_decode($_GET['user']);
	$tour=json_decode($_GET['tour']);
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	//echo '<pre>'.print_r($_GET).'</pre>';
	/*$sql="Select * FROM Registered_user WHERE userId='$user'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);*/
	$to='info@getcentre.com';
	$subject = "GETCentre Tour Reservation";
	$message="<b>".$tour->pname." has been reserved, Please respond to this user as soon as possible</b><br><br>";
	$message.= '<b>User Full Name:</b> '.$user->fname.' <br><br>';	
	$message.= '<b>User Email Address:</b> '.$user->email.' <br><br>';
	$message.= '<b>User Phone Number:</b> '.$user->phone.' <br><br>';	
	$message.= "Best Regards,<br> The GetCentre Team.<br>";    
	$headers = "MIME-Version: 1.0"."\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= "From:Getcentre.com\r\n";
	//$message = nl2br($message);
	$a = mail($to, $subject, $message, $headers);
	
	if($a){
		$to=$user->email;
		$subject = "GETCentre Tour Reservation";
		$message = "Thanks for booking the <b>".$tour->pname."</b>, your package has been reserved. Our representative will contact you soon. <br>";
		$message.= 'Please contact info@getcentre.com for more inquiries.<br> <br>';	
		$message.= "Best Regards,<br> The GETCentre Team.<br>";    
		$headers = "MIME-Version: 1.0"."\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= "From:Getcentre.com\r\n";
		//$message = nl2br($message);
		$b = mail($to, $subject, $message, $headers);
		if($b) echo ('o');
	}
?>