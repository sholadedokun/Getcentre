  <?php
 	include('../server/fun_connect2.php');
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	$a_json = array();
	$a_json_row = array();
	$querys= "SELECT * FROM `email_subscriber` where `sub_email`='".$_GET['sub_email']."'";
	$res_get=mysql_query($querys);
	$pre=mysql_num_rows($res_get);
	if($pre>0){
		echo 'Your Email is already subscribed. Please add another email';
	}
	else{
		$t=time();
		$sql="insert into `email_subscriber` values( NULL,'".mysql_real_escape_string($_GET['sub_email'])."',$t)";
		$res=mysql_query($sql);
		if($res){echo 'Thanks for subscribing, your email has been added to our database';}
	}
	
 ?>