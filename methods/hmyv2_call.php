<?php
// Get the transactions
if(isset($valid_oneaddr) && $valid_oneaddr == 1 && isset($valid_blocknum) && $valid_blocknum == 1){
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
	}

	/**
	* Prepare from for validation
	*/
	if(isset($_GET['from'])&& !empty($_GET['from']) && $phph1->val_oneaddr($_GET['from'])){
		$from = $_GET['from'];
	}else{
		$from = 1;
	}
	
	/**
	* Prepare gas for validation
	*/
	if(isset($_GET['gas'])&& !empty($_GET['gas'])){
		$gas = $_GET['gas'];
	}else{
		$gas = null;
	}

	/**
	* Prepare gasprice for validation
	*/
	
	if(isset($_GET['gasprice']) && !empty($_GET['gasprice'])){
		$gasprice = $_GET['gasprice'];
	}else{
		$gasprice = null;
	}
	
	/**
	* Prepare value for validation
	*/
	if(isset($_GET['value']) && !empty($_GET['value'])){
		$value = htmlentities($_GET['value']);
	}else{
		$value = null;
	}
	
	/**
	* Prepare data for validation
	*/
	if(isset($_GET['data']) && !empty($_GET['data'])){
		$data = $_GET['data'];
	}else{
		$data = null;
	}
	

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_call($php1->oneaddr, $from, $gas, $gasprice, $value, $data, $blocknum)){
		$validinput = 1;
		$hmyv2_data = $phph1->hmyv2_call($php1->oneaddr, $from, $gas, $gasprice, $value, $data, $blocknum);
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
				
					<li class="infoObjectNoBul"><h4><span>Object</span> - Transaction history args</h4></li>
					
					<li><div class="ioobjectWrap"><span>address</span> - <span >String</span> :</div>
					<div class="iodefWrap">Wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span >pageIndex</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Optional, which page of transactions to return, default 0</div></li>
					
					<li><div class="ioobjectWrap"><span >pageSize</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Optional, how many transactions to display per page, default 1000</div></li>
					
					<li><div class="ioobjectWrap"><span >fullTx</span> - <span >Bool</span> :</div>
					<div class="iodefWrap">Optional, return full transaction data or just transaction hashes, default false</div></li>
					
					<li><div class="ioobjectWrap"><span >txType</span> - <span >String</span>:</div>
					<div class="iodefWrap">Optional, which type of transactions to display ("ALL", "RECEIVED", or "SENT"), default "ALL"</div></li>
					
					<li><div class="ioobjectWrap"><span >order</span> - <span >String</span>:</div>
					<div class="iodefWrap">Optional, sort transactions in ascending or descending order based on timestamp ("ASC" or "DESC"), default "ASC"</div></li>
					
				</ul>
				
				<h3>Returns</h3>
				<h4>If <span >fullTx</span> is <span >true</span></h4>
				<h4 class="infoHeader"><span >Array</span> of <span >Object</span></h4>
				<ul class="infoObjects">
					<li><div class="ioobjectWrap"><span >blockHash</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Block hash that transaction was finalized. null if the transaction is pending.</div></li>
					
					<li><div class="ioobjectWrap"><span >blockNumber</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Block number that transaction was finalized. null if the transaction is pending.</div></li>
					
					<li><div class="ioobjectWrap"><span >from</span> - <span >String</span>:</div>
					<div class="iodefWrap">Wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span >timestamp</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Timestamp in Unix time when transaction was finalized</div></li>
					
					<li><div class="ioobjectWrap"><span >gas</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Gas limit in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span >gasPrice</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Gas price in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span >hash</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Transaction hash</div></li>
					
					<li><div class="ioobjectWrap"><span >input</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Transaction data, used for smart contracts</div></li>
					
					<li><div class="ioobjectWrap"><span >nonce</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Wallet nonce for the transaction</div></li>
					
					<li><div class="ioobjectWrap"><span >to</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Wallet address of receiver</div></li>
					
					<li><div class="ioobjectWrap"><span >transactionIndex</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Index of transaction in block. null if the transaction is pending.</div></li>
					
					<li><div class="ioobjectWrap"><span >value</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Amount transfered in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span >shardID</span> - <span >Number</span> :</div> 
					<div class="iodefWrap">Shard where amount is from</div></li>
					
					<li><div class="ioobjectWrap"><span >toShardID</span> - <span >Number</span> :</div> 
					<div class="iodefWrap">Shard where the amount is sent</div></li>
					
				</ul>

				<h4>If <span >fullTx</span> is <span >false</span></h4>

				<h4 class="infoHeader"><span >Array</span> of <span >String</span>: List of transaction hashes</h4>
			</div>
		</div>
	</div>
	<div class="form_container">
		<div id="formcontent">
		<form method="get">
			<div class="row">
				<div class="col-25">
					<label for="oneaddr">To: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="oneaddr" name="oneaddr" maxlength="42" value="<?php if(isset($oneaddr)){ echo $oneaddr; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="blocknum">Block Number: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="blocknum" name="blocknum" maxlength="200" value="<?php if(isset($blocknum)){ echo $blocknum; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="fromaddr">To: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="fromaddr" name="fromaddr" maxlength="42" value="<?php if(isset($fromaddr)){ echo $fromaddr; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="gas">Gas: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="gas" name="gas" maxlength="10" value="<?php if(isset($gas)){ echo $gas; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="gasprice">Gas Price: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="gasprice" name="gasprice" maxlength="10" value="<?php if(isset($gasprice)){ echo $gasprice; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="value">Value: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="value" name="value" maxlength="10" value="<?php if(isset($value)){ echo $value; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="data">Data: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="data" name="data" maxlength="10" value="<?php if(isset($data)){ echo $data; } ?>" />
				</div>
			</div>

			<div class="row">
				<input type="hidden" id="do" name="do" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_getTransactionsHistory" />
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
