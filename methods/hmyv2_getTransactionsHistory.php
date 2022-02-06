<h3>Get Wallet Transactions History ( hmyv2_getTransactionsHistory )</h3>

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
	
	/*
	Once again, this list could go into a separate include
	to keep this page clean
	*/
	
	if(isset($_GET['pagenum']) && !empty($_GET['pagenum'])){
		$pagenum = $_GET['pagenum'];
	}else{
		$pagenum = 1;
	}
	
	if(isset($_GET['pagesize']) && !empty($_GET['pagesize']) && $_GET['pagesize'] <= $max_pagesize){
		$pagesize = $_GET['pagesize'];
	}else{
		$pagesize = $def_pagesize;
	}

	/*
	If txtype isn't set then we will set it to grab all transactions
	The choices here are "ALL", "RECEIVED", or "SENT"
	*/
	
	if(isset($_GET['txtype']) && !empty($_GET['txtype'])){
		$txtype = $_GET['txtype'];
	}else{
		$txtype = 'ALL';
	}
	
	/*
	If order isn't set then we will set it to descending by default
	The choices here are "ALL", "RECEIVED", or "SENT"
	*/
	if(isset($_GET['order']) && !empty($_GET['order'])){
		$order = $_GET['order'];
	}else{
		$order = 'DESC';
	}
	
	/*
	If fulltx isn't set then we will set it to FALSE by default
	The choices here are TRUE or FALSE
	*/
	if(isset($_GET['fulltx']) && !empty($_GET['fulltx'])){
		$fulltx = $_GET['fulltx'];
	}else{
		$fulltx = "false";
	}

	// Validate the input and run our call if the data is good
	if($phph1->val_getTransactionsHistory($oneaddr,$pagenum,$pagesize,$fulltx,$txtype,$order)){
		$getTransactionsHistory_transactions = $phph1->hmyv2_getTransactionsHistory($oneaddr,$pagenum,$pagesize,$fulltx,$txtype,$order);
		$mytransactioncount = $phph1->hmyv2_getTransactionsCount($oneaddr,$txtype);
		#print_r($mytransactioncount);
		$trcount = $mytransactioncount['result'];
		$trpages = ceil($trcount / $pagesize);
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
	
	<p><label for="pagesize">Results Per Page:</label>
	<select name="pagesize" id="pagesize">
		<option value="">--</option>
		<option value="10" <?php if($validinput == 1 && $pagesize == 10){ echo 'selected="selected"'; } ?> >10</option>
		<option value="20" <?php if($validinput == 1 && $pagesize == 20){ echo 'selected="selected"'; } ?> >20</option>
	</select></p>
	
	<p><label for="txtype">Transaction Type:</label>
	<select name="txtype" id="txtype">
		<option value="">--</option>
		<option value="ALL" <?php if($validinput == 1 && $txtype == 'ALL'){ echo 'selected="selected"'; } ?> >ALL</option>
		<option value="SENT" <?php if($validinput == 1 && $txtype == 'SENT'){ echo 'selected="selected"'; } ?> >SENT</option>
		<option value="RECEIVED" <?php if($validinput == 1 && $txtype == 'RECEIVED'){ echo 'selected="selected"'; } ?> >RECEIVED</option>
	</select></p>
	
	<p><label for="order">Order (by date):</label>
	<select name="order" id="order">
		<option value="">--</option>
		<option value="ASC" <?php if($validinput == 1 && $order == 'ASC'){ echo 'selected="selected"'; } ?> >ASCENDING</option>
		<option value="DESC" <?php if($validinput == 1 && $order == 'DESC'){ echo 'selected="selected"'; } ?> >DESCENDING</option>
	</select></p>
	
	<p><label for="fulltx">Get Full Transaction Data:</label>
	<select name="fulltx" id="fulltx">
		<option value="">--</option>
		<option value="true" <?php if($validinput == 1 && $fulltx == 'true'){ echo 'selected="selected"'; } ?> >TRUE</option>
		<option value="false" <?php if($validinput == 1 && $fulltx == 'false'){ echo 'selected="selected"'; } ?> >FALSE</option>
	</select></p>
	
	<p><input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getTransactionsHistory" />
	<input type='submit' name='Submit' /></p>
</form>

<br />

<?php
if($validinput == 1){
	echo "<h2>Total Number Of Transactions: ".$trcount."</h2>";
	echo "<h2>Total Number Of Pages Available: ".$trpages."</h2>";
	
	// You can view the raw array here
	echo "<h2>TRANSACTIONS ARRAY FOR CURRENT PAGE</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($getTransactionsHistory_transactions);
	echo "</pre>";
	
}
?>

