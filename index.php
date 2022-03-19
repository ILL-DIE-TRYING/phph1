<?php
session_start();
require_once('inc/config.php');
?>
<!doctype html>
<html lang="us">
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

	<button onclick="flyToTop()" id="toTopBtn" title="Back To Top">Back To Top</button>

	<div id="wrapper">
		<?php
		/**
		* Include the class
		*/
		require_once('inc/phph1.php');
		
		/**
		* Include the boot script. This invokes PHPH1 class
		* and checks if we have any input for the explorer
		*/
		require_once('inc/boot.php');
		
		/**
		* Include index_top which handles the menu and such
		* Turned into an include for easier editing
		*/
		require_once('inc/index_top.php'); 
		?>
	</div>

	<div id="bodyWrap">
		<?php
		/**
		* Check is we have a method request
		* Otherwise, show the home page
		*/
		if(isset($phph1_method)){
			include('methods/'.$phph1_method.'.php');
		}else{
			require_once('inc/index_body.php');
		}	

		/**
		* Include the footer on every page
		*/
		require_once('inc/footer.php');

		?>
	</div>
	
	<!--
	Include the PHPH1 javascript
	-->
	<script src="js/phph1.js"></script>

</body>
</html>