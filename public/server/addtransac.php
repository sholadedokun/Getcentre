<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once 'fun_connect2.php';
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$user=$request->userE;
	$transaction=$request->trans;
	//print_r($transaction);
	//echo "<pre>".$user->fname."</pre>";
	$t=time();
	$basketId=uniqid();
	$a_json = array();
	$a_json_row = array();
	$amount=0;
	$paymenttype='';
	$status='';
	$code=0;
	if ($request->payopt=='paynow'){$paymenttype='interswitch'; $status='Pending'; $code='I.N.Y.C';}
	else{$paymenttype='PayLater';}
	for($i=0; $i<count($transaction); $i++){
		$amount=$amount+$transaction[0]->Price;
		$name='';
		if($transaction[$i]->productType=='Flight'){

			foreach($transaction[$i]->flightDetails as $flight){
				$name= $name.'| '.$flight->fname.' |';
			}
			$soldPrice=$transaction[$i]->soldPrice;
			$soldDiscount=$transaction[$i]->discount;
		}
		else{
			$name=$transaction[$i]->Name;
		}
		$sql="INSERT INTO user_transaction VALUES (NULL,
			'".mysql_real_escape_string($user->id)."',
			'".mysql_real_escape_string($user->title)."',
			'".mysql_real_escape_string($user->fname)."',
			'".mysql_real_escape_string($user->lname)."',
			'".mysql_real_escape_string($user->email)."',
			'".mysql_real_escape_string($user->phone)."',
			'".mysql_real_escape_string($transaction[$i]->product)."',
			'".mysql_real_escape_string($transaction[$i]->productType)."',
			'".mysql_real_escape_string($name)."',
			'".mysql_real_escape_string($transaction[$i]->Price)."',
			'".mysql_real_escape_string($soldPrice)."',
			'".mysql_real_escape_string($transaction[$i]->curr)."',
			'".$basketId."',
			'".mysql_real_escape_string($soldDiscount)."',
			'Online',
			'Desktop',
			'".mysql_real_escape_string($transaction[$i]->Price)."',
			'',
			'".$paymenttype."',
			'".$code."',
			'".$status."',
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
	if(count($a_json)>0){
		$sql="INSERT INTO pay_log VALUES (NULL,
			'".$basketId."',
			'".$amount."',
			'".$t."',
			'".mysql_real_escape_string($request->payopt)."',
			'Unpaid'
			)";
		$res=mysql_query($sql)or die ("Error : could not insert values" . mysql_error());
	}
	$json = json_encode($a_json);
	echo $json;
?>
