<?php

/*
Validate the one address
*/
if(isset($_GET['epoch']) && $phph1->val_epoch($_GET['epoch']) && isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 1;
	// This is the handle that actually gets used in the page
	$phph1 = new phph1($apiaddr,$phph1_debug);
	$epoch = $_GET['epoch'];
}


// unset the boothandle
unset($phph1_boothandle);

// Get the transactions
if($validinput == 1){
	$hmyv2_getValidators_data = $phph1->hmyv2_getValidators($epoch);
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
	<p><label for="epoch">Epoch: </label><input type="text" id="epoch" name="epoch"  size="60" maxlength="42" value="<?php if(isset($epoch)){ echo $epoch; } ?>" /></p>	
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getValidators" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>VALIDATORS ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_getValidators_data);
	echo "</pre>";
	
}
?>

