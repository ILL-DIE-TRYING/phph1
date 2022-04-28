<?php
/**
* Method file for hmyv2_latestHeader() in the phph1.php class file
*/

// There is no input so no validation required
$phph1->set_validinput(1);

// Get the block number dataset
$hmyv2_data = $phph1->hmyv2_latestHeader();

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
							<p>Gets the current blockchain header information.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_latestHeader">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
		
			<h3 class="infoHeader">Parameters</h3>
			<ul class="infoObjects" >
				<li class="infoObjectNoBul"><h4>No Parameters Required</h4></li>
			</ul>
			
			<h3 class="infoHeader">Returns</h3>
			<ul class="infoObjects">
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span></div></li>
				
				<li><div class="ioobjectWrap"><span>blockHash</span> - <span>String</span>:</div>
				<div class="iodefWrap">Block hash</div></li>
				
				<li><div class="ioobjectWrap"><span>blockNumber</span> - <span>Number</span>:</div>
				<div class="iodefWrap">Block number</div></li>
				
				<li><div class="ioobjectWrap"><span>crossLinks</span> - <span>Array</span>:</div></li>
				
				<ul class="infoObjects2">
					
					<li><div class="ioobjectWrap"><span>block-number</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Block number</div></li>
					
					<li><div class="ioobjectWrap"><span>epoch-number</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Epoch number</div></li>
					
					<li><div class="ioobjectWrap"><span>hash</span> - <span>String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>shard-id</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Shard ID</div></li>
					
					<li><div class="ioobjectWrap"><span>signature</span> - <span>String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>signature-bitmap</span> - <span>String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>view-id</span> - <span>Number</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
				</ul>
				
				<li><div class="ioobjectWrap"><span>epoch</span> - <span>Number</span>:</div>
				<div class="iodefWrap">Epoch of block</div></li>
				
				<li><div class="ioobjectWrap"><span>lastCommitBitmap</span> - <span>String</span>:</div>
				<div class="iodefWrap">Hex representatino of the aggregated signature bitmap of the previous block</div></li>
				
				<li><div class="ioobjectWrap"><span>lastCommitSig</span> - <span>String</span>:</div>
				<div class="iodefWrap">Hex representation of aggregated signatures of the previous block</div></li>
				
				<li><div class="ioobjectWrap"><span>leader</span> - <span>String</span>:</div>
				<div class="iodefWrap">Wallet address of leader that proposed this block if prestaking, otherwise sha256 hash of leader's public bls key</div></li>
				
				<li><div class="ioobjectWrap"><span>shardID</span> - <span>Number</span>:</div>
				<div class="iodefWrap">Shard ID</div></li>
				
				<li><div class="ioobjectWrap"><span>timestamp</span> - <span>String</span>:</div>
				<div class="iodefWrap">Timestamp that the block was finalized</div></li>
				
				<li><div class="ioobjectWrap"><span>unixtime</span> - <span>Number</span>:</div>
				<div class="iodefWrap">Timestamp that the block was finalized in Unix time</div></li>
				
				<li><div class="ioobjectWrap"><span>viewID</span> - <span>Number</span>:</div>
				<div class="iodefWrap">View ID of the block</div></li>
				
				<li><div class="ioobjectWrap"><span>vrf</span> - <span>String</span>:</div>
				<div class="iodefWrap">FIXME</div></li>
				
				<li><div class="ioobjectWrap"><span>vrfProof</span> - <span>String</span>:</div>
				<div class="iodefWrap">FIXME</div></li>

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

