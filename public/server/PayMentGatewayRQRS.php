<?php
	//error_reporting(E_ALL);
	//ini_set('display_errors', 0);
	$url = 'https://stageserv.interswitchng.com/test_paydirect/pay';
	$params=json_decode($_GET['params']);
	//print_r($params);
	//echo($hasher);
	//$scope.payhash= $scope.txn_ref+'6205'+''+$scope.pay_item_id+''+$scope.amount+''+$scope.site_redirect_url+;
	
	$hsa=$params->txn_ref.$params->product_id.$params->pay_item_id.$params->amount.$params->site_redirect_url.'D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F';
	$has=hash('sha512', $hsa);
	
	//echo($has);
$fields = array(
						'product_id' => urlencode($params->product_id),
						'txn_ref' => urlencode($params->txn_ref),
						'pay_item_id' => urlencode($params->pay_item_id),
						'pay_item_name' => urlencode($params->pay_item_name),
						'amount' => urlencode($params->amount),
						'currency' => urlencode($params->currency),
						'site_redirect_url' => urlencode($params->site_redirect_url),
						'site_name' => urlencode($params->site_name),
						'cust_name' => urlencode($params->cust_name),
						'cust_id' => urlencode($params->cust_id),
						'cust_id_desc' => urlencode($params->cust_id_desc),
						'cust_name_desc' => urlencode($params->cust_name_desc),
						'local_date_time' => urlencode($params->local_date_time),
						'hash' => urlencode($has)
				);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_URL => $url,
		CURLOPT_POST=> count($fields),
		CURLOPT_POSTFIELDS=> $fields_string,
		//CURLOPT_HEADER=> true, // set to true if you want headers in the output
		//CURLOPT_NOBODY=> true, // set to true if you do not want the body
		CURLOPT_CONNECTTIMEOUT=> 30,
		CURLOPT_RETURNTRANSFER=> false,
		CURLOPT_SSL_VERIFYPEER=> false,
		CURLOPT_FOLLOWLOCATION=> true, // set to false if you want to see what redirect header was sent
		//CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; MS Web Services Client Protocol 4.0.30319.239)'
	));
	//$headers = array();
	//$headers[] =  'Hash:'+$hasher;
	//echo $headers;
	//curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	curl_setopt($ch, CURLOPT_URL, 'https://stageserv.interswitchng.com/test_paydirect/pay');
	$content = curl_exec($ch);
	// Close request to clear up some resources
	curl_close($curl);
	var_dump($resp);
?>  
