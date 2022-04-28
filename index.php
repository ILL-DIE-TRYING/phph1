<?php
/**
* PHPH1 Explorer index.php
*/

// This code is to measure the load time of pages and plave it in the footer, do not remove it
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$phph1_start = $time;
unset($time);

session_start();
require_once('inc/config.php');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>PHPH1 :: <?php if(isset($_GET['method']) && in_array($_GET['method'],$phph1_methods)){ echo $_GET['method']; }else{ echo "A Harmony ONE Node API PHP Class"; } ?></title>
<meta name="keywords" content="PHPH1, Harmony, ONE, Blockchain, Crypto, Currency, Explorer, PHP Class, Harmony Node API">
<meta name="description" content="PHPH1 is a PHP class that bridges the Harmony ONE Node API to PHP. Through this, many scripting languages will be able to query the PHP class. The class is designed to validate, insure the request data is in the right format, and return information saving web developers from having to write the code themselves.">
<meta name="author" content="Jason L Kolpin">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/phph1.css">
<link rel="stylesheet" href="css/phph1_mobile.css">
<!--
<link rel="stylesheet" href="phph1_desktop.css">

<link rel="stylesheet" href="phph1_landscape.css">
-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

	<button onclick="flyToTop()" id="toTopBtn" title="Back To Top"><img src="./img/topBtn.png" class="topBtnImg" alt="Back To Top Button Image"/></button>

	<div id="wrapper">
		<?php

// Include the PHPH1 class file. (Required)
		require_once('inc/phph1.php');
		
// Include the boot.php file. (Required)
		require_once('inc/boot.php');
		
// index_top.php is only required if you are using the API Explorer interface
		require_once('inc/index_top.php'); 
		?>
	</div>

	<div id="bodyWrap">
		<?php
		
		/** Show the standard debugging info */
		if($phph1->get_debugstatus()){
			include('inc/debug.php');
		}

// Check if we have a method request and include the method file. (required)
// Otherwise, show the home page 
// $php_method is set in boot.php
		if(!empty($phph1->get_currentmethod()) && $phph1->chk_access()){
			require_once('methods/'.$phph1->get_currentmethod().'.php');
		}else{
			if(!$phph1->chk_access()){
				array_push($boot_errors, "ACCESS DENIED: ".$_SERVER['REMOTE_ADDR']);
				$phph1->set_booterrors($boot_errors);
			}
			require_once('inc/index_body.php');
		}

// Include the footer (required for API Explorer only)
		require_once('inc/footer.php');

		?>
	</div>
	
	<!--
	Include the PHPH1 javascript (required for API Explorer only)
	-->
	<script src="js/phph1.js"></script>

</body>
</html>