<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	$tran_con= json_decode($_COOKIE['webPay']);
	$txn_ref=$tran_con->txn_ref;
	$amount=$tran_con->amount;
	$hasher=$tran_con->hasher;
	//echo($hasher);
	$has=hash('sha512', '21'.$txn_ref.$hasher);
	echo( '21'.$txn_ref.$hasher);
	echo($has);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'https://stageserv.interswitchng.com/test_paydirect/api/v1/gettransaction.json?productid=21&transactionreference='.$txn_ref.'&amount='.$amount
		//CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; MS Web Services Client Protocol 4.0.30319.239)'
	));
	$headers = array();
	$headers[] =  'Hash:'+$hasher;
	//echo $headers;
	curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
	echo $resp;
?>  
