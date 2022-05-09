<?php
/**
* Method file for hmyv2_getPendingCXReceipts() in the phph1.php class file
*/

// There is no input so no validation required
$phph1->set_validinput(1);

// Get the block number dataset
$hmyv2_data = $phph1->hmyv2_getPendingCXReceipts();

require_once('inc/errors.php');

/**
* Check if this is a RPC call
* If not show the html output of the method explorer
*/
if($phph1->get_rpcstatus() != 1){

?>

	<div class="info_container" >
		<div class="infoRow">
			<button type="button" class="collapsibleInfo"><?=$phph1->get_currentmethod()?> :: Params/Returns</button>
			<div id="infoContent" class="infoContent">
			
				<h3 class="infoHeader">Description</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul">
						<div>
							<p>Gets a list of pending cross chard transactions.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getPendingCXReceipts">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><h4>No Parameters Required</h4></div></li>
					
				</ul>
				
				<h3>Returns</h3>
				<ul class="infoObjects">
				
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Array</span> of <span>Object</span>:</div></li>
					
					<li><div class="ioobjectWrap"><span>commigBitmap</span> - <span>String</span>:</div>
					<div class="iodefWrap">Hex representation of aggregated signature bitmap</div></li>
					
					<li><div class="ioobjectWrap"><span>commitSig</span> - <span>String</span>:</div>
					<div class="iodefWrap">Hex representation of aggregated signature</div></li>
					
					<li><div class="ioobjectWrap"><span>header</span> - <span>Object</span>:</div>
					<div class="iodefWrap"></div></li>
					
					<ul class="infoObjects2">
						
						<li><div class="ioobjectWrap"><span>difficulty</span> - <span>String</span>:</div>
						<div class="iodefWrap">Hex diffculty value</div></li>
						
						<li><div class="ioobjectWrap"><span>epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Epoch number</div></li>
						
						<li><div class="ioobjectWrap"><span>extraData</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>gasLimit</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>gasUsed</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>hash</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>logsBloom</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>miner</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>mixHash</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>nonce</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>number</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>parentHash</span> - <span>String</span>:</div>
						<div class="iodefWrap">Parent hash</div></li>
						
						<li><div class="ioobjectWrap"><span>receiptsRoot</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>sha3Uncles</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>shardID</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Shard ID</div></li>
						
						<li><div class="ioobjectWrap"><span>stateRoot</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>timestamp</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>transactionsRoot</span> - <span>String</span>:</div>
						<div class="iodefWrap"></div></li>
						
						<li><div class="ioobjectWrap"><span>viewID</span> - <span>Number</span>:</div>
						<div class="iodefWrap"></div></li>
						
					</ul>
					
					<li><div class="ioobjectWrap"><span>merkleProof</span> - <span>Object</span>:</div>
					<div class="iodefWrap"></div></li>
					
					<ul class="infoObjects2">
					
						<li><div class="ioobjectWrap"><span>blockHash</span> - <span>String</span>:</div>
						<div class="iodefWrap">Block hash</div></li>
						
						<li><div class="ioobjectWrap"><span>blockNum</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Block number</div></li>
						
						<li><div class="ioobjectWrap"><span>receiptHash</span> - <span>String</span>:</div>
						<div class="iodefWrap">Transaction receipt hash</div></li>
						
						<li><div class="ioobjectWrap"><span>shardHashes</span> - <span>Array</span > of <span>String</span>:</div>
						<div class="iodefWrap">List of shard hashes</div></li>
						
						<li><div class="ioobjectWrap"><span>shardID</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Shard ID of originating block</div></li>

						<li><div class="ioobjectWrap"><span>shardIDs</span> - <span>Array</span > of <span>Number</span>:</div>
						<div class="iodefWrap">To shard</div></li>

					</ul>

					<li><div class="ioobjectWrap"><span>receipts</span> - <span>Array</span> of <span>Object</span>:</div>
					<div class="iodefWrap"></div></li>
					
					<ul class="infoObjects2">
						
						<li><div class="ioobjectWrap"><span>amount</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Amount transferred in Atto</div></li>
						
						<li><div class="ioobjectWrap"><span>from</span> - <span>String</span>:</div>
						<div class="iodefWrap">Sender wallet address</div></li>
						
						<li><div class="ioobjectWrap"><span>shardID</span> - <span>Number</span>:</div>
						<div class="iodefWrap">From shard</div></li>
						
						<li><div class="ioobjectWrap"><span>to</span> - <span>String</span>:</div>
						<div class="iodefWrap">Receiver wallet address</div></li>

						<li><div class="ioobjectWrap"><span>toShardID</span> - <span>Number</span>:</div>
						<div class="iodefWrap">To shard</div></li>
						
						<li><div class="ioobjectWrap"><span>txHash</span> - <span>String</span>:</div>
						<div class="iodefWrap">Transaction hash</div></li>

					</ul>
					
				</ul>
			</div>
		</div>
	</div>

<?php
/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>

