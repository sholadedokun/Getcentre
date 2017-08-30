<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once 'fun_connect2.php';
	$transaction=json_decode($_GET['trans']);
		$sql="UPDATE user_transaction SET `transactionConfirmationCode` VALUES ('".mysql_real_escape_string($_GET['bookCode'])."') WHERE `transactionId`=".$transaction->id." AND `transactionBasketId`='".$transaction->basketId."'";
		$res=mysql_query($sql)or die ("Error : could not insert values" . mysql_error());
		if($res){	echo 'o';}
?>
