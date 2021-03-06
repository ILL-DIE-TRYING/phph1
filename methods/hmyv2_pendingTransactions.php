<?php
/**
* Method file for hmyv2_pendingTransactions() in the phph1.php class file
*/

// There is no input so no validation required
$phph1->set_validinput(1);

// Get the block number dataset
$hmyv2_data = $phph1->hmyv2_pendingTransactions();

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
						<p>Gets a list of transactions currently in the staking pool.</p>
						<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_pendingTransactions">PHPH1 Class Documentation</a>.</p>
					</div>
				</li>
			</ul>
		
			<h3 class="infoHeader">Parameters</h3>
			<ul class="infoObjects" >
				<li class="infoObjectNoBul"><h4>No Parameters Required</h4></li>
			</ul>
			
			<h3 class="infoHeader">Returns</h3>
			<ul class="infoObjects">
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Array</span> of <span >Object</span></div> 
				<div class="iodefWrap">List of regular & smart contract transactions in the transaction pool</div></li>
				
				<li><div class="ioobjectWrap"><span >blockHash</span> - <span >String</span>:</div> 
				<div class="iodefWrap">Block hash that transaction was finalized. null if the transaction is pending.</div></li>
				
				<li><div class="ioobjectWrap"><span >blockNumber</span> - <span >Number</span>:</div> 
				<div class="iodefWrap">Block number that transaction was finalized. null if the transaction is pending.</div></li>
				
				<li><div class="ioobjectWrap"><span >ethHash</span> - <span >String</span>:</div>
				<div class="iodefWrap">ETH hash</div></li>
				
				<li><div class="ioobjectWrap"><span >from</span> - <span >String</span>:</div>
				<div class="iodefWrap">Wallet address</div></li>
				
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
				
				<li><div class="ioobjectWrap"><span >r</span> - <span >String</span>:</div> 
				<div class="iodefWrap">FIXME</div></li>
				
				<li><div class="ioobjectWrap"><span >s</span> - <span >String</span>:</div> 
				<div class="iodefWrap">FIXME</div></li>
				
				<li><div class="ioobjectWrap"><span >shardID</span> - <span >Number</span> :</div> 
				<div class="iodefWrap">Shard where amount is from</div></li>
				
				<li><div class="ioobjectWrap"><span >timestamp</span> - <span >Number</span>:</div> 
				<div class="iodefWrap">Timestamp in Unix time when transaction was finalized</div></li>
				
				<li><div class="ioobjectWrap"><span >to</span> - <span >String</span>:</div> 
				<div class="iodefWrap">Wallet address of receiver</div></li>
				
				<li><div class="ioobjectWrap"><span >toShardID</span> - <span >Number</span> :</div> 
				<div class="iodefWrap">Shard where the amount is sent</div></li>
				
				<li><div class="ioobjectWrap"><span >transactionIndex</span> - <span >Number</span>:</div> 
				<div class="iodefWrap">Index of transaction in block. null if the transaction is pending.</div></li>
				
				<li><div class="ioobjectWrap"><span >v</span> - <span >String</span>:</div> 
				<div class="iodefWrap">FIXME</div></li>				
				
				<li><div class="ioobjectWrap"><span >value</span> - <span >Number</span>:</div> 
				<div class="iodefWrap">Amount transfered in Atto</div></li>

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

