<?php
  require_once 'fun_connect2.php';
  $sql='Select * from fxchange order by fx_id Desc limit 1';
	$rs=mysql_query($sql) or die ("Error : could not Fetch FXUpdate ".mysql_error());
	$info=mysql_fetch_assoc($rs);
  if(isset($_GET['fetcher'])){
    $jsonOutput = json_encode($info);
    echo $jsonOutput;
  }

?>
