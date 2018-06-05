<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('memory_limit','40048M');

	require_once 'fun_connect2.php';

	$file = 'new_zoneList.txt';

	$newArray=array("1", "2", "de", "e3");
	print_r(array_splice($newArray, 0, 2));
	print_r(array_splice($newArray, 0, 2));
	print_r ($newArray);
	// if($current!=""){
	// 	 echo $current;
	// 	echo "<pre>".json_decode($current)."</pre>";
	// 	$current=json_decode(json_encode($current), true);
	// 	echo  "<pre>".print_r($current, true)."</pre>";;
	// 	echo count($current);
	// 	// for($i=0; $i<count($transaction); $i++){
	// 	// 	$amount=$amount+$transaction[0]->Price;
	// 	// 	$name='';
	// 	// 	if($transaction[$i]->productType=='Flight'){

	// 	// 		foreach($transaction[$i]->flightDetails as $flight){
	// 	// 			$name= $name.'| '.$flight->fname.' |';
	// 	// 		}
	// 	// 		$soldPrice=$transaction[$i]->soldPrice;
	// 	// 		$soldDiscount=$transaction[$i]->discount;
	// 	// 	}
	// 	// 	else{
	// 	// 		$name=$transaction[$i]->Name;
	// 	// 	}
	// 	// 	$sql="INSERT INTO user_transaction VALUES (NULL,
	// 	// 		'".mysql_real_escape_string($user->id)."',
	// 	// 		'".mysql_real_escape_string($user->title)."',
	// 	// 		'".mysql_real_escape_string($user->fname)."',
	// 	// 		'".mysql_real_escape_string($user->lname)."',
	// 	// 		'".mysql_real_escape_string($user->email)."',
	// 	// 		'".mysql_real_escape_string($user->phone)."',
	// 	// 		'".mysql_real_escape_string($transaction[$i]->product)."',
	// 	// 		'".mysql_real_escape_string($transaction[$i]->productType)."',
	// 	// 		'".mysql_real_escape_string($name)."',
	// 	// 		'".mysql_real_escape_string($transaction[$i]->Price)."',
	// 	// 		'".mysql_real_escape_string($soldPrice)."',
	// 	// 		'".mysql_real_escape_string($transaction[$i]->curr)."',
	// 	// 		'".$basketId."',
	// 	// 		'".mysql_real_escape_string($soldDiscount)."',
	// 	// 		'Online',
	// 	// 		'Desktop',
	// 	// 		'".mysql_real_escape_string($transaction[$i]->Price)."',
	// 	// 		'',
	// 	// 		'".$paymenttype."',
	// 	// 		'".$code."',
	// 	// 		'".$status."',
	// 	// 		'',
	// 	// 		$t
	// 	// 	)";
	// 	// 	$res=mysql_query($sql)or die ("Error : could not insert values" . mysql_error());
	// 	// 	$trans_id = mysql_insert_id();
	// 	// 	if($res){
	// 	// 		$a_json_row["id"] = $trans_id;
	// 	// 		$a_json_row["basketId"] = $basketId;
	// 	// 		array_push($a_json, $a_json_row);
	// 	// 	}
	// 	// }
	// }	
?>
