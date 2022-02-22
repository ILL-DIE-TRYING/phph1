<?php
/**
* Start debug info display area
*/
if($phph1->phph1_debug == 1){
	echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
}

/**
* NO INPUT TO VALIDATE SET TO 1
*/
$validinput = 1;

// Get the transactions
$hmyv2_data = $phph1->hmyv2_getPendingCXReceipts();

/**
* End debug info display area
*/
if($phph1->phph1_debug == 1){
	echo "<p class='hmyv2_debug_notify'>### END DEBUGGING INFORMATION ###</p>";
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
					
					<li><div class="ioobjectWrap"><span >None</span></div></li>
					
				</ul>
				
				<h3>Returns</h3>

				<ul class="infoObjects">
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Array</span> of Object:</div></li>
					
					<li><div class="ioobjectWrap"><span>receipts</span> - <span >Array</span> of <span >Object</span>:</div>
					<div class="iodefWrap"></div></li>
					
					<ul class="infoObjects2">
					
						<li><div class="ioobjectWrap"><span>txHash</span> - <span >String</span> :</div>
						<div class="iodefWrap">Transaction hash</div></li>
						
						<li><div class="ioobjectWrap"><span>from</span> - <span >String</span> :</div>
						<div class="iodefWrap">Sender wallet address</div></li>
						
						<li><div class="ioobjectWrap"><span>to</span> - <span >String</span> :</div>
						<div class="iodefWrap">Receiver wallet address</div></li>
						
						<li><div class="ioobjectWrap"><span>shardID</span> - <span >Number</span>:</div>
						<div class="iodefWrap">From shard</div></li>
						
						<li><div class="ioobjectWrap"><span>toShardID</span> - <span >Number</span>:</div>
						<div class="iodefWrap">To shard</div></li>
						
						<li><div class="ioobjectWrap"><span>amount</span> - <span >Number</span>:</div>
						<div class="iodefWrap">Amount transferred in Atto</div></li>
						
					</ul>
					
					<li><div class="ioobjectWrap"><span>merkleProof</span> - <span >Object</span>:</div>
					<div class="iodefWrap"></div></li>
					
					<ul class="infoObjects2">
					
						<li><div class="ioobjectWrap"><span>blockNum</span> - <span >Number</span> :</div>
						<div class="iodefWrap">Block number</div></li>
						
						<li><div class="ioobjectWrap"><span>blockHash</span> - <span >String</span> :</div>
						<div class="iodefWrap">Block hash</div></li>
						
						<li><div class="ioobjectWrap"><span>shardID</span> - <span >Number</span> :</div>
						<div class="iodefWrap">Shard ID of originating block</div></li>
						
						<li><div class="ioobjectWrap"><span>receiptHash</span> - <span >String</span>:</div>
						<div class="iodefWrap">Transaction receipt hash</div></li>
						
						<li><div class="ioobjectWrap"><span>shardIDs</span> - <span >Array</span > of <span >Number</span>:</div>
						<div class="iodefWrap">To shard</div></li>
						
						<li><div class="ioobjectWrap"><span>shardHashes</span> - <span >Array</span > of <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
					</ul>
					
					<li><div class="ioobjectWrap"><span>header</span> - <span >Object</span>:</div>
					<div class="iodefWrap"></div></li>
					
					<ul class="infoObjects2">
					
						<li><div class="ioobjectWrap"><span>shard-id</span> - <span >Number</span> :</div>
						<div class="iodefWrap">Shard ID</div></li>
						
						<li><div class="ioobjectWrap"><span>block-header-hash</span> - <span >String</span> :</div>
						<div class="iodefWrap">Block header hash</div></li>
						
						<li><div class="ioobjectWrap"><span>blockNumber</span> - <span >Number</span> :</div>
						<div class="iodefWrap">Block number</div></li>
						
						<li><div class="ioobjectWrap"><span>view-id</span> - <span >Number</span>:</div>
						<div class="iodefWrap">View ID</div></li>
						
						<li><div class="ioobjectWrap"><span>epoch</span> - <span >Number</span>:</div>
						<div class="iodefWrap">Epoch number</div></li>
						
					</ul>

					<li><div class="ioobjectWrap"><span>commitSig</span> - <span >String</span> :</div>
					<div class="iodefWrap">Hex representation of aggregated signature</div></li>

					<li><div class="ioobjectWrap"><span>commigBitmap</span> - <span >String</span> :</div>
					<div class="iodefWrap">Hex representation of aggregated signature bitmap</div></li>
					
				</ul>

			</div>
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

