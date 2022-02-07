<?php

// Check what core information we have. Validate it and set it
// This one validates the ONE address
// These items could probably be put in an include to keep this page shorter
if(isset($_GET['oneaddr']) && $phph1_boothandle->val_oneaddr($_GET['oneaddr']) && isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 1;
	// This is the handle that actually gets used in the page
	$phph1 = new phph1($apiaddr,$phph1_debug);
	$phph1->oneaddr = $_GET['oneaddr'];
	$oneaddr = $phph1->oneaddr;
}

// unset the boothandle
unset($phph1_boothandle);

// Get the transactions
if($validinput == 1){
	$hmyv2_getDelegationsByDelegator_data = $phph1->hmyv2_getDelegationsByDelegator($oneaddr);
}elseif(isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 0;
	echo "<p>INVALID INPUT</p>";
}
?>

<form method="GET">
	<p><label for="oneaddr">Validator Address: </label>
	<input type="text" id="oneaddr" name="oneaddr"  size="60" maxlength="42" value="<?php if(isset($oneaddr)){ echo $oneaddr; } ?>" />
	</p>
	
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getDelegationsByDelegator" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){

	// You can view the raw array here
	echo "<h2>GET DELEGATIONS BY DELEGATOR ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_getDelegationsByDelegator_data);
	echo "</pre>";
	
}
?>

