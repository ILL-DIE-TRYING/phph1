<h3>Get Wallet Balance ( hmyv2_getBalance )</h3>
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
This handle is temporary and is used to validate
the variables for the $phph1 handle to successfully and safely load
it will get destroyed once we have the real handle
*/
$phph1_boothandle = new phph1($apiaddr,$phph1_debug);


// Show the raw GET request BE CAREFULL!
// IF DEBUGGING IS TURNED ON IN PRODUCTION 
// AN ATTACKER COULD POTENTIALLY INJECT CODE INTO THE PAGE
if($phph1_debug == 1){
	echo "<pre style='color:blue;'><br />GET DATA:<br />";
	print_r($_GET);
	echo "<br /></pre>";
}


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
	if($phph1->hmyv2_getBalance($oneaddr)){
		$hmyv2_getBalance_data = $phph1->hmyv2_getBalance($oneaddr);
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
	<p><label for="oneaddr">Wallet Address: </label><input type="text" id="oneaddr" name="oneaddr"  size="60" maxlength="42" value="<?php if(isset($oneaddr)){ echo $oneaddr; } ?>" /></p>	
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getBalance" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>WALLET BALANCE ARRAY</h2>";
	echo "<pre>";
	print_r($hmyv2_getBalance_data);
	echo "</pre>";
	
}
?>

