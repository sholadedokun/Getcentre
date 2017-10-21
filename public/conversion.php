<?php
error_reporting(E_ALL);
	ini_set('display_errors', 1);
	// require_once 'server/fun_connect2.php';
	require_once 'server/getConversionRate.php';
	if(isset($_GET['UpdateB'])){
		$t=time();
		$sqlu="Insert into fxchange values ( NULL, '".$_GET['USD']."','".$_GET['GBP']."', '".$_GET['EUR']."', '".$t."')";
		$rsu=mysql_query($sqlu) or die ("Error : could not Update FXUpdate" . mysql_error());
		if($rsu){$updated="Conversion rate was successfully Updated.";}
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FX Update</title>
</head>

<body>
	<div class="" style="margin:10% 0 0 40%; width:300px; height:auto; border:2px solid #aaa">
    		<?php if (isset($updated)){?><div style="padding:10px"> <?php echo $updated; ?> </div> <?php } ?>


    	<form action="http://getcentre.com/conversion.php" method="get" >
        	<div class="" style="padding:5px 15px; background:#ccc; color:#555"><h2>Update Exchange Rate</h2></div>
        	<div class="" style="padding:10px; background:#eee; color:#555">
            	<div><b>Dollar $ (USD)</b></div>
                <span><input type="text" name="USD" value="<?php echo $info[1] ?>" /></span>
            </div>
            <div class="" style="padding:10px; background:#bbb; color:#555">
            	<div><b>Pounds &pound; (GBP)</b></div>
                <span><input type="text" name="GBP" value="<?php echo $info[2] ?>" /></span>
            </div>
            <div class="" style="padding:10px; background:#eee; color:#555">
            	<div><b>Euro &euro; (EUR)</b></div>
                <span><input type="text" name="EUR" value="<?php echo $info[3] ?>" /></span>
            </div>
            <div  style="padding:10px; " ><input type="submit" value="Update" name="UpdateB" /></div>
        </form>
        <div  style="padding:10px;"><b>Last Updated :</b>  <?php echo gmdate("F j, Y, g:i a", $info[4]); ?></div>
    </div>
</body>
</html>
