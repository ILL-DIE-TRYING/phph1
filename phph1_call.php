<?php
	/**
	* Let the system know this is an RPC call
	*/
	$rpc_call = 1;
	
	require_once('inc/config.php');
	require_once('inc/phph1.php');
	require_once('inc/boot.php');


	if(isset($phph1_method)){
		include('methods/'.$phph1_method.'.php');
	}else{
		echo "No Method Defined";
	}

?>