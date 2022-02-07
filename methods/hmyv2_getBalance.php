<?php
/*
We start with a default of no input is good input
This way we have to explicitely tell it that it is okay to run the calls (security)
there are val_ requests at the bottom of the class.
NEVER remove/comment this line
ALWAYS wrap your output code in this: if($validoutput ==1){   YOURCODEGOESHERE   };
*/
$validinput = 0;

$phph1 = new phph1($apiaddr, $phph1_debug);

// Check what core information we have. Validate it and set it
// This one validates the ONE address
// These items could probably be put in an include to keep this page shorter
if(isset($_GET['oneaddr']) && $phph1->val_oneaddr($_GET['oneaddr']) && isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 1;
	$phph1->oneaddr = $_GET['oneaddr'];
	$oneaddr = $phph1->oneaddr;
}

// GET THE BALANCE
if($validinput == 1){
	$hmyv2_getBalance_data = $phph1->hmyv2_getBalance($oneaddr);
}elseif(isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 0;
	echo "<p class='alert'>INVALID INPUT</p>";
}

?>
<!-- FORM -->
<form method="GET">
	<p><label for="oneaddr">Wallet Address: </label><input type="text" id="oneaddr" name="oneaddr"  size="60" maxlength="42" value="<?php if(isset($oneaddr)){ echo $oneaddr; } ?>" /></p>	
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getBalance" />
	<input type='submit' name='Submit' /></p>
</form>
<br />
<?php

// DEBUGGING OUTPUT
if($phph1_debug == 1){
	echo "<h3 style='color:red;'>DEBUGGING OUTPUT</h3>";
	echo "<pre style='color:blue;'><br />GET DATA:<br />";
	htmlentities(print_r($_GET));
	echo "<br /></pre>";
}

// SHOW THE RESULTS IF WE HAVE VALID INPUT
if($validinput == 1){
	
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>Harmony Node JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_getBalance_data);
	echo "</pre>";
	
}
?>

