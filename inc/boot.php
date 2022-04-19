<?php
/**
* boot.php creates a phph1 class handle and does common validation checks as well as if settings have been changed
* 
* boot.php checks if any settings have been set, and does validation for some commonly used inputs on the method pages:
* ONE address, block number, a second block number, block hash, smart contract address, and epoch
*/
	
	// Set an empty array for boot errors that we can inject into the error system later after we have a class handle
	$boot_errors = [];

	/**
	* Check if we are changing the settings 
	*
	* Validate there is a network for that setting in config.php
	* otherwise unset the session to stop from injecting some unknown network
	*/ 
	if(isset($_POST['dosettings']) && $_POST['dosettings'] == 1){
		// Make sure the NETWORK setting posted is in our $phph1_apiaddresses array set in config.php
		// and set the session data accordingly so the settings stick between requests
		// This is the only factoring that should be done outside of the class because there is no class handle yet
		if(isset($phph1_apiaddresses[$_POST['network']])){
			$_SESSION['network'] = $_POST['network'];
			// Make sure the SHARD setting posted is in our $phph1_apiaddresses array set in config.php
			// Otherwise clear the session data
			if(isset($phph1_apiaddresses[$_POST['network']][$_POST['shard']])){
				$_SESSION['shard'] = $_POST['shard'];
			}else{
				session_unset();
				array_push($boot_errors, 'Invalid shard ID value, reverting settings to default: <strong>'.$default_network." shard ".$default_shard."</strong>"); 
			}
		}else{
			session_unset();
			array_push($boot_errors, 'Invalid network value, reverting settings to default: <strong>'.$default_network." shard ".$default_shard."</strong>");
		}
	}
	
	// If $_SESSION['network'] and $_SESSION['shard'] is stored
	// Make sure they exist in $phph1_apiaddresses which is set in config.php
	// IF $_SESSION['network'] and $_SESSION['shard'] are not valid, use the $default_network and $default_shard variables from config.php
	// $rpc_call is set at the top of phph1_call.php in order to not use $_SESSION[] and use the $default_network and $default_shard variables from config.php
	// This keeps things safe from clients injection bad RPC nodes and trying to do nasty things
	if(isset($_SESSION['network']) && isset($_SESSION['shard']) && isset($phph1_apiaddresses[$_SESSION['network']][$_SESSION['shard']]) && !isset($rpc_call)){
		// Fire up our class handle
		$phph1 = new phph1($phph1_apiaddresses,$phph1_methods,$phph1_debug,$max_pagesize,$default_pagesize,$_SESSION['network'],$_SESSION['shard']);
	}else{
		$phph1 = new phph1($phph1_apiaddresses,$phph1_methods,$phph1_debug,$max_pagesize,$default_pagesize, $default_network, $default_shard);
		// If this is an RPC call, the session information shouldn't be set
		// $rpc_call is set to 1 in phph1_call.php
		// Otherwise set the user session variables for network and shard so the user keeps the settings across requests
		if(isset($rpc_call) && $rpc_call == 1){
			$phph1->set_rpc(1);
		}else{
			$_SESSION['network'] = $default_network;
			$_SESSION['shard'] = $default_shard;
		}
	}
	
	// Inject our boot errors to the class error array if there are any
	if(!empty($boot_errors)){
		$phph1->set_booterrors($boot_errors);
	}
	
	// Check if we have a method input and make sure $_GET['method'] is in $phph1_methods array in the phph1 class
	// The methods array is set in config.php and loaded to the class in boot.php when the class handle is created
	$phph1->chk_request();
?>