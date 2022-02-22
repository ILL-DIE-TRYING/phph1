<?php
if(isset($valid_blockhash) && $valid_blockhash == 1){
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
	}

	/**
	* NO INPUT TO VALIDATE SET TO 1
	*/
	$validinput = 1;

	$hmyv2_data = $phph1->hmyv2_getTransactionByHash($blockhash);
	
	/**
	* End debug info display area
	*/
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### END DEBUGGING INFORMATION ###</p>";
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

					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span> :</div>
					<div class="iodefWrap">Transaction hash</div></li>
				
				</ul>
				
				<h3>Returns</h3>
				<h4 class="infoHeader"><span >Array</span></h4>
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
			</div>
		</div>
	</div>

<form method="GET">
	
<div class="row">
	<div class="col-25">
		<label for="blockhash">Hash (NOT Block Hash): </label>
	</div><div class="col-75">
		<input style="background: orange;" type="text" id="blockhash" name="blockhash" maxlength="66" value="<?php if(isset($blockhash)){ echo $blockhash; } ?>" />
	</div>
</div>

<div class="row">
	<input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getTransactionByHash" />
	<input type='submit' name='Submit' />
</div>

</form>
<br />

<?php
/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>

