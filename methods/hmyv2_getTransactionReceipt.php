<h3>Get Transaction Receipt ( hmyv2_getTransactionReceipt )</h3>
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
	$hmyv2_getTransactionReceipt_data = $phph1->hmyv2_getTransactionReceipt($hash);
}else{
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
	<input type="hidden" id="method" name="method" value="hmyv2_getTransactionReceipt" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>TRANSACTION RECEIPT ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_getTransactionReceipt_data);
	echo "</pre>";
	
}
?>

