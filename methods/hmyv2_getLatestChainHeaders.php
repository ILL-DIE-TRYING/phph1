<?php
/**
* Start debug info display area
*/
if($phph1->phph1_debug == 1){
	echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
}

/**
* There is no input so no validation required
*/
$validinput = 1;

/**
* Get the transactions
*/
$hmyv2_data = $phph1->hmyv2_getLatestChainHeaders();

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
				<li class="infoObjectNoBul"><h4>No Parameters Required</h4></li>
			</ul>
			
			<h3 class="infoHeader">Returns</h3>
			<ul class="infoObjects">
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span>:</div></li>
				
				<li><div class="ioobjectWrap"><span>beacon-chain-header</span> - <span >Object</span>:</div></li>
				
				<ul class="infoObjects2">

					<li><div class="ioobjectWrap"><span>difficulty</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>epoch</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Epoch number</div></li>
					
					<li><div class="ioobjectWrap"><span>extraData</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>gasLimit</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>gasUsed</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>hash</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>logsBloom</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>miner</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>mixHash</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>nonce</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>number</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>parentHash</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>receiptsRoot</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>sha3Uncles</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>shardID</span> - <span >Number</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>stateRoot</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>timestamp</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>transactionsRoot</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>viewID</span> - <span >Number</span>:</div>
					<div class="iodefWrap">View ID</div></li>

				</ul>
				
				<li><div class="ioobjectWrap"><span>shard-chain-header</span> - <span >Object</span>:</div></li>
				
					<ul class="infoObjects2">
						
						<li><div class="ioobjectWrap"><span>difficulty</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>epoch</span> - <span >Number</span>:</div>
						<div class="iodefWrap">Epoch number</div></li>
						
						<li><div class="ioobjectWrap"><span>extraData</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>gasLimit</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>gasUsed</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>hash</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>logsBloom</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>miner</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>mixHash</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>nonce</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>number</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>parentHash</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>receiptsRoot</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>sha3Uncles</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>shardID</span> - <span >Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>stateRoot</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>timestamp</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>transactionsRoot</span> - <span >String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>viewID</span> - <span >Number</span>:</div>
						<div class="iodefWrap">View ID</div></li>
						
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
