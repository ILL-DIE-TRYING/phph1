<?php
// Validate Block Hash
if(isset($_GET['blockhash']) && $phph1_boothandle->val_blockhash($_GET['blockhash']) && isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 1;
	// This is the handle that actually gets used in the page
	$phph1 = new phph1($apiaddr,$phph1_debug);
	$phph1->blockhash = $_GET['blockhash'];
	$blockhash = $phph1->blockhash;
}

// unset the boothandle
unset($phph1_boothandle);

// Get the transactions
if($validinput == 1){

	// Validate the input and run our call if the data is good
	if($phph1->hmyv2_getStakingTransactionByHash($blockhash)){
		$hmyv2_getStakingTransactionByHash_data = $phph1->hmyv2_getStakingTransactionByHash($blockhash);
	}else{
		$validinput = 0;
		echo "<p>INVALID INPUT</p>";
	}
}

?>

<form method="GET">
	<p><label for="blockhash">Block Hash: </label><input type="text" id="blockhash" name="blockhash"  size="60" maxlength="100" value="<?php if(isset($blockhash)){ echo $blockhash; } ?>" /></p>
	
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getStakingTransactionByHash" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>GET STAKING TRANSACTION BY HASH ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_getStakingTransactionByHash_data);
	echo "</pre>";
	
}
?>

