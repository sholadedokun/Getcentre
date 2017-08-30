<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once 'fun_connect2.php';
	$user=json_decode($_GET['userE']);
	$transaction=json_decode($_GET['trans']);
	//print_r($transaction);
	//echo "<pre>".$user->fname."</pre>";
	$t=time();
	$basketId=uniqid();
	$a_json = array();
	$a_json_row = array();
	for($i=0; $i<count($transaction); $i++){
		$sql="INSERT INTO pay_log VALUES (NULL,
			
			'".mysql_real_escape_string($transaction->product)."',
			'".mysql_real_escape_string($transaction->productType)."',
			'".mysql_real_escape_string($transaction->Name)."',
			'".mysql_real_escape_string($transaction->Price)."',
			'".mysql_real_escape_string($transaction->curr)."',
			'".$basketId."',
			'0',
			'Online',
			'Desktop',
			'".mysql_real_escape_string($transaction->Price)."',
			'',
			'',
			'',
			'',
			$t
		)";
		$res=mysql_query($sql)or die ("Error : could not insert values" . mysql_error());
		$trans_id = mysql_insert_id();
		if($res){
			$a_json_row["id"] = $trans_id;
			$a_json_row["basketId"] = $basketId;
			array_push($a_json, $a_json_row);
		}
		
	}
	$json = json_encode($a_json);
	print $json;
?>
