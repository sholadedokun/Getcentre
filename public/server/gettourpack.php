  <?php
 	include('../server/fun_connect2.php');
	$a_json = array();
	$a_json_row = array();
	$tours=json_decode($_GET['alltours']);
	$querys= "SELECT * FROM `Tours` where ";
	for($i=0; $i<count($tours); $i++){
		if($i==0){		$querys.=" t_id=".$tours[$i].""; }
		else{ $querys.=" OR t_id=".$tours[$i]."";}
	}
	//echo($querys);
	$res_get=mysql_query($querys);
	while ($row=mysql_fetch_array($res_get)) {
		$a_json_row["tname"] = $row[2];
		$a_json_row["Category"] = $row[6];
		$a_json_row["rate"] = $row[7];
		$a_json_row["city"] = $row[5];
		$a_json_row["country"] = $row[4];
		$a_json_row["brief"] = $row[9];
		$a_json_row["cost"] = $row[8];
		$a_json_row["duration"] = $row[10];
		$a_json_row["pict"] = $row[11];
		$a_json_row["all_pict"] = $row[12];
		
		array_push($a_json, $a_json_row);
	}
	echo  json_encode($a_json);
 ?>