<?php
if(isset($valid_oneaddr) && $valid_oneaddr == 1){
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
	}

	/**
	* If txtype isn't set then we will set it to grab all transactions
	* The choices here are "ALL", "RECEIVED", or "SENT"
	*/
	if(isset($_GET['txtype']) && !empty($_GET['txtype'])){
		$txtype = htmlentities($_GET['txtype']);
	}else{
		$txtype = 'ALL';
	}

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getTransactionCount($oneaddr,$txtype)){
		$validinput = 1;
		$hmyv2_data = $phph1->hmyv2_getTransactionsCount($oneaddr,$txtype);
	}else{
		$validinput = 0;
	}
	
	/**
	* End debug info display area
	*/
	if($phph1->phph1_debug == 1){
			echo "<p class='hmyv2_debug_notify'>### END DEBUGGING INFORMATION ###</p>";
	}
	
	/**
	* Show our errors if we have them
	*/
	if ($validinput == 0){
		echo '<div class="error_div">';
		echo '<p class="hmyv2_errors">Error:';
		$errnum = 1;
		foreach($phph1->errors as $anerror){
			if($errnum == 1){
				echo ' <span class="hmyv2_error">'.$anerror.'</span>';
				$errnum=0;
			}else{
				echo '<span class="hmyv2_error">, '.$anerror.'</span>';
			}
		}
		echo '</p></div>';
	}
/**
* Show our errors if we have them
*/
}elseif(isset($_GET['do'])){
		echo '<div class="error_div">';
		echo '<p class="hmyv2_errors">Error:';
		$errnum = 1;
		foreach($phph1->errors as $anerror){
			if($errnum == 1){
				echo ' <span class="hmyv2_error">'.$anerror.'</span>';
				$errnum=0;
			}else{
				echo '<span class="hmyv2_error">, '.$anerror.'</span>';
			}
		}
		echo '</p></div>';
}

/**
* Check if this is a RPC call
* If not show the html output of the method explorer
*/
if($phph1->rpc_call != 1){

?>
	
	<div class="info_container" >
		<div class="infoRow">
			<button type="button" class="collapsibleInfo"><?=$phph1_method?> :: Params/Returns</button>
			<div id="infoContent" class="infoContent">
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>address</span> - <span >String</span> :</div>
					<div class="iodefWrap">Wallet address</div></li>
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >txType</span> - <span >String</span>:</div>
					<div class="iodefWrap">Optional, which type of transactions to display ("ALL", "RECEIVED", or "SENT"), default "ALL"</div></li>
					
				</ul>
				
				<h3>Returns</h3>
				<ul class="infoObjects">
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span></div>
					<div class="iodefWrap">Number of transactions</div></li>
				</ul>

			</div>
		</div>
	</div>


	<div class="form_container">
		<div id="formcontent">
		<form method="get">
			<div class="row">
				<div class="col-25">
					<label for="oneaddr">Wallet Address: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="oneaddr" name="oneaddr" maxlength="42" value="<?php if(isset($oneaddr)){ echo $oneaddr; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="txtype">Transaction Type:</label>
				</div><div class="col-75">
					<select name="txtype" id="txtype">
						<option value="ALL" <?php if($validinput == 1 && $txtype == 'ALL'){ echo 'selected="selected"'; }elseif(!isset($txtype)){ echo 'selected="selected"'; } ?> >ALL</option>
						<option value="SENT" <?php if($validinput == 1 && $txtype == 'SENT'){ echo 'selected="selected"'; } ?> >SENT</option>
						<option value="RECEIVED" <?php if($validinput == 1 && $txtype == 'RECEIVED'){ echo 'selected="selected"'; } ?> >RECEIVED</option>
					</select>
				</div>
			</div>
			
			<div class="row">
				<input type="hidden" id="do" name="do" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_getTransactionsCount" />
				<input type='submit' name='Submit' class="form_submit" />
			</div>
			
			</form>
		</div>
	</div>
<br />

<?php
/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>

