<?php
/*
Validate the one address
*/
if(isset($_GET['oneaddr']) && $phph1_boothandle->val_oneaddr($_GET['oneaddr']) && isset($_GET['do']) && $_GET['do'] == 1){
	$validaddr = 1;
	// This is the handle that actually gets used in the page
	$phph1 = new phph1($apiaddr,$phph1_debug);
	$phph1->oneaddr = $_GET['oneaddr'];
	$oneaddr = $phph1->oneaddr;
}

// Validate Block Number
if(isset($_GET['blocknum']) && $phph1_boothandle->val_blocknum($_GET['blocknum']) && isset($_GET['do']) && $_GET['do'] == 1){
	$validbn = 1;
	// This is the handle that actually gets used in the page
	$phph1 = new phph1($apiaddr,$phph1_debug);
	$phph1->blocknum = $_GET['blocknum'];
	$blocknum = $phph1->blocknum;
}

if(isset($validaddr) && isset($validbn) && $validaddr == 1 && $validbn == 1){
	$validinput = 1;
}

// unset the boothandle
unset($phph1_boothandle);

// Get the transactions
if($validinput == 1){
	$hmyv2_isBlockSigner_data = $phph1->hmyv2_isBlockSigner($oneaddr,$blocknum);
}elseif(isset($_GET['do']) && $_GET['do'] == 1){
		echo "<p>INVALID INPUT</p>";
}

if($phph1_debug == 1){
	
	echo "<p style='color:blue;'>";
	
	echo "<br />DO WE HAVE VALID INPUT?: ".$validinput."<br />";
	
	echo "</p>";
}


?>

<form method="GET">
	<p><label for="oneaddr">Validator Address: </label><input type="text" id="oneaddr" name="oneaddr"  size="60" maxlength="42" value="<?php if(isset($oneaddr)){ echo $oneaddr; } ?>" /></p>	
	<p><label for="blocknum">Block Number: </label><input type="text" id="blocknum" name="blocknum"  size="60" maxlength="100" value="<?php if(isset($blocknum)){ echo $blocknum; } ?>" /></p>
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_isBlockSigner" />
	
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>IS BLOCK SIGNER ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_isBlockSigner_data);
	echo "</pre>";
	
}
?>

