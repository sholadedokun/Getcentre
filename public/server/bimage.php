<?php
header('Access-Control-Allow-Origin: *');
$host = "localhost";
	$username = "getcentr_grand";
	$password = "Autonimrod1@";
	$database = "getcentr_wo6110";
	@ mysql_pconnect($host,$username,$password);
	$connection=mysql_select_db($database);
$a_json = array();
$a_json_row = array();
$sql = "SELECT `meta_value` FROM `wp_jwix_postmeta` where `meta_key`='_wp_attached_file' and `post_id`=(Select `meta_value` from `wp_jwix_postmeta` where `meta_key`='_thumbnail_id' and `post_id`=".$_GET['blog_code'].")";
//echo $sql;
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)) {
	$hdet->det='http://i2.wp.com/blog.getcentre.com/wp-content/uploads/'.$row[0];
	echo json_encode($hdet);
}
?>
