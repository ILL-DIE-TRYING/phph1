<?php
if(isset($valid_blockhash) && $valid_blockhash == 1){
	/**
	* Start debug info display area
	*/
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
	}

	/*
	* We are already validated in advance
	*/
	$validinput = 1;
	
	$hmyv2_data = $phph1->hmyv2_getTransactionReceipt($blockhash);
	
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
					<div class="iodefWrap">Hash.</div></li>
				
				</ul>
				<ul class="infoObjects" >
					<h3 class="infoHeader">Returns</h3>
					<h4 class="infoHeader"><span >Object</span></h4>
					<ul class="infoObjects">
						<li><div class="ioobjectWrap"><span >blockHash</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Block hash that transaction was finalized. null if the transaction is pending.</div></li>
						
						<li><div class="ioobjectWrap"><span >blockNumber</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Block number that transaction was finalized. null if the transaction is pending.</div></li>
						
						<li><div class="ioobjectWrap"><span >contractAddress</span> - <span >String</span>:</div>
						<div class="iodefWrap">Smart contract address</div></li>
						
						<li><div class="ioobjectWrap"><span >cumulativeGasUsed</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Gas used for transaction</div></li>
						
						<li><div class="ioobjectWrap"><span >from</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Sender wallet address</div></li>
						
						<li><div class="ioobjectWrap"><span >gasUsed</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Gas used for the transaction</div></li>
						
						<li><div class="ioobjectWrap"><span >logs</span> - <span >Array</span></div></li>
						
						<li><div class="ioobjectWrap"><span >logsBloom</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Bloom logs</div></li>
						
						<li><div class="ioobjectWrap"><span >root</span> - <span >String</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span >shardID</span> - <span >Number</span> :</div> 
						<div class="iodefWrap">Shard ID</div></li>
						
						<li><div class="ioobjectWrap"><span >status</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Status of transaction (0: pending, 1: success)</div></li>
						
						<li><div class="ioobjectWrap"><span >to</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Receiver wallet address</div></li>
						
						<li><div class="ioobjectWrap"><span >transactionHash</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Transaction hash</div></li>
						
						<li><div class="ioobjectWrap"><span >transactionIndex</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Transaction index within block</div></li>

					</ul>
				</ul>
			</div>
		</div>
	</div>

	<div class="form_container">
		<div id="formcontent">
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
				<input type="hidden" id="method" name="method" value="hmyv2_getTransactionReceipt" />
				<input type='submit' name='Submit' />
			</div>

			</form>
		</div>
	</div>

<?php
/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>

