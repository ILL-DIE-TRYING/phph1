<!doctype html>
<html lang="us">
<head>
<meta charset="utf-8">
<title>PHPH1 :: A Harmony ONE Node API PHP Class</title>
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

<div id="wrapper">
	
<?php 
	
	session_start();
	require_once('inc/config.php');
	require_once('inc/phph1.php');
	require_once('inc/boot.php');
	require_once('inc/index_top.php'); 
?>
</div>

<div id="bodyWrap">
<?php

if(isset($phph1_method)){
	include('methods/'.$phph1_method.'.php');
}else{
	require_once('inc/index_body.php');
}	

?>
</div>

<script src="js/phph1.js"></script>
<?php

?>
</body>
</html>