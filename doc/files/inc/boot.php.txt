<?php
/**
* boot.php creates a phph1 class handle and does common validation checks as well as if settings have been changed
* 
* boot.php checks if any settings have been set, and does validation for some commonly used inputs on the method pages:
* ONE address, block number, a second block number, block hash, smart contract address, and epoch
*/

/**
* Check if we are changing the settings 
*
* Validate there is a network for that setting in config.php
* otherwise unset the session to stop from injecting some unknown network
*/ 
	if(isset($_POST['dosettings']) && $_POST['dosettings'] == 1){
		// Make sure the NETWORK setting posted is in our $phph1_apiaddresses array set in config.php
		// Otherwise clear the session data
		if(isset($_POST['network']) && isset($phph1_apiaddresses[$_POST['network']])){
			
			$_SESSION['network'] = $_POST['network'];
			// Make sure the SHARD setting posted is in our $phph1_apiaddresses array set in config.php
			// Otherwise clear the session data
			if(isset($_POST['shard']) && isset($phph1_apiaddresses[$_POST['network']][$_POST['shard']])){
				$_SESSION['shard'] = $_POST['shard'];
			}else{
				session_unset();
			}
		}else{
			session_unset();
		}
	}
	
	// If $_SESSION['network'] and $_SESSION['shard'] is stored
	// Make sure they exist in $phph1_apiaddresses which is set in config.php
	if(isset($_SESSION['network']) && isset($_SESSION['shard']) && isset($phph1_apiaddresses[$_SESSION['network']][$_SESSION['shard']]) && !isset($rpc_call)){
		$phph1 = new phph1($phph1_apiaddresses,$phph1_methods,$phph1_debug,$max_pagesize,$default_pagesize,$_SESSION['network'],$_SESSION['shard']);
	}else{
		$phph1 = new phph1($phph1_apiaddresses,$phph1_methods,$phph1_debug,$max_pagesize,$default_pagesize, $default_network, $default_shard);
		// If this is an RPC call, the session information shouldn't be set
		// $rpc_call is set to 1 in phph1_call.php
		if(isset($rpc_call) && $rpc_call == 1){
			$phph1->rpc_call = 1;
		}else{
			$_SESSION['network'] = $phph1->network;
			$_SESSION['shard'] = $phph1->shard;
		}
	}
	
	// Check if we have a method input and make sure $_GET['method'] is in $phph1_methods in the phph1 class
	// The methods are set in config.php and loaded to the class in boot.php when the class handle is created
	if(isset($phph1->phph1_methods) && isset($_GET['method']) && in_array($_GET['method'], $phph1->phph1_methods)){
		$phph1_method = $_GET['method'];
	}
	
	if(isset($phph1_method)){
		// We start with a default of no input is good input
		// This way we have to explicitely tell it that it is okay to run the calls (security)
		// there are val_ requests at the bottom of the class.
		// NEVER remove/comment this line
		$validinput = 0;
		
		// See if we have submitted a form. 
		// $_GET['do'] will only ever have a single valid setting of 1
		// Otherwise somebody is trying to mess around and we need to kick their whole request immediately
		if(isset($_GET['do']) && $_GET['do'] != 1){ 
			array_push($phph1->errors, 'Invalid Request');
			unset($_GET['do']);
			$validinput = 0;
		
		// If the form has been submitted, validate some common inputs
		}elseif(isset($_GET['do']) && $_GET['do'] == 1){
			// Validate the ONE address if set
			// The ONE address also must not be empty so we don't waste our time here	
			if(isset($_GET['oneaddr']) && !empty($_GET['oneaddr']) && $phph1->val_oneaddr($_GET['oneaddr'])){
				$valid_oneaddr = 1;
				$phph1->oneaddr = $_GET['oneaddr'];
				$oneaddr = $phph1->oneaddr;
			}elseif(isset($_GET['oneaddr'])){
				$validinput = 0;
				$valid_oneaddr = 0;
				array_push($phph1->errors, 'Invalid Wallet Address');
			}			
			
			// Validate the block number if set
			// The block number also must not be empty so we don't waste our time here
			if(isset($_GET['blocknum']) && !empty($_GET['blocknum']) && $phph1->val_blocknum($_GET['blocknum'])){
				$valid_blocknum = 1;
				$phph1->blocknum = $_GET['blocknum'];
				$blocknum = $phph1->blocknum;
			}elseif(isset($_GET['blocknum'])){
				$validinput = 0;
				$valid_blocknum = 0;
				array_push($phph1->errors, 'Invalid Block Number');
			}
			
			
			// Validate the SECOND block number if set
			// The block number must not be empty so we don't waste our time here
			// This one is used in cases where we search between two block numbers	
			if(isset($_GET['blocknum2']) && !empty($_GET['blocknum2']) && $phph1->val_blocknum($_GET['blocknum2'])){
				$valid_blocknum2 = 1;
				$phph1->blocknum2 = $_GET['blocknum2'];
				$blocknum2 = $phph1->blocknum2;
			}elseif(isset($_GET['blocknum2'])){
				$validinput = 0;
				$valid_blocknum2 = 0;
				array_push($phph1->errors, 'Invalid Block Number 2');
			}
			
			// Validate the block hash if set
			// The block hash must not be empty so we don't waste our time here	
			if(isset($_GET['blockhash']) && !empty($_GET['blockhash']) && $phph1->val_blockhash($_GET['blockhash'])){
				$valid_blockhash = 1;
				$phph1->blockhash = $_GET['blockhash'];
				$blockhash = $phph1->blockhash;
			}elseif(isset($_GET['blockhash'])){
				$validinput = 0;
				$valid_blockhash = 0;
				array_push($phph1->errors, 'Invalid Hash');
			}
			
			// Validate the Smart Contract Address if set
			// The Smart Contract Address must not be empty so as to waste our time here	
			if(isset($_GET['scaddress']) && !empty($_GET['scaddress']) && $phph1->val_scaddress($_GET['scaddress'])){
				$valid_scaddress = 1;
				$phph1->scaddress = $_GET['scaddress'];
				$scaddress = $phph1->scaddress;
			}elseif(isset($_GET['scaddress'])){
				$validinput = 0;
				$valid_scaddress = 0;
				array_push($phph1->errors, 'Invalid Smart Contract Address');
			}
			
			// Validate the epoch if set
			// The epoch must not be empty so as to waste our time here	
			if(isset($_GET['epoch']) && !empty($_GET['epoch']) && $phph1->val_epoch($_GET['epoch'])){
				$valid_epoch = 1;
				$phph1->epoch = $_GET['epoch'];
				$epoch = $phph1->epoch;
			}elseif(isset($_GET['epoch'])){
				$validinput = 0;
				$valid_epoch = 0;
				array_push($phph1->errors, 'Invalid Epoch');
			}
		}

	}
?>