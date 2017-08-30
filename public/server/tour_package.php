    <?php
require_once 'fun_connect2.php';
require_once 'JSON.php';
error_reporting(E_ALL);
ini_set('display_errors', 0); 
 
$a_json = array();
$a_json_row = array();


$sql = "SELECT p_name, p_category, p_country, p_p_image From `Tours Packages` ORDER BY package_id Desc";

$rs = mysql_query($sql);
if($rs === false) {
  $user_error = 'Wrong SQL: ' . $sql . 'Error: ' . mysql_errno . ' ' . mysql_error;
  trigger_error($user_error, E_USER_ERROR);
}
 
while($row = mysql_fetch_array($rs)) {
  $a_json['packages'][]=array('package_name' => $row[0], 
  'package_category' =>$row[1],
  'package_country' => $row[2],
  'package_img_sm' => '../admin/p_images/'.$row[3],
  'package_img_lg' => '../admin/f_images/'.$row[3]);
}

if (($a_json != null) && (sizeof($a_json) > 0)) {
		//$arrayData = xmlToArray($a_json);
		$jsonOutput=json_encode($a_json);	
	}
		echo $jsonOutput;

    ?>

