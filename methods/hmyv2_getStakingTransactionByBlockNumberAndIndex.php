<?php
// Validate Block Number
if(isset($_GET['blocknum']) && $phph1_boothandle->val_blocknum($_GET['blocknum']) && isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 1;
	// This is the handle that actually gets used in the page
	$phph1 = new phph1($apiaddr,$phph1_debug);
	$phph1->blocknum = $_GET['blocknum'];
	$blocknum = $phph1->blocknum;
}


// unset the boothandle
unset($phph1_boothandle);

// Get the transactions
if($validinput == 1){
	/*
	If txindex isn't set then we will set it to 0 by default
	*/
	if(isset($_GET['txindex']) && !empty($_GET['txindex'])){
		// We have to do this on boolean items to convert the GET data to a PHP boolean value
		$txindex = $_GET['txindex'];
	}else{
		$txindex = 0;
	}
	
	// Validate the input and run our call if the data is good
	if($phph1->val_getTransactionByBlockNumberAndIndex($blocknum,$txindex)){
		$hmyv2_getStakingTransactionByBlockNumberAndIndex_data = $phph1->hmyv2_getStakingTransactionByBlockNumberAndIndex($blocknum,$txindex);
	}else{
		$validinput = 0;
		echo "<p>INVALID INPUT</p>";
	}
}

if($phph1_debug == 1){
	
	echo "<p style='color:blue;'>";
	
	echo "<br />DO WE HAVE VALID INPUT?: ".$validinput."<br />";
	
	echo "</p>";
}


?>

<form method="GET">
	<p><label for="blocknum">Block Number: </label><input type="text" id="blocknum" name="blocknum"  size="60" maxlength="100" value="<?php if(isset($blocknum)){ echo $blocknum; } ?>" /></p>
	<p><label for="txindex">Transaction Index: </label><input type="text" id="txindex" name="txindex"  size="20" maxlength="20" value="<?php if(isset($txindex)){ echo $txindex; } ?>" /></p>
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getStakingTransactionByBlockNumberAndIndex" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>TRANSACTION ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_getStakingTransactionByBlockNumberAndIndex_data);
	echo "</pre>";
	
}
?>

