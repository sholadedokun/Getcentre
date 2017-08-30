<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once '../../server/fun_connect2.php';
	$postdata = file_get_contents("php://input");
	$user = json_decode($postdata);
	// $user=json_decode($_GET['trans']);
		$sql="UPDATE Registered_user SET
        `userStatus` = '".$user->status."', `hotelDiscount` = ".$user->hotelDiscount." ,`flightDiscount` = ".$user->flightDiscount.", `tourDiscount` = ".$user->tourDiscount." ,`transferDiscount` = ".$user->transferDiscount."
         WHERE `userId` =".$user->id;
		$res=mysql_query($sql)or die ("Error : could not insert values" . mysql_error());
		if($res){	echo 'success';}
?>
