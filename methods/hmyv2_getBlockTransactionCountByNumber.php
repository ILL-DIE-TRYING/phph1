<h3>Get Block By Block Number ( hmyv2_getBlockByNumber )</h3>
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
if(isset($_GET['blocknum']) && $phph1_boothandle->val_blocknum($_GET['blocknum']) && isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 1;
	// This is the handle that actually gets used in the page
	$phph1 = new phph1($apiaddr,$phph1_debug);
	$phph1->blocknum = $_GET['blocknum'];
	$blocknum = $phph1->blocknum;
}

// unset the boothandle
unset($phph1_boothandle);

// Get the transaction count
if($validinput == 1){
		$hmyv2_getBlockTransactionCountByNumber_data = $phph1->hmyv2_getBlockTransactionCountByNumber($blocknum);
}else{
	$validinput = 0;
	echo "<p>INVALID INPUT</p>";
}

?>

<form method="GET">
	<p><label for="blocknum">Block Number: </label><input type="text" id="blocknum" name="blocknum"  size="60" maxlength="100" value="<?php if(isset($blocknum)){ echo $blocknum; } ?>" /></p>
	
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getBlockTransactionCountByNumber" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>BLOCK TRANSACTION COUNT ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_getBlockTransactionCountByNumber_data);
	echo "</pre>";
	
}
?>

