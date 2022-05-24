<?php
	/**
	* Let the system know this is an RPC call
	*/
	$rpc_call = 1;
	
	require_once('inc/config.php');
	require_once('inc/phph1.php');
	require_once('inc/boot.php');
	
	/** Start debug info display area */
	if($phph1->get_debugstatus()){
		include('inc/debug.php');
	}

	if(!$phph1->chk_access()){
		echo '{"jsonrpc":"2.0","id":1,"errors":{"data":["Access Denied"]}}';
	}else{
		if($phph1->get_currentmethod()){
			include('methods/'.$phph1->get_currentmethod().'.php');
		}else{
			echo '{"jsonrpc":"2.0","id":1,"errors":{"data":["Method not found"]}}';
		}
	}


?>