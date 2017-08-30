  <?php
    header('Access-Control-Allow-Origin: *');
 	include('../server/fun_connect2.php');
	$a_json = array();
	$a_json_row = array();
	$querys= "SELECT * FROM `Tours Packages`";
	if(isset($_GET['id'])){$querys.=" where package_id='".$_GET['id']."' ";}
	$querys.=" order by package_id Desc Limit ".$_GET['limit'];
	$res_get=mysql_query($querys);
	while ($row=mysql_fetch_array($res_get)) {
		$a_json_row["id"] = $row[0];
		$a_json_row["pname"] = $row[2];
		$a_json_row["Category"] = $row[3];
		$a_json_row["rate"] = $row[4];
		$a_json_row["city"] = $row[7];
		$a_json_row["country"] = $row[6];
		$a_json_row["brief"] = $row[8];
		$a_json_row["cost"] = $row[9];
		$a_json_row["feat"] = $row[13];
		$a_json_row["lname"] = $row[17];
		$a_json_row["ltype"] = $row[18];
		$a_json_row["lrate"] = $row[19];
		$a_json_row["lrtype"] = $row[20];
		$a_json_row["lbrief"] = $row[21];
		$a_json_row["all_trips"] = $row[14];
		$a_json_row["pict"] = $row[22];
		$a_json_row["all_pict"] = $row[23];
		array_push($a_json, $a_json_row);
	}
	echo  json_encode($a_json);
 ?>
