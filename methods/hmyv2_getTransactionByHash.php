<?php

// Validate Block Number
if(isset($_GET['hash']) && $phph1_boothandle->val_hash($_GET['hash']) && isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 1;
	// This is the handle that actually gets used in the page
	$phph1 = new phph1($apiaddr,$phph1_debug);
	$phph1->hash = $_GET['hash'];
	$hash = $phph1->hash;
}

// unset the boothandle
unset($phph1_boothandle);

// Get the transactions
if($validinput == 1){
	$hmyv2_getTransactionByHash_data = $phph1->hmyv2_getTransactionByHash($hash);
}elseif(isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 0;
	echo "<p>INVALID INPUT</p>";
}

if($phph1_debug == 1){
	
	echo "<p style='color:blue;'>";
	
	echo "<br />DO WE HAVE VALID INPUT?: ".$validinput."<br />";
	
	echo "</p>";
}


?>

<form method="GET">
	<p><label for="hash">Hash: </label><input type="text" id="hash" name="hash"  size="60" maxlength="100" value="<?php if(isset($hash)){ echo $hash; } ?>" /></p>

	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getTransactionByHash" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>TRANSACTION INFORMATION ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_getTransactionByHash_data);
	echo "</pre>";
	
}
?>

