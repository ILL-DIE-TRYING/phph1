<?php
/*
We start with a default of no input is good input
This way we have to explicitely tell it that it is okay to run the calls (security)
there are val_ requests at the bottom of the class.
NEVER remove/comment this line
ALWAYS wrap your output code in this: if($validoutput ==1){   YOURCODEGOESHERE   };
*/
$validinput = 0;

require_once('config.php');
require_once('phph1.php');

$phph1 = new phph1($apiaddr, $phph1_debug);

/*
Validate the one address
*/
if(isset($_GET['oneaddr']) && $phph1->val_oneaddr($_GET['oneaddr']) && isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 1;
	$phph1->oneaddr = $_GET['oneaddr'];
	$oneaddr = $phph1->oneaddr;
}

/*
This handle is temporary and is used to validate
the variables for the $phph1 handle to successfully and safely load
it will get destroyed once we have the real handle
*/
$phph1_boothandle = new phph1($apiaddr,$phph1_debug);


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
	
	// Validate the input and run our call if the data is good
	if($phph1->hmyv2_getValidatorInformation($oneaddr)){
		$hmyv2_getValidatorInformation_data = $phph1->hmyv2_getValidatorInformation($oneaddr);
	}else{
		$validinput = 0;
		echo "<p>INVALID INPUT</p>";
	}
}
?>

<form method="GET">
	<p><label for="oneaddr">Wallet Address: </label>
	<input type="text" id="oneaddr" name="oneaddr"  size="60" maxlength="42" value="<?php if(isset($oneaddr)){ echo $oneaddr; } ?>" />
	</p>
	
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getValidatorInformation" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>VALIDATOR INFORMATION ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_getValidatorInformation_data);
	echo "</pre>";
	
}
?>

