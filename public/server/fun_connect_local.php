<?php
	error_reporting (E_ALL ^ E_NOTICE);
	$phpver = phpversion();
	$phpver = explode(".", $phpver);
	$phpver = "$phpver[0]$phpver[1]";
	if ($phpver != 41) {
		$PHP_SELF = $_SERVER['PHP_SELF'];
	}
	if (!ini_get("register_globals")) {
		extract($_REQUEST, EXTR_PREFIX_ALL|EXTR_REFS, 'REQ');
	}
	$host = "173.254.2.163:3306;";
	$username = "getcentr_grand";
	$password = "Autonimrod1@";
	$database = "getcentr_getcentre";
	$db = new mysqli($host, $username, $password, $database);
	
?>