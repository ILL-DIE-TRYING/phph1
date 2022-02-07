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
	# val_getBlockByNumber($blocknum,$fulltx,$incltx,$inclstaking)
	
	/*
	If fulltx isn't set then we will set it to FALSE by default
	The choices here are 1 (for true) or 0 (for false)
	*/
	if(isset($_GET['fulltx']) && $_GET['fulltx'] == '1'){
		// We have to do this on boolean items to convert the GET data to a PHP boolean value
		$fulltx = filter_var('true', FILTER_VALIDATE_BOOLEAN);
	}else{
		$fulltx = filter_var('false', FILTER_VALIDATE_BOOLEAN);
	}
	
	/*
	If incltx isn't set then we will set it to FALSE by default
	The choices here are TRUE or FALSE
	*/
	if(isset($_GET['incltx']) && $_GET['incltx'] == '1'){
		$incltx = filter_var('true', FILTER_VALIDATE_BOOLEAN);
	}else{
		$incltx = filter_var('false', FILTER_VALIDATE_BOOLEAN);
	}
	
	/*
	If inclstaking isn't set then we will set it to FALSE by default
	The choices here are TRUE or FALSE
	
	I think this is broken on the node side or the wrong information was presented
	*/
	if(isset($_GET['inclstaking']) && $_GET['inclstaking'] == 1){
		$inclstaking = filter_var('true', FILTER_VALIDATE_BOOLEAN);
	}else{
		$inclstaking = filter_var('false', FILTER_VALIDATE_BOOLEAN);
	}
	
	/*
	If withsigners isn't set then we will set it to FALSE by default
	The choices here are TRUE or FALSE
	*/
	if(isset($_GET['withsigners']) && $_GET['withsigners'] == '1'){
		$withsigners = filter_var('true', FILTER_VALIDATE_BOOLEAN);
	}else{
		$withsigners = filter_var('false', FILTER_VALIDATE_BOOLEAN);
	}

	// Validate the input and run our call if the data is good
	if($phph1->val_getBlockByNumber($blocknum,$fulltx,$incltx,$withsigners,$inclstaking)){
		$getBlockByNumber_data = $phph1->hmyv2_getBlockByNumber($blocknum,$fulltx,$incltx,$withsigners,$inclstaking);
	}else{
		$validinput = 0;
		echo '<p class="alert">INVALID INPUT</p>';
	}
}elseif(isset($_GET['do']) && $_GET['do'] == 1){
	$validinput = 0;
	echo "<p class='alert'>INVALID INPUT</p>";
}

if($phph1_debug == 1){
	
	echo "<p style='color:blue;'>";
	
	echo "<br />DO WE HAVE VALID INPUT?: ".$validinput."<br />";
	
	echo "<br />VARIABLE TYPES FOR THIS REQUEST:";
	echo "<br />fulltx: ".gettype($fulltx);
	echo "<br />incltx: ".gettype($incltx);
	echo "<br />inclstaking: ".gettype($inclstaking);
	echo "<br />withsigners: ".gettype($withsigners)."<br />";
	
	echo "<br />VARIABLE VALUES (NOTE: FALSE BOOLEANS WILL SHOW UP EMPTY):";
	echo "<br />fulltx:".$fulltx;
	echo "<br />incltx:".$incltx;
	echo "<br />inclstaking:".$inclstaking;
	echo "<br />withsigners:".$withsigners;
	
	echo "</p>";
}


?>

<form method="GET">
	<p><label for="blocknum">Block Number: </label><input type="text" id="blocknum" name="blocknum"  size="60" maxlength="100" value="<?php if(isset($blocknum)){ echo $blocknum; } ?>" /></p>
	
	<p><label for="fulltx">Show Full Transaction Data:</label>
	<select name="fulltx" id="fulltx" data-bind="booleanValue: state">
		<option value="">--</option>
		<option value=1 <?php if($validinput == 1 && $fulltx == 1){ echo 'selected="selected"'; } ?> >TRUE</option>
		<option value=0 <?php if($validinput == 1 && $fulltx == 0){ echo 'selected="selected"'; } ?> >FALSE</option>
	</select></p>
	
	<p><label for="incltx">Include Regular Transactions (Doesn't do anything?):</label>
	<select name="incltx" id="incltx">
		<option value="">--</option>
		<option value=1 <?php if($validinput == 1 && $incltx == 1){ echo 'selected="selected"'; } ?> >TRUE</option>
		<option value=0 <?php if($validinput == 1 && $incltx == 0){ echo 'selected="selected"'; } ?> >FALSE</option>
	</select></p>
	
	<p><label for="inclstaking">Include Staking Transactions(Doesn't do anything?):</label>
	<select name="inclstaking" id="inclstaking">
		<option value="">--</option>
		<option value=1 <?php if($validinput == 1 && $inclstaking == 1){ echo 'selected="selected"'; } ?> >TRUE</option>
		<option value=0 <?php if($validinput == 1 && $inclstaking == 0){ echo 'selected="selected"'; } ?> >FALSE</option>
	</select></p>
	
	<p><label for="withsigners">Include Signer Addresses:</label>
	<select name="withsigners" id="withsigners">
		<option value="">--</option>
		<option value=1 <?php if($validinput == 1 && $withsigners == 1){ echo 'selected="selected"'; } ?> >TRUE</option>
		<option value=0 <?php if($validinput == 1 && $withsigners == 0){ echo 'selected="selected"'; } ?> >FALSE</option>
	</select></p>
	

	
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getBlockByNumber" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>BLOCK INFORMATION ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($getBlockByNumber_data);
	echo "</pre>";
	
}
?>

